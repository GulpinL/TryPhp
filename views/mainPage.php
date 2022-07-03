<?php 

	include('model/db_connect.php');

    if(isset($_GET['page'])){
		
		// escape sql chars
		$pageIndex = mysqli_real_escape_string($conn, $_GET['page']);
        if($pageIndex==0){
            $pageIndex=1;
        }
        $noClubPerPage=9;
        $noSkipClubPage=$noClubPerPage*($pageIndex-1);
		// make sql
		$sql = "SELECT * FROM club order by ClubID asc limit $noClubPerPage offset $noSkipClubPage ";

	}
	else{
        $sql = 'SELECT clubid, clubname, stadiumid FROM club';
    }

	// get the result set (set of rows)
	$result = mysqli_query($conn, $sql);

	// fetch the resulting rows as an array
	$clubs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    $limit = isset($_POST["limit-records"]) ? $_POST["limit-records"] : 9;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $limit;
    $result = $conn->query("SELECT * FROM club LIMIT $start, $limit");
    $customers = $result->fetch_all(MYSQLI_ASSOC);
    
    $result1 = $conn->query("SELECT count(ClubID) AS ClubID FROM club");
    $custCount = $result1->fetch_all(MYSQLI_ASSOC);
    $total = $custCount[0]['ClubID'];
    $pages = ceil( $total / $limit );
    $Previous = $page - 1;
    $Next = $page + 1;

	// free the $result from memory (good practise)
	mysqli_free_result($result);

	// close connection
	mysqli_close($conn);

?>
<h4 class="center grey-text">List Club</h4>

	<div class="container">
		<div class="row">

			<?php foreach($clubs as $monoclub): ?>

				<div class="col s6 m4">
					<div class="card z-depth-0">
						<div class="card-content center">
							<h6><?php echo htmlspecialchars($monoclub['ClubID']); ?></h6>
							<h6><?php echo htmlspecialchars($monoclub['ClubName']); ?></h6>
							
						</div>
						<div class="card-action right-align">
							<a class="brand-text" href="clubDetail.php?clubid=<?php echo $monoclub['ClubID'] ?>">Detail</a>
						</div>
					</div>
				</div>

			<?php endforeach; ?>

		</div>
        <!-- <ul class="pagination center">
            <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
            <li class="active"><a href="#!">1</a></li>
            <li class="waves-effect"><a href="#!">2</a></li>
            <li class="waves-effect"><a href="#!">3</a></li>
            <li class="waves-effect"><a href="#!">4</a></li>
            <li class="waves-effect"><a href="#!">5</a></li>
            <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
        </ul> -->
        <ul class="pagination center">
            <li class="disabled">
                <a href="index.php?page=<?= $Previous; ?>" aria-label="Previous">
                <!-- <span aria-hidden="true">&laquo; Previous</span> -->
                <i class="material-icons">chevron_left</i>
                </a>
            </li>

            <?php for($i = 1; $i<= $pages; $i++) : ?>
				    	<li><a href="index.php?page=<?= $i; ?>"><?= $i; ?></a></li>
				    <?php endfor; ?>

            <li class="disabled">
                <a href="index.php?page=<?= $Next; ?>" aria-label="Next">
                <!-- <span aria-hidden="true">Next &laquo; </span> -->
                <i class="material-icons">chevron_left</i>
                </a>
            </li>
        </ul>
	</div>

    
<script type="text/javascript">
	$(document).ready(function(){
		$("#limit-records").change(function(){
			$('form').submit();
		})
	})
</script>