<?php

namespace App\Http\Livewire\Admin\Cms\Menu;

use App\Http\Livewire\Traits\Notifies;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;

class MenuBuilder extends MenuAbstract
{
    use Notifies;

    public Menu $menu;

    /**
     * @var array<mixed>
     */
    protected $listeners = [
        'items-updated' => 'render'
    ];

    /**
     * mount
     *
     * @return void
     */
    public function mount(Menu $menu)
    {
        $this->menu = $menu;
    }

    public function render(): View
    {
        return $this->view('admin.cms.menu.menu-builder', function (View $view) {
            $view->with('items', $this->getItems());
        });
    }

    /**
     * updateSorting
     *
     * @param  array<mixed>  $data
     * @return void
     */
    #[On('updateSorting')]
    public function updateSorting($data)
    {
        $reorderedItems = $this->flattenArray($data);

        foreach ($reorderedItems as $item) {
            MenuItem::where('id', $item['id'])->update([
                'order' => $item['order'],
                'parent_id' => $item['parent_id'],
            ]);
        }

        $this->notify(__('menu.item.form.list.updated'));
    }

    public function getItems(): Collection
    {
        return $this->menu->items()->orderBy('order')->doesntHave('parent')->get();
    }

    /**
     * flattenArray
     *
     * @param  array<mixed>  $data
     * @param  int  $parent
     * @param  int  $order
     * @return array<mixed>
     */
    private function flattenArray($data, $parent = null, $order = 0)
    {
        $items = [];
        foreach ($data as $item) {
            array_push($items, $this->buildItem($item, $order, $parent));
            if (isset($item['children']) && ! empty($item['children'])) {
                $items = array_merge($items, $this->flattenArray($item['children'], $item['id']));
            }
            $order++;
        }

        return $items;
    }

    /**
     * buildItem
     *
     * @param  mixed  $item
     * @param  int  $order
     * @param  int  $parent
     * @return array<string, mixed>
     */
    private function buildItem($item, $order, $parent = null)
    {
        return [
            'id' => $item['id'],
            'order' => $order,
            'parent_id' => $parent == $item['id'] ? null : $parent,
        ];
    }

    /**
     * deleteItem
     *
     * @return void
     */
    #[On('delete-item')]
    public function deleteItem(MenuItem $menuItem)
    {
        $menuItem->delete();
        $this->notify(__('menu.item.form.item.deleted'));
    }
}
