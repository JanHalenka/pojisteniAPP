<?php

/**
 * Description of CustomersConctroller
 *
 * @author jan
 */
class CustomersController extends Controller {
    
    public function process(array $parameters): void {
        
        $adminOfCustomers = new AdminOfCustomers();
        $this->head = array(
                'title' => 'Pojištěnci',
                'keywords' => 'pojištěnci, aplikace, formulář',
                'description' => 'Hlavní formulář s pojištěnci',
        );
        
        $customers = $adminOfCustomers->returnCustomers();
        $this->data['customers'] = $customers;
        
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
        $this->view = 'customers';
    }
}
