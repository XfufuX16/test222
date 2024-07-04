<?php
    date_default_timezone_set('Asia/Jakarta');
    // Start the session
    session_start();
?>

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


// Establish a database connection
$con = new mysqli("localhost", "root", "", "story");

if ($con->connect_errno) {
    die("Connect failed: " . $con->connect_error);
}

if (isset($_POST['simpan'])) {
    // Get user inputs
    $judul = $_POST['judul'];
    $paragraf = $_POST['paragraf'];
    // $username = $_SESSION['user'];

    // Check if the user is logged in and has an active session
    if (isset($_SESSION['user'])) {
        //MENGAMBIL ID USER
        $sql = "SELECT idusers FROM users WHERE nama ='" . $_SESSION['user'] . "'";
        $res = $con->query($sql);

        while ($row = $res->fetch_assoc()) {
            $iduser = $row['idusers'] . "<br><br>";
        }
    } else {
        // Add the diagnostic code here to check the session data
        // echo "Debug: Session Data - ";
        print_r($_SESSION); // This will print the session data for debugging purposes
        // die("Error: User not found. Please log in first.");
    }

    // Insert a new story into the 'cerita' table
    $insert_cerita_sql = "INSERT INTO cerita (judul,idusers_pembuat_awal) VALUES (?,?)";
    $stmt = $con->prepare($insert_cerita_sql);
    $stmt->bind_param("si", $judul, $iduser); // Use "si" for string and integer
    $stmt->execute();

    if ($stmt->error) {
        die("Error: Failed to add the story (cerita). " . $stmt->error);
    }

    // Get the auto-generated idcerita from the inserted row
    $idcerita = $stmt->insert_id;

    // Insert paragraphs into the 'paragraf' table
    $insert_paragraf_sql = "INSERT INTO paragraf (idusers, idcerita, isi_paragraf) VALUES (?, ?, ?)";
    $stmt = $con->prepare($insert_paragraf_sql);
    $stmt->bind_param("iis", $iduser, $idcerita, $paragraf); // Use "iis" for integer and string
    $stmt->execute();

    if ($stmt->error) {
        die("Error: Failed to add the paragraphs to the story. " . $stmt->error);
    }

    echo "Story added successfully.<br><br>";
    echo "<a href='home.php' class='btnBack'>Back Home</a>";
    // Close the database connection
    $con->close();
}
?>