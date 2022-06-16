		<?php include ('header.php'); ?>
    	<?php include ('sidemenu.php'); ?>

    <div class="main-panel">

    	<?php include ('mainpanel.php'); ?>

		<!-- rid x, pid x, aid x,
		rdate, rtime, rnotes,
		radult x, rchild x,
		rsuppliernotes x, rpickup, rstatus Waiting Approval -->
		
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Book - <?php echo 'Airport Transfer'; ?></h4>
                            </div>
                            <div class="content">
                                <form>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Lead Traveler</label>
                                                <input type="text" class="form-control" disabled placeholder="Lead Traveler" value="<?php echo $lead; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Pass ID</label>
                                                <input type="text" class="form-control" disabled placeholder="Pass ID" value="<?php echo $pid; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" class="form-control" placeholder="Email" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Adults</label>
                                                <select class="form-control">
													<?php
														$i=1;
														while ($i < $adult) {
														echo '<option>' .$i++. '</option>';
														}
													?>
													<option selected><?php echo $adult; ?>
												</select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Children</label>
                                                <select class="form-control">
													<?php
														$i=0;
														while ($i < $child) {
														echo '<option>' .$i++. '</option>';
														}
													?>
													<option selected><?php echo $child; ?></option>
												</select>
                                            </div>
                                        </div>
                                    </div>

									<div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Date</label>
                                                <input type="text" id="datepicker" class="form-control" placeholder="Date Requested">
                                            </div>
                                        </div>
										
										<div class="col-md-2">
                                            <div class="form-group">
                                                <label>HH</label>
                                                <select class="form-control">
													<option>00</option>
													<option>01</option>
													<option>02</option>
													<option>03</option>
													<option>04</option>
													<option>05</option>
													<option>06</option>
													<option>07</option>
													<option>08</option>
													<option>09</option>
													<option>10</option>
													<option>11</option>
													<option>12</option>
													<option>13</option>
													<option>14</option>
													<option>15</option>
													<option>16</option>
													<option>17</option>
													<option>18</option>
													<option>19</option>
													<option>20</option>
													<option>21</option>
													<option>22</option>
													<option>23</option>
												</select>
                                            </div>
                                        </div>
										
										<div class="col-md-2">
                                            <div class="form-group">
                                                <label>MM</label>
                                                <select class="form-control">
													<option>00</option>
													<option>15</option>
													<option>30</option>
													<option>45</option>
												</select>
                                            </div>
                                        </div>									
										
										<div class="col-md-4">
                                            <div class="form-group">
                                                <label>Flight Number</label>
                                                <input type="text" class="form-control" placeholder="TK0001">
												</select>
                                            </div>
                                        </div>
                                    </div>

									<div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Airport</label>
                                                <select class="form-control">
													<option>IST - Ataturk</option>
													<option>SAW - Sabiha Gökçen</option>
												</select>
                                            </div>
                                        </div>
																				
										<div class="col-md-4">
                                            <div class="form-group">
                                                <label>Transfer Type</label>
                                                <select class="form-control">
													<option selected>Arrival (Airport to Hotel)</option>
													<option>Departure (Hotel to Airport)</option>
												</select>
                                            </div>
                                        </div>
										
										<div class="col-md-4">
                                            <div class="form-group">
                                                <label>Vehicle Type</label>
                                                <select class="form-control">
													<option>Shared</option>
													<option>Private (+€10)</option>
												</select>
                                            </div>
                                        </div>
				
                                    </div>
									
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Hotel Name & Address</label>
                                                <input type="text" class="form-control" placeholder="Hilton İstanbul Bosphorus, Harbiye Mahallesi, Cumhuriyet Cd. No:50, 34367 Şişli/İstanbul">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Reservation Name</label>
                                                <input type="text" class="form-control" placeholder="City" value="<?php echo $lead; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Reservation Number</label>
                                                <input type="text" class="form-control" placeholder="Expedia #123456789">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Postal Code</label>
                                                <input type="number" class="form-control" placeholder="ZIP Code">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Notes</label>
                                                <textarea rows="5" class="form-control" placeholder="Do you require any special treatment?"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-info btn-fill pull-right">Book Now</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <?php include('footer.php'); ?>