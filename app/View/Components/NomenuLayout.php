<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;

class NomenuLayout extends Component
{
    public $title;

    public function __construct($title = null)
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('layouts.nomenu');
    }
}
