<?php

namespace App\Http\Livewire\Admin\System\Staff;

use App\Http\Livewire\Admin\System\SystemAbstract;
use App\Http\Livewire\Traits\Notifies;
use App\Models\Admin\Staff;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;
use Throwable;

class StaffIndexController extends SystemAbstract
{
    use Notifies;
    use WithPagination;

    public string $search = '';

    public string $showTrashed = '';

    /**
     * render
     */
    public function render(): View
    {
        return $this->view('admin.system.staff.staff-index-controller', function (View $view) {
            $view->with('staff', $this->getStaff());
        });
    }

    public function getStaff(): Paginator
    {
        $query = Staff::query();

        if ($this->search) {
            $query->search($this->search);
        }

        if ($this->showTrashed) {
            $query = $query->withTrashed();
        }

        return $query->paginate(10);
    }

    /**
     * Force delete staff
     *
     * @param  int|null  $id
     */
    public function forceDelete($id): void
    {
        try {
            Staff::onlyTrashed()->find($id)->forceDelete();

            $this->notify(__('staff.form.staff.deleted_permanently'), 'admin.system.staff.index');
        } catch (Throwable $th) {
            $this->notify($th->getMessage(), level: 'error');
        }
    }

    /**
     * Restore staff member
     *
     * @param  int|null  $id
     */
    public function restore($id): void
    {
        try {
            Staff::withTrashed()->find($id)->restore();

            $this->notify(__('staff.form.staff.restore'), 'admin.system.staff.index');
        } catch (\Throwable $th) {
            $this->notify($th->getMessage(), level: 'error');
        }
    }
}
