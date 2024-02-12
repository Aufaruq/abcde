<?php
session_start();
require_once "mysql.php"; // Memasukkan file mysql.php untuk koneksi ke database

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// Cek apakah user memiliki hak akses untuk registrasi
if (isset($_SESSION['user']) && $_SESSION['user']['level'] == 'petugas') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Proses registrasi
    // Gunakan prepared statement untuk menghindari serangan SQL injection
    $sql = "INSERT INTO masyarakat (nik, nama, username, password) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $nik, $nama, $username, $password);

    if (mysqli_stmt_execute($stmt)) {
        // Registrasi berhasil
        echo '<script>Alert("Registrasi berhasil!")</script>';
    } else {
        // Registrasi gagal
        echo '<script>Alert("Registrasi gagal:  '. mysqli_error($conn).'")</script>';
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>

    <link rel="stylesheet" href="css/re-log.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <h2>Registrasi</h2>
        <div class="box-1">
            <form action="" method="POST">
                <label for="nik">NIK:</label><br>
                <input type="text" name="nik" required><br>
                <label for="nama">Nama:</label><br>
                <input type="text" name="nama" required><br>
                <label for="username">Username:</label><br>
                <input type="text" name="username" required><br>
                <label for="password">Password:</label><br>
                <input type="password" name="password" required><br>
                <button type="submit">Register</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>