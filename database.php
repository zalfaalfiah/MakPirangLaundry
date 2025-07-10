<?php
class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "laundry";
    public $koneksi;

    public function __construct()
    {
        $this->koneksi = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->koneksi->connect_error) {
            die("Koneksi gagal: " . $this->koneksi->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->koneksi;
    }
}
?>