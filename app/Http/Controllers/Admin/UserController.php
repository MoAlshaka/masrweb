<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:AllUsers', ['only' => ['index']]);
        $this->middleware('permission:AddUser', ['only' => ['create', 'store']]);
        $this->middleware('permission:EditUser', ['only' => ['edit', 'update']]);
        $this->middleware('permission:DeleteUser', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:100',
            'email' => 'required|unique:users,email',
            'phone' => 'required|regex:/^[0-9]{1,13}$/',
            'password' => 'required|min:4|max:50|confirmed',
            'address' => 'required|max:200',
            'status' => 'required',
        ]);

        $exists = User::where('email', $request->email)->first();
        if ($exists) {
            return redirect()->back()->withInput()->with(['Delete' => ' this email is aleardy exists']);
        }

        $exists_phone = User::where('phone', $request->phone)->first();
        if ($exists_phone) {
            return redirect()->back()->withInput()->with(['Delete' => ' this phone is aleardy exists']);
        }
        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
            'address' => $request->address,
            'status' => $request->status,
            'added_by' => auth()->user()->id,
        ]);
        return redirect()->route('users.index')->with(['Add' => 'Users created successfully']);
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
    public function edit(string $id)
    {
        $user = User::findorfail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:3|max:100',
            'email' => 'required|email',
            'phone' => 'required|regex:/^[0-9]{1,13}$/',
            'password' => 'nullable|min:8|max:50',
            'address' => 'required|max:200',
            'status' => 'required',
        ]);

        $user = User::findOrFail($id);
        $exists = User::where('email', $request->email)->where('id', '!=', $id)->first();
        if ($exists) {
            return redirect()->back()->withInput()->with(['Delete' => 'User this email is aleardy exists']);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->filled('password') ? bcrypt($request->password) : $user->password,
            'address' => $request->address,
            'status' => $request->status,
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('users.index')->with(['Update' => 'Users created successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->image) {
            $imagePath = public_path('assets/users/images/' . $user->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $user->delete();


        return redirect()->route('users.index')->with(['Delete' => 'User deleted successfully.']);
    }
}
