<html>
<title>Home Page</title>
<body>
<?php
	include('index1.php');
?>
<h2>BLOG LOGIN:</h2>
<?php
session_start();
    // provide form to log in 
    echo 'Only logged in user can add a COMMENT/POST.<br />';
    echo '<form method="post" action="index.php">';
    echo '<table>';
    echo '<tr><td>Username:</td>';
    echo '<td><input type="text" name="userid"></td></tr>';
    echo '<tr><td>Password:</td>';
    echo '<td><input type="password" name="password"></td></tr>';
    echo '<tr><td colspan="2" align="center">';
    echo '<input type="submit" value="Log in"></td></tr>';
    echo '</table></form>';
?>
</body>
</html>
