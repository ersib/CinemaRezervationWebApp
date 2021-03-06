
<?php
session_start();
if(!isset($_SESSION['admin']))
{
	header('location: ../logimi.php');
}
	require_once '../classes/user.php';
	require_once '../classes/rezervim.php';
	$rezervim=new Rezervim();
	if(isset($_GET['userID']))
	{
     $userId=$_GET['userID'];
		 if($userId != null){
       $perdorues=(new User())->getUserById($userId);
		 $userName=$perdorues->username;
		 }
		 else{
			 $userName="???????";
		 }
	}
	if(isset($_GET['deleteID']))
	{
         $fshiId=$_GET['deleteID'];
		 if($fshiId != null){
		 $rezervim->delete($fshiId);
	     echo '<script>window.alert("U fshi rezervimi");</script>';

		 }
	}

?>
<!DOCTYPE html>

<html>
<head>
	<meta charset="UTF-8">
	<title>Ticket Info - Cinema Theatre Website</title>
<link href="font-awesome.css" rel="stylesheet" />
<link href="bootstrap.css" rel="stylesheet" />
<link rel="stylesheet" href="styleadmin3.css" type="text/css">
<script>
function editRezervim(bid,bseats,bstatus)
{
var div=document.getElementById("printoDiv"+bid);
var p='<form method="post"><div class="form-group"><label>Nr Seats : </label><input type="text" style="width:50px;" name="nrVendeve" value="'+bseats+'"/></div>';
p+='<input type="hidden" name="idRezervim" value="'+bid+'"/>';
p+='<div class="form-group"><label>Statusi: </label><input style="width:50px;" type="text" value="'+bstatus+'" name="status" /></div><input type="submit" name="updatebooking" value="Save"/>';
p+='<input type="submit" onclick="mbyllEditDiv('+bid+','+bseats+','+bstatus+')" value="Cancel"/></form>';
div.innerHTML=p;

}
function mbyllEditDiv(bid,bseats,bstatus)
{
var div=document.getElementById("printoDiv"+bid);
div.innerHTML=' <button type="button" onclick="editRezervim('+bid+','+bseats+','+bstatus+')" class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button></td>';

}

</script>
</head>
<?php
if(isset($_POST['updatebooking'])){
      $nrseats=$_POST['nrVendeve'];
      $status=$_POST['status'];
	  $bid=$_POST['idRezervim'];
	  $rezervim->update($nrseats,$status,$bid);
	  $rezervim->redirect("listaRezPerUserin.php?userID=".$userId."");
}
?>
<body>
	<div id="header">
		<div class="admboard">
			<a  id="logo"><img src="../images/logo.png" alt=""></a>
			      <div class="helloAd">WELCOME ADMIN !</div>
			        <a class="logout" href="../logout.php">Log out</a>
					<a class="bt" href="admin_board.php">Back to Admin Board</a>
		</div>
	</div>
	<div id="body" class="Adminboard">

		<div class="panel panel-default" style="margin-bottom:0px;">

						<div class="panel-heading" style="font-size:1.5em;">
                          Bookings list for <?php echo $userName;?>
                        </div>
						<a href="admin_lista_userave.php"><input type="submit" style="float:left;margin-top:5px;margin-bottom:5px;background-color:#f5f5f5;color:black;
						border:1px solid #dddddd" value="Back to Users Table"  class="btn btn-info"/></a>
						<br>


						<div class="panel-body">
                            <div class="table-responsive">
		            	<?php
							$msg='<table class="table table-striped table-bordered table-hover"><thead><tr>
<th>#</th><th>Film name</th><th>Show Date</th><th>Show Time</th><th>Kinema</th><th>Salla</th><th>Tech</th><th>Nr.Seats</th>
<th>Total Price</th><th>Reservation Date</th><th>Status</th></tr></thead><tbody>';

                 $lista_rez=$perdorues->getUserBookings();


                 for($i=0;$i<count($lista_rez);$i++)
								 {
								 $bid=$lista_rez[$i]['Id_rezervim'];
								 $dataRez=$lista_rez[$i]['Data_rez'];
								 $bseats=$lista_rez[$i]['Nr_vendeve'];
								 $bStatus=$lista_rez[$i]['Statusi'];
								 $data=$lista_rez[$i]['Data_sh'];
								 $ora=$lista_rez[$i]['Ora_sh'];
								 $totali=$lista_rez[$i]['Cmimi']*$bseats;
								 $Emfilm=$lista_rez[$i]['Titull_film'];
								 $Emsalla=$lista_rez[$i]['Em_salla'];
								 $tech=$lista_rez[$i]['Teknologjia'];
								 $Emkinema=$lista_rez[$i]['Em_kinema'];

			$msg.='<tr><td>'.$bid.'</td><td style="width:20px">'.$Emfilm.'</td><td>'.$data.'</td><td>'.$ora.'</td><td>'.$Emkinema.'</td><td>'.$Emsalla.'</td>
          <td>'.$tech.'</td><td>'.$bseats.'  </td>
		  <td>'.$totali.'</td><td>'.$dataRez.'</td><td>'.$bStatus.'</td>
		  <td><a href="listaRezPerUserin.php?userID='.$userId.'&deleteID='.$bid.'"><img width="20px" height="20px" src="../images/trashbin.jpg" /><a></td>
		  <td id="printoDiv'.$bid.'">
		  <button type="button" onclick="editRezervim('.$bid.','.$bseats.',\''.$bStatus.'\')" class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button></td>
		  </tr>

		  ';
								 }
								 $msg.="</tbody></table>";
								 echo $msg;
							?>
						    </div>
						</div>
         </div>

    </div>

	<div id="footer">
		<div>
			<p>
				&#169; 2023 Cinema Theatre
			</p>
			<div class="connect">
				<span>Stay Connected:</span> <a href="http://freewebsitetemplates.com/go/facebook/" id="facebook">facebook</a> <a href="http://freewebsitetemplates.com/go/twitter/" id="twitter">twitter</a> <a href="http://freewebsitetemplates.com/go/googleplus/" id="googleplus">google+</a>
			</div>
		</div>
	</div>
</body>
</html>
