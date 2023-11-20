<?php
session_start();
include_once("db_connect.php");
//we connect to database here
//include_once("db_connect.php");

function handleLoginForm($db){
?>
    <link rel="stylesheet" href="dashboard.css">
    <div class="gradient-background">
    <div class="login-container">
     
    <FORM name='fmLogin' method='POST' action='dashboard.php?op=login' class="login-form">
    <INPUT type="text" name="uid" size='4' placeholder="user ID" class="login-input" />
    <INPUT type="submit" value="Log in" class="login-button"/>
    </FORM>
  <?php
}

function handleSignUpForm($db){
    ?>
        <P>Please enter a username. Your unique user ID will be assigned to you upon account creation.</P>
        <link rel="stylesheet" href="dashboard.css">
        <div class="gradient-background">
        <div class="login-container">
         
        <FORM name='fmLogin' method='POST' action='dashboard.php?op=signedUp' class="login-form">
        <INPUT type="text" name="username" size='4' placeholder="Username" class="login-input" />
        <INPUT type="text" name="password" size='4' placeholder="Password" class="login-input" />
        <INPUT type="submit" value="Sign Up" class="login-button"/>
        </FORM>
      <?php
    }

function showTryAgain($db){
  ?>
    <P>That username already exists. Please try again.</P>
    <link rel="stylesheet" href="dashboard.css">
    <div class="gradient-background">
    <div class="login-container">
           
    <FORM name='fmLogin' method='POST' action='dashboard.php?op=signedUp' class="login-form">
    <INPUT type="text" name="username" size='4' placeholder="Username" class="login-input" />
    <INPUT type="text" name="password" size='4' placeholder="Password" class="login-input" />
    <INPUT type="submit" value="Sign Up" class="login-button"/>
    </FORM>
  <?php
}


function getName($db, $uid){
	$sql = "SELECT name 
		    FROM   shop_user
		    WHERE  userID = $uid";

	$res = $db->query($sql);

	if ($res != FALSE && $res->rowCount() == 1) {
        $nameRow = $res->fetch();
        return $nameRow['name'];
    }
  	else {
        return "Unknown";
    } 
}

function showLogoutForm() {
    ?>
        <FORM name='fmLogout' method='POST' action='dashboard.php?op=logout'>
        <INPUT type='submit' value='Logout' />
        </FORM>
    <?php
    }
  ?>