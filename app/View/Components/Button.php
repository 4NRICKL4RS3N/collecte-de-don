<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $content;
    public $lien;
    public $backgroundColor;
    public $addClass;

    public function __construct($content, $lien, $backgroundColor, $addClass='') {
        $this->content = $content;
        $this->lien = $lien;
        $this->addClass = $addClass;
        if ($backgroundColor == 'blanc' || $backgroundColor == 'white') {
            $this->backgroundColor = 'btn-light';
        }
        if ($backgroundColor == 'primary' || $backgroundColor == 'primaire') {
            $this->backgroundColor = 'btn-primary';
        }
    }

    public function render(): View
    {
        return view('components.button');
    }
}
