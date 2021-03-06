<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::filter($request->all())->get();
        // \Log::info(request()->sortOrder);
        // \Log::info(request()->sortField);
        $users->sort();
        return response()->json(compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->cgpa = $request->cgpa;
        $user->hobby = $request->hobby;
        $user->dob = $request->dob;
        $user->qualification = $request->qualification;
        $user->college = $request->college;
        $user->phone = $request->phone;
        $user->work_experience = $request->work_experience;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['success' => true, 'user' => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json(['success' => true, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email',
            'password'  => ['sometimes', 'nullable', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
            'hobby'    => 'required',
            'qualification'    => 'required',
            'college' => 'required',
            'cgpa'    => 'required|numeric|between:0.00,10.00',
            'phone'   => 'required|digits:10|distinct',
            'dob'     => 'required|date',
            'work_experience' => 'required|string|min:3|max:60',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->cgpa = $request->cgpa;
        $user->hobby = $request->hobby;
        $user->dob = $request->dob;
        $user->qualification = $request->qualification;
        $user->college = $request->college;
        $user->phone = $request->phone;
        $user->work_experience = $request->work_experience;

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response()->json(['success' => true, 'user' => $user]);
    }

    public function upload_user_photo(Request $request)
    {
        // check if image has been received from form
        if ($request->file('avatar')) {
            // check if user has an existing avatar
            if ($this->guard()->user()->avatar != NULL) {
                // delete existing image file
                Storage::disk('user_avatars')->delete($this->guard()->user()->avatar);
            }

            // processing the uploaded image
            $avatar_name = $this->random_char_gen(20) . '.' . $request->file('avatar')->getClientOriginalExtension();
            $avatar_path = $request->file('avatar')->storeAs('', $avatar_name, 'user_avatars');

            // Update user's avatar column on 'users' table
            $profile = User::find(3);
            $profile->avatar = $avatar_path;

            if ($profile->save()) {
                return response()->json([
                    'status'    =>  'success',
                    'message'   =>  'Profile Photo Updated!',
                    'avatar_url' =>  url('storage/user-avatar/' . $avatar_path)
                ]);
            } else {
                return response()->json([
                    'status'    => 'failure',
                    'message'   => 'failed to update profile photo!',
                    'avatar_url' => NULL
                ]);
            }
        }

        return response()->json([
            'status'    => 'failure',
            'message'   => 'No image file uploaded!',
            'avatar_url' => NULL
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => true, 'user' => $user]);
    }
}
