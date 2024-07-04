<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story | Tambah Paragraf</title>
    <style>
        body {
            background-color: #d3f5cf; /* Warna latar belakang hijau cerah */
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .btnSimpan {
            background-color: #2db74f; /* Warna hijau cerah */
            border: none;
            color: white;
            padding: 6px 8px;
            text-align: center;
            border-radius: 6px;
            transition-duration: 0.4s;
            text-decoration: none;
            margin-top: 10px;
        }

        .btnSimpan:hover {
            background: #228941; /* Warna hijau cerah saat dihover */
            color: #2db74f; /* Warna hijau saat dihover */
        }

        .btnBack {
            background-color: #2db74f; /* Warna hijau cerah */
            border: none;
            color: white;
            padding: 8px 10px;
            text-align: center;
            font-size: 14px;
            border-radius: 6px;
            transition-duration: 0.4s;
            text-decoration: none;
        }

        .btnBack:hover {
            background: #228941; /* Warna hijau cerah saat dihover */
            color: #2db74f; /* Warna hijau saat dihover */
        }
    </style>
</head>

<body>
    <?php
        $con = new mysqli("localhost", "root", "", "story");

        if ($con->connect_errno) {
            echo "Failed to connect to MySQL: " . $con->connect_error;
        } else {
            $idcerita = $_GET['id'];
            // echo "id cerita: " . $idcerita . "<br><br>";

            $sql = "SELECT isi_paragraf, idparagraf FROM paragraf WHERE idcerita=?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $idcerita);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                //Menampilkan id paragraf beserta isi
                $idparagraf = $row['idparagraf'];
                $paragraf = $row['isi_paragraf'];
            } else {
                echo "Invalid data";
            }

            // echo "id paragraf: " . $idparagraf . "<br>";

            $sql2 = "SELECT judul FROM cerita WHERE idcerita=?";
            $stmt2 = $con->prepare($sql2);
            $stmt2->bind_param("i", $idcerita);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            if ($row2 = $result2->fetch_assoc()) {
                // echo "Tampilkan data di form. Judul<br>";
            } else {
                echo "Invalid data";
            }
        }
    ?>

    <form method="post" action="viewstory_proses.php" autocomplete="off">
        <h1><?= $row2['judul'] ?></h1>
        <?php
            $text = $paragraf;
            $lines = explode("<br><br>", $text);

            foreach ($lines as $line) {
                echo "<p>$line</p>"; // Menampilkan setiap baris dalam HTML
            }
        ?>
        <!-- <p><?= $paragraf ?></p> --><br><br>

        <strong>Tambah Paragraf :</strong><br><br>
        <textarea name="paragrafbaru" cols="40" rows="8"></textarea><br>

        <input type="hidden" name="paragraf" value="<?= $paragraf ?>">
        <input type="hidden" name="idparagraf" value="<?= $row['idparagraf'] ?>">
        <button name="submit" class="btnSimpan">Simpan</button><br><br><br>
        <a href="home.php" class="btnBack">Back Home</a>
    </form>
</body>

</html>