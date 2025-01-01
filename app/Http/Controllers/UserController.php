<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(15);
        return view('admin.users.user', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = $request->only('name', 'email');
        $user['password'] = Hash::make($request['password']);
        if ($request->has('picture')) {
            $path = $request->file('picture')->store('users', 'public');
            $user['picture'] = $path;
        }
        User::create($user);
        return redirect()->back()->with('success', 'User created successfully');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'editName' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'name')->ignore($id),
            ],
            'editEmail' => [
                'required',
                'email',
                'max:255',
                'string',
                Rule::unique('users', 'email')->ignore($id)
            ],
            'password' => 'confirmed',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = User::findOrFail($id);
        if (!$request->has('modalId')) {
            if (!Hash::check($request->password, $user->password)) {
                return redirect()->back()->with('error', 'User password not correct');
            }
        }
        $user->name = $validated['editName'];
        $user->email = $validated['editEmail'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }
        if ($request->hasFile('picture')) {
            if ($user->picture && Storage::exists('public/' . $user->picture)) {
                Storage::delete('public/' . $user->picture);
            }
            $path = $request->file('picture')->store('users', 'public');
            $user->picture = $path;
        }
        $user->save();
        return redirect()->back()->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->picture && Storage::exists('public/' . $user->picture)) {
            Storage::delete('public/' . $user->picture);
        }
        $user->delete();
        return redirect()->back()->with('succes', 'User deleted with success');
    }
}
