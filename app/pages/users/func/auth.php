<?php
use taladashvili\root\Database;


class login_auth
{
    // for redirect login url
    protected $loginpage = URL . 'users/login';
    protected $profilepage = URL . 'users/profile';

    // max lengths
    protected $username_maxlength = 64;
    protected $password_maxlength = 256;

    // max attempts
    protected $max_attempts = 3;

    // error messages
    protected $error_messages = [
        'empty' => 'Username Or Password Was Empty',
        'notexists' => 'Username Not Exists',
        'blocked' => 'Username Is Blocked',
        'incorect' => 'Username Or Password Was Incorect'
    ];

    public function __construct()
    {
        unset($_SESSION['login_error']);

        // if allready is authorized redirect to profile
        $this->allready_authorized();

        // checks if it is post request
        $this->check_method();

        // authenticate user
        $this->start();
    }


    private function start()
    {

        // check if username or password is empty
        if (empty($_POST['login_username']) || empty($_POST['login_Password'])) {
            $this->login_filed('empty');
        }

        // username and password  length Cut
        $username = substr($_POST['login_username'], 0, $this->username_maxlength);
        $password = substr($_POST['login_Password'], 0, $this->password_maxlength);

        // New Database 
        $pdo = new Database();

        // user exists
        $sql_user = $pdo->Existed('users', 'username', $username);
        if (!empty($sql_user['error']) || !isset($sql_user['resoult']) || !$sql_user['resoult']) {
            $this->login_filed('notexists');
        }

        // select user row
        $sql_user = $pdo->SQL('SELECT `id`, `username`, `pass`, `status`, `last_attampt`, `attempts` FROM `users` WHERE `username`=?', [$username], false);

 
        // password check 
        $pass_check = $this->password_chack($sql_user['pass'], $password);

        // update
        $attempts = $sql_user['attempts'];
        $attempts = !$pass_check ? $attempts + 1 : 0;
        $sql = "UPDATE `users` SET `attempts`=:attempts ";

        if ($attempts >= $this->max_attempts) {
            $sql .= " ,`status`='blocked' ";
        }
        // check if user status
        if (empty($sql_user['status']) || $sql_user['status'] == 'blocked') {
            $this->insert_auth($sql_user['id'], false);
            $this->login_filed('blocked');
        }
        
            $resoult = $pdo->UPDATE($sql . " WHERE `username`=:username", ['attempts' => $attempts, 'username' => $username]);

       

       

        $this->insert_auth($sql_user['id'], $pass_check);


        if ($attempts >= $this->max_attempts) {
            $this->login_filed('blocked');
        }



        // user password is correct
        if ($pass_check == true) {
            $this->login_success($sql_user);
        }

        // at last password is incorect
        $this->login_filed('incorect');
    }
    private function check_method()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            // redirect to back if exists or redirect to login page
            $url = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->loginpage;
            header("Location: " . $url);
            exit();
        }
    }

    private function password_chack($sql_pass, $input_pass)
    {
        if ($sql_pass == $input_pass) {
            return true;
        }
        return false;
    }

    private function login_filed($err_msg_key)
    {

        $_SESSION['login_error'] = isset($this->error_messages[$err_msg_key]) ? $this->error_messages[$err_msg_key] : 'Error while authenticate';
        header("Location: " . $this->loginpage);
        exit();
    }

    private function login_success($user)
    {
        $_SESSION['user'] = $user;
        header("Location: " . $this->profilepage);
        exit();
    }

    private function allready_authorized()
    {
        if (!empty($_SESSION['user'])) {
            header("Location: " . $this->profilepage);
            exit();
        }
    }



    private function insert_auth($user_id, $succes)
    {
        $device = $this->get_device();
        $ip = $this->get_ip();
        $status = $succes ? 'S' : 'F';
        // New Database 
        $pdo = new Database();
        $sql = "INSERT INTO `users_auth`(`user_id`, `status`,`user_device`, `ip`) 
        VALUES (?,?,?,?)";
        $arr = [$user_id, $status, $device, $ip];
        $pdo->SQL_insert($sql, $arr);
    }

    private function get_device()
    {
        $PLATFORM = $_SERVER['HTTP_SEC_CH_UA_PLATFORM'];
        $MOBILE = $_SERVER['HTTP_SEC_CH_UA_MOBILE'];
        $USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
        $SEC_CH_UA = $_SERVER['HTTP_SEC_CH_UA'];


        if (!isset($_COOKIE['browser_hash'])) {
            $user_agent_hash = md5($this->get_ip() . $USER_AGENT . time());
            setcookie('browser_hash', $user_agent_hash, time() + 86400 * 30, '/');
        }

        $token = isset($_COOKIE['browser_hash']) ? $_COOKIE['browser_hash'] : (isset($user_agent_hash) ? $user_agent_hash : '');

        // New Database 
        $pdo = new Database();

        $check = $pdo->Existed('user_devices', 'token', $token);
        if (!empty($check['error']) || !isset($check['resoult']) || !$check['resoult']) {


            return $pdo->SQL_insert(
                "INSERT INTO `user_devices`(`PLATFORM`, `MOBILE`, `USER_AGENT`, `SEC_CH_UA`, `token`)  VALUES (?,?,?,?,?)",
                [$PLATFORM, $MOBILE, $USER_AGENT, $SEC_CH_UA, $token]
            );

        }

        $device_id = $pdo->SQL("select id from user_devices where token =?", [$token], false);

        if (empty($device_id['error']) && isset($device_id['id']))
            return $device_id['id'];

        return -1;

    }

    private function get_ip()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}

?>