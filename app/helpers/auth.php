<?php 

class Auth{

    public static function  adminAuth(){
        if(isset($_SESSION['admin'])){
            return true;
        }else {
            Session::set('danger', 'You are not authorized');
            Redirect::to('login');
        }
    }

    public static function  userAuth(){
        if(isset($_SESSION['user'])){
            return true;
        }else {
            Session::set('danger', 'You are not authorized');
            Redirect::to('user/login');
        }
    }
 
}

