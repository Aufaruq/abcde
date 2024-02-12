<?php
session_start();
require_once "mysql.php"; // Include your database connection file

// Check if the user is logged in and is a petugas
if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
    header("Location: index.php");
    exit;
}

// Process the response
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pengaduan = $_POST['id_pengaduan'];
    $tanggapan = $_POST['tanggapan'];
    $id_petugas = $_SESSION['user']['id_petugas'];

    // Insert the response into the 'tanggapan' table
    $sql = "INSERT INTO tanggapan (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) VALUES (?, NOW(), ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isi", $id_pengaduan, $tanggapan, $id_petugas);

    if (mysqli_stmt_execute($stmt)) {
        // If insertion is successful, show success message
        echo "Tanggapan berhasil disimpan.";
    } else {
        // If there's an error, show error message
        echo "Terjadi kesalahan saat menyimpan tanggapan: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

// Fetch data of pengaduan from the database
$sql = "SELECT * FROM pengaduan";
$result = mysqli_query($conn, $sql);

// If there are pengaduan available
if ($result && mysqli_num_rows($result) > 0) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Beri Tanggapan</title>
        <link rel="stylesheet" href="css/tanggapan.css">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    </head>

    <body>
        <div class="container">
            <div class="head">
                <h2>Beri Tanggapan</h2>
                <a href="index.php">Kembali</a> <!-- Link back to main page -->
            </div>
            <table class="table table-bordered border table-hover">
                <tr>
                    <th>ID Pengaduan</th>
                    <th>Tanggal Pengaduan</th>
                    <th>Nik</th>
                    <th>Isi Laporan</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <th>Tanggapan</th>
                </tr>
                <?php
                // Display pengaduan data in a table
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
                            <!-- Form to submit tanggapan -->
                            <div class="form">
                                <form action="" method="POST">
                                    <input type="hidden" name="id_pengaduan" value="<?php echo $row['id_pengaduan']; ?>">
                                    <textarea name="tanggapan" rows="4" cols="50" required></textarea>
                                    <button style="margin: 10px 0;border-radius: 8px;" type="submit">Submit</button>
                                </form>
                            </div>
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