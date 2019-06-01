<?php 

	if (isset($_GET['p_id'])) {
		$the_post_id = $_GET['p_id'];
	}

    $query = "SELECT * FROM posts WHERE post_id = '{$the_post_id}'";
    $select_post_by_id = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_post_by_id)) {
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comments = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_content = $row['post_content'];

    }

    if (isset($_POST['update_post'])) {
    	$post_author = s($_POST['author']);
    	$post_title = s($_POST['title']);
    	$post_category_id = s($_POST['post_category']);
    	$post_status = s($_POST['post_status']);
        $post_image = $_FILES['image']['name'];
		$post_image_temp = $_FILES['image']['tmp_name']; //temporary location of a file
        $post_content = s($_POST['post_content']);
        $post_tags = s($_POST['post_tags']);

		move_uploaded_file($post_image_temp, "../images/$post_image");

		if (empty($post_image)) {
			$query = "SELECT * FROM posts WHERE post_id = {$the_post_id}";
			$select_image = mysqli_query($connection, $query);
			confirmQuery($select_image);

			while ($row = mysqli_fetch_assoc($select_image)) {
				$post_image = $row['post_image'];
			}
		}

		$query = "UPDATE posts SET ";
		$query .= "post_title = '{$post_title}', ";
		$query .= "post_category_id = '{$post_category_id}', ";
		$query .= "post_date = now(), ";
		$query .= "post_author = '{$post_author}', ";
		$query .= "post_status = '{$post_status}', ";
		$query .= "post_tags = '{$post_tags}', ";
		$query .= "post_content = '{$post_content}', ";
		$query .= "post_image = '{$post_image}' ";
		$query .= "WHERE post_id = {$the_post_id} ";

		$update_post = mysqli_query($connection, $query);

		confirmQuery($update_post);



    }


?>

<form action="" method="post" enctype="multipart/form-data"> <!-- enctype is in charge for sending diffrent types of form data -->
	

	<div class="form-group">
		<label for="title">Post Title</label>
		<input value="<?= $post_title; ?>" type="text" class="form-control" name="title">
	</div>	

	<div class="form-group">
		<select name="post_category" id="post_category">
<?php 

            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);

            confirmQuery($select_categories);

            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
            
 ?>
 			<option value="<?= $cat_id ?>"><?= $cat_title ?></option>

<?php } ?>

		</select>
	</div>

	<div class="form-group">
		<label for="author">Post Author</label>
		<input type="text" value="<?= $post_author; ?>" class="form-control" name="author">
	</div>

	<div class="form-group">
		<select name="user_role" id="post_category">
		<?php 

            $query = "SELECT * FROM users";
            $select_users = mysqli_query($connection, $query);

            confirmQuery($select_users);

            while ($row = mysqli_fetch_assoc($select_users)) {
                $user_id = $row['user_role'];
                $user_role = $row['user_role'];
            
		 ?>
 			<option value="<?= $user_id ?>"><?= $user_role ?></option>

<?php } ?>

		</select>
	</div>

	<div class="form-group">
		<label for="post_status">Post Status</label>
		<input value="<?= $post_status ?>" type="text" class="form-control" name="post_status">
	</div>

	<div class="form-group">
		<img width="200" src="../images/<?= $post_image; ?>" alt="image">
		<input type="file" name="image">
	</div>

	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input value="<?= $post_tags; ?>" type="text" class="form-control" name="post_tags">
	</div>

	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea class="form-control" name="post_content" id="" cols="30" rows="10"><?= $post_content; ?></textarea>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
	</div>


</form>