<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../lib/Database.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $formData = [];
    foreach ($_POST as $key => $value) {
        $formData[$key] = trim($value);
    }

    if (!empty($formData)) {
        $fields = array_keys($formData);
        $placeholders = array_map(fn($field) => ':' . $field, $fields);

        $sql = sprintf(
            "INSERT INTO prodotti (%s) VALUES (%s)",
            implode(', ', $fields),
            implode(', ', $placeholders)
        );

        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare($sql);

            foreach ($formData as $field => $value) {
                $stmt->bindValue(':' . $field, $value);
            }

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
