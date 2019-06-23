<?php include 'includes/db.php'; ?>

<?php include 'includes/header.php'; ?>
    <!-- Navigation -->
<?php include 'includes/navigation.php'; ?>


    <!-- Page Content -->
    <div class="container">

        <?php 

            if (isset($_GET['author'])) {
                // $the_post_id = $_GET['p_id'];
                $the_post_author = $_GET['author'];
            }


        ?>

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <p class="lead">
                    All posts by <?= $the_post_author; ?>
                </p>

            <?php 

                $query = "SELECT * FROM posts WHERE post_author = '{$the_post_author}'";
                $select_all_posts_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $the_post_id = $row['post_id'];
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

                <!-- Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?= $the_post_id; ?>"><?= $post_title ?></a>
                </h2>
                
                <p><span class="glyphicon glyphicon-time"></span> <?= $post_date; ?></p>
                <hr>
                <?php if ($post_image): ?>
                    <img class="img-responsive" src="images/<?= $post_image; ?>" alt="">
                <hr>
                <?php endif ?>
                
                <p><?= $post_content ?></p>
                

                <hr>


                <?php } ?> <!-- end while loop -->
                        




            </div>

            <!-- Blog Sidebar Widgets Column -->
        <?php include 'includes/sitebar.php'; ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include 'includes/footer.php'; ?>
