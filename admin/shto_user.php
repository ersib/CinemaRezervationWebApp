<?php
session_start();
if(!isset($_SESSION['admin']))
{
	header('location: ../logimi.php');
}

	require_once '../classes/user.php';
	$user = new User();

	if(isset($_GET['editID']))
	{
         $editId=$_GET['editID'];
		     $edited_user=$user->getUserById($editId);

	       $username=$edited_user->username;
         $password=$edited_user->password;
				 $emri=$edited_user->emri;
			   $tel=$edited_user->tel;
				 $email=$edited_user->email;
				 $ditelindja=$edited_user->ditelindja;
				 $adresa=$edited_user->adresa;
				 $qyteti=$edited_user->qyteti;
	}
	else
	{
		    $username="";
        $password="";
        $emri="";
	      $tel="";
				 $email="";
				 $ditelindja="";
				 $adresa="";
				 $qyteti="";
	}
?>
<!DOCTYPE html>

<html>
<head>
	<meta charset="UTF-8">
	<title>Ticket Info - Cinema Theatre Website</title>
	<link href="bootstrap.css" rel="stylesheet" />
<link href="font-awesome.css" rel="stylesheet" />
	<link rel="stylesheet" href="styleadmin3.css" type="text/css">
</head>
<body>

	<div id="header">
		<div class="admboard">
			<a  id="logo"><img src="../images/logo.png" alt=""></a>
			      <div class="helloAd">WELCOME ADMIN !</div>
			        <a class="logout" href="../logout.php">Log out</a>
					<a class="bt" href="admin_board.php">Back to Admin Board</a>
		</div>
	</div>

	<div id="body" class="Adminboard" style="background-color:white;">


		         <div class="panel panel-info" style="width:100%;position:relative;margin-bottom:0px;font-size:1.2em;float:left;">
                         <div class="panel-heading">
                           <?php if(isset($_GET['editID'])) echo 'User Details';
						   else echo 'Add User';
						   ?>
                        </div>


							<a href="admin_lista_userave.php"><input type="submit" style="float:right;margin-top:5px;"value="Back to UserTable"  class="btn btn-info"/></a>
                        <div class="panel-body">

                            <form action="" method="post">
							<?php
							    if(isset($_GET['editID'])){
                                        echo '<div class="form-group">
                                            <label>Id:</label>
		                                    <input type="text" readonly name="name" size="20" value="'.$editId.'"  />
                                       </div>';
							    }
							?>
										<div class="form-group">
                                            <label>Name:</label>
		                                    <input required type="text" name="name" size="20" value="<?php echo $emri; ?>"/>
                                       </div>
                                 <div class="form-group">
                                            <label>Username:</label>
		  <input required type="text" name="username" size="20" value="<?php echo $username; ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label>Password:</label>
		   <input  <?php if(isset($_GET['editID'])) echo 'type="text"';
			  else
				  echo 'type="password"';?> name="password" required size="20"  value="<?php echo $password; ?>" />
                                        </div>
										 <div class="form-group">
                                             <label>Confirm password:</label>
		   <input  <?php if(isset($_GET['editID'])) echo 'type="text"';
			  else
				  echo 'type="password"';?>name="cpassword" required size="20" value="<?php echo $password; ?>" />
                                        </div>

                                  <div class="form-group">
<label>Phone Nr:</label>
		    <input type="tel"  name="tel" value="<?php echo $tel; ?>" required placeholder="### ### ####"  />
                                    </div>
									<div class="form-group">
                                          <label>Date of birth:</label>
                                          <input class="form-control" style="width:150px;"name="ditelindja"  type="date"/><?php if(isset($_GET['editID']))
											  echo '( Current : '.$ditelindja.' )<br>';?><br>
										<div class="form-group">
                                          <label>Email:</label>
		  <input type="email" name="email" value="<?php echo $email; ?>"  />
                                        </div>
										<div class="form-group">
                                          <label>Adress:</label>
<input type="text" name="adresa" size="20" value="<?php echo $adresa; ?>" />
                                        </div>
										<div class="form-group">
										 <label>City:</label>
		   <input type="text" name="qyteti" size="20" value="<?php echo $qyteti; ?>" />
                                        </div>
                                       <input type="submit" name="submit" value="Save" class="btn btn-info"/>

									   </form>



                            </div>

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
<?php
      if(isset($_POST['submit']))
		   {

			     $name=$_POST['name'];
				   $username=$_POST['username'];
			     $password=$_POST['password'];
			     $cpassword=$_POST['cpassword'];
				   $emri=$_POST['name'];
			     $tel=$_POST['tel'];
				   $email=$_POST['email'];
				   $ditelindja=$_POST['ditelindja'];
				   $adresa=$_POST['adresa'];
				   $qyteti=$_POST['qyteti'];


						 if(isset($_GET['editID'])){

							  if(!$edited_user->uniqueUsername($username))
					          {
					               echo '<script type="text/javascript"> alert("Already used username !")</script>';
					          }
							  else{
						$user->update($name,$username,$password,$tel,$email,$ditelindja,$adresa,$qyteti,$editId);
						echo '<script type="text/javascript"> alert("Changes are made succesfully !")</script>';
							  $user->redirect("shto_user.php?editID=".$editId."");
							  }
						}
						else
						{

							if($temp=$user->getUserByUsername($username))
							{
								echo '<script type="text/javascript"> alert("User already exsts ... Try another username !")</script>';
							}
							else{
							  if($password==$cpassword){
							  $user->insert($name,$username,$password,$tel,$email,$ditelindja,$adresa,$qyteti);
							  echo '<script type="text/javascript"> alert("User is added succesfully !")</script>';
							  }
							  else{
								 echo '<script type="text/javascript"> alert("The password doesn\'t match !")</script>';
							  }
              }
						}
		   }
		       if(isset($_POST['goback']))
			   {
				 $user->redirect("admin_lista_userave.php");
			   }
?>
