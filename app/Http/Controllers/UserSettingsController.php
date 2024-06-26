<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $settings = auth()->user()->settings();

        return view('application.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $user->settings()->merge($request->only([
            'ticket_notifications',
            'snow',
        ]));

        $this->showSuccessToast('Your settings have been updated successfully');

        return redirect(route('user.settings.show'));
    }
}
