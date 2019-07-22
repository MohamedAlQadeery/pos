<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\Users\StoreRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    //


    public function __construct()
    {
        //crud

        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only('create');
        $this->middleware(['permission:update_users'])->only('edit');
        $this->middleware(['permission:delete_users'])->only('destroy');
    }

    public function index()
    {

        $users = User::where([]);
        if (request()->has('search')) {
            $users = $users->where('first_name', 'like', '%' . request()->input('search') . '%')->
            orWhere('last_name', 'like', '%' . request()->input('search') . '%');
        }


        $users = $users->whereRoleIs('admin')->paginate(10);
        $users->appends(['search'=>request()->input('search')]);
        return view('dashboard.users.index', ['users' => $users]);
    }

    public function create()
    {
        return view('dashboard.users.create');
    }


    public function edit(User $user){

        return view('dashboard.users.edit',['user'=>$user]);
    }

    public function store(StoreRequest $request)
    {

        $request_data = $request->except(['password', 'password_confirmation', 'permissions']);

        $request_data['password'] = bcrypt($request->input('password'));

        $user = User::create($request_data);

        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);


        return redirect()->route('users.index')->with('success', __('site.created_successfully'));


    }

    public function update(Request $request , User $user){

        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email'
        ]);

        $user->update($request->except(['_token','_method','permissions']));

        $user->syncPermissions($request->permissions);
        return redirect()->route('users.index')->with('success', __('site.edit_successfully'));


    }


    public function destroy(User $user){
        $user->delete();
        return redirect()->route('users.index')->with('success', __('site.deleted_successfully'));


    }



}
