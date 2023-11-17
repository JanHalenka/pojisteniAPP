<?php

/**
 * Description of AdminOfCustomers
 *
 * @author jan
 */
class AdminOfCustomers {
    
    /**
     * Vrátí pojištěnce z databáze pojištěnců na základě id v databázi
     * @param string $id customer_id v databázi
     * @return array Záznam z databáze
     */
    public function returnCustomer(string $id): array|bool
    {
        return Db::querySingle('
            SELECT `customers_id`, `name`, `surname`, `tel`, `age`
            FROM `customers`
            WHERE `customers_id` = ?                
        ', array($id));
    }
    
    /**
     * Vrací všechny pojištěnce z databáze pojištěnců
     * @return array Pole pojištěnců
     */
    public function returnCustomers(): array
    {
        return Db::queryAll('
            SELECT `customers_id`, `name`, `surname`, `tel`, `age`
            FROM `customers`
            ORDER BY `surname`, `name` ASC
        ');
    }
    
    /**
     * Edituje nebo vloží záznam v tabulce pojištěnců
     * @param int|bool $id ID záznamu v tabulce
     * @param array $customer Záznam k editaci/vložení
     * @return void
     */
    public function addCustomer(int|bool $id, array $customer): void
    {
        if (!$id) {
            Db::insert('customers', $customer);
        } else {
            Db::edit('customers', $customer, 'WHERE customers_id = ?', array($id));
        }
    }
    
    /**
     * Odstraní záznam z tabulky pojištěnců
     * @param int $id
     * @return void
     */
    public function deleteCustomer(int $id): void
    {
        Db::query(
        'DELETE FROM customers WHERE customers_id = ?',
                array($id)                
        );
    }
}
