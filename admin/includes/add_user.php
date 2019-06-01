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
	$post_comment_count = 0;

	move_uploaded_file($post_image_temp, "../images/$post_image");

	$query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status, post_comment_count) ";

	$query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}', {$post_comment_count} ) ";

	$create_post_query = mysqli_query($connection, $query);

	confirmQuery($create_post_query);

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