<?php include_once('pages/functions.php'); ?>

<!-- Main big container -->

<div class="container">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="todo_H">To do</h2>
			</div>
		</div>
	</div>

	<!-- ========================= Blocks with tasks ========================= -->

	<div class="container">
		<div class="row">
			<div class="col-md-2" style="margin-left: -20px;">
				<div>
					<p class="tasksfor">Tasks for:</p>
				</div>
				<form action="" method="post">
					<div class="btn-group-vertical period">

						<?php // Active button handler
							if(isset($_GET['per'])) {
								if($_GET['per'] == 'day')$cld = 'active';
								if($_GET['per'] == 'week')$clw = 'active';
								if($_GET['per'] == 'month')$clm = 'active';
								if($_GET['per'] == 'year')$cly = 'active';
							} else {
								$cld = 'active';
							}
						?>

						<a href="index.php?per=day" class="btn btn-info <?echo $cld;?>">Day</a>
						<a href="index.php?per=week" class="btn btn-info <?echo $clw;?>">Week</a>
						<a href="index.php?per=month" class="btn btn-info <?echo $clm;?>">Month</a>
						<a href="index.php?per=year" class="btn btn-info <?echo $cly;?>">Year</a>
					</div>
					<button type="submit" name="delall" class="btn btn-info period delall-btn">Delete all</button>

					<?php // Period switcher handler
						if(isset($_GET['per'])) {
							$per = $_GET['per'];
							$tbname = 'tasks_'.$per;
							$tbname2 = 'done_'.$per;
						} else {
							$tbname = 'tasks_day';
							$tbname2 = 'done_day';
						}
 
						// "Delete all" button handler
						if(isset($_POST['delall'])) {
							if(!isset($_SESSION['id'])) {
								pleaseReg();
							} else {
								$delt1 = 'DELETE FROM '.$tbname2;
								$delt2 = 'DELETE FROM '.$tbname;
								connect();
								mysql_query($delt1);
								mysql_query($delt2);
								pageReload();
							}
						}
					?>

				</form>
			</div>
			<div class="col-md-5">
				<div class="tasks">
				<p class="first_p">Tasks:</p>

				<!-- First form starts -->
				
				<form action="" method="post">

				<?php // "Tasks" div handler
					@connect();
					$res = @mysql_query('SELECT * FROM '.$tbname.' WHERE userid="'.$_SESSION['id'].'" ORDER BY id');
					while($row = @mysql_fetch_array($res, MYSQL_NUM)) {
						echo '
						&nbsp;<input type="radio" name="radiobutton" value="'.$row[1].'" id="'.$row[0].'">
						<label for="'.$row[0].'"><span class="line">'.$row[1].'</span></label>'.'<br>';
					}
				?>

				</div>
			</div>
			<div class="col-md-5">
				<div class="done">
				<p class="first_p">Done:</p>

				<?php // "Done" div handler
					@connect();
					$res2 = @mysql_query('SELECT * FROM '.$tbname2.' WHERE userid="'.$_SESSION['id'].'" ORDER BY id');
					while($row2 = @mysql_fetch_array($res2, MYSQL_NUM)) {
						echo '
						&nbsp;<input type="radio" name="radiobutton2" value="'.$row2[1].'" id="'.$row2[0].'">
						<label for="'.$row2[0].'"><span class="line">'.$row2[1].'</span></label>'.'<br>';
					}
				?>

				</div>
			</div>
		</div>
	</div>

	<!-- ========================= Buttons ========================= -->

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<button type="submit" name="choose" class="btn btn-primary done-btn">
					<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Done!
				</button>

				<?php // "Done" button handler
					if(isset($_POST['choose'])) {
						if(!isset($_SESSION['id'])) {
							pleaseReg();
						} else {
							$remt = $_POST['radiobutton'];
							$rem = 'INSERT INTO '.$tbname2.' (done, userid) VALUES ("'.$remt.'", "'.$_SESSION['id'].'")';
							$delete = 'DELETE FROM '.$tbname.' WHERE tasks="'.$_POST['radiobutton'].'"';
							connect();
							mysql_query($rem);
							mysql_query($delete);
							pageReload();
						}
					}
				?>

				<button type="submit" name="deltask" class="btn btn-danger delete-btn">
					Delete&nbsp;&nbsp;<i class="fa fa-trash-o"></i>
				</button>

				<?php // "Delete" button handler
					if(isset($_POST['deltask'])) {
						if(!isset($_SESSION['id'])) {
							pleaseReg();
						} else {
							$delt = 'DELETE FROM '.$tbname2.' WHERE done="'.$_POST['radiobutton2'].'"';
							connect();
							mysql_query($delt);
							pageReload();
						}
					}
				?>
				
				</form>
				<!-- End of the form -->
			</div>
		</div>
	</div>

	<!-- ========================= "Add task" form ========================= -->

	<div class="container">
		<div class="col-md-12 atf">
			<form action="" class="navbar-form add-task" method="POST">
				<b>New task:</b>
				<div class="form-group">
					<input type="text" name="newtask" class="form-control" placeholder="Option for each user" rows="1" style="width: 430px;">
				</div>
				<button name="addnew" type="submit" class="btn btn-success add-btn">Add task</button>
			</form>
		</div>
	</div>

	<?php // "ADD TASK" button handler
		if(isset($_POST['addnew'])) {
			if(!isset($_SESSION['id'])) {
				pleaseReg();
			} else {
			$newt=$_POST['newtask'];
			$ins='INSERT INTO '.$tbname.' (tasks, userid) VALUES ("'.$newt.'", "'.$_SESSION['id'].'")';
			connect();
			mysql_query($ins);
			pageReload();
			}
		}
	?>

	<? include_once('pages/parents.php'); ?>

</div>
