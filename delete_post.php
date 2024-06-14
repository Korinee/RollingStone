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
    echo "<script>
            if(confirm('해당 게시물의 작성자입니다. 해당 게시물을 삭제하시겠습니까?')) {
                window.location.href = 'delete_process.php?id=$post_id'; // 삭제 프로세스로 이동
            } else {
                window.history.back(); // 이전 페이지로 되돌아감
            }
          </script>";
} else {
    echo "<script>alert('해당 게시물의 작성자가 아닙니다. 게시물 삭제의 권한이 없습니다.'); window.history.back();</script>";
    exit;
}
?>
