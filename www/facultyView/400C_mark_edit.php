<?php

require '../server/config.php';
require 'sessionInfo.php';
require 'validation.php';

$session = new SessionInfo();
$userFName = $session->f_fName;
$faculty_id = $session->f_id;

$demoObj = new Validation();

$student_id = "";
$mark = "";
$semester = "";
$year = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    //get method: show the data of student

    if (!isset($_GET["student_id"])) {

        header('location:400C_mark.php');
        exit;
    }

    $student_id = $_GET["student_id"];

    $sql = "SELECT * FROM 400c_mark WHERE student_id = '$student_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header('location:400C_mark.php');
        exit;
    }


    $student_id = $row["student_id"];
    $mark = $row["mark"];

    $semYear = $row["semester"];

    list($from, $to) = explode("-", $semYear);


    $semester = $from;
    $year = $to;


} else {

    //post method: updata the data of the student

    $student_id = $_POST["student_id"];
    $mark = $_POST["mark"];
    $semester = $_POST["semester"];
    $year = date("Y");



    do {
        if (empty($student_id) || empty($mark) || empty($semester)) {
            $errorMessage = "All fields are required";
            break;
        }

        $stdId = $demoObj->validStId($student_id);
        $stdMark = $demoObj->markSubmit($mark);

        if ($stdId && $stdMark) {

            $student_id = mysqli_real_escape_string($conn, $student_id);
            $mark = mysqli_real_escape_string($conn, $mark);
        }

        $semYear = $semester . "-" . $year;

        $sql = "UPDATE `400c_mark` SET `mark`='$mark ',`semester`='$semYear' WHERE `student_id`='$student_id'";

        $result = $conn->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;

        }

        $successMessage = "Mark hase been updated";
        break;

    } while (false);


}



?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grade Edit</title>
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
        <h2> <b>400C mark update</b></h2>
    </div>

    <div>
        <div class="container my-5">
            <h2>update student mark 400C</h2>
            <br>

            <div>
                <?php
                if (!empty($errorMessage)) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo "<strong>$errorMessage</strong>";
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                    echo '<script>';
                    echo 'setTimeout(function() {';
                    echo '    window.location.href = "400C_mark.php";';
                    echo '}, 2000);'; // Adjust the delay time as needed
                    echo '</script>';
                }
                ?>
            </div>

            <form method="POST">

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Student ID</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="student_id" id="student_id"
                            value="<?php echo $student_id ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Mark</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="mark" id="mark" value="<?php echo $mark ?>">
                    </div>
                </div>

                <div class="row mb-3">

                    <label class="col-sm-3 col-form-label">Semester</label>

                    <div class="col-sm-6">

                        <select class="form-select custom_select" required aria-label="select example" name="semester">
                            <?php
                            if ($semester == "Spring") {
                                echo "
                                                                <option value=$semester>Spring</option>
                                                                <option value='Summer'>Summer</option>
                                                                <option value='Fall'>Fall</option>
                                                            ";

                            } elseif ($semester == "Summer") {
                                echo "
                                                                <option value='Spring'>Spring</option>
                                                                <option value=$semester>Summer</option>
                                                                <option value='Fall'>Fall</option>
                                                            ";

                            } else {
                                echo "
                                                                <option value='Spring'>Spring</option>
                                                                <option value='Summer'>Summer</option>
                                                                <option value=$semester>Fall</option>
                                                            ";
                            }

                            ?>
                        </select>

                    </div>

                </div>

                <div>
                    <?php
                    if (!empty($successMessage)) {
                        echo '<div class="row mb-3">';
                        echo '<dic class="offset-sm-3 col-sm-6">';
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                        echo "<strong>$successMessage</strong>";
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '<script>';
                        echo 'setTimeout(function() {';
                        echo '    window.location.href = "400C_mark.php";';
                        echo '}, 2000);'; // Adjust the delay time as needed
                        echo '</script>';
                    }
                    ?>
                </div>

                <div class="row mb-3">

                    <div class="offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" class="btn btn-outline-primary">SUBMIT</button>
                    </div>

                    <div class="col-sm-3 d-grid">
                        <a class="btn btn-outline-primary" href="400C_mark.php" role="button">Cancel</a>
                    </div>

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