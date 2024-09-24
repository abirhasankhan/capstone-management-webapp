<?php

require '../server/config.php';
require 'sessionInfo.php';


$session = new SessionInfo();
$userFName = $session->f_fName;
$userID = $session->f_id;

$sql = "SELECT `group_req`.`group_id`, `group_req`.`std_1`, `group_req`.`std_2`, `group_req`.`std_3`, `group_req`.`std_4`, `group_req`.`dept_name` FROM `group` JOIN `group_req` WHERE `group_req`.`group_id` = `group`.`group_id` AND `group`.`faculty_id` = '$userID' AND `group_req`.`status` = 'complete'";

$result = $conn->query($sql);

if (!$result) {
    die("Invalid query: " . $conn->error);
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Overpast</title>
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
                            <a class="nav-link" href="group.php">Group</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link" href="grade_submit.php">Grade Report</a>
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
        <h2> <b>Overpast Group Info</b></h2>
    </div>

    <div style="margin-right: 10%; margin-top: 50px; text-align: right;">
        <h4> <b><a class="nav-link" style="color:coral" href="group.php">Onging Group List</a></b></h4>
    </div>

    <div class="container">

        <section>

            <div style="padding-top: 25px;">

                <div class="row gy-3 my-3">

                    <?php

                    if ($result->num_rows > 0) {
                        // for each student details
                        function getStudentInfo($studentId, $conn)
                        {
                            $sql = "SELECT * FROM student WHERE student_id = '$studentId'";
                            $result = $conn->query($sql);

                            if ($result) {
                                if ($result->num_rows > 0) {
                                    $studentData = $result->fetch_assoc();
                                    // Display relevant student information (adjust as needed)
                                    return "<b>ID</b>: " . $studentData['student_id'] . "<br><b>Name</b>: " . $studentData['s_firstname'] . "<br><b>Email</b>: " . $studentData['s_email'];
                                } else {
                                    return "Student not found";
                                }
                            } else {
                                return "Error: " . $conn->error;
                            }
                        }

                        // for assigne group
                        while ($row = $result->fetch_assoc()) {
                            echo "
                                    <table class='table table-light table table-hover table table-bordered border border-dark' style='width:100%'>
                                        <thead class='table-secondary border border-dark'>
                                            <tr>
                                                <th>Group ID</th>
                                                <th>Student ID one</th>
                                                <th>Student ID two</th>
                                                <th>Student ID three</th>
                                                <th>Student ID four</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><br><b>$row[group_id]</b></td>
                                                <td>" . getStudentInfo($row['std_1'], $conn) . "</td>
                                                <td>" . getStudentInfo($row['std_2'], $conn) . "</td>
                                                <td>" . getStudentInfo($row['std_3'], $conn) . "</td>
                                                <td>" . getStudentInfo($row['std_4'], $conn) . "</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                ";
                        }

                    } else {
                        echo "
                                <div>
                                    <h1>Nothing Found...!</h1>
                                </div>

                            ";
                    }

                    ?>

                </div>

            </div>

        </section>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
        </script>
</body>

</html>