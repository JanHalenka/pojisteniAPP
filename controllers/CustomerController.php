<?php

/**
 * Description of CustomerController
 *
 * @author jan
 */
class CustomerController extends Controller
{
    public function process(array $parameters): void {
        
        $adminOfCustomers = new AdminOfCustomers();
    
        if (!empty($parameters[0])) {
            $customer = $adminOfCustomers->returnCustomer($parameters[0]);
            if (!$customer) {
                $this->redirect('error');
            }

            $this->head = array(
                'title' => $customer['customers_id'],
                'keywords' => $customer['surname'] . ', ' . $customer['tel'],
                'description' => 'Pojistenec ' . $customer['customers_id'],
            );

            $this->data['customers_id'] = $customer['customers_id'];
            $this->data['name'] = $customer['name'];
            $this->data['surname'] = $customer['surname'];
            $this->data['tel'] = $customer['tel'];
            $this->data['age'] = $customer['age'];

            $this->view = 'customer';
        } else {
            $customers = $adminOfCustomers->returnCustomers();
            $this->data['customers'] = $customers;
            $this->view = 'customers';
        }
    }
}
