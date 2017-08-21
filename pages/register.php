<?php include_once('pages/functions.php'); ?>

<!-- ========================= Modal window with registration form ========================= -->

<div class="modal fade" id="modal-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal">
					<i class="glyphicon glyphicon-remove"></i>
				</button>
				<h3 class="modal-title">Registration Form</h3>
			</div>
			<div class="modal-body">
			
				<?php
					if (!isset($_POST['reg'])) {
				?>

				<form action='' method='post'>
					<div class="form-group">
						<label for='login'>Login:</label>
						<input type='text' name='login' class='form-control'>
					</div>
					<div class="form-group">
						<label for='pass'>Password:</label>
						<input type='password' name='pass' class='form-control'>
					</div>
					<div class="form-group">
						<label for="role">Role:</label>
						<select name="role" id="role" class="form-control">
							<option value="3">Child</option>
							<option value="1">Mother</option>
							<option value="2">Father</option>
						</select>
					</div>
				</div>

				<?php
					} else {
						if (register($_POST['login'], $_POST['pass'], $_POST['role'])) {
							// echo '<h3 style="color: green;">User Added Successfully</h3>'.'<br>';
							login($_POST['login'], $_POST['pass'], $_POST['role']);
						}
					}
				?>

				<div class="modal-footer">
					<input type='submit' name='reg' value='Register' class='btn btn-success'>
					<button class="btn btn-danger" type="button" data-dismiss="modal">&nbsp;Cancel&nbsp;</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
