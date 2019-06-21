<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php 

if (isset($_POST['submit'])) {
    $firstname = s($_POST['firstname']);
    $lastname = s($_POST['lastname']);
    $username = s($_POST['username']);
    $email = s($_POST['email']);
    $password = s($_POST['password']);


    if (!empty($username) && !empty($email) && !empty($password)) {

        $query = "SELECT randSalt from users";
        $select_randsalt_query = mysqli_query($connection, $query);
        // Could have used my custom function ConfirmQuery().
        if (!$select_randsalt_query) {
            die('Query FAILED! ' . mysqli_error($connection));
        }

        $row = mysqli_fetch_array($select_randsalt_query);

        $salt = $row['randSalt'];
        $password = crypt($password, $salt);

        $query = "INSERT INTO users (user_firstname, user_lastname, username, user_email, user_password, user_role) ";
        $query .= "VALUES ('{$firstname}', '{$lastname}', '{$username}', '{$email}', '{$password}', 'subscriber')";
        $register_user_query = mysqli_query($connection, $query);
        if (!$register_user_query) {
            die("Query Failed. " . mysqli_error($connection) . ' ' . mysqli_errno($connection));
        }

        $message = "Your registration has been submitted!";

    } else {
        $message = "All the fields cannot be empty";
    }
        
    
} else {
    $message = "";
}

?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <h6 class="text-center"><?= $message; ?></h6>
                        <div class="form-group">
                            <label for="firstname" class="sr-only">first name</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter your first name">
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="sr-only">last name</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter your last name">
                        </div>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
