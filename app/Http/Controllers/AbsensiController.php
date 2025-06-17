<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class AbsensiController extends Controller
{
    // Menampilkan halaman absensi
    public function index()
    {
        $pegawaiList = Pegawai::all(); // Ambil semua data pegawai
        return view('absensi', compact('pegawaiList')); // Kirim data pegawai ke view
    }

    // Menyimpan data absensi
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'employee_id' => 'required|exists:pegawais,id',
            'status' => 'required|in:Hadir,Izin,Tanpa Keterangan',
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

        // Jika status 'Hadir' dan ada foto, simpan foto tersebut
        if ($request->status == 'Hadir' && $request->has('attendance_photo')) {
            // Konversi base64 menjadi file dan simpan di storage
            $photo = $request->attendance_photo;  // Base64 image
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photo));  // Remove base64 header
            
            // Generate file name (optional: timestamp for uniqueness)
            $fileName = 'attendance_' . time() . '.png';  // Save as PNG (or adjust extension as needed)
            
            // Save the file to storage
            Storage::disk('public')->put('attendance_photos/' . $fileName, $image);

            // Simpan path file ke dalam database
            $absensi->attendance_photo = 'attendance_photos/' . $fileName;
        }

        // Simpan data absensi ke database
        $absensi->save();

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dilakukan!');
    }

    public function riwayat(Request $request)
{
    $query = Absensi::with('pegawai');

    if ($request->filled('nama')) {
        $query->whereHas('pegawai', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->nama . '%');
        });
    }

    if ($request->filled('bulan')) {
        $tanggal = \Carbon\Carbon::parse($request->bulan);
        $query->whereMonth('attendance_time', $tanggal->month)
              ->whereYear('attendance_time', $tanggal->year);
    }

    $absensis = $query->orderBy('attendance_time', 'desc')->get();

    return view('riwayat-absensi', compact('absensis'));
}

    public function downloadPDF(Request $request)
{
    $query = Absensi::with('pegawai');

    if ($request->filled('nama')) {
        $query->whereHas('pegawai', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->nama . '%');
        });
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
