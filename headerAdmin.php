<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="./css/main.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">


</head>

<body>

    <div class="col-12 bg-body">
        <div class="row">
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand fs-3" href="#">Musicate<span class="fw-lighter" style="font-size: 12px;">Admin</span></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="col-12 col-md-8">
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="adminPanel.php">Admin Panel</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><i class="bi bi-info-square-fill"></i> User Feedbacks</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><i class="bi bi-bug-fill"></i> Reported Issues</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><i class="bi bi-truck"></i> Track Orders</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-4 col-md-2">
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-person-circle fs-5"></i>&nbsp; Ravidu Vithana
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-person-lines-fill"></i> Admin Profile</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-activity"></i> Recent Activity</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-file-bar-graph-fill"></i> Sales Report</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-chat-left-dots"></i> Message</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><button class="dropdown-item btn"><i class="bi bi-box-arrow-right"></i> Sign Out</button></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </nav>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>

</body>

</html>