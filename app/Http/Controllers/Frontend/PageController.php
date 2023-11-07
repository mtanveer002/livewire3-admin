<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Page  $page
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(Page $page = null)
    {
        if (! $page) {
            $page = Page::findOrFail(Page::HOME_PAGE_ID);
        }

        abort_if(! $page->isActive(), 404);

        return view('frontend.pages.index', compact('page'));
    }
}
