<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
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
            $project->project_objectives->delete();
            $project->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Erreur : projet introuvable']);
        }
    }

    public function processMedia(Request $request, Project $id)
    {
        $files = json_decode($request->input('files'), true);
        $processedFiles = [];

        foreach ($files as $tempPath) {
            if (Storage::exists($tempPath)) {
                $newPath = 'public/uploads/' . basename($tempPath);
                Storage::move($tempPath, $newPath);
                $processedFiles[] = Storage::url($newPath);
            }
        }

        return response()->json(['files' => $processedFiles]);
    }

}
