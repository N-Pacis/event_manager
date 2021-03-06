<?php
session_start();
require_once '../utils/connection.php';
if (!$connect) {
    $_SESSION["error-message"] = "Connection to the database failed";
    header("Location: ../login-page/login.php");
} else {
    $user = $_SESSION["username"];
    if (!$user) {
        $_SESSION["error-message"] = "You need to login first!";
        header("Location: ../login-page/login.php");
    } else {
        $selectUserQuery = mysqli_query($connect, "SELECT * FROM users where username='$user'");
        $rowUser = mysqli_fetch_assoc($selectUserQuery);
        if (mysqli_num_rows($selectUserQuery) == 0) {
            $_SESSION["error-message"] = "No user found with the supplied username and password";
            header("Location: ../login-page/login.php");
        } else {
            $event = $_GET['event'];
            $_SESSION["event_id"] = $event;
            if (!$event) {
                header("Location: events-page.php");
            } else {
                $selectEventQuery = mysqli_query($connect, "SELECT * FROM events where event_id=$event");
                if (!$selectEventQuery) {
                    $_SESSION["error-message"] = "Invalid event!";
                    header("Location: events-page.php");
                } else {
                    $row = mysqli_fetch_assoc($selectEventQuery);
                    $selectEventMembersQuery = mysqli_query($connect,"SELECT * FROM event_members em INNER JOIN users u ON em.user_id=u.user_id where event_id=$event");
                }
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row["event_name"] ?></title>
    <script src="https://kit.fontawesome.com/1681f60826.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="dashboard-page.css?v=<?php echo time(); ?>">
</head>

<body id="body" onload="clearSession()">
    <?php if ($_SESSION['error-message'] != "") : ?>
        <div class="error-message-div">
            <p><?php echo $_SESSION['error-message']; ?></p>
        </div>
    <?php endif; ?>
    <a href="events-page.php" class="go-back-link">
        <i class="fa fa-angle-double-left"></i>Go back
    </a>
    <div class="event-page-image">
        <i class="far fa-images"></i>
        <p class="event-page-image-text">Event Image Here</p>
    </div>
    <div class="event-page-title">
        <h2 class="event-page-title-text"><?php echo $row["event_name"] ?></h2>
    </div>
    <div class="event-page-description">
        <p class="event-page-description-paragraph"><?php echo $row["event_description"] ?></p>
        <p class="event-page-duration"><span>Date:</span><?php echo $row["event_duration"] ?></p>
        <button id="invite-participant-btn" class="invite-participant-btn">Invite a participant</button>
        <div class="event-members">
            <div class="search-member">
                <i class="fa fa-search"></i>
                <input type="text" name="search-member" id="search-member" placeholder="Find A participant...">
            </div>
            <div class="members">
                <?php
                if (mysqli_num_rows($selectEventMembersQuery) == 0) {
                    echo '
                        <p>The event has no participants yet</p>
                        <button id="invite-participant-btn">Invite a participant</button>
                     ';
                }
                else{
                    while($rowParticipant = mysqli_fetch_assoc($selectEventMembersQuery)){
                        echo '
                           <div class="participant" >
                               <h2 id="participant-name">'.$rowParticipant["username"].'</h2>
                               <p>'.$rowParticipant["firstname"].' '. $rowParticipant["lastname"].'</p> 
                        ';
                        if($row["creator"] == $rowUser["user_id"]){
                            echo '<button id='.$rowParticipant["user_id"].' class="delete-participant">Remove <i class="fas fa-trash-alt"></i></button>';
                        }
                        echo '
                          </div>
                        ';
                    }
                }
                ?>

            </div>
        </div>
        <div class="participant-form" id="participant-form">
            <form action="add-participant-form.php" method="post">
                <i class="fas fa-times" id="close-participant-form"></i>
                <p class="invite-icon"><i class="fas fa-users"></i></p>
                <h1 class="invite-participant">Invite a participant to <span><?php echo $row["event_name"]?></span></h1>
                <div class="search-user">
                    <i class="fa fa-search"></i>
                    <input type="text" name="search-user" id="search-user" placeholder="Search user by username....">
                    <i class="fas fa-spinner fa-pulse"></i>
                </div>
                <div class="search-result" id="search-result">

                </div>
                <input type="submit" value="Invite to <?php echo $row["event_name"]?>" disabled class="add-participant-submit">
            </form>
        </div>
    </div>
    <script type="text/javascript">
        function clearSession() {
            <?php
            $_SESSION['error-message'] = "";
            ?>
        }
        document.getElementById('invite-participant-btn').addEventListener('click', function() {
            document.getElementById("participant-form").style.display = "block";
            document.getElementById("body").style.overflowY = "hidden";
            document.querySelector(".error-message-div").style.display = "none";
        });
        document.querySelector('#close-participant-form').addEventListener('click',function(){
            document.getElementById("participant-form").style.display="none";
        });

        $(document).ready(function(){
            $("#search-user").keyup(function(){
                let searchText = $(this).val();
                if(searchText != ''){
                    document.querySelector(".fa-pulse").style.display="block";
                    $.ajax({
                        url:"searchAction.php",
                        method:"post",
                        data:{query:searchText},
                        success:function(response){
                            $("#search-result").html(response);
                            document.querySelector(".fa-pulse").style.display="none";
                        }
                    });
                }
                else{
                    $("#search-result").html("");
                }
            });
            $(document).on("click","#search-list-group",function(){
                let text = $(this).text();
                let splitText = text.trim().split("\n");
                $("#search-user").val(splitText[0]);
                $("#search-result").html("");
                $(".add-participant-submit").removeAttr("disabled");
            });
        })
    </script>
</body>

</html>