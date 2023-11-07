<?php

namespace App\View\Components\Admin\Components;

use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Specify the HTML tag the component should render.
     *
     * @var string
     */
    public $tag = 'button';

    /**
     * The button theme.
     *
     * @var string
     */
    public $theme = 'default';

    /**
     * Button size
     *
     * @var string
     */
    public $size = 'default';

    /**
     * Initialize the component.
     */
    public function __construct(string $tag = 'button', string $theme = 'default', string $size = 'default')
    {
        $this->tag = $tag;
        $this->theme = $theme;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.button');
    }
}
