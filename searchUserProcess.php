<?php

require "connection.php";

if (isset($_GET["input"])) {

    $input = $_GET["input"];

    $results = Database::search("SELECT * FROM `user` 
    INNER JOIN `gender` ON `user`.`gender_id` = `gender`.`id` 
    WHERE `fname` LIKE '%" . $input . "%' OR `lname` LIKE '%" . $input . "%' OR `email` LIKE '%" . $input . "%'");
    $results_num = $results->num_rows;

    if ($results_num == 0) {
?>

        <div class="col-12 my-2">
            <div class="row d-flex flex-row justify-content-evenly">
                <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 40rem;">
                <span class="noresultsText text-center">No Results Found. Try another way.</span>
            </div>
        </div>

        <?php
    } else {

        for ($x = 0; $x < $results_num; $x++) {
            $results_data = $results->fetch_assoc();

            $joined_date = new DateTime($results_data["joined_date"]);

            $date = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $date->setTimezone($tz);

            $today = new DateTime($date->format("Y-m-d H:i:s"));
            $difference = $today->diff($joined_date);


        ?>

            <!-- user card -->
                <div class="card my-3" style="max-width: 50rem;">
                    <div class="row g-0 ps-2">
                        <div class="col-md-4 d-flex flex-column align-items-center justify-content-center">
                            <?php

                            $image_rs = Database::search("SELECT * FROM `profile_images` WHERE `user_email` = '" . $results_data["email"] . "'");
                            if ($image_rs->num_rows == 1) {
                                $image_data = $image_rs->fetch_assoc();
                            ?>

                                <img src="<?php echo ($image_data["path"]); ?>" style="max-height: 10rem; max-width: 10rem;" class="img-fluid rounded" id="userImg<?php echo ($results_data['email']); ?>" alt="..." onerror="userImageError('userImg<?php echo ($results_data['email']); ?>','<?php echo ($results_data['gender_name']); ?>');">

                            <?php
                            } else {
                            ?>

                                <img src="resources/<?php echo ($results_data["gender_name"] == "Male" ? "userMale.jpg" : "userFemale.png"); ?>" style="max-height: 10rem; max-width: 10rem;" class="img-fluid rounded" alt="...">

                            <?php
                            }

                            ?>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo ($results_data["fname"] . " " . $results_data["lname"]) ?></h5>
                                <span class="text-black-50 fw-bold">User Email : </span><br />
                                <span><?php echo ($results_data["email"]) ?></span><br />
                                <span class="text-black-50 fw-bold">Current Active Time : </span>
                                <p>
                                    <?php

                                    echo ($difference->format('%Y') . " Years " . $difference->format('%m') . " Months " .
                                        $difference->format('%d') . " Days " . $difference->format('%H') . " Hours " .
                                        $difference->format('%i') . " Minutes ");

                                    ?>
                                </p>
                                <span id="blockText" class="fw-bold text-<?php echo ($results_data["status"] == 1 ? "success" : "danger"); ?>">User is <?php echo ($results_data["status"] == 1 ? "Active" : "Blocked"); ?></span><br />
                                <button id="blockBtn" class="mt-2 btn btn-outline-<?php echo ($results_data["status"] == 1 ? "danger" : "success"); ?>" onclick="userBlockStatus('<?php echo ($results_data['email']); ?>');"><?php echo ($results_data["status"] == 1 ? "Block" : "Unblock"); ?></button>
                                <button class="mt-2 btn btn-outline-warning" onclick="viewBlockingHistory('<?php echo ($results_data['email']); ?>');">View Blocking History</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- user card -->

<?php

        }
    }
} else {
    echo ("1");
}

?>