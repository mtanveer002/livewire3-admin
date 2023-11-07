<?php

namespace App\Http\Livewire\Admin\Cms\Page;

use App\Http\Livewire\Admin\Cms\CmsAbstract;
use App\Http\Livewire\Traits\Notifies;
use App\Models\Page;
use Illuminate\Contracts\View\View;

abstract class PageAbstract extends CmsAbstract
{
    use Notifies;

    /**
     * The page model
     */
    public Page $page;
    public string $page1 = 'testing';

    /**
     * Validation rules for pages
     *
     * @return array<mixed>
     */
    protected function rules(): array
    {
        return [
            'page.title' => 'bail|required',
            'page.slug' => 'bail|nullable|unique:pages,slug,'.$this->page->id,
            'page.meta_title' => 'bail|nullable',
            'page.meta_keywords' => 'bail|nullable',
            'page.meta_description' => 'bail|nullable',
            'page.raw_meta' => 'bail|nullable',
            'page.is_published' => 'bail|required|boolean',
        ];
    }

    /**
     * Save the page in database
     */
    public function save()
    {
        $this->validate();

        $this->page->save();

        $type = $this->page->wasRecentlyCreated ? 'created' : 'updated';

        // $this->notify("Page {$type} successfully.");
    
        $this->redirect(route('admin.cms.pages.index'), navigate: true);
    }

    public function render(): View
    {
        $title = $this->page->id ? 'edit' : 'create';

        return $this->view('admin.cms.page.page-form')
            ->with('pageTitle', "pages.{$title}.title");
    }
}
