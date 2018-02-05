<?php // Options for admin and contributor (upload and distribute tasks)
if ( isset( $_SESSION['role'] ) && $_SESSION['role'] == 1 ) { ?>
    <!-- If admin -->
    <form action="" method="POST" enctype="multipart/form-data" class="upload">
        <div class="form-group">
            <label for="file">Upload your .txt file with tasks list (each task shoud be on new line)</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
            <input type="file" name="file" id="file" class="form-control">
            <button type="submit" name="upfile" class="btn btn-primary btn-list">Send</button>
        </div>
    </form>

	<?php // Upload file handler (for admin)
	if ( isset( $_POST['upfile'] ) ) {
		if ( ! empty( $_FILES['file']['name'] ) ) {
			if ( $_FILES['file']['error'] == 0 ) {
				move_uploaded_file( $_FILES['file']['tmp_name'], "files/" . $_FILES['file']['name'] );
				$path = realpath( './files/' ) . '/' . $_FILES['file']['name'];
				$sql  = 'LOAD DATA INFILE \'' . $path . '\' INTO TABLE upl_task(task, datetime) SET datetime = NOW()';
				if ( $pdo->query( $sql ) ) {
					rename( $path, realpath( './files/' ) . '/tasks_' . date( "m.d.y_H:i:s" ) );
					echo '<h3 class="tasks-upl-p">Tasks uploaded successfully</h3><br>';
				}
			}
		}
	} ?>

<? } elseif ( isset( $_SESSION['role'] ) && $_SESSION['role'] == 2 ) { ?>
    <!-- If contributor -->
    <form action="" method="post" class="upload">
        <p>Distribute new tasks (option for contributor only)</p>
        <table class="table table-striped distr">

			<?php // Forming table with tasks and related users
			// Head of the table
			echo '<tr>
                      <th class="task">Task</th>
				      <th class="child">User</th>
				      <th class="child">Period</th>
                  </tr>';

			// Column "Tasks"
			$stmt = 'SELECT * FROM upl_task';
			$res = $pdo->query( $stmt );
			while ( $row = $res->fetch( PDO::FETCH_ASSOC ) ) {
			    global $tsk;
				$tsk = &$row['task'];
				echo '<tr>
					      <td>' . $row['task'] . '</td>';

				// Column "User"
				echo '<td class="tab_align">
				        <select name="' . $tsk . '">';
				// <option></option>
				$stmt = 'SELECT * FROM users WHERE roleid = 3';
				$sql = $pdo->query( $stmt );
				while ( $row = $sql->fetch( PDO::FETCH_ASSOC ) ) {
					echo '<option value="' . $row['id'] . '">' . $row['login'] . '</option>';
				}
				echo   '</select>
			          </td>';

				// Column "period"
                echo '<td class="tab_align">
				        <select name="period_' . $tsk . '">';
                $stmt2 = 'SHOW TABLES WHERE Tables_in_todo LIKE \'tasks_%\'';
				$sql2 = $pdo->query( $stmt2 );
				while ( $row = $sql2->fetch( PDO::FETCH_NUM ) ) {
					echo '<option value="' . $row['0'] . '">' . ucfirst( substr( $row['0'], 6 ) ) . '</option>';
				}
				echo   '</select>
			          </td>';
			} ?>

        </table>
        <button type="submit" name="distr" id="distr" class="btn btn-primary distr_tasks">OK</button>
    </form>
    <br><br><br>

	<?php // Distribute tasks handler (for contributor)
	if ( isset( $_POST['distr'] ) ) {
        foreach ( $_POST as $key => $val ) {
            if ( ! ereg( 'period_*', $key ) AND ! ereg( 'distr', $key ) ) {
	            if ( $_POST["period_$key"] ) {
	                $table_name =  $_POST["period_$key"];
	            }
	            $sql = 'INSERT INTO ' . $table_name . ' (tasks, userid) VALUES ("' . $key . '", "' . $val . '");
	                    DELETE FROM upl_task WHERE task="' . $key . '";';
	            $pdo->query( $sql );
            }
        }
        pageReload();
	} ?>

<?php } else {
	echo '<br><h5 class="admin-rights">You have no admin rights</h5><br>';
} ?>
