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
     
    <FORM name='fmLogin' method='POST' action='dashboard.php?menu=login' class="login-form">
    <INPUT type="text" name="uid" size='4' placeholder="user ID" class="login-input" />
    <INPUT type="submit" value="Log in" class="login-button"/>
    </FORM>
  <?php
}
function getName($db, $uid){
	$sql = "SELECT userID 
		FROM shop_user
		WHERE userID=$uid";
	$res = $db->query($sql);
	if ($res != FALSE && $res->rowCount() == 1) {
        $nameRow = $res->fetch();
        return $nameRow['name'];
    }
  	  else {
        	return "Unknown";
    	} 


}
  ?>
