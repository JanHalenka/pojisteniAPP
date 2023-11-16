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
    
    public function returnCustomers(): array
    {
        return Db::queryAll('
            SELECT `customers_id`, `name`, `surname`, `tel`, `age`
            FROM `customers`
            ORDER BY `surname`, `name` ASC
        ');
    }
}
