<?php 

if (isset($_POST['create_user'])) {

	$user_firstname = s($_POST['user_firstname']);
	$user_lastname = s($_POST['user_lastname']);
	$user_role = s($_POST['user_role']);

	// $post_image = $_FILES['image']['name'];
	// $post_image_temp = $_FILES['image']['tmp_name']; //temporary location of a file

	$username = s($_POST['username']);
	$user_email = s($_POST['user_email']);
	$user_password = s($_POST['user_password']);
	// $post_date = date('d-m-y');

	// move_uploaded_file($post_image_temp, "../images/$post_image");

	$query = "SELECT randSalt FROM users";
	$select_randsalt_query = mysqli_query($connection, $query);
	if (!$select_randsalt_query) {
		die("Query failed! " . mysqli_error($connection));
	}

	$row = mysqli_fetch_array($select_randsalt_query);
	$salt = $row['randSalt'];
	$user_password = crypt($user_password, $salt);
	$query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) ";
	$query .= "VALUES('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_email}', '{$user_password}' ) ";

	$create_user_query = mysqli_query($connection, $query);

	confirmQuery($create_user_query);


	?>

	<p>The user has been created successfully! <a href='users.php'>View Users</a></p>

<?php

}

 ?>

<form action="" method="post" enctype="multipart/form-data"> <!-- enctype is in charge for sending diffrent types of form data -->
	

	<div class="form-group">
		<label for="author">First name</label>
		<input type="text" class="form-control" name="user_firstname">
	</div>

	<div class="form-group">
		<label for="post_status">Last Name</label>
		<input type="text" class="form-control" name="user_lastname">
	</div>

	<div class="form-group">
		<select name="user_role" id="user_category">
			<option value="subscriber">Select option</option>
			<option value="admin">Admin</option>
			<option value="subscriber">Subscriber</option>

		</select>
	</div>



<!-- 	<div class="form-group">
		<label for="image">Post Image</label>
		<input type="file" name="image">
	</div> -->

	<div class="form-group">
		<label for="post_tags">Username</label>
		<input type="text" class="form-control" name="username">
	</div>

	<div class="form-group">
		<label for="post_content">Email</label>
		<input type="email" class="form-control" name="user_email">
	</div>

	<div class="form-group">
		<label for="post_content">Password</label>
		<input type="password" class="form-control" name="user_password">
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_user" value="Add user">
	</div>


</form>