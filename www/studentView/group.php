<?php

require '../server/config.php';
require 'sessionInfo.php';


$session = new SessionInfo();
$userFName = $session->s_fName;
$std_1 = $session->s_id;


$sql = "SELECT * FROM group_req";
$quary = $conn->query($sql);

if (!$quary) {
    die("Invalid query: " . $conn->error);
}

$std_1 = $_SESSION['student_id'];

$searchGroup = "SELECT * FROM group_req WHERE std_1 = '$std_1' OR std_2 = '$std_1' OR std_3 = '$std_1' OR std_4 = '$std_1'";

$querySearchGroup = $conn->query($searchGroup);

if ($querySearchGroup->num_rows > 0) {

    //get group data group_req table
    while ($row = $querySearchGroup->fetch_assoc()) {
        $gourpId = $row["group_id"];
        $std01 = $row["std_1"];
        $std02 = $row["std_2"];
        $std03 = $row["std_3"];
        $std04 = $row["std_4"];

    }

    //getting student name and eamil from Database
    $forStd01 = "SELECT s_firstname, s_email FROM student WHERE student_id = '$std01'";
    $queryForStd01 = $conn->query($forStd01);
    $studentDetail01 = $queryForStd01->fetch_assoc();
    if ($studentDetail01) {
        $std01Name = $studentDetail01["s_firstname"];
        $std01Email = $studentDetail01["s_email"];
    } else {
        $std01Name = null;
        $std01Email = null;
    }

    $forStd02 = "SELECT s_firstname, s_email FROM student WHERE student_id = '$std02'";
    $queryForStd02 = $conn->query($forStd02);
    $studentDetail02 = $queryForStd02->fetch_assoc();
    if ($studentDetail02) {
        $std02Name = $studentDetail02["s_firstname"];
        $std02Email = $studentDetail02["s_email"];
    } else {
        $std02Name = null;
        $std02Email = null;
    }

    $forStd03 = "SELECT s_firstname, s_email FROM student WHERE student_id = '$std03'";
    $queryForStd03 = $conn->query($forStd03);
    $studentDetail03 = $queryForStd03->fetch_assoc();
    if ($studentDetail03) {
        $std03Name = $studentDetail03["s_firstname"];
        $std03Email = $studentDetail03["s_email"];
    } else {
        $std03Name = null;
        $std03Email = null;
    }

    $forStd04 = "SELECT s_firstname, s_email FROM student WHERE student_id = '$std04'";
    $queryForStd04 = $conn->query($forStd04);
    $studentDetail04 = $queryForStd04->fetch_assoc();
    if ($studentDetail04) {
        $std04Name = $studentDetail04["s_firstname"];
        $std04Email = $studentDetail04["s_email"];
    } else {
        $std04Name = null;
        $std04Email = null;
    }


    //for Supervisor
    /* without using join query
    $assignSuper = "SELECT `faculty_id` FROM `group` WHERE group_id = '$gourpId'";
    $querySuper = $conn->query($assignSuper);
    //checking Supervisor id in supervisor table
    if ($querySuper->num_rows > 0) {
    $querySuperId = $querySuper->fetch_assoc();
    $superId = $querySuperId["faculty_id"];
    //getting Supervisor name from faculty table
    $superDetail = "SELECT `f_name` FROM `faculty` WHERE faculty_id = '$superId'";
    $querySuperDetail = $conn->query($superDetail);
    $querySuper_Id = $querySuperDetail->fetch_assoc();
    $super_name = $querySuper_Id["f_name"];
    $alart_mess = null;
    */

    //using join query
    $assignSuper = "SELECT faculty.f_firstname, faculty.f_email  FROM `group` JOIN faculty WHERE faculty.faculty_id = `group`.`faculty_id` AND `group`.`group_id` = '$gourpId'";
    $querySuper = $conn->query($assignSuper);

    //checking Supervisor id in Join table table and get name
    if ($querySuper->num_rows > 0) {
        $querySuperId = $querySuper->fetch_assoc();
        $super_name = $querySuperId["f_firstname"];
        $super_mail = $querySuperId["f_email"];
        $alart_mess = null;

    } else {
        //if Supervisor not assigned
        $super_name = null;
        $alart_mess = "Your supervisor isn't assigned yet";


    }


} else {
    // Didn't find the group
    echo '
    <script>
        alert("You or your teammate did not apply for the group yet"); 
        window.location.href="capstone_reg.php";
    </script>
    ';
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Group</title>
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
                            <a class="nav-link active" aria-current="page" href="#">Group</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link" href="vivaInfo.php">Viva Info</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link" href="grade_report.php">Grade</a>
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
        <h2> <b>Group Info.</b></h2>
    </div>

    <div class="container" style="background-color:#F5F4F4">

            <div class="row">

                <div style="margin-top:30px">

                    <div>

                        <?php
                        if ($alart_mess) {
                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                            echo $alart_mess;
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        }

                        ?>

                    </div>

                    <?php echo "<h1 style='font-size: 30px; color:black'>Supervisor: $super_name ($super_mail)</h1>"; ?>

                </div>

                <table class="table table-light table table-hover table table-bordered border border-dark" style="width:100%">

                    <thead class="table-secondary border border-dark">
                        <tr>
                            <th scope="col">Student ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php

                        echo "
                            <tr>
                                <th scope='row'> " . $std01 . " </th>
                                <td> " . $std01Name . " </td>
                                <td> " . $std01Email . " </td>
                            </tr>
                            <tr>
                                <th scope='row'> " . $std02 . " </th>
                                <td> " . $std02Name . " </td>
                                <td> " . $std02Email . " </td>
                            </tr>
                            <tr>
                                <th scope='row'> " . $std03 . " </th>
                                <td> " . $std03Name . " </td>
                                <td> " . $std03Email . " </td>
                            </tr>
                            <tr>
                                <th scope='row'> " . $std04 . " </th>
                                <td> " . $std04Name . " </td>
                                <td> " . $std04Email . " </td>
                            </tr>
            
                        ";

                        ?>
                    </tbody>


                </table>


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