<?php

namespace App\Http\Livewire\Admin\Auth;

use Throwable;
use Livewire\Component;
use App\Models\Admin\Staff;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Http\Livewire\Traits\Notifies;
use App\Mail\Admin\ResetPasswordEmail;
use App\View\Components\Admin\Layouts\GuestLayout;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PasswordResetController extends Component
{
    use AuthorizesRequests;
    use Notifies;

    /**
     * The staff members email address.
     *
     * @var string
     */
    public $email;

    /**
     * The new password.
     *
     * @var string
     */
    public $password;

    /**
     * The confirmed password.
     *
     * @var string
     */
    public $password_confirmation;

    /**
     * The reset token.
     *
     * @var string|null
     */
    public $token;

    /**
     * @var array<string>
     */
    protected $queryString = ['email', 'token'];

    public bool $invalid = false;

    /**
     * @var array<string,string>
     */
    protected $rules = [
        'email' => 'required|email',
        'password' => 'nullable|confirmed',
        'password_confirmation' => 'nullable',
    ];

    /**
     * {@inheritDoc}
     */
    public function mount(): void
    {
        if ($this->token && ! request()->hasValidSignature()) {
            $this->invalid = true;
        }
    }

    /**
     * Process the reset form.
     */
    public function process(): void
    {
        if (! $this->token) {
            $this->sendResetEmail();

            return;
        }

        $this->updatePasswordAndLogin();
    }

    /**
     * Send the reset email.
     *
     * @return void
     */
    public function sendResetEmail()
    {
        $this->validate();

        if ($staff = Staff::whereEmail($this->email)->first()) {
            Cache::forget('admin.password.reset.'.$staff->id);

            Cache::add(
                'admin.password.reset.'.$staff->id,
                $token = Str::random(),
                now()->addMinutes(30)
            );

            Mail::to($staff->email)->send(new ResetPasswordEmail(
                encrypt($staff->id.'|'.$token)
            ));

            $this->email = '';

            $this->notify(
                __('notifications.password-reset.email_sent')
            );
        }
    }

    /**
     * Update the password and log staff in.
     *
     * @return void
     */
    public function updatePasswordAndLogin()
    {
        $this->validate([
            'password' => 'min:8|required|confirmed',
            'password_confirmation' => 'required',
        ]);

        try {
            $token = decrypt($this->token);

            [$staffId, $token] = explode('|', $token);

            $staff = Staff::findOrFail($staffId);
        } catch (Throwable $e) {
            $this->notify(
                __('notifications.password-reset.invalid_token'),
                level: 'error'
            );

            return;
        }

        if (cache()->get('admin.password.reset.'.$staffId) != $token) {
            $this->notify(
                __('notifications.password-reset.invalid_token'),
                level: 'error'
            );

            return;
        }

        cache()->forget('password.reset.'.$staffId);

        $staff->password = Hash::make($this->password);
        $staff->save();

        Auth::guard('admin')->loginUsingId($staffId);

        $this->notify(
            __('notifications.password-reset.password_updated'),
            'admin.system.staff.index'
        );
    }

    public function render(): View
    {
        return view('admin.auth.password-reset-controller')
            ->layout(GuestLayout::class);
    }
}
