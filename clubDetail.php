<?php 

	include('model/db_connect.php');

	// check GET request id param
	if(isset($_GET['clubid'])){
		
		// escape sql chars
		$id = mysqli_real_escape_string($conn, $_GET['clubid']);

		// make sql
		$sql = "SELECT * FROM club WHERE clubid = $id";

		// get the query result
		$result = mysqli_query($conn, $sql);

		// fetch result in array format
		$club = mysqli_fetch_assoc($result);

		mysqli_free_result($result);
		mysqli_close($conn);

        // print_r($club);

	}

    if(isset($_POST['delete'])){

		$id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

		$sql = "DELETE FROM club WHERE clubid = $id_to_delete";

		if(mysqli_query($conn, $sql)){
			header('Location: index.php');
		} else {
			echo 'query error: '. mysqli_error($conn);
		}

	}

?>

<!DOCTYPE html>
<html>

	<?php include('views/templates/header.php'); ?>

	<div class="container center">
		<?php if($club): ?>
			<h4><?php echo htmlspecialchars($club['ClubID']); ?></h4>
			<p>Name <?php echo htmlspecialchars($club['ClubName']); ?></p>
			<p>Short Name <?php echo htmlspecialchars($club['Shortname']); ?></p>
		
			<h5>Stadium Id:</h5>
			<p><?php echo htmlspecialchars($club['StadiumID']); ?></p>
		
			<h5>Coach Id:</h5>
			<p><?php echo htmlspecialchars($club['CoachID']); ?></p>
            <!--DETELETE-->
            <form action="clubDetail.php" method="POST">
                <input type="hidden" name="id_to_delete" value="<?php echo $club['ClubID']; ?>">
				<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
            </form>

            <?php else: ?>
			<h5>No such club exists.</h5>
		<?php endif ?>
	</div>

	<?php include('views/templates/footer.php'); ?>

</html>