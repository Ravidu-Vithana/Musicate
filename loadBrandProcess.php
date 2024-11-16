<?php

require "connection.php";

if (isset($_GET["scid"])) {

    $scid = $_GET["scid"];

    if ($scid > '0') {

        $brand_has_category_rs = Database::search("SELECT * FROM `brand_has_category` WHERE `sub_categories_id` = '" . $scid . "'");
        $brand_has_category_num = $brand_has_category_rs->num_rows;

        if ($brand_has_category_num > 0) {

?>

            <option value="0">Select Brand</option>

            <?php

            for ($x = 0; $x < $brand_has_category_num; $x++) {
                $brand_has_category_data = $brand_has_category_rs->fetch_assoc();
                $brand_id = $brand_has_category_data["brand_id"];

                $brand_rs = Database::search("SELECT * FROM `brand` WHERE `id` = '" . $brand_id . "'");
                $brand_data = $brand_rs->fetch_assoc();

            ?>

                <option value="<?php echo ($brand_data["id"]); ?>"><?php echo ($brand_data["brand_name"]); ?></option>

            <?php

            }
        } else {
            ?>

            <option value="0">None</option>

        <?php
        }
    } else {

        ?>

        <option value="0">Select category first</option>

<?php

    }
} else {
    echo ("1");
}

?>