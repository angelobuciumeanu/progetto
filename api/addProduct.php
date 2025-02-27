<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../lib/Database.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Raccogli tutti i dati del form
    $formData = [];
    foreach ($_POST as $key => $value) {
        $formData[$key] = trim($value);
    }

    // Verifica se ci sono dati nel form
    if (!empty($formData)) {
        // Estrai i nomi dei campi e i valori
        $fields = array_keys($formData);
        $placeholders = array_map(function($field) { return ':' . $field; }, $fields);

        // Costruisci la query SQL dinamicamente
        $sql = sprintf(
            "INSERT INTO prodotti (%s) VALUES (%s)",
            implode(', ', $fields),
            implode(', ', $placeholders)
        );

        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare($sql);

            // Associa i valori ai placeholder
            foreach ($formData as $field => $value) {
                $stmt->bindValue(':' . $field, $value);
            }

            // Esegui la query
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Prodotto inserito con successo';
            } else {
                $response['message'] = 'Errore durante l\'inserimento';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Errore di database: ' . $e->getMessage();
        }
    } else {
        $response['message'] = 'Nessun dato inviato';
    }
} else {
    $response['message'] = 'Metodo non valido';
}

echo json_encode($response);
?>
