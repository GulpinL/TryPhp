<?php 

	include('model/db_connect.php');

	// write query for all pizzas
	$sql = 'SELECT clubid, clubname, stadiumid FROM club';

	// get the result set (set of rows)
	$result = mysqli_query($conn, $sql);

	// fetch the resulting rows as an array
	$clubs = mysqli_fetch_all($result, MYSQLI_ASSOC);

	// free the $result from memory (good practise)
	mysqli_free_result($result);

	// close connection
	mysqli_close($conn);


?>
<h4 class="center grey-text">Long!</h4>

	<div class="container">
		<div class="row">

			<?php foreach($clubs as $monoclub): ?>

				<div class="col s6 m4">
					<div class="card z-depth-0">
						<div class="card-content center">
							<h6><?php echo htmlspecialchars($monoclub['clubid']); ?></h6>
							<h6><?php echo htmlspecialchars($monoclub['clubname']); ?></h6>
							
						</div>
						<div class="card-action right-align">
							<a class="brand-text" href="#">more info</a>
						</div>
					</div>
				</div>

			<?php endforeach; ?>

		</div>
	</div>