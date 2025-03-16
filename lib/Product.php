<?php
require_once 'Database.php';

class Product {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function insert($nome, $descrizione, $prezzo, $quantita, $categoria) {
        $stmt = $this->db->prepare("INSERT INTO prodotti (nome, descrizione, prezzo, quantita, categoria) VALUES (:nome, :descrizione, :prezzo, :quantita, :categoria)");
        return $stmt->execute([
            ':nome' => $nome,
            ':descrizione' => $descrizione,
            ':prezzo' => $prezzo,
            ':quantita' => $quantita,
            ':categoria' => $categoria
        ]);
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM prodotti ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
