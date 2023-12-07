<?php
session_start();
include_once("db_connect.php");
//we connect to database here
//include_once("db_connect.php");
function showAccountManagementForm($db, $uid){
?>
    <link rel="stylesheet" href="dashboard.css">
    <div class="main-content">
	<!-- there should be a button that goes back to the dashboard.php -->
	<div class="back-button-container">
            <a href="dashboard.php" class="back-button">Back to Dashboard</a>
        </div>       
	<div class="account-container">
            <h2>Welcome <?php echo getName($db, $uid) ?>!</h2>
            <form name='actManage' method='POST' action='dashboard.php?op=Account_Manage' class="login-form">
                <h2>Account Management</h2>
		<!-- should have orders tab, wishlist addresses -->
		
	<!-- Personal Information Section -->
                <div class="manage-section">
                    <h3>Personal Information</h3>
		<!-- display uid and name -->
		<p>Name: <?php echo getName($db, $uid) ?></p>
		<p>User ID: <?php echo $uid ?></p>
                <!-- Change Password Section -->
                <div class="manage-section">
                    <h3>Change Password</h3>
                    <input type="password" name="currentPassword" placeholder="Current Password" class="form-input"/>
                    <input type="password" name="newPassword" placeholder="New Password" class="form-input"/>
                    <input type="password" name="confirmNewPassword" placeholder="Confirm New Password" class="form-input"/>
                </div>

                <input type="submit" value="Update Account" class="login-button"/>
            </form>
        </div>
    </div>

    <?php
}
   
    

?>
<?php


function handleLoginForm($db,$dest,$message){
?>
    <p> <?php echo $message ?> </p>
    <link rel="stylesheet" href="dashboard.css">
    <div class="gradient-background">
    <div class="login-container">
     
    <FORM name='fmLogin' method='POST' action='dashboard.php?op=login' class="login-form"/>
    <INPUT type="text" name="uid" size='4' placeholder="user ID" class="login-input"/>    
    <INPUT type="hidden" name="dest" value=<?php echo($dest); ?> /> 
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
        <INPUT type="hidden" name="password" size='4' placeholder="Password" class="login-input" />
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

	if($res != FALSE && $res->rowCount() == 1) {
        $nameRow = $res->fetch();
        return $nameRow['name'];
    }
	else{
        return false; //regenerate the form so that the user is prompted to re enter
    } 
}

function getRandomItems($db, $numItems){
	$sql = "SELECT name 
		FROM item"; //generate all items
	$res = $db->query($sql);
	if($res != FALSE && $res-> rowCount() == 1){
		$items = $res->fetch();
		return $items['name'];
	}
}

function validateNewPassword($db, $uid,$current_password, $newPassword, $confirmPassword){
	$sql = "SELECT password 
		FROM shop_user
		WHERE userID=$uid";
	$res = $db->query($sql);
	
	if($res != FALSE && $res-> rowCount() == 1){
		$row = $res -> fetch();
		$curr_password = $row['password'];
		if($curr_password === $current_password){
			if($newPassword !== $curr_password&&$newPassword ===$confirmPassword){
				echo "Successfully Changed Password";
				showAccountManagementForm($db, $uid);
				return true;
			}else{
				echo "New Password & Confirm New Password fields must match";
				showAccountManagementForm($db, $uid);
				return false;
			}
		}else{
			echo "invalid current password";
			showAccountManagementForm($db, $uid);
			return false;
		}

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
