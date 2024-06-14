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

// 로그인된 사용자의 사용자 이름과 아이디 가져오기 (변수 이름 수정)
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$user_id = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && $user_name !== '') {
    $post_id = intval($_POST['post_id']);
    $content = filter_var(trim($_POST['content']), FILTER_SANITIZE_STRING);

    if (empty($content)) {
        echo "댓글을 입력해주세요 : )";
        exit;
    }

    $comment_sql = "INSERT INTO comments (post_id, user_id, user_name, content) VALUES (?, ?, ?, ?)";
    $comment_stmt = $conn->prepare($comment_sql);

    if ($comment_stmt === false) {
        die("오류: SQL 문 준비 실패: " . $conn->error);
    }

    $comment_stmt->bind_param("isss", $post_id, $user_id, $user_name, $content);

    if ($comment_stmt->execute()) {
        header("Location: view_post.php?id=$post_id");
        exit;
    } else {
        echo "오류: SQL 문 실행 실패: " . $comment_stmt->error;
    }
    $comment_stmt->close();
} else {
    echo "오류: 요청이 올바르지 않습니다.";
}

$conn->close();
?>
