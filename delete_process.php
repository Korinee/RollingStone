<?php
session_start(); // 세션 시작
include 'db.php';

$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 게시물 조회
$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();
$stmt->close();

// 게시물이 존재하지 않을 경우 처리
if (!$post) {
    echo "<script>alert('존재하지 않는 게시물입니다.'); window.history.back();</script>";
    exit;
}

// 현재 로그인한 사용자의 ID 가져오기
$user_id = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;

// 현재 로그인한 사용자의 ID와 게시물 작성자의 ID가 같은지 확인
if ($user_id == $post['user_id']) {
    // 트랜잭션 시작
    $conn->begin_transaction();

    try {
        // 댓글 삭제
        $delete_comments_sql = "DELETE FROM comments WHERE post_id = ?";
        $delete_comments_stmt = $conn->prepare($delete_comments_sql);
        $delete_comments_stmt->bind_param("i", $post_id);
        $delete_comments_stmt->execute();
        $delete_comments_stmt->close();

        // 게시물 삭제
        $delete_post_sql = "DELETE FROM posts WHERE id = ?";
        $delete_post_stmt = $conn->prepare($delete_post_sql);
        $delete_post_stmt->bind_param("i", $post_id);
        $delete_post_stmt->execute();
        $delete_post_stmt->close();

        // 트랜잭션 커밋
        $conn->commit();

        header("Location: board.php");
        exit();
    } catch (Exception $e) {
        // 트랜잭션 롤백
        $conn->rollback();
        echo "<script>alert('게시물 삭제 중 오류가 발생했습니다.'); window.history.back();</script>";
        exit();
    }
} else {
    echo "<script>alert('해당 게시물의 작성자가 아닙니다. 게시물 삭제의 권한이 없습니다.'); window.history.back();</script>";
    exit;
}
?>
