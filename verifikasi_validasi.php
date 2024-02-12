<?php
session_start();
require_once "mysql.php"; // Memasukkan file mysql.php untuk koneksi ke database

// Periksa apakah pengguna telah masuk atau memiliki tingkat akses yang sesuai
if (
    !isset($_SESSION['user']) ||
    !isset($_SESSION['user']['level']) ||
    $_SESSION['user']['level'] != 'petugas'
) {
    header("Location: index.php");
    exit;
}

// Proses verifikasi dan validasi laporan
if (
    $_SERVER['REQUEST_METHOD'] == 'POST'
    && isset(
        $_POST['id_pengaduan'],
        $_POST['aksi']
    )
) {
    $id_pengaduan = $_POST['id_pengaduan'];
    $aksi = $_POST['aksi'];

    // Lakukan verifikasi atau validasi laporan sesuai dengan aksi yang dipilih
    // Misalnya, update status laporan menjadi 'proses' atau 'selesai' di database
    $sql = "UPDATE pengaduan SET status = ? WHERE id_pengaduan = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $aksi, $id_pengaduan);

    if (mysqli_stmt_execute($stmt)) {
        // Jika update berhasil, tampilkan pesan sukses
        echo '<script>alert("Verifikasi atau Validasi laporan berhasil");</script>';
    } else {
        // Jika gagal, tampilkan pesan error
        echo '<script>alert("Terjadi kesalahan saat melakukan verifikasi/validasi laporan: ' . mysqli_error($conn) . '");</script>';
    }
    mysqli_stmt_close($stmt);
}

// Ambil data laporan pengaduan dari database
$sql = "SELECT * FROM pengaduan";
$result = mysqli_query($conn, $sql);

// Jika query berhasil dijalankan
if ($result && mysqli_num_rows($result) > 0) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verifikasi dan Validasi Laporan</title>
        <link rel="stylesheet" href="css/generate.css">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    </head>

    <body>
        <div class="container">
            <div class="head">
                <h2>Verifikasi dan Validasi Laporan</h2>
                <a href="index.php">Kembali</a> <!-- Tombol kembali ke halaman index.php -->
            </div>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>ID Pengaduan</th>
                    <th>Tanggal Pengaduan</th>
                    <th>Nik</th>
                    <th>Isi Laporan</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                <?php
                // Tampilkan data laporan dalam bentuk tabel
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?php echo $row['id_pengaduan']; ?></td>
                        <td><?php echo $row['tgl_pengaduan']; ?></td>
                        <td><?php echo $row['nik']; ?></td>
                        <td><?php echo $row['isi_laporan']; ?></td>
                        <td><img src="uploads/<?php echo $row['foto']; ?>" width="100" height="100" alt="Foto"></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="id_pengaduan" value="<?php echo $row['id_pengaduan']; ?>">
                                <select name="aksi">
                                    <option value="proses">Verifikasi</option>
                                    <option value="selesai">Validasi</option>
                                </select>
                                <button style="border-radius:4px;" type="submit">Submit</button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    </body>

    </html>
<?php
} else {
    echo "Tidak ada laporan yang tersedia.";
}
?>