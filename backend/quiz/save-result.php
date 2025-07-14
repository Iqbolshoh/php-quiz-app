<?php

header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['score']) || !isset($data['total']) || !isset($data['percentage'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid input data'
    ]);
    exit;
}

$score = $data['score'];
$total = $data['total'];
$percentage = $data['percentage'];

if (empty($score) || empty($total) || empty($percentage)) {
    echo json_encode([
        'success' => false,
        'message' => 'Score, total, and percentage cannot be empty'
    ]);
    exit;
}

if (!is_numeric($score) || $score < 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Score must be a non-negative number'
    ]);
    exit;
}

if (!is_numeric($total) || $total <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Total must be a positive number'
    ]);
    exit;
}

if (!is_numeric($percentage) || $percentage < 0 || $percentage > 100) {
    echo json_encode([
        'success' => false,
        'message' => 'Percentage must be a number between 0 and 100'
    ]);
    exit;
}

$file = '../data/quiz_result.json';
$allResults = [];

if (file_exists($file) && filesize($file) > 0) {
    $allResults = json_decode(file_get_contents($file), true);
}

$result = [
    'score' => $score,
    'total' => $total,
    'percentage' => $percentage,
    'timestamp' => date('Y-m-d H:i:s')
];

$allResults[] = $result;

file_put_contents($file, json_encode($allResults, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode([
    'success' => true,
    'message' => 'Quiz result saved successfully',
    'result' => $result
]);
exit;