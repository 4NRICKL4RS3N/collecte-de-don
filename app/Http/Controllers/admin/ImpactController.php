<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Impact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImpactController extends Controller
{
    public function index() {
        $impacts = Impact::all();
        return view('admin.pages.impacts', ['impacts' => $impacts]);
    }

    public function store(Request $request) {
        try {
            $validatedData = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
            ]);
            Impact::create($validatedData);
            return response()->json(['success' => true, 'data' => $validatedData]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

    }

    public function update(Request $request, $id) {
        try {
            $impact = Impact::find($id);
            if (!$impact) {
                return response()->json(['success' => false, 'error' => 'impact introuvable']);
            }

            $validatedData = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
            ]);
            \Log::info("updaaate", [$validatedData]);
            $impact->update($validatedData);
            return response()->json(['success' => true, 'data' => $validatedData]);
        } catch (\Exception $e) {
            \Log::error("erreur update", [$e]);
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

    }

    public function destroy($id) {
        $impact = Impact::find($id);
        if ($impact) {
            $impact->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => 'projet introuvable']);
        }

    }
}
