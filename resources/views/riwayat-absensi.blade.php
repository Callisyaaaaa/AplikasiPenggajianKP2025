@extends('layouts.app')

@section('title', 'Riwayat Absensi Pegawai')

@section('content')
<div class="container mt-4">
    <h4 style="border-bottom: 2px solid #198754; padding-bottom: 10px; display: inline-block; font-family: 'Montserrat', sans-serif; font-weight: 600;">
            RIWAYAT ABSENSI
    </h4>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('absensi.riwayat') }}" class="row mb-3">
        <div class="col-md-3">
            <input type="text" name="nama" class="form-control" placeholder="Nama Pegawai" value="{{ request('nama') }}">
        </div>
        <div class="col-md-2">
            <input type="month" name="bulan" class="form-control" value="{{ request('bulan') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    @if($absensis->isEmpty())
        <div class="alert alert-warning text-center">
            Data riwayat absensi yang Anda input tidak tersedia.
        </div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Jam</th>
                    <th>Tanggal</th>
                    <th>Nama Pegawai</th>
                    <th>Status Kehadiran</th>
                    <th>Bukti Foto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absensis as $absensi)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($absensi->attendance_time)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($absensi->attendance_time)->format('d-m-Y') }}</td>
                        <td>{{ $absensi->pegawai->name }}</td>
                        <td>{{ $absensi->status }}</td>
                        <td>
                            @if($absensi->status === 'Hadir' && $absensi->attendance_photo)
                                <a href="{{ asset('storage/' . $absensi->attendance_photo) }}" target="_blank">Lihat Foto</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="col-md-2">
            <a href="{{ route('absensi.riwayat.download', request()->query()) }}" class="btn btn-danger">Download PDF</a>
        </div>
    </div>
@endsection
