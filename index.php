<?php 

include 'config.php';

session_start();

error_reporting(0);

if (isset($_SESSION['loggedInUser'])) {
    header("Location: statistics.php");

} 

if (isset($_POST['submitLogin'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];

	$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
	$result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0) {
		$row = mysqli_fetch_assoc($result);
		unset($row['password']);
		$_SESSION['loggedInUser'] = $row;
		header("Location: statistics.php");
        
	} else {
		echo '<script type="text/javascript">
               window.onload = function () { alert("Wrong password"); } 
        </script>';
	}
}

?>

<?php

if (isset($_POST['submitRegistration'])) {
	$firstname = $_POST['firstname'];
	$middlename = $_POST['middlename'];
	$lastname = $_POST['lastname'];
	$birthdate = $_POST['birthdate'];
	$password = $_POST['password'];
	$cpassword = $_POST['cpassword'];
	$email = $_POST['email'];
	$contactnumber = $_POST['contactnumber'];
	$barangay = $_POST['barangay'];
	$municipality = $_POST['municipality'];
	$province = $_POST['province'];
	$gender = $_POST['gender'];
    $usertype = $_POST['usertype'];

    $today = date("Y-m-d");
    $diff = date_diff(date_create($birthdate), date_create($today));
    $age = $diff->format('%y');

    if ($age < 18) {
        echo "<script>alert('You are not of legal age.')</script>";
    } else if ($password != $cpassword) {
        echo "<script>alert('Password Not Matched.')</script>";
    } else {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if (!$result->num_rows > 0) {
            $sql = "INSERT INTO users (firstname, middlename, lastname, birthdate, password, email, contactnumber, barangay, municipality, province, gender, usertype)
					VALUES ('$firstname', '$middlename', '$lastname', '$birthdate', '$password', '$email', '$contactnumber', '$barangay', '$municipality', '$province', '$gender', '$usertype')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('Wow! User Registration Completed.')</script>";
            } else {
                echo "<script>alert('Woops! Something Wrong Went.')</script>";
            }
        } else {
            echo "<script>alert('Woops! Email Already Exists.')</script>";
        }

    }
}
?>

<!-- https://stackoverflow.com/questions/14447444/modal-pop-up-fade-in-on-open-click-and-fade-out-on-close -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css" type="text/css">
    <link rel="stylesheet" href="css/font.css" type="text/css">
    <link rel=" stylesheet" href="css/font-awesome.min.css" type="text/css">
    <!-- <link rel="stylesheet" href="css/style.css" type="text/css"> -->

    <title>Home</title>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>">
    <script src="js/jquery3.1.0.min.js"></script>
</head>

<body>
    <!-- nav bar -->
    <div class="nav_container">
        <nav>
            <div class="logo"><img src="img/logo2.png" width="30" height="40" alt=""></div>
            <ul>

                <li><a id="login-show" class="login-show" style="user-select: none; font-size:1em;">SIGN IN</a></li>
                <li><a id="registration" class="registration" style="user-select: none;">SIGN UP</a></li>

            </ul>

        </nav>
    </div>
    <!-- nav -->
    <!-- video gallery  -->
    <div class="container2">
        <div class="row">
            <div class="youtube_video">
                <iframe width="100%" height="100%" id="video_id" src="https://www.youtube.com/embed/JVEKHZmH6YI?rel=0"
                    frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
            <div class="details">
                <hr>
                <br>
                <p style="color: white;" class="quote">
                    " Vote for the Philippines you <br> want to see. "
                </p>
                <br>

                <hr>
            </div>
        </div>
        <div class="gallery">
            <div class="item">
                <img src="images/cnn1.jpg" data-id="QpwH9cO7nLg?rel=0" />
                <div class=" youtube_icon">
                    <img src="images/youtube.svg" />
                </div>
            </div>
            <div class="item">
                <img src="images/cnn2.jpg" data-id="QaHbEMVYzjo?rel=0" />
                <div class="youtube_icon">
                    <img src="images/youtube.svg" />
                </div>
            </div>
            <div class="item">
                <img src="images/ust1.jpg" data-id="JVEKHZmH6YI?rel=0" />
                <div class="youtube_icon active">
                    <img src="images/youtube.svg" />
                </div>
            </div>
            <div class="item">
                <img src="images/ust2.jpg" data-id="nc-RXeXPOg4?rel=0" />
                <div class="youtube_icon">
                    <img src="images/youtube.svg" />
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $(".item").click(function() {
            let youtube_id = $(this).children("img").attr("data-id");
            $(this)
                .children(".youtube_icon")
                .addClass("active")
                .parent()
                .siblings()
                .children(".youtube_icon")
                .removeClass("active");

            let newUrl = `https://www.youtube.com/embed/${youtube_id}`;
            $("#video_id").attr("src", newUrl);
        });
        //due to slow connection video is playing slow
        // you can call your playlist using youtube api
    });
    </script>
    <!-- video gallery  -->
    <!-- footer -->
    <footer>
        <ul>
            <li>
                @2021-2022. All Rights Reserved
            </li>
        </ul>

    </footer>
    <!-- footer -->

    <!-- Login -->

    <div id="login-modal" class="box">
        <div class="modal">
            <div class="top-form">
                <div class="close-modal">
                    &#10006;
                </div>
            </div>
            <div class="container">
                <form action="" method="POST" class="login-email" autocomplete="off">
                    <p class="login-text" style="font-family: sans-serif; font-size:40px">Login</p>
                    <br>
                    <!-- EMAIL  -->
                    <div class="input-group">
                        <input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
                    </div>
                    <!-- PASSWORD -->
                    <div class="input-group">
                        <input type="password" placeholder="Password" name="password"
                            value="<?php echo $_POST['password']; ?>" required>
                    </div>
                    <!-- LOG IN BUTTON -->
                    <div class="input-group">
                        <button type="submit" name="submitLogin" class="btn">Login</button>
                    </div>
                    <!-- REGISTER -->
                    <br>
                    <hr>
                    <br>
                    <p class="login-register-text" style="font-family:sans-serif">Don't have an account? <a
                            class="register" style="user-select: none; color:blue; font-family:sans-serif;">Register
                            Here</a></p>
                </form>

            </div>



        </div>
    </div>


    <!-- /LOG IN -->
    <!-- sign up -->

    <div id="signup-modal" class="box2">
        <div class="modal2">
            <br>
            <div class="top-form2">

                <div class="close-modal">
                    &#10006;
                </div>
            </div>
            <div class="signup">
                <p class="reg" style="font-family: sans-serif; font-size:40px">Register</p>
                <br>

                <form action="" method="POST" class="regform" autocomplete="off">
                    <div class="input-group2">
                        <div class="column-1">
                            <input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
                        </div>
                        
                        <!--  -->
                        <div class="input-group2">
                            <input type="password" placeholder="Password" name="password"
                                value="<?php echo $_POST['password']; ?>" required>
                        </div>
                        <div class="input-group2">
                            <input type="password" placeholder="Confirm Password" name="cpassword"
                                value="<?php echo $_POST['cpassword']; ?>" required>
                        </div>
                        <div class="input-group2">
                            <input type="date" placeholder="Birth Date" name="birthdate"
                                value="<?php echo $birthdate; ?>" required>
                        </div>
                        <div class="input-group2">
                            <input type="text" placeholder="Contact Number" name="contactnumber"
                                value="<?php echo $contactnumber; ?>" required>
                        </div>
                        <div class="input-group2" class="gender">
                            <select class="gender" name="gender" value="<?php echo $gender; ?>">
                                <option class="gender" disabled selected>Select Gender</option>
                                <option name="gender" value="Female">Female</option>
                                <option name="gender" value="Male">Male</option>
                                <option name="gender" value="Other">Other</option>
                            </select>
                        </div>
                        <div class="input-group2" class="usertype">
                            <select class=" usertype" name="usertype" value="<?php echo $usertype; ?>" required>
                                <option class="usertype" disabled selected>Select User Type</option>
                                <option name="usertype" value="voter">Voter</option>
                                <option name="usertype" value="official">Official</option>
                            </select>
                        </div>
                       
                        <!--  -->
                    </div>
                    <div class="column-2">
                    <div class="input-group2">
                            <input class="" type="text" placeholder="First Name" name="firstname"
                                value="<?php echo $firstname; ?>" required>
                        </div>
                        <div class="input-group2">
                            <input type="text" placeholder="Last Name" name="lastname" value="<?php echo $lastname; ?>"
                                required>
                        </div>
                       


                        <div class="input-group2">
                            <input type="text" placeholder="Middle Name" name="middlename"
                                value="<?php echo $middlename; ?>" required>
                        </div>
                       
                        <div class="input-group2">

                            <input type="text" placeholder="Barangay" name="barangay" value="<?php echo $barangay; ?>"
                                required>
                        </div>
                        
                        <div class="input-group2">
                            <input type="text" placeholder="City/Municipality" name="municipality"
                                value="<?php echo $municipality; ?>" required>
                        </div>
                        
                        <div class="input-group2">
                            <input type="text" placeholder="Province" name="province" value="<?php echo $province; ?>"
                                required>
                        </div>
                        <div class="input-group2">
                        <button name="submitRegistration" class="btn">Register</button>
                    </div>
                       
                    </div>

                   

                </form>
                <br>
                <hr>

                <br>
                <p class="login-register-text" style="font-family:sans-serif;"=>Have an account? <a class="register2"
                        style="user-select: none; color:blue; font-family:sans-serif;" id=" login-here">Login Here</a>
                </p>
                <br>
            </div>

        </div>
    </div>



    <script>
    $(function() {

        $('#login-show').click(function() {
            $('#login-modal').fadeIn().css("display", "flex");
        });

        $('#registration').click(function() {
            $('#signup-modal').fadeIn().css("display", "flex");
        });
        $('.register2').click(function() {
            $('#signup-modal').fadeOut();
            $('#login-modal').fadeIn().css("display", "flex");
        });
        $('.register').click(function() {
            $('#signup-modal').fadeIn().css("display", "flex");
            $('#login-modal').fadeOut();
        });



        $('.close-modal').click(function() {
            $('#login-modal').fadeOut();
        });
        $('.close-modal').click(function() {
            $('#signup-modal').fadeOut();
        });

    });
    </script>

</body>

</html>