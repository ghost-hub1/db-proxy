<?php
header('Content-Type: application/json');

try {
    $dsn = "mysql:host=mysql-emp-paylocity0-00.b.aivencloud.com;port=16646;dbname=defaultdb";
    $username = "avnadmin";
    $password = "AVNS_XTwQCB7wiuay88BHwOB";

    // optional SSL if required by Aiven
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_SSL_CA => __DIR__ . '/ca.pem'
    ];

    $pdo = new PDO($dsn, $username, $password, $options);

    // Sample query - you can adjust or generalize it
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare($data['query']);
        $stmt->execute($data['params'] ?? []);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $result]);
    } else {
        echo json_encode(['success' => false, 'message' => 'POST only']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
