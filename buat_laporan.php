<?php
session_start();
require_once "mysql.php"; // Memasukkan file mysql.php untuk koneksi ke database

if (!isset($_SESSION['user']) || (isset($_SESSION['user']['level']) && ($_SESSION['user']['level'] == 'admin' || $_SESSION['user']['level'] == 'petugas'))) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $laporan = $_POST['laporan'];
    $nik = $_SESSION['user']['nik']; // Ambil NIK pengguna dari sesi

    // Cek apakah file telah diunggah
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $nama_file = $_FILES['foto']['name']; // Nama file yang diunggah oleh pengguna
        $lokasi_file = $_FILES['foto']['tmp_name']; // Lokasi file sementara yang diunggah oleh pengguna
        $lokasi_simpan = 'uploads/' . $nama_file; // Lokasi di server untuk menyimpan file
        $status = '0'; // Status default '0'

        // Simpan file yang diunggah ke folder yang diinginkan
        if (move_uploaded_file($lokasi_file, $lokasi_simpan)) {
            // Simpan laporan ke database
            $sql = "INSERT INTO pengaduan (tgl_pengaduan, nik, isi_laporan, foto, status) VALUES (NOW(), ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $nik, $laporan, $nama_file, $status);

            if (mysqli_stmt_execute($stmt)) {
                // Jika penyimpanan berhasil, tampilkan pesan sukses
                echo "Laporan berhasil disimpan!";
            } else {
                // Jika gagal, tampilkan pesan error
                echo "Terjadi kesalahan saat menyimpan laporan: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Gagal menyimpan file.";
        }
    } else {
        echo "File tidak diunggah atau terdapat kesalahan saat mengunggah file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan Pengaduan</title>
    <link rel="stylesheet" href="css/laporan.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>
    <div class="container items">
        <h2 style=" display: flex; justify-content: center; margin-bottom:3rem; font-size: 4.3rem; color:#fff; text-shadow: 0 2px 3px green; font-weight:600;">Buat Laporan Pengaduan</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form">
                <label for="laporan">Laporan</label><br>
                <textarea name="laporan" id="laporan" cols="30" rows="10" required></textarea><br>
                <input class="file" type="file" name="foto" required><br>
            </div>

            <!-- Input file untuk unggah foto -->
            <button style="border-radius:8px; margin-top: 2rem;" type="submit">Kirim</button>
            <button style="border-radius:8px; margin-top: 2rem; margin-left:1rem;" href="index.php">Kembali</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>