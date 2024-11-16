<?php

require "connection.php";

if (isset($_GET["bid"])) {
    $bid = $_GET["bid"];

    if ($bid > '0') {

        $model_rs = Database::search("SELECT * FROM `model` WHERE `brand_id` = '" . $bid . "'");
        $model_num = $model_rs->num_rows;

        if ($model_num > 0) {

?>

            <option value="0">Select Model</option>

            <?php

            for ($x = 0; $x < $model_num; $x++) {

                $model_data = $model_rs->fetch_assoc();

            ?>

                <option value="<?php echo ($model_data["id"]); ?>"><?php echo ($model_data["model_name"]); ?></option>

            <?php

            }
        } else {
            ?>

            <option value="0">None</option>

        <?php
        }
    } else {
        ?>

        <option value="0">Select brand first</option>

<?php
    }
}else{
    echo("1");
}

?>