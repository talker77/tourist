		<?php include ('header.php'); ?>

    	<?php include ('sidemenu.php'); ?>
		
		<?php
		
		// Default Status Signs
		$i = 0;
		while ($i <= 7) {
			${'sign' . $i++} = '<i style="font-size:40px; color:#ebebeb;" class="fa fa-check"></i>';
			${'note' . $i} = 'not yet booked. <a href="book.php?aid=' .$i. '">Book Now</a>';
		}
		
		$signres = '<i style="font-size:40px; color:#ebebeb;" class="fa fa-check"></i>';
		$noteres = 'You haven\'t booked for any experience so far. <a href="book.php?aid=4">Book Now</a>';
		$note6 = 'Your museum pass has not yet been collected';
		$note7 = 'You haven\'t visited any attraction so far';
		
		// Check Booking Statuses
		
		$sqlres = "SELECT * FROM reservations WHERE pid ='" .$pid. "'";
		$resultres = $conn->query($sqlres);

		if ($resultres->num_rows > 0) {
			// output data of each row
			while($rowres = $resultres->fetch_assoc()) {
				${'status' . $rowres[aid]} = $rowres[rstatus];
				${'date' . $rowres[aid]} = $rowres[rdate];
				
				// Dynamic Status Signs
				if (${'status'. $rowres[aid]} == 'Confirmed') {
					${'status' . $rowres[aid]} = $rowres[rstatus];
					${'sign' . $rowres[aid]} = '<i style="font-size:40px; color:#8bc34a;" class="fa fa-check"></i>';
					${'note' . $rowres[aid]} = 'booked for ' . $rowres[rdate] . '. ' . '<a href="#">View Details</a>';
				}
				elseif (${'status'. $rowres[aid]} == 'Waiting Approval') { 
					${'status' . $rowres[aid]} = $rowres[rstatus];
					${'sign' . $rowres[aid]} = '<i style="font-size:35px; color:#ffc107;" class="fa fa-reply-all"></i>';
					${'note' . $rowres[aid]} = 'waiting for approval. <a href="#">View Details</a>';
				}
				elseif (${'status'. $rowres[aid]} == 'Canceled') {
					${'status' . $rowres[aid]} = $rowres[rstatus];
					${'sign' . $rowres[aid]} = '<i style="font-size:40px; color:#f44336;" class="fa fa-times"></i>';
					${'note' . $rowres[aid]} = 'canceled. <a href="#">View Details</a>';
				}
			}
		} else { echo 'Problem'; }
		
		
		// Check Experience Reservations
		
		if ($status4 == "Confirmed" OR $status5 == "Confirmed") {
			$signres = '<i style="font-size:40px; color:#8bc34a;" class="fa fa-check"></i>';
			$noteres = 'You have booked for all experiences. <a href="#">View Details</a>';
		}
		
		if ($status4 == "Waiting Approval" OR $status5 == "Waiting Approval") {
			$signres = '<i style="font-size:35px; color:#ffc107;" class="fa fa-reply-all"></i>';
			$noteres = 'You have a booking that\'s waiting for approval <a href="#">View Details</a>';
		}
			
		if ($status4 == "Canceled" OR $status5 == "Canceled") {
			$signres = '<i style="font-size:40px; color:#f44336;" class="fa fa-times"></i>';
			$noteres = 'You have a booking that was canceled. <a href="#">View Details</a>';
		}
		
		
		// Check Pass Usage
		
		$sqlpu = "SELECT * FROM pass WHERE pid ='" .$pid. "'";
		$resultpu = $conn->query($sqlpu);

		if ($resultpu->num_rows > 0) {
			// output data of each row
			while($rowpu = $resultpu->fetch_assoc()) {
				$mus = $rowpu[mus];
				$bdc = $rowpu[bdc];
				$wds = $rowpu[wds];
				$bot = $rowpu[bot];
				$big = $rowpu[big];
				$xdc = $rowpu[xdc];
				$sea = $rowpu[sea];
				$trb = $rowpu[trb];
				$mme = $rowpu[mme];
				$pexpiry = $rowpu[pexpiry];
				
				
				
		}
		}
		
			if (!empty($mus)) {
				$sign6 = '<i style="font-size:40px; color:#8bc34a;" class="fa fa-check"></i>';
				$note6 = 'Your MuseumPass was picked up on ' . $mus;
				}
				
			if (!empty($bot) OR !empty($big) OR !empty($xdc) OR !empty($sea) OR !empty($trb) OR !empty($mme)) {
				$sign7 = '<i style="font-size:40px; color:#8bc34a;" class="fa fa-check"></i>';
				$note7 = 'Your pass has been used at least at one attraction';
			}
		
		?>

    <div class="main-panel">

    	<?php include ('mainpanel.php'); ?>

        <div class="content">
            <div class="container-fluid">
				<div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Manage Your Trip</h4>
                                <p class="category">Pass #<?php echo $pid; ?></p>
                            </div>
                            <div class="content manageyourtrip">
							
                                <table class="table table-hover">
                                    <thead>
                                        <th></th>
                                    	<th>Activity</th>
                                    	<th>Status</th>
                                    </thead>
                                    <tbody>
										<tr>
                                        	<td><i style="font-size:40px" class="pe-7s-plane"></i></td>
                                        	<td>
												<b>Book your airport transfer</b>
												<br>
												<p>Your airport transfer is <?php echo $note1; ?>
												</p>
												
											</td>
                                        	<td><?php echo $sign1; ?></td>
                                        </tr>
                                        <tr>
                                        	<td><i style="font-size:40px" class="pe-7s-users"></i></td>
                                        	<td><b>Book your guided Welcome Tour</b>
												<br>
												<p>Your guided tour is <?php echo $note2; ?> <?php echo $time2; ?></p>
											</td>
                                        	<td><?php echo $sign2; ?></td>
                                        </tr>
                                        <tr>
                                        	<td><i style="font-size:40px" class="pe-7s-signal"></i></td>
                                        	<td><b>Rent an internet deivce</b>
												<br>
												<p>Your internet device is <?php echo $note3; ?></p>
											</td>
                                        	<td><?php echo $sign3; ?></td>
                                        </tr>
                                        <tr>
                                        	<td><i style="font-size:40px" class="pe-7s-date"></i></td>
                                        	<td><b>Book for experiences</b>
												<br>
												<p><?php echo $noteres; ?></p>
											</td>
                                        	<td><?php echo $signres; ?></td>
                                        </tr>
                                        <tr>
                                        	<td><i style="font-size:40px" class="pe-7s-culture"></i></td>
                                        	<td><b>Collect your MuseumPass</b>
												<br>
												<p><?php echo $note6; ?></p>
											</td>
                                        	<td><?php echo $sign6; ?></td>
                                        </tr>
                                        <tr>
                                        	<td><i style="font-size:40px" class="pe-7s-map-2"></i></td>
                                        	<td><b>Visit included Attractions</b>
												<br>
												<p><?php echo $note7; ?></p>
											</td>
                                        	<td><?php echo $sign7; ?></td>
                                        </tr>
                                    </tbody>
                                </table>

							   
							
							<div class="footer">
                                    <div class="legend">
										<i style="color:#b7b7b7;" class="fa fa-check"></i> Not Made
                                        <i style="color:#ffc107;" class="fa fa-reply-all"></i> Waiting Approval
                                        <i style="color:#8bc34a;" class="fa fa-check"></i> Confirmed
                                        <i style="color:#f44336;" class="fa fa-times"></i> Canceled
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-clock-o"></i> This pass will expire on <?php echo $pexpiry; ?>
                                    </div>
							</div>
                            </div>
                        </div>
                    </div>
                </div>
			
            </div>   
        </div>


        <?php include('footer.php'); ?>