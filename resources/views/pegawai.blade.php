@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h2
            style="border-bottom: 2px solid #198754; padding-bottom: 10px; display: inline-block; font-family: 'Montserrat', sans-serif; font-weight: 600;">
            INPUT PEGAWAI
        </h2>


        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pegawai.store') }}" method="POST">
            @csrf
            <div class="mb-3 col-md-6">
                <label for="name" class="form-label">Nama Pegawai</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    placeholder="Masukkan nama pegawai" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <!-- NIK -->
            <div class="mb-3 col-md-6">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik"
                    placeholder="Masukkan NIK pegawai" value="{{ old('nik') }}" required>
                @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Status Pegawai -->
            <div class="mb-3 col-md-6">
                <label for="status_pegawai" class="form-label">Status Pegawai</label>
                <select class="form-select @error('status_pegawai') is-invalid @enderror" id="status_pegawai"
                    name="status_pegawai" required>
                    <option value="" disabled selected>Pilih status</option>
                    <option value="Aktif" {{ old('status_pegawai') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Kontrak" {{ old('status_pegawai') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                </select>
                @error('status_pegawai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Status Menikah -->
            <div class="mb-3 col-md-6">
                <label for="status_menikah" class="form-label">Status Menikah</label>
                <select class="form-select @error('status_menikah') is-invalid @enderror" id="status_menikah"
                    name="status_menikah" required>
                    <option value="" disabled selected>Pilih status</option>
                    <option value="Belum Menikah" {{ old('status_menikah') == 'Belum Menikah' ? 'selected' : '' }}>Belum
                        Menikah</option>
                    <option value="Menikah" {{ old('status_menikah') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                </select>
                @error('status_menikah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Pendidikan Terakhir -->
            <div class="mb-3 col-md-6">
                <label for="pendidikan" class="form-label">Pendidikan Terakhir</label>
                <select class="form-select @error('pendidikan') is-invalid @enderror" id="pendidikan" name="pendidikan"
                    required>
                    <option value="" disabled selected>Pilih pendidikan terakhir</option>
                    <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                    <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                    <option value="SMA/SMK" {{ old('pendidikan') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                    <option value="D3" {{ old('pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                    <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                    <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                    <option value="S3" {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                </select>
                @error('pendidikan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3 col-md-6">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                    name="alamat" placeholder="Masukkan alamat pegawai" value="{{ old('alamat') }}" required>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-4">
                <label for="nomor" class="form-label">Nomor Telepon</label>
                <input type="number" class="form-control @error('nomor') is-invalid @enderror" id="nomor"
                    name="nomor" placeholder="Masukkan nomor telepon" value="{{ old('nomor') }}"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                @error('nomor')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label for="jabatan" class="form-label">Jabatan</label>
                <select class="form-select @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" required>
                    <option value="" disabled selected>Pilih jabatan</option>
                    <option value="Manager" {{ old('jabatan') == 'Manager' ? 'selected' : '' }}>Manager</option>
                    <option value="Accounting" {{ old('jabatan') == 'Accounting' ? 'selected' : '' }}>Finance</option>
                    <option value="Sales / Marketing" {{ old('jabatan') == 'Sales / Marketing' ? 'selected' : '' }}>Sales /
                        Marketing</option>
                    <option value="Teknisi" {{ old('jabatan') == 'Teknisi' ? 'selected' : '' }}>Teknisi</option>
                    <option value="Operasional" {{ old('jabatan') == 'Operasional' ? 'selected' : '' }}>Operasional
                    </option>
                    <option value="Personalia" {{ old('jabatan') == 'Operasional' ? 'selected' : '' }}>Personalia
                    </option>
                </select>
                @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label for="gaji" class="form-label">Gaji Pokok</label>
                <input type="text" class="form-control @error('gaji') is-invalid @enderror" id="gaji"
                    name="gaji" placeholder="Masukkan gaji pokok" value="{{ old('gaji') }}"
                    oninput="formatRupiah(this)" required>
                @error('gaji')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" placeholder="Masukkan email pegawai" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" placeholder="Masukkan password pegawai" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success">Tambah Pegawai</button>
        </form>


        @if (isset($pegawaiList) && count($pegawaiList) > 0)
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
                        @foreach ($pegawaiList as $pegawai)
                            <tr>
                                <td>{{ $pegawai->id }}</td>
                                <td>{{ $pegawai->name }}</td>
                                <td>{{ $pegawai->alamat }}</td>
                                <td>{{ $pegawai->nomor }}</td>
                                <td>{{ $pegawai->jabatan }}</td>
                                <td>{{ $pegawai->gaji }}</td>
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

    <script>
        function formatRupiah(el) {
            let value = el.value.replace(/\./g, '').replace(/[^\d]/g, '');
            if (!value) {
                el.value = '';
                return;
            }

            el.value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    </script>


@endsection
