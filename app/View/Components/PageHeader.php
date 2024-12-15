<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public $title;
    public $buttonText;
    public $buttonAvailable;
    public function __construct($title, $buttonText = 'New Item', $buttonAvailable = true)
    {
        $this->title = $title;
        $this->buttonText = $buttonText;
        $this->buttonAvailable = $buttonAvailable;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.page-header');
    }
}
