
<?php // Options for mother and father (upload and distribute tasks)
	if($_SESSION['role'] == 1) { ?>
		<!-- If mother -->
		<form action="" method="POST" enctype="multipart/form-data" class="upload">
			<div class="form-group">
				<label for="file">Upload tasks list (option for mother only):</label>
				<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
				<input type="file" name="file" id="file" class="form-control">
				<button type="submit" name="upfile" class="btn btn-primary btn-list">Send</button>
			</div>
		</form>

	<?php // Upload file handler (for mother)
		if(isset($_POST['upfile'])) {
			if( !empty( $_FILES['file']['name'] ) ) {
				if ( $_FILES['file']['error'] == 0 ) {
					move_uploaded_file( $_FILES['file']['tmp_name'], "files/".$_FILES['file']['name'] );
					connect();
					$dl = 'DELETE FROM upl_task';
					$ins = "LOAD DATA INFILE 'c:/OpenServer/domains/localhost/files/".$_FILES['file']['name']."' INTO TABLE upl_task";
					mysql_query($dl);
					mysql_query($ins);
					echo '<h3 style="color: green;">File uploaded successfully</h3>'.'<br>';
				}
			}
		}
	?>

	<? } elseif ($_SESSION['role'] == 2) { ?>
		<!-- If father -->
		<form action="" method="post" class="upload">
			<p>Distribute new tasks (option for father only):</p>
			<table class="table table-striped distr">

			<?php // Forming table with tasks and related users

				// Head of the table
				echo '
					<tr>
						<th class="task">Tasks</th>
						<th class="child">User</th>
						<th class="child">Period</th>
					</tr>';

				// Column "Tasks"
				$task = 'SELECT * FROM upl_task';
				$res2 = mysql_query($task);
				while ($row2 = mysql_fetch_array($res2, MYSQL_ASSOC)) {
					echo '<tr>
							<td>'.$row2['task'].'</td>';

						// Column "User"
						echo '<td class="tab_align">
								<select name="'.$row2['task'].'">
									<option></option>';

									$check = 'SELECT * FROM users WHERE roleid = 3';
									$res3 = mysql_query($check);
									while ($row3 = mysql_fetch_array($res3, MYSQL_ASSOC)) {
										echo '<option value="'.$row3['id'].'">'.$row3['login'].'</option>';
									};

							echo '</select>
							</td>';
						
						// Column "period"
						echo '
						<td class="tab_align">
							<select name="period">
								<option value="tasks_day">Day</option>
								<option value="tasks_week">Week</option>
								<option value="tasks_month">Month</option>
								<option value="tasks_year">Year</option>
							</select>
						</td>
					</tr>';
				}
			?>

			</table>
			<button type="submit" name="distr" id="distr" class="btn btn-primary distr_tasks">OK</button>
		</form>

<?php // Distribute tasks handler (for father)
	if(isset($_POST['distr'])) {
		var_dump($_POST);
		// to do
	}
?>

	<? } else { }
?>
