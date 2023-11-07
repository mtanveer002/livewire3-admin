<?php

namespace App\Http\Livewire\Admin\Cms\Page;

use App\Http\Livewire\Admin\Cms\CmsAbstract;
use App\Http\Livewire\Traits\Notifies;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;

class PageIndexController extends CmsAbstract
{
    use Notifies;
    use WithPagination;
    use ResetsPagination;

    public string $search = '';

    public bool $showTrashed = false;

    public function getPagesProperty(): LengthAwarePaginator
    {
        return Page::query()
            ->when($this->search, fn ($q) => $q->search($this->search))
            ->when($this->showTrashed, fn ($q) => $q->withTrashed())
            ->paginate(10);
    }

    public function render(): View
    {
        return $this->view('admin.cms.page.page-index-controller');
    }
}
