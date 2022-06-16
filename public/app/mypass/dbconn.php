<?php
$servername = "localhost";
$username = "istanv3g_passApp";
$password = "ML1WnksSe3c4Nhu";
$dbname = "istanv3g_pass";

/* $servername = "localhost";
$username = "yukse3fv_itpadmi";
$password = "eu33ssi2xgxb";
$dbname = "yukse3fv_itp"; */

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}

$pid=$_GET["pid"];

$sql = "SELECT * FROM pass WHERE pid ='" .$pid.  "'";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {

							$pid = $row[pid];
							$oid = $row[oid];
							$lead = $row[lead];
							$adult = $row[adult];
							$child = $row[child];
							$validity = $row[validity];
							$pstart = $row[pstart];
							$pexpiry = $row[pexpiry];
							$attraction = $row[$attraction];
							$bot = $row[bot];
							$big = $row[big];
							$mus = $row[mus];
							$xdc = $row[xdc];
							$wds = $row[wds];
							$bdc = $row[bdc];
							$apt = $row[apt];
							$net = $row[net];
							$sea = $row[sea];
							$trb = $row[trb];
							$hrc = $row[hrc];

			}


		} else {
			echo "x";
		}

function get_Invoice($conn) {
    // Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}

$pid=$_GET["pid"];

$sql = "SELECT cid, iid FROM pass WHERE pid ='" .$pid.  "'";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {

                $cid = $row[cid];
                $iid = $row[iid];
			}



		} else {
			echo "0 results";
		}

    }
?>
