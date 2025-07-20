@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h2
            style="border-bottom: 2px solid #198754; padding-bottom: 10px; display: inline-block; font-family: 'Montserrat', sans-serif; font-weight: 600;">
            DAFTAR PEGAWAI
        </h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Nomor Telepon</th>
                    <th>Jabatan</th>
                    <th>Pendidikan Terakhir</th>
                    <th>Status Pegawai</th>
                    <th>Status Menikah</th>
                    <th>Gaji Pokok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawaiList as $pegawai)
                    <tr>
                        <td>{{ $pegawai->nik }}</td>
                        <td>{{ $pegawai->name }}</td>
                        <td>{{ $pegawai->alamat }}</td>
                        <td>{{ $pegawai->nomor }}</td>
                        <td>{{ $pegawai->jabatan }}</td>
                        <td>{{ $pegawai->pendidikan }}</td>
                        <td>{{ $pegawai->status_pegawai }}</td>
                        <td>{{ $pegawai->status_menikah }}</td>
                        <td>{{ $pegawai->gaji }}</td>
                        <td>
                            <!-- Tombol Edit -->
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $pegawai->id }}">Edit</button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $pegawai->id }}">Hapus</button>
                            </div>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal{{ $pegawai->id }}" tabindex="-1"
                                aria-labelledby="editModalLabel{{ $pegawai->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $pegawai->id }}">Edit Pegawai
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama Pegawai</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        value="{{ $pegawai->name }}">
                                                </div>
                                                <!-- NIK -->
                                                <div class="mb-3">
                                                    <label for="nik" class="form-label">NIK</label>
                                                    <input type="text" class="form-control" id="nik" name="nik"
                                                        value="{{ $pegawai->nik }}" required>
                                                </div>

                                                <!-- Status Pegawai -->
                                                <div class="mb-3">
                                                    <label for="status_pegawai" class="form-label">Status Pegawai</label>
                                                    <select class="form-select" id="status_pegawai" name="status_pegawai"
                                                        required>
                                                        <option value="Aktif"
                                                            {{ $pegawai->status_pegawai == 'Aktif' ? 'selected' : '' }}>
                                                            Aktif</option>
                                                        <option value="Kontrak"
                                                            {{ $pegawai->status_pegawai == 'Kontrak' ? 'selected' : '' }}>
                                                            Kontrak</option>
                                                    </select>
                                                </div>

                                                <!-- Status Menikah -->
                                                <div class="mb-3">
                                                    <label for="status_menikah" class="form-label">Status Menikah</label>
                                                    <select class="form-select" id="status_menikah" name="status_menikah"
                                                        required>
                                                        <option value="Belum Menikah"
                                                            {{ $pegawai->status_menikah == 'Belum Menikah' ? 'selected' : '' }}>
                                                            Belum Menikah</option>
                                                        <option value="Menikah"
                                                            {{ $pegawai->status_menikah == 'Menikah' ? 'selected' : '' }}>
                                                            Menikah</option>
                                                    </select>
                                                </div>

                                                <!-- Pendidikan Terakhir -->
                                                <div class="mb-3">
                                                    <label for="pendidikan" class="form-label">Pendidikan Terakhir</label>
                                                    <select class="form-select" id="pendidikan" name="pendidikan" required>
                                                        <option value="SD"
                                                            {{ $pegawai->pendidikan == 'SD' ? 'selected' : '' }}>SD
                                                        </option>
                                                        <option value="SMP"
                                                            {{ $pegawai->pendidikan == 'SMP' ? 'selected' : '' }}>SMP
                                                        </option>
                                                        <option value="SMA/SMK"
                                                            {{ $pegawai->pendidikan == 'SMA/SMK' ? 'selected' : '' }}>
                                                            SMA/SMK</option>
                                                        <option value="D3"
                                                            {{ $pegawai->pendidikan == 'D3' ? 'selected' : '' }}>D3
                                                        </option>
                                                        <option value="S1"
                                                            {{ $pegawai->pendidikan == 'S1' ? 'selected' : '' }}>S1
                                                        </option>
                                                        <option value="S2"
                                                            {{ $pegawai->pendidikan == 'S2' ? 'selected' : '' }}>S2
                                                        </option>
                                                        <option value="S3"
                                                            {{ $pegawai->pendidikan == 'S3' ? 'selected' : '' }}>S3
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="alamat" class="form-label">Alamat</label>
                                                    <input type="text" class="form-control" id="alamat" name="alamat"
                                                        value="{{ $pegawai->alamat }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nomor" class="form-label">Nomor Telepon</label>
                                                    <input type="text" class="form-control" id="nomor" name="nomor"
                                                        value="{{ $pegawai->nomor }}" pattern="\d*" inputmode="numeric"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        maxlength="15" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jabatan" class="form-label">Jabatan</label>
                                                    <select class="form-select @error('jabatan') is-invalid @enderror"
                                                        id="jabatan" name="jabatan" required>
                                                        <option value="" disabled selected>Pilih jabatan</option>
                                                        <option value="Manager"
                                                            {{ old('jabatan', $pegawai->jabatan) == 'Manager' ? 'selected' : '' }}>
                                                            Manager
                                                        </option>
                                                        <option value="Accounting"
                                                            {{ old('jabatan', $pegawai->jabatan) == 'Accounting' ? 'selected' : '' }}>
                                                            Accounting</option>
                                                        <option value="Sales / Marketing"
                                                            {{ old('jabatan', $pegawai->jabatan) == 'Sales / Marketing' ? 'selected' : '' }}>
                                                            Sales /
                                                            Marketing</option>
                                                        <option value="Teknisi"
                                                            {{ old('jabatan', $pegawai->jabatan) == 'Teknisi' ? 'selected' : '' }}>
                                                            Teknisi
                                                        </option>
                                                        <option value="Operasional"
                                                            {{ old('jabatan', $pegawai->jabatan) == 'Operasional' ? 'selected' : '' }}>
                                                            Operasional
                                                        </option>
                                                    </select>
                                                    @error('jabatan')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="gaji" class="form-label">Gaji Pokok</label>
                                                    <input type="text" class="form-control" id="gaji"
                                                        name="gaji" value="{{ $pegawai->gaji }}" pattern="\d*"
                                                        inputmode="numeric"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update Pegawai</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Delete -->
                            <div class="modal fade" id="deleteModal{{ $pegawai->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel{{ $pegawai->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $pegawai->id }}">Hapus
                                                Pegawai
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus pegawai {{ $pegawai->name }}?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
