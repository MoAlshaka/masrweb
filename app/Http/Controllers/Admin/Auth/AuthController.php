<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function get_admin_login()
    {
        return view('admin.auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|max:50',
            'password' => 'required|max:50',
        ]);

        if (auth()->guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->back()->with([
                'error' => 'the username or password is not correct'
            ]);
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('get.admin.login');
    }


    public function mail_reset_password(Request $request)
    {

        $request->validate([
            'email' => 'required|email|max:50',
        ]);

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return redirect()->back()->with(['Delete' => 'You don\'t have an email , please contact with admin ']);
        }

        Mail::to($request->email)->send(new ResetPasswordMail($request->email));
        return redirect()->back()->with(['Add' => 'Password reset link sent to your email, check your email']);
    }
    public function reset_password_page($email)
    {
        return view('admin.auth.resetpassword', compact('email'));
    }

    public function reset_password_store(Request $request, $email)
    {
        $request->validate([
            'email' => 'required|email|max:50',
            'new_password' => 'required|max:50',
            'confirm_password' => 'required|max:50|same:new_password',

        ]);
        if ($request->email != $email) {
            return redirect()->back()->with('Delete', 'Your Email is defferent from the email that we sent to you');
        }
        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return redirect()->back()->with(['Delete' => 'Email not found']);
        }
        $admin->update([
            'password' => bcrypt($request->new_password),
        ]);
        return redirect()->route('admin.login')->with('Add', 'Password reset successfully');
    }
}
