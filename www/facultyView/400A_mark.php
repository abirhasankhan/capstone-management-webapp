<?php

require '../server/config.php';
require 'sessionInfo.php';
require 'validation.php';

$session = new SessionInfo();
$userFName = $session->f_fName;
$faculty_id = $session->f_id;

$demoObj = new Validation();

$num_per_page = 10;

if (isset($_GET["pages"])) {

    $pages = $_GET["pages"];

    $pages_pre = $pages - 1;
    $pages_next = $pages + 1;


} else {
    $pages = 1;
    $pages_pre = 0;
    $pages_next = 2;
}

$start_from = ($pages - 1) * 10;

$page = "SELECT * FROM `400a_mark` ORDER BY student_id DESC";
$query_page = $conn->query($page);
$total_rec = mysqli_num_rows($query_page);
//echo $total_rec;
$total_page = ceil($total_rec / $num_per_page);
//echo $total_page;

/************************************************************** */

$sql = "SELECT * FROM `400a_mark` ORDER BY `student_id` DESC LIMIT $start_from,$num_per_page";

$result = $conn->query($sql);

//for search
if (isset($_POST['search_submit'])) {

    $search = $_POST['search'];
    $sql = "SELECT * FROM `400a_mark` WHERE `student_id` LIKE '%$search%' ORDER BY student_id DESC LIMIT $start_from,$num_per_page";

} else {
    $sql = "SELECT * FROM `400a_mark` ORDER BY student_id DESC LIMIT $start_from,$num_per_page";

    $search = "";

}

$result = $conn->query($sql);




?>

<!-- The rest of your HTML code remains unchanged -->


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>400A Info</title>
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
        <h2> <b>400A info</b></h2>
    </div>

    <div style="margin-right: 10%; margin-top: 50px; text-align: right;">
        <h4> <b><a class="nav-link" style="color:coral" href="grade_submit.php">Grade Submit</a></b></h4>
    </div>

        <div class="container">

            <div class="row">

                <div class="my-5">

                    <form class="d-flex" role="search" action="400A_mark.php" method="POST">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                            name="search" value="<?php echo $search ?>">
                        <button class="btn btn-outline-success" type="submit" name="search_submit">Search</button>
                    </form>

                    <br>

                    <table class="table">

                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Mark</th>
                                <th>Semester</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php

                            if ($result->num_rows > 0) {

                                while ($row = $result->fetch_assoc()) {

                                    echo "
                                        <tr>
                                            <td>$row[student_id]</td>
                                            <td>$row[mark]</td>
                                            <td>$row[semester]</td>
                                            
                                            <td>
                                                <a class='btn btn-outline-primary' href='400A_mark_edit.php?student_id=$row[student_id]'>Edit</a> &nbsp;
                                                <a class='btn btn-outline-danger' href='400A_mark_del.php?student_id=$row[student_id]'>Delete</a>
                                            </td>

                                        </tr>
                                    ";
                                }

                            } else {

                                echo "
                            <div>
                                <h1>Nothing found..!</h1>
                            </div>

                        ";
                            }

                            ?>
                        </tbody>

                    </table>

                    <?php
                    /*****************************************for Previous page*********************************************************** */

                    echo "
                        <nav aria-label='Page navigation example'>
                        <ul class='pagination'>
                        ";

                    if ($pages_pre < 1) {
                        echo "
                            <li class='page-item'>
                                <a class='page-link' aria-label='Previous'>
                                    <span aria-hidden='true'>&laquo;</span>
                                </a>
                            </li>
                            ";
                    } else {
                        echo "
                            <li class='page-item'>
                                <a class='page-link' href='all_req.php?pages=$pages_pre' aria-label='Previous'>
                                    <span aria-hidden='true'>&laquo;</span>
                                </a>
                            </li>
                            ";
                    }
                    /*****************************************for current and all  pages*********************************************************** */

                    for ($i = 1; $i <= $total_page; $i++) {

                        if ($i == $pages) {

                            echo "
                                <li class='page-item'>
                                    <a class='page-link active'>$i</a>
                                </li>
                                ";

                        } else {

                            echo "               
                                <li class='page-item'>
                                    <a class='page-link' href='all_req.php?pages=$i'>$i</a>
                                </li>
                                ";

                        }

                    }

                    /*****************************************for next page*********************************************************** */

                    if ($pages_next > $total_page) {
                        echo "
                            <li class='page-item'>
                                <a class='page-link' aria-label='Next'>
                                    <span aria-hidden='true'>&raquo;</span>
                                </a>
                            </li>
                            ";

                    } else {
                        echo "
                            <li class='page-item'>
                                <a class='page-link' href='all_req.php?pages=$pages_next' aria-label='Next'>
                                    <span aria-hidden='true'>&raquo;</span>
                                </a>
                            </li>
                        ";
                    }

                    echo "
                        </ul>
                        </nav>
                        ";

                    ?>

                </div>

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