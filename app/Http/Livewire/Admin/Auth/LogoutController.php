<?php

namespace App\Http\Livewire\Admin\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LogoutController extends Component
{
    public bool $isSideBar;

    public function render(): View
    {
        return view('admin.auth.logout-controller');
    }

    /**
     * End admin session and logout
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        session()->regenerate();

        $this->redirect(route('admin.login'), navigate: true);

    }
}
