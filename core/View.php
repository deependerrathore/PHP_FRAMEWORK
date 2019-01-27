<?php 

namespace Core;

/**
 * Class View
 */
class View{
    protected $_head, $_body,$_siteTitle = SITE_TITLE, $_outputBuffer, $_layout = DEFAULT_LAYOUT;

    public function __construct(){
        
    }

    /**
     * @fun render @para $viewName = home/index ~ home/index.php 
     */
    public function render($viewName){
        $viewArray = explode('/',$viewName);
        $viewString = implode(DS,$viewArray);
        if (file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $viewString .'.php')) {
            include(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php');
            include(ROOT . DS . 'app' . DS . 'views' . DS . '_layout' . DS. $this->_layout . '.php');
        }else{
            die("This view {$viewName} does not exist");
        }
    }

    /**
     * @function  content @para $type = 'head' or 'body' 
     * @return private _head or _body
     */
    public function content($type){
        if($type == 'head'){
            return $this->_head;
        }elseif($type == 'body'){
            return $this->_body;
        }

        return false;
    }

    /**
     * Start the buffer for head and body
     */
    public function start($type){
        $this->_outputBuffer = $type;
        ob_start(); //start the output buffer
    }

    public function end(){
        if($this->_outputBuffer == 'head'){
            $this->_head = ob_get_clean(); //assigning the data to _head and cleaning the ob
        }elseif($this->_outputBuffer == 'body'){
            $this->_body = ob_get_clean(); //assigning the data to _body and cleaning the ob
        }else{
            die('You must first the the strat method');
        }
    }

    /**
     * get title
     */
    public function getSiteTitle(){
        return $this->_siteTitle;
    }
    
    /**
     * set title other than which is set in config/config.php
     * default = MVC_FRAMEWORK
     */
    public function setSiteTitle($title){
        $this->_siteTitle = $title;
    }

    /**
     * If we want to change the default layout 
     * Default layout set in config/config = 'default'
     */
    public function setLayout($path){
        $this->_layout = $path;
    }

    public function insert($path){
        include(ROOT. DS . 'app' . DS . 'views' . DS . $path . '.php' );
    }

    
    public function partial($group,$partial){
        include(ROOT. DS . 'app' . DS . 'views' . DS . $group . DS . 'partials' . DS . $partial . '.php' );
    }

}