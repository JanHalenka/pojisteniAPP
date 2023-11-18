<?php

/**
 * Description of EditorController
 *
 * @author jan
 */
class EditorController extends Controller {
    
    public function process(array $parameters): void
    {
        $message = '';
        $this->head['title'] = 'Editor klientů';
        $adminOfCustomers = new AdminOfCustomers();
        $customer = array(
            'customers_id' => '',
            'name' => '',
            'surname' => '',
            'tel' => '',
            'age' => '',
            'message' => '',
        );
        if ($_POST) {
            if (isset($_POST['name']) && $_POST['name'] &&
                isset($_POST['surname']) && $_POST['surname'] &&
                isset($_POST['age']) && $_POST['age'] &&
                isset($_POST['tel']) && $_POST['tel']
            ) {
                    $pojistenec = $_POST['name'] . $_POST['surname'] . $_POST['age'] . $_POST['tel'];
                    echo($pojistenec);
            } else {
                $customer['message'] = "Formulář nebyl správně vyplněn.";
            }
        }
        
        $this->data['customer'] = $customer;
        $this->view = 'editor';                
    }
}