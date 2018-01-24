<div class="container">
    <h3 class="notes_H">Notes for each task (in progress)</h3>
</div>
<!-- List of notes (accordion) -->
<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <?php if( isset( $_SESSION['id'] ) ) { ?>
                <div id="accordion" class="panel-group">
                    <?php
                    $delbut  = 'Delete note&nbsp;&nbsp;<i class="fa fa-trash-o"></i>';
                    $delname = 'delb';
                    $vis     = 'style="visibility: collapse;"'; // Hide button "Delete note"
                    if ( isset( $_POST['delb'] ) ) {
                        // Show elements "close" for each note (action for "Delete note")
                        $delbut  = '&nbsp; Cancel &nbsp;';
                        $delname = 'delcanc';
                        $vis     = 'style="visibility: visible;"';
                    }
                    if ( isset( $_POST['delcanc'] ) ) { // Cancel delete
                        unset( $rem );
                        $delname = 'delb';
                        $vis     = 'style="visibility: collapse;"';
                    }
                    $sql = $pdo->query ( 'SELECT * FROM notes WHERE userid="' . $_SESSION['id'] . '" ORDER BY id' );
                    while ( $row = $sql->fetch( PDO::FETCH_ASSOC ) ) { // List of notes from DB
                        echo '<form action="" method="post">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="#collapse-' . $row['id'] . '" data-parent="#accordion" data-toggle="collapse">' . $row['name'] . '</a>
                                            <button type="submit" class="close" name="' . $row['id'] . '" ' . $vis . '>
                                                <i class="glyphicon glyphicon-remove remove-note"></i>
                                            </button>
                                        </h4>
                                    </div>
                                    <div id="collapse-' . $row['id'] . '" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <p>' . $row['text'] . '</p>
                                        </div>
                                    </div>
                                </div>
                            </form>';
                        if ( isset( $_POST[ $row['id'] ] ) ) { // Delete button handler
                            $sql = 'DELETE FROM notes WHERE id="' . $row['id'] . '"';
                            $pdo->query( $sql );
                            pageReload();
                        }
                    } ?>
                </div>
            <?php } else {
                echo '<p class="reg-for-notes">You should be registered to use notes</p>';
	            $delbut  = 'Delete note&nbsp;&nbsp;<i class="fa fa-trash-o"></i>';
            } ?>
        </div>
    </div>
</div>
<!-- Create note (modal window) -->
<div class="container">
    <div class="row create-note">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="modal fade" id="modal-2">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">
                                <i class="glyphicon glyphicon-remove"></i>
                            </button>
                            <h4 class="modal-title">
                                New note
                                <?php if ( ! isset( $_SESSION['id'] ) ) {
									echo ' (you should be registered for this action)';
								} ?>
                            </h4>
                        </div>
                        <form action="" class="" method="POST">
                            <div class="modal-body">
                                    <div class="form-group form-group-sm">
                                        <input name="name" type="text" class="form-control" placeholder="Article">
                                    </div>
                                    <div class="form-group form-group-sm">
                                        <textarea name="text" class="form-control" placeholder="Full text" rows="10"></textarea>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <input type='submit' name='addnote' value='Add note' class='btn btn-success'>
                                <button class="btn btn-danger" type="submit" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modal-2" id="create-note">
                <i class="fa fa-plus"></i> Create note
            </button>
            <form action="" method="post">
                <button type="submit" name="<?php echo $delname; ?>" class="btn btn-info navbar-right del-note">
					<?php echo $delbut; ?>
                </button>
            </form>
        </div>
    </div>
</div>

<?php // "Create note" button handler (put notes in DB)
if ( isset( $_POST['addnote'] ) ) {
	if ( ! isset( $_SESSION['id'] ) ) {
		pleaseReg();
	} else {
		$name = trim( htmlspecialchars( $_POST['name'] ) );
		$text = trim( htmlspecialchars( $_POST['text'] ) );
		$sql  = 'INSERT INTO notes (name, text, userid) VALUES ("' . $name . '", "' . $text . '", "' . $_SESSION['id'] . '")';
		$pdo->query( $sql );
		pageReload();
	}
} ?>
