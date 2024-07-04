<?php
    // class koneksi {
    //     protected $con;

    //     public function __construct($server,$user,$pass,$db)
    //     {
    //         $this->con = new mysqli($server,$user,$pass,$db);
    //     }

	// 	public function __destruct()
	// 	{
	// 		$this->con->close();
	// 	}
    // }

    // class Story extends koneksi
	// {
	// 	public function __construct($server,$user,$pass,$db)
	// 	{
	// 		parent::__construct($server,$user,$pass,$db);
	// 	}

	// 	public function getStory($search)
	// 	{
	// 		$sql = "SELECT * FROM cerita WHERE judul=?";
	// 		$stmt = $this->con->prepare($sql);
	// 		$stmt->bind_param("s",$search);
	// 		$stmt->execute();
	// 		$result = $stmt->get_result();

	// 		if ($row = $result->fetch_assoc()) {
	// 			return $row;
    //         } else {
	// 			return false;
    //         }
	// 	}
	// }

	class StoryClass {
		public function story() {
			$con = new mysqli('localhost', 'root', '', 'story');

			if ($con->connect_errno) {
        		die("Connect failed: " . $con->connect_error);
    		}

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
		}
	}
?>