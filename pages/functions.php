<?php

function connect($host = "127.0.0.1:3306", $user = "aws-test", $pass = "Abc123", $dbname = "aws_test") {
	$link = mysql_connect($host, $user, $pass); //or die ('Connection error')
	mysql_select_db($dbname); //or die ('db select error')
	mysql_query('set names "utf8"');
}

function register($name, $pass, $role) {
	$name = trim(htmlspecialchars($name));
	$pass = trim(htmlspecialchars($pass));

	if ($name == "" || $pass == "") {
		echo "<script>
				window.onload = function() {
					alert('Fill all required fields');
					window.location=document.URL;
				}
			</script>";
		return false;
	}

	if (strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
		echo "<script>
				window.onload = function() {
					alert('From 3 to 30 symbols required');
					window.location=document.URL;
				}
			</script>";
		return false;
	}

	$ins = 'INSERT INTO users (login, pass, roleid) VALUES("'.$name.'", "'.md5($pass).'", "'.$role.'")';
	connect();
	mysql_query($ins);
	$err = mysql_errno();
	
	if ($err) {
		if($err == 1062) {
			echo "<script>
					window.onload = function() {
						alert('Choose another login');
						window.location=document.URL;
					}
				</script>";
		} else {
			echo "<script>
					window.onload = function() {
						alert('Error');
						window.location=document.URL;
					}
				</script>";
		}
		return false;
	}
	return true;
}

function login($logname, $logpass) {
	$logname = trim(htmlspecialchars($logname));
	$logpass = trim(htmlspecialchars($logpass));
	
	if ($logname == "" || $logpass == "") {
		echo "<script>
				window.onload = function() {
					alert('Fill all required fields');
				}
			</script>";
		return false;
	}

	if (strlen($logname) < 3 || strlen($logname) > 30 || strlen($logpass) < 3 || strlen($logpass) > 30) {
		echo "<script>
				window.onload = function() {
					alert('From 3 to 30 symbols required');
				}
			</script>";
		return false;
	}
	
	connect();
	$sel = 'SELECT * FROM users WHERE login ="'.$logname.'" and pass="'.md5($logpass).'"';
	$res = mysql_query($sel);
	if($row = mysql_fetch_array($res, MYSQL_NUM)) {
		$_SESSION['id'] = $row[0];
		$_SESSION['login'] = $row[1];
		$_SESSION['pass'] = $row[2];
		$_SESSION['role'] = $row[3];
		echo'<script>window.location=document.URL</script >';
	}

	if (!$_SESSION['login']) {
		echo "<script>
				window.onload = function() {
					alert('Wrong login or password');
				}
			</script>";
		return false;
	}
}

function pleaseReg() {
	echo "<script>
			window.onload = function() {
				alert('Please register or sign in for this action');
			}
		</script>";
}

function pageReload() {
	echo "<script>
			window.location=document.URL
		</script>";
}
?>
