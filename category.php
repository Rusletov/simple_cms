<?php include 'includes/db.php'; ?>

<?php include 'includes/header.php'; ?>
    <!-- Navigation -->
<?php include 'includes/navigation.php'; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php

            if (isset($_GET['category'])) {
                $post_category_id = $_GET['category'];
            }

            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == "admin") {
                $query = "SELECT * FROM posts WHERE post_category_id = '{$post_category_id}' ORDER BY post_id DESC";
            } else {
                $query = "SELECT * FROM posts WHERE post_category_id = '{$post_category_id}' AND post_status = 'published' ORDER BY post_id DESC";
            }


                $select_all_posts_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_status = $row['post_status'];
                        $post_content = rtrim(substr($row['post_content'], 0, 250)) . '... ';

                ?>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?= $post_id; ?>"><?= $post_title ?></a>
                    <?php
                        if ($post_status == 'draft') {
                    ?>
                        <small>DRAFT</small>
                    <?php 
                        }
                    ?>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?= $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?= $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?= $post_image; ?>" alt="">
                <hr>
                <p><?= $post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?= $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>


                <?php } ?> <!-- end while loop -->


            </div>

            <!-- Blog Sidebar Widgets Column -->
        <?php include 'includes/sitebar.php'; ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include 'includes/footer.php'; ?>
