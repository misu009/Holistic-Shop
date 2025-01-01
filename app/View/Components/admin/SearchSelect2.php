<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchSelect2 extends Component
{
    public $route;
    public $searchFilter;
    public $searchItems;
    public $searchOption;
    public $searchRecord;
    public $ajaxRoute;
    /**
     * Create a new component instance.
     */
    public function __construct($route, $searchFilter, $searchItems, $searchOption, $searchRecord, $ajaxRoute)
    {
        $this->route = $route;
        $this->searchFilter = $searchFilter;
        $this->searchItems = $searchItems;
        $this->searchOption = $searchOption;
        $this->searchRecord = $searchRecord;
        $this->ajaxRoute = $ajaxRoute;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.search-select2');
    }
}