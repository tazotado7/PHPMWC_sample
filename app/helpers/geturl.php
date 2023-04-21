<?php
 function getUrl(){
    if(isset($_GET['url'])){ 
        $url = rtrim($_GET['url'], '/'); 
        $url = strtolower($url);
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        
       return $url;
    }
    return array('Home','index');
}