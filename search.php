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
    <?php 
        include "./partials/_dbconnect.php"; 
        $search = $_GET["search"];
    ?>
    <?php include "./partials/_header.php"; ?>
    <!-- Search Results -->
    <div class="container serachResults my-5">
        <h1 class="py-4">Search results for "<?php echo $search; ?>"</h1>
        <?php 
            $sql = "SELECT * FROM `threads` WHERE MATCH(`thread_title`, `thread_desc`) AGAINST('$search')";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);
            if($num > 0 ){
                while($row = mysqli_fetch_assoc($result)){
                    $id = $row['thread_id'];
                    $title = $row['thread_title'];
                    $decs = $row['thread_desc'];
                    $url = "thread.php?threadid=" . $id;
                    
                    // Display search result
                    echo '
                    <div class="result mx-5">
                        <h3><a href="' . $url . '" class="link-dark text-decoration-none">' . $title . '</a></h3>
                        <p>' . $decs . '</p>
                    </div>';
                }
            }
            else{
                echo '
                    <div class="container">
                        <h1 class="py-2 mx-4">No Results Found</h1>
                        <p class="mx-2 px-5">
                        Suggestions:
                            <ul class="mx-5 px-5">
                                <li>Make sure that all words are spelled correctly.</li>
                                <li>Try different keywords.</li>
                                <li>Try more general keywords.</li>
                            </ul>
                        </p>
                    </div>';
            }
        ?>
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