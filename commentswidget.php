<?php

$web_url = "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];

error_reporting(0); // For not showing any error

if (isset($_POST['submit'])) { // Check press or not Post Comment Button
$name = $_POST['name']; // Get Name from form
$email = $_POST['email']; // Get Email from form
$comment = $_POST['comment']; // Get Comment from form
   
      $conn = mysqli_connect("localhost", "pma", "DSA", "mysql");
        $result = mysqli_query($conn, "INSERT INTO comments (name, email, comment)
VALUES ('$name', '$email', '$comment')");

if ($result) {
echo "<script>alert('Comment added successfully.')</script>";
} else {
echo "<script>alert('Comment does not add.')</script>";
}
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" type="text/css" href="style5.css">

<title>Comment Widget in PHP - Pure Coding</title>
</head>
<body>
<h1 style="font-family:verdana;">Leave a comment about Liverpool or Rio de Janeiro down below!</h1>
<body style="background-color:dodgerblue;">
<div class="wrapper">
<form action="" method="POST" class="form">
<div class="row">
<div class="input-group">
<label for="name" style="font-family:verdana;">Name</label>
<input type="text" name="name" id="name" placeholder="Enter your Name" required>
</div>
<div class="input-group">
<label for="email" style="font-family:verdana;">Email</label>
<input type="email" name="email" id="email" placeholder="Enter your Email" required>
</div>
</div>
<div class="input-group textarea">
<label for="comment" style="font-family:verdana;">Comment</label>
<textarea id="comment" name="comment" placeholder="Enter your Comment" required></textarea>
</div>
<div class="input-group">
<button name="submit" class="btn" style="font-family:verdana;">Post Comment</button>
</div>
</form>
<div class="prev-comments">
<?php
$sql = "SELECT * FROM comments";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
while ($row = mysqli_fetch_assoc($result)) {

?>
<div class="single-item">
<h4><?php echo $row['name']; ?></h4>
<a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a>
<p><?php echo $row['comment']; ?></p>
</div>
<?php

}
}
?>
</div>
</div>
</body>
</html>