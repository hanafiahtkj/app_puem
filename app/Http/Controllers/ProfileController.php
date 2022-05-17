<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use DB;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [
            'profile' => $user,
        ];
        //var_dump($data); die;
        return view('profile', $data);
    }

    public function updateProfileInformation(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'name'       => 'required|string|max:255',
            'username'   => 'required|unique:users,username,'.$user->id,
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        try{
            DB::beginTransaction();

            $data = [
                'name'         => $request->name,
                'username'     => $request->username,
                'email'        => $request->username,
            ];

            $path = '';
            if($request->hasFile('image')) {
                $upload_path = 'public/users/image';
                $filename = time().'_'.$request->file('image')->getClientOriginalName();
                $path = $request->file('image')->storeAs(
                    $upload_path, $filename
                );
                $data['image'] = $path;
            }

            $user->update($data);

            // event(new Registered($user));

            DB::commit();
        
        }catch(\Exception $e){
            DB::rollback();

            return response()->json([
                'status' => false,
                'msg' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => true,
        ]);
    }

    function updatePassword(Request $request)
    {
        $rules = [
            'current_password' => 'required',
            'password' => 'required|string|confirmed|min:8',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $user = Auth::user();
        if (! Hash::check($request->input('current_password'), $user->password)) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'current_password' => 'Password yang dimasukan salah',
                ]
            ]);
        }

        $user->forceFill([
            'password' => Hash::make($request->input('password')),
        ])->save();

        return response()->json([
            'status' => true,
        ]);
    }
}
