<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
require_once 'Pelanggan.php';

$pelanggan = new Pelanggan();
$sukses = "";
$error = "";
$tanggal = $nama_pelanggan = $tipe_servis = $berat = $harga = $jenis_pembayaran = $kontak = "";

$op = isset($_GET['op']) ? $_GET['op'] : '';

if (isset($_GET['op'])) {
    if ($op == 'delete') {
        $id = intval($_GET['id']);
        if ($pelanggan->deleteData($id)) {
            $sukses = "Data berhasil dihapus.";
        } else {
            $error = "Gagal menghapus data.";
        }
    }

    if ($op == 'edit') {
        $id = intval($_GET['id']);
        $data = $pelanggan->getDataById($id);
        if ($data) {
            $tanggal = $data['tanggal'];
            $nama_pelanggan = $data['nama_pelanggan'];
            $tipe_servis = $data['tipe_servis'];
            $berat = $data['berat'];
            $harga = $data['harga'];
            $jenis_pembayaran = $data['jenis_pembayaran'];
            $kontak = $data['kontak'];
        } else {
            $error = "Data tidak ditemukan.";
        }
    }
}

if (isset($_POST['simpan'])) {
    $tanggal = $_POST['tanggal'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $tipe_servis = $_POST['tipe_servis'];
    $berat = $_POST['berat'];
    $harga = $_POST['harga'];
    $jenis_pembayaran = $_POST['jenis_pembayaran'];
    $kontak = $_POST['kontak'];
    $total_harga = floatval($berat) * floatval($harga);

    if ($tanggal && $nama_pelanggan && $tipe_servis && $berat && $harga && $jenis_pembayaran && $kontak) {
        if ($op == 'edit') {
            $id = $_GET['id'];
            if ($pelanggan->updateData($id, $tanggal, $nama_pelanggan, $tipe_servis, $berat, $harga, $jenis_pembayaran, $kontak, $total_harga)) {
                $sukses = "Data berhasil diupdate.";
            } else {
                $error = "Data gagal diupdate.";
            }
        } else {
            if ($pelanggan->tambahData($tanggal, $nama_pelanggan, $tipe_servis, $berat, $harga, $jenis_pembayaran, $kontak, $total_harga)) {
                $sukses = "Data berhasil disimpan.";
            } else {
                $error = "Gagal menyimpan data.";
            }
        }
    } else {
        $error = "Silakan isi semua data.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/pesanan.css">
</head>

<body>
    <header>
        <div class="logo-header">
            <img src="images/logo.png" alt="">
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
                <h2>DATA PELANGGAN</h2>
            </div>
            <div class="input-data">
                <div class="pesan-container">
                    <?php if ($error): ?>
                        <div class="pesan-error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if ($sukses): ?>
                        <div class="pesan-sukses"><?php echo $sukses; ?></div>
                    <?php endif; ?>
                </div>

                <form action="" method="POST">
                    <div class="input1">
                        <label for="tanggal">Tanggal</label>
                        <input class="input-tanggal" type="date" id="tanggal" name="tanggal"
                            value="<?php echo $tanggal; ?>" required><br>

                        <label for="tipe_servis">Tipe Servis</label>
                        <select id="tipe_servis" name="tipe_servis" required>
                            <option value="">- Pilih Tipe Servis -</option>
                            <option value="cks" <?php echo $tipe_servis == "cks" ? "selected" : ""; ?>>CKS</option>
                            <option value="cl" <?php echo $tipe_servis == "cl" ? "selected" : ""; ?>>CL</option>
                            <option value="js" <?php echo $tipe_servis == "js" ? "selected" : ""; ?>>JS</option>
                        </select><br>

                        <label for="harga">Harga</label>
                        <input type="number" id="harga" name="harga" value="<?php echo $harga; ?>" required><br>

                        <label for="kontak">Kontak</label>
                        <input type="text" id="kontak" name="kontak" value="<?php echo $kontak; ?>" required><br>
                    </div>

                    <div class="input2">
                        <label for="nama_pelanggan">Nama Pelanggan</label>
                        <input type="text" id="nama_pelanggan" name="nama_pelanggan"
                            value="<?php echo $nama_pelanggan; ?>" required><br>

                        <label for="berat">Berat (kg)</label>
                        <input type="number" id="berat" name="berat" value="<?php echo $berat; ?>" required><br>

                        <label for="jenis_pembayaran">Jenis Pembayaran</label>
                        <select id="jenis_pembayaran" name="jenis_pembayaran" required>
                            <option value="">- Pilih Jenis Pembayaran -</option>
                            <option value="e-wallet" <?php echo $jenis_pembayaran == "e-wallet" ? "selected" : ""; ?>>
                                E-Wallet</option>
                            <option value="bank" <?php echo $jenis_pembayaran == "bank" ? "selected" : ""; ?>>Bank
                            </option>
                            <option value="tunai" <?php echo $jenis_pembayaran == "tunai" ? "selected" : ""; ?>>Tunai
                            </option>
                        </select><br>

                        <label for="total_harga">Total Harga</label>
                        <input type="number" id="total_harga" name="total_harga" value="<?php echo $total_harga; ?>"
                            readonly><br>
                    </div>
                    <button class="simpan-button" type="submit" name="simpan">Simpan</button>
                </form>
            </div>

            <div class="tabel-status">
                <table border="1">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Nama Pelanggan</th>
                            <th scope="col">Tipe Servis</th>
                            <th scope="col">Berat (kg)</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jenis Pembayaran</th>
                            <th scope="col">Kontak</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = $pelanggan->getAllData();
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($data)) {
                            $id = $r2['id'];
                            $tanggal = $r2['tanggal'];
                            $nama_pelanggan = $r2['nama_pelanggan'];
                            $tipe_servis = $r2['tipe_servis'];
                            $berat = $r2['berat'];
                            $harga = $r2['harga'];
                            $jenis_pembayaran = $r2['jenis_pembayaran'];
                            $kontak = $r2['kontak'];
                            $total_harga = $r2['total_harga'];
                            ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td><?php echo $tanggal ?></td>
                                <td><?php echo $nama_pelanggan ?></td>
                                <td><?php echo $tipe_servis ?></td>
                                <td><?php echo $berat ?></td>
                                <td><?php echo $harga ?></td>
                                <td><?php echo $jenis_pembayaran ?></td>
                                <td><?php echo $kontak ?></td>
                                <td><?php echo $total_harga ?></td>
                                <td>
                                    <form action="pesanan.php" method="GET" style="display:inline;">
                                        <input type="hidden" name="op" value="edit">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <button type="submit" class="edit-button">Edit</button>
                                    </form>
                                    <form action="pesanan.php" method="GET" style="display:inline;"
                                        onsubmit="return confirm('Yakin mau hapus data?')">
                                        <input type="hidden" name="op" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <button type="submit" class="delete-button">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
        function hitungTotalHarga() {
            var berat = document.getElementById("berat").value;
            var harga = document.getElementById("harga").value;

            if (berat && harga) {
                var total_harga = berat * harga;
                document.getElementById("total_harga").value = total_harga;
            } else {
                document.getElementById("total_harga").value = "";
            }
        }

        document.getElementById("berat").addEventListener("input", hitungTotalHarga);
        document.getElementById("harga").addEventListener("input", hitungTotalHarga);
    </script>
</body>

</html>