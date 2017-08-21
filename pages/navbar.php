<!-- Modal box with registration -->

<?php
	include_once('pages/register.php');
	include_once('pages/functions.php');
?>

<!-- ========================= Navbar + authorization form ========================= -->

<div class="navbar navbar-inverse navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" rel="home" href="index.php">
		        <img style="max-width: 120px; margin-top: -10px;" src="images/logo.png">
		    </a>
		</div>
		<ul class="nav navbar-nav">

			<?php // "Active" page handler
				if(isset($_GET['page'])) {
					if($_GET['page']=='notes')$notes='active';
					if($_GET['page']=='about')$about='active';
				} else {
					$tasks='active';
				}
			?>

			<li class="<?echo $tasks;?>"><a href="index.php">TASKS</a></li>
			<li class="<?echo $notes;?>"><a href="index.php?page=notes">NOTES</a></li>
			<li class="<?echo $about;?>"><a href="index.php?page=about">ABOUT</a></li>
		</ul>

		<?php // Greetings for authorized user
			if (isset($_SESSION['login'])) {
				echo '
				<form action="index.php';
				if (isset($_GET['page'])) echo '?page='.$_GET['page'];
				echo '" class="navbar-form navbar-right" method="post" id="first-form">
				<span style="color: #5B65C2; font-size: 120%" >Welcome, '.$_SESSION['login'].'! &nbsp;</span>
				<button type="submit" name="ex" class="btn btn-sm btn-primary" id="ex">SIGN OUT &nbsp;<i class="glyphicon glyphicon-log-out"></i></button>
				</form>';
			} else {
		?>

		<!-- Sign in and register -->
		<button type="submit" class="btn btn-sm btn-info navbar-right" data-toggle="modal" data-target="#modal-1" id="reg-form"><i class="fa fa-user-plus"></i> REGISTER
		</button>
		<form action="" class="navbar-form navbar-right" method="POST" id="first-form">
			<div class="form-group form-group-sm">
				<input type="text" name="logname" class="form-control" placeholder="Login" value="">
			</div>
			<div class="form-group form-group-sm">
				<input type="password" name="logpass" class="form-control" placeholder="Password" value="">
			</div>
			<button type="submit" name='log' class="btn btn-sm btn-primary">
				<i class="glyphicon glyphicon-user"></i> SIGN IN
			</button>
		</form>

		<? } ?>

		<?php // User data handler (function Login, page/functions.php)
			if(isset($_POST['log'])) {
			  login($_POST['logname'],$_POST['logpass']);
			}
		?>

		<?php // Exit button
			if(isset($_POST['ex'])) {
				unset($_SESSION['login']);
				unset($_SESSION['id']);
				session_destroy();
				pageReload();
			}
		?>
		
	</div>
</div>
