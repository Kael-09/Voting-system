<?php 

include 'config.php';

session_start();

error_reporting(0);

if (!isset($_SESSION['loggedInUser'])) {
    header("Location: index.php");
}

?>
<?php
    


    session_start();
    $user = $_SESSION['loggedInUser'];
    $links = array(
        'stat' => array(
            'label' => 'Statistics',
            'href' => 'statistics.php',
            'showWhenVoted' => true
        ),
        'vote' => array(
            'label' => 'Vote',
            'href' => 'vote.php',
            'showWhenVoted' => false
        ),
        'prof' => array(
            'label' => 'Profile',
            'href' => 'profile.php',
            'showWhenVoted' => true
        ),
    )

?>
<div class="nav_container">
    <nav>
        <div class="logo"><img src="img/logo2.png" width="35" height="46" alt=""></div>
        <ul>
            <?php
                foreach ($links as $class => $link) {
                    if (!$link['showWhenVoted'] && $user['voted']) {
                        continue;
                    }

                    $className = ((!empty($section)) && ($section == $class))
                        ? $class : '';
                    $href = $link['href'];
                    $label = $link['label'];
                    echo "<li>
                        <a id=\"\" class=\"$className\" style=\"user-select: none;\" href=\"$href\">
                            $label
                        </a>
                    </li>";
                }
            ?>
            <li><a id="" class="" style="user-select: none;" href="logout.php">Logout</a></li>

        </ul>
    </nav>
</div>