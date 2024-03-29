            <div class="col-md-4">


                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="post">

                    <div class="input-group">
                        <input name="search" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>

                    </form><!-- search form -->
                    <!-- /.input-group -->
                </div>

<?php if (!isset($_SESSION['user_role'])) { ?>
    

                <!-- Login -->
                <div class="well">
                    <h4>Login</h4>
                    <form action="includes/login.php" method="post">

                    <div class="form-group">
                        <input name="username" type="text" class="form-control" placeholder="Enter username">
                    </div>
                    <div class="input-group">
                        <input name="password" type="password" class="form-control" placeholder="Enter password">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" name="login" type="submit">Submit</button>
                        </span>
                    </div>

                    </form><!-- login form -->
                    <!-- /.input-group -->
                </div>

<?php } else { ?>

                            <!-- Logout -->
                <div class="well">
                    <h4>Log out</h4>
                    <form action="includes/logout.php" method="post">

                        <p>Hi <?= $_SESSION['username'] ?>!</p>

                            <button class="btn btn-primary" name="logout" type="submit">Log out</button>


                    </form><!-- logout form -->
                    <!-- /.input-group -->
                </div>

<?php }?>

                <!-- Blog Categories Well -->
                <div class="well">


                <?php

                    $query = "SELECT * FROM categories";
                    $select_categories_sitebar = mysqli_query($connection, $query);


                ?>

                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                <?php

                    while ($row = mysqli_fetch_assoc($select_categories_sitebar)) {
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];

                ?>

                <li><a href="category.php?category=<?= $cat_id; ?>"><?= $cat_title; ?></a></li>

                <?php } ?>

                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <?php include 'widget.php' ?>

            </div>