<?php

namespace App\Http\Livewire\Admin\Profile;

use App\Http\Livewire\Admin\System\Staff\StaffAbstract;
use App\Http\Livewire\Traits\Notifies;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class StaffProfileController extends StaffAbstract
{
    use Notifies;
    use WithFileUploads;

    public string $currentPassword = '';

    public TemporaryUploadedFile|string|null $profileImage = null;

    public function mount(): void
    {
        $this->staff = auth_staff();

        $this->profileImage = $this->staff->profileImageUrl;
    }

    public function getMediaModel(): Model
    {
        return $this->staff;
    }

    /**
     * Define the validation rules.
     *
     * @return array<string, mixed>
     */
    protected function rules()
    {
        return [
            'staff.email' => 'required|email|max:50|unique:'.get_class($this->staff).',email,'.$this->staff->id,
            'staff.first_name' => 'required|max:30',
            'staff.last_name' => 'required|max:30',
            'profileImage' => 'nullable',
            'password' => 'nullable|min:8|max:255',
            'currentPassword' => ['nullable', 'required_with:password',
                function ($attribute, $value, $fail) {
                    if ($this->password && ! Hash::check($value, $this->staff->password)) {
                        return $fail(trans('validation.current_password'));
                    }
                },
            ],
        ];
    }

    public function render(): View
    {
        return $this->view('admin.profile.staff-profile-controller', function ($view) {
            $view->layoutData([
                'title' => trans('staff.profile.title'),
            ]);
        });
    }

    public function getProfileImagePreviewProperty(): string|null
    {
        if (! $this->profileImage) {
            return null;
        }

        return $this->profileImage instanceof TemporaryUploadedFile ? $this->profileImage->temporaryUrl() : $this->profileImage;
    }

    public function update(): void
    {
        $this->validate();

        abort_if($this->staff->id != Auth::id(), 404);

        if ($this->password) {
            $this->staff->password = Hash::make($this->password);
        }

        if ($this->profileImage instanceof TemporaryUploadedFile) {
            $this->staff->clearMediaCollection('avatar');
            $this->staff->addMedia($this->profileImage->getRealPath())
                ->usingName($this->profileImage->getClientOriginalName())
                ->toMediaCollection('avatar');

            $this->profileImage = $this->staff->profileImageUrl;
        }

        $this->staff->save();

        $this->notify(trans('notifications.profile.updated'));
    }
}
