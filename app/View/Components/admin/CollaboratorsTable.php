<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CollaboratorsTable extends Component
{
    public $collaborators;
    /**
     * Create a new component instance.
     */
    public function __construct($collaborators)
    {
        $this->collaborators = $collaborators;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.collaborators-table');
    }
}
