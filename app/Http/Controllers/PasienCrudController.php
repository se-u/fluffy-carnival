<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasienCrudController extends Controller
{
    public function index()
    {
        $pasiens = User::where('role', 'pasien')->paginate(10);
        return view('admin.pasien.index', compact('pasiens'));
    }

    public function create()
    {
        return view('admin.pasien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_ktp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_ktp' => $request->no_ktp,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'role' => 'pasien',
        ]);

        return redirect()->route('pasien.index')->with('success', 'Data Pasien Berhasil Ditambahkan');
    }

    public function edit(User $pasien)
    {
        return view('admin.pasien.edit', compact('pasien'));
    }

    public function update(Request $request, User $pasien)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pasien->id,
            'no_ktp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
        ];

        if ($request->password) {
            $rules['password'] = 'min:6';
        }

        $request->validate($rules);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'no_ktp' => $request->no_ktp,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $pasien->update($data);

        return redirect()->route('pasien.index')->with('success', 'Data Pasien Berhasil Diubah');
    }

    public function destroy(User $pasien)
    {
        $pasien->delete();
        return redirect()->route('pasien.index')->with('success', 'Data Pasien Berhasil Dihapus');
    }
}
