 <?php
        require_once '../utils/connection.php';
        //get the post result from the frontend and put them in variables
        $uid = $_POST['userId'];
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $email = $_POST['email'];
        $username = $_POST['username'];

        if($fname === " " || $lname === "" || $email === "" || $username === "" ||$uid==""){
            $_SESSION["error-message"] = "All fields are required!";
            header("Location: updateProfileForm.php");
        }
        else{
            if(!$connect){
                $_SESSION["error-message"] = "Connection Error!";
                header("Location: updateProfileForm.php");
            }
            else{
                $selectQuery = mysqli_query($connect,"SELECT * FROM users where user_id=$uid");
                $rowUser=mysqli_fetch_assoc($selectQuery);
                //receive the profile picture file
                if($_FILES['profilePic']['name'] == ""){
                    $final_filename = $rowUser["profilePic"];
                }
                else {
                    $temporary_file_data = $_FILES['profilePic']['tmp_name'];
                    $unique_id = uniqid();
                    $final_filename = $unique_id . $_FILES['profilePic']['name'];
                    move_uploaded_file($temporary_file_data, '../profileUploads/' . $final_filename);
                    $old_profile_pic = $rowUser["profilePic"];
                    if($old_profile_pic != 'defaultProfile.png'){
                        unlink("../profileUploads/$old_profile_pic");
                    }
                }
                $updateQuery = "UPDATE users set firstname='$fname',lastname='$lname',profilePic='$final_filename',username='$username',email='$email' WHERE user_id=$uid";
                $result = mysqli_query($connect,$updateQuery);
                if(!$result){
                    $_SESSION["error-message"] = "Failed to update user due to ".mysqli_error($connect);
                    header("Location: updateProfileForm.php");
                }
                else{
                   header('Location:userProfile.php');
                }
            }
        }
        ?>

