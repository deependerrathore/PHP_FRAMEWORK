<?php

class RegisterController extends Controller{
    
    /**
    * constructor will instantiate the view from parent controller
    * load the model
    */
    public function __construct($controller, $action){
        parent::__construct($controller,$action);
        $this->load_model('Users'); //load the Users model
    }
    
    public function logoutAction($params = ''){
        if ($params == 'all') {
            if(currentUser()){
                currentUser()->logoutAll();
            }
        }else{
            if(currentUser()){
                currentUser()->logout();
            }
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
        $this->view->render('register/register.1');
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
                if (password_verify(Input::get('oldpassword'),currentUser()->password)) {
                    $this->UsersModel->changePassword(currentUser()->id,$_POST);
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
    
    
        
        