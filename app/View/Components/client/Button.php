<?php

namespace App\View\Components\Client;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $content;
    public $lien;
    public $backgroundColor;
    public $addClass;
    public $addAttribut;

    public function __construct($content='bouton', $lien='#', $addClass='', $addAttribut='') {
        $this->content = $content;
        $this->lien = $lien;
        $this->addClass = $addClass;
        $this->addAttribut = $addAttribut;
    }

    public function render(): View
    {
        return view('client.components.button');
    }
}
