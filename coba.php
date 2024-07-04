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
    <link rel="stylesheet" href="layout.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="scripts.js"></script>
    <title>Story Categories</title>
</head>
<body>
	<div class="container">
        <div class="combobox-container">
            <label for="category-dropdown">Pilih Kategori:</label>
            <select id="category-dropdown">
                <option value="Ceritaku">Ceritaku</option>
                <option value="Kumpulan Cerita">Kumpulan Cerita</option>
            </select>
        </div>
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
	        $sql = "SELECT * FROM cerita WHERE judul LIKE ?";
	        $stmt = $con->prepare($sql);
	        $stmt->bind_param("s", $search);
	        $stmt->execute();
	        $result = $stmt->get_result();

	        $perpage = 4;
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

	        $sql2 = "SELECT * FROM users";
            $result2 = $con->query($sql2);
            while ($row2 = $result2->fetch_assoc()) {
            	if($row2['nama'] == $username){
            		$idactive = $row2['idusers'];
            	}
            }
            echo "<div class='left-section'>";
            echo "<h1>Kumpulan Cerita</h1>";
            echo "<div id='kumpulan-cerita' class='story-container'></div>";

	        while ($row = $result->fetch_assoc()) {
	        	if($row['idusers_pembuat_awal'] != $idactive){
	        		$sql3 = "SELECT U.nama FROM users as U INNER JOIN cerita as C ON U.idusers=C.idusers_pembuat_awal WHERE C.idcerita=" . $row['idcerita'];
            		$result3 = $con->query($sql3);
            		while ($row3 = $result3->fetch_assoc()) {
                		$pembuat = $row3['nama'] . "<br>";
            		}
            		echo "<div class='card'>";
            		echo "<h2>".$row['judul']."</h2>";
            		echo "<p>Pemilik Cerita:$pembuat</p>";
            		echo "<p>jumlah paragraf: </p>";
            		echo "<p>baca selanjutnya</p>";
            	}
	        }
	        
	        echo "<button id='load-more-kumpulan-cerita' class='load-more-btn'>Tampilkan Cerita Selanjutnya</button>";
	        echo "</div>";
	        
	        echo "<div class='right-section'>";
            echo "<h1>Ceritaku</h1>";
            echo "<div id='ceritaku' class='story-container'></div>";
	        while ($row = $result->fetch_assoc()) {
	        	if($row['idusers_pembuat_awal'] == $idactive){
                	echo "<div class='card'>";
            		echo "<h2>".$row['judul']."</h2>";
            		echo "<p>jumlah paragraf: </p>";
            		echo "<p>baca selanjutnya</p>";
	        	}
	        }
	        
	        echo "<button id='load-more-kumpulan-cerita' class='load-more-btn'>Tampilkan Cerita Selanjutnya</button>";
	        echo "</div>";
	    ?>
    </div>
</body>
</html>
