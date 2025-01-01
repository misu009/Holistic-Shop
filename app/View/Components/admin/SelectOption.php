<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectOption extends Component
{
    public string $value;

    public string $selectOption;

    public string $attributesParam;

    /**
     * Create a new component instance.
     */
    public function __construct(string $value, string $selectOption, string $attributesParam)
    {
        $this->value = $value;
        $this->selectOption = $selectOption;
        $this->attributesParam = $attributesParam;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.select-option');
    }
}
