<?php

namespace App\Http\Livewire\Admin\System\Staff;

use App\Http\Livewire\Traits\Notifies;
use App\Models\Admin\Staff;
use App\Services\Admin\PermissionProviderService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;

class StaffCreateController extends StaffAbstract
{
    use Notifies;

    /**
     * Called when the component has been mounted.
     *
     * @return void
     */
    public function mount()
    {
        $this->staff = new Staff();
        $this->isAdmin = false;
        $this->staffPermissions = $this->staff->permissions->pluck('name');
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
            'staff.email' => 'required|email|unique:'.get_class($this->staff).',email',
            'staff.first_name' => 'string|max:255',
            'staff.last_name' => 'string|max:255',
            'password' => 'required|min:8|max:255|confirmed',
            'password_confirmation' => 'string',
        ];
    }

    public function render(PermissionProviderService $permissionService): View
    {
        return $this->view('admin.system.staff.staff-create-controller', function (View $view) use ($permissionService) {
            $view->with('permissions', $permissionService->getGroupedPermissions());
        });
    }

    public function create(): void
    {
        $this->validate();

        $this->staff->password = Hash::make($this->password);

        if ($this->isAdmin) {
            $this->staff->is_admin = true;
        }

        $this->staff->save();
        $this->syncPermissions();

        // $this->notify(__('staff.form.staff.created'), 'admin.system.staff.index');
        $this->redirect(route('admin.system.staff.index'), navigate: true);

    }
}
