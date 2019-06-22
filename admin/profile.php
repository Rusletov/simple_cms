<?php include 'includes/admin_header.php'; ?>

<?php 

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_profile_query = mysqli_query($connection, $query);
    confirmQuery($select_user_profile_query);

    while ($row = mysqli_fetch_array($select_user_profile_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }

}


?>


<?php 

if (isset($_POST['edit_user'])) {

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
    $hashed_password = crypt($user_password, $salt);


        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_role = '{$user_role}', ";
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_password = '{$hashed_password}' ";
        $query .= "WHERE user_id = {$user_id} ";

        $edit_user_query = mysqli_query($connection, $query);
        confirmQuery($edit_user_query);

}


?>

    <div id="wrapper">

        <!-- Navigation -->
<?php include 'includes/admin_navigation.php'; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">

                <h1 class="page-header">
                    Welcome to admin
                    <small>Author</small>
                </h1>


<form action="profile.php" method="post" enctype="multipart/form-data"> <!-- enctype is in charge for sending diffrent types of form data -->
    

    <div class="form-group">
        <label for="author">First name</label>
        <input type="text" value="<?= $user_firstname; ?>" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="post_status">Last Name</label>
        <input type="text" value="<?= $user_lastname; ?>" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <select name="user_role">
            <option value="subscriber" <?php SelectedUserRole('subscriber') ?>>Subscriber</option>
            <option value="admin" <?php SelectedUserRole('admin') ?>>Admin</option>
        </select>
    </div>



<!--    <div class="form-group">
        <label for="image">Post Image</label>
        <input type="file" name="image">
    </div> -->

    <div class="form-group">
        <label for="post_tags">Username</label>
        <input type="text" value="<?= $username; ?>" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="post_content">Email</label>
        <input type="email" value="<?= $user_email; ?>" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="post_content">Password</label>
        <input type="password" value="<?= $user_password; ?>" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update profile">
    </div>


</form>


                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include 'includes/admin_footer.php'; ?>
