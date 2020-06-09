<?php
session_start();
define('__ROOT__', '../app/');		

require_once(__ROOT__ . 'model/User_php.php');
require_once(__ROOT__ . 'controller/UserController.php');
require_once(__ROOT__ . 'db\Dbh.php');



$model = new User();
$controller = new UserController($model);
$dbh = new Dbh();



require_once(__ROOT__ . 'view/Viewbar.php');


$sql="SELECT * FROM order_details WHERE access ='".$_SESSION['username']."';";

$result=$dbh->query($sql);

if($result!=false)
{
	while($row=$dbh->fetchRow($result))
	{
	if(isset($_POST[$row['id']]))
		{
			$sql2="DELETE FROM order_details WHERE id = ".$row['id'].";";
			$result2=$dbh->query($sql2);
		}
	}
}



?>


<html>
<head>
	<title>orderhistory | INAGZ</title>
	<link rel = 'icon' href ='images/logo2.jpg' type = 'image/x-icon'> 
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>

	<!-- links of bootstrap 3 -->
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'>
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
	<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>

	
</head>

<body>
	<!-------------------------------------------------------Start of Content--------------------------------------------------------------->			
	<div class='container'>
		<h1><b>Your  Order History :-</b></h1>
		<style>
		td, tr, img  { padding: 0px; margin: 0px; border: none; }
		table { border-collapse: collapse; }
		</style>
		<?php

			if(isset($_SESSION['username']))
			{
		
				$sql="SELECT * FROM order_details WHERE access = '".$_SESSION['username']."';";
				$result=$dbh->query($sql);
				echo "<form action='' method='post' class='need-validated' enctype='multipart/form-data'>
				<table class='table table-condensed' cellspacing='0' cellpadding='0'>";
				echo "<tr>
						<th width='25%'>Design</th>
						<th width='25%'>Details</th>
						<th width='25%'>Description</th>
						<th width='15%'>Cost</th>
					
					</tr>
					
				";
				if($result!=false)
				{
					while($row=$dbh->fetchRow($result))
					{
						$desc="";
						if(!empty($row['description']))
						{
							$desc=$row['description'];
						}
						else
						{
							$desc="None";
						}
						echo "
							<tr>
								<td rowspan='7'><img src='data:image/jpg;base64,".base64_encode($row['design'])."' height=256 width=256 /> </td>
								<td> Product Category: ".$row['category']."</td>
								<td rowspan='7'>".$desc."</td>
								
								
								
								
							</tr>

							<tr>
								<td> Product Quantity: ".$row['quantity']."</td>
								
							</tr>
							<tr>
								<td> Paper Quantity: ".$row['paper_quantity']."</td>
								
								
							</tr>
							<tr>
								<td> Paper Size: ".$row['papersize']."</td>
								
							</tr>
							<tr>
								<td> Printed Sides: ".$row['printedsides']."</td>
																

							</tr>
							<tr>
								<td> Finish: ".$row['finish']."</td>
								
								<td> Total Cost: ".$row['total_cost']." EG</td>

							

							</tr>
							<tr>
								<td> Printed Weight: ".$row['paperweight']."</td>
							</tr>
							

							<!--<td rowspan='1'><button type='submit' class='glyphicon glyphicon-pencil btn-lg' name='edit'></button></td>-->

							
						";
						
					}
					
					echo "</table> </form>";
				}
			}





		?>



	</div>

	<!-------------------------------------------------------End of Content----------------------------------------------------------------->
	
	<!-------------------------------------------------------Start of Footer---------------------------------------------------------------->
	<?php include 'footer.php'; ?>
	<!-------------------------------------------------------End of Footer------------------------------------------------------------------>
</body>
</html>
