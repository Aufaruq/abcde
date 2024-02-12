<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$pesan = '';

if (isset($_SESSION['user']['level'])) {
    if ($_SESSION['user']['level'] == 'admin') {
        $pesan = "Anda login sebagai admin";
    } elseif ($_SESSION['user']['level'] == 'petugas') {
        $pesan = "Anda login sebagai petugas";
    }
} else {
    $pesan = "Anda login sebagai masyarakat";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/index.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


</head>

<body style="height:100vh !important;">
    <div class="container items">
        <h2 style="font-family: 'Roboto Condense', sans-serif;">
            <?php if (!empty($pesan)) : ?>
                <p><?php echo $pesan; ?></p>
            <?php endif; ?>
        </h2>

        <div class="box">
            <div class="icon">
                <i class="ri-user-settings-line"></i>
            </div>
            <div class="tombol">
                <?php if (isset($_SESSION['user'])) : ?>
                    <ul>
                        <li>
                            <a href="buat_laporan.php">Buat Laporan Pengaduan</a>
                            <a href="verifikasi_validasi.php">Verifikasi dan Validasi Laporan</a>
                        </li>
                        <li>
                            <a href="beri_tanggapan.php">Beri Tanggapan</a>
                            <a href="generate_laporan.php">Generate Laporan</a>
                        </li>
                    </ul>
                    <ul>
                        <li class="logout" style="width:fit-content; align-self:end;">
                            <a href="logout.php">Logout</a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>