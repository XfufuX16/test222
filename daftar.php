<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story | Daftar</title>
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

    .btnDaftar {
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

    .btnDaftar:hover {
        background: #228941; /* Warna hijau cerah saat dihover */
    }
</style>

</head>

<body>
    <fieldset>
        <legend>Daftar</legend>
        <form method="post" action="daftar.php" autocomplete="off">
            <label>User ID:</label><br>
            <input type="text" name="userid" required><br><br>

            <label>Name:</label><br>
            <input type="text" name="user" required><br><br>

            <label>Password:</label><br>
            <input type="password" name="pass" required><br><br>
            <label>Konfirmasi Password:</label><br>
            <input type="password" name="konfpass" required><br><br>

            <button name="daftar" class="btnDaftar">Daftar</button>
        </form>
    </fieldset><br><br>

    <?php
        if (isset($_POST['daftar'])) {
            $con = new mysqli("localhost","root","","story");

		    $userid = $_POST['userid'];
            $user = htmlentities(strip_tags($_POST['user']));
		    $pass = $_POST['pass'];
		    $konfpass = $_POST['konfpass'];

		    $salt = str_shuffle("ProjectUTS");

		    if ($pass === $konfpass) {
			    $md5pass = md5($pass);
			    $combinepass = $md5pass . $salt;
			    $finalpass = md5($combinepass);

			    $sql = "INSERT INTO users VALUES(?,?,?,?)";
			    $stmt = $con->prepare($sql);
			    $stmt->bind_param("ssss", $userid, $user, $finalpass, $salt);
			    $stmt->execute();

			    if (!$stmt->error) {
                    echo "Pendaftaran user berhasil.";
                } else {
                    echo "Pendaftaran user gagal.";
                }
		    } else {
			    echo "Password tidak sama.";
            }

		    $con->close();
        }
    ?>
</body>

</html>