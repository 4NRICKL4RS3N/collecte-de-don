<?php

namespace App\View\Components\client;

use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public $page_elements;

    public function __construct()
    {
        $this->page_elements = Page::find(2)->get_page_elements();
    }
    public function render(): View
    {
        return view('client.layouts.partials.footer');
    }
}
