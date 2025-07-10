<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

include 'database.php';

$db = new Database();
$conn = $db->getConnection();

$search = "";
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
}

$query = "SELECT id, nama_pelanggan, tipe_servis, tanggal, total_harga FROM data_pelanggan WHERE status = 'Selesai'";
if (!empty($search)) {
    $query .= " AND (nama_pelanggan LIKE '%$search%' OR tipe_servis LIKE '%$search%' OR tanggal LIKE '%$search%')";
}
$query .= " ORDER BY id ASC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/riwayat.css">
</head>

<body>
    <header>
        <div class="logo-header">
            <img src="images/logo.png">
            <h3>Mak Pirang Laundry</h3>
        </div>
        <nav>
            <ul class="navbar">
                <li><a href="beranda.php"
                        class="<?php if (basename($_SERVER['PHP_SELF']) == 'beranda.php')
                            echo 'active'; ?>">Beranda</a>
                </li>
                <li><a href="pesanan.php"
                        class="<?php if (basename($_SERVER['PHP_SELF']) == 'pesanan.php')
                            echo 'active'; ?>">Pesanan</a>
                </li>
                <li><a href="riwayat.php"
                        class="<?php if (basename($_SERVER['PHP_SELF']) == 'riwayat.php')
                            echo 'active'; ?>">Riwayat</a>
                </li>
                <li><a href="logout.php"
                        class="<?php if (basename($_SERVER['PHP_SELF']) == 'logout.php')
                            echo 'active'; ?>">Logout</a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="container">
            <div class="judul">
                <i class="fa-solid fa-shirt ikon"></i>
                <h2>RIWAYAT PEMESANAN</h2>
            </div>
            <form method="POST" action="">
                <div class="search-bar">
                    <input type="text" name="search" placeholder="Search Data..."
                        value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit">Search</button>
                </div>
            </form>
            <div class="tabel-riwayat">
                <table border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Pelanggan</th>
                            <th>Tipe Servis</th>
                            <th>Tanggal</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1;
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $counter++; ?></td>
                                <td><?php echo $row['nama_pelanggan']; ?></td>
                                <td><?php echo $row['tipe_servis']; ?></td>
                                <td><?php echo $row['tanggal']; ?></td>
                                <td><?php echo $row['total_harga']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>