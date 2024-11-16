<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Pacifico&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="./css/main.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">


</head>

<body>

    <div class="row text-grayM">
        <div class="col-12 p-0">
            <div class="w-100 d-flex justify-content-between justify-content-sm-end gap-5 bg-grayM text-secondaryM px-5 py-2">
                <span class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-redM me-1" style="height: 1rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                    </svg>
                    Support Anytime +94761231234
                </span>

                <?php

                if (isset($_SESSION["user"])) {
                ?>

                    <span class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-redM me-1" style="height: 1rem;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <?php echo ($_SESSION["user"]["fname"]); ?>
                    </span>

                <?php
                } else {

                ?>

                    <a class="d-flex align-items-center text-secondaryM" href="signin.php">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-redM me-1" style="height: 1rem;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Login
                    </a>

                <?php

                }

                ?>

            </div>
            <div class="w-100 d-flex align-items-center justify-content-between justify-content-lg-center p-1 headerImgDiv px-4 px-sm-5">
                <img src="./resources/logo.png" class="h-100" style=" object-fit: contain;" alt="">
                <div class=" d-flex align-items-center gap-2 d-lg-none gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-redM" style="height: 1.7rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-redM" style="height: 1.7rem;" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </div>
            </div>
            <div class="w-100 border-top border-bottom border-redM border-opacity-25 border-2 p-3 d-none d-lg-flex justify-content-center gap-5">
                <a class="d-flex align-items-center text-grayM text-decoration-none" href="index.php">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-redM me-2" style="height: 1.5rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Home
                </a>
                <a class="d-flex align-items-center text-grayM text-decoration-none" href="cart.php">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-redM me-2" style="height: 1.5rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    Cart
                </a>
                <a class="d-flex align-items-center text-grayM text-decoration-none" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-redM me-2" style="height: 1.5rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                    Track My Order
                </a>

                <?php

                if (isset($_SESSION["user"])) {
                ?>

                    <a class="dropdown-toggle text-danger" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        More
                    </a>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person-lines-fill text-redM me-2"></i> My Profile</a></li>
                        <li><a class="dropdown-item" href="wishlist.php"><i class="bi bi-suit-heart-fill text-redM me-2"></i> Wishlist</a></li>
                        <li><a class="dropdown-item" href="purchasedHistory.php"><i class="bi bi-clock-history text-redM me-2"></i> Purchased History</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-chat-left-dots text-redM me-2"></i> Contact Admin</a></li>
                        <li>
                            <hr class="dropdown-divider border-secondary">
                        </li>
                        <li><button class="dropdown-item btn" onclick="signOut();"><i class="bi bi-box-arrow-right text-redM me-2"></i> Sign Out</button></li>
                    </ul>

                <?php
                }
                ?>

            </div>
            <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="row p-4">
                        <a class="d-flex align-items-center text-white text-decoration-none" href="index.php">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-redM me-1" style="height: 1.5rem;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Home
                        </a>
                    </div>
                    <div class="row p-4 border-top border-white border-1 border-opacity-10">
                        <a class="d-flex align-items-center text-white text-decoration-none" href="cart.php">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-redM me-1" style="height: 1.5rem;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                            Cart
                        </a>
                    </div>
                    <div class="row p-4 border-top border-white border-1 border-opacity-10">
                        <a class="d-flex align-items-center text-white text-decoration-none" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-redM me-1" style="height: 1.5rem;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>
                            Track My Order
                        </a>
                    </div>
                    <?php

                    if (isset($_SESSION["user"])) {
                    ?>
                        <div class="row border-top border-white border-1 border-opacity-10 py-4">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            More
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <a class="dropdown-item border-bottom border-white border-1 border-opacity-10 py-2" href="profile.php"><i class="bi bi-person-lines-fill text-redM me-2"></i> My Profile</a>
                                            <a class="dropdown-item border-bottom border-white border-1 border-opacity-10 py-2" href="wishlist.php"><i class="bi bi-suit-heart-fill text-redM me-2"></i> Wishlist</a>
                                            <a class="dropdown-item border-bottom border-white border-1 border-opacity-10 py-2" href="purchasedHistory.php"><i class="bi bi-clock-history text-redM me-2"></i> Purchased History</a>
                                            <a class="dropdown-item border-bottom border-white border-1 border-opacity-10 py-2" href="#"><i class="bi bi-chat-left-dots-fill text-redM me-2"></i> Contact Admin</a>
                                            <button class="dropdown-item btn py-2" onclick="signOut();"><i class="bi bi-box-arrow-right text-redM me-2"></i> Sign Out</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
</body>

</html>