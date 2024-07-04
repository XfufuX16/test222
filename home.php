<?php
    session_start();

    require_once 'storyclass.php';

    $username = $_SESSION['user'];

    if (isset($_SESSION['user'])) {
        echo "<strong>Welcome, " . $_SESSION['user'] . "</strong><br>"; 
    } else {
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story | Home</title>
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

        .btnCari, .btnCerita, .btnLogout {
            background-color: #2db74f; /* Warna hijau cerah */
            border: none;
            color: #fff;
            padding: 8px 10px;
            text-align: center;
            font-size: 14px;
            border-radius: 6px;
            transition-duration: 0.4s;
            text-decoration: none;
            margin: 10px 0;
        }

        .btnLogout {
            position: absolute;
            top: 0; /* Tombol Logout akan berada di pojok kanan atas */
            right: 20px; /* Jarak dari tepi kanan */
        }

        .btnCari {
            margin-left: 20px;
        }

        .btnCari:hover, .btnCerita:hover, .btnLogout:hover {
            background: #228941; /* Warna hijau cerah saat dihover */
        }

        li {
            display: inline-block;
            width: 20px;
        }

        table {
            background-color: #fff;
            border-collapse: collapse;
            width: 80%;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #2db74f; /* Warna hijau cerah */
            color: #fff;
        }
    </style>
</head>

<body>
    <?php
        $con = new mysqli("localhost", "root", "", "story");

        if ($con->connect_errno) {
            die("Connect Failed: " . $con->connect_error);
        }

        if (isset($_GET['key'])) {
            $search = "%" . $_GET['key'] . "%";
        } else {
            $search = "%";
        }

        echo "<br>";

        if (isset($_GET['key'])) {
            $key = $_GET['key'];
        } else {
            $key = "";
        }

        echo "<form	method='GET' action='home.php'>";
        echo "<label><strong>Cari judul : </strong></label><input type='text' name='key' value='$key' autocomplete='off'>";
        echo "<button name='submit' class='btnCari'>Cari</button>";
        echo "</form><br>";

        echo "<a href='addstory.php' class='btnCerita'>Buat Cerita Baru</a>";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "<a href='logout.php' class='btnLogout'>Logout</a>";

        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>Judul</th>";
        echo "<th>Pembuat Awal</th>";
        echo "<th>Aksi</th>";
        echo "</tr>";

        //TOTAL DATA 
        $sql = "SELECT * FROM cerita WHERE judul LIKE ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $result = $stmt->get_result();

        $perpage = 3;
        $totaldata = $result->num_rows;
        $totalpage = ceil($totaldata / $perpage);

        //DATA WITH LIMIT
        if (isset($_GET['p'])) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }

        $start = ($p - 1) * $perpage;

        $sql = "SELECT * FROM cerita WHERE judul LIKE ? LIMIT ?,?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sii", $search, $start, $perpage);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo "<td>" . $row['judul'] . "</td>";
            echo "<td>";
            $sql2 = "SELECT U.nama FROM users as U INNER JOIN cerita as C ON U.idusers=C.idusers_pembuat_awal WHERE C.idcerita=" . $row['idcerita'];
            $result2 = $con->query($sql2);

            while ($row2 = $result2->fetch_assoc()) {
                echo $row2['nama'] . "<br>";
            }
            echo "</td>";

            $idcerita = $row['idcerita'];
            echo "<td><a href = 'viewstory.php?id=$idcerita'>Edit</td></tr>";
        }

        echo "</table>";
        //View Halaman
        echo "<ul>";
        for ($i = 1; $i <= $totalpage; $i++) {
            echo "<li><a href='home.php?p=$i&key=$key'>$i</a></li>";
        }
        echo "</ul>";

    ?>
</body>

</html>