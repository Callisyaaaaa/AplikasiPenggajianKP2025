<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;  // Model Pegawai

class PegawaiController extends Controller
{
    public function index()
    {
        return view('pegawai'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomor' => 'required|string|max:15',
            'jabatan' => 'required|string|max:100',
            'gaji' => 'required|integer',
        ]);

        Pegawai::create([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'nomor' => $request->nomor,
            'jabatan' => $request->jabatan,
            'gaji' => $request->gaji,
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
        ]);

        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($validated);

        return redirect()->route('pegawai.showAll')->with('success', 'Pegawai berhasil diupdate!');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return redirect()->route('pegawai.showAll')->with('success', 'Data pegawai berhasil dihapus.');;
    }
    public function showAll()
    {
        $pegawaiList = Pegawai::all();
        return view('daftarpegawai', compact('pegawaiList'));
    }
}
