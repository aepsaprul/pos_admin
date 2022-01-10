<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\NavAccess;
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
        $user = User::with(['employee', 'employee.position'])->where('employee_id', '!=', null)->orderBy('id', 'desc')->get();

        return view('pages.user.index', ['users' => $user]);
    }

    public function create()
    {
        $employee = Employee::doesntHave('navAccess')->get();

        return response()->json([
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
        $user->save();

        $nav_sub = NavSub::get();

        foreach ($nav_sub as $key => $item) {
            $nav_access = new NavAccess;
            $nav_access->user_id = $request->employee_id;
            $nav_access->main_id = $item->nav_main_id;
            $nav_access->sub_id = $item->id;
            $nav_access->show = "n";
            $nav_access->create = "n";
            $nav_access->edit = "n";
            $nav_access->delete = "n";
            $nav_access->save();
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function access($id)
    {
        $user = User::find($id);

        $employee = Employee::where('id', $user->employee_id)->first();
        $menu = NavAccess::where('user_id', $user->employee_id)->get();
        $sub = NavAccess::with('navMain')
            ->where('user_id', $user->employee_id)
            ->select(DB::raw('count(main_id) as total'),'main_id')
            ->groupBy('main_id')
            ->get();

        return view('pages.user.access', [
            'employee' => $employee,
            'menus' => $menu,
            'subs' => $sub
        ]);
    }

    public function accessSave(Request $request, $id)
    {
        $nav_access = NavAccess::find($id);

        if ($request->show) {
            $nav_access->show = $request->show;
        }
        if ($request->create) {
            $nav_access->create = $request->create;
        }
        if ($request->edit) {
            $nav_access->edit = $request->edit;
        }
        if ($request->delete) {
            $nav_access->delete = $request->delete;
        }

        $nav_access->save();

        return response()->json([
            'status' => 'success'
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

        $employee = Employee::where('id', $user->employee_id)->first();
        $nav_access = NavAccess::where('user_id', $employee->id);
        $nav_access->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
