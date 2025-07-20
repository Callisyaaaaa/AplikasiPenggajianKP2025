<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index()
    {
        return view('pegawai');
    }

    public function store(Request $request)
    {

        $request->merge([
            'gaji' => str_replace('.', '', $request->gaji),
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomor' => 'required|string|max:15',
            'jabatan' => 'required|string|max:100',
            'gaji' => 'required|integer',
            'nik' => 'required|string|max:20|unique:pegawais,nik',
            'status_pegawai' => 'required|in:Aktif,Kontrak',
            'status_menikah' => 'required|in:Belum Menikah,Menikah',
            'pendidikan' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);


        // Simpan user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Pegawai' // tambahkan kolom ini di tabel users
        ]);

        // Simpan pegawai
        $pegawai = Pegawai::create([
            'iduser' => $user->id,
            'name' => $request->name,
            'alamat' => $request->alamat,
            'nomor' => $request->nomor,
            'jabatan' => $request->jabatan,
            'gaji' => $request->gaji,
            'nik' => $request->nik,
            'status_pegawai' => $request->status_pegawai,
            'status_menikah' => $request->status_menikah,
            'pendidikan' => $request->pendidikan,
        ]);


        return redirect('/pegawai')->with('success', 'Pegawai berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomor' => 'required|string|max:15',
            'jabatan' => 'required|string|max:255',
            'gaji' => 'required|numeric|min:0',
            'nik' => 'required|string|max:20|unique:pegawais,nik,' . $id,
            'status_pegawai' => 'required|in:Aktif,Kontrak',
            'status_menikah' => 'required|in:Belum Menikah,Menikah',
            'pendidikan' => 'required|string|in:SD,SMP,SMA/SMK,D3,S1,S2,S3',
        ]);

        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($validated);

        return redirect()->route('pegawai.showAll')->with('success', 'Pegawai berhasil diupdate!');
    }


    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $user = User::where('id', $pegawai->iduser)->first();

        $user->delete();
        $pegawai->delete();


        return redirect()->route('pegawai.showAll')->with('success', 'Data pegawai berhasil dihapus.');;
    }
    public function showAll()
    {
        $pegawaiList = Pegawai::all();
        return view('daftarpegawai', compact('pegawaiList'));
    }
}
