<?php
class Database {
    private static $host = 'localhost';
    private static $dbname = 'crud_mvc';
    private static $username = 'root';
    private static $password = '';
    private static $connection = null;
    
    public static function getConnection() {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbname,
                    self::$username,
                    self::$password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                    ]
                );
            } catch(PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
?>