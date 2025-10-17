<?php

namespace App\View\Components\client;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class orderModal extends Component
{
    public $countries;
    /**
     * Create a new component instance.
     */
    public function __construct($countries)
    {
        $this->countries = $countries;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.order-modal');
    }
}
