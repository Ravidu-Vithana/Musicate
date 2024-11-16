<?php

require "connection.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Musicate | Register</title>

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="./css/main.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Pacifico&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link rel="icon" href="resources/logo_title.png" />

</head>

<body class="background">

    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-12">
                <div class="row py-4">
                    <div class="col-4 offset-2 d-none d-lg-block" style="background-image: url('./resources/signinupBg.jpg'); background-size: cover; background-position: center;">
                    </div>
                    <div class="col-lg-4 offset-lg-0 offset-md-2 col-md-8 offset-1 col-10 bg-white text-grayM">
                        <div class="row">
                            <div class="col-12 mt-2">
                                <div class="row">
                                    <div class="col-4 offset-4 d-flex flex-column align-items-center">

                                        <img src="resources/logo.png" class="rounded-circle" style="height: 8rem;" />

                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-1">
                                <h3 class="h3 fw-bold">Sign Up</h3>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span id="errf" class="text-warning" style="font-size: 12px;"></span><br />
                                <label class="form-label">First Name<span class="req">*</span></label>
                                <input class="form-control text-black " type="text" id="f" />
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span id="errl" class="text-warning" style="font-size: 12px;"></span><br />
                                <label class="form-label">Last Name<span class="req">*</span></label>
                                <input class="form-control text-black " type="text" id="l" />
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span id="errdob" class="text-warning" style="font-size: 12px;"></span><br />
                                <label class="form-label">Date Of Birth<span class="req">*</span></label>
                                <input class="form-control" type="date" id="dob" />
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span id="errg" class="text-warning" style="font-size: 12px;"></span><br />
                                <label class="form-label">Gender<span class="req">*</span></label>
                                <select class="form-select" id="g">
                                    <option value="0">Select Gender</option>

                                    <?php

                                    $gender_rs = Database::search("SELECT * FROM `gender`");
                                    $gender_num = $gender_rs->num_rows;

                                    for ($x = 0; $x < $gender_num; $x++) {
                                        $gender_data = $gender_rs->fetch_assoc();

                                    ?>

                                        <option value="<?php echo ($gender_data["id"]); ?>"><?php echo ($gender_data["gender_name"]); ?></option>

                                    <?php

                                    }

                                    ?>

                                </select>
                            </div>
                            <div class="col-12 mt-2">
                                <span id="erre" class="text-warning" style="font-size: 12px;"></span><br />
                                <label class="form-label">Email<span class="req">*</span></label>
                                <input class="form-control text-black " type="email" id="e" />
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span id="errp" class="text-warning" style="font-size: 12px;"></span><br />
                                <label class="form-label">Password<span class="req">*</span></label>
                                <div class="input-group mb-3">
                                    <input class="form-control text-black" aria-describedby="button-addon2" type="password" id="p">
                                    <button class="btn btn-light" type="button" id="button-addon2" onclick="viewpassword('0');"><i class="bi bi-eye-slash-fill"></i></button>
                                </div>
                                <span style="font-size: 11px;"><i style="font-size: 11px;">Password must contain atleast one Uppercase letter, one lowercase letter, a digit and one of the special characters @,#,$,%,&.</i></span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span id="errm" class="text-warning" style="font-size: 12px;"></span><br />
                                <label class="form-label">Mobile Number<span class="req">*</span></label>
                                <input class="form-control text-black " type="text" id="m" />
                            </div>
                            <div class="col-12 mt-2">
                                <span id="erra" class="text-warning" style="font-size: 12px;"></span><br />
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="agreebox">
                                    <label class="form-check-label" for="agreebox">
                                        I agree to the <a href="#" class="text-decoration-none">Terms and Conditions<span class="req">*</span></a>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 mt-2 mb-3 d-grid">
                                <span class="text-warning" id="erru" style="font-size: 12px;"></span><br />
                                <button class="btn btn-outline-dark fs-5" onclick="signUp();">Sign Up</button>
                            </div>
                            <div class="col-12 mt-2 mb-4 text-center">
                                <span>Already have an Account? <a class="text-decoration-none fw-bold text-success" href="signin.php">Sign In!</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="bootstrap.bundle.js"></script>

</body>

</html>