<?php require_once('includes/db.php') ?>
<?php require_once('includes/header.php') ?>
<?php require_once('./functions.php'); ?>

    <!-- Navigation -->
    <?php require_once "includes/navigation.php" ?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php

                    if (isset($_GET['p_id'])) {

                        $the_post_id = $_GET['p_id'];

                    }
                
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
                    $select_all_posts_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];

                ?>

                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="#"><?= $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?= $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?= $post_date ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?= $post_image ?>" alt="">
                    <hr>
                    <p><?= $post_content ?></p>
                    <a class="btn btn-primary" href="#">Read More<span class="glyphicon glyphicon-chevron-right"></span></a>
                    
                <?php } ?>
                
                <!-- Blog Comments -->

                <?php
                
                if (isset($_POST['create_comment'])) {

                    $the_post_id = $_GET['p_id'];

                    $comment_author = $_POST['comment_author'];
                    $comment_email = $_POST['comment_email'];
                    $comment_content = $_POST['comment_content'];

                    $query = "INSERT INTO comments (comment_post_id, comment_author
                                                , comment_email, comment_content, comment_status, comment_date) ";
                    $query .= "VALUES($the_post_id, '{$comment_author}', '{$comment_email}'
                                    , '{$comment_content}', 'unapproved', now())";

                    $creat_comment_query = mysqli_query($connection, $query);
                    confirmQuery($creat_comment_query);

                    $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                    $query .= "WHERE post_id = $the_post_id ";
                    $update_comment_count = mysqli_query($connection, $query);
                    
                }

                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                        <div class="form-group">
                            <label for="Author">Author</label>
                            <input type="text" name="comment_author" class="from-control" name="comment_author">
                        </div>
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" name="comment_email" class="from-control" name="comment_email">
                        </div>
                        <div class="form-group">
                            <label for="Your Comment">Your Comment</label>
                            <textarea name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <?php
                
                $query = "SELECT * FROM comments WHERE comment_post_id = $the_post_id ";
                $query .= "AND comment_status = 'approved' ";
                $query .= "ORDER BY comment_id DESC ";
                $select_comment_query = mysqli_query($connection, $query);
                confirmQuery($select_comment_query);

                while ($row = mysqli_fetch_array($select_comment_query)) {
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
                        <h4 class="media-heading"><?= $comment_author ?>
                            <small><?= $comment_date; ?></small>
                        </h4>
                        <?= $comment_content; ?>
                    </div>
                </div>

                <?php } ?>

                <!-- <hr> -->
            </div>

            <?php require_once('includes/sidebar.php') ?>

        </div>
        <!-- /.row -->

        <hr>
<?php require_once('includes/footer.php') ?>