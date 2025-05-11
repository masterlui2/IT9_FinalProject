<?php

namespace App\Helpers;

use PDO;
use PDOException;

class DatabaseHelper
{
    /**
     * Get a direct PDO connection bypassing Laravel's authentication
     * 
     * @return PDO
     * @throws PDOException
     */
    public static function getDirectConnection()
    {
        // Get database credentials from Laravel's config
        $config = config('database.connections.mysql');
        
        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
        
        try {
            return new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            throw new PDOException("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Quick query execution bypassing Laravel's ORM
     * 
     * @param string $sql
     * @param array $params
     * @return array
     */
    public static function quickQuery($sql, $params = [])
    {
        $pdo = self::getDirectConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Quick insert bypassing Laravel's ORM
     * 
     * @param string $table
     * @param array $data
     * @return int Last insert ID
     */
    public static function quickInsert($table, $data)
    {
        $pdo = self::getDirectConnection();
        
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($data));
        
        return $pdo->lastInsertId();
    }
}