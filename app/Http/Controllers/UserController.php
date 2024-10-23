<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User_Supplier;
use Inertia\Inertia;
use Illuminate\Validation\Rules\Password;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles', 'suppliers')->get();
        return Inertia::render('Users/Index', ['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $suppliers = Supplier::all();
        return Inertia::render('Users/Create', ['roles'=>$roles, 'suppliers'=>$suppliers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email:rfc,dns',
            'password'=>['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
            'password_confirmation'=>'required',
            'role'=>'required'
        ]);

        User::createUser($request);

        return to_route("admin.users.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with(['roles', 'suppliers', 'team'])->find($id);
        $usersForTeam = User::getUsersForTeam($id);
        $roles = Role::all();
        $suppliers = Supplier::getUsersSuppliers($user);
        $assigned_suppliers = User_Supplier::getAssignedSuppliers($id);
        $assigned_users = User_Supplier::getAssignedUsers($user->team);
        return Inertia::render("Users/Show", ["user"=>$user, "users_for_team"=>$usersForTeam, "roles"=>$roles, "suppliers"=>$suppliers, "assigned_suppliers"=>$assigned_suppliers, "assigned_users"=>$assigned_users]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'name'=>'required',
            'email'=>'required|email:rfc,dns',
            'password'=>['nullable','confirmed', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
            'password_confirmation'=>['required_with:password'],
            'role'=>'required'
        ]);

        User::updateUser($request);

        return to_route('admin.users.index');
    }
    public function updaterole(Request $request){
        $user = User::find($request->user['id']);
        $user->assignRole($request->role);
        return to_route('admin.users.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
