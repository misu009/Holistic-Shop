<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImageUploader extends Component
{
    public string $path;
    public string $imagePreviewId;
    public string $imageInputId;
    public string $imageInputName;
    public string $buttonText;

    /**
     * Create a new component instance.
     */
    public function __construct($path, $imagePreviewId, $imageInputId, $imageInputName, $buttonText)
    {
        $this->imagePreviewId = $imagePreviewId;
        $this->imageInputId = $imageInputId;
        $this->imageInputName = $imageInputName;
        $this->buttonText = $buttonText;;
        $this->path = $path;
    }

    /*
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.image-uploader');
    }
}
