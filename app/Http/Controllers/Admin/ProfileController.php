<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $admin = auth()->guard('admin')->user();


        return view('admin.auth.profile', compact('admin'));
    }
    public function update_profile(Request $request, $id)
    {


        $request->validate([
            'name' => 'required|max:50',
            'username' => 'required|max:50',
            'phone' => 'nullable|min:11|max:12',
            'email' => 'nullable|email|max:100|unique:admins,email',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:8048',

        ]);
        $admin = Admin::findorfail($id);
        $exists_username = Admin::where(['username' => $request->username])->where('id', '!=', $id)->first();
        if ($exists_username) {
            return redirect()->back()->with(['Delete' => 'Username already exists']);
        }
        $exists_phone = Admin::where(['phone' => $request->phone])->where('id', '!=', $id)->first();
        if ($exists_phone) {
            return redirect()->back()->with(['Delete' => 'phone already exists']);
        }
        if ($request->email) {

            $exists = Admin::where(['email' => $request->email])->where('id', '!=', $id)->first();
            if ($exists) {
                return redirect()->back()->with(['Delete' => 'Email already exists']);
            }
        }

        $old_image = $admin->image;


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/admins/images'), $image_name);
            if ($admin->image && file_exists(public_path('admins/images/' . $admin->image))) {
                unlink(public_path('assets/admins/images/' . $admin->image));
            }
        }


        $admin->update([
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone ?? null,
            'email' => $request->email ?? null,
            'image' => $image_name ?? $old_image,
        ]);
        return redirect()->route('admin.profile')->with(['Update' => 'update Profile successfully']);
    }




    public function change_password(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'old_password' => 'required|max:50',
            'new_password' => 'required|max:50',
            'confirm_password' => 'required|max:50|same:new_password',
        ]);

        $admin = Admin::findOrFail($id);

        if (!Hash::check($request->old_password, $admin->password)) {
            return redirect()->back()->withInput()->withErrors(['old_password' => 'The old password is incorrect']);
        }

        $admin->update([
            'password' => bcrypt($request->new_password),
        ]);
        return redirect()->route('admin.edit.password')->with('Add', 'Password changed successfully');
    }
}
