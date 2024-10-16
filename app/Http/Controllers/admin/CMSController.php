<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CMSController extends Controller
{
    public function accueil(Request $request)
    {
        return view('admin.pages.cms_accueil');
    }
}
