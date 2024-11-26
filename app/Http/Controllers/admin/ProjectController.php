<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Project_image;
use App\Models\Project_objective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('admin.pages.projets', ['projets' => $projects]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
                'location' => 'nullable',
                'status' => 'required',
                'objectifs' => 'nullable',
                'donation_target' => 'nullable',
                'date_start' => 'nullable',
                'date_end' => 'nullable',
            ]);

            \Log::info("data", $validatedData);

            $project = Project::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'location' => $validatedData['location'],
                'status' => $validatedData['status'],
                'donation_target' => $validatedData['donation_target'],
                'donation_collected' => 0,
                'date_start' => $validatedData['date_start'],
                'date_end' => $validatedData['date_end'],
            ]);

            $objectives = json_decode($validatedData['objectifs'], true);
            foreach ($objectives as $objectiveText) {
                \Log::info("object", ['text' => $objectiveText]);
                Project_objective::create([
                    'project_id' => $project->id,
                    'objective' => $objectiveText,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e]);
        }
        return response()->json(['message' => 'Form data and objectifs saved successfully!']);
    }

    public function show(Project $id)
    {
        $project = $id;
        return view('admin.pages.projet-details', ['projet' => $project]);
    }

    public function update(Request $request, $id)
    {
        try {
            $project = Project::find($id);
            if (!$project) {
                return response()->json(['success' => false, 'message' => 'Erreur : projet introuvable']);
            }

            $validatedData = $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
                'location' => 'nullable',
                'status' => 'required',
                'objectifs' => 'nullable',
                'donation_target' => 'nullable',
                'date_start' => 'nullable',
                'date_end' => 'nullable',
            ]);

            $project->update([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'location' => $validatedData['location'],
                'status' => $validatedData['status'],
                'donation_target' => $validatedData['donation_target'],
                'date_start' => $validatedData['date_start'],
                'date_end' => $validatedData['date_end'],
            ]);

            $objectives = json_decode($validatedData['objectifs'], true);
            $actualObjectives = $project->project_objectives;
            $actualObjectives = $actualObjectives->pluck('objective')->toArray();
            $objectivesToDelete = array_diff($actualObjectives, $objectives);
            $objectivesToAdd = array_diff($objectives, $actualObjectives);
            foreach ($objectivesToDelete as $objectiveText) {
                $project->project_objectives()->where('objective', $objectiveText)->delete();
            }
            foreach ($objectivesToAdd as $objectiveText) {
                Project_objective::create([
                    'project_id' => $project->id,
                    'objective' => $objectiveText,
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error("VALIDATION ERROR", [$e]);
            \Log::info("REQUEST", [$request]);
            return response()->json(['success' => false, 'message' => $e->errors()]);
        }
        return response()->json(['success' => true, 'message' => 'Projet modifié']);
    }

    public function destroy($id)
    {
        $project = Project::find($id);
        if ($project) {
            $project->deleteObjectives();
            $project->deleteImages();
            $project->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Erreur : projet introuvable']);
        }
    }

    public function processMedia(Request $request, Project $id)
    {
        $project = $id;
        $files = json_decode($request->input('files'), true);
        $processedFiles = [];

        foreach ($files as $tempPath) {
            if (Storage::exists($tempPath)) {
                $filename = basename($tempPath);
                $newPath = 'public/project-uploads/' . $filename;
                Storage::move($tempPath, $newPath);

                $mimeType = Storage::mimeType($newPath);
                $type = str_contains($mimeType, 'image') ? 'image' : 'video';
                $media = Project_image::create([
                    'project_id' => $project->id,
                    'url' => Storage::url($newPath),
                    'type' => $type,
                    'filename' => $filename,
                    'mime_type' => $mimeType
                ]);

                $processedFiles[] = $media;
            }
        }

        return response()->json(['files' => $processedFiles]);
    }

    public function destroyMedia(Project_image $id)
    {
        $media = $id;
        $path = str_replace('/storage', 'public', $media->url);
        if (Storage::exists($path)) {
            \Log::info("file deleted", [$path]);
            Storage::delete($path);
        }
        $media->delete();
        return response()->json(['success' => true]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $filter = $request->input('filter');

        $projectsQuery = Project::query()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%");

        // Appliquer le filtre
        switch ($filter) {
            case 'fonds_leves':
                $projectsQuery->orderBy('donation_collected', 'desc');
                break;
            case 'les_plus_proches_du_but':
                // For this filter, you need to calculate the progress dynamically.
                // Instead of getting the projects early, we will handle progress calculation after fetching the results.
                break;
            case 'les_plus_recents':
                $projectsQuery->orderBy('created_at', 'desc');
                break;
            default:
            case 'pertinence':
                $projectsQuery->orderByRaw('
                CASE
                    WHEN date_start IS NOT NULL AND date_end IS NOT NULL AND NOW() BETWEEN date_start AND date_end THEN 1
                    ELSE 2
                END ASC
            ')
                    ->orderBy('id', 'asc');
                break;
        }

        // Fetch the projects after applying filters
        $projects = $projectsQuery->get();

        // Apply progress calculation
        $projects = $projects->map(function ($project) {
            $project->progress = $project->getProgress();
            $project->objectives = $project->project_objectives->pluck('objective');
            return $project;
        });


        return response()->json($projects);
    }


}
