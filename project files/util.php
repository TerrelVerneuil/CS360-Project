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

function displayItem($db, $iid){

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
  }
}

function addToCart($db, $iid){
  $res = $db->query("SELECT * FROM item WHERE itemID = $iid");

  if($res != FALSE){
    $item = $res->fetch();





  }
}






  ?>
