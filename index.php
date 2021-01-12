<html>
<head>
  <title>BLOG HOME</title>
</head>
<body>
<h1>BLOG HOME</h1>
<?php
//http://163.238.35.165/~jing/Final/login.php
session_start();
include("../loginFinal.php");
if (isset($_POST['userid']) && isset($_POST['password']))
{
  // if the user has just tried to log in
  $userid = $_POST['userid'];
  $password = $_POST['password'];


  $db_conn = login();
  if (mysqli_connect_errno()) {
   echo 'Connection to database failed:'.mysqli_connect_error();
   exit();
  }
  
  $query = "select username from Users where username = ? and password = sha1(?)";
  
  $stmt = $db_conn -> prepare($query);
  $stmt->bind_param('ss',$userid,$password);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($username);
  
  if ($stmt->num_rows >0 )
  {
    // if they are in the database register the user id
    $_SESSION['valid_user'] = $userid;
  }
  $stmt->free_result();
 
  $db_conn->close();
}
  if (isset($_SESSION['valid_user']))
  {
    echo "<strong>Welcome ".$_SESSION['valid_user'].".</strong> <br /><br/>";
	//show the index
	idx();
    echo '<br/><br/><a href="logout.php">Logout</a><br />';
  }
  else
  {
    if (isset($userid))
    {
      // if they've tried and failed to log in
      echo 'Could not log you in.<br />';
	  echo '<br/><a href="login.php">BACK TO HOMEPAGE</a><br />';
    }
    else 
    {
      // they have not tried to log in yet or have logged out
      echo 'Only logged in user can add a COMMENT/POST.<br />';

    }
	echo '<form method="post" action="index.php">';
    echo '<table>';
    echo '<tr><td>Username:</td>';
    echo '<td><input type="text" name="userid"></td></tr>';
    echo '<tr><td>Password:</td>';
    echo '<td><input type="password" name="password"></td></tr>';
    echo '<tr><td colspan="2" align="center">';
    echo '<input type="submit" value="Log in"></td></tr>';
    echo '</table></form>';
  }
?>
<?
function idx(){
  $db_conn = login();
  if (mysqli_connect_errno()) {
   echo 'Connection to database failed:'.mysqli_connect_error();
   exit();
  }
  
  if (isset($_GET['page']))
	  $thispage = $_GET['page'];
  else
	  $thispage = 1;
  
	$query = "SELECT count(post_id) FROM Posts";

	$stmt = $db_conn -> prepare($query);
	$stmt-> execute();
	$stmt->store_result();
	$stmt->bind_result($totrecords);
	$stmt->fetch();
  
  echo "Total records: " . $totrecords . " Posts<br />";
  $stmt->free_result();
  
  $recordsperpage = 5;
  $totalpages = ceil($totrecords/$recordsperpage);    // 1. how many pages are needed to show all the records
  $offset = ($thispage - 1) * $recordsperpage;
  
  $query = "select post_id, title, username, date, body from Posts order by date desc limit ?, ?";
  
  $stmt = $db_conn -> prepare($query);
  $stmt->bind_param('ss', $offset, $recordsperpage);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($postid, $title, $username, $date, $body);
  while ($stmt->fetch()) {
	 echo "<p><strong> Post ID: ".$postid."</strong><br/>";
     echo "<strong>Title: ".$title."</strong><br />";
	 echo "Username: ".$username."<br />";
     echo "Date: ".$date."<br />";
	 echo "Post: ".$body."<br />";
	 echo "<a href=\"addComment.php?postid=$postid\">Add a Comment</a> ";
	 echo "<a href=\"viewComment.php?postid=$postid\">View Comments</a>";
  }

  $stmt->free_result();
 
  $db_conn->close();
  
  if ($thispage > 1)
   {
      $page = $thispage - 1;

      $prevpage = "<a href=\"      \">Previous</a>"; //put in the link with get parameters for the previous page!
   } else

   {
      $prevpage = "";
   }

$bar = "";
echo "<br />";
if ($totalpages > 1)

{ 
    for($page = 1; $page <= $totalpages; $page++)

    {
       if ($page == $thispage)      
       {

           $bar .= " $page ";
       } 
	   else
       {
          $bar .= " <a href=\"index.php?page=$page\">$page</a> ";
       }

    }
echo $bar;
}
echo '<br/><br/><a href="addBlogPosting.php">Add a BOLG POSTING</a>';
}

?>