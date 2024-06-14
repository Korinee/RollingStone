<?php
session_start();
include 'db.php';

// 데이터베이스 연결 상태 확인
if ($conn->connect_error) {
    die("데이터베이스 연결 실패: " . $conn->connect_error);
}

// 로그인 여부 확인 (세션 변수 이름 수정)
if (!isset($_SESSION['userid'])) {
    echo "<script>
        alert('해당 기능은 로그인이 필요합니다. 로그인 후 이용해주세요 : )');
        window.location.href = 'login.php';
    </script>";
    exit;
}

// 댓글 id 가져오기
$comment_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 댓글 삭제
$delete_sql = "DELETE FROM comments WHERE id = ? AND user_id = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("is", $comment_id, $_SESSION['userid']);

if ($delete_stmt->execute()) {
    // 삭제 성공 시 이전 페이지로 리다이렉트
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
} else {
    // 삭제 실패 시 오류 메시지 출력
    echo "댓글 삭제 중 오류가 발생했습니다.";
}

$delete_stmt->close();
$conn->close();
?>
