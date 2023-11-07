<?php

namespace App\Http\Livewire\Admin\Cms\Menu;

use App\Http\Livewire\Traits\Notifies;
use App\Models\Menu;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MenuTable extends Component
{
    use Notifies;

    public string $search = '';

    /**
     * @var array<mixed>
     */
    protected $listeners = [
        'records-updated' => 'render',
        'delete',
    ];

    public function render(): View
    {
        return view('admin.cms.menu.menu-table', [
            'menus' => $this->getMenuList(),
        ]);
    }

    private function getMenuList(): Paginator
    {
        $query = Menu::query();

        if ($this->search) {
            $query->where('name', 'LIKE', "%{$this->search}%");
        }

        return $query->paginate(50);
    }

    public function delete(Menu $menu): void
    {
        $menu->items()->delete();
        $menu->delete();

        $this->notify(__('item.form.menu.deleted'));
        $this->dispatch('records-updated');
    }
}
