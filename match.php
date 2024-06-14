<?php
session_start();
include 'db.php';

if (!isset($_SESSION['userid'])) {
    echo "<script>
        if (confirm('공모전 매칭 현황은 로그인 후 이용해주세요 : )')) {
            window.location.href = 'login.php';
        } else {
            window.location.href = 'index.php';
        }
    </script>";
    exit;
}

$userid = $_SESSION['userid'];

// 매칭 신청 개수 가져오기
$query_count = "SELECT COUNT(*) AS count FROM matches WHERE userid = ?";
$stmt_count = $conn->prepare($query_count);
$stmt_count->bind_param("s", $userid);
$stmt_count->execute();
$result_count = $stmt_count->get_result();
$match_count = $result_count->fetch_assoc()['count'];
$stmt_count->close();

// 매칭 신청 목록 가져오기
$query = "
    SELECT m.id, m.contest_id, m.userid, m.desired_members, m.current_members, c.title, c.img
    FROM matches m
    JOIN contests c ON m.contest_id = c.num
    WHERE m.userid = ?
    GROUP BY m.id, m.contest_id, m.userid, m.desired_members, m.current_members, c.title, c.img
";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();

$matches = [];
while ($row = $result->fetch_assoc()) {
    $matches[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공모전 매칭 현황 | ROLLING STONE</title>
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <style>
        body {
            background-color: #F5F5F5;
            font-family: 'Nunito Sans', sans-serif;
        }
        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: calc(100vh - 80px);
            padding: 20px;
        }
        h2 {
            font-weight: bold;
        }
        .divider {
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
        .match-detail {
            display: flex;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            width: 30%; /* 넓이를 줄임 */
        }
        .match-image img {
            width: 170px; /* 고정 너비 */
            height: 230px; /* 고정 높이 */
            object-fit: cover; /* 고정된 크기에 맞게 이미지 비율 유지 */
            margin-right: 20px; 
        }
        .match-info {
            flex-grow: 1;
            text-align: left;
        }
        .match-info h3 {
            font-size: 24px;
            font-weight: bold; /* 타이틀을 bold로 설정 */
            margin-bottom: 10px;
            margin-top:20px;
        }
        .match-info p {
            font-size: 16px;
            margin: 5px 0;
        }
        .match-info a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #000;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .match-info a:hover {
            background-color: #555;
        }
        .match-team-btn, .match-cancel-btn, .search-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #E53637;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .match-team-btn:hover, .match-cancel-btn:hover, .search-btn:hover {
            background-color: #C12F2F;
        }
    </style>
</head>
<body>
    <!-- Header Section Begin -->
    <?php include 'header.php'; ?>
    <!-- Header Section End -->

    <!-- Main Content Begin -->
    <div class="main-content">
        <div class="main-container">
            <h2>공모전 매칭 현황</h2><br>
            <h6><?php echo $_SESSION['username']; ?>님이 신청하신 공모전 매칭은 <?php echo $match_count; ?>개 입니다.</h6>
            <div class="divider"></div>
            <?php if (count($matches) == 0): ?>
                <p>매칭 신청한 공모전이 없습니다. 롤링스톤의 매칭 시스템을 이용해보세요 : )</p>
                <a href="contest_exhibit.php?category=전체" class="search-btn">공모전/대외활동 찾으러 가기 -></a>
            <?php else: ?>
                <?php foreach ($matches as $match): ?>
                    <div class="match-detail">
                        <div class="match-image">
                            <a href="contest_detail.php?contest_id=<?php echo $match['contest_id']; ?>"><img src="<?php echo $match['img']; ?>" alt="공모전 이미지"></a>
                        </div>
                        <div class="match-info">
                            <h3><?php echo $match['title']; ?></h3>
                            <p><strong>매칭 현황 :</strong> <?php echo $match['current_members']; ?> / <?php echo $match['desired_members']; ?></p>
                            <?php if ($match['current_members'] >= $match['desired_members']): ?>
                                <p style="color: green;">매칭이 성사되었습니다 : )</p>
                            <?php else: ?>
                                <p style="color: red;">매칭할 인원을 열심히 찾고 있습니다 : (</p>
                            <?php endif; ?>
                            <a href="match_team.php?contest_id=<?php echo $match['contest_id']; ?>" class="match-team-btn">매칭 확인</a>
                            <a href="match_cancel.php?contest_id=<?php echo $match['contest_id']; ?>" class="match-cancel-btn">매칭 취소</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <!-- Main Content End -->

    <!-- Footer Section Begin -->
    <?php include 'footer.php'; ?>
    <!-- Footer Section End -->
    
    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
