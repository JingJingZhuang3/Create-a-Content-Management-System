<html>
<head>
  <title>BLOG HOME</title>
</head>
<body>
<h1>BLOG HOMEPAGE</h1>
<?php
session_start();
//http://163.238.35.165/~jing/Final/index.php
  include("../loginFinal.php");
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
  
  $query = "select title, username, date, body from Posts order by date desc limit ?, ?";
  
  $stmt = $db_conn -> prepare($query);
  $stmt->bind_param('ss', $offset, $recordsperpage);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($title, $username, $date, $body);
  
  while ($stmt->fetch()) {
     echo "<p><strong> Title: ".$title."</strong><br />";
	 echo "Username: ".$username."<br />";
     echo "Date: ".$date."<br />";
	 echo "Post: ".$body."<br />";
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
?>