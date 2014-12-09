<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Edit Profile</title>
    </head>
    <body>
        <h1>Edit Profile</h1>
        <form id="profileForm" method="post" action="upload_profile.php" enctype="multipart/form-data">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="firstName" /><br />
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="lastName" /><br />
            <label for="dateOfBirth">Date of Birth</label>
			   <input type="text" id="dateOfBirth" name="dateOfBirth" /><br />
			   <label for="gender">Gender</label>
			  	<input type="text" id="gender" name="gender" /><br />
			  	<label for="email">Change Email Address</label>
			  	<input type="text" id="email" name="email" /><br />
			  	<label for="password">Change Password</label>
			  	<input type="text" id="password" name="password" /><br />
			  	<label for="confirmPassword">Confirm Changed Password</label>
			  	<input type="text" id="confirmPassword" name="confirmPassword" /><br />
			   <label for="avatar">Avatar File (JPG and PNG only)</label>
            <input type="file" id="avatar" name="avatar" /><br />
            <button type="submit">Save Profile</button>
			   <script type ="text/javascript" src ="//ajax.googleapis.com/ajax/libs/jquery.min.js"></script>
			   <script type ="text/javascript" src ="//malsup.github.com/min/jquery.validate/1.11.1/
        </form>
    </body>
</html>

