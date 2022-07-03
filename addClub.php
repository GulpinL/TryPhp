<?php

	include('model/db_connect.php');

	$clubid = $clubname = $shortname =$stadiumid =$coachid ='';
	$errors = array('clubid' => '', 'clubname' => '', 'shortname' => '', 'stadiumid' => '', 'coachid' => '');

	if(isset($_POST['submit'])){
		


		// check clubname
		if(empty($_POST['clubname'])){
			$errors['clubname'] = 'A clubname is required';
		} else{
			$clubname = $_POST['clubname'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $clubname)){
				$errors['clubname'] = 'clubname must be letters and spaces only';
			}
		}

		// check shortname
		if(empty($_POST['shortname'])){
			$errors['shortname'] = 'At least one ingredient is required';
		} else{
			$shortname = $_POST['shortname'];
			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $shortname)){
				$errors['shortname'] = 'shortname must be a comma separated list';
			}
		}

		if(array_filter($errors)){
			//echo 'errors in form';
		} else {
			// escape sql chars
			$clubid = mysqli_real_escape_string($conn, $_POST['clubid']);
			$clubname = mysqli_real_escape_string($conn, $_POST['clubname']);
			$shortname = mysqli_real_escape_string($conn, $_POST['shortname']);
			$stadiumid = mysqli_real_escape_string($conn, $_POST['stadiumid']);
			$coachid = mysqli_real_escape_string($conn, $_POST['coachid']);

			// create sql
			$sql = "INSERT INTO club(clubname,clubid,shortname,stadiumid,coachid) VALUES('$clubname','$clubid','$shortname','$stadiumid','$coachid')";

			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				header('Location: index.php');
			} else {
				echo 'query error: '. mysqli_error($conn);
			}

			
		}

	} // end POST check

?>

<!DOCTYPE html>
<html>
	
	<?php include('views/templates/header.php'); ?>

	<section class="container grey-text">
		<h4 class="center">Add Club</h4>
		<form class="white" action="addClub.php" method="POST">
			<label>Club Id</label>
			<input type="text" name="clubid" value="<?php echo htmlspecialchars($clubid) ?>">
			<div class="red-text"><?php echo $errors['clubid']; ?></div>

			<label>Club name</label>
			<input type="text" name="clubname" value="<?php echo htmlspecialchars($clubname) ?>">
			<div class="red-text"><?php echo $errors['clubname']; ?></div>

			<label>Club short name (comma separated)</label>
			<input type="text" name="shortname" value="<?php echo htmlspecialchars($shortname) ?>">
			<div class="red-text"><?php echo $errors['shortname']; ?></div>
            

			<label>Stadium Id</label>
			<input type="text" name="stadiumid" value="<?php echo htmlspecialchars($stadiumid) ?>">
			<div class="red-text"><?php echo $errors['stadiumid']; ?></div>

			<label>Coach Id</label>
			<input type="text" name="coachid" value="<?php echo htmlspecialchars($coachid) ?>">
			<div class="red-text"><?php echo $errors['coachid']; ?></div>

			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>
	

	<?php include('views/templates/footer.php'); ?>

</html>