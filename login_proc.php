<?php
session_start();
include 'db.php';  // 데이터베이스 연결 파일 포함

// 폼에서 전송된 데이터 받기
$userid = $_POST['id'];
$password = $_POST['pw'];

// 데이터 검증
if (empty($userid) || empty($password)) {
    die("아이디와 비밀번호를 모두 입력하세요.");
}

// 데이터베이스에서 사용자 정보 확인
$sql = "SELECT * FROM users WHERE userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // 비밀번호 확인
    if (password_verify($password, $row['password'])) {
        // 로그인 성공
        $_SESSION['userid'] = $row['userid'];
        $_SESSION['username'] = $row['username'];
        $username = $row['username'];  // 여기서 $username 변수에 값을 설정
        echo "<script>
        alert('$username($userid)님 로그인되었습니다. 롤링스톤에 오신것을 환영합니다 : )');
        location.href = 'index.php';
        </script>";
    } else {
        // 비밀번호 불일치
        echo "<script>
        alert('비밀번호가 올바르지 않습니다.');
        history.back();
        </script>";
    }
} else {
    // 아이디 불일치
    echo "<script>
    alert('아이디가 올바르지 않습니다.');
    history.back();
    </script>";
}

$stmt->close();
$conn->close();
?>
