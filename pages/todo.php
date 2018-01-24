
<!-- Main big container -->
<div class="container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="todo_H">To do</h2>
            </div>
        </div>
    </div>
    <!-- Blocks with tasks -->
    <div class="container">
        <div class="row">
            <div class="col-md-2 leftpanel">
                <div>
                    <p class="tasksfor">Tasks for:</p>
                </div>
                <form action="" method="post">
                    <div class="btn-group-vertical period">
						<?php // Active button handler
						if ( isset( $_GET['per'] ) ) {
							if ( $_GET['per'] == 'day' ) {
								$chose_day = 'active';
							} elseif ( $_GET['per'] == 'week' ) {
								$chose_week = 'active';
							} elseif ( $_GET['per'] == 'month' ) {
								$chose_month = 'active';
							} elseif ( $_GET['per'] == 'year' ) {
								$chose_year = 'active';
							}
						} else {
							$chose_day = 'active';
						} ?>
                        <a href="index.php?per=day" class="btn btn-info <?php if ( ! empty( $chose_day ) ) { echo $chose_day; } ?>">Day</a>
                        <a href="index.php?per=week" class="btn btn-info <?php if ( ! empty( $chose_week ) ) { echo $chose_week; } ?>">Week</a>
                        <a href="index.php?per=month" class="btn btn-info <?php if ( ! empty( $chose_month ) ) { echo $chose_month; } ?>">Month</a>
                        <a href="index.php?per=year" class="btn btn-info <?php if ( ! empty( $chose_year ) ) { echo $chose_year; } ?>">Year</a>
                    </div>
                    <button type="submit" name="delall" class="btn btn-info period delall-btn">Delete all</button>
					<?php // Period switcher handler
					if ( isset( $_GET['per'] ) ) {
						$per     = $_GET['per'];
						$tbname  = 'tasks_' . $per;
						$tbname2 = 'done_' . $per;
					} else {
						$tbname  = 'tasks_day';
						$tbname2 = 'done_day';
					}
					// "Delete all" button handler
					if ( isset( $_POST['delall'] ) ) {
						if ( ! isset( $_SESSION['id'] ) ) {
							pleaseReg();
						} else {
							$sql = 'DELETE FROM ' . $tbname2 . ';
							        DELETE FROM ' . $tbname;
							$pdo->query( $sql );
							pageReload();
						}
					} ?>
                </form>
            </div>
            <div class="col-md-10">
                <form action="" method="post">
                    <div class="col-md-5">
                        <div class="tasks">
                            <p class="first_p">Tasks:</p>
	                        <?php // "Tasks" div handler
                            if ( isset( $_SESSION['id'] ) ) {
                                $stmt = 'SELECT * FROM '.$tbname.' WHERE userid="'.$_SESSION['id'].'" ORDER BY id';
                                $sql = $pdo->query ( $stmt );
                                while ( $row = $sql->fetch( PDO::FETCH_NUM ) ) {
                                    echo '&nbsp;<input type="radio" name="radiobutton" value="' . $row[1] . '" id="' . $row[0] . '">
                                                <label for="' . $row[0] . '"><span class="line">' . $row[1] . '</span></label>' . '<br>';
                                }
                            } else {
                                echo '<p class="centered">Put your tasks here</p>';
                            } ?>
                        </div>
                        <div>
                            <button type="submit" name="choose" class="btn btn-primary done-btn">
                                <i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Done!
                            </button>
                        </div>
	                    <?php // "Done" button handler
	                    if ( isset( $_POST['choose'] ) ) {
		                    if ( ! isset( $_SESSION['id'] ) ) {
			                    pleaseReg();
		                    } else {
		                        $sql = 'INSERT INTO ' . $tbname2 . ' (done, userid) VALUES ("' . $_POST['radiobutton'] . '", "' . $_SESSION['id'] . '");
		                                DELETE FROM ' . $tbname . ' WHERE tasks="' . $_POST['radiobutton'] . '"';
			                    $pdo->query( $sql );
			                    pageReload();
		                    }
	                    } ?>
                    </div>
                    <div class="col-md-5">
                        <div class="done">
                            <p class="first_p">Done:</p>
                            <?php // "Done" div handler
                            if ( isset( $_SESSION['id'] ) ) {
                                $stmt = 'SELECT * FROM ' . $tbname2 . ' WHERE userid="' . $_SESSION['id'] . '" ORDER BY id';
	                            $sql = $pdo->query( $stmt );
	                            while ( $row = $sql->fetch( PDO::FETCH_NUM ) ) {
		                            echo '&nbsp;<input type="radio" name="radiobutton2" value="' . $row[1] . '" id="' . $row[0] . '">
                                                <label for="' . $row[0] . '"><span class="line">' . $row[1] . '</span></label>' . '<br>';
	                            }
                            } else {
	                            echo '<p class="centered">Mark tasks as "done"</p>';
                            } ?>
                        </div>
                        <button type="submit" name="deltask" class="btn btn-danger delete-btn">
                            Delete&nbsp;&nbsp;<i class="fa fa-trash-o"></i>
                        </button>
	                    <?php // "Delete" button handler
	                    if ( isset( $_POST['deltask'] ) ) {
		                    if ( ! isset( $_SESSION['id'] ) ) {
			                    pleaseReg();
		                    } else {
		                        $sql = 'DELETE FROM ' . $tbname2 . ' WHERE done="' . $_POST['radiobutton2'] . '"';
			                    $pdo->query( $sql );
			                    pageReload();
		                    }
	                    } ?>
                    </div>
                </form>
            </div>
        </div><!-- .row -->
    </div><!-- .container -->
    <!-- "Add task" form -->
    <div class="container">
        <div class="col-md-12 atf">
            <form action="" class="navbar-form add-task" method="POST">
                <b>New task:</b>
                <div class="form-group">
                    <input type="text" name="newtask" class="form-control users-add-task-btn" placeholder="Option for each user">
                </div>
                <button name="addnew" type="submit" class="btn btn-success add-btn">Add task</button>
            </form>
        </div>
    </div>

	<?php // "ADD TASK" button handler
	if ( isset( $_POST['addnew'] ) ) {
		if ( ! isset( $_SESSION['id'] ) ) {
			pleaseReg();
		} else {
		    $sql = 'INSERT INTO ' . $tbname . ' (tasks, userid) VALUES ("' . $_POST['newtask'] . '", "' . $_SESSION['id'] . '")';
			$pdo->query( $sql );
			pageReload();
		}
	} ?>

	<?php include_once('admins.php'); ?>

</div>
