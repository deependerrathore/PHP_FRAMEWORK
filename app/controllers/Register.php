<?php

class Register extends Controller{

    /**
     * constructor will instantiate the view from parent controller
     * load the model
     */
    public function __construct($controller, $action){
        parent::__construct($controller,$action);
        $this->load_model('Users'); //load the Users model
        $this->view->setLayout('default');
    }

    public function loginAction(){

        if($_POST){
            //form validation 
            $validation = true;

            if($validation === true){

                //we are defining UsersModel in Controller
                $user = $this->UsersModel->findByUsername($_POST['username']);

                if($user && password_verify(Input::get('password'),$user->password)){
                    $remember = (isset($_POST['remember_me']) && Input::get('remember_me')) ? true : false;
                    $user->login($remember); //since $user is the object we can call method on it
                }
            }
        }
        $this->view->render('register/login');
    }
}
