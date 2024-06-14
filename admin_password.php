<!-- check_password.php -->
<?php
$master_password = "1234"; // 마스터 비밀번호 설정

if (isset($_GET['password'])) {
    $password = $_GET['password'];

    if ($password === $master_password) {
        // 비밀번호 일치 시, 관리자 페이지로 이동
        header("Location: admin.php");
        exit();
    } else {
        // 비밀번호 불일치 시, JavaScript로 팝업 창에서 오류 메시지 표시
        echo "<script>alert('비밀번호가 틀렸습니다. 해당 페이지는 관리자용입니다.');</script>";
        // 비밀번호를 입력한 페이지로 돌아가기
        echo "<script>window.history.back();</script>";
        exit();
    }
} else {
    // 비밀번호가 전송되지 않은 경우
    echo "<script>alert('비밀번호를 입력하세요.');</script>";
    // 비밀번호를 입력한 페이지로 돌아가기
    echo "<script>window.history.back();</script>";
    exit();
}
?>