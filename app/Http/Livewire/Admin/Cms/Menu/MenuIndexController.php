<?php

namespace App\Http\Livewire\Admin\Cms\Menu;

use Illuminate\Contracts\View\View;

class MenuIndexController extends MenuAbstract
{
    public function render(): View
    {
        return $this->view('admin.cms.menu.menu-index-controller');
    }
}
