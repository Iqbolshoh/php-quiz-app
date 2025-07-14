<?php

header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid input data'
    ]);
    exit;
}

$id = $data['id'];

if (empty($id) || !is_numeric($id) || $id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'ID must be a positive number'
    ]);
    exit;
}

$allQuestion = [];
$file = '../data/questions.json';

if (file_exists($file)) {
    $allQuestion = json_decode(file_get_contents($file), true);
}

foreach ($allQuestion as $key => $question) {
    if ($question['id'] == $id) {
        unset($allQuestion[$key]);

        $allQuestion = array_values($allQuestion);

        file_put_contents($file, json_encode($allQuestion, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo json_encode([
            'success' => true,
            'message' => 'Question deleted successfully'
        ]);
        exit;
    }
}

echo json_encode([
    'success' => false,
    'message' => 'Question not found'
]);
exit;
