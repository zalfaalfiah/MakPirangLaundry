<?php
class Pelanggan
{
    private $koneksi;

    public function __construct()
    {
        require_once 'Database.php';
        $db = new Database();
        $this->koneksi = $db->getConnection();
    }

    public function tambahData($tanggal, $nama_pelanggan, $tipe_servis, $berat, $harga, $jenis_pembayaran, $kontak, $total_harga)
    {
        $sql = "INSERT INTO data_pelanggan (tanggal, nama_pelanggan, tipe_servis, berat, harga, jenis_pembayaran, kontak, total_harga) 
                VALUES ('$tanggal', '$nama_pelanggan', '$tipe_servis', '$berat', '$harga', '$jenis_pembayaran', '$kontak', '$total_harga')";
        return mysqli_query($this->koneksi, $sql);
    }

    public function updateData($id, $tanggal, $nama_pelanggan, $tipe_servis, $berat, $harga, $jenis_pembayaran, $kontak, $total_harga)
    {
        $sql = "UPDATE data_pelanggan SET tanggal='$tanggal', nama_pelanggan='$nama_pelanggan', tipe_servis='$tipe_servis', 
                berat='$berat', harga='$harga', jenis_pembayaran='$jenis_pembayaran', kontak='$kontak', total_harga='$total_harga' 
                WHERE id='$id'";
        return mysqli_query($this->koneksi, $sql);
    }

    public function deleteData($id)
    {
        $sql = "DELETE FROM data_pelanggan WHERE id='$id'";
        return mysqli_query($this->koneksi, $sql);
    }

    public function getDataById($id)
    {
        $sql = "SELECT * FROM data_pelanggan WHERE id='$id'";
        $result = mysqli_query($this->koneksi, $sql);
        return mysqli_fetch_array($result);
    }

    public function getAllData()
    {
        $sql = "SELECT * FROM data_pelanggan ORDER BY id DESC";
        return mysqli_query($this->koneksi, $sql);
    }
}
?>