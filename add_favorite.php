<?php
include 'db.php'; // DB 연결
session_start();

if (!isset($_POST['userId']) || !isset($_POST['contestId'])) {
    echo "필수 정보가 누락되었습니다 : (";
    exit;
}

$userId = $_POST['userId'];
$contestId = $_POST['contestId'];

// 중복 확인
$checkSql = "SELECT * FROM favorite_contests WHERE userid = ? AND contestnum = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("si", $userId, $contestId);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    echo "해당 공모전은 이미 관심 목록에 추가되었습니다 : )";
    $checkStmt->close();
    $conn->close();
    exit;
}
$checkStmt->close();

// 중복이 아니면 저장
$sql = "INSERT INTO favorite_contests (userid, contestnum) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $userId, $contestId);

if ($stmt->execute()) {
    echo "해당 공모전이 관심 목록에 추가되었습니다 : )";
} else {
    echo "오류: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
