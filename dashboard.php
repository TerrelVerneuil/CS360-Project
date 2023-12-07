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
        $username = $_POST['username'];
        $password = $_POST['password'];
        $res = $db->query("SELECT * FROM shop_user WHERE name = '$username' AND password = '$password'");

        if($res != FALSE){
            $user = $res->fetch();
            if($res -> rowCount() == 0){
                loginAgain($db, "Username or password was incorrect. Please try again.", 'login');
                exit;
            }
            else {
                $_SESSION['uid'] = $user['userID'];
                $op = $_POST['dest'];
            }
        }
        else{
            loginAgain($db, "An error has occurred. Please try again.", 'login');
                exit;
        }
    }
    else if ($op == 'logout') {
        unset($_SESSION['uid']);
    }
    else if ($op == 'signedUp') {
        if($_POST['username'] == "" or $_POST['password'] == "" or $_POST['display_name'] == ""){
            showTryAgain($db, "Please fill out all forms to create an account.");
            exit;
        }
        else{
            $newUser = $_POST['username'];
            $checkName = $db -> query("SELECT name
                                      FROM shop_user
                                      WHERE name = '$newUser'");
            if($checkName -> rowCount() == 0){
                $newPassword = $_POST['password'];
                $displayName = $_POST['display_name'];
                $db->query("INSERT INTO shop_user(name, created_at, password, display_name) VALUES ('$newUser', NOW(), '$newPassword', '$displayName')");
                $getNewUID = $db -> query("SELECT userID FROM shop_user WHERE name = '$newUser'");
                $newUID = $getNewUID -> fetch()['userID'];
                $_SESSION['uid'] = $newUID;
            }
            else{
                showTryAgain($db, "That username already exists. Please try again.");
                exit;
            }
        }
    }
}

$uid = $_SESSION['uid'];
$uname = getName($db, $uid);

if (isset($_GET['op']) && $_GET['op']  == 'showLoginForm'){
    handleLoginForm($db, 'login');
    exit;
}

if (isset($_GET['op']) && $_GET['op']  == 'showSignUpForm'){
    handleSignUpForm($db);
    exit;
}
//terrel
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
    $user = -1;

    if (isset($_SESSION['uid'])) {
        $user = $_SESSION['uid'];
    }

    displayItem($db, $_GET['IID'], $user);
}
else if($op == "addedToCart"){
    if(!isset($_SESSION['uid'])){
        handleLoginForm($db, 'main');
        exit;
    }
    else{
//        echo("<DIV class='main-content'><H1>" .$_GET['IID']. "$uid</H1>");
        addToCart($db, $_GET['IID'], $uid);
    }
}
else if($op == "cart"){
    if(!isset($_SESSION['uid'])){
        handleLoginForm($db, $op);
        exit;
    }
    else{
        if(isset($_POST['iid'])){
            $removeItem = $_POST['iid'];
            $db->query("DELETE FROM has_in_cart WHERE itemId = $removeItem AND userID = $uid");
        }
        showCart($db, $uid);
    }
}
else{
    echo("<DIV class ='main-content'>\n");
    echo("<H1>Picked for you</H1>");
    if(isset($_SESSION['uid'])){
        $randomItem = $db->query("SELECT * 
                                  FROM item  
                                  ORDER BY RAND()
                                  LIMIT 10");
        if($randomItem != FALSE){
            for($x = 0; $x < 10; $x++){
                $row = $randomItem -> fetch();
                echo("<DIV class='item'>");
                echo("<DIV class='item-box'>Null</DIV>");
                echo("<DIV class='item-stack'>");
                echo("<A href=?op=displayItem&IID=".$row['itemID'].">".$row['name']."</A>");
                echo("<P>".$row['description']."</P>");
                echo("<P>Price: $".$row['price']."</P>");
                echo("</DIV>");
                echo("</DIV>");
        
            }
        }
        
    }
    else{
        echo("<P>Please sign in to see your recommended items.</P>");
    }
    echo("</DIV>");
}
?>
<DIV class="sidenav">
<A href="?op=home"><H2>MARKETPLACE</H2></A>

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
    <DIV class="box"><A href="?op=cart"><i style="font-size:24px" class="fa">&#xf07a;</i></A></DIV>
            
    <DIV class="box"><A href="?op=sell">SELL</A></DIV>
    <DIV class="text-under-box"></DIV>
</DIV>

<DIV class="boxcontainer">
    <DIV class="box"><i style="font-size:24px" class="fa">&#xf004;</i></DIV>
    <DIV class="text-under-box"></DIV>
    <DIV class="box">ORDERS</DIV>
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
