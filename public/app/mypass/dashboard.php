		<?php include ('header.php'); ?>
    	<?php include ('sidemenu.php'); ?>

    <div class="main-panel">

    	<?php include ('mainpanel.php'); ?>

        <div class="content">
            <div class="container-fluid">
				<div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Pass ID #<?php echo $pid; ?></h4>
                                <p class="category">Show this for admission at attractions</p>
                            </div>
                            <div class="content">
								<center>
                                <img style="width:100%; max-width:200px;" src="https://chart.googleapis.com/chart?cht=qr&chl=<?php echo $pid; ?>&chs=350x350"/>
								</center>
								
                                <div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-clock-o"></i> This pass will expire on 20/05/2017
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					
                    <div class="col-md-4">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Pass Details</h4>
                                <p class="category">Last Campaign Performance</p>
                            </div>
                            <div class="content">
						
                                <table class="table table-hover" style="margin-top:-5px; margin-bottom:2px;">
                                    <tbody>
										<tr>
											<th style="border-top:0;">Holder</th>
											<td style="border-top:0;"><?php echo $lead; ?></td>
										</tr>
										<tr>
											<th>Adults</th>
											<td><?php echo $adult; ?></td>
										</tr>
										<tr>
											<th>Children</th>
											<td><?php echo $child; ?></td>
										</tr>
										<tr>
											<th>Validity</th>
											<td><?php echo $validity; ?> Day Pass</td>
										</tr>
										<tr>
											<th>Status</th>
											<td><i class="fa fa-circle text-warning"></i> Not Started</td>
										</tr>
                                    </tbody>
								</table>
	
							<div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-clock-o"></i> Campaign sent 2 days ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					
                    <div class="col-md-4">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Savings</h4>
                                <p class="category">Total value of services used for your group</p>
                            </div>
                            <div class="content">
                                <span style="font-size:50px">€425</span>

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> €<?php echo $adult * 125 + $child * 67.5; ?> paid for Istanbul Tourist Pass
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-clock-o"></i> Based on regular admission prices
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                 
                </div>
			</div>
        </div>


        <?php include('footer.php'); ?>