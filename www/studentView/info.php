<?php

require '../server/config.php';
require 'sessionInfo.php';


$session = new SessionInfo();
$userFName = $session->s_fName;
$std_1 = $session->s_id;


if (isset($_POST['info'])) {

    $sub = $_POST['sub'];
    $text = $_POST['text'];

    // Escape the values to prevent syntax errors
    $sub = mysqli_real_escape_string($conn, $sub);
    $text = mysqli_real_escape_string($conn, $text);


    $report = "INSERT INTO `support`(`std_id`, `subject`, `detail`) VALUES ('$s_id','$sub','$text')";

    $query_report = $conn->query($report);

    if ($query_report) {

        echo "
            <script>
                alert('Report has been sent');
                window.location.href='info.php';
            </script>
            ";


    } else {

        // for Query error
        echo "
                <script>
                    alert('Cannot Run Query');
                    window.location.href='home.php';
                </script>
                ";
    }

}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Support</title>
    <link rel="stylesheet" href="../css/main.css?v=<?= $version ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/d4c3426ce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>

<body style="background-color: #f2f6ff;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container-fluid" style="margin-left:50px">

            <a class="navbar-brand" href="#">East West University</a>

            <ul class="navbar-nav" style="margin-right:100px">

                <a href="" class="text-dark mx-3">
                    <i class="fas fa-envelope fa-2x"></i>
                    <span class="badge bg-danger badge-dot"></span>
                </a>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $userFName ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                        <li><a class="dropdown-item" id="logOut" href="logout.php">Logout</a></li>
                    </ul>
                </li>


            </ul>

        </div>
    </nav>


    <div style="font-size:20px;">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

            <div class="container-fluid" style="margin-left:70px;">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">

                        <li class="nav-item" style="margin-left:10px">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link" href="capstone_reg.php">Capstone</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link" href="group.php">Group</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link" href="vivaInfo.php">Viva Info</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link " href="grade_report.php">Grade</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link active" aria-current="page" href="#">Info</a>
                        </li>

                    </ul>
                </div>

            </div>

        </nav>

    </div>

    <div style="margin-left: 10%; margin-top: 50px;">
        <h2> <b>Other Info</b></h2>
    </div>

    <div style="padding-bottom:100px">

    <div style="margin-left: 10%; margin-top: 50px;">
        <h3>You can visit our other website</h3>
        <b><a style="color:#68B7B3; text-decoration: none;" target="_blank" href="https://www.ewubd.edu/"> East West University</a></b>
        <br>
        <b><a style="color:#68B7B3; text-decoration: none;" target="_blank" href="https://portal.ewubd.edu/"> University Protal</a></b>
    </div>
   

    <div style="margin-left: 10%; margin-right: 10%; margin-top: 50px;">
        <h3>Support Section</h3>
        <p>If you need any help you can ask here. We will contact you by mail.</p>

        <form action="info.php" method="POST">
            
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Subject</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Subject" name="sub" required>
            </div>

            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Text</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="text" required></textarea>
            </div>

            <br>

            <div class="mb-3">
                <button type="submit" class="btn btn-outline-success" id="info" name="info">SEND</button>
            </div>
   
        </form>

    </div>

</div>








    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
        </script>
</body>

</html>