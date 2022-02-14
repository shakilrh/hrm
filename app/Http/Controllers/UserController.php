<?php

namespace App\Http\Controllers;

use App\User;
use App\Enums\UserStatus;
use App\Traits\FileHandler;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use FileHandler;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $userStatus = UserStatus::toArray();
        return view('user.form', compact('roles', 'userStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required',
            'status' => 'required'
        ]);
        $user = new User();
        $user->name = $request->name;
        if (!isset($request->username)) {
            $user->username = str_slug($request->name);
        } else {
            $user->username = $request->username;
        }
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->status = $request->status;
        $user->save();
        $user->assignRole($request->role);
        Toastr::success('User Successfully Created.', 'Success');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $userStatus = UserStatus::toArray();
        return view('user.form', compact('user', 'roles', 'userStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (isset($request->password)) {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'required|string|min:6|confirmed',
                'role' => 'required'
            ]);
        } else {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'role' => 'required'
            ]);
        }
        $user->name = $request->name;
        if (isset($request->username)) {
            $user->username = $request->username;
        } else {
            $user->username = str_slug($request->name);
        }
        $user->email = $request->email;
        if (isset($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->status = $request->status;
        $user->save();
        $user->syncRoles($request->role);
        Toastr::success('User Profile Successfully Updated.', 'Success');
        return redirect()->route('users.index');
    }

    public function profile()
    {
        return view('profile');
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image',
        ]);
        $username = str_slug(Auth::user()->username);
        $image = $request->file('image');
        $this->uploadImage($image, 'users', $username, '500', '500', Auth::user()->image);
        //        update User for employee
        $user = User::findOrFail(Auth::id());
        $user->name = $request->name;
        $user->image = $this->fileName;
        $user->save();
        Toastr::success('Profile Successfully Updated.', 'Success');
        return redirect()->back();
    }

    public function changePassword()
    {
        return view('password');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);
        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->current_password, $hashedPassword)) {
            if (!Hash::check($request->password, $hashedPassword)) {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                Auth::logout();
                Toastr::success('Password Successfully Changed', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('New password cannot be the same as old password.', 'Error');
                return redirect()->back();
            }
        } else {
            Toastr::error('Current password not match.', 'Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        Toastr::success('User Successfully Deleted.', 'Success');
        return redirect()->back();
    }
}
