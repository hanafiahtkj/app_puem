<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        return view('user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi = [
            'name'       => 'required|string|max:255',
            'username'   => 'required|min:5|unique:users',
            'password'   => 'required|string|confirmed|min:8',
            'image'      => 'required|mimes:jpg,bmp,png',
        ];

        $request->validate($validasi);

        $path = '';
        if($request->hasFile('image')) {
            $upload_path = 'public/users/image';
            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs(
                $upload_path, $filename
            );
        }

        $user = User::create([
            'name'         => $request->name,
            'username'     => $request->username,
            'email'        => $request->username,
            'password'     => Hash::make($request->password),
            'image'        => $path,
            'status'       => 1,
            'email_verified_at' => now()
        ]);

        // event(new Registered($user));

        $user->assignRole('Admin');

        return redirect()->route('users.index')
            ->with('success','Pengguna berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $data = [
            'user'      => $user,
        ];
        return view('user.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validasi = [
            'name'       => 'required|string|max:255',
            'username'   => 'required|unique:users,username,'.$id,
            'password'   => 'same:confirm-password',
            'image'      => 'mimes:jpg,bmp,png',
        ];

        $request->validate($validasi);

        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }

        $path = '';
        if($request->hasFile('image')) {
            $upload_path = 'public/users/image';
            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs(
                $upload_path, $filename
            );
            $input['image'] = $path;
        }
        
        $input['email'] =  $request->username;

        $user = User::find($id);
        $user->update($input);
    
        return redirect()->route('users.index')
            ->with('success','Pengguna berhasil dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return response()->json([
            'status' => true,
        ]);
    }

    public function getDataTables(Request $request)
    {
        $users = User::orderBy('id','DESC');
        return Datatables::of($users)
            ->make(true);
    }
}
