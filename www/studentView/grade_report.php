<?php

require '../server/config.php';
require 'sessionInfo.php';


$session = new SessionInfo();
$userFName = $session->s_fName;
$std_1 = $session->s_id;


$sql1 = "SELECT * FROM `400a_mark` WHERE student_id = '$std_1'";
$result1 = $conn->query($sql1);

if ($result1->num_rows > 0) {
    $query1 = $result1->fetch_assoc();
    $markA = $query1["mark"];

} else {
    $markA = "not given yet";
}

$sql2 = "SELECT * FROM `400b_mark` WHERE student_id = '$std_1'";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
    $query2 = $result2->fetch_assoc();
    $markB = $query2["mark"];

} else {
    $markB = "not given yet";
}


$sql3 = "SELECT * FROM `400c_mark` WHERE student_id = '$std_1'";
$result3 = $conn->query($sql3);

if ($result3->num_rows > 0) {
    $query3 = $result3->fetch_assoc();
    $markC = $query3["mark"];

} else {
    $markC = "not given yet";
}



?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grade</title>
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
                            <a class="nav-link active" aria-current="page" href="#">Grade</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link" href="info.php">Info</a>
                        </li>

                    </ul>
                </div>

            </div>

        </nav>

    </div>

    <div style="margin-left: 10%; margin-top: 50px;">
        <h2> <b>Grade Report</b></h2>
    </div>

    <section>

        <div class="container">

            <div class="row">

                <div style="margin-top:30px">

                    <table class="table table-hover">

                        <tbody>

                            <tr>
                                <td scope="row">
                                    <h2 style="font-size: 20px; color:black; margin-left: 100px; margin-top:30px">400A mark is: </h2>
                                </td>
                                <td>
                                    <h2 style="font-size: 20px; color:black; margin-left: 100px; margin-top:10px">
                                        <span style="color:#EA105D;"> <?php echo $markA ?></span>
                                    </h2>
                                </td>
                
                            </tr>

                            <tr>
                                <td scope="row">
                                    <h2 style="font-size: 20px; color:black; margin-left: 100px; margin-top:30px">400B mark is: </h2>
                                </td>
                                <td>       
                                    <h1 style="font-size: 20px; color:black; margin-left: 100px; margin-top:30px"> 
                                        <span style="color:#EA105D;"> <?php echo $markB ?></span>
                                    </h1>
                                </td>
                                
                            </tr>

                            <tr>
                                <td scope="row">
                                    <h2 style="font-size: 20px; color:black; margin-left: 100px; margin-top:30px">400C mark is: </h2>
                                </td>
                                <td>                         
                                    <h2 style="font-size: 20px; color:black; margin-left: 100px; margin-top:30px">
                                        <span style="color:#EA105D;"> <?php echo $markC ?></span>
                                    </h2>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>
    
            </div>
    
        </div>

    </section>






    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
        </script>
</body>

</html>