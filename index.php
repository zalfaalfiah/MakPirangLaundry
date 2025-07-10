<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles/index.css">
</head>

<body>
    <div class="login-dashboard">
        <div class="login-container">
            <div class="login-form-section">
                <div class="login-form-wrapper">
                    <div class="main-content">
                        <div class="judul-apk">
                            <div class="logo">
                                <img class="logo-img" src="images/logo.png">
                            </div>
                            <div class="judul">
                                <h2>Mak Pirang Laundry</h2>
                                <h2 class="selamat-datang">Selamat Datang!</h2>
                            </div>
                        </div>
                        <p>Silahkan Masukkan Username dan Password Anda</p>
                        <form id="loginForm" class="input-form">
                            <label for="username">Username</label>
                            <input placeholder="Masukkan Username" type="text" name="username" id="username"
                                required><br>
                            <label for="password">Password</label>
                            <input placeholder="Masukkan Password" type="password" name="password" id="password"
                                required><br>
                            <button type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="hero-section">
                <img src="images/hero-img.jpg">
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#loginForm').on('submit', function (event) {
                event.preventDefault();

                const formData = {
                    username: $('#username').val(),
                    password: $('#password').val(),
                };

                $.ajax({
                    url: 'auth.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.trim() === 'success') {
                            window.location.href = 'beranda.php';
                        } else {
                            alert(response);
                        }
                    },
                    error: function () {
                        alert('Terjadi kesalahan pada server.');
                    },
                });
            });
        });
    </script>
</body>

</html>