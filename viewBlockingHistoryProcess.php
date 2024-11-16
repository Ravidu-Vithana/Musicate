<?php

require "connection.php";

if (isset($_GET["email"])) {

    $email = $_GET["email"];

    $results = Database::search("SELECT * FROM `user_blocking_history` WHERE `user_email` = '$email' ORDER BY `date_time` DESC");
    $user = Database::search("SELECT * FROM `user` WHERE `email` = '$email'");

    if ($user->num_rows == 1) {

        $userData = $user->fetch_assoc();

?>

        <span class="text-black-50">Name : </span>
        <span><?php echo ($userData["fname"] . " " . $userData["lname"]); ?></span><br />
        <span class="text-black-50">Email : </span>
        <span><?php echo ($email); ?></span><br />

        <?php

        if ($results->num_rows == 0) {

        ?>

            <div class="row d-flex flex-row justify-content-evenly">
                <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 30rem;">
                <span class="notBlockedBefore text-center">Seems like this User haven't been blocked before!</span>
            </div>

            <?php

        } else {

            for ($x = 0; $x < $results->num_rows; $x++) {
                $resultsData = $results->fetch_assoc();

                $admin = Database::search("SELECT * FROM `admin` WHERE `email` = '" . $resultsData["admin_email"] . "'");

                $dateTime = explode(" ", $resultsData["date_time"]);

            ?>
                <div class="border border-secondary border-2 border-opacity-25 rounded-3 p-2 mt-2">
                    <span class="text-black-50 fw-bold">Date : </span>
                    <span><?php echo ($dateTime[0]); ?></span><br>
                    <span class="text-black-50 fw-bold">Time : </span>
                    <span><?php echo ($dateTime[1]); ?></span><br>
                    <span class="text-black-50 fw-bold">Reason : </span>
                    <span><?php echo ($resultsData["description"]); ?></span><br>

                    <?php

                    if ($admin->num_rows == 1) {

                        $adminData = $admin->fetch_assoc();

                    ?>

                        <span class="text-black-50 fw-bold">Deactivated by : </span>
                        <span><?php echo ($adminData["fname"] . " " . $adminData["lname"]); ?></span><br/>
                        <span>(<?php echo ($adminData["email"]); ?>)</span>

                    <?php
                    }

                    ?>

                </div>
<?php
            }
        }
    } else {
        echo ("1");
    }
} else {
    echo ("1");
}

?>