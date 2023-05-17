
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/statistics.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Statistics</title>
    

</head>

<body>

    <!-- nav bar -->
    <?php
 $section = 'stat';
        include 'config.php';

        
        // require_once 'auth_check';
        include 'sections/header.php';
       

        $totalUsers = mysqli_query($conn, "SELECT * FROM users")->num_rows;
        $totalVotes = mysqli_query($conn, "SELECT * FROM users WHERE voted = 1")->num_rows;

        $result = $conn->query("SELECT * FROM candidate_votes");
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $candidateVotes = array();
        foreach ($rows as $row) {
            $candidateVotes[$row['candidate_id']] = (int)$row['count'];
        }

        $rankedResult = $conn->query("SELECT c.*, v.count FROM `candidate_votes` v INNER JOIN `candidates` c ON c.id = v.candidate_id ORDER BY v.count DESC, c.id ASC");
        $rankedRows = $rankedResult->fetch_all(MYSQLI_ASSOC);
        $rankedVotes = array(
            'pres' => array(),
            'vpres' => array(),
            'senators' => array()
        );

        foreach ($rankedRows as $rankedRow) {
            switch ($rankedRow['position_id']) {
                case 1:
                    $rankedVotes['pres'][] = $rankedRow;
                    break;
                case 2:
                    $rankedVotes['vpres'][] = $rankedRow;
                    break;
                case 3:
                    if (count($rankedVotes['senators']) < 15) {
                        $rankedVotes['senators'][] = $rankedRow;
                    }
                    break;
            }
        }
    ?>
    <!-- nav -->

    <!-- statistics -->
    <div class="wrapper">
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
            <label class="radio_wrap"  data-radio="radio_1">
                <input type="radio" name="candidates" class="input" checked>
                <span class="radio_mark">
                    President
                </span>
            </label>
            <label class="radio_wrap" data-radio="radio_2">
                <input type="radio"   name="candidates" class="input">
                <span class="radio_mark" >
                    Vice President
                </span>
            </label>
            <label class="radio_wrap" data-radio="radio_3">
                <input  type="radio"  name="candidates" class="input">
                <span class="radio_mark">
                    Senators
                </span>
            </label>
            <label class="radio_wrap" data-radio="radio_4">
                <input type="radio"   name="candidates" class="input">
                <span class="radio_mark">
                    Voters
                </span>
            </label>
            <label class="radio_wrap" data-radio="radio_5">
                <input type="radio"   name="candidates" class="input">
                <span class="radio_mark">
                    Rankings
                </span>
            </label>
        </div>
        <div class="content">
            <div class="radio_content radio_1">
                <!-- Prsident -->
                <div class="wrapper2">
                    <h2 style="font-family: sans-serif;">Distributed Vote Count</h2>
                    <div class="radio-buttons">
                        <label class="custom-radio">
                            <input type="none" name="pres" >
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/abella.png" />
                                    </div>
                                    <h2>1. Abella, Ernie</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[1]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                            echo ($candidateVotes[1] > 0)
                                                ? round((($candidateVotes[1]/$totalVotes) * 100))
                                                : 0
                                        ?>%
                                    </span>
                                    
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input  name="pres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/2.jpg" />
                                    </div>
                                    <h2>2. De Guzman, Leody</h2>
                                    <span class="party">PLM</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[2]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[2] > 0)
                                            ? round((($candidateVotes[2]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input  name="pres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/3.png" />
                                    </div>
                                    <h2 style="text-align:center;">3. Domagoso, Isko Moreno</h2>
                                    <span class="party">AKSYON</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[3]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[3] > 0)
                                            ? round((($candidateVotes[3]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input  name="pres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/4.png" />
                                    </div>
                                    <h2 style="text-align:center;">4. Gonzales, Norberto</h2>
                                    <span class="party">PDSP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[4]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[4] > 0)
                                            ? round((($candidateVotes[4]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input  name="pres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/5.jpg" />
                                    </div>
                                    <h2>5. Lacson, Ping</h2>
                                    <span class="party">PDR</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[5]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[5] > 0)
                                            ? round((($candidateVotes[5]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input  name="pres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/6.jpg" />
                                    </div>
                                    <h2 style="text-align:center;">6. Mangondato, Faisal</h2>
                                    <span class="party">KTPNAN</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[6]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[6] > 0)
                                            ? round((($candidateVotes[6]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input  name="pres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/7.jpg" />
                                    </div>
                                    <h2>7. Marcos, Bongbong</h2>
                                    <span class="party">PFP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[7]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[7] > 0)
                                            ? round((($candidateVotes[7]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input  name="pres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/8.jpg" />
                                    </div>
                                    <h2 style="text-align:center;">8. Montemayor, Jose Jr.</h2>
                                    <span class="party">DPP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[8]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[8] > 0)
                                            ? round((($candidateVotes[8]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input  name="pres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/9.jpg" />
                                    </div>
                                    <h2 style="text-align:center;">9. Pacquiao, Manny Pacman</h2>
                                    <span class="party">PROMDI</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[9]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[9] > 0)
                                            ? round((($candidateVotes[9]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input  name="pres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/president/10.png" />
                                    </div>
                                    <h2>10. Leni Robredo</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[10]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[10] > 0)
                                            ? round((($candidateVotes[10]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>

                    </div>
                    <br>
                </div>
            </div>
            <!-- vpresident -->
            <div class="radio_content radio_2">
                <div class="wrapper2">
                    <h2 style="font-family: sans-serif;">Distributed Vote Count</h2>
                    <div class="radio-buttons">
                        <label class="custom-radio">
                            <input  name="vpres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/1.jpg">
                                    </div>
                                    <h2>1. Atienza, Lito</h2>
                                    <span class=" party">PROMDI</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[11]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[11] > 0)
                                            ? round((($candidateVotes[11]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                            
                        </label>
                        <label class="custom-radio">
                            <input  name="vpres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/2.jpg">
                                    </div>
                                    <h2>2. Bello, Walden</h2>
                                    <span class=" party">PLM</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[12]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[12] > 0)
                                            ? round((($candidateVotes[12]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input  name="vpres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/3.jpg">
                                    </div>
                                    <h2>3. David, Rizalito</h2>
                                    <span class=" party">DPP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[13]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[13] > 0)
                                            ? round((($candidateVotes[13]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input  name="vpres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/4.jpg">
                                    </div>
                                    <h2>4. Duterte, Sara</h2>
                                    <span class=" party">LAKAS</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[14]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[14] > 0)
                                            ? round((($candidateVotes[14]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input  name="vpres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/5.jpg">
                                    </div>
                                    <h2>5. Lopez, Manny SD</h2>
                                    <span class=" party">WPP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[15]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[15] > 0)
                                            ? round((($candidateVotes[15]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input  name="vpres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/6.jpg">
                                    </div>
                                    <h2>6. Ong, Doc Willie</h2>
                                    <span class=" party">AKSYON</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[16]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[16] > 0)
                                            ? round((($candidateVotes[16]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input  name="vpres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/7.jpg">
                                    </div>
                                    <h2>7. Pangilinan, Kiko</h2>
                                    <span class=" party">LP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[17]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[17] > 0)
                                            ? round((($candidateVotes[17]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input  name="vpres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/8.png">
                                    </div>
                                    <h2>8. Serapio, Carlos</h2>
                                    <span class=" party">KTPNAN</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[18]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[18] > 0)
                                            ? round((($candidateVotes[18]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input  name="vpres" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/vicepresident/9.jpg">
                                    </div>
                                    <h2>9. Sotto, Vicente Tito</h2>
                                    <span class=" party">NPC</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[19]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[19] > 0)
                                            ? round((($candidateVotes[19]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>

                    </div>
                </div>
            </div>
            <!-- senators -->
            <div class="radio_content radio_3">
                <div class="wrapper2">
                    <h2 style="font-family: sans-serif;">Distributed Vote Count</h2>
                    <div class="radio-buttons">
                    <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/1.jpg" />
                                    </div>
                                    <h2>1. Afuang, Abner</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[20]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[20] > 0)
                                            ? round((($candidateVotes[20]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/2.jpg" />
                                    </div>
                                    <h2>2. Albani, Ibrahim</h2>
                                    <span class="party">WPP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[21]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[21] > 0)
                                            ? round((($candidateVotes[21]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/3.jpg" />
                                    </div>
                                    <h2>3. Arranza, Jesus</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[22]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[22] > 0)
                                            ? round((($candidateVotes[22]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/4.jpg" />
                                    </div>
                                    <h2>4. Baguilat, Teddy</h2>
                                    <span class="party">LP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[23]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[23] > 0)
                                            ? round((($candidateVotes[23]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/5.jpg" />
                                    </div>
                                    <h2>5. Bailen, Agnes</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[24]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[24] > 0)
                                            ? round((($candidateVotes[24]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/6.jpg" />
                                    </div>
                                    <h2>6. Balita, Carl</h2>
                                    <span class="party">AKSYON</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[25]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[25] > 0)
                                            ? round((($candidateVotes[25]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/7.jpg" />
                                    </div>
                                    <h2>7. Lutgardo, Barbo</h2>
                                    <span class="party">PDP-Laban</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[26]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[26] > 0)
                                            ? round((($candidateVotes[26]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/8.jpg" />
                                    </div>
                                    <h2>8. Bautista, Herbert</h2>
                                    <span class="party">NPC</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[27]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[27] > 0)
                                            ? round((($candidateVotes[27]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/9.jpg" />
                                    </div>
                                    <h2>9. Belgica, Greco</h2>
                                    <span class="party">PDDS</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[28]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[28] > 0)
                                            ? round((($candidateVotes[28]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/10.jpg" />
                                    </div>
                                    <h2>10. Silvestre, Bello Jr.</h2>
                                    <span class="party">PDP-Laban</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[29]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[29] > 0)
                                            ? round((($candidateVotes[29]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/11.jpg" />
                                    </div>
                                    <h2>11. Binay, Jejomar</h2>
                                    <span class="party">UNA</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[30]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[30] > 0)
                                            ? round((($candidateVotes[30]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/12.jpg" />
                                    </div>
                                    <h2>12. Cabonegro, Roy</h2>
                                    <span class="party">PLM</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[31]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[31] > 0)
                                            ? round((($candidateVotes[31]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/13.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">13. Castriciones, John</h2>
                                    <span class="party">PDP-Laban</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[32]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[32] > 0)
                                            ? round((($candidateVotes[32]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/14.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">14. Cayetano, Alan Peter</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[33]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[33] > 0)
                                            ? round((($candidateVotes[33]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/15.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">15. Chavez, Melchor</h2>
                                    <span class="party">WPP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[34]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[34] > 0)
                                            ? round((($candidateVotes[34]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/16.jpeg" />
                                    </div>
                                    <h2 style="text-align: center;">16. Colmenares, Neri</h2>
                                    <span class="party"> Makabayan</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[35]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[35] > 0)
                                            ? round((($candidateVotes[35]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/17.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">17. d'Angelo, David</h2>
                                    <span class="party">PLM</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[36]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[36] > 0)
                                            ? round((($candidateVotes[36]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/18.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">18. de Lima, Leila</h2>
                                    <span class="party">LP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[37]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[37] > 0)
                                            ? round((($candidateVotes[37]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/19.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">19. del Rosario, Monsour</h2>
                                    <span class="party">Reporma</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[38]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[38] > 0)
                                            ? round((($candidateVotes[38]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/20.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">20. Diaz, Fernando</h2>
                                    <span class="party">PPP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[39]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[39] > 0)
                                            ? round((($candidateVotes[39]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/21.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">21. Diokno, Chel</h2>
                                    <span class="party">KANP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[40]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[40] > 0)
                                            ? round((($candidateVotes[40]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/22.jpeg" />
                                    </div>
                                    <h2 style="text-align: center;">22. Ejercito, JV</h2>
                                    <span class="party">NPC</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[41]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[41] > 0)
                                            ? round((($candidateVotes[41]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/23.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">23. Eleazar, Guillermo</h2>
                                    <span class="party">Reporma</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[42]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[42] > 0)
                                            ? round((($candidateVotes[42]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/24.jpeg" />
                                    </div>
                                    <h2 style="text-align: center;">24. Ereño, Ernie</h2>
                                    <span class="party">PM</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[43]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[43] > 0)
                                            ? round((($candidateVotes[43]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/25.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">25. Escudero, Francis</h2>
                                    <span class="party">NPC</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[44]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[44] > 0)
                                            ? round((($candidateVotes[44]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/26.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">26. Espiritu, Luke</h2>
                                    <span class="party">PLM</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[46]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[45] > 0)
                                            ? round((($candidateVotes[45]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/27.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">27. Estrada, Jinggoy</h2>
                                    <span class="party">PMP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[46]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[46] > 0)
                                            ? round((($candidateVotes[46]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/28.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">28. Falcone, Baldomero</h2>
                                    <span class="party">DPP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[47]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[47] > 0)
                                            ? round((($candidateVotes[47]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/29.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">29. Gadon, Larry</h2>
                                    <span class="party">KBL</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[48]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[48] > 0)
                                            ? round((($candidateVotes[48]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/30.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">30. Gatchalian, Win</h2>
                                    <span class="party">NPC</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[49]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[49] > 0)
                                            ? round((($candidateVotes[49]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/31.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">31. Gordon, Dick</h2>
                                    <span class="party">Bagumbayan</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[50]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[50] > 0)
                                            ? round((($candidateVotes[50]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/32.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">32. Gutoc, Samira</h2>
                                    <span class="party">Aksyon</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[51]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[51] > 0)
                                            ? round((($candidateVotes[51]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/33.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">33. Honasan, Gregorio</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[52]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[52] > 0)
                                            ? round((($candidateVotes[52]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/34.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">34. Hontiveros, Risa</h2>
                                    <span class="party">Akbayan</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[53]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[53] > 0)
                                            ? round((($candidateVotes[53]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/35.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">35. Javellana, RJ</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[54]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[54] > 0)
                                            ? round((($candidateVotes[54]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/36.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">36. Kiram, Nur-Mahal</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[55]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[55] > 0)
                                            ? round((($candidateVotes[55]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/37.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">37. Labog, Elmer</h2>
                                    <span class="party">Makabayan</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[56]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[56] > 0)
                                            ? round((($candidateVotes[56]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/38.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">38. Lacson, Alex</h2>
                                    <span class="party">Ang Kapatiran</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[57]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[57] > 0)
                                            ? round((($candidateVotes[57]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/39.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">39. Langit, Rey</h2>
                                    <span class="party">PDP-Laban</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[58]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[58] > 0)
                                            ? round((($candidateVotes[58]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/40.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">40. Legarda, Loren</h2>
                                    <span class="party">NPC</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[59]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[59] > 0)
                                            ? round((($candidateVotes[59]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/41.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">41. Lim, Ariel</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[60]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[60] > 0)
                                            ? round((($candidateVotes[60]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/42.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">42. Mallillin, Emily</h2>
                                    <span class="party">PPM</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[61]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[61] > 0)
                                            ? round((($candidateVotes[61]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/43.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">43. Marcos, Francis Leo</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[62]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[62] > 0)
                                            ? round((($candidateVotes[62]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/44.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">44. Matula, Sonny</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[63]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[63] > 0)
                                            ? round((($candidateVotes[63]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/45.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">45. Adam Mindalano, Marieta</h2>
                                    <span class="party">Katipunan</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[64]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[64] > 0)
                                            ? round((($candidateVotes[64]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/46.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">46. Olarte, Leo</h2>
                                    <span class="party">Bigkis Pinoy</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[65]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[65] > 0)
                                            ? round((($candidateVotes[65]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/47.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">47. Padilla, Minguita</h2>
                                    <span class="party">Reporma</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[66]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[66] > 0)
                                            ? round((($candidateVotes[66]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/48.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">48. Padilla, Robin</h2>
                                    <span class="party">PDP-Laban</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[67]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[67] > 0)
                                            ? round((($candidateVotes[67]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/49.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">49. Panelo, Salvador</h2>
                                    <span class="party">PDP-Laban</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[68]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[68] > 0)
                                            ? round((($candidateVotes[68]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/50.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">50. Naik Pimentel, Astravel</h2>
                                    <span class="party">PDP-Laban</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[69]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[69] > 0)
                                            ? round((($candidateVotes[69]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/51.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">51. Piñol, Emmanuel </h2>
                                    <span class="party">NPC</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[70]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[70] > 0)
                                            ? round((($candidateVotes[70]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/52.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">52. Jr. Ricablance, Willie</h2>
                                    <span class="party">PM</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[71]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[71] > 0)
                                            ? round((($candidateVotes[71]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/53.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">53. Roque, Harry</h2>
                                    <span class="party">PRP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[72]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[72] > 0)
                                            ? round((($candidateVotes[72]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/54.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">54. Sahidulla, Nur-Ana</h2>
                                    <span class="party">PDDS</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[73]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[73] > 0)
                                            ? round((($candidateVotes[73]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/55.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">55. Sison, Jopet</h2>
                                    <span class="party">Aksyon</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[74]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[74] > 0)
                                            ? round((($candidateVotes[74]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/56.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">56. Teodoro, Gilberto</h2>
                                    <span class="party">PRP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[75]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[75] > 0)
                                            ? round((($candidateVotes[75]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/57.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">57. Trillanes, Antonio</h2>
                                    <span class="party">LP</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[76]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[76] > 0)
                                            ? round((($candidateVotes[76]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/58.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">58. Tulfo, Raffy</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[77]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[77] > 0)
                                            ? round((($candidateVotes[77]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/59.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">59. Valeros, Rey</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[78]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[78] > 0)
                                            ? round((($candidateVotes[78]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/60.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">60. Villanueva, Joel</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[79]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[79] > 0)
                                            ? round((($candidateVotes[79]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/61.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">61. Villar, Mark</h2>
                                    <span class="party">Nacionalista</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[80]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[80] > 0)
                                            ? round((($candidateVotes[80]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/62.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">62. Zubiaga, Carmen</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[81]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[81] > 0)
                                            ? round((($candidateVotes[81]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn">
                                <div class="content1">
                                    <div class="profile-img">
                                        <img src="assets/senators/63.jpg" />
                                    </div>
                                    <h2 style="text-align: center;">63. Zubiri, Miguel Juan</h2>
                                    <span class="party">IND</span>
                                    <span class="num" style="<?php echo ($user['usertype'] != 'official') ? 'display: none': '' ?>">
                                        <?php echo number_format($candidateVotes[82]); ?>
                                    </span>
                                    <span class="num" style="<?php echo ($user['usertype'] == 'official') ? 'display: none': '' ?>">
                                        <?php
                                        echo ($candidateVotes[82] > 0)
                                            ? round((($candidateVotes[82]/$totalVotes) * 100))
                                            : 0
                                        ?>%
                                    </span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="radio_content radio_4">
                <div class="wrapper2">
                    <h2 style="font-family: sans-serif;">Voters Count</h2>
                    <div class="radio-buttons ">
                        <label class="custom-radio">
                            <input class="senators"  name="senators" />
                            <div class="radio-btn voter_num">
                                <div class="content1" style="<?php echo ($user['usertype'] == 'official') ? 'display: none' : ''; ?>">
                                    
                                    <h2 style="padding-top: 80px; font-size:70px;">
                                        <?php echo round((($totalVotes/$totalUsers) * 100)); ?>%
                                    </h2>
                                    <span class="party">Voters</span>
                                    
                                </div>

                                <div class="content1" style="<?php echo ($user['usertype'] != 'official') ? 'display: none' : ''; ?>">

                                    <h2 style="padding-top: 80px; font-size:70px;">
                                        <?php echo $totalVotes; ?>
                                    </h2>
                                    <span class="party">Users Voted</span>

                                </div>
                            </div>


                            <div class="radio-btn voter_num"  style="<?php echo ($user['usertype'] != 'official') ? 'display: none' : ''; ?>">
                                <div class="content1">

                                    <h2 style="padding-top: 80px; font-size:70px;">
                                        <?php echo $totalUsers; ?>
                                    </h2>
                                    <span class="party">Users Registered</span>

                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="radio_content radio_5">
                <div class="wrapper2">
               
                    <h2 style="font-family: sans-serif;">Rankings</h2>


                    <h3 style="font-family: sans-serif;">Presidential Rankings</h3>
                    <table class="candidate-rankings" style="font-family: sans-serif; ">
                        <tr>
                            <th>Candidate</th>
                            <th>Votes</th>
                        </tr>
                        <?php
                            foreach ($rankedVotes['pres'] as $presRankedVote) {
                                echo "<tr  >
                                    <td>". $conn->real_escape_string($presRankedVote['lastname'] .", ". $presRankedVote['firstname']) ."</td>
                                    <td>". number_format($presRankedVote['count']) ."</td>
                                </tr>";
                            }
                        ?>
                    </table>


                    <h3 style="font-family: sans-serif;">Vice-Presidential Rankings</h3>
                    <table class="candidate-rankings" style="font-family: sans-serif;">
                        <tr>
                            <th >Candidate</th>
                            <th>Votes</th>
                        </tr>
                        <?php
                        foreach ($rankedVotes['vpres'] as $vpresRankedVote) {
                            echo "<tr>
                                    <td>". $conn->real_escape_string($vpresRankedVote['lastname'] .", ". $vpresRankedVote['firstname']) ."</td>
                                    <td>". number_format($vpresRankedVote['count']) ."</td>
                                </tr>";
                        }
                        ?>
                    </table>

                    <h3 style="font-family: sans-serif;">Senatorial Rankings</h3>
                    <table class="candidate-rankings" style="font-family: sans-serif;">
                        <tr>
                            <th>Candidate</th>
                            <th>Votes</th>
                        </tr>
                        <?php
                        foreach ($rankedVotes['senators'] as $senatorRankedVote) {
                            echo "<tr>
                                    <td>". $conn->real_escape_string($senatorRankedVote['lastname'] .", ". $senatorRankedVote['firstname']) ."</td>
                                    <td>". number_format($senatorRankedVote['count']) ."</td>
                                </tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        

    </div>

    <!-- statistics -->
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