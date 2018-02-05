<?php

function connect( $host = "127.0.0.1:3306", $user = "todo", $pass = "Abc123", $dbname = "todo" ) {
	return new PDO( "mysql:host=$host;dbname=$dbname", $user, $pass, array( PDO::ATTR_PERSISTENT => true ) );
}

function register( $name, $pass, $role ) {
	$name = trim( htmlspecialchars( $name ) );
	$pass = trim( htmlspecialchars( $pass ) );
	if ( $name == "" || $pass == "" ) {
		fillFields();
		return false;
	}
	if ( strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30 ) {
		inputLength();
		return false;
	}
	$pdo = connect();
	$ins = 'INSERT INTO users (login, pass, roleid) VALUES("'.$name.'", "'.md5($pass).'", "'.$role.'")';
	$pdo->query( $ins );
//	$err = mysql_errno();
//	if ( $err ) {
//		if( $err == 1062 ) {
//			echo "<script>window.onload = function() { alert( 'Choose another login' ); window.location=document.URL; }</script>";
//		} else {
//			echo "<script>window.onload = function() { alert( 'Error' ); window.location=document.URL; }</script>";
//		}
//		return false;
//	}
	return true;
}

function login( $logname, $logpass ) {
	$logname = trim( htmlspecialchars( $logname ) );
	$logpass = trim( htmlspecialchars( $logpass ) );
	if ( $logname == "" || $logpass == "" ) {
		fillFields();
		return false;
	}
	if ( strlen( $logname ) < 3 || strlen( $logname ) > 30 || strlen( $logpass ) < 3 || strlen( $logpass ) > 30 ) {
		inputLength();
		return false;
	}
	$pdo = connect();
	$sel = 'SELECT * FROM users WHERE login ="'.$logname.'" and pass="'.md5( $logpass ).'"';
	$sql = $pdo->query( $sel );
	if ( $row = $sql->fetch( PDO::FETCH_NUM ) ) {
		$_SESSION['id'] = $row[0];
		$_SESSION['login'] = $row[1];
		$_SESSION['pass'] = $row[2];
		$_SESSION['role'] = $row[3];
		echo'<script>window.location=document.URL</script >';
	}
	if ( ! $_SESSION['login'] ) {
		echo "<script>window.onload = function() { alert( 'Wrong login or password' ); }</script>";
		return false;
	}
}

function pleaseReg() {
	echo "<script>window.onload = function() { alert( 'Please register or sign in for this action' ); }</script>";
}

function pageReload() {
	echo "<script>window.location=document.URL</script>";
}

function fillFields() {
	echo "<script>window.onload = function() { alert( 'Fill all required fields' ); window.location=document.URL; }</script>";
}

function inputLength() {
	echo "<script>window.onload = function() { alert( 'From 3 to 30 symbols required' ); window.location=document.URL; }</script>";
}
