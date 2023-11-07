<?php

namespace App\Http\Livewire\Admin\System\Staff;

use App\Http\Livewire\Traits\CanDeleteRecord;
use App\Http\Livewire\Traits\Notifies;
use App\Models\Admin\Staff;
use App\Services\Admin\PermissionProviderService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffShowController extends StaffAbstract
{
    use CanDeleteRecord;
    use Notifies;

    /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->staffPermissions = $this->staff->permissions->pluck('name');
        $this->isAdmin = $this->staff->isAdmin();
    }

    /**
     * render
     *
     * @return View
     */
    public function render(PermissionProviderService $permissionService)
    {
        return $this->view('admin.system.staff.staff-show-controller', function (View $view) use ($permissionService) {
            $view->with('permissions', $permissionService->getGroupedPermissions());
        });
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        return [
            'staffPermissions' => 'array',
            'staff.email' => 'required|email|unique:'.get_class($this->staff).',email,'.$this->staff->id,
            'staff.first_name' => 'required|string|max:255',
            'staff.last_name' => 'required|string|max:255',
            'password' => 'nullable|min:8|max:255|confirmed',
        ];
    }

    /**
     * update
     *
     * @return void
     */
    public function update()
    {
        $this->staff->is_admin = false;

        $this->validate();

        // If we only have one admin, we can't remove it.
        if (! $this->isAdmin && ! Staff::where('id', '!=', $this->staff->id)->whereIsAdmin(true)->exists()) {
            $this->notify(__('staff.form.staff.atleast.one'), level: 'warning');

            return;
        }

        if ($this->password) {
            $this->staff->password = Hash::make($this->password);
        }

        if ($this->isAdmin) {
            $this->staff->is_admin = true;
        }

        $this->staff->save();

        $this->syncPermissions();

        $this->redirect(route('admin.system.staff.index'), navigate: true);

    }

    /**
     * delete
     */
    public function delete(): void
    {
        $this->staff->delete();
        $this->redirect(route('admin.system.staff.index'), navigate: true);
    }

    /**
     * Computed property to determine if we're editing ourself.
     *
     * @return bool
     */
    public function getOwnAccountProperty()
    {
        return $this->staff->id == Auth::user()->id;
    }

    /**
     * return field to verify for delete
     */
    public function getCanDeleteConfirmationField(): string
    {
        return $this->staff->email;
    }
}
