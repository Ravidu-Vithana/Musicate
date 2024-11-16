<?php

require "connection.php";

if (isset($_GET["cid"])) {
    $cid = $_GET["cid"];

    if ($cid > 0) {

        $subcategory_rs = Database::search("SELECT * FROM `sub_categories` WHERE `category_id` = '" . $cid . "'");
        $subcategory_num = $subcategory_rs->num_rows;

        if ($subcategory_num > 0) {

?>

            <option value="0">Select sub-category</option>

            <?php

            for ($x = 0; $x < $subcategory_num; $x++) {

                $subcategory_data = $subcategory_rs->fetch_assoc();

            ?>

                <option value="<?php echo ($subcategory_data["id"]); ?>"><?php echo ($subcategory_data["sub_name"]); ?></option>

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