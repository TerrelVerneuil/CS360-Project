<?php
session_start();
include_once("db_connect.php");
//we connect to database here
//include_once("db_connect.php");

function handleLoginForm($db, $dest){
?>
    <link rel="stylesheet" href="dashboard.css">
    <div class="gradient-background">
    <div class="login-container">
     
    <FORM name='fmLogin' method='POST' action='dashboard.php?op=login' class="login-form">
    <INPUT type="text" name="uid" size='4' placeholder="user ID" class="login-input" />
    <INPUT type="hidden" name="dest" value=<?php echo($dest);?> />
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

//-------------------- Ha Duong -----------------------//
function showReview($db, $item, $sid) {
  $sql = "SELECT reviews.*, s1.name AS reviewer, item.*
          FROM reviews 
          JOIN shop_user AS s1 ON reviews.reviewerID = s1.userID 
          JOIN item ON item.itemID = reviews.iid
          WHERE reviews.iid = $item AND reviews.sellerID = $sid";

  $res = $db->query($sql);

  if ($res == FALSE) {
    header("refresh:1;url=dashboard.php");
    echo "<div class='main-content'>";
    echo "<h3>Something went wrong!</h3>\n";
    echo "</div>";

  }
  else {
      echo "<div class='main-content' style='border:solid 1px'>
            <p style='font-size: 24px; font-weight:600; margin-top: 2px'>Customer Reviews</p>";
      
        while ($row = $res->fetch()) {
          $reviewer = $row['reviewer'];
          $rating = $row['rating'];
          $message = $row['message'];
      echo "
      <div style='border-top: solid 1px; padding-top: 1rem'>
          <div style='font-size: 20px'>$reviewer</div>
          <div style='font-size: 14px'>(Rating: $rating/5)</div>
          <div style='margin-top: 1rem;'>$message</div>
      </div>
      ";
        }
      echo "</div>";
  }
}

function genReviewForm($db, $uid, $sid, $iid){
    echo "<FORM name='reviewform' action='?op=send' method='POST' class='main-content'>\n";    
    echo "<p style='font-size: 24px; font-weight:600; margin-top: 2px; border-bottom: solid 1px; padding-bottom:1rem'>Write your review!</p>";
    echo "<P><INPUT type='text' name='rating' placeholder='Rating from 1 to 5'/></P> \n";    
    echo "<P><INPUT type='hidden' name='uid' value='$uid'/></P> \n";    
    echo "<P><INPUT type='hidden' name='sid' value='$sid'/></P> \n"; 
    echo "<P><INPUT type='hidden' name='iid' value='$iid'/></P> \n";       
    echo "<P><TEXTAREA rows='5' cols='70' name='message' placeholder='Rating from 1 to 5'></TEXTAREA><P> \n";
    echo "<P><INPUT type='submit' value='Review!'/></P>\n";
    echo "</FORM>\n";
}

function writeReview($db, $reviews){
	$rating = $reviews['rating'];
	$message = $reviews['message'];
  $reviewerID = $reviews['uid'];
  $sellerID = $reviews['sid'];
  $iid = $reviews['iid'];

	$sql = "INSERT INTO reviews(rating, message, reviewerID, sellerID, iid) "
			. "VALUE($rating, '$message', $reviewerID, $sellerID, $iid)";

	$res = $db->query($sql);

	if ($res !=FALSE) {
		header("refresh:2;url=?op=displayItem&IID=$iid");
		printf("<h3>Successfully added review!</h3> \n");
	}
	else {
		header("refresh:2;url=?op=displayItem&IID=$iid");
		printf("<h3>Failed to send review!</h3> \n");
	}
}

//----------------------------------------------------//

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
    $query = "SELECT description, price, name, itemID FROM (" . $query . ") AS searched " . $condition;
  }

  $res = $db->query($query);
  
  //echo("<DIV class='main-content'><H1>".$query."</H1></DIV>");

  if($res != FALSE){
    while($row = $res->fetch()){
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

  echo("</DIV>");


}

function listItem($itemInfo, $db, $uid){

  $name = $itemInfo['name'];
  $price = $itemInfo['price'];
  $desc = $itemInfo['desc'];
  $category = $itemInfo['category'];

  $res = $db->query("INSERT INTO item(sid, name, price, description, itemCat) VALUES ($uid, '$name', $price, '$desc', '$category')");
  
  if($res != FALSE){
  ?>
    <DIV class='main-content'>
    <P>Your item has been successfully listed!</P>
    <FORM name='returnMain' action='?'>
    <INPUT type='submit' value='Return to Main Page' />
    </FORM>
    </DIV>
  <?php
  }
  else{
    ?>
    <DIV class='main-content'>
    <P>A problem has occurred. Please press this button to return to the previous page.</P>
    <FORM name='returnMain' method='get'>
    <INPUT type='hidden' name='op' value = 'sell' />
    <INPUT type='submit' value='Return to sell page' />
    </FORM>
    </DIV>
  <?php
  }

}

function displayItem($db, $iid, $uid){
  $res = $db->query("SELECT * FROM item WHERE itemID = $iid");

  if($res != FALSE){
    $item = $res->fetch();

    $res2 = $db->query("SELECT name FROM shop_user WHERE userID =".$item['sid']);
    $seller = $res2->fetch();
    echo("<DIV class='main-content'><H1>".$item['name']."</H1>\n");
    echo("<P>Item Description: ".$item['description']."</P>\n");
    echo("<P>Price: $".$item['price']."</P>\n");
    echo("<P>Seller Name: ".$seller['name']."</P>\n");
    ?>
    <FORM name='addToCart' method='get'>
    <INPUT type='hidden' name='op' value = 'addedToCart' />
    <INPUT type='hidden' name='IID' value = '<?php echo($iid); ?>' />
    <INPUT type='submit' value='Add to cart' />
    </FORM>
  </DIV>
  <?php

  showReview($db, $iid, $item['sid']);

  if ($uid != -1) {
    genReviewForm($db, $uid, $item['sid'], $iid);
  }
  }
}

function addToCart($db, $iid){
  $res = $db->query("SELECT * FROM item WHERE itemID = $iid");

  if($res != FALSE){
    $item = $res->fetch();
  }
}
  ?>