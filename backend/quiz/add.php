<?php

header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['quiz']) || !isset($data['options']) || !isset($data['answer'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid input data'
    ]);
    exit;
}

$quiz = $data['quiz'];
$options = $data['options'];
$answer = $data['answer'];

if (empty($quiz) || empty($options) || empty($answer)) {
    echo json_encode([
        'success' => false,
        'message' => 'Quiz, options, and answer cannot be empty'
    ]);
    exit;
}

if (!is_string($quiz)) {
    echo json_encode([
        'success' => false,
        'message' => 'Quiz must be a string'
    ]);
    exit;
}

if (!is_array($options) || count($options) < 2) {
    echo json_encode([
        'success' => false,
        'message' => 'Options must be an array with at least two items'
    ]);
    exit;
}

if (!is_string($answer)) {
    echo json_encode([
        'success' => false,
        'message' => 'Answer must be a string'
    ]);
    exit;
}

$allQuestion = [];
$file = '../data/questions.json';

if (file_exists($file)) {
    $allQuestion = json_decode(file_get_contents($file), true);
}

$allQuestion[] = [
    'quiz' => $quiz,
    'options' => $options,
    'answer' => $answer
];

file_put_contents($file, json_encode($allQuestion, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode([
    'success' => true,
    'message' => 'Quiz added successfully',
    'data' => [
        'quiz' => $quiz,
        'options' => $options,
        'answer' => $answer
    ]
]);
exit;
