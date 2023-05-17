<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/vote.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <title>Vote</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var limit = 12;
            $("input[name='senators[]']").on('change', function(evt) {
                if($("input[name='senators[]']:checked").length > limit) {
                    this.checked = false;
                }
            });
        });
    </script>
</head>

<body>
    <!-- nav bar -->
    <?php
        $section = 'vote';
      
        include 'config.php';
        
        include 'sections/header.php';
        if (isset($_POST['submitVote'])) {

            $presidentialCandidate = !empty($_POST['pres']) ? $_POST['pres'] : null;
            $vicePresidentialCandidate = !empty($_POST['vpres']) ? $_POST['vpres'] : null;
            $senatorialCandidates = !empty($_POST['senators']) ? $_POST['senators'] : [];

            if (empty($presidentialCandidate) && empty($vicePresidentialCandidate) && empty($senatorialCandidates)) {
                echo "<script>alert('Please select a candidate to vote.')</script>";
            } else {
                $votingSuccessful = true;
                $candidateIds = [];

                if (!empty($presidentialCandidate)) {
                    $candidateIds[] = (int) $presidentialCandidate;
                }
                if (!empty($vicePresidentialCandidate)) {
                    $candidateIds[] = (int) $vicePresidentialCandidate;
                }
                if (!empty($senatorialCandidates)) {
                    foreach ($senatorialCandidates as $senatorialCandidate) {
                        $candidateIds[] = (int) $senatorialCandidate;
                    }
                }
                $candidateIds = implode(', ', $candidateIds);


                $insertVotes = $conn->query(
                    "UPDATE `candidate_votes` SET count = count + 1 WHERE candidate_id IN ($candidateIds)"
                );
                if ($insertVotes === true) {
                    echo "<script>alert('Congratulations, your vote has been submitted.')</script>";
                    $conn->query(
                        "UPDATE `users` SET voted = 1 WHERE id = " . $_SESSION['loggedInUser']['id']
                    );

                    $_SESSION['loggedInUser']['voted'] = 1;
                    echo "<script>
                            setTimeout(function() {
                                window.location.replace('./statistics.php');
                            }, 1000)
                        </script>";
                } else {
                    echo "<script>alert('Failed to submit vote.')</script>";
                }
            }
        }

        if (isset($_POST['viewVote'])) {
            $result = $conn->query("SELECT * FROM candidates");
            $candidates = $result->fetch_all(MYSQLI_ASSOC);

            $presidentialCandidate = !empty($_POST['pres']) ? $_POST['pres'] : null;
            $vicePresidentialCandidate = !empty($_POST['vpres']) ? $_POST['vpres'] : null;
            $senatorialCandidates = !empty($_POST['senators']) ? $_POST['senators'] : [];

            $votes = [
                'pres' => null,
                'vpres' => null,
                'senators' => []
            ];

            foreach ($candidates as $candidate) {
                if (!empty($presidentialCandidate) && ($candidate['id'] == $presidentialCandidate)) {
                    $votes['pres'] = $candidate;
                    continue;
                } else if (!empty($vicePresidentialCandidate) && ($candidate['id'] == $vicePresidentialCandidate)) {
                    $votes['vpres'] = $candidate;
                    continue;
                }

                if (empty($senatorialCandidates)) {
                    continue;
                }

                foreach ($senatorialCandidates as $senatorialCandidate) {
                    if ($candidate['id'] == $senatorialCandidate) {
                        $votes['senators'][] = $candidate;
                    }
                }
            }

            echo '<script type="text/javascript"> 
                    $(document).ready(function() {
                        document.getElementById("popup-1").classList.toggle("active");
                    });
                </script>';
        }
    ?>



    <!-- nav -->
    <!-- dropdown-->
    <form name="votingForm" id="votingForm" action="" method="POST" autocomplete="off" class="wrapper">
        <script type="text/javascript">
        $(document).ready(function() {


            /* by default hide all radio_content div elements except first element */
            $(".content .radio_content").hide();
            $(".content .radio_content:first-child").show();

            /* when any radio element is clicked, Get the attribute value of that clicked radio element and show the radio_content div element which matches the attribute value and hide the remaining tab content div elements */
            $(".radio_wrap").click(function() {
                var current_radio = $(this).attr("data-radio");
                $(".content .radio_content").hide();
                $("." + current_radio).show();
            });



        });
        </script>

        <div class="radio_tabs">
            <label class="radio_wrap" data-radio="radio_1">
                <input type="radio" name="candidates" class="input" checked>
                <span class="radio_mark">
                    President
                </span>
            </label>
            <label class="radio_wrap" data-radio="radio_2">
                <input type="radio" name="candidates" class="input">
                <span class="radio_mark">
                    Vice President
                </span>
            </label>
            <label class="radio_wrap" data-radio="radio_3">
                <input type="radio" name="candidates" class="input">
                <span class="radio_mark">
                    Senators
                </span>
            </label>
            <!--     <label class="radio_wrap" data-radio="radio_4">
			<input type="radio" name="sports" class="input">
			<span class="radio_mark">
				Golf
			</span>
		</label> -->
        </div>

        <div class="content">
            <div class="radio_content radio_1">
                <!-- Prsident -->
                <div class="wrapper2">
                    <h2 style="font-family: sans-serif;">Select only 1 candidate</h2>
                    <div class="radio-buttons">
                        <label class="custom-radio">
                            <input type="radio" name="pres"  <?php echo (!empty($presidentialCandidate) && $presidentialCandidate == 1) ? 'checked' : ''; ?> value="1" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/abella.png" />
                                    </div>
                                    <h2>1. Abella, Ernie</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="pres"  <?php echo (!empty($presidentialCandidate) && $presidentialCandidate == 2) ? 'checked' : ''; ?> value="2" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/2.jpg" />
                                    </div>
                                    <h2>2. De Guzman, Leody</h2>
                                    <span class="party">PLM</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="pres"  <?php echo (!empty($presidentialCandidate) && $presidentialCandidate == 3) ? 'checked' : ''; ?> value="3" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/3.png" />
                                    </div>
                                    <h2 style="text-align:center;">3. Domagoso, Isko Moreno</h2>
                                    <span class="party">AKSYON</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="pres"  <?php echo (!empty($presidentialCandidate) && $presidentialCandidate == 4) ? 'checked' : ''; ?> value="4" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/4.png" />
                                    </div>
                                    <h2 style="text-align:center;">4. Gonzales, Norberto</h2>
                                    <span class="party">PDSP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="pres"  <?php echo (!empty($presidentialCandidate) && $presidentialCandidate == 5) ? 'checked' : ''; ?> value="5" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/5.jpg" />
                                    </div>
                                    <h2>5. Lacson, Ping</h2>
                                    <span class="party">PDR</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="pres"  <?php echo (!empty($presidentialCandidate) && $presidentialCandidate == 6) ? 'checked' : ''; ?> value="6" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/6.jpg" />
                                    </div>
                                    <h2 style="text-align:center;">6. Mangondato, Faisal</h2>
                                    <span class="party">KTPNAN</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="pres"  <?php echo (!empty($presidentialCandidate) && $presidentialCandidate == 7) ? 'checked' : ''; ?> value="7" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/7.jpg" />
                                    </div>
                                    <h2>7. Marcos, Bongbong</h2>
                                    <span class="party">PFP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="pres"  <?php echo (!empty($presidentialCandidate) && $presidentialCandidate == 8) ? 'checked' : ''; ?> value="8" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/8.jpg" />
                                    </div>
                                    <h2 style="text-align:center;">8. Montemayor, Jose Jr.</h2>
                                    <span class="party">DPP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="pres"  <?php echo (!empty($presidentialCandidate) && $presidentialCandidate == 9) ? 'checked' : ''; ?> value="9" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/9.jpg" />
                                    </div>
                                    <h2 style="text-align:center;">9. Pacquiao, Manny Pacman</h2>
                                    <span class="party">PROMDI</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="pres"  <?php echo (!empty($presidentialCandidate) && $presidentialCandidate == 10) ? 'checked' : ''; ?> value="10" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/10.png" />
                                    </div>
                                    <h2>10. Leni Robredo</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>


                    </div>
                    <br>





                </div>

                <!-- Vice President -->

            </div>
            <div class="radio_content radio_2">
                <div class="wrapper2">
                    <h2 style="font-family: sans-serif;">Select only 1 candidate</h2>
                    <div class="radio-buttons">
                        <label class="custom-radio">
                            <input type="radio" name="vpres"  <?php echo (!empty($vicePresidentialCandidate) && $vicePresidentialCandidate == 11) ? 'checked' : ''; ?> value="11" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/1.jpg">
                                    </div>
                                    <h2>1. Atienza, Lito</h2>
                                    <span class=" party">PROMDI</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="vpres"  <?php echo (!empty($vicePresidentialCandidate) && $vicePresidentialCandidate == 12) ? 'checked' : ''; ?> value="12" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/2.jpg">
                                    </div>
                                    <h2>2. Bello, Walden</h2>
                                    <span class=" party">PLM</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="vpres"  <?php echo (!empty($vicePresidentialCandidate) && $vicePresidentialCandidate == 13) ? 'checked' : ''; ?> value="13" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/3.jpg">
                                    </div>
                                    <h2>3. David, Rizalito</h2>
                                    <span class=" party">DPP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="vpres"  <?php echo (!empty($vicePresidentialCandidate) && $vicePresidentialCandidate == 14) ? 'checked' : ''; ?> value="14" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/4.jpg">
                                    </div>
                                    <h2>4. Duterte, Sara</h2>
                                    <span class=" party">LAKAS</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="vpres"  <?php echo (!empty($vicePresidentialCandidate) && $vicePresidentialCandidate == 15) ? 'checked' : ''; ?> value="15" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/5.jpg">
                                    </div>
                                    <h2>5. Lopez, Manny SD</h2>
                                    <span class=" party">WPP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="vpres"  <?php echo (!empty($vicePresidentialCandidate) && $vicePresidentialCandidate == 16) ? 'checked' : ''; ?> value="16" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/6.jpg">
                                    </div>
                                    <h2>6. Ong, Doc Willie</h2>
                                    <span class=" party">AKSYON</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="vpres"  <?php echo (!empty($vicePresidentialCandidate) && $vicePresidentialCandidate == 17) ? 'checked' : ''; ?> value="17" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/7.jpg">
                                    </div>
                                    <h2>7. Pangilinan, Kiko</h2>
                                    <span class=" party">LP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="vpres"  <?php echo (!empty($vicePresidentialCandidate) && $vicePresidentialCandidate == 18) ? 'checked' : ''; ?> value="18" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/8.png">
                                    </div>
                                    <h2>8. Serapio, Carlos</h2>
                                    <span class=" party">KTPNAN</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="vpres"  <?php echo (!empty($vicePresidentialCandidate) && $vicePresidentialCandidate == 19) ? 'checked' : ''; ?> value="19" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/9.jpg">
                                    </div>
                                    <h2>9. Sotto, Vicente Tito</h2>
                                    <span class=" party">NPC</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>

                    </div>

                </div>


            </div>

            <!-- Senators -->
            <div class="radio_content radio_3">
               
                <div class="wrapper2">
                    <h2 style="font-family: sans-serif;">Select only 12 candidates</h2>
                    <div class="radio-buttons">
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('20', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="20" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/1.jpg" />
                                    </div>
                                    <h2>1. Afuang, Abner</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('21', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="21" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/2.jpg" />
                                    </div>
                                    <h2>2. Albani, Ibrahim</h2>
                                    <span class="party">WPP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('22', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="22" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/3.jpg" />
                                    </div>
                                    <h2>3. Arranza, Jesus</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('23', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="23" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/4.jpg" />
                                    </div>
                                    <h2>4. Baguilat, Teddy</h2>
                                    <span class="party">LP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('24', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="24" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/5.jpg" />
                                    </div>
                                    <h2>5. Bailen, Agnes</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('25', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="25" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/6.jpg" />
                                    </div>
                                    <h2>6. Balita, Carl</h2>
                                    <span class="party">AKSYON</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('26', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="26" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/7.jpg" />
                                    </div>
                                    <h2>7. Lutgardo, Barbo</h2>
                                    <span class="party">PDP-Laban</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('27', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="27" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/8.jpg" />
                                    </div>
                                    <h2>8. Bautista, Herbert</h2>
                                    <span class="party">NPC</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('28', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="28" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/9.jpg" />
                                    </div>
                                    <h2>9. Belgica, Greco</h2>
                                    <span class="party">PDDS</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('29', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="29" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/10.jpg" />
                                    </div>
                                    <h2>10. Silvestre, Bello Jr.</h2>
                                    <span class="party">PDP-Laban</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('30', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="30" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/11.jpg" />
                                    </div>
                                    <h2>11. Binay, Jejomar</h2>
                                    <span class="party">UNA</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('31', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="31" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/12.jpg" />
                                    </div>
                                    <h2>12. Cabonegro, Roy</h2>
                                    <span class="party">PLM</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('32', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="32" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/13.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">13. Castriciones, John</h2>
                                    <span class="party">PDP-Laban</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('33', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="33" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/14.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">14. Cayetano, Alan Peter</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('34', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="34" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/15.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">15. Chavez, Melchor</h2>
                                    <span class="party">WPP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('35', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="35" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/16.jpeg" />
                                    </div>
                                    <h2 style="text-align: center;">16. Colmenares, Neri</h2>
                                    <span class="party"> Makabayan</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('36', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="36" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/17.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">17. d'Angelo, David</h2>
                                    <span class="party">PLM</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('37', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="37" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/18.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">18. de Lima, Leila</h2>
                                    <span class="party">LP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('38', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="38" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/19.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">19. del Rosario, Monsour</h2>
                                    <span class="party">Reporma</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('39', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="39" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/20.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">20. Diaz, Fernando</h2>
                                    <span class="party">PPP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('40', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="40" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/21.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">21. Diokno, Chel</h2>
                                    <span class="party">KANP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('41', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="41" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/22.jpeg" />
                                    </div>
                                    <h2 style="text-align: center;">22. Ejercito, JV</h2>
                                    <span class="party">NPC</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('42', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="42" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/23.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">23. Eleazar, Guillermo</h2>
                                    <span class="party">Reporma</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('43', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="43" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/24.jpeg" />
                                    </div>
                                    <h2 style="text-align: center;">24. Ereño, Ernie</h2>
                                    <span class="party">PM</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('44', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="44" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/25.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">25. Escudero, Francis</h2>
                                    <span class="party">NPC</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('45', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="45" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/26.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">26. Espiritu, Luke</h2>
                                    <span class="party">PLM</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('46', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="46" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/27.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">27. Estrada, Jinggoy</h2>
                                    <span class="party">PMP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('47', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="47" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/28.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">28. Falcone, Baldomero</h2>
                                    <span class="party">DPP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('48', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="48" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/29.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">29. Gadon, Larry</h2>
                                    <span class="party">KBL</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('49', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="49" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/30.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">30. Gatchalian, Win</h2>
                                    <span class="party">NPC</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('50', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="50" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/31.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">31. Gordon, Dick</h2>
                                    <span class="party">Bagumbayan</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('51', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="51" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/32.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">32. Gutoc, Samira</h2>
                                    <span class="party">Aksyon</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('52', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="52" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/33.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">33. Honasan, Gregorio</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('53', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="53" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/34.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">34. Hontiveros, Risa</h2>
                                    <span class="party">Akbayan</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('54', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="54" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/35.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">35. Javellana, RJ</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('55', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="55" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/36.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">36. Kiram, Nur-Mahal</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('56', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="56" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/37.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">37. Labog, Elmer</h2>
                                    <span class="party">Makabayan</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('57', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="57" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/38.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">38. Lacson, Alex</h2>
                                    <span class="party">Ang Kapatiran</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('58', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="58" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/39.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">39. Langit, Rey</h2>
                                    <span class="party">PDP-Laban</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('59', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="59" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/40.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">40. Legarda, Loren</h2>
                                    <span class="party">NPC</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('60', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="60" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/41.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">41. Lim, Ariel</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('61', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="61" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/42.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">42. Mallillin, Emily</h2>
                                    <span class="party">PPM</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('62', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="62" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/43.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">43. Marcos, Francis Leo</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('63', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="63" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/44.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">44. Matula, Sonny</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('64', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="64" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/45.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">45. Adam Mindalano, Marieta</h2>
                                    <span class="party">Katipunan</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('65', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="65" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/46.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">46. Olarte, Leo</h2>
                                    <span class="party">Bigkis Pinoy</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('66', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="66" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/47.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">47. Padilla, Minguita</h2>
                                    <span class="party">Reporma</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('67', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="67" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/48.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">48. Padilla, Robin</h2>
                                    <span class="party">PDP-Laban</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('68', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="68" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/49.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">49. Panelo, Salvador</h2>
                                    <span class="party">PDP-Laban</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('69', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="69" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/50.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">50. Naik Pimentel, Astravel</h2>
                                    <span class="party">PDP-Laban</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('70', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="70" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/51.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">51. Piñol, Emmanuel </h2>
                                    <span class="party">NPC</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('71', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="71" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/52.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">52. Jr. Ricablance, Willie</h2>
                                    <span class="party">PM</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('72', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="72" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/53.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">53. Roque, Harry</h2>
                                    <span class="party">PRP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('73', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="73" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/54.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">54. Sahidulla, Nur-Ana</h2>
                                    <span class="party">PDDS</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('74', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="74" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/55.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">55. Sison, Jopet</h2>
                                    <span class="party">Aksyon</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('75', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="75" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/56.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">56. Teodoro, Gilberto</h2>
                                    <span class="party">PRP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('76', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="76" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/57.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">57. Trillanes, Antonio</h2>
                                    <span class="party">LP</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('77', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="77" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/58.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">58. Tulfo, Raffy</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('78', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="78" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/59.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">59. Valeros, Rey</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('79', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="79" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/60.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">60. Villanueva, Joel</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('80', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="80" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/61.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">61. Villar, Mark</h2>
                                    <span class="party">Nacionalista</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('81', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="81" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/62.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">62. Zubiaga, Carmen</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input name="senators[]"   <?php echo (!empty($senatorialCandidates) && in_array('82', $senatorialCandidates)) ? 'checked' : ''; ?> type="checkbox" name="senators[]" value="82" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/63.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">63. Zubiri, Miguel Juan</h2>
                                    <span class="party">IND</span>
                                    <span class="check-icon">
                                        <span class="icon"></span>
                                    </span>
                                </div>
                            </div>
                        </label>
                    </div>
                  

                </div>

            </div>
            <div class="nav_btn">
                <div class="popup" id="popup-1">
                    <div class="overlay"></div>
                    <div class="content">
                        <div class="close-btn" onclick="togglePopup()">&times;</div>
                        <h1>Review Selected Candidates</h1>

                        <table class="selected-candidates">
                            <tr>
                                <th>Position</th>
                                <th>Candidate</th>
                            </tr>
                            <?php
                                if (!empty($votes['pres'])) {
                                    echo "<tr>
                                        <td>President</td>
                                        <td>". $conn->real_escape_string($votes['pres']['lastname'] .", ". $votes['pres']['firstname']) ."</td>
                                    </tr>";
                                }
                                if (!empty($votes['vpres'])) {
                                    echo "<tr>
                                        <td>Vice President</td>
                                        <td>". $conn->real_escape_string($votes['vpres']['lastname'] .", ". $votes['vpres']['firstname']) ."</td>
                                    </tr>";
                                }
                                if (!empty($votes['senators'])) {
                                    foreach ($votes['senators'] as $senator) {
                                        echo "<tr>
                                            <td>Senator</td>
                                            <td>". $conn->real_escape_string($senator['lastname'] .", ". $senator['firstname']) ."</td>
                                        </tr>";
                                    }
                                }
                            ?>
                        </table>
                    </div>
                </div>
                <button name="submitVote" type="submit">Submit</button>
                <button type="reset">Reset</button>
                <button type="submit" name="viewVote">View</button>
                <script type="text/javascript">
                    function resetForm() {
                        $('#votingForm').trigger("reset");
                    }
                    function togglePopup() {
                        document.getElementById("popup-1").classList.toggle("active");
                    }
                </script>
            </div>
        </div>
    </form>


    <!-- dropdown -->
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