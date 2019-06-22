<?php  

if (isset($_POST['checkBoxArray'])) {
    
    foreach ($_POST['checkBoxArray'] as $postValueId) {
        $bulk_options = $_POST['bulk_options'];

        switch ($bulk_options) {
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                $update_to_published_status = mysqli_query($connection, $query);
                confirmQuery($update_to_published_status);
                break;
            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                $update_to_draft_status = mysqli_query($connection, $query);
                confirmQuery($update_to_draft_status);
                break;
            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$postValueId} LIMIT 1 ";
                $update_to_delete_status = mysqli_query($connection, $query);
                confirmQuery($update_to_delete_status);
                break;
            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id = {$postValueId} ";
                $select_post_query = mysqli_query($connection, $query);
                if (!$select_post_query) {
                    die("Query Failed! " . mysqli_error($connection));
                }
                $row = mysqli_fetch_array($select_post_query);

                $post_author = s($row['post_author']);
                $post_title = s($row['post_title']);
                $post_category_id = s($row['post_category_id']);
                $post_status = s($row['post_status']);
                $post_image = s($row['post_image']);
                $post_tags = s($row['post_tags']);
                $post_date = s($row['post_date']);
                $post_content = s($row['post_content']);

                $query = "INSERT INTO posts (post_author, post_title, post_category_id, post_status, post_image, post_tags, post_date, post_content) ";
                $query .= "VALUES ('{$post_author}', '{$post_title}', {$post_category_id}, '{$post_status}', '{$post_image}', '{$post_tags}', now(), '{$post_content}') ";
                $copy_query = mysqli_query($connection, $query);
                if (!$copy_query) {
                    die("Query failed! " . mysqli_error($connection));
                }
        }
    }
}

?>

<form action="" method="post">

    <div id="bulkOptionsContainer" class="col-xs-4">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
        </select>
    </div>

    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a class="btn btn-primary" href="posts.php?source=add_post">Add new</a>
    </div>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th><input id="selectAllBoxes" type="checkbox" name=""></th>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>View Post</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Viewed</th>

        </tr>
    </thead>
    <tbody>

<?php 

    $query = "SELECT * FROM posts ORDER BY post_id DESC";
    $select_posts = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_posts)) {
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comments = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_views_count = $row['post_views_count'];

    ?>
    
    <tr>
        <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="<?= $post_id; ?>"></td>
        <td><?= $post_id; ?></td>
        <td><?= $post_author; ?></td>
        <td><?= $post_title; ?></td>

<?php 

        $query = "SELECT * FROM categories WHERE cat_id ={$post_category_id}";
        $select_categories_id = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_categories_id)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

?>

        <td><?= $cat_title; ?></td>
<?php } ?>        

        <td><?= $post_status; ?></td>
        <td><img width="100" src="../images/<?= $post_image; ?>" alt="image"></td>
        <td><?= $post_tags; ?></td>
        <td><?= $post_comments; ?></td>
        <td><?= $post_date; ?></td>
        <td><a href='../post.php?p_id=<?= s($post_id); ?>'>View Post</a></td>
        <td><a href='./posts.php?source=edit_post&p_id=<?= $post_id; ?>'>Edit</a></td>
        <td><a onclick="javascript: return confirm('Are you sure you want to delete this post?')" href='./posts.php?delete=<?= s($post_id); ?>'>Delete</a></td>
        <td><a onclick="javascript: return confirm('Are you sure you want to reset the views of this post?')" href="./posts.php?reset=<?= $post_id; ?>"><?= s($post_views_count); ?></a></td>

    </tr>
    

    <?php } // end while loop ?>

    </tbody>
</table>

</form>

<?php 

    if (isset($_GET['delete'])) {
        $the_post_id = $_GET['delete'];
        $query = "DELETE FROM posts WHERE post_id = '{$the_post_id}'";
        $delete_query = mysqli_query($connection, $query);
        confirmQuery($delete_query);
        header("Location: posts.php");
    }

    if (isset($_GET['reset'])) {
        $the_post_id = $_GET['reset'];
        $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = '{$the_post_id}'";
        $reset_query = mysqli_query($connection, $query);
        confirmQuery($reset_query);
        header("Location: posts.php");
    }


?>