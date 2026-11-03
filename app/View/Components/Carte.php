<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Carte extends Component
{
    public $titre;

    public function __construct($titre)
    {
        $this->titre = $titre;
    }

    public function render(): View|Closure|string
    {
        return view('components.carte');
    }
}