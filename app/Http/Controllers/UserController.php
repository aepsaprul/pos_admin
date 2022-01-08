<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\NavMain;
use App\Models\NavMainUser;
use App\Models\NavSub;
use App\Models\NavSubUser;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with(['employee', 'employee.position'])->where('employee_id', '!=', null)->get();

        return view('pages.user.index', ['users' => $user]);
    }

    public function create()
    {
        $employee = Employee::get();
        $menu = NavSub::get();
        $sub = NavSub::with('navMain')
            ->select(DB::raw('count(nav_main_id) as total'),'nav_main_id')
            ->groupBy('nav_main_id')
            ->get();

        return view('pages.user.create', [
            'employees' => $employee,
            'menus' => $menu,
            'subs' => $sub
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
