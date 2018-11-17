<?php

class Profile extends Controller{
    /**
     * Handles all of the user profile actions
     */
    public function __construct($controller, $action)
    {
        parent::__construct($controller,$action);
        $this->load_model('Users');
        $this->view->setLayout('default');
    }

    public function changepasswordAction(){
        $validation = new Validate();
        $posted_values = ['oldpassword' =>'','newpassword'=>'','confirmnewpassword' => ''];

        if($_POST){
            $posted_values = posted_values($_POST);
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
                    $this->UsersModel->changePassword($_POST);
                    Router::redirect('');
                }else{
                    $validation->addError("There is something wrong with your current password.");
                }
            }
        }
        
        $this->view->displayErrors = $validation->displayErrors();
        $this->view->render('profile/changepassword');
    }
}