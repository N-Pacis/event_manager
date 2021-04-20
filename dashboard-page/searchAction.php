<?php
 session_start();
  require_once "../utils/connection.php";
  if(!$connect){
      $_SESSION["error-message"] = "Connection to the database failed";
      header("Location: ../login-page/login.php");
  }
  else{
      if(isset($_POST['query'])){
          $current_user = $_SESSION["username"];
          $inputText = $_POST['query'];
          $searchQuery = mysqli_query($connect,"Select username,firstname,lastname from users where username like '%$inputText%' and username != '$current_user' LIMIT 5");
          if(mysqli_num_rows($searchQuery) > 0){
              while($row = mysqli_fetch_assoc($searchQuery)){
                  echo '<div class="search-list-group" id="search-list-group">
                        <li href="" class="result-item">'.$row["username"].'</li>
                        <p class="result-item-two">'.$row["firstname"].' '.$row["lastname"].'</p>
                    </div>';
              }
          }
          else{
              echo '<div class="search-list-group">
                       <p>No user found</p>
                    </div>';
          }

      }
  }
?>