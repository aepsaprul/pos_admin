<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\NavMain;
use App\Models\NavMainUser;
use App\Models\NavSubUser;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with('roles')->where('roles_id', '!=', '0')->get();

        return view('pages.user.index', ['users' => $user]);
    }

    public function create()
    {
        $roles = Roles::get();
        $employee = Employee::get();

        return response()->json([
            'roles' => $roles,
            'employees' => $employee
        ]);
    }

    public function store(Request $request)
    {
        $employee = Employee::find($request->employee_id);

        $user = new User;
        $user->name = $employee->full_name;
        $user->email = $employee->email;
        $user->password = Hash::make($request->password);
        $user->employee_id = $request->employee_id;
        $user->roles_id = $request->roles;
        $user->save();

        return response()->json([
            'status' => 'Data berhasil disimpan'
        ]);
    }

    public function deleteBtn($id)
    {
        $user = User::find($id);

        return response()->json([
            'id' => $user->id,
            'name' => $user->name
        ]);
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
