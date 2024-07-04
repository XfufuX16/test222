<style>
    .btnBack {
        background-color: #2db74f;
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
        background: #228941;
        color: #2db74f;
    }

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
</style>

<?php
    $par_lama = $_POST['paragraf'];
    $par_baru = $_POST['paragrafbaru'];
    $par_final = $par_lama . "<br><br>" . $par_baru;
    $idparagraf = $_POST['idparagraf'];

    $con = new mysqli("localhost", "root", "", "story");

    if ($con->connect_errno) {
        echo "Failed to connect to MySQL: " . $con->connect_error;
    }

    $sql = "UPDATE paragraf SET isi_paragraf=? WHERE idparagraf=?";
    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $par_final, $idparagraf,);
        $stmt->execute();
        echo "Success tambah paragraf.<br>";
        $stmt->close();
    } else {
        echo "Error in preparing the statement: " . $con->error;
    }

    $con->close();
?>
<br>
<a href="home.php" class="btnBack">Back Home</a>