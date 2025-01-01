<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MediaContent extends Component
{
    public $media;
    public $objectId;
    public $route;
    public $objectName;
    /**
     * Create a new component instance.
     */
    public function __construct($media, $objectId, $route, $objectName)
    {
        $this->media = $media;
        $this->objectId = $objectId;
        $this->route = $route;
        $this->objectName = $objectName;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.media-content');
    }
}