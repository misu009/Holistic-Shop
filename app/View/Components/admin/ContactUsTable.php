<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContactUsTable extends Component
{
    public $contacts;
    /**
     * Create a new component instance.
     */
    public function __construct($contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.contact-us-table');
    }
}