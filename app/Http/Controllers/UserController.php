<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kecamatan;
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
        $data = [
            'kecamatan' => Kecamatan::all(),
            'roles' => Role::all(),
        ];
        return view('user.form', $data);
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
            'level'      => 'required',
            'image'      => 'mimes:jpg,bmp,png',
            'status'     => 'required',
        ];

        $level = $request->level;
        if ($level == 'Admin Kecamatan') {
            $validasi['id_kecamatan'] = 'required';
        } else if ($level == 'Admin Desa') {
            $validasi['id_kecamatan'] = 'required';
            $validasi['id_desa'] = 'required';
        }

        $request->validate($validasi);

        $path = '';
        if($request->hasFile('image')) {
            $upload_path = 'public/users/image';
            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs(
                $upload_path, $filename
            );
        }

        $data = [
            'name'         => $request->name,
            'username'     => $request->username,
            'email'        => $request->username,
            'password'     => Hash::make($request->password),
            'id_kecamatan' => $request->id_kecamatan,
            'id_desa'      => $request->id_desa,
            'image'        => $path,
            'status'       => $request->status,
            'email_verified_at' => now()
        ];

        $user = User::create($data);

        $user->assignRole($level);

        return redirect()->route('master.pengguna.index')
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
        foreach($user->getRoleNames() as $v){
            $roleName = $v;
        }
        $data = [
            'user'      => $user,
            'roleName'  => $roleName,
            'roles'     => Role::all(),
            'kecamatan' => Kecamatan::all(),
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
            'level'      => 'required',
            'image'      => 'mimes:jpg,bmp,png',
            'status'     => 'required',
        ];

        $level = $request->level;
        if ($level== 'Admin Kecamatan') {
            $validasi['id_kecamatan'] = 'required';
        } else if ($level == 'Admin Desa') {
            $validasi['id_kecamatan'] = 'required';
            $validasi['id_desa'] = 'required';
        }

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

        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($level);
    
        return redirect()->route('master.pengguna.index')
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
            ->addColumn('role',function(User $users){
                foreach($users->getRoleNames() as $v){
                    return $v;
                }
            })
            ->make(true);
    }
}
