<?php

namespace App\Http\Livewire\Admin\Cms\Menu;

use App\Http\Livewire\Traits\Authenticated;
use App\View\Components\Admin\Layouts\SubMasterLayout;
use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MenuAbstract extends Component
{
    use Authenticated;

    /**
     * View to show menus
     *
     * @param  view-string  $view
     * @param  Closure  $closure
     * @return View
     */
    public function view($view, $closure = null)
    {
        return tap(view($view), $closure)
            ->with('pageTitle', 'Menu Editor')
            ->layout(SubMasterLayout::class, [
                'menuName' => 'cms',
            ]);
    }
}
