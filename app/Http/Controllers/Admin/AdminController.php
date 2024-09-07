<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:AllAdmins', ['only' => ['index']]);
        $this->middleware('permission:AddAdmin', ['only' => ['create', 'store']]);
        $this->middleware('permission:EditAdmin', ['only' => ['edit', 'update']]);
        $this->middleware('permission:DeleteAdmin', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Owner');
        })->get();

        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('admin.admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:100',
            'username' => 'required|unique:admins,username',
            'phone' => 'required|regex:/^[0-9]{1,13}$/',
            'password' => 'required|min:4|max:50|confirmed',
            'roles_name' => 'required',
            'status' => 'required',
        ]);
        $exists = Admin::where('username', $request->username)->first();
        if ($exists) {
            return redirect()->back()->withInput()->with(['Delete' => 'Admin this username is aleardy exists']);
        }

        $exists_phone = Admin::where('phone', $request->phone)->first();
        if ($exists_phone) {
            return redirect()->back()->withInput()->with(['Delete' => 'Admin this phone is aleardy exists']);
        }

        $admin = Admin::create([
            "name" => "Admin",
            "username" => "admin",
            "password" => Hash::make($request->password),
            "phone" => "12345678910",
            "roles_name" => "Manger",
            "status" => "1",
        ]);


        $admin->assignRole($request->input('roles_name'));

        return redirect()->route('admins.index')->with(['Add' => 'Admin created successfully']);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $roles = Role::pluck('name', 'name')->all();
        $adminRole = $admin->roles->pluck('name', 'name')->all();

        return view('admin.admins.edit', compact('admin', 'roles', 'adminRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'nullable|min:3|max:100',
            'username' => 'nullable|unique:admins,username,' . $id,
            'password' => 'nullable|min:8|max:50',
            'status' => 'nullable',
            'roles_name' => 'required',
        ]);

        $admin = Admin::findOrFail($id);
        $exists = Admin::where('username', $request->username)->where('id', '!=', $id)->first();
        if ($exists) {
            return redirect()->back()->withInput()->with(['Delete' => 'Admin this username is aleardy exists']);
        }


        // Update user information
        $input = $request->except(['_token', '_method', 'password_confirmation']);

        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        } else {
            // If no new password is provided, keep the existing password
            $input['password'] = $admin->password;
        }

        $admin->update($input);

        // Remove existing roles and assign new roles
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $admin->assignRole($request->input('roles_name'));



        return redirect()->route('admins.index')->with(['Update' => 'Admin updated successfully.']);
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();


        return redirect()->route('admins.index')->with(['Delete' => 'Admin deleted successfully.']);
    }
}
