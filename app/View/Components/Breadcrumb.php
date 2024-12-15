<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * Create a new component instance.
     */
    public $homeLink;
    public $homeTitle;
    public $currentLink;
    public $currentTitle;
    public function __construct($homeLink = '#', $homeTitle = 'Home', $currentLink = '#', $currentTitle = 'List')
    {
        $this->homeLink = $homeLink;
        $this->homeTitle = $homeTitle;
        $this->currentLink = $currentLink;
        $this->currentTitle = $currentTitle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.breadcrumb');
    }
}
