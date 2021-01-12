<?php
session_start();

if (isset($_POST['title']) && isset($_POST['body']) && isset($_POST['name']))
{
	$title=$_POST['title'];
	$body=$_POST['body'];
	$name=trim($_POST['name']);
	
	if (!$title||!$body||!$name) {
     echo 'You have not fill the form.  Please go back and try again.<br/>';
	 echo '<a href="addBlogPosting.php">Add A Post</a><br/>';
	 echo '<br/><a href="index.php">Back to BOLG HOMEPAGE</a></p>';
     exit;
	}
	
  include("../loginFinal.php");
  $db_conn = login();

  if (mysqli_connect_errno()) {
    echo 'Connection to database failed:'.mysqli_connect_error();
    exit();
  }
  
  $query = "insert into Posts VALUES (NULL, ?,  ?, ?, CURRENT_TIMESTAMP())";
  $stmt = $db_conn -> prepare($query);
  $stmt->bind_param('sss',$title,$body,$name);
  $stmt->execute();
  
if($stmt->affected_rows > 0)
{
	echo "<p>Post added to database<br/>";
	echo '<br/><a href="index.php">Back to BOLG HOMEPAGE</a></p>';
}
else
{
	echo "<p>ERROR! UNABLE TO ADD<br/>";
   // echo 'Post ID Already Exit/Invalid Post ID.<br /></p>';
}
  $db_conn->close();
}

?>

<html>
<body>
<?php
    echo '<b>Fill the form to add a blog post.<b/><br/><br />';

    // provide form to log in 
    echo '<form method="post" action="addBlogPosting.php">';
    echo '<table>';
    echo '<tr><td>Title:</td>';
    echo '<td><input type="text" name="title"></td></tr>';
    echo '<tr><td>Post:</td>';
    echo '<td><textarea type="text" name="body" rows="5" cols="40"></textarea></td></tr>';
	echo '<tr><td>Username:</td>';
    echo '<td><input type="text" name="name"></td></tr>';
    echo '<tr><td colspan="2" align="center">';
    echo '<input type="submit" value="Submit"></td></tr>';
    echo '</table></form>';
	//echo '<br/><a href="index.php">BACK TO HOMEPAGE</a>';
?>