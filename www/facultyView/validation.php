<?php

class Validation
{
    // Function for validating student ID
    public function validStId($s_id)
    {
        // Define the regular expression for a valid ID.
        $id_regex = "/^[0-9]{4}-[0-9]{1}-[0-9]{2}-[0-9]{3}$/";

        // Validate the ID.
        if (!preg_match($id_regex, $s_id)) {
            // The ID is invalid.
            echo "
                <script>
                    alert('The ID is not in the correct format');  
                </script>
                ";
            return false;
        } else {
            // The ID is valid.
            return true;
        }
    }

    public function validFLId($f_id)
    {
        // Define the regular expression for a valid ID.
        $id_regex = "/^[A-Z]{2}-[0-9]{4}$/";

        // Validate the ID.
        if (!preg_match($id_regex, $f_id)) {
            // The ID is invalid.
            echo "
                    <script>
                        alert('The ID is not in the correct format');
                        window.location.href='fsignUp.php';
                    </script>
                    ";
            return false;
        } else {
            //echo "The ID is valid.";
            return true;
        }
    }

    // Function for validating first name
    public function validFastName($s_fName)
    {
        // Define the regular expression for a valid name.
        $name_regex = "/^[a-zA-Z ]*$/";

        // Validate the name.
        if (!preg_match($name_regex, $s_fName)) {
            // The name is invalid.
            echo "
                <script>
                    alert('Fast name must only contain letters and whitespace');
                </script>
                ";
            return false;
        } else {
            // The name is valid.
            return true;
        }
    }

    // Function for validating last name
    public function validLastName($s_lName)
    {
        // Define the regular expression for a valid name.
        $name_regex = "/^[a-zA-Z ]*$/";

        // Validate the name.
        if (!preg_match($name_regex, $s_lName)) {
            // The last name is invalid.
            echo "
                <script>
                    alert('Last name must only contain letters and whitespace');
                </script>
                ";
            return false;
        } else {
            // The last name is valid.
            return true;
        }
    }

    // Function for validating phone number
    public function validNumber($s_phoneNo)
    {
        // Define the regular expression for a valid phone number.
        $phone_regex = "/^[0-9]{11}$/";


        // Validate the phone number.
        if (!preg_match($phone_regex, $s_phoneNo)) {
            // The phone number is invalid.
            echo "
                <script>
                    alert('Phone number is not in the correct format');
                </script>
                ";
            return false;
        } else {
            // The phone number is valid.
            return true;
        }
    }

    // Function for validating student email
    public function validStMail($s_email)
    {
        // Define the regular expression for a valid email address.
        $email_regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/";

        // Validate the email address.
        if (!preg_match($email_regex, $s_email)) {
            // The email address is invalid.
            echo "
                <script>
                    alert('Email address is not in the correct format');
                </script>
                ";
            return false;
        } else {
            // The email address is valid.
            return true;
        }

    }

    public function validFLMail($f_email)
    {
        // Define the regular expression for a valid email address.
        $email_regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/";

        // Validate the email address.
        if (!preg_match($email_regex, $f_email)) {
            // The email address is invalid.
            echo "
                <script>
                    alert('Email address is not in the correct format');
                </script>
                ";
            return false;
        } else {
            // The email address is valid.
            return true;
        }

    }

    // Function for validating password
    public function validPassword($s_password)
    {
        // Define the regular expression for a valid password.
        $password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*]).{8,}$/";

        // Validate the password.
        if (!preg_match($password_regex, $s_password)) {
            // The password is invalid.
            echo "
                <script>
                    alert('Password is invalid');
                </script>
                ";
            return false;
        } else {
            // The password is valid.
            return true;
        }
    }

    // Function for validating total complete credit (must be >= 90)
    public function validTot_credit($tot_credit)
    {
        // Validate the total credit.
        if ($tot_credit < 90) {
            // The total credit is invalid.
            echo "
                <script>
                    alert('Total credit is not complete');
                </script>
                ";
            return false;
        } else {
            // The total credit is valid.
            return true;
        }
    }

    public function markSubmit($mark)
    {
        // Validate the total credit.
        if ($mark >= 0 && $mark <= 100) {
            // The total credit is valid.
            return true;

        } else {
            // The total credit is invalid.
            echo "
                <script>
                    alert('mark must be 0-100');
                </script>
                ";
            return false;
        }
    }


}

?>