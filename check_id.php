<?php
include 'db.php';

if (isset($_POST['userid'])) {
    $id = $_POST['userid'];

    // ID 중복 체크
    $sql = "SELECT userid FROM users WHERE userid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "이미 사용 중인 ID입니다.";
    } else {
        echo "사용 가능한 ID입니다.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID가 입력되지 않았습니다.";
}
?>
