<?php
session_start();
include 'db.php';  // 데이터베이스 연결 파일 포함

// 폼에서 전송된 데이터 받기
$username = $_POST['username'];
$userid = $_POST['userid'];
$password = $_POST['password'];
$email = $_POST['email'] . '@' . $_POST['custom_email'];
$phone = $_POST['phone'];

// 데이터 검증
if (empty($username) || empty($userid) || empty($password) || empty($email) || empty($phone)) {
    die("모든 필드를 입력하세요.");
}

// 비밀번호 암호화
$hashed_pw = password_hash($password, PASSWORD_DEFAULT);

// 데이터베이스에 삽입
$sql = "INSERT INTO users (username, userid, password, email, phone) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $username, $userid, $hashed_pw, $email, $phone);

if ($stmt->execute()) {
    // 회원가입 성공
    echo "<script>
    alert('롤링스톤에 회원가입 해주셔서 감사합니다. 자주 방문해주세요 : )');
    location.href = 'login.php';
    </script>";
} else {
    // 회원가입 실패
    echo "<script>
    alert('회원가입 중 오류가 발생했습니다. 다시 시도해주세요.');
    history.back();
    </script>";
}

$stmt->close();
$conn->close();
?>
