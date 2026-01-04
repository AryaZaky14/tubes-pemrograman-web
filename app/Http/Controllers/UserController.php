<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // ======================
    // TAMPIL DATA USER
    // ======================
    public function index()
    {
        $users = User::with('role')->get();
        return view('user.index', compact('users'));
    }

    // ======================
    // FORM TAMBAH USER
    // ======================
    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    // ======================
    // SIMPAN USER BARU
    // ======================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => [
                'required',
                Rule::unique('user', 'username'),
                'regex:/^\S*$/'
            ],
            'password' => [
                'required',
                'min:6',
                'regex:/^\S*$/'
            ],
            'role_id' => 'required|exists:role,id_role'
        ], [
            'nama.required' => 'Nama wajib diisi',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'username.regex' => 'Username tidak boleh mengandung spasi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.regex' => 'Password tidak boleh mengandung spasi',
            'role_id.required' => 'Role wajib dipilih',
            'role_id.exists' => 'Role tidak valid'
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    // ======================
    // FORM EDIT USER
    // ======================
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('user.edit', compact('user', 'roles'));
    }

    // ======================
    // UPDATE DATA USER
    // ======================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'username' => [
                'required',
                'unique:user,username,' . $id . ',id_user',
                'regex:/^\S*$/'
            ],
            'role_id' => 'required|exists:role,id_role'
        ], [
            'nama.required' => 'Nama wajib diisi',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan oleh user lain',
            'username.regex' => 'Username tidak boleh mengandung spasi',
            'role_id.required' => 'Role wajib dipilih',
            'role_id.exists' => 'Role tidak valid'
        ]);

        $user = User::findOrFail($id);

        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->role_id = $request->role_id;

        // Jika password diisi
        if ($request->password) {
            $request->validate([
                'password' => [
                    'min:6',
                    'regex:/^\S*$/'
                ]
            ], [
                'password.min' => 'Password minimal 6 karakter',
                'password.regex' => 'Password tidak boleh mengandung spasi'
            ]);

            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()
            ->route('user.index')
            ->with('success', 'Data user berhasil diperbarui');
    }

    // ======================
    // HAPUS USER
    // ======================
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil dihapus');
    }
}
