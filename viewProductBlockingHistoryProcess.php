<?php

require "connection.php";

if (isset($_GET["product_id"])) {

    $product_id = $_GET["product_id"];

    $results = Database::search("SELECT * FROM `product_deactivation_history` WHERE `product_id` = '$product_id' ORDER BY `date_time` DESC");
    $product = Database::search("SELECT * FROM `product` WHERE `id` = '$product_id'");

    if ($product->num_rows == 1) {

        $product_data = $product->fetch_assoc();

?>

        <span class="text-black-50">Product ID : </span>
        <span><?php echo ($product_data["id"]); ?></span><br />
        <span class="text-black-50">Title : </span>
        <span><?php echo ($product_data["title"]); ?></span><br />

        <?php

        if ($results->num_rows == 0) {

        ?>

            <div class="row d-flex flex-row justify-content-evenly">
                <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 30rem;">
                <span class="notBlockedBefore text-center">Seems like this Product haven't been deactivated before!</span>
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