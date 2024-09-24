<?php

require '../server/config.php';

session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('location: login.php');
    exit;
}


class SessionInfo
{

    public $s_id;
    public $s_fName;
    public $s_lName;
    public $phone_no;
    public $s_email;
    public $tot_credit;
    public $is_verified;

    public function __construct()
    {
        $this->s_id = $_SESSION['student_id'];
        $this->s_fName = $_SESSION['s_firstName'];
        $this->s_lName = $_SESSION['s_lastName'];
        $this->phone_no = $_SESSION['phone_no'];
        $this->s_email = $_SESSION['s_email'];
        $this->tot_credit = $_SESSION['tot_credit'];
        $this->is_verified = $_SESSION['is_verified'];
    }
}

?>