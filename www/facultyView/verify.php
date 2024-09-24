<?php
    require '../server/config.php';

    if(isset($_GET['f_email']) && isset($_GET['v_code'])){

        $query = "SELECT * FROM verify_faculty WHERE f_email = '$_GET[f_email]' AND ver_code= '$_GET[v_code]'";
        $result = mysqli_query($conn,$query);


        if($result){

            if(mysqli_num_rows($result) == 1){

                $result_fatch = mysqli_fetch_assoc($result);
                if($result_fatch['is_verified'] == 0){

                    $update = "UPDATE `faculty` SET `is_verified`='1' WHERE `f_email` = '$result_fatch[f_email]'";
                    if(mysqli_query($conn,$update)){

                        header('location:after_verify.php');

                    } else{
                        echo "
                        <script>
                            alert('Email already registered!');
                            window.location.href='fSignup.php';
                        </script>
                        ";
                    }

                } else{
                    echo "
                    <script>
                        alert('Email already registered!');
                        window.location.href='fSignup.php';
                    </script>
                    ";
                }
            }


        } else{

            // for Query error
            echo "
            <script>
                alert('Cannot Run Query');
                window.location.href='fSignup.php';
            </script>
            ";
        }
    }




?>
