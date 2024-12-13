<?php

namespace App\View\Components\client;

use App\Models\Page;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    public $page_elements;

    public function __construct()
    {
        $this->page_elements = Page::find(1)->get_page_elements();
    }

    public function render()
    {
        return view('client.layouts.partials.header');
    }
}
