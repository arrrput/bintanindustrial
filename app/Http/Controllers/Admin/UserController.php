<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Helpers\LogHelper;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('cms.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('cms.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        LogHelper::log('CREATE', 'User Management', "Created new user: {$user->name} ({$user->email})");

        return redirect()->route('cms.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('cms.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles($request->role);

        LogHelper::log('UPDATE', 'User Management', "Updated user: {$user->name} ({$user->email})");

        return redirect()->route('cms.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('cms.users.index')->with('error', 'You cannot delete yourself.');
        }

        $userName = $user->name;
        $userEmail = $user->email;
        $user->delete();

        LogHelper::log('DELETE', 'User Management', "Deleted user: $userName ($userEmail)");

        return redirect()->route('cms.users.index')->with('success', 'User deleted successfully.');
    }
}
