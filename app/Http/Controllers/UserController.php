<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        
        // Only admin can manage users
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Explicitly exclude soft-deleted users
        $users = User::orderBy('name', 'asc')->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currentUser = Auth::user();
        
        // Only admin can create users
        if (!$currentUser->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currentUser = Auth::user();
        
        // Only admin can create users
        if (!$currentUser->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:admin,college_head,senior_head,junior_head,teacher,staff,Head Maintenance',
            'employee_id' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'employee_id' => $validated['employee_id'] ?? null,
            'department' => $validated['department'] ?? null,
        ]);

        Log::info('User created', [
            'user_id' => $user->id,
            'created_by' => $currentUser->id,
        ]);

        return redirect()->route('users.show', $user)
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $currentUser = Auth::user();
        
        // Only admin can view other users
        if (!$currentUser->isAdmin() && $currentUser->id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $currentUser = Auth::user();
        
        // Only admin can edit other users
        if (!$currentUser->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $currentUser = Auth::user();
        
        // Only admin can update other users
        if (!$currentUser->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:admin,college_head,senior_head,junior_head,teacher,staff,Head Maintenance',
            'employee_id' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update user data
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'employee_id' => $validated['employee_id'] ?? null,
            'department' => $validated['department'] ?? null,
        ];

        // Only update password if provided
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        Log::info('User updated', [
            'user_id' => $user->id,
            'updated_by' => $currentUser->id,
        ]);

        return redirect()->route('users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $currentUser = Auth::user();
        
        // Only admin can delete users
        if (!$currentUser->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Prevent self-deletion
        if ($currentUser->id === $user->id) {
            return redirect()->back()
                ->with('error', 'You cannot delete your own account.');
        }

        // Handle foreign key constraints by setting null on related events
        DB::transaction(function () use ($user) {
            // Set created_by to null for events created by this user
            Event::where('created_by', $user->id)->update(['created_by' => null]);
            
            // Set approved_by to null for events approved by this user
            Event::where('approved_by', $user->id)->update(['approved_by' => null]);
            
            // Soft delete the user
            $user->delete();
        });

        Log::info('User deleted', [
            'deleted_user_id' => $user->id,
            'deleted_by' => $currentUser->id,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully. Related events have been updated.');
    }
}

