<?php

require '../server/config.php';
require 'sessionInfo.php';


$session = new SessionInfo();
$userFName = $session->s_fName;
$std_1 = $session->s_id;

//getting group ID
$searchGroup = "SELECT * FROM group_req WHERE std_1 = '$std_1' OR std_2 = '$std_1' OR std_3 = '$std_1' OR std_4 = '$std_1'";
$querySearchGroup = $conn->query($searchGroup);

if ($querySearchGroup->num_rows > 0) {
    //get group data group_req table
    while ($row = $querySearchGroup->fetch_assoc()) {
        $gourpId = $row["group_id"];
    }

} else {
    $gourpId = null;
}


//getting viva ID and viva for 400A
$vivaNoA = "SELECT `viva_no` FROM `viva_group` WHERE `def_type` = '400A' AND `group_id` = '$gourpId'";

$queryVivaNoA = $conn->query($vivaNoA);

if ($queryVivaNoA->num_rows > 0) {
    //get group data group_req table
    while ($rowVivaNoA = $queryVivaNoA->fetch_assoc()) {
        $viva_noA = $rowVivaNoA["viva_no"];
    }

    $vivaDetialA = "SELECT `time_slot`.`day`, `time_slot`.`start_hr`, `time_slot`.`start_min`, `time_slot`.`end_hr`, `time_slot`.`end_min`, `viva_board`.`viva_no`, `viva_board`.`room_no_room_no`, `viva_board`.`room_no_building` FROM `viva_board` JOIN `time_slot` WHERE `viva_board`.`viva_no` = $viva_noA";
    $queryVivaDetialA = $conn->query($vivaDetialA);


    if ($queryVivaDetialA->num_rows > 0) {
        //get group data group_req table
        while ($rowVivaA = $queryVivaDetialA->fetch_assoc()) {
            $vivaTimeA = $rowVivaA["day"];
            $vivaRoomNumberA = $rowVivaA["room_no_room_no"];
            $vivaBuildingA = $rowVivaA["room_no_building"];
            $vivaStartTimeHrA = $rowVivaA["start_hr"];
            $vivaStartTimeMinA = $rowVivaA["start_min"];
            $vivaEndTimeHrA = $rowVivaA["end_hr"];
            $vivaEndTimeMinA = $rowVivaA["end_min"];
        }

    }

} else {
    $vivaTimeA = null;
    $vivaRoomNumberA = null;
    $vivaBuildingA = null;
    $vivaStartTimeHrA = null;
    $vivaStartTimeMinA = null;
    $vivaEndTimeHrA = null;
    $vivaEndTimeMinA = null;
}

//getting viva ID and viva for 400B
$vivaNoB = "SELECT viva_no FROM `viva_group` WHERE `group_id` = '$gourpId' AND `def_type` = '400B'";

$queryVivaNoB = $conn->query($vivaNoB);

if ($queryVivaNoB->num_rows > 0) {
    //get group data group_req table
    while ($rowVivaNoB = $queryVivaNoB->fetch_assoc()) {
        $viva_noB = $rowVivaNoB["viva_no"];
    }

    $vivaDetialB = "SELECT `time_slot`.`day`, `time_slot`.`start_hr`, `time_slot`.`start_min`, `time_slot`.`end_hr`, `time_slot`.`end_min`, `viva_board`.`viva_no`, `viva_board`.`room_no_room_no`, `viva_board`.`room_no_building` FROM `viva_board` JOIN `time_slot` WHERE `viva_board`.`viva_no` = $viva_noB";
    $queryVivaDetialB = $conn->query($vivaDetialB);


    if ($queryVivaDetialB->num_rows > 0) {
        //get group data group_req table
        while ($rowVivaB = $queryVivaDetialB->fetch_assoc()) {
            $vivaTimeB = $rowVivaB["day"];
            $vivaRoomNumberB = $rowVivaB["room_no_room_no"];
            $vivaBuildingB = $rowVivaB["room_no_building"];
            $vivaStartTimeHrB = $rowVivaB["start_hr"];
            $vivaStartTimeMinB = $rowVivaB["start_min"];
            $vivaEndTimeHrB = $rowVivaB["end_hr"];
            $vivaEndTimeMinB = $rowVivaB["end_min"];
        }

    }

} else {
    $vivaTimeB = null;
    $vivaRoomNumberB = null;
    $vivaBuildingB = null;
    $vivaStartTimeHrB = null;
    $vivaStartTimeMinB = null;
    $vivaEndTimeHrB = null;
    $vivaEndTimeMinB = null;
}

//getting viva ID and viva for 400C
$vivaNoC = "SELECT viva_no FROM `viva_group` WHERE `group_id` = '$gourpId' AND `def_type` = '400C'";

$queryVivaNoC = $conn->query($vivaNoC);

if ($queryVivaNoC->num_rows > 0) {
    //get group data group_req table
    while ($rowVivaNoC = $queryVivaNoC->fetch_assoc()) {
        $viva_noC = $rowVivaNoC["viva_no"];
    }

    $vivaDetialC = "SELECT `time_slot`.`day`, `time_slot`.`start_hr`, `time_slot`.`start_min`, `time_slot`.`end_hr`, `time_slot`.`end_min`, `viva_board`.`viva_no`, `viva_board`.`room_no_room_no`, `viva_board`.`room_no_building` FROM `viva_board` JOIN `time_slot` WHERE `viva_board`.`viva_no` = $viva_noC";
    $queryVivaDetialC = $conn->query($vivaDetialC);


    if ($queryVivaDetialC->num_rows > 0) {
        //get group data group_req table
        while ($rowVivaC = $queryVivaDetialC->fetch_assoc()) {
            $vivaTimeC = $rowVivaC["day"];
            $vivaRoomNumberC = $rowVivaC["room_no_room_no"];
            $vivaBuildingC = $rowVivaC["room_no_building"];
            $vivaStartTimeHrC = $rowVivaC["start_hr"];
            $vivaStartTimeMinC = $rowVivaC["start_min"];
            $vivaEndTimeHrC = $rowVivaC["end_hr"];
            $vivaEndTimeMinC = $rowVivaC["end_min"];
        }

    }

} else {
    $vivaTimeC = null;
    $vivaRoomNumberC = null;
    $vivaBuildingC = null;
    $vivaStartTimeHrC = null;
    $vivaStartTimeMinC = null;
    $vivaEndTimeHrC = null;
    $vivaEndTimeMinC = null;
}




?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Viva Info</title>
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
                            <a class="nav-link" aria-current="page" href="home.php">Home</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link" href="capstone_reg.php">Capstone</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link" href="group.php">Group</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link active" aria-current="page" href="#">Viva Info</a>
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
        <h2> <b>Viva Info</b></h2>
    </div>

    <section>



        <div class="container">

            <div class="row">

                <div style="margin-top:30px">

                    <table class="table table-hover">

                        <tbody>

                            <tr>
                                <td scope="row">400A Viva Info...</td>
                                <td>
                                    <!-- Button 400A trigger modal -->
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        For 400A
                                    </button>
                                </td>
                
                            </tr>

                            <tr>
                                <td scope="row">400B Viva Info...</td>
                                <td>
                                    <!-- Button 400A trigger modal -->
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal01">
                                        For 400B
                                    </button>
    
                                    
                                </td>
                                
                            </tr>

                            <tr>
                                <td scope="row">400C Viva Info...</td>
                                <td>                        
                                    <!-- Button 400A trigger modal -->
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal02">
                                        For 400C
                                    </button>
                                </td>
                            </tr>

                        </tbody>

                    </table>


                    <!-- #region for 400A, 400B, 400C-->
                    <div>

                        <!-- Modal 400A-->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Viva for 400A</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div>
                                            <h1 style="font-size: 20px; color:black;">Gorup ID: <?php echo $gourpId; ?>
                                            </h1>
                                        </div>
                                        <div>
                                            <h1 style="font-size: 20px; color:black;">Viva Date:
                                                <?php echo $vivaTimeA; ?>
                                            </h1>
                                        </div>
                                        <div>
                                            <h1 style="font-size: 20px; color:black;">Room Number:
                                                <?php echo $vivaRoomNumberA, " Building: ", $vivaBuildingA; ?>
                                            </h1>
                                        </div>
                                        <div>
                                            <h1 style="font-size: 20px; color:black;">Start time:
                                                <?php echo $vivaStartTimeHrA, ":", $vivaStartTimeMinA; ?>
                                            </h1>
                                        </div>
                                        <div>
                                            <h1 style="font-size: 20px; color:black;">End Time:
                                                <?php echo $vivaEndTimeHrA, ":", $vivaEndTimeMinA; ?>
                                            </h1>
                                        </div>
    
                                    </div>
    
                                </div>
                            </div>
                        </div>
    
                    </div>
    
    
                    <div class="mt-4">

                        <!-- Modal 400B-->
                        <div class="modal fade" id="exampleModal01" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Viva for 400B</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
    
                                        <div>
                                            <h1 style="font-size: 20px; color:black;">Gorup ID:
                                                <?php echo $gourpId; ?>
                                            </h1>
                                        </div>
                                        <div>
                                            <h1 style="font-size: 20px; color:black;">Viva Date:
                                                <?php echo $vivaTimeB; ?>
                                            </h1>
                                        </div>
                                        <div>
                                            <h1 style="font-size: 20px; color:black;">Room Number:
                                                <?php echo $vivaRoomNumberB, " Building: ", $vivaBuildingB; ?>
                                            </h1>
                                        </div>
                                        <div>
                                            <h1 style="font-size: 20px; color:black;">Start time:
                                                <?php echo $vivaStartTimeHrB, ":", $vivaStartTimeMinB; ?>
                                            </h1>
                                        </div>
                                        <div>
                                            <h1 style="font-size: 20px; color:black;">End Time:
                                                <?php echo $vivaEndTimeHrB, ":", $vivaEndTimeMinB; ?>
                                            </h1>
                                        </div>
    
                                    </div>
    
                                </div>
                            </div>
                        </div>
    
                    </div>
    
                    <div class="mt-4">

                        <!-- Modal 400C-->
                        <div class="modal fade" id="exampleModal02" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Viva for 400C</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
    
                                        <div>
                                            <h1 style="font-size: 20px; color:black;">Gorup ID:
                                                <?php echo $gourpId; ?>
                                            </h1>
                                        </div>
                                        <div>
                                            <h1 style="font-size: 20px; color:black;">Viva Date:
                                                <?php echo $vivaTimeC; ?>
                                            </h1>
                                        </div>
                                        <div>
                                            <h1 style="font-size: 20px; color:black;">Room Number:
                                                <?php echo $vivaRoomNumberC, " Building: ", $vivaBuildingC; ?>
                                            </h1>
                                        </div>
                                        <div>
                                            <h1 style="font-size: 20px; color:black;">Start time:
                                                <?php echo $vivaStartTimeHrC, ":", $vivaStartTimeMinC; ?>
                                            </h1>
                                        </div>
                                        <div>
                                            <h1 style="font-size: 20px; color:black;">End Time:
                                                <?php echo $vivaEndTimeHrC, ":", $vivaEndTimeMinC; ?>
                                            </h1>
                                        </div>
    
                                    </div>
    
                                </div>
                            </div>
                        </div>
    
                    </div>
    
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