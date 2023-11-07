<?php

namespace App\View\Components\Admin\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public string $heading = '';

    /**
     * Create a new component instance.
     *
     * @param  string  $heading
     * @return void
     */
    public function __construct($heading)
    {
        $this->heading = $heading;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.card');
    }
}
