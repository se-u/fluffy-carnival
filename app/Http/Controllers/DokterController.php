<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = User::where('role', 'dokter')
            ->with('poli')
            ->paginate(10);
        return view('admin.dokter.index', compact('dokters'));
    }

    public function create()
    {
        $polis = Poli::all();
        return view('admin.dokter.create', compact('polis'));
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
            'id_poli' => 'required|exists:poli,id',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_ktp' => $request->no_ktp,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'id_poli' => $request->id_poli,
            'role' => 'dokter',
        ]);

        return redirect()->route('dokter.index')->with('success', 'Data Dokter Berhasil Ditambahkan');
    }

    public function edit(User $dokter)
    {
        $polis = Poli::all();
        return view('admin.dokter.edit', compact('dokter', 'polis'));
    }

    public function update(Request $request, User $dokter)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $dokter->id,
            'no_ktp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'id_poli' => 'required|exists:poli,id',
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
            'id_poli' => $request->id_poli,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $dokter->update($data);

        return redirect()->route('dokter.index')->with('success', 'Data Dokter Berhasil Diubah');
    }

    public function destroy(User $dokter)
    {
        $dokter->delete();
        return redirect()->route('dokter.index')->with('success', 'Data Dokter Berhasil Dihapus');
    }
}
