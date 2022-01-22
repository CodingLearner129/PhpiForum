<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>iForum - Coding Forums</title>

    <link rel="stylesheet" href="./css/style.css">

</head>

<body>
    <?php include "./partials/_dbconnect.php"; ?>
    <?php include "./partials/_header.php"; ?>

    <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE `thread_id` = '$id'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if($num > 0 ){
            while($row = mysqli_fetch_assoc($result)){
                $id = $row['thread_id'];
                $title = $row['thread_title'];
                $decs = $row['thread_desc'];
                $thread_user_id = $row['thread_user_id'];
            }
        }
    ?>

    <?php
        $showAlert = false;
        $method = $_SERVER["REQUEST_METHOD"];
        if($method == "POST"){
            // Insert into comment DB
            $comment = $_POST["comment"];
            $comment = str_replace("<", "&lt;", $comment);
            $comment = str_replace(">", "&gt;", $comment);
            $user_id = $_POST["user_id"];
            $sql = "INSERT INTO `comments`(`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES('$comment', '$id', '$user_id', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showAlert = true;
            if($showAlert){
                echo'
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your comment has been added!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        }

        // Query of user table to find the name of posted by
        $sqlu = "SELECT `user_name` FROM `users` WHERE `sno`='$thread_user_id'";
        $resultu = mysqli_query($conn, $sqlu);
        $rowu = mysqli_fetch_assoc($resultu);
        $postedBy = $rowu['user_name'];
    ?>

    <!-- Category container starts here -->
    <div class="container my-4">
        <div class="alert alert-secondary py-4" role="alert">
            <h2 class="alert-heading"><?php echo $title; ?></h2>
            <p><?php echo $decs; ?></p>
            <hr>
            <p class="mb-3">This is peer to peer forum.
                <!-- for sharing knowledge with each other. -->
                No Spam / Advertising / Self-promote in the forums is not allowed. Do not post copyright-infringing
                material. Do not post “offensive” posts, links or images. Do not cross post questions. Remain respectful
                of other members at all times.
            </p>
            <p>Posted by: <b><?php echo $postedBy; ?></b></p>
            <!-- <a class="btn btn-success mb-2" href="#" role="button">Learn more</a> -->
        </div>
    </div>

    <?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
            echo'
            <div class="container my-3">
                <h1 class="py-2">Post Your Comment</h1>
                <form action="' . $_SERVER["REQUEST_URI"] . '" method="post" >
                    <div class="mb-3">
                        <label for="comment" class="form-label">Write Your Comment</label>
                        <textarea class="form-control" aria-label="With textarea" id="comment" name="comment" row="3"></textarea>
                        <input type="hidden" value="' . $_SESSION['userid'] . '" name="user_id">
                    </div>
                    <button type="submit" class="btn btn-success">Post Comment</button>
                </form>
            </div>';
        }
        else{
            echo '
            <div class="container">
                <h1 class="py-2">Post Your Comment</h1>
                <p class="px-4">You are not loggedin. Please login to post comments.</p>
            </div>';    
        }
    ?>

    <div class="container mb-5" id="ques">
        <h1 class="py-2">Comments</h1>

        <?php
            $id = $_GET['threadid'];
            $sql = "SELECT * FROM `comments` WHERE `thread_id` = '$id'";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);
            $noResult = true;
            if($num > 0 ){
                while($row = mysqli_fetch_assoc($result)){
                    $noResult = false;
                    $id = $row['comment_id'];
                    $content = $row['comment_content'];
                    $commentTime = $row['comment_time'];
                    $commentBy = $row['comment_by'];

                    $sql2 = "SELECT `user_name` FROM `users` WHERE `sno`='$commentBy'";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);

                    echo '
                    <div class="d-flex align-items-center my-3 rounded">
                        <div class="flex-shrink-0">
                            <img src="./img/userdefault.png" width="32px" class="mr-3" alt="...">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="fw-bold my-0">' . $row2["user_name"] . ' </p>
                            ' . $content . '
                        </div>
                        <p class="text-secondary">' . $commentTime . '</p>
                    </div>';
                }
            }
            if($noResult){
                echo '
                    <div class="alert alert-light" role="alert">
                        <h4 class="alert-heading">No comments found!</h4>
                        <p class="mb-0">Be the first person to post a comment.</p>
                    </div>';
            }
        ?>


        <!-- Putting this for just check html alignment -->
        <!-- <div class="d-flex align-items-center my-3">
            <div class="flex-shrink-0">
                <img src="./img/userdefault.png" width="40px" class="mr-3 mb-4" alt="...">
            </div>
            <div class="flex-grow-1 ms-3">
                <h5>Unable to install Pyaudio error in Windows</h5>
                This is some content from a media component. You can replace this with any content and adjust it as needed.
            </div>
        </div> -->
    </div>

    <?php include "./partials/_footer.php"; ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>