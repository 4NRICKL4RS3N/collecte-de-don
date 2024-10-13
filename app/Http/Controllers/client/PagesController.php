<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Impact;
use App\Models\Project;
use App\Models\Testimony;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function accueil() {
        $impacts = Impact::all();
        $temoignages = Testimony::all();
        return view('client.pages.accueil', ['impacts' => $impacts, 'temoignages' => $temoignages]);
    }

    public function projets() {
        $projets = Project::all();
        return view('client.pages.projets', ['projets' => $projets]);
    }

    public function projets_details($id) {
        $projet = Project::find($id);
        return view('client.pages.projet-detail', ['projet' => $projet]);
    }
}
