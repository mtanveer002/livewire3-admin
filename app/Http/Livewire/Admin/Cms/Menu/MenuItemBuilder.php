<?php

namespace App\Http\Livewire\Admin\Cms\Menu;

use App\Http\Livewire\Traits\Notifies;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

class MenuItemBuilder extends MenuAbstract
{
    use Notifies;

    public MenuItem $menuItem;

    public Menu $menu;

    /**
     * mount
     *
     * @return void
     */
    public function mount(Menu $menu, int $order = 0, int $parentId = null)
    {
        $this->menuItem = new MenuItem();
        $this->menuItem->parent_id = $parentId;
        $this->menuItem->order = $order;
    }

    public function render(): View
    {
        return $this->view('admin.cms.menu.menu-item-builder');
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        return [
            'menuItem.title' => [
                'required',
                'max:191',
                Rule::unique('menu_items', 'title')
                    ->when($this->menuItem->id, fn ($query) => $query->ignore($this->menuItem->id))
                    ->when($this->menuItem->menu_id, fn ($query) => $query->where('menu_id', $this->menuItem->menu_id)),
            ],
            'menuItem.link' => [
                'required',
                'max:191',
            ],
            'menuItem.target' => 'max:191',
        ];
    }

    /**
     * save
     *
     * @return void
     */
    public function save()
    {
        $this->validate();

        $this->menuItem->menu_id = $this->menu->id;
        $this->menuItem->save();

        $type = $this->menuItem->wasRecentlyCreated ? 'created' : 'updated';

        $this->notify(__("menu.item.form.item.$type"));
        $this->dispatch('items-updated');

        $this->menuItem = new MenuItem();
    }

    #[On('edit-item')]
    public function editItem(MenuItem $menuItem): void
    {
        $this->menuItem = $menuItem;
    }
}
