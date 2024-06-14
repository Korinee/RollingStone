<?php
session_start();
include 'db.php';

if (!isset($_SESSION['userid'])) {
    echo json_encode(['success' => false, 'message' => '로그인이 필요합니다.']);
    exit;
}

$userid = $_SESSION['userid'];
$contest_id = $_POST['contest_id'];

try {
    $db = new PDO("mysql:host=localhost;dbname=rollingstone_db", "root", "park9570");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE FROM favorite_contests WHERE userid = :userid AND contestnum = :contestnum";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
    $stmt->bindParam(':contestnum', $contest_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => '관심 목록에서 삭제되었습니다.']);
    } else {
        echo json_encode(['success' => false, 'message' => '삭제할 항목을 찾을 수 없습니다.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => '데이터베이스 오류: ' . $e->getMessage()]);
}
?>