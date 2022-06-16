<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="ui/css/font.css" rel="stylesheet" />
    <link href="ui/css/main.css" rel="stylesheet" />
    <link href="ui/css/bootstrap.css" rel="stylesheet" />
    <title>AlohaVentures</title>
</head>

<?php include($_SERVER["DOCUMENT_ROOT"] . '/mypass/dbconn.php'); ?>
<?php
$sql = 'SELECT * from invoices WHERE iid = ' . $_GET["iid"] . '';
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			 // output data of each row
			 while($row = $result->fetch_assoc()) {
				$cid = $row["cid"];
				$idate_issued = $row["idate_issued"];
				$istatus = $row["istatus"];
				$idescription = $row["idescription"];
				$iquantity = $row["iquantity"];
				$icurrency = $row["currency_code"];
				$iprice = $row["iprice"];
				$idiscount = $row["idiscount"];
				$itax_rate = $row["itax_rate"];
				$itax_value = $row["itax_value"];
				$irefund = $row["irefund"];
				$irefund_date = $row["irefund_date"];
				$itx_fee = $row["itx_fee"];
				$itotal = $row["itotal"];
			 }
		}else {
			echo "0 results";
		}

$sql2 = 'SELECT * from customers WHERE cid = ' . $cid . '';
		$result2 = $conn->query($sql2);

		if ($result2->num_rows > 0) {
			 // output data of each row
			 while($row2 = $result2->fetch_assoc()) {
				$cname = $row2["cname"];
				$cemail = $row2["cemail"];
				$cphone = $row2["cphone"];
				$caddress = $row2["caddress"];
				$ccountry = $row2["ccountry"];
		}}
	?>

<body>
    <div class="Wrapper">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                </div>
                <div class="row">
                    <div class="Left" style="width: 585px;">
                        <div class="row">
                            <img src="ui/img/AlohaVenturesLogo.png" class=" img img-responsive ">
                             <div class="BufferMiddle"></div>
                            <div class="Bx1">
                                <p class="Grey Bold">ALOHA VENTURES LTD.</p>
                                <p class="Grey Bold BufferMiddle">Registered in England & Wales</p>
                                <p class="Grey Bold">Company # 10676383</p>
                            </div>

                            <div class="Buffer"></div>
                            <div class="Bx1 Buffer">
                                <p class="Grey ">71 KING GEORGE SQ</p>
                                <p class="Grey ">RICHMOND TW10 6LF</p>
                                <p class="Grey ">+44 (203) 808 5858 | info@alohaventures.com</p>
                                <a href="www.alohaventures.com" target="_blank" class="Grey ">www.alohaventures.com</a>
                            </div>

                            <div class="Buffer"></div>
                            <div class="Bx1 Buffer">
                                <p class="Blue ">TO</p>
                                <p class="Grey "><?php echo $cname; ?></p>
                                <p class="Grey "><?php echo $caddress; ?> <?php echo $ccountry; ?></p>
                                <p class="Grey "><?php echo $cphone; ?>  | <?php echo $cemail; ?></p>
                            </div>


                        </div>
                    </div>
                    <div class="pull-right BufferMiddle" style="width:292px;margin-top: -528px;">
                        <h1 class="Title ">INVOICE</h1>
                        <div class="BufferBig"></div>
                        <p class="Blue pull-right ">INVOICE #</p>
                        <p class="Grey pull-right "><?php echo $_GET["iid"] + 10000; ?> </p>


                        <p class="Blue pull-right  Buffer">DATE</p>
                        <p class="Grey pull-right "><?php echo $idate_issued; ?></p>


                        <p class="Blue pull-right  Buffer">BALANCE DUE</p>
                        <p class="Grey pull-right Box "><?php echo $idate_issued; ?></p>


                        <p class="Blue pull-right  Buffer">FOR</p>
                        <p class="Grey pull-right Box "></p>

                        <p class="Blue pull-right  Buffer">P.O.#</p>
                        <p class="Grey pull-right Box ">-</p>

                    </div>
                </div>
                <div class="row">
                    <div class="Buffer"></div>


                    <hr />
                    <div class="List">
                        <p class="Blue pull-left">Desciption</p>
                        <p class="Blue pull-right">Amount</p>
                        <hr class="Blue " />
                        <div class="item" style="margin-bottom:25px; border-bottom:0;">
                            <p><?php echo $idescription; ?></p>
                            <p><?php echo $icurrency; ?> <?php echo $iprice; ?> </p>

                        </div>
                        <div class="item">
                            <p>Discount</p>
                            <p><?php echo $icurrency; ?> <?php echo $idiscount; ?></p>
                        </div>
                        <div class="item">
                            <p>Tax (<?php echo $itax_rate; ?>%)</p>
                            <p><?php echo $icurrency; ?> <?php echo $itax_value; ?></p>
                        </div>

                        <div class="item Total">
                            <p class="Blue">Total</p>
                            <p><?php echo $icurrency; ?> <?php echo $itotal; ?></p>
                        </div>
                    </div>
                </div>
                <div class="Buffer"></div>
                <div class="Buffer"></div>
                <p class="center-block grey">Payment is due within 10 working days</p>

                <div class="BufferBig"></div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="Bx1">
                            <p class="Grey">Make payments to</p>
                            <p class="Grey Bold">ALOHA VENTURES LTD.</p>
                        </div>
                    </div>

                </div>


                <div class="col-md-6">
                    <div class="row">
                        <div class="Bx1 pull-right">
                            <p class="Grey  DTable pull-right NoneClear">Bank</p>
                            <p class="Grey Bold DTable pull-right NoneClear" style="margin-right:5px;">HSBC</p>

                            <div class="clear"></div>
                            <p class="Grey  DTable pull-right NoneClear">Sort Code</p>
                            <p class="Grey Bold DTable pull-right NoneClear" style="margin-right:5px;">403818</p>

                            <div class="clear"></div>
                            <p class="Grey  DTable pull-right NoneClear">Account #</p>
                            <p class="Grey Bold DTable pull-right NoneClear" style="margin-right:5px;">21893076</p>

                        </div>
                    </div>
                </div>
                 <div class="clear"></div>
                                <div class="Buffer"></div>

                <div class="Buffer"></div>

                <p class="center-block blue Light ">THANK YOU FOR YOUR BUSINESS!</p>

                 <div class="clear"></div>
                           <div class="BufferBig"></div>


            </div>
        </div>
    </div>
</body>
</html>
