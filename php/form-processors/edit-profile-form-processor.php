<?php
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}
// create the white list of allowed types
$goodExtensions = array("jpg", "jpeg", "png");
$goodMimes      = array("image/jpeg", "image/png");

// verify the file was uploaded OK
if($_FILES["avatar"]["error"] !== UPLOAD_ERR_OK) {
	throw(new RuntimeException("Error while uploading file: " . $_FILES["avatar"]["error"]));
}

// verify the CSRF tokens
$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

if((verifyCsrf($_POST["csrfName"], $_POST["csrfToken"])) === false) {
	throw(new Exception("external source violation"));
}

// verify the file is an allowed extension and type
$extension = end(explode(".", $_FILES["avatar"]["name"]));
if(in_array($extension, $goodExtensions) === false
	|| in_array($_FILES["avatar"]["type"], $goodMimes) === false) {
	throw(new RuntimeException($_FILES["avatar"]["name"] . " is not a JPEG or PNG file"));
}

// use PHP's GD library to ensure the image is actually an image
if($_FILES["avatar"]["type"] === "image/png") {
	$image = @imagecreatefrompng($_FILES["avatar"]["tmp_name"]);
	if($image === false) {
		throw(new InvalidArgumentException("Image is not a valid PNG file"));
	}
	imagedestroy($image);
} else if($_FILES["avatar"]["type"] === "image/jpeg") {
	$image = @imagecreatefromjpeg($_FILES["avatar"]["tmp_name"]);
	if($image === false) {
		throw(new InvalidArgumentException("Image is not a valid JPEG file"));
	}
	imagedestroy($image);
} else {
	throw(new InvalidArgumentException("Image is not a supported format. Please use a JPEG or PNG file."));
}

// move the file to its permanent home - instead of mt_rand() - use mySQL for the Id, please...;)
$destination = "/var/www/html/upload";
$fileName    = "avatar-" . mt_rand(1, 1024) . "." . strtolower($extension);
if(move_uploaded_file($_FILES["avatar"]["tmp_name"], "$destination/$fileName") === false) {
	throw(new RuntimeException("Unable to move file"));
}

// report successful upload to the user

$avatarName  = $_FILES["avatar"]["name"];
$avatarSize  = $_FILES["avatar"]["size"];
$avatarType  = $_FILES["avatar"]["type"];
$firstName   = $_POST["firstName"];
$lastName    = $_POST["lastName"];
$dateOfBirth = $_POST["dateOfBirth"];
$gender      = $_POST["gender"];
$email 		 = $_POST["email"];
$password 	 = $_POST["password"];
echo <<<EOF
<p>Profile successfully updated</p>
<ul>
    <li>First Name: $firstName</li>
    <li>Last Name: $lastName</li>
    <li>Date of Birth: $dateOfBirth</li>
    <li>Gender: $gender</li>
    <li>Email: $email</li>
    <li>Password: $password</li>
    <li>Avatar: $avatarName ($avatarType, $avatarSize bytes)<br />
    <img src="/upload/$fileName" /></li>
</ul>
EOF;
?>
