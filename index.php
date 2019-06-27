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
            $per_page = 3; // the number of posts per page.

            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            if ($page == "" || $page == 1) {
                $offset = 0;
            } else {
                $offset = ($page * $per_page) - $per_page;
            }


            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == "admin") {
                $post_query_count = "SELECT * FROM posts";
            } else {
                $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";
            }
            

            $find_count = mysqli_query($connection, $post_query_count);
            $num_posts = mysqli_num_rows($find_count); // the number of records in the table.

            $pages_count = ceil($num_posts / $per_page); // the number of pages.

            ?>

            <?php 

                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == "admin") {
                    $query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $offset, $per_page";
                } else {
                    $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT $offset, $per_page";
                }

                
                $select_all_posts_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = rtrim(substr($row['post_content'], 0, 250)) . '... ';
                        $post_status = $row['post_status'];
                        

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
                    by <a href="author_posts.php?author=<?= $post_author; ?>"><?= $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?= $post_date; ?></p>
                <hr>
                <?php if ($post_image): ?>
                    <a href="post.php?p_id=<?= $post_id; ?>"><img class="img-responsive" src="images/<?= $post_image; ?>" alt=""></a>
                <hr>
                <?php endif ?>
                <p><?= $post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?= $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>


                <?php } ?> <!-- end while loop and  -->


            </div>

            <!-- Blog Sidebar Widgets Column -->
        <?php include 'includes/sitebar.php'; ?>

        </div>
        <!-- /.row -->

        <hr>

        <!-- .pagination -->
        <?php if ($pages_count >= 2) { ?>
        <ul class="pager">
        <?php if ($page != 1) { // if the current page is greater than the first, output the links First and Previous ?>
            <li><a href="index.php?page=1">First</a></li>
            <li><a href="index.php?page=<?= $page - 1; ?>">Previous</a></li>
        <?php } ?>

        <?php  
        if ($page >= 3) {
        ?>
        <!-- output previous 2 pages links, if the current page is greater or equal to the third page -->
        <li><a href="index.php?page=<?= $page - 2; ?>"><?= $page -2; ?></a></li>
        <li><a href="index.php?page=<?= $page - 1; ?>"><?= $page -1; ?></a></li>
        <?php
        } else if ($page >= 2) {
        ?>
        <!-- output previous 1 page link, if the current is one greater than the first page -->
        <li><a href="index.php?page=<?= $page - 1; ?>"><?= $page -1; ?></a></li>
        <?php
        }
        ?>

        <!-- output the current page link -->
        <li><a class="active_link" href="index.php?page=<?= $page; ?>"><?= $page; ?></a></li>
        <!-- output the following 2 pages -->

        <?php  
        if ($page <= $pages_count - 2) {
        ?>
        <!-- next 2 pages -->
        <li><a href="index.php?page=<?= $page + 1; ?>"><?= $page + 1; ?></a></li>
        <li><a href="index.php?page=<?= $page + 2; ?>"><?= $page + 2; ?></a></li>
        <?php
        }
        /// output the following 1 link, if the current page is 1 less than the last page
        else if ($page <= $pages_count - 1) {
        ?>
        <!-- next 1 page -->
        <li><a href="index.php?page=<?= $page + 1; ?>"><?= $page + 1; ?></a></li>
        <?php
        }
        ?>

        <?php if ($page != $pages_count) { // if a page is less than the last one, output the buttons First and Previous ?>
            <li><a href="index.php?page=<?= $page + 1; ?>">Next</a></li>
            <li><a href="index.php?page=<?= $pages_count; ?>">Last</a></li>
            
        <?php } ?>

        </ul>
        <?php } ?>
        <!-- /.pagination -->


<?php include 'includes/footer.php'; ?>
