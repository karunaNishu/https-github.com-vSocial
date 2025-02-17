<?php
	include 'dbconnect.php';
	$author = $_COOKIE['user'];
	$showError = false;
	$showSuccess = false;
	
?>

<?php 
if($_SERVER["REQUEST_METHOD"] == "POST") {
$title = $_POST["title"];
$body = $_POST["body"];

	if($title != " " && $body != " "){
		$showSuccess = "Thank you for writing the blog";
		$sql = "INSERT INTO `blogs` ( `author`,`title`,`body`) VALUES ('$author','$title','$body')"; 		
		mysqli_query($conn, $sql);
		
		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$timestamp = date('m/d/Y h:i:s a', time());
		$logdescription = "User: ".htmlentities($author).", has made a new Blog entry with Blog Title: ".htmlentities($title);
		$logsql = "INSERT INTO `logs` ( `url`,`timestamp`,`description`) VALUES ('$url','$timestamp','$logdescription')";
		$logresult = mysqli_query($conn, $logsql);
		
	}
	else{
		$showError = "Title or Content is blank!";		
	}

}
?>

<!doctype html> 
	
<html lang="en"> 

<head> 
<title>WriteBlog-vSocial</title>
<link rel="icon" type="image/x-icon" href="favicon.ico">	
	<!-- Required meta tags --> 
	<meta charset="utf-8"> 
	<meta name="viewport" content= 
		"width=device-width, initial-scale=1, 
		shrink-to-fit=no"> 
	
</head> 

<script>
function viewblog(){
				var viewBlogUrl = "http://localhost:81/Vsocial/allBlog.php?back=blogger";
				location.replace(viewBlogUrl);
			}
 function logout(){
				var homepage = "http://localhost:81/Vsocial/logout.php";
				location.replace(homepage);
			}
</script>

<body style="background-image: url(http://localhost:81/VSocial/cbg.jpg); background-position: center"> 
	
	
<div style="text-align:center;"> 
<button onclick="viewblog()">View all Blog</button> &ensp;&ensp; <button onclick="logout()">LogOut</button> <br/><br/>
	<h2>Write a Blog post</h2><br/><br/>
<?php echo 'Welcome  '.$author.',<br/><br/>';

echo 'You can create a blog by submitting the form below.<br/><br/>';

echo '<form name="writeblog" action="http://localhost:81/Vsocial/writeBlog.php" method="POST">
<div style="text-align:center;">Title <input name="title" type="text" maxlength=100/><br/><br/>         
Content <textarea name="body"> </textarea></div><br/><br/>';
echo '<input type="submit" value="Submit Blog Entry"></pre></form> ';

if($showError) { 
	
		echo ' <div style="text-align:center;" class="alert alert-danger 
			alert-dismissible fade show" role="alert"> 
		<strong>Error!</strong> '.$showError;
}
if($showSuccess) { 
	
		echo ' <div style="text-align:center;" class="alert alert-danger 
			alert-dismissible fade show" role="alert"> 
		<strong>Success!</strong> '.$showSuccess;
}

?>

	
</body> 
</html> 
