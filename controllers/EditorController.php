<?php

/**
 * Description of EditorController
 *
 * @author jan
 */
class EditorController extends Controller {
    
    public function process(array $parameters): void
    {
        $this->head['title'] = 'Editor klientů';
        $adminOfCustomers = new AdminOfCustomers();
        
        $customer = array(
            'customers_id' => '',
            'name' => '',
            'surname' => '',
            'tel' => '',
            'age' => '',
        );
        if ($_POST) {
            if (isset($_POST['name']) && $_POST['name'] &&
                isset($_POST['surname']) && $_POST['surname'] &&
                isset($_POST['age']) && $_POST['age'] &&
                isset($_POST['tel']) && $_POST['tel']
            ) {
                $keys = array('name', 'surname', 'tel', 'age');
                $customer = array_intersect_key($_POST, array_flip($keys));
                
                $adminOfCustomers->addCustomer('', $customer);
                $this->addMessage('Záznam byl úspěšně uložen.');
                $this->redirect('customer');                
            } else {
                $this->addMessage('Formulář nebyl správně vyplněn.');
            }
        }
        
        $this->data['customer'] = $customer;
        $this->view = 'editor';                
    }
}
