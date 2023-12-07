<?php
    session_start();
    include("bootstrap.php");
    include("util.php");
    
?>  

<!DOCTYPE HTML>
<HTML lang="en">
<HEAD>  
    <meta charset="UTF-8">
    <link rel="stylesheet" href="dashboard.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=MuseoModerno' rel='stylesheet'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
</HEAD>
<BODY>

<?php
$op = "login";

if (isset($_GET['op'])) {
    $op = $_GET['op'];

    if ($op == 'login') {
        
        $_SESSION['uid'] = $_POST['uid'];
        $op = $_POST['dest'];
    }
    else if ($op == 'logout') {
        unset($_SESSION['uid']);
    }
    else if ($op == 'signedUp') {
        $newUser = $_POST['username'];
        $checkName = $db -> query("SELECT name
                                  FROM shop_user
                                  WHERE name = '$newUser'");
        if($checkName -> rowCount() == 0){
            $newPassword = $_POST['password'];
            $db->query("INSERT INTO shop_user(name, created_at, password) VALUES ('$newUser', NOW(), '$newPassword')");
            $getNewUID = $db -> query("SELECT userID FROM shop_user WHERE name = '$newUser'");
            $newUID = $getNewUID -> fetch()['userID'];
            $_SESSION['uid'] = $newUID;
        }
        else{
            showTryAgain($db);
            exit;
        }
    }
}

$uid = $_SESSION['uid'];
$uname = getName($db, $uid);

if (isset($_GET['op']) && $_GET['op']  == 'showLoginForm'){
		handleLoginForm($db, 'login', "");
   	 	exit;
}

if (isset($_GET['op']) && $_GET['op']  == 'showSignUpForm'){
    handleSignUpForm($db);
    exit;
}
if (isset($_GET['op']) && $_GET['op'] == 'showAccountManagement'){
    showAccountManagementForm($db,$uid);
    exit;
}
if (isset($_GET['op']) && $_GET['op'] == 'Account_Manage'){
	$newPassword=$_POST['newPassword'] ?? null;
	$confirmPassword = $_POST['confirmNewPassword']??null;
	$currentPassword= $_POST['currentPassword']??null;	
   $result = validateNewPassword($db,$uid,$currentPassword,$newPassword, $confirmPassword);     
	
	if($result == true){
	   //update the database password based on the uid
	   $db->query("UPDATE shop_user 
		   SET password=$newPassword
		WHERE userID='$uid'");
   }
   exit;
}
?>

<?php
    

	//show dashboard content

    //include("account_manage")
    //
    //the util file isnt implemented yet so this
    //so functionality will be missing
    //add a way to login
    //add a way to check purchase history
    //make filter work 
    //purchase
    //review
    //account mangagement(this is in conjunction with the login)
    //currently it should just redirect to login page, then
    //display everything that should be in account management
    //or just redirect to dashboard
    //so clicking username should help manage account
?>

<?php 
//echo("<div class='main-content'>$op</DIV>");

if($op == "searchItems"){
    showFilteredItems($db, $_POST);
}
else if($op == "sell"){
    if(!isset($_SESSION['uid'])){
        handleLoginForm($db, $op);
        exit;
    }
    else{
        showSellForm($db);
    }
}
else if($op == "listedItem"){
    listItem($_POST, $db, $uid);
}
else if($op == "displayItem"){
    displayItem($db, $_GET['IID']);
}
else if($op == "addedToCart"){
    if(!isset($_SESSION['uid'])){
        handleLoginForm($db, 'main');
        exit;
    }
    else{
        showSellForm($db);
    }
    echo("HELLO");
}
else{
?>

    <div class="main-content">
    <h1>Picked for you</h1>
    
    <div class="item">
        <div class="item-box">Null</div>
        <p>Item Description</p>
        <p>Item Price</p>
    </div>
    <div class="item">
        <div class="item-box">Null</div>
        <p>Item Description</p>
        <p>Item Price</p>
    </div>
    <div class="item">
        <div class="item-box">Null</div>
        <p>Item Description</p>
        <p>Item Price</p>
    </div>
    <div class="item">
        <div class="item-box">Null</div>
        <p>Item Description</p>
        <p>Item Price</p>
    </div>
    
</div>
<?php    
}
?>
<DIV class="sidenav">
<H2>MARKETPLACE</H2>

<?php
//this section icon should be pressed and prompt the user to a login page
	//following that it should log the user in when user name and pass word is specified. 
	//more functionality added later.

if (isset($_SESSION['uid'])) {

?>
	<a href="?op=showAccountManagement"><?php echo ("👤 " . htmlspecialchars($uname)) ?></a>
<?php
showLogoutForm();
}
else {
?>
    <A id="username" href="?op=showLoginForm">👤 login</A>
    <A id="username" href="?op=showSignUpForm" style = 'color: blue; font-size: 10px'>Don't have an account? Click here to sign up!</A>
<?php
}
?>

	
<DIV class="boxcontainer">
    <DIV class="box"><A href="?op=cart"><i style="font-size:24px" class="fa">&#xf07a;</i>
</A></DIV>

    <DIV class="box"><A href="?op=sell">SELL</A></DIV>

    <DIV class="text-under-box"></DIV>
</DIV>

<DIV class="boxcontainer">
    <DIV class="box"><A href="?op=saved"><i style="font-size:24px" class="fa">&#xf004;</i></A></DIV>
    <DIV class="text-under-box"></DIV>
    <DIV class="box"><A href="?op=orders">ORDERS</A></DIV>
    <DIV class="text-under-box"></DIV>
</DIV>

            
        
    <!-- search bar implement -->
    <!-- add an inline bar over here -->
<DIV class="line-divider"></DIV>
<FORM name='filterResults' method='POST' action='?op=searchItems'>
<INPUT id="searchbar" name = "searchbar" type="text" placeholder="Search...">    <!--will clean this up a bit later -->
<A href=<?php if($op != 'filter'){echo("?op=filter");} else{echo("dashboard.php");} ?>>filter</A>
    
<?php

if($op == 'filter'){
    echo("<TD>\n");
    echo("<input type='checkbox' name='cb1' value='Electronics'>Electronics</INPUT></BR>");
    echo("<input type='checkbox' name='cb2' value='Home Goods'>Home Goods</INPUT></BR>");
    echo("<input type='checkbox' name='cb3' value='Kitchen Ware'>Kitchen Ware</INPUT></BR>");
    echo("<input type='checkbox' name='cb4' value='Toys & Games'>Toys & Games</INPUT></BR>");
    echo("</TD>\n");
}

?>

<INPUT type='submit' value='Search' />
</FORM>

</DIV> <!-- closes side bar-->



        
        
<!-- implement filter icon -->
        
<!-- implement logout icon -->

</DIV> 
    
</BODY>
</HTML>

