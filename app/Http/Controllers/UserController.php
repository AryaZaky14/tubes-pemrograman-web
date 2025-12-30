<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();

        return view('user.index', compact('users'));
    }
    
    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

public function store(Request $request)
{
    $request->validate([
        'nama'     => 'required',
        'username' => 'required|unique:user,username',
        'password' => 'required|min:6',
        'role_id'  => 'required'
    ], [
        'nama.required'     => 'Nama wajib diisi',
        'username.required' => 'Username wajib diisi',
        'username.unique'   => 'Username sudah digunakan, silakan pilih username lain',
        'password.required' => 'Password wajib diisi',
        'password.min'      => 'Password minimal 6 karakter',
        'role_id.required'  => 'Role wajib dipilih'
    ]);

    User::create([
        'nama'     => $request->nama,
        'username' => $request->username,
        'password' => bcrypt($request->password),
        'role_id'  => $request->role_id,
    ]);

    return redirect()
        ->route('user.index')
        ->with('success', 'User berhasil ditambahkan');
}


    public function edit($id)
{
    $user  = User::findOrFail($id);
    $roles = Role::all();

    return view('user.edit', compact('user', 'roles'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama'     => 'required',
        'username' => 'required|unique:user,username,' . $id . ',id_user',
        'role_id'  => 'required|exists:role,id_role'
    ], [
        'nama.required'     => 'Nama wajib diisi',
        'username.required' => 'Username wajib diisi',
        'username.unique'   => 'Username sudah digunakan oleh user lain',
        'role_id.required'  => 'Role wajib dipilih',
        'role_id.exists'    => 'Role tidak valid'
    ]);

    $user = User::findOrFail($id);

    $user->nama     = $request->nama;
    $user->username = $request->username;
    $user->role_id  = $request->role_id;

    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()
        ->route('user.index')
        ->with('success', 'Data user berhasil diperbarui');
}


public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()
        ->route('user.index')
        ->with('success', 'Berhasil menghapus data');
}

}
