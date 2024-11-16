<?php

require "connection.php";

if (isset($_GET["category_id"])) {

    $categories = $_GET["category_id"];

    if ($categories == 0) {

?>

        <div class="d-flex flex-row mb-1 selectedDiv" style="width: auto; height: auto;">
            <span class="my-auto mx-auto">All Categories</span>
        </div>

        <?php

    } else {


        $category = explode(",", $categories);
        $category_amt = sizeof($category);

        for ($x = 1; $x < $category_amt; $x++) {
            $category_rs = Database::search("SELECT * FROM `category` WHERE `id` = '" . $category[$x] . "'");
            $category_data = $category_rs->fetch_assoc();

        ?>

            <div class="d-flex flex-row mb-1 selectedDiv" style="width: auto; height: auto;">
                <span class="my-auto mx-auto"><?php echo ($category_data["category_name"]); ?></span>
            </div>

<?php

        }
    }
} else {
    echo ("1");
}

?>