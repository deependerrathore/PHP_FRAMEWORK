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
    
    public function logoutAction(){
        if(currentUser()){
            currentUser()->logout();
        }

        Router::redirect('register/login');
    }

    public function registerAction(){
        $validation = new Validate();

        $posted_values = ['fname'=>'','lname'=>'','email'=>'','username'=>'','password'=>'','confirm'=>'',];
        if($_POST){
            $posted_values = posted_values($_POST);
            $validation->check($_POST,[
                'fname' => [
                    'display' => 'First Name',
                    'required' => true
                ],
                'lname' => [
                    'display' => 'Last Name',
                    'required' => true
                ],
                'email' => [
                    'display' => 'Email',
                    'required' => true,
                    'unique' =>'users',
                    'min' => 6,
                    'max' => 150,
                    'valid_email' => true
                ],
                'username' => [
                    'display' => 'Username',
                    'required' => true,
                    'unique' =>'users',
                    'min' => 6,
                    'max' => 150,
                    'valid_username' => true
                ],
                'password' => [
                    'display' => 'Password',
                    'required' => true,
                    'min' => 6
                ],
                'confirm' => [
                    'display' => 'Confirm Password',
                    'required' => true,
                    'matches' => 'password'
                ]
            ]);

            if($validation->passed()){
                $newUser = new Users();
                $newUser->registerNewUser($_POST);
                Router::redirect('register/login');
            }
        }
        $this->view->post = $posted_values;
        $this->view->displayErrors = $validation->displayErrors();
        $this->view->render('register/register');
    }
    public function loginAction(){
        
        $validation = new Validate();
        
        if($_POST){
            //form validation 
            
            
            $validation->check($_POST,[
                'username' =>[
                    'display' =>"Username",
                    'required' => true
                ],
                'password' => [
                    'display' => "Password",
                    'required' => true,
                    'min' => 6,
                    'max' => 20
                    ]
                    ]);
                    
                    if($validation->passed()){
                        
                        //we are defining UsersModel in Controller
                        $user = $this->UsersModel->findByUsername($_POST['username']);
                        
                        if($user && password_verify(Input::get('password'),$user->password)){
                            $remember = (isset($_POST['remember_me']) && Input::get('remember_me')) ? true : false;
                            $user->login($remember); //since $user is the object we can call method on it
                            Router::redirect('');
                        }else{
                            $validation->addError("There is something wrong with your username or password.");
                        }
                    }
                }
                $this->view->displayErrors = $validation->displayErrors();
                $this->view->render('register/login');
            }
        }
    
        
        