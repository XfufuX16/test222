<?php
session_start();

$id = $_SESSION['id'];

// Sesuaikan dengan konfigurasi database Anda
$con = new mysqli("localhost", "root", "", "story");

if ($con->connect_errno) {
    die("Connect Failed: " . $con->connect_error);
}

$perpage = 4; // Jumlah cerita per halaman

if (isset($_POST['category']) && isset($_POST['page'])) {
    $category = $_POST['category'];
    $page = $_POST['page'];
    $start = ($page - 1) * $perpage;

    $sql = ($category === 'kumpulan') ?
        "SELECT * FROM cerita LIMIT $start, $perpage" :
        "SELECT * FROM cerita WHERE idusers_pembuat_awal = $id LIMIT $start, $perpage";

    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Tampilkan data cerita sesuai kebutuhan
            echo '<div class="card"><h5>' . $row['judul'] . '</h5>';
            if($category == 'kumpulan'){
                // Ambil nama pembuat milik orang lain
                $sql2 = "SELECT U.nama FROM users as U INNER JOIN cerita as C ON U.idusers=C.idusers_pembuat_awal WHERE C.idcerita=" . $row['idcerita'];
                $result2 = $con->query($sql2);
                while ($row2 = $result2->fetch_assoc()) {
                    echo "<p>Nama Pembuat: ".$row2['nama']."</p>";
                }
            }
            // Jumlah paragraf
            $sql3 = "SELECT isi_paragraf FROM paragraf WHERE idcerita =".$row['idcerita'];
            $result3 = $con->query($sql3);
            while ($row3 = $result3->fetch_assoc()) {
                $paragraf = $row3['isi_paragraf'];
            }
            $paragraphs = explode('<br><br>', $paragraf);
            $par_count = count($paragraphs);
            echo "<p>Jumlah paragraf: $par_count</p>";
            echo "</div>";
        }
    } else {
        echo 'Tidak ada cerita.';
    }
} else {
    echo 'Parameter tidak sesuai.';
}

$con->close();
?>