<?php 

class ContactsController extends Controller{
    public function __construct($controller, $action){
        parent::__construct($controller,$action);
        $this->load_model('Contacts');
    }

    public function indexAction(){
        $contacts = $this->ContactsModel->getAllByUserId(currentUser()->id,['order'=>'lname,fname']);
        $this->view->contacts = $contacts;
        $this->view->render('contacts/index');
    }
}