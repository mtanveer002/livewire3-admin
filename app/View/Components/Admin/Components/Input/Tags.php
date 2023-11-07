<?php

namespace App\View\Components\Admin\Components\Input;

use Illuminate\View\Component;

class Tags extends Component
{
    /**
     * Whether or not the input has an error to show.
     */
    public bool $error = false;

    /**
     * @var array<mixed>
     */
    public array $tags = [];

    /**
     * Initialize the component.
     *
     * @param  bool  $error
     * @param  array<mixed>  $tags
     * @return void
     */
    public function __construct($error = false, $tags = [])
    {
        $this->error = $error;
        $this->tags = $tags;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.input.tags');
    }
}
