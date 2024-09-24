<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Head extends Component
{
    public $titre;

    public function __construct($titre) {
        $this->titre = $titre;
    }

    public function render(): View
    {
        return view('components.head');
    }
}
