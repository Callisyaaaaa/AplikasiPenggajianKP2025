<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;  // Model Pegawai

class PegawaiController extends Controller
{
    // Menampilkan form untuk tambah pegawai
    public function index()
    {
        return view('pegawai');  // Form tambah pegawai
    }

    // Menyimpan data pegawai baru ke dalam database
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomor' => 'required|string|max:15',
            'jabatan' => 'required|string|max:100',
            'gaji' => 'required|integer',
        ]);

        // Menyimpan data ke database
        Pegawai::create([
            'id' => $request->id,
            'name' => $request->name,
            'alamat' => $request->alamat,
            'nomor' => $request->nomor,
            'jabatan' => $request->jabatan,
            'gaji' => $request->gaji,
        ]);

        // Redirect dengan pesan sukses
        return redirect('/pegawai')->with('success', 'Pegawai berhasil ditambahkan!');
    }

    // Menampilkan halaman untuk mengedit pegawai
    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.edit', compact('pegawai'));
    }

    // Update data pegawai yang sudah ada
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomor' => 'required|string|max:15',
            'jabatan' => 'required|string|max:255',
            'gaji' => 'required|numeric|min:0',
        ]);

        // Update data pegawai
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($validated);

        return redirect()->route('pegawai.showAll')->with('success', 'Pegawai berhasil diupdate!');
    }

    // Menghapus data pegawai
    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

         return redirect('pegawai.showAll')->with('success', 'Data pegawai berhasil dihapus.');
    }

    // Menampilkan daftar pegawai dari database
    public function showAll()
    {
        // Ambil semua data pegawai dari database
        $pegawaiList = Pegawai::all();

        // Kirim data ke view daftarpegawai.blade.php
        return view('daftarpegawai', compact('pegawaiList'));
    }
}
