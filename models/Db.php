<?php
/**
 * Description of Db
 *
 * @author jan
 */
class Db {
    
    private static PDO $connection;
    private static array $settings = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false
    );
    
    public static function connect(string $host, string $user, string $password, string $database): void
    {
        if (!isset(self::$connection)) {
            self::$connection = @new PDO(
                    "mysql:host=$host;dbname=$database",
                    $user,
                    $password,
                    self::$settings
            );
        }
    }
    
    public static function querySingle(string $query, array $parameters = array()): array|bool
    {
        $result = self::$connection->prepare($query);
        $result->execute($parameters);
        return $result->fetch();
    }
    
    public static function queryAll(string $query, array $parameters = array()): array|bool
    {
        $result = self::$connection->prepare($query);
        $result->execute($parameters);
        return $result->fetchAll();
    }
    
    public static function querySolo(string $query, array $parameters = array()): string
    {
        $result = self::querySingle($query, $parameters);
        return $result[0];
    }
            
    public static function query(string $query, array $parameters = array()): int
    {
        $result = self::$connection->prepare($query);
        $result->execute($parameters);
        return $result->rowCount();
    }
    
    /**
     * Zapíše do požadované tabulky záznam dle vloženého pole hodnot
     * @param string $table Název tabulky
     * @param array $parameters Pole s hodnotami
     * @return bool
     */
    public static function insert(string $table, array $parameters = array()): bool
    {
        return self::query("INSERT INTO `$table` (`" .
            implode('`, `', array_keys($parameters)) .
            "`) VALUES (" . str_repeat('?,', sizeof($parameters)-1) .
            "?)", array_values($parameters)
        );
    }
    
    /**
     * Úprava existujícího záznamu v tabulce
     * @param string $table Název tabulky
     * @param array $values Pole s názvy sloupců
     * @param string $condition SQL podmínka změny
     * @param array $parameters Pole s hodnotami
     * @return bool
     */
    public static function edit(string $table, array $values, string $condition, array $parameters = array()): bool
    {
        return self::query("UPDATE `$table` SET `" .
            implode('` = ?, `', array_keys($values)) .
            "` = ? " . $condition,
            array_merge(array_values($values), $parameters)
        );
    }
    
    /**
     * Vrací IF posledního záznamu
     * @return int ID posledního záznamu
     */
    public static function lastId(): int
    {
        return self::$connection->lastInsertId();
    }
}
