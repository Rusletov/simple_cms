<?php include 'includes/db.php'; ?>

<?php include 'includes/header.php'; ?>
    <!-- Navigation -->
<?php include 'includes/navigation.php'; ?>


    <!-- Page Content -->
    <div class="container">

        <?php 

            if (isset($_GET['p_id'])) {
                $the_post_id = $_GET['p_id'];
            
                $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = {$the_post_id}";
                $send_query = mysqli_query($connection, $view_query);
                if (!$send_query) {
                    die("Query failed!" . mysqli_error($connection));
                }

        ?>

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php 

                $query = "SELECT * FROM posts WHERE post_id = {$the_post_id}";
                $select_all_posts_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {

                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        $post_status= $row['post_status'];
                        
                        if (!isset($_SESSION['user_role']) && $post_status == 'draft') {

                                header("Location: index.php");

                        } // if user_role is not defined and post is draft, redirect to the main page.
                
             
                ?>

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?= $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?= $post_author; ?>"><?= $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?= $post_date; ?></p>
                <hr>
                <?php if ($post_image): ?>
                    <img class="img-responsive" src="images/<?= $post_image; ?>" alt="">
                <hr>
                <?php endif ?>
                <p><?= $post_content ?></p>
                

                <hr>


                <?php 
                } 

            } else {
                header('Location: index.php'); // redirect if doesn't have post id.
            }

            ?> <!-- end while loop and if -->
                        



                <!-- Blog Comments -->

    <?php 

    if (isset($_POST['create_comment'])) {

        $the_post_id = $_GET['p_id'];
        $comment_author = $_POST['comment_author'];
        $comment_email = $_POST['comment_email'];
        $comment_content = $_POST['comment_content'];


        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date ) ";
            $query .= "VALUES ({$the_post_id}, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now() ) ";

            $create_comment_query = mysqli_query($connection, $query);
            confirmQuery($create_comment_query);

            $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
            $query .= "WHERE post_id = {$the_post_id}";
            $update_comment_count =  mysqli_query($connection, $query);
            confirmQuery($update_comment_count);
        } else {
            $empty_comment_field = true;
        }





    }


    ?>

                <!-- Comments Form -->
                <div class="well">
                    <?php 
                    if (isset($empty_comment_field)) {
                    ?>
                    <strong style="color: red;">All these fields cannot be empty!</strong>
                    <?php
                    }
                    ?>
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                        <div class="form-group">
                            <label for="comment_author">Author</label>
                            <input class="form-control" type="text" name="comment_author">
                        </div>
                        <div class="form-group">
                            <label for="comment_email">Email</label>
                            <input class="form-control" type="text" name="comment_email">
                        </div>
                        <div class="form-group">
                            <label for="comment_content">Your Comment</label>
                            <textarea name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

            <?php 

                $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
                $query .= "AND comment_status = 'approved' ";
                $query .= "ORDER BY comment_id DESC ";
                $select_comment_query = mysqli_query($connection, $query);
                confirmQuery($select_comment_query);

                    while ($row = mysqli_fetch_assoc($select_comment_query)) {
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        $comment_author = $row['comment_author'];
                ?>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?= $comment_author; ?>
                            <small><?= $comment_date; ?></small>
                        </h4>
                        <?= $comment_content; ?>
                    </div>
                </div>

            <?php } ?>






            </div>

            <!-- Blog Sidebar Widgets Column -->
        <?php include 'includes/sitebar.php'; ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include 'includes/footer.php'; ?>
