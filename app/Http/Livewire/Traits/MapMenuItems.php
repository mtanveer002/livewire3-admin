<?php

namespace App\Http\Livewire\Traits;

trait MapMenuItems
{
    /**
     * Map collections so they're ready to be used.
     *
     * @param  \Illuminate\Support\Collection  $items
     * @return array<mixed>
     */
    public function mapMenuItems($items)
    {
        return $items->map(function ($item) {
            return [
                'id' => $item->id,
                'parent_id' => $item->parent_id,
                'name' => $item->name,
                'sort_order' => $item->sort_order,
                'url' => $item->url,
                'children' => [],
                'children_count' => $item->children_count,
            ];
        })->toArray();
    }
}
