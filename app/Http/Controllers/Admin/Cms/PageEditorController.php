<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Dotlogics\Grapesjs\App\Traits\EditorTrait;
use Illuminate\Http\Request;

class PageEditorController extends Controller
{
    use EditorTrait;

    public function editor(Request $request, Page $page): mixed
    {
        return $this->show_gjs_editor($request, $page);
    }
}
