<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public string $labelName;
    public string $attributesParam;
    public string $name;
    public string $value;
    /**
     * Create a new component instance.
     */
    public function __construct(string $labelName, string $attributesParam, string $name = '', string $value = '')
    {
        $this->labelName = $labelName;
        $this->attributesParam = $attributesParam;
        $this->name = $name;
        $this->value = $value;
    }

    public function hasValue(): bool
    {
        return $this->value != '';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.input');
    }
}