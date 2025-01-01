<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public string $modalId;
    public string $title;
    public string $content;
    /**
     * Create a new component instance.
     */
    public function __construct($modalId, $title, $content)
    {
        $this->modalId = $modalId;
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.modal');
    }
}