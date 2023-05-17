
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css" type="text/css">
    <title>Profile</title>

</head>

<body>

    <!-- nav bar -->
    <?php
    
        $section = 'prof';
        include 'sections/header.php';
        
        $name = $user['firstname'] .' '. $user['middlename'] .' '. $user['lastname'];
        $birthdate = !empty($user['birthdate']) ? date('F d, Y', strtotime($user['birthdate'])) : '';
    ?>

    <!-- profile -->
    <div class="wrapper">
        <div class="container2">
        <div id="info">
            <div class="info-content">
                <div class="image">
                    <img style="width: 150px; height: 150px;" src="img/user.png">
                </div>
                <div class="name" style="font-size: 30px; font-weight:bold;"><?php echo $name ?></div>
                <div class="line" ><hr></div>
                <div class="birthday-icon">
                <img src="img/BdayIcon.png" alt="">
                                
                </div>
                <div class="birthday-text">  Birthday: <?php echo $birthdate; ?></div>
                <div class="gender-icon">
                    <img src="img/GenderIcon.png" alt="">
                </div>
                <div class="gender-text"> Gender: <?php echo $user['gender']; ?></div>
                <div class="email-icon">
                    <img src="img/Email Icon.png" alt="">
                </div>
                <div class="email-text"> Email: <?php echo $user['email']; ?></div>
                <div class="contact-icon">
                    <img src="img/ContactIcon.png" alt="">
                </div>
                <div class="contact-text"> Contact: <?php echo $user['contactnumber']; ?></div>
            </div>

        </div>
        <div id="address">
            <div class="address-content">
            <div class="address-icon">
            <img src="img/Home.png" alt="">
            </div>
            <div class="address-text">
                Address:
            </div>
            <div class="hline" style="width: 100%; "><hr></div>

            <div class="brgy-text">
                    Barangay: <?php echo $user['barangay']; ?>
            </div>
            <div class="cm-text">
                    City/Municipality: <?php echo $user['municipality']; ?>
            </div>
            <div class="prov-text">
                    Province: <?php echo $user['province']; ?>
            </div>
            </div>
            
        </div>
        <div id="notif">
            <div class="notif-content vote-status">
                <span>Vote Status: <?php echo ($user['voted']) ? 'DONE' : 'N/A'; ?></span>
            </div>
        </div>
        
    </div>
    <!-- profile  -->

    <!-- footer -->
    <footer>
        <ul>
            <li>
                @2021-2022. All Rights Reserved
            </li>
        </ul>

    </footer>
    <!-- footer -->



</body>

</html>