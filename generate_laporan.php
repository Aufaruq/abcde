<?php
// Koneksi ke database
require_once "mysql.php";

// Query untuk mengambil data pengaduan dan tanggapan
$sql = "SELECT pengaduan.*, tanggapan.tanggapan, tanggapan.tgl_tanggapan, tanggapan.id_petugas 
        FROM pengaduan 
        LEFT JOIN tanggapan ON pengaduan.id_pengaduan = tanggapan.id_pengaduan";
$result = mysqli_query($conn, $sql);

// Buat struktur laporan
$laporan = [];
while ($row = mysqli_fetch_assoc($result)) {
    $laporan[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <link rel="stylesheet" href="css/generate.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="head">
            <h2>Laporan Pengaduan Masyarakat</h2>
            <a href="index.php">Kembali</a>
        </div>

        <table class="table table-bordered border table-hover">
            <tr>
                <th>ID Pengaduan</th>
                <th>Tanggal Pengaduan</th>
                <th>NIK</th>
                <th>Isi Laporan</th>
                <th>Foto</th>
                <th>Status Tanggapan</th>
                <th>Tanggapan</th>
                <th>Tanggal Tanggapan</th>
                <th>ID Petugas</th>
            </tr>
            <?php
            foreach ($laporan as $data) { ?>
                <tr>
                    <td><?php echo $data['id_pengaduan'] ?></td>
                    <td><?php echo $data['tgl_pengaduan'] ?></td>
                    <td><?php echo $data['nik'] ?></td>
                    <td><?php echo $data['isi_laporan'] ?></td>
                    <td><img src="uploads/<?php echo $data['foto'] ?>" style="height:100px; width:120px;" alt=""></td>
                    <td><?php echo $data['status'] ?></td>
                    <td><?php echo $data['tanggapan'] ?></td>
                    <td><?php echo $data['tgl_tanggapan'] ?></td>
                    <td><?php echo $data['id_petugas'] ?></td>
                </tr>
            <?php } ?>
        </table>

        <?php
        // Tutup koneksi ke database
        mysqli_close($conn);
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>