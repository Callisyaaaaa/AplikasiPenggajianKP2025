@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <!-- <h2>Absensi Pegawai</h2> -->
       <h2 style="border-bottom: 2px solid #198754; padding-bottom: 10px; display: inline-block; font-family: 'Montserrat', sans-serif; font-weight: 600;">
            ABSENSI PEGAWAI
        </h2>

         @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        
        <form action="{{ route('absensi.store') }}" method="POST" enctype="multipart/form-data" id="absensiForm">
            @csrf
            <!-- Pilih Pegawai -->
            <div class="mb-3">
                <label for="employee_id" class="form-label">Nama Pegawai</label>
                <select class="form-select" id="employee_id" name="employee_id">
                    <option selected>Pilih Pegawai</option>
                    @foreach($pegawaiList as $pegawai)
                        <option value="{{ $pegawai->id }}">{{ $pegawai->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Kehadiran -->
            <div class="mb-3">
                <label for="status" class="form-label">Status Kehadiran</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="hadir" name="status" value="Hadir" onclick="toggleCamera()">
                    <label class="form-check-label" for="hadir">Hadir</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="izin" name="status" value="Izin" onclick="toggleCamera()">
                    <label class="form-check-label" for="izin">Izin</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="tanpa_keterangan" name="status" value="Tanpa Keterangan" onclick="toggleCamera()">
                    <label class="form-check-label" for="tanpa_keterangan">Tanpa Keterangan</label>
                </div>
            </div>
            <!-- Kolom Foto Absensi (hanya muncul saat "Hadir" dipilih) -->
            <div class="mb-3" id="attendance_photo_div" style="display: none;">
                <label for="attendance_photo" class="form-label">Foto Absensi</label>
                <video id="webcam" width="320" height="240" autoplay style="display:none;"></video>
                <canvas id="canvas" style="display:none;"></canvas>
                <br>
                <button type="button" class="btn btn-primary" id="takePhotoBtn">Ambil Foto</button>
                <br><br>
                <!-- Tempat untuk menampilkan gambar -->
                <img id="photoPreview" src="" style="display:none; width: 320px; height: 240px; border: 1px solid #ddd;">
                <input type="hidden" name="attendance_photo" id="attendance_photo">
            </div>

            <!-- Waktu Absensi -->
            <div class="mb-3">
                <label for="attendance_time" class="form-label">Waktu Absensi</label>
                <input type="datetime-local" class="form-control" id="attendance_time" name="attendance_time">
            </div>

            <button type="submit" class="btn btn-success shadow-sm rounded-pill px-4 py-2" style="background-color: #28a745; border: none; font-weight: 600; transition: 0.3s;">
                <i class="fa fa-check-circle me-2"></i> Absen
            </button>
        </form>
    </div>

    <script>
        // Fungsi untuk menampilkan kamera dan foto saat status 'Hadir' dipilih
        function toggleCamera() {
            var status = document.querySelector('input[name="status"]:checked').value;  // Menyimpan nilai status yang dipilih
            var attendancePhotoDiv = document.getElementById("attendance_photo_div");  // Referensi ke div foto absensi
            var webcam = document.getElementById("webcam");  // Referensi ke elemen webcam
            var takePhotoBtn = document.getElementById("takePhotoBtn");  // Referensi ke tombol foto

            // Jika status "Hadir" dipilih
            if (status === "Hadir") {
                attendancePhotoDiv.style.display = "block";  // Tampilkan bagian foto absensi
                takePhotoBtn.style.display = "block";        // Tampilkan tombol ambil foto
                webcam.style.display = "block";              // Tampilkan webcam
                startCamera();  // Mulai kamera
            } else {
                // Jika status "Izin" atau "Tanpa Keterangan" dipilih, sembunyikan semuanya
                attendancePhotoDiv.style.display = "none";  // Sembunyikan bagian foto absensi
                takePhotoBtn.style.display = "none";        // Sembunyikan tombol ambil foto
                webcam.style.display = "none";              // Sembunyikan webcam
                stopCamera();  // Matikan kamera
            }
        }

        // Memulai webcam
        function startCamera() {
            navigator.mediaDevices.getUserMedia({ video: true })  // Meminta izin akses kamera
                .then(function(stream) {
                    var webcam = document.getElementById('webcam');
                    webcam.srcObject = stream;  // Menampilkan stream video dari kamera ke elemen video
                    webcam.style.display = 'block';  // Menampilkan elemen webcam
                    window.stream = stream;  // Menyimpan stream untuk menghentikan kamera nanti
                })
                .catch(function(err) {
                    console.log("Error accessing webcam: " + err);  // Menangani error jika tidak dapat mengakses kamera
                });
        }

        // Menghentikan webcam
        function stopCamera() {
            var webcam = document.getElementById('webcam');
            if (window.stream) {
                window.stream.getTracks().forEach(track => track.stop());  // Menghentikan semua track pada stream
                webcam.style.display = 'none';  // Menyembunyikan elemen webcam
            }
        }

        // Mengambil foto dari webcam
         function takePhoto() {
            var canvas = document.getElementById('canvas');
            var webcam = document.getElementById('webcam');
            var context = canvas.getContext('2d');
            canvas.width = webcam.videoWidth;
            canvas.height = webcam.videoHeight;
            context.drawImage(webcam, 0, 0, canvas.width, canvas.height);

            // Menyimpan foto ke input hidden
            var photo = canvas.toDataURL('image/png');
            document.getElementById('attendance_photo').value = photo;

            // Menampilkan foto di halaman
            var photoPreview = document.getElementById('photoPreview');
            photoPreview.src = photo;
            photoPreview.style.display = 'block';  // Menampilkan gambar
        }

        // Pastikan tombol "Ambil Foto" berfungsi
        document.getElementById("takePhotoBtn").addEventListener("click", function() {
            takePhoto();
        });

        // Validasi form sebelum submit
        document.getElementById("absensiForm").addEventListener("submit", function(event) {
            var employeeId = document.getElementById("employee_id").value;  // Mengecek apakah Nama Pegawai dipilih
            var status = document.querySelector('input[name="status"]:checked');  // Mengecek apakah status dipilih
            var attendanceTime = document.getElementById("attendance_time").value;  // Mengecek apakah Waktu Absensi dipilih

            // Cek apakah semua field wajib diisi
            if (employeeId === "" || !status || attendanceTime === "") {
                event.preventDefault();  // Mencegah submit form jika ada field kosong
                alert("Semua field wajib diisi: Nama Pegawai, Status Kehadiran, dan Waktu Absensi.");
            }
        });
    </script>

    <style>
    .btn-success:hover {
    background-color: #218838;
    transform: scale(1.02);
    }
    .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }
    .form-check-input:hover {
        cursor: pointer;
    }
    .form-check-label {
        margin-right: 12px;
    }
</style>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
@endsection
