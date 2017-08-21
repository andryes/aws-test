<div class="container">
	<h3 class="notes_H">Notes for each task (in progress)</h3>
</div>

<!-- List of notes (accordion) -->

<div class="container">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div id="accordion" class="panel-group">

				<?php
					include_once('pages/functions.php');
					connect();
					$sel='SELECT * FROM notes WHERE userid="'.$_SESSION['id'].'" ORDER BY id';
					$res=mysql_query($sel);
					$delbut = 'Delete note&nbsp;&nbsp;<i class="fa fa-trash-o"></i>';
					$delname = 'delb';
					$vis = 'style="visibility: collapse;"'; // Hide button "Delete note"
					if(isset($_POST['delb'])) {
					// Show elements "close" for each note (action for "Delete note")
						$delbut = '&nbsp; Cancel &nbsp;';
						$delname = 'delcanc';
						$vis = 'style="visibility: visible;"';
					}
					if(isset($_POST['delcanc'])) { // Cancel delete
						unset($rem);
						$delname = 'delb';
						$vis = 'style="visibility: collapse;"';
					}
					while ($row=mysql_fetch_array($res, MYSQL_ASSOC)) { // List of notes from DB
						echo
						'<form action="" method="post">
							<div class="panel panel-info">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a href="#collapse-'.$row['id'].'" data-parent="#accordion" data-toggle="collapse">'.$row['name'].'</a>
										<button type="submit" class="close" name="'.$row['id'].'" '.$vis.'>
											<i class="glyphicon glyphicon-remove" style="margin-top: -3px"></i>
										</button>
									</h4>
								</div>
								<div id="collapse-'.$row['id'].'" class="panel-collapse collapse">
									<div class="panel-body">
										<p>'.$row['text'].'</p>
									</div>
								</div>
							</div>
						</form>';

						if(isset($_POST[$row['id']])) { // Delete button handler
							$deln='DELETE FROM notes WHERE id="'.$row['id'].'"';
							connect();
							mysql_query($deln);
							pageReload();
						}
					}
				?>

			</div>
		</div>
	</div>
</div>

<!-- ==================== Create note (modal window) ==================== -->

<div class="container">
	<div class="row" style="margin-top: 200px">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div class="modal fade" id="modal-2">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" type="button" data-dismiss="modal">
								<i class="glyphicon glyphicon-remove"></i>
							</button>
							<h4 class="modal-title">New note</h4>
						</div>
						<div class="modal-body">
							<form action="" class="" method="POST">
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
							</form>
						</div>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modal-2" id="create-note">
				<i class="fa fa-plus"></i> Create note
			</button>
			<form action="" method="post">
				<button type="submit" name="<?echo $delname;?>" class="btn btn-info navbar-right" 
				style="margin-top: -30px;">
					<?echo $delbut;?>
				</button>
			</form>
		</div>
	</div>
</div>

<?php // "Create note" button handler (put notes in DB)
	if(isset($_POST['addnote'])) {
		if(!isset($_SESSION['id'])) {
			pleaseReg();
		} else {
			$name=trim(htmlspecialchars($_POST['name']));
			$text=trim(htmlspecialchars($_POST['text']));
			$ins='INSERT INTO notes (name, text, userid) VALUES ("'.$name.'", "'.$text.'", "'.$_SESSION['id'].'")';
			connect();
			mysql_query($ins);
			pageReload();
		}
	}
?>

<div style="height: 200px"></div>
