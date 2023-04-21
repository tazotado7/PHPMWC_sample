<?php 
namespace taladashvili\root;
 class core
 {
    private $defoult_folder = 'Home';
    private $defoult_file = 'index';
     public function __construct()
    {
        $path = $this->start();
        require_once($path);
    }

    private function start()
    {
        $url = getUrl();
        $root_file = PAGES.'/'.$this->defoult_folder.'/'.$this->defoult_file.'.php';
        if(empty($url))
        return $root_file;
        
        
        $path = PAGES;
        $last_file = $root_file;  
        for ($i=0; $i < count($url); $i++) {  
        
            $new = $path.'/'.$url[$i];
            $isfolder = false;
            $isfile = false;
        
            if(file_exists($new))
            {
                $isfolder = true; 
                $path = $new;
                if(file_exists($new.'/'.$this->defoult_file.'.php'))
                $last_file = $new.'/'.$this->defoult_file.'.php';
            }
            else if(file_exists($new.'.php'))
            { 
                $isfile = true;
                $last_file = $new.'.php';
            }
            else
            { 
                break;
            } 
        } 
        
        
        return $last_file;
    }

    private function url()
    {
        if(isset($_GET['url'])){ 
            $url = rtrim($_GET['url'], '/'); 
            $url = strtolower($url);
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            
           return $url;
        }
        return array($this->defoult_folder,$this->defoult_file);
    }
 }