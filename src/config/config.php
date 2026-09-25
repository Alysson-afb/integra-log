<?php
class Config {
    public static function conexaoPDO(): object {
        $db_host = '127.0.0.1';
        $db_name = 'IntegraLogDB';
        $db_usuario = 'root';
        $db_senha = '';

        try {
            $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_usuario, $db_senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo 'Conexão falhou: ' . $e->getMessage();
            exit;
        }
    }
    
}
