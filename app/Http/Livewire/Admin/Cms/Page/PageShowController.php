<?php

namespace App\Http\Livewire\Admin\Cms\Page;

use App\Http\Livewire\Traits\CanDeleteRecord;

class PageShowController extends PageAbstract
{
    use CanDeleteRecord;

    public function delete(): void
    {
        $this->page->delete();

        $this->redirect(route('admin.cms.pages.index'), navigate: true);

    }

    /**
     * return field to verify for delete
     */
    public function getCanDeleteConfirmationField(): string
    {
        return $this->page->slug;
    }
}
