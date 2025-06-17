@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h2 style="border-bottom: 2px solid #198754; padding-bottom: 10px; display: inline-block; font-family: 'Montserrat', sans-serif; font-weight: 600;">
            KELOLA PEGAWAI
        </h2>
        
        {{-- Show Success Messages --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        {{-- Show Error Messages --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('pegawai.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Pegawai</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                       placeholder="Masukkan nama pegawai" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" 
                       placeholder="Masukkan alamat pegawai" value="{{ old('alamat') }}">
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="nomor" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control @error('nomor') is-invalid @enderror" id="nomor" name="nomor" 
                       placeholder="Masukkan nomor telepon pegawai" value="{{ old('nomor') }}">
                @error('nomor')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" 
                       placeholder="Masukkan jabatan pegawai" value="{{ old('jabatan') }}">
                @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="gaji" class="form-label">Gaji Pokok</label>
                <input type="number" class="form-control @error('gaji') is-invalid @enderror" id="gaji" name="gaji" 
                       placeholder="Masukkan gaji pokok" value="{{ old('gaji') }}">
                @error('gaji')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success">Tambah Pegawai</button>
        </form>
        
        {{-- Display existing pegawai if any --}}
        @if(isset($pegawaiList) && count($pegawaiList) > 0)
            <div class="mt-5">
                <h3>Daftar Pegawai</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Nomor Telepon</th>
                            <th>Jabatan</th>
                            <th>Gaji Pokok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pegawaiList as $pegawai)
                            <tr>
                                <td>{{ $pegawai->id }}</td>
                                <td>{{ $pegawai->name }}</td>
                                <td>{{ $pegawai->alamat }}</td>
                                <td>{{ $pegawai->nomor }}</td>
                                <td>{{ $pegawai->jabatan }}</td>
                                <td>{{ ($pegawai->gaji) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <style>
    .btn-success {
        border-radius: 50px;
        padding: 10px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background-color: #157347;
        transform: scale(1.02);
    }
</style>

@endsection