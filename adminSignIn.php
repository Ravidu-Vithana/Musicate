<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Pacifico&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="./css/main.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="icon" href="resources/logo_title.png" />

</head>

<body class="background">

    <div class="container-fluid vh-100">
        <div class="row">
            <div class="col-12">
                <div class="row min-vh-100 d-flex flex-column align-items-center justify-content-center">
                    <div class="col-lg-4 col-md-6 col-8 bg-dark text-white mt-1 rounded-4 bg-opacity-75">
                        <div class="row">
                            <div class="col-12 mt-1">
                                <div class="row">
                                    <div class="col-4 offset-4 d-flex flex-column align-items-center">

                                        <img src="resources/logo.png" class="rounded-circle" style="height: 160px;" />

                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-2 p-3">
                                <h2 class="h2 fw-bold">Admin Sign In</h2>
                            </div>

                            <?php

                            $email = "";
                            $password = "";

                            if (isset($_COOKIE["admin_email"])) {
                                $email = $_COOKIE["admin_email"];
                            }

                            if (isset($_COOKIE["admin_password"])) {
                                $password = $_COOKIE["admin_password"];
                            }

                            ?>

                            <div class="col-12 mt-3">
                                <span id="err" class="text-warning" style="font-size: 12px;"></span><br />
                                <span class="h6 ">Email</span>
                                <input class="form-control text-black " type="email" id="e" value="<?php echo ($email); ?>" />
                            </div>
                            <div class="col-12 mt-3">
                                <span class="h6 ">Password</span>
                                <div class="input-group">
                                    <input type="password" class="form-control text-black" id="p" value="<?php echo ($password); ?>" />
                                    <button class="btn btn-light" type="button" id="button-addon2" onclick="viewpassword('0');"><i class="bi bi-eye-slash-fill"></i></button>
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="rememberMe" <?php if (isset($_COOKIE["admin_password"])) {
                                                                                                                ?> checked <?php
                                                                                                                        } ?>>
                                    <label class="form-check-label" for="rememberMe">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 mt-3 text-end">
                                <a href="#" class="text-decoration-none text-primary" onclick="forgotPassword();">Forgot Password?</a>
                            </div>
                            <div class="col-12 mt-4 mb-4 d-grid">
                                <button class="btn btn-outline-light" onclick="signInAdmin();">Sign In</button>
                            </div>
                            <div class="col-12 mt-3 mb-5 text-end">
                                <a class="text-decoration-none fw-bold text-success" href="signin.php"><i class="bi bi-person-fill"></i> Sign In as User</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- forgot password modal -->
    <div class="modal fade" id="fpwmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <span class="fw-bold text-secondary fs-5 my-3">Enter Your Email</span><br />
                    <span class="text-secondary mb-3">An email containing your verification code will be sent to this email.</span>
                    <input type="email" id="email" class="form-control" />
                    <span class="my-2" id="viewmsg"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="sendEmail('admin');">Send Email</button>
                </div>
            </div>
        </div>
    </div>
    <!-- forgot password modal -->

    <!-- reset password modal -->
    <div class="modal fade" id="rpwmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <span class="text-secondary mb-3">An email containing your verification code is sent to the email. Please check your inbox.</span>
                    <input type="text" id="vcode" class="form-control" placeholder="Enter the verification code" />

                    <label for="npw">Enter your New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" aria-describedby="npwb" id="npw">
                        <button class="btn btn-light" type="button" id="npwb" onclick="viewpassword('1');"><i class="bi bi-eye-slash-fill"></i></button>
                    </div>
                    <span><i style="font-size: 11px;">Password must contain atleast one Uppercase letter, one lowercase letter, a digit and one of the special characters @,#,$,%,&.</i></span><br />

                    <label for="rnpw" class="mt-3">Confirm your Password</label>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" aria-describedby="rnpwb" id="rnpw">
                        <button class="btn btn-light" type="button" id="rnpwb" onclick="viewpassword('2');"><i class="bi bi-eye-slash-fill"></i></button>
                    </div>

                    <span class="text-secondary mb-3">Didnt receive the code?</span>
                    <button class="btn btn-warning" onclick="sendagain();">Send Again</button><br />
                    <span class="my-2" id="viewmsg2"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="resetPassword();">Reset Password</button>
                </div>
            </div>
        </div>
    </div>
    <!-- reset password modal -->

    <script src="script.js"></script>
    <script src="bootstrap.bundle.js"></script>

</body>

</html>