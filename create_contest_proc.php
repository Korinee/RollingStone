<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>
    alert('공모전 등록 기능은 회원만 가능합니다. 로그인 후 사용 가능합니다 : )');
    location.href = 'login.php';
    </script>";
    exit;
}

// 데이터베이스 연결
include 'db.php';

// 폼에서 전달된 데이터 받기
$img = $_POST['img'];
$title = $_POST['title'];
$organizer = $_POST['organizer'];
$field = $_POST['field'];
$homepage = $_POST['homepage'];
$start_day = $_POST['start_day'];
$finish_day = $_POST['finish_day'];

// 데이터베이스에 데이터 삽입
$query = "INSERT INTO contests (img, title, organizer, field, homepage, start_day, finish_day)
          VALUES ('$img', '$title', '$organizer', '$field', '$homepage', '$start_day', '$finish_day')";

if (mysqli_query($conn, $query)) {
    echo "<script>
    alert('등록하신 공모전을 롤링스톤에서 찾아 볼 수 있습니다 : )');
    location.href = 'contest_exhibit.php?category=전체'; // 공모전 목록 페이지로 리디렉션
    </script>";
} else {
    echo "<script>
    alert('공모전 등록 중 오류가 발생했습니다. 다시 시도해주세요 : (');
    location.href = 'create_contest.php';
    </script>";
}

// 데이터베이스 연결 종료
mysqli_close($conn);
?>
