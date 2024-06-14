<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => '로그인이 필요합니다.']);
    exit;
}

$userId = $_SESSION['userid'];

// 연결 확인
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// 기존의 관심 분야 삭제
$query = "DELETE FROM user_interests WHERE userid = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('s', $userId);
    if ($stmt->execute()) {
        $stmt->close();
        echo json_encode(['status' => 'success', 'message' => '관심 분야가 초기화되었습니다.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'DELETE execute() failed: ' . htmlspecialchars($conn->error)]);
        $stmt->close();
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'DELETE prepare() failed: ' . htmlspecialchars($conn->error)]);
}
?>
