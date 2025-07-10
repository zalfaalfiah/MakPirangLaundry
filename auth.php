<?php
session_start();
include 'Database.php';
include 'Authentication.php';

$database = new Database();
$conn = $database->getConnection();

$auth = new Authentication($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo 'Username dan password harus diisi.';
        exit;
    }

    $user_id = $auth->login($username, $password);

    if ($user_id) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user_id;
        echo 'success';
    } else {
        echo 'Login gagal. Periksa kembali username dan password Anda.';
    }
}
?>