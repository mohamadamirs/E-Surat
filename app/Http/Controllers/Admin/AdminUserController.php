<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.pengguna.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat pengguna baru.
     */
    public function create()
    {
        return view('admin.pengguna.create');
    }
    // function store "menambahkan data"
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'string', 'in:admin,sekretaris,kepala'],
            'jenis_kelamin' => ['required', 'string', 'in:Laki-laki,Perempuan'],
            'nomer_hp' => ['nullable', 'string', 'unique:users,nomer_hp'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nomer_hp' => $request->nomer_hp,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data pengguna.
     */
    public function edit(User $user)
    {
        return view('admin.pengguna.edit', compact('user'));
    }

    /**
     * Memperbarui data pengguna di database.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'jenis_kelamin' => ['required', 'string', 'in:Laki-laki,Perempuan'],
            
            'nomer_hp' => [
                'nullable',
                'string',
                Rule::unique('users', 'nomer_hp')->ignore($user->id),
            ],
            'role' => ['required', 'string', 'in:admin,sekretaris,kepala'], 
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $dataToUpdate = $validatedData;

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($validatedData['password']);
        } else {
            unset($dataToUpdate['password']);
        }

        $user->update($dataToUpdate);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        if (auth()->id() == $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}