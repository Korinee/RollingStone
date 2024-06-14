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

// URL에서 contest_id 매개변수를 가져옴
if (isset($_GET['contest_id'])) {
    $contest_id = $_GET['contest_id'];

    // contest_id를 사용하여 공모전의 상세 정보를 가져옴
    $query = "SELECT * FROM contests WHERE num = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $contest_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // 공모전 정보가 있는 경우 표시
    if ($result->num_rows > 0) {
        $contest = $result->fetch_assoc();
    } else {
        echo "해당 공모전을 찾을 수 없습니다.";
        exit; // 해당 공모전이 없으면 페이지를 종료
    }
    $stmt->close();
} else {
    echo "공모전 ID가 제공되지 않았습니다.";
    exit; // contest_id가 전달되지 않으면 페이지를 종료
}

// 홈페이지 링크 가져오기
$homepage = $contest['homepage'];

if (isset($_GET['contest_id'])) {
    $contest_id = $_GET['contest_id'];
    $current_user_id = $_SESSION['userid'];

    // 매칭된 사용자 정보를 가져옴
    $query = "SELECT u.username, u.userid, u.email, u.phone, ui.field
              FROM matches m
              JOIN users u ON m.userid = u.userid
              LEFT JOIN user_interests ui ON u.userid = ui.userid
              WHERE m.contest_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $contest_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $participants = [];
    while ($row = $result->fetch_assoc()) {
        if ($row['userid'] != $current_user_id) {
            if (!isset($participants[$row['userid']])) {
                $participants[$row['userid']] = [
                    'username' => $row['username'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'fields' => []
                ];
            }
            $participants[$row['userid']]['fields'][] = $row['field'];
        }
    }

    $stmt->close();
} else {
    echo "공모전 ID가 제공되지 않았습니다.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>매칭 팀원 목록 | ROLLING STONE</title>

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
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 80px);
            padding: 20px;
            flex-direction: column;
            margin-top: 1px;
            margin-bottom: 20px;
        }
        .contest-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .contest-box {
            display: flex;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 45%; 
            margin-bottom: 50px; 
            align-items: center; 
        }
        .contest-column {
            flex: 1;
            padding: 10px;
            text-align: center;
        }
        .contest-column img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .contest-detail-content {
            flex: 2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 10px;
        }
        .contest-detail-content p {
            font-size: 18px;
            margin: 5px 0;
        }
        .homepage-link {
            font-size: 18px;
            margin: 5px 0;
            display: block;
            text-decoration: none;
            color: #000;
            transition: color 0.3s ease;
        }
        .homepage-link:hover {
            color: #555;
        }
        .homepage-link:visited {
            color: #555; /* 방문한 링크 색 */
        }
        .homepage-link:hover,
        .homepage-link:active {
            color: #E53637; /* 호버 및 클릭 시 색 변경 */
        }
        .participant-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            width: 100%;
            margin-bottom: 10px; /* 푸터를 내리기 위한 여백 추가 */
        }
        .participant-box {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
            width: 280px;
            height: 200px;
            display: flex;
            text-align: center;
            flex-direction: column;
            justify-content: center;
            margin: 15px;
        }
        .participant-box p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <!-- Header Section Begin -->
    <?php include 'header.php'; ?>
    <!-- Header Section End -->

    <!-- Contest Detail Begin -->
    <div class="main-content">
        <div class="main-container">
            <h4 class="contest-title"><?php echo htmlspecialchars($contest['title']); ?></h4>
            <div class="contest-box">
                <div class="contest-column">
                    <img src="<?php echo htmlspecialchars($contest['img']); ?>" alt="공모전 이미지">
                </div>
                <div class="contest-detail-content">
                    <p><strong>주최/주관</strong> : <?php echo htmlspecialchars($contest['organizer']); ?></p>
                    <p><strong>관련 분야</strong> : <?php echo htmlspecialchars($contest['field']); ?></p>
                    <p><strong>접수 기간</strong> : <?php echo htmlspecialchars($contest['start_day'] . ' ~ ' . $contest['finish_day']); ?></p>
                    <?php
                        $today = date("Y-m-d");
                        $finish_date = new DateTime($contest['finish_day']);
                        $today_date = new DateTime($today);
                        $interval = $finish_date->diff($today_date);
                        $days_left = $interval->format('%a') - 1;
                    ?>
                    <p><strong>접수 마감</strong> : <?php echo htmlspecialchars($days_left); ?>일</p>
                    <p><strong>홈페이지</strong> : <a href="<?php echo htmlspecialchars($homepage); ?>" target="_blank" class="homepage-link"><?php echo htmlspecialchars($homepage); ?></a></p>
                </div>
            </div>
            <h4 class="contest-title">해당 공모전 매칭 팀원 목록</h4>
            <div class="participant-container">
                <?php if (count($participants) == 0): ?>
                    <p>매칭된 팀원이 없습니다.</p>
                <?php else: ?>
                    <?php foreach ($participants as $participant): ?>
                        <div class="participant-box">
                            <p><strong><span style="font-size: 20px; display: block;"><?php echo htmlspecialchars($participant['username']); ?></span></strong></p>
                            <p><strong>이메일 :</strong> <?php echo htmlspecialchars($participant['email']); ?></p>
                            <p><strong>휴대폰번호 :</strong> <?php echo htmlspecialchars($participant['phone']); ?></p>
                            <p><strong>관심분야 :</strong> <?php echo implode(', ', array_map('htmlspecialchars', $participant['fields'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Contest Detail End -->


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