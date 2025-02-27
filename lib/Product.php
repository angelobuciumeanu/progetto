<?php
require_once 'Database.php';

class Product {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function insert($nome, $prezzo) {
        $stmt = $this->db->prepare("INSERT INTO prodotti (nome, prezzo) VALUES (:nome, :prezzo)");
        return $stmt->execute([':nome' => $nome, ':prezzo' => $prezzo]);
    }
    
    // Puoi aggiungere metodi per aggiornare, cancellare o recuperare prodotti
}
