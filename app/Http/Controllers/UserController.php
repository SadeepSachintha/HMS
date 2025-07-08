<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Display a listing of the users
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('contact_number', 'like', "%$search%")
                  ->orWhere('address', 'like', "%$search%")
                  ->orWhere('role', 'like', "%$search%")
                  ->orWhere('id', 'like', "%$search%")
                  ;
            });
        }
        $users = $query->paginate(10);
        return view('users.index', compact('users'));
    }

    // Show the form for creating a new user
    public function create()
    {
        $roles = ['Admin', 'Manager', 'Staff'];
        return view('users.create', compact('roles'));
    }

    // Store a newly created user in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:Admin,Manager,Staff',
            'password' => 'required|string|min:6|confirmed',
            'status' => 'required|boolean',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Display the specified user
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // Show the form for editing the specified user
    public function edit(User $user)
    {
        $roles = ['Admin', 'Manager', 'Staff'];
        return view('users.edit', compact('user', 'roles'));
    }

    // Update the specified user in storage
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:Admin,Manager,Staff',
            'status' => 'required|boolean',
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'role' => $request->role,
            'status' => $request->status,
        ]);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Remove the specified user from storage
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    // Admin resets the user's password directly
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('users.edit', $user)->with('success', 'Password reset successfully.');
    }

    // Toggle user status (active/inactive)
    public function toggleStatus(User $user)
    {
        $user->status = !$user->status;
        $user->save();
        return redirect()->route('users.index')->with('success', 'User status updated.');
    }
}
