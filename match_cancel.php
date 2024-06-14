<?php
session_start();
include 'db.php';

if (!isset($_SESSION['userid'])) {
    echo "<script>
        alert('로그인이 필요합니다.');
        window.location.href = 'login.php';
    </script>";
    exit;
}

if (isset($_GET['contest_id'])) {
    $contest_id = $_GET['contest_id'];
    $userid = $_SESSION['userid'];

    // 매칭 정보 가져오기
    $query_match = "SELECT id, desired_members FROM matches WHERE contest_id = ? AND userid = ?";
    $stmt_match = $conn->prepare($query_match);
    $stmt_match->bind_param("is", $contest_id, $userid);
    $stmt_match->execute();
    $result_match = $stmt_match->get_result();

    if ($result_match->num_rows > 0) {
        $match = $result_match->fetch_assoc();
        $match_id = $match['id'];
        $desired_members = $match['desired_members'];

        $stmt_match->close();

        // 매칭 삭제
        $query_delete = "DELETE FROM matches WHERE id = ? AND userid = ?";
        $stmt_delete = $conn->prepare($query_delete);
        $stmt_delete->bind_param("is", $match_id, $userid);

        if ($stmt_delete->execute()) {
            // 해당 contest_id의 매칭 개수 가져오기
            $query_count_matches = "SELECT COUNT(*) AS match_count FROM matches WHERE contest_id = ?";
            $stmt_count_matches = $conn->prepare($query_count_matches);
            $stmt_count_matches->bind_param("i", $contest_id);
            $stmt_count_matches->execute();
            $result_count_matches = $stmt_count_matches->get_result();

            if ($result_count_matches->num_rows > 0) {
                $row = $result_count_matches->fetch_assoc();
                $current_members = $row['match_count'];

                $update_query = "UPDATE matches SET current_members = ? WHERE contest_id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("ii", $current_members, $contest_id);
                $update_stmt->execute();
                $update_stmt->close();
            }

            echo "<script>
                alert('매칭이 취소되었습니다. 다른 공모전에 매칭을 신청해보세요 : )');
                window.location.href = 'match.php';
            </script>";
        } else {
            echo "오류: " . $stmt_delete->error;
        }

        $stmt_delete->close();
    } else {
        echo "매칭 정보를 찾을 수 없습니다.";
    }
} else {
    echo "공모전 ID가 제공되지 않았습니다.";
}

$conn->close();
?>
