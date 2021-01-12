<html>
<head>
  <title>Comment Page</title>
</head>
<body>
<h1>Comments:</h1>
<?php
//http://163.238.35.165/~jing/Final/login.php
session_start();
  include("../loginFinal.php");

  $db_conn = login();

  if (mysqli_connect_errno()) {
    echo 'Connection to database failed:'.mysqli_connect_error();
    exit();
  }
if (isset($_GET['postid']))
{
	$postid = $_GET['postid'];
    $query = "SELECT count(comment_id) FROM Comments where post_id=?";
	$stmt = $db_conn -> prepare($query);
	$stmt->bind_param('i', $postid);
	$stmt-> execute();
	$stmt->store_result();
	$stmt->bind_result($totrecords);
	$stmt->fetch();
  
  echo "Total records: " . $totrecords . " Comments<br />";
  $stmt->free_result();


  $query = "SELECT comment_id, username, comment_date, comment_body from Comments where post_id=?";
  $stmt = $db_conn -> prepare($query);
  $stmt->bind_param('i', $postid);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($Cid, $Uname, $Cdate, $Cbody);
  echo "<p><strong>Here's all the comments on Post ID: ".$postid."</strong><br/>";
  while ($stmt->fetch()) {

	 echo "<p><strong> Comment ID: ".$Cid."</strong><br/>";
     echo "Username: ".$Uname."<br />";
	 echo "Comment Date: ".$Cdate."<br />";
     echo "Comment Body: ".$Cbody."<br />";


  }
  $stmt->free_result();
 
  $db_conn->close();
  echo "<p><a href=\"addComment.php?postid=$postid\">Add a Comment</a> ";
  echo '<p><br/><a href="index.php">Back to BOLG HOMEPAGE</a>';
}
else
{ echo "ERROR!<br/>";}
?>