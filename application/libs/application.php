<?php

class Application 
{

    private $url_controller = null;
    private $url_action = null;
    private $url_parameter_1 = null;
    private $url_parameter_2 = null;
    private $url_parameter_3 = null;
    
    //Start the application
    public function __construct()
    {
        //call function and create array from url
        $this->splitUrl();
        
        //check for controller 
        if(file_exists('.application/controller/'. $this->url_controller . 'php')) {
            require '.application/controller/' . $this->url_controller . 'php';
            $this->url_controller = new $this->url_controller();
            
            //check if method exist
            if(method_exists($this->controller, $this->action)) {
                if(isset($this->url_paramater_3)) {
                    $this->url_controller->{$this->action}($this->url_parameter_1, $this->url_parameter_2, $this->url_parameter_3);
                } elseif(isset($this->url_parameter_2)) {
                    $this->url_controller->{$this->action}($this->url_parameter_1, $this->url_parameter_2);
                } elseif(isset($this->url_parameter_1)) {
                    $this->url_controller->{$this->action}($this->url_parameter_1);
                } else {
                    $this->url_controller->{$this->action};
                }
            } else {
                //default callback if method not exist
                $this->url_controller->index();
            }
        } else {
            //invalide URL, so simple show home/index
            require './application/controller/home.php';
            $home = new Home();
            $home->index();     
        }
    }
    
    private function splitUrl() 
    {
        //split url
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            
        //Put URL parts into according properties;
        $this->url_controller = (isset($url[0]) ? $url[0] : null);
        $this->url_action = (isset($url[1]) ? $url[1] : null);
        $this->url_parameter_1 = (isset($url[2]) ? $url[2] : null);
        $this->url_parameter_2 = (isset($url[3]) ? $url[3] : null);
        $this->url_parameter_3 = (isset($url[4]) ? $url[4] : null); 
        }
    }
}


?>