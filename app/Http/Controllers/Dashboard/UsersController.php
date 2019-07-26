<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\Users\StoreRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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


        $request_data = $request->except(['password', 'password_confirmation', 'permissions','image']);

        if($request->image){
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/uploads/user_images/'.$request->image->hashName()));
        }

        $request_data['image']= $request->image->hashName();
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

        $request_data = $request->except(['permissions','image']);

        if($request->image){

           if($user->image !='default.png'){
               Storage::disk('public_uploads')->delete('/user_images/'.$user->image);
           }

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/uploads/user_images/'.$request->image->hashName()));
            $request_data['image']= $request->image->hashName();

        }




        $user->update($request_data);

        $user->syncPermissions($request->permissions);
        return redirect()->route('users.index')->with('success', __('site.edit_successfully'));


    }


    public function destroy(User $user){
        if($user->image !='default.png'){
            Storage::disk('public_uploads')->delete('/user_images/'.$user->image);
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', __('site.deleted_successfully'));


    }



}
