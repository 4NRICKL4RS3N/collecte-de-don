<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Testimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonyController extends Controller
{
    public function index()
    {
        $testimonies = Testimony::all();
        return view('admin.pages.temoignages', ['testimonies' => $testimonies]);
    }

    public function store(Request $request) {
        try {
            $validatedData = $request->validate([
                'testifier_name' => 'required|max:255',
                'statement' => 'required',
            ]);
            $file = $request->input('image');
            \Log::info('files', [$request->input('image')]);
            if (Storage::exists($file)) {
                $filename = basename($file);
                $newPath = 'public/testimony-uploads/' . $filename;
                Storage::move($file, $newPath);
                $validatedData['image_url'] = Storage::url($newPath);
            }
            Testimony::create($validatedData);
            return response()->json(['success' => true, 'data' => $validatedData]);
        } catch (\Exception $e) {
            \Log::error("tsy voa upload", [$e]);
            return response()->json(['success' => false, 'error' => $e]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $testimony = Testimony::find($id);
            if (!$testimony) {
                return response()->json(['success' => false, 'error' => 'projet introuvable']);
            }

            $validatedData = $request->validate([
                'testifier_name' => 'required|max:255',
                'statement' => 'required',
            ]);
            $file = $request->input('image');
            if ($request->input('image')) {
                if (Storage::exists($file)) {
                    if ($testimony->image_url) {
                        Storage::delete($testimony->image_url);
                    }
                    $filename = basename($file);
                    $newPath = 'public/testimony-uploads/' . $filename;
                    Storage::move($file, $newPath);
                    $validatedData['image_url'] = Storage::url($newPath);
                }
            }
            \Log::info("updaaate", [$validatedData]);
            $testimony->update($validatedData);
            return response()->json(['success' => true, 'data' => $validatedData]);
        } catch (\Exception $e) {
            \Log::error("erreur update", [$e]);
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

    }
}
