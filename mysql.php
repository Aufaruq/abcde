<?php
// Informasi koneksi database
$host = 'localhost'; // Host database (biasanya 'localhost')
$user = 'root'; // Nama pengguna database
$password = ''; // Kata sandi pengguna database
$database = 'ukk_pengaduan'; // Nama database

// Membuat koneksi ke database
$conn = mysqli_connect($host, $user, $password, $database);

// Memeriksa koneksi
if (!$conn) {
    // Jika koneksi gagal, tampilkan pesan error di konsol
    echo "<script>console.error('Koneksi gagal: " . mysqli_connect_error() . "');</script>";
} else {
    // Jika koneksi berhasil, tampilkan pesan sukses di konsol
    echo "<script>console.log('Koneksi berhasil');</script>";
}
?>
