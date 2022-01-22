<?php

  session_start();

  echo '
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
          <a class="navbar-brand" href="../forum">iForum</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="../forum">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="./about.php">About</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Top Categories
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    
                  $sql = "SELECT `category_name`, `category_id` FROM `categories` LIMIT 5";
                  $result = mysqli_query($conn, $sql);
                  while($row = mysqli_fetch_assoc($result)){
                    echo '<li><a class="dropdown-item" href="./threadlist.php?catid=' . $row["category_id"] . '">' . $row["category_name"] . '</a></li>';
                  }  
                echo '</ul>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="./contact.php">Contact</a>
                </li>
            </ul>
            <div class="d-flex">';
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
              echo'
              <form class="d-flex" method="get" action="search.php">
                <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-success" type="submit">Search</button>
                <p class="text-light mb-0 mx-2 text-center">Welcome ' . $_SESSION["username"] . '</p>
                <a href="./partials/_logout.php" class="btn btn-outline-success" type="submit">LogOut</a>
              </form>';
            }
            else{
              echo'
              <form class="d-flex" method="get" action="search.php">
                <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-success" type="submit">Search</button>
              </form>
              <button class="btn btn-outline-success mx-2" data-bs-toggle="modal" data-bs-target="#loginModal">LogIn</button>
              <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#signupModal">SignUp</button>';
            }
            echo '</div>
          </div>
      </div>
  </nav>';
  include "./partials/_loginModal.php";
  include "./partials/_signupModal.php";
  if(isset($_GET['alert']) && $_GET['alert']== true){
    if(isset($_GET['signupSuccess']) && $_GET['signupSuccess']=='true'){
      echo '
      <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
        <strong>Success!</strong> You can login now.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    elseif(isset($_GET['error']) && $_GET['error']!='false'){
        echo '
        <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
        <strong>Error!</strong> ' . $_GET['error'] . '!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    else{
        echo '
        <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
          <strong>Error!</strong> Signup Failed!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
  }
  if(isset($_GET['loginAlert']) && $_GET['loginAlert']== true){
    if(isset($_GET['loginSuccess']) && $_GET['loginSuccess']=='true'){
      echo '
      <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
        <strong>Success!</strong> You are loggedin successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    elseif(isset($_GET['loginError']) && $_GET['loginError']!='false'){
        echo '
        <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
        <strong>Error!</strong> ' . $_GET['loginError'] . '!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    else{
        echo '
        <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
          <strong>Error!</strong> Login Failed!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
  }
?>