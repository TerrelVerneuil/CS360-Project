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

function showSellForm($db){
  ?>
  <DIV class="main-content">
    <FORM name='fmListItem' action='?op=listedItem' method='POST'>
    <P>Please enter the information of the item you wish to sell.</P>
    <P>
    Name of Item:  
    <INPUT type='text' name='name'      placeholder='Item Name' />
    </P>
    <P>
    Price of Item: 
    <INPUT type='text' name='price'     placeholder='Item Price' />
    </P>
    <P>
    Brief Description of Item:  
    <INPUT type='text' name='desc'      placeholder='Item Description' />
    </P>
    <P>
    Select a Category for your Item:  
    <SELECT name="category">
      <OPTION value="Electronics">Electronics</OPTION>
      <OPTION value="Home Goods">Home Goods</OPTION>
      <OPTION value="Kitchen Ware">Kitchen Ware</OPTION>
      <OPTION value="Toys & Games">Toys & Games</OPTION>
    </SELECT>
    </P>
    <P>
    <INPUT type='submit' value='List Item'/>
    </P>
    </FORM>
  </DIV>
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

function showFilteredItems($db, $filters){
  echo("<DIV class='main-content'><H1>Items that fit your search</H1>");

  $search = $filters['searchbar'];

  
  $query = "SELECT *
            FROM item
            WHERE name LIKE '%$search%'";

  $condition = "WHERE ";

  for ($x = 1; $x <= 4; $x++) {
    if (isset($_POST['cb'.$x])) {
      $filter = $_POST['cb'.$x];
      $condition = $condition . "itemCat = '$filter' OR ";
    }
  }

  if($condition != "WHERE "){
    $condition = substr_replace($condition, "", -4) . ";";
    $query = "SELECT description, price FROM (" . $query . ") AS searched " . $condition;
  }

  $res = $db->query($query);
  
  //echo("<DIV class='main-content'><H1>".$query."</H1></DIV>");

  if($res != FALSE){
    while($row = $res->fetch()){
      echo("<DIV class='item'>");
      echo("<DIV class='item-box'>Null</DIV>");
      echo("<P>".$row['description']."</P>");
      echo("<BR>");                               //figure out how to create a new line.
      echo("<P>Price:".$row['price']."</P>");
      echo("</DIV>");
    }
  }

  echo("</DIV>");


}












  ?>
