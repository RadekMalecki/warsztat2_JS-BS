<!DOCTYPE html>
<?php
require __DIR__ . '/../authorization.php';
require __DIR__ . '/../class/user.php';
require __DIR__ . '/../class/tweets.php';
require __DIR__ . '/../class/comments.php';
require __DIR__ . '/../config.php';
?>
<html>


    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
        <script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
        <script src="../js/app.js" type="text/javascript"></script>
        <meta charset="UTF-8">
        <title>twitter</title>
    </head>

    <body>
        <div class="container">
            <header class="panel-heading">

                <div class="col-lg-12 bg-primary panel panel-default well loginPanel">
                    <h3 class="text-center">
                        <form class="form-inline" method="post" action="#">
                            <div class="form-group">
                                <label class="sr-only" for="exampleInputEmail3">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email" name="logEmail">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="exampleInputPassword3">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword3" placeholder="Password" name="logPassword">
                            </div>
                            <button type="submit" class="btn btn-default" name="loginbutton">Sign in</button>
                        </form>
                    </h3>
                </div>
            </header>
            <!-- LOGIN -->
            <?php
            require __DIR__ . '/../login.php';
            ?>
            <div class="panel-body">

                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="text-center text-info">RECENT PUBLIC TWEETS</h3>
                            <h6 class="text-center text-info">more tweet only for logged users</h6>
                        </div>
                    </div>
                    <?php
                    $PublicTweets = Tweet::loadAllPublicTweets($conn);
                    foreach ($PublicTweets as $row) {

                        $old_date = $row->getCreationDate();
                        $old_date_timestamp = strtotime($old_date);
                        $new_date = date('d F Y, G:i', $old_date_timestamp);
                        ?>
                        <div class='panel panel-default'>

                            <div class='panel-body'>
                                <div class="pull-left image">
                                    <img src="https://assets.pinshape.com/default/avatar-pin.jpg" class="img-circle avatar" alt="user profile image">
                                </div>
                                <div class='pull-left meta'>
                                    <div class='title h5'>
                                        <b class='text-primary'><?php echo $row->username; ?></b>
                                        made a post.
                                    </div>
                                    <h6 class='text-muted time'><?php echo $new_date; ?></h6>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 tweet "><p class=''><?php echo $row->getTweet(); ?></p></div>
                            </div>
                            <hr>
                            <div class='panel-body show-comment'>
                                <?php
                                $comment = Comments:: loadAllCommentsByTweetId($conn, $row->getId());
                                foreach ($comment as $row1) {

                                    $old_date = $row1->getCreationDate();
                                    $old_date_timestamp = strtotime($old_date);
                                    $new_date = date('d.m.y G:i', $old_date_timestamp);
                                    ?>

                                    <ul class='comments-list'>
                                        <li class='comment'>
                                            <div class='comment-body'>
                                                <div class='comment-heading'>
                                                    <i class='fa fa-comment-o' aria-hidden='true'></i> <b class='h5 text-warning'><?php echo $row1->username; ?> </b>
                                                    <b class='h6 text-muted'><?php echo $new_date; ?></b>
                                                </div>
                                                <p class='font-comment tweet'><?php echo $row1->getComment(); ?></p>
                                            </div>
                                        </li> 
                                    </ul>

                                <?php } ?>
                            </div>          
                        </div>
                    <?php } ?>
                </div>
                <div class="col-lg-4">

                    <div class="row well registerPanel">

                        <div class="col-md-12">

                            <h3 class="text-center text-info">New on Twitter? Sign up</h3>
                            <form class="" method="post" action="#" autocomplete="off">

                                <div class="form-group">
                                    <label for="email" class="cols-sm-2 control-label">Your Email</label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                                            <input type="text" class="form-control" name="emailaddress" id="emailValid" placeholder="Enter your Email" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="username" class="cols-sm-2 control-label">Username</label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
                                            <input type="text" class="form-control" name="username" id="username" placeholder="Enter your Username" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="cols-sm-2 control-label">Password</label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                            <input type="password" class="form-control" name="userpassword" id="password" placeholder="Enter your Password" />
                                        </div>
                                    </div>
                                </div>

                               

                                <div class="form-group ">
                                    <button target="_blank" id="signup" class="btn btn-primary btn-lg btn-block login-button" name="signup">sign up</button>
                                </div>

                            </form>
                            <!-- REGISTRATION -->
                            <?php
                            require __DIR__ . '/../registration.php';
                            ?>
                        </div>
                    </div>
                </div>


            </div>

    </body>

</html>
