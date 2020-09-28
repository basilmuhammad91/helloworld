




<?php 
session_start();
if(!isset($_SESSION["Name"]))
{
	header("Location:Login.php");
}


$con=mysqli_connect("localhost","root","","aptechdb");

if(isset($_POST["insert"]))
{
	
	$Name=$_POST["Name"];
	$Phone=$_POST["Phone"];
	$Email=$_POST["Email"];
	$Password=$_POST["Password"];
	$Gender=@$_POST["Gender"];
	$Subjects=@$_POST["chHtml"].' '.@$_POST["chSwift"].' '.@$_POST["chPython"];
	$Country=$_POST["Country"];
	$City=$_POST["City"];
	$Address=$_POST["Address"];
	$dob=$_POST["dob"];
	
	$img=addslashes(file_get_contents( $_FILES["Image"]["tmp_name"]));
	$pdf=addslashes(file_get_contents($_FILES["Pdf"]["tmp_name"]));
	
	
	$insert=mysqli_query($con,"insert into students (Name, Phone, Email, Password, Gender, Subjects, Country, City, Address, DOB,Image,Pdf) values('$Name','$Phone','$Email','$Password','$Gender','$Subjects','$Country','$City','$Address','$dob','$img','$pdf') ");
	
	if($insert>0)
	{
		echo "<script>alert('insert Successfully')</script>";
	}
	else
	{
		echo "<script>alert('Error')</script>";
	}
	
	
}

if(isset($_POST["Update"]))
{
	
	$Id=$_POST["Id"];
	$Name=$_POST["Name"];
	$Phone=$_POST["Phone"];
	$Email=$_POST["Email"];
	$Password=$_POST["Password"];
	$Gender=@$_POST["Gender"];
	$Subjects=@$_POST["chHtml"].' '.@$_POST["chSwift"].' '.@$_POST["chPython"];
	$Country=$_POST["Country"];
	$City=$_POST["City"];
	$Address=$_POST["Address"];
	$dob=$_POST["dob"];
	
//	$img=addslashes(file_get_contents( $_FILES["Image"]["tmp_name"]));
//	$pdf=addslashes(file_get_contents($_FILES["Pdf"]["tmp_name"]));
	
	
	$IsUpdated=mysqli_query($con,"update students set Name='$Name', Phone='$Phone', Email='$Email', Password='$Password', Gender='$Gender', Subjects='$Subjects', Country='$Country', City='$City', Address='$Address', DOB='$dob' where Id='$Id'") or die(mysqli_error($con));
	
	if($IsUpdated)
	{
		echo "<script>alert('Update Successfully')</script>";
	}
	else
	{
		echo "<script>alert('Error')</script>";
	}
	
	
}



if(isset($_GET["delete_id"]))
{
	$id=$_GET["delete_id"];
	$isDelete=mysqli_query($con,"delete from students where id='$id'");
	if($isDelete)
	{
		echo "<script>alert('delete Successfully')</script>";
	}
	else
	{
		echo "<script>alert('Error')</script>";
	}
	
	
}

if(isset($_POST["Edit"]))
{
	$id=$_POST["Edit_id"];
	
	$query=mysqli_query($con,"select * from Students where id='$id'");
	
	$Std=mysqli_fetch_array($query);
	
	
	
	if($Std[5]=="Male")$isMalechecked="checked";
	else $isFemalechecked="checked";
	
	if(strpos(" ".$Std[6],"HTML")) $html="checked";
	if(strpos($Std[6],"Swift")) $swift="checked";
	if(strpos($Std[6],"Python")) $python="checked";
	
	
	
}


?>
<style>
	table
	{
		width: 98%;
		margin: 0 auto;
		
		
	}
</style>
<center>
<table>
<tr>
	<td><h3 style="color: orange"><?php echo "Welcome : ".$_SESSION["Name"]?></h3></td>
	<td>
		<form action="login.php" method="post">
		<input type="hidden" name="Logout" value="true">
			<input type="image" src="logout.png" width="20" name="Logout">
		</form>
	</td>
</tr>
</table>

</center>
<!-----------------------form start------------------------>
<form action="index.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="Id" value="<?php echo @$Std[0] ?>">
	Name <input type="text" name="Name" value="<?php echo @$Std[1]?>"><br>
	Phone <input type="text" name="Phone"  value="<?php echo @$Std[2]?>"><br>
	Email <input type="text" name="Email"  value="<?php echo @$Std[3]?>"><br>
	Password <input type="text" name="Password"  value="<?php echo @$Std[4]?>"><br>
	Gender <input type="radio" name="Gender" <?php echo @$isMalechecked?>  value="Male">Male
	 <input type="radio" name="Gender" <?php echo @$isFemalechecked ?> value="Female">Female<br>
	 Subjects 
	  <input type="checkbox" value="HTML" <?php echo @$html ?> name="chHtml">HTML 
	  <input type="checkbox" value="Swift" <?php echo @$swift ?> name="chSwift">Swift 
	  <input type="checkbox" value="Python" <?php echo @$python ?> name="chPython">Python <br>
	  Counrty
	  <select name="Country" id="country" onChange="changeCities()">
	  	<option>--select--</option>
	  	<option <?php if(@$Std[7]=="Pakistan") echo "selected" ?>>Pakistan</option>
	  	<option <?php if(@$Std[7]=="China") echo "selected" ?>>China</option>
	  	<option <?php if(@$Std[7]=="Iraq") echo "selected" ?>>Iraq</option>
	  </select>
	  <br>
	  City 
	  <select name="City" id="city" >
	  	<option>--select--</option>
	  	<?php
		  if(isset($Std))
		  {
			  echo "<option selected>$Std[8]</option>";
		  }
		  ?>
	  </select>
	   <br>
	   Date of Birth
	   <input type="date" name="dob" value="<?php echo @$Std[10]?>"><br>
	   Select Image 
	   <img src="data:image/jpeg;base64,<?php echo base64_encode($Std[11])?>" style="height: 50px ; width: 50px; border-radius: 25px;"  alt="">
	   <input type="file" name="Image" accept="image/*"><br>
	   upload CV in pdf format <input type="file" name="Pdf" accept="application/pdf"><br>
	   Address <textarea name="Address" id="" ><?php echo @$Std[9]?></textarea><br>
	   <?php
		if(isset($_POST["Edit"]))
		{
			?><input type="submit" name="Update" value="Update"><?php
		}
		else
		{
		  ?><input type="submit" name="insert" value="Submit"><?php
		}
	
		?>
	   
	
</form>
<!-----------------------form End------------------------>




<table border="1" cellpadding="1">
<thead>
	<tr>
		<th>Student Id</th>
		<th>Name</th>
		<th>Phone</th>
		<th>Email</th>
		<th>Pasword</th>
		<th>Gender</th>
		<th>Subjects</th>
		<th>Counrty</th>
		<th>City</th>
		<th>Date of birth</th>
		<th>Image</th>
		<th>CV</th>
		<th>Actions</th>
	</tr>
</thead>
	<tbody>
		<?php
		$query=mysqli_query($con,"select * from students ");
		while($row=mysqli_fetch_array($query))
		{
			?>
			<tr>
				<td><?php echo $row[0]?></td>
				<td><?php echo $row[1]?></td>
				<td><?php echo $row[2]?></td>
				<td><?php echo $row[3]?></td>
				<td><?php echo $row[4]?></td>
				<td><?php echo $row[5]?></td>
				<td><?php echo $row[6]?></td>
				<td><?php echo $row[7]?></td>
				<td><?php echo $row[8]?></td>
				<td><?php echo $row[10]?></td>
				<td>
					<img src="data:image/jpeg;base64,<?php echo base64_encode($row[11])?>" width="100" alt="">
				</td>
				<td>
					<a href="data:document/pdf;base64,<?php echo base64_encode($row[12])?>" download="<?php echo $row[1]?>_CV.pdf" >download</a>
				</td>
				<td>
					<form action="index.php" method="post">
						<input type="hidden" value="<?php echo $row[0]?>" name="Edit_id">
						<input type="submit" value="Edit" name="Edit" >
					</form>
					
					<a href="index.php?delete_id=<?php echo $row[0]?>"><img src="delete.png" width="25" alt=""></a>
					
				</td>
			</tr>
			
			<?php
		}
		
		?>
	</tbody>
</table>










<script>

 function changeCities()
	{
		var country = document.getElementById('country').value;
		//alert(country);
		var city=document.getElementById('city');
		switch(country)
			{
				case "Pakistan": 
					city.innerHTML="<option>--select city--</option><option>Karachi</option><option>Islamabad</option><option>Hyderbad</option>";
					break;
					
				case "China": 
					city.innerHTML="<option>--select city--</option><option>Bejing</option><option>Shanghai</option><option>ching chung</option>";
					break;
					
				case "Iraq": 
					city.innerHTML="<option>--select city--</option><option>Baghdad</option><option>Basra</option><option>Najaf</option>";
					break;
					
			}
		
		
	}

</script>








