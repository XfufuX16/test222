<?php
    // class koneksi {
    //     protected $con;

    //     public function __construct() {
    //         $this->con = new mysqli('localhost','root','','story');
    //     }
    // }

    // class UserClass extends koneksi {
	// 	// public function __construct($server,$user,$pass,$db) {
	// 	// 	parent::__construct($server, $user, $pass, $db);
	// 	// }

	// 	public function login($user, $pass) {
    //         $con = new mysqli("localhost","root","","story");

	// 	    $user = $_POST['user'];
    //         $pass = $_POST['pass'];

    //         $sql = "SELECT * FROM users WHERE nama=?";
    //         $stmt = $con->prepare($sql);
    //         $stmt->bind_param("s", $user);
    //         $stmt->execute();
    //         $result = $stmt->get_result();

    //         if ($row = $result->fetch_assoc()) {
    //             $salt = $row['salt'];

    //             $md5pass = md5($pass);
    //             $combinepass = $md5pass . $salt;
    //             $finalpass = md5($combinepass);

    //             if ($finalpass === $row['password']) {
    //                 $_SESSION['user'] = $user;

    //                 if (isset($_POST['redirect'])){
	// 					header("location: ".$_POST['redirect']);
	// 				} else {
	// 					header("location: home.php");
	// 				}

    //                 echo "Password Benar.";
    //             } else {
    //                 echo "Password Salah.";
    //             }
    //         } else {
    //             echo "User Tidak Ditemukan.";
    //         }

	// 	    $con->close();
	// 	}
	// }

    class UserClass {
        //Koneksi ke db
        // protected $db;

        // public function __construct($db) {
        //     $this->db = $db;
        // }

        // public function login($username, $password) {
        //     // Contoh implementasi login
        //     // Anda harus mengganti ini dengan logika sebenarnya
        //     // Gunakan $this->db untuk berinteraksi dengan database
        //     // Misalnya, jalankan query untuk memeriksa kecocokan username dan password
        //     $query = $this->db->prepare("SELECT * FROM users WHERE nama=?");
        //     $query->bindParam(':username', $username);
        //     $query->bindParam(':password', $password);
        //     $query->execute();
        
        //         // Cek apakah ada hasil
        //     if ($query->rowCount() == 1) {
        //         return true; // Login berhasil
        //     } else {
        //         return false; // Login gagal
        //     }
        // }

        public function login($user, $pass) {
            $con = new mysqli('localhost', 'root', '', 'story');
            
            $user = $_POST['user'];
            $pass = $_POST['pass'];
    
            $sql = "SELECT * FROM users WHERE nama=?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param('s', $user);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $salt = $row['salt'];

                $md5pass = md5($pass);
                $combinepass = $md5pass . $salt;
                $finalpass = md5($combinepass);

                if ($finalpass === $row['password']) {
                    $_SESSION['user'] = $user;
                    $_SESSION['id'] = $row['idusers'];

                    if (isset($_POST['redirect'])){
						header("location: ".$_POST['redirect']);
					} else {
						header("location: tes.php");
					}

                    echo "Password Benar.";
                } else {
                    echo "Password Salah.";
                }
            } else {
                echo "User Tidak Ditemukan.";
            }

		    $con->close();
        }
    }
?>