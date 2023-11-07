<?php

namespace App\View\Components\Admin\Components;

use Illuminate\View\Component;

class Gravatar extends Component
{
    /**
     * The image address for the gravatar.
     *
     * @var string
     */
    public $image;

    /**
     * Initialize the component.
     *
     * @param  string  $image
     */
    public function __construct($image)
    {
        $this->image = $image;
    }

    /**
     * Gets a hash of the image ready for display.
     *
     * @return string
     */
    protected function getimageHash()
    {
        return md5(strtolower(
            trim($this->image)
        ));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.gravatar', [
            'hash' => $this->getimageHash(),
        ]);
    }
}
