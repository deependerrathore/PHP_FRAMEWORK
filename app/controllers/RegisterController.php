<?php

namespace App\Controllers;
use Core\Controller;
use Core\Router;
use Core\H;
use App\Models\Users;
use App\Models\Login;
class RegisterController extends Controller{
    
    /**
    * constructor will instantiate the view from parent controller
    * load the model
    */
    public function __construct($controller, $action){
        parent::__construct($controller,$action);
        $this->load_model('Users'); //load the Users model
    }
    
    public function logoutAction($params = []){
        $forAllDevice = false;
        if (Users::currentUser()) {
            if (!empty($params) && !$params[0] == '') {
                $forAllDevice = (strtolower($params[0]) === 'all') ? true : false;
                Users::currentUser()->logout($forAllDevice);
            }else{
                Users::currentUser()->logout($forAllDevice);
            }
        }
        Router::redirect('register/login');
    }
    
    
    public function registerAction(){
        
        $newUser = new Users();
        if($this->request->isPost()){
            $this->request->csrfCheck();

            $newUser->assign($this->request->get());

            $newUser->setConfirm($this->request->get('confirm'));
            if($newUser->save()){
                Router::redirect('register/login');
            }
            
        }
        $this->view->newUser = $newUser;
        $this->view->displayErrors = $newUser->getErrorMessages();
        $this->view->render('register/register.1');
    }
    
    
    public function loginAction(){
        $loginModel = new Login();

        if($this->request->isPost()){
            $this->request->csrfCheck();
            $loginModel->assign($this->request->get());
            $loginModel->validator();
            
            if($loginModel->validationPassed()){
                //we are defining UsersModel in Controller
                $user = $this->UsersModel->findByUsername($this->request->get('username'));

                if ($user && password_verify($this->request->get('password'), $user->password)) {
                    $remember = $loginModel->getRememberMeChecked();
                    $user->login($remember); //since $user is the object we can call method on it
                    Router::redirect('');
                } else {
                    $loginModel->addErrorMessage("username","There is something wrong with your username or password.");
                }
            }
            
            
        }   
            $this->view->postAction = PROJECT_ROOT . 'register/login';
            $this->view->login = $loginModel;
            $this->view->displayErrors = $loginModel->getErrorMessages();
            $this->view->render('register/login');
    }
        
        public function changepasswordAction(){
            $validation = new Validate();
            
            
            if($_POST){
                $validation->check($_POST,[
                    'oldpassword' => [
                        'display' => 'Old Password',
                        'required' => true
                    ],
                    'newpassword' => [
                        'display' => 'New Password',
                        'required' => true,
                        'not_matches' => 'oldpassword'
                    ],
                    'confirmnewpassword' => [
                        'display' => 'Comfirm New Password',
                        'required' => true,
                        'matches' => 'newpassword'
                        ]
                        ]);
                        
                        if($validation->passed()){
                            if (password_verify(Input::get('oldpassword'),Users::currentUser()->password)) {
                                $this->UsersModel->changePassword(Users::currentUser()->id,$_POST);
                                Router::redirect('');//Need to add alert message
                            }else{
                                $validation->addError("There is something wrong with your current password.");
                            }
                        }
                    }
                    $this->view->displayErrors = $validation->displayErrors();
                    $this->view->render('register/changepassword');
                }
                
                public function forgotpasswordAction(){
                    $validation = new Validate();
                    
                    if($_POST){
                        
                        $validation->check($_POST,[
                            'email' => [
                                'display' => 'Email',
                                'required' => true,
                                'min' => 6,
                                'max' => 150,
                                'valid_email' => true
                                ]
                                ]);
                                
                                if ($validation->passed()) {
                                    $user = $this->UsersModel->findByEmail($_POST['email']);
                                    if($user->email != NULL || $user->email != ''){
                                        $passwordTokenObj = new PasswordTokens();
                                        $passwordTokenObj->savePasswordToken($user->id);
                                        Router::redirect(''); //Need to add alert message
                                    }else{
                                        $validation->addError("Email Address not found.Please check your email address again.");
                                    }
                                }
                            }
                            
                            $this->view->displayErrors = $validation->displayErrors();
                            $this->view->render('register/forgotpassword');
                            
                        }
                        
                        public function resetpasswordAction(){
                            $validation = new Validate();
                            
                            if (isset($_GET['token'])) {
                                $token = $_GET['token'];
                                $passwordTokenObj = new PasswordTokens();
                                $tokenData = $passwordTokenObj->findfirst([
                                    'conditions' => ['token =?'],
                                    'bind' => [sha1($token)]
                                    ]); 
                                    if($_POST){
                                        $validation->check($_POST,[
                                            'newpassword' => [
                                                'display' => 'New Password',
                                                'required' => true,
                                            ],
                                            'confirmnewpassword' => [
                                                'display' => 'Comfirm New Password',
                                                'required' => true,
                                                'matches' => 'newpassword'
                                                ]
                                                ]); 
                                                if($validation->passed()){
                                                    if($tokenData && (sha1($_GET['token']) == $tokenData->token)){
                                                        $this->UsersModel->changePassword($tokenData->user_id,$_POST);
                                                        $passwordTokenObj->delete($tokenData->id);
                                                        Router::redirect('');//Need to add alert message
                                                    }else{
                                                        $validation->addError("Invalid Token. Please try again.");
                                                    }
                                                }
                                                
                                            }
                                            $this->view->token = $token;
                                            $this->view->displayErrors = $validation->displayErrors();
                                            $this->view->render('register/resetpassword');
                                            
                                        }else{
                                            Router::redirect('restircted');
                                        }
                                        
                                        
                                        
                                        
                                    }
                                    
                                }
                                
                                
                                
                                