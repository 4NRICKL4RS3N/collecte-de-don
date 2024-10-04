<?php

namespace App\View\Components\client;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public function render(): View
    {
        return view('client.layouts.partials.footer');
    }
}
