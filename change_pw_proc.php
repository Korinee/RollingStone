<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['userid']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['newPassword'])) {
        $username = $_POST['username'];
        $userid = $_POST['userid'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $newPassword = $_POST['newPassword'];

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $sql = "SELECT * FROM users WHERE username = ? AND userid = ? AND email = ? AND phone = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $userid, $email, $phone);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $updateSql = "UPDATE users SET password = ? WHERE username = ? AND userid = ? AND email = ? AND phone = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("sssss", $hashedPassword, $username, $userid, $email, $phone);
            $updateStmt->execute();

            echo "<script>alert('비밀번호가 변경되었습니다! 로그인을 다시 해보세요 : )'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('입력하신 정보로 일치하는 사용자를 찾을 수 없습니다. 항목들을 모두 작성하였는지 확인해주세요.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('입력하신 정보로 일치하는 사용자를 찾을 수 없습니다. 항목들을 모두 작성하였는지 확인해주세요.'); window.history.back();</script>";
    }
}
?>