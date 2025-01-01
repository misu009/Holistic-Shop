<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductCategoryTable extends Component
{
    public $categories;
    /**
     * Create a new component instance.
     */
    public function __construct($categories)
    {
        $this->categories = $categories;
    }
    public function render(): View|Closure|string
    {
        return view('components.admin.product-category-table');
    }
}
