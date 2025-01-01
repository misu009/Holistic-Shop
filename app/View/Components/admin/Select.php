<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public string $labelName;

    public string $optionDefault;

    public string $attributesParam;

    public string $name;

    /**
     * Create a new component instance.
     */
    public function __construct(string $labelName, string $optionDefault, string $attributesParam, string $name)
    {
        $this->labelName = $labelName;
        $this->optionDefault = $optionDefault;
        $this->attributesParam = $attributesParam;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.select');
    }
}
