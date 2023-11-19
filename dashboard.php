<?php
    session_start();
    include("bootstrap.php");
    include("util.php");
    
    
    
    
    
    	    //logout

	if (isset($_GET['op']) && $_GET['op'] == 'login' && isset($_POST['uid'])) {
    		$uid = $_POST['uid'];
		$_SESSION['uid'] = $uid;
	} elseif (isset($_GET['op']) && $_GET['op']  == 'showLoginForm'){
		handleLoginForm($db);
		exit;
	}

$uid = $_SESSION['uid'];
$uname = getName($db, $uid);

?>
<?php


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

<!DOCTYPE html>
<html lang="en">
<head>
<?php
	
?>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="dashboard.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=MuseoModerno' rel='stylesheet'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
	<?php 
	//if (isset($_SESSION['user_id'])): ?>
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
    <div class="sidenav">
	<h2>MARKETPLACE</h2>
<?php
	//this section icon should be pressed and prompt the user to a login page
		//following that it should log the user in when user name and pass word is specified. 
		//more functionality added later.
?>
	<a id="username" href="<?php echo (isset($_SESSION['uid']) ? '#profile' : '?op=showLoginForm'); ?>">👤<?php if(isset($_SESSION['uid'])){echo "Welcome " . htmlspecialchars($uname);}else{echo "login";}?></a>
    
        <div class="boxcontainer">
            <div class="box"></div>
            
            <div class="box"></div>
            <div class="text-under-box"></div>
        </div>
        <div class="boxcontainer">
            <div class="box"></div>
            <div class="text-under-box"></div>
            <div class="box"></div>
            <div class="text-under-box"></div>
        </div>
            
        
        <!-- search bar implement -->
        <!-- add an inline bar over here -->
        <div class="line-divider"></div>
        <input id="searchbar" type="text" placeholder="Search...">    <!--will clean this up a bit later -->
        <a href="">filter</div>
        
        <!-- implement filter icon -->
        
        <!-- implement logout icon -->
      </div>
    
</body>
</html>
<?php
    
    ?>
