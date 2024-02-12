<?php
session_start();
require_once "mysql.php"; // Memasukkan file mysql.php untuk koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan validasi login untuk petugas
    $sql_petugas = "SELECT * FROM petugas WHERE username = ? AND password = ?";
    $stmt_petugas = mysqli_prepare($conn, $sql_petugas);
    mysqli_stmt_bind_param($stmt_petugas, "ss", $username, $password);
    mysqli_stmt_execute($stmt_petugas);
    $result_petugas = mysqli_stmt_get_result($stmt_petugas);

    // Jika login sebagai petugas berhasil
    if (mysqli_num_rows($result_petugas) == 1) {
        $user = mysqli_fetch_assoc($result_petugas);
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit;
    } else {
        // Jika login gagal, tampilkan pesan error
        echo '<script>alert("Login petugas gagal. Periksa kembali username dan password Anda");</script>';
    }

    mysqli_stmt_close($stmt_petugas);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas</title>

    <link rel="stylesheet" href="css/re-log.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>
    <div class="container log">
        <h2 class="title">Login Petugas</h2>
        <div class="box-1">
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>