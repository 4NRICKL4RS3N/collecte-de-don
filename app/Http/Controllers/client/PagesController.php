<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Impact;
use App\Models\Page;
use App\Models\Project;
use App\Models\Testimony;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function accueil() {
        $impacts = Impact::all();
        $temoignages = Testimony::all();
        $page = Page::find(3);
        $page_elements = $page->get_page_elements();
        return view('client.pages.accueil', ['impacts' => $impacts, 'temoignages' => $temoignages, 'page' => $page, 'page_elements' => $page_elements]);
    }

    public function projets() {
        $projets = Project::all();
        return view('client.pages.projets', ['projets' => $projets]);
    }

    public function projets_details($id) {
        $projet = Project::find($id);
        return view('client.pages.projet-detail', ['projet' => $projet]);
    }

    public function contact() {
        return view('client.pages.contact');
    }

    public function a_propos() {
        return view('client.pages.a-propos');
    }
}
