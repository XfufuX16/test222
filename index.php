<?php
    session_start();

    require_once 'userclass.php';

    $user = new UserClass(); // Membuat objek UserClass

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['user'];
        $password = $_POST['pass'];

        if ($user->login($username, $password)) {
            // Login berhasil, arahkan ke halaman beranda atau halaman lain yang sesuai
            header('Location: tes.php');
            exit();
        } else {
            // Login gagal, tampilkan pesan kesalahan atau arahkan kembali ke halaman login
            echo 'Login gagal. Silakan coba lagi.';
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Story | Login</title>
    <style>
        body {
            background-color: #d3f5cf; /* Warna latar belakang hijau cerah */
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        fieldset {
            width: 300px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }

        legend {
            font-weight: bold;
            font-size: 24px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px -10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .btnLogin {
            background-color: #2db74f; /* Warna hijau cerah */
            border: none;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            font-size: 16px;
            border-radius: 5px;
            transition-duration: 0.4s;
            cursor: pointer;
        }

        .btnLogin:hover {
            background: #228941; /* Warna hijau cerah saat dihover */
        }
    </style>
</head>

<body>
    <fieldset>
        <legend>Login</legend>
        <form method="post" action="" autocomplete="off">
            <label>User:</label><br>
            <input type="text" name="user" required><br><br>

            <label>Password:</label><br>
            <input type="password" name="pass" required><br><br>

            <?php
                if (isset($_GET['redirect'])) {
                    $url = $_GET['redirect'];
                    echo "<input type='hidden' name='redirect' value='$url'>";
                }
            ?>

            <button name="login" class="btnLogin">Login</button>
        </form>
    </fieldset>
</body>

</html>