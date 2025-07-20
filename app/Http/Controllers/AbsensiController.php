<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    // Menampilkan halaman absensi
    public function index()
    {
        // $pegawaiList = Pegawai::all(); // Ambil semua data pegawai
        // return view('absensi', compact('pegawaiList'));
        $today = Carbon::today()->toDateString();

        $sudahAbsenIds = Absensi::whereDate('attendance_time', $today)->pluck('pegawai_id');

        $pegawaiBelumAbsen = Pegawai::whereNotIn('id', $sudahAbsenIds)->get();

        return view('absensi', [
            'pegawaiList' => Pegawai::all(),
            'pegawaiBelumAbsen' => $pegawaiBelumAbsen,
        ]); // Kirim data pegawai ke view
    }

    // Menyimpan data absensi
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'employee_id' => 'required|exists:pegawais,id',
            'status' => 'required|in:Hadir,Izin,Tidak Hadir',
            'attendance_photo' => 'nullable|string', // Validasi base64 string
            'attendance_time' => 'required|date',
        ]);

        // Cari pegawai berdasarkan ID
        $pegawai = Pegawai::findOrFail($request->employee_id);

        // Simpan data absensi
        $absensi = new Absensi();
        $absensi->pegawai_id = $pegawai->id;

        // Simpan nama pegawai juga jika kolom ada di tabel absensi
        $absensi->pegawai_name = $pegawai->name;

        $absensi->status = $request->status;
        $absensi->attendance_time = $request->attendance_time;

      
        if ($request->status == 'Hadir' && $request->has('attendance_photo')) {
            
            $photo = $request->attendance_photo;  
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photo));  // Remove base64 header

            
            $fileName = 'attendance_' . time() . '.png';  

            
            Storage::disk('public')->put('attendance_photos/' . $fileName, $image);

        
            $absensi->attendance_photo = 'attendance_photos/' . $fileName;
        }

        $absensi->save();

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dilakukan!');
    }

    public function riwayat(Request $request)
    {
        $query = Absensi::with('pegawai');

        
        if (Auth::user()->role === 'Admin' || Auth::user()->role === 'Pimpinan') {
            if ($request->filled('nama')) {
                $query->whereHas('pegawai', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->nama . '%');
                });
            }
        } else {
            // filter hanya data pribadi
            $pegawai = Pegawai::where('iduser', Auth::user()->id)->first();
            if ($pegawai) {
                $query->where('pegawai_id', $pegawai->id);
            }
        }

        // === Filter bulan ===
        if ($request->filled('bulan')) {
            $tanggal = \Carbon\Carbon::parse($request->bulan);
            $query->whereMonth('attendance_time', $tanggal->month)
                ->whereYear('attendance_time', $tanggal->year);
        }

        // Ambil data absensi yang sudah difilter
        $absensis = $query->orderBy('attendance_time', 'desc')->get();

        // === Rekap per pegawai ===
        $rekapPegawai = [];

        foreach ($absensis as $absen) {
            $nama = $absen->pegawai->name;
            $tanggal = \Carbon\Carbon::parse($absen->attendance_time)->format('d-m-Y');

            if (!isset($rekapPegawai[$nama])) {
                $rekapPegawai[$nama] = [
                    'nama' => $nama,
                    'hadir' => 0,
                    'izin' => 0,
                    'tidak_hadir' => 0,
                    'tanggal' => [
                        'Hadir' => [],
                        'Izin' => [],
                        'Tidak Hadir' => [],
                    ]
                ];
            }

            switch ($absen->status) {
                case 'Hadir':
                    $rekapPegawai[$nama]['hadir']++;
                    $rekapPegawai[$nama]['tanggal']['Hadir'][] = $tanggal;
                    break;
                case 'Izin':
                    $rekapPegawai[$nama]['izin']++;
                    $rekapPegawai[$nama]['tanggal']['Izin'][] = $tanggal;
                    break;
                case 'Tidak Hadir':
                    $rekapPegawai[$nama]['tidak_hadir']++;
                    $rekapPegawai[$nama]['tanggal']['Tidak Hadir'][] = $tanggal;
                    break;
            }
        }

        // Ubah dari associative ke array numerik
        $rekapPegawai = array_values($rekapPegawai);

        return view('riwayat-absensi', compact('absensis', 'rekapPegawai'));
    }


    public function downloadPDF(Request $request)
    {
        $query = Absensi::with('pegawai');

        // Jika user bukan Admin/Pimpinan, filter hanya data dirinya
        if (!in_array(Auth::user()->role, ['Admin', 'Pimpinan'])) {
            $pegawai = Pegawai::where('iduser', Auth::user()->id)->first();
            if ($pegawai) {
                $query->where('pegawai_id', $pegawai->id);
            } else {
                // Tidak ditemukan data pegawai untuk user ini
                return back()->with('error', 'Data pegawai tidak ditemukan.');
            }
        } else {
            // Jika Admin atau Pimpinan, bisa filter berdasarkan nama
            if ($request->filled('nama')) {
                $query->whereHas('pegawai', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->nama . '%');
                });
            }
        }

        if ($request->filled('bulan')) {
            $tanggal = Carbon::parse($request->bulan);
            $query->whereMonth('attendance_time', $tanggal->month)
                ->whereYear('attendance_time', $tanggal->year);
        }

        $absensis = $query->orderBy('attendance_time', 'desc')->get();

        $pdf = Pdf::loadView('riwayat_pdf', [
            'absensis' => $absensis,
            'nama' => $request->nama,
            'bulan' => $request->bulan,
        ]);

        return $pdf->download('Riwayat_Absensi.pdf');
    }
}
