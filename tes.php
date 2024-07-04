<?php
    session_start();

    // require_once 'storyclass.php';

    $username = $_SESSION['user'];

    if (isset($_SESSION['user'])) {
        echo "<strong>Welcome, " . $_SESSION['user'] . "</strong><br>"; 
    } else {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerbung Page</title>
    <link rel="stylesheet" href="tes.css">
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
        <div class="left-section">
            <h1>Kumpulan Cerita</h1>
            <div id="kumpulan-cerita" class="cerita-container"></div>
            <button onclick="loadMore('kumpulan')">Tampilkan Cerita Selanjutnya</button>
        </div>
        <div class="right-section">
            <h1>Ceritaku</h1>
            <div id="ceritaku" class="cerita-container"></div>
            <button onclick="loadMore('ceritaku')">Tampilkan Cerita Selanjutnya</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="tes.js"></script>
    <script type="text/javascript">
    	
    </script>
</body>

</html>
