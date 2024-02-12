<?php
session_start();
require_once "mysql.php"; // Memasukkan file mysql.php untuk koneksi ke database

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan validasi login untuk masyarakat
    $sql_masyarakat = "SELECT * FROM masyarakat WHERE username = ? AND password = ?";
    $stmt_masyarakat = mysqli_prepare($conn, $sql_masyarakat);
    mysqli_stmt_bind_param($stmt_masyarakat, "ss", $username, $password);
    mysqli_stmt_execute($stmt_masyarakat);
    $result_masyarakat = mysqli_stmt_get_result($stmt_masyarakat);

    // Jika login sebagai masyarakat berhasil
    if (mysqli_num_rows($result_masyarakat) == 1) {
        $user = mysqli_fetch_assoc($result_masyarakat);
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit;
    } else {
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
            echo '<script>alert("Login gagal. Periksa kembali username dan password Anda")</script>';
        }
    }

    mysqli_stmt_close($stmt_masyarakat);
    mysqli_stmt_close($stmt_petugas);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- JS -->
    <script src="https://unpkg.com/scrollreveal"></script>
    <script defer src="reveal.js"></script>

</head>

<body style="height:100vh;" class=" d-flex">
    <div class="container cont align-self-center">
        <h1>Pengaduan Masyarakat</h1>
        <div class="form justify-content-around">
            <div class="box login side-1">
                <h2 style="margin-bottom: 2rem; font-weight:700; text-align:center;">Login Masyarakat</h2>
                <form action="" method="POST">
                    <label for="username">Username</label>
                    <input type="text" name="username" required><br>
                    <label for="password">Password</label>
                    <input type="password" name="password" required><br>
                    <div class="button">
                        <button style="margin-top:18px; border-radius:8px;" type="submit">Login</button>
                    </div>
                </form>
            </div>

            <div class="box login side-2">
                <h2 style="margin-bottom: 2rem; font-weight:700; text-align:center;">Login Petugas</h2>
                <form action="login_petugas.php" method="POST">
                    <label for="username">Username</label>
                    <input type="text" name="username" required><br>
                    <label for="password">Password</label>
                    <input type="password" name="password" required><br>
                    <div class="button">
                        <button style="margin-top:18px; border-radius:8px;" type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        ScrollReveal({
            reset: true
        });

        ScrollReveal().reveal('.login h2', {
            origin: 'top',
            delay: 600,
            duration: 1200,
            distance: '30px',
            interval: 100,
        });

        ScrollReveal().reveal('.login label, .login input, .login button', {
            origin: 'bottom',
            delay: 600,
            duration: 1200,
            distance: '80px',
            interval: 90,
        });

        ScrollReveal().reveal('.cont h1, .form .box', {
            origin: 'left',
            delay: 400,
            duration: 1000,
            distance: '120px',
            interval: 150,
        });
    </script>
</body>

</html>