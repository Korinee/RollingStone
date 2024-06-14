<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => '로그인이 필요합니다.']);
    exit;
}

$userId = $_SESSION['userid'];
$username = $_SESSION['username'];  // Assuming username is stored in session

// 연결 확인
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

$selectedFields = isset($_POST['fields']) ? $_POST['fields'] : [];

if (empty($selectedFields)) {
    echo json_encode(['status' => 'error', 'message' => '선택된 관심 분야가 없습니다.']);
    exit;
}

// 기존의 관심 분야 삭제
$query = "DELETE FROM user_interests WHERE userid = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('s', $userId);
    $stmt->execute();
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'DELETE prepare() failed: ' . htmlspecialchars($conn->error)]);
    exit;
}

// 새로운 관심 분야 삽입
$query = "INSERT INTO user_interests (userid, username, field) VALUES (?, ?, ?)";
if ($stmt = $conn->prepare($query)) {
    foreach ($selectedFields as $field) {
        $stmt->bind_param('sss', $userId, $username, $field);
        $stmt->execute();
    }
    $stmt->close();
    echo json_encode(['status' => 'success', 'message' => '관심 분야가 성공적으로 저장되었습니다.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'INSERT prepare() failed: ' . htmlspecialchars($conn->error)]);
}
?>