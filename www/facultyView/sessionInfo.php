<?php

require '../server/config.php';

session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('location: login.php');
    exit;
}


class SessionInfo
{

    public $f_id;
    public $f_fName;
    public $f_lName;
    public $phone_no;
    public $f_email;
    public $dept_name;
    public $is_verified;

    public function __construct()
    {
        $this->f_id = $_SESSION['faculty_id'];
        $this->f_fName = $_SESSION['f_firstname'];
        $this->f_lName = $_SESSION['f_lastname'];
        $this->phone_no = $_SESSION['phone_no'];
        $this->f_email = $_SESSION['f_email'];
        $this->dept_name = $_SESSION['department_dept_name'];
        $this->is_verified = $_SESSION['is_verified'];
    }
}

?>