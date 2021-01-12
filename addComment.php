<?php
//http://163.238.35.165/~jing/Final/login.php
session_start();
  include("../loginFinal.php");

if (isset($_POST['postid']) && isset($_POST['comment']) && isset($_POST['name']))
{
	$postid=$_POST['postid'];
	$comment=$_POST['comment'];
	$name=trim($_POST['name']);
	
	$db_conn = login();
	
  if (mysqli_connect_errno()) {
    echo 'Connection to database failed:'.mysqli_connect_error();
    exit();
  }
  $query = "select count(post_id) from Posts where post_id = ?";
  $stmt = $db_conn -> prepare($query);
  $stmt-> bind_param('i',$postid);
  $stmt-> execute();
  $stmt-> store_result();
  $stmt-> bind_result($match);
  $stmt->fetch();
  //echo $match." and ".$postid; //check
   if (!$postid||!$comment||!$name|| $match < 1) {
     echo 'You have not fill the form/ Post ID does not exist <br/>';
	 echo 'Please go back and try again.<br/>';
	 echo '<p><a href="addComment.php">Add A Comment</a><br/>';
	 echo '<br/><a href="index.php">Back to BOLG HOMEPAGE</a></p>';
     exit;
	}

  $stmt->free_result();

  $query = "insert into Comments VALUES (null, ?, ?, ?, CURRENT_TIMESTAMP())";
  $stmt = $db_conn -> prepare($query);
  $stmt->bind_param('sss',$name,$comment,$postid);
  $stmt->execute();
  

if($stmt->affected_rows > 0)
{
	echo "<p>Comment added to Post ID: ".$postid."<br/>";
	echo "<br/><a href=\"viewComment.php?postid=$postid\">View All Comments</a></p>";
	//echo '<br/><a href="index.php">Back to BOLG HOME</a></p>';
}
else
{
	echo "<p>ERROR! UNABLE TO ADD</p><br/>";
   // echo 'Post ID Already Exit/Invalid Post ID.<br />';
}
  $db_conn->close();
}
?>

<html>
<body>
<?php
    echo '<b>Fill the form to add a Comment.<b/><br/><br />';
    // provide form to log in 
    echo '<form method="post" action="addComment.php">';
    echo '<table>';
    echo '<tr><td>Comment to Post ID:</td>';
    echo '<td><input type="int" name="postid"></td></tr>';
    echo '<tr><td>Comment:</td>';
    echo '<td><textarea type="text" name="comment" rows="5" cols="40"></textarea></td></tr>';
	echo '<tr><td>Username:</td>';
    echo '<td><input type="text" name="name"></td></tr>';
	echo '<tr><td colspan="2" align="center">';
    echo '<input type="submit" value="Submit"></td></tr>';
    echo '</table></form>';
	echo '<br/><a href="index.php">BACK TO HOMEPAGE</a>';
?>