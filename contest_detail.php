<?php
session_start();
include 'db.php';

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

// 매칭 신청 폼 제출 처리
if (isset($_POST['submit'])) {
    if (!isset($_SESSION['userid'])) {
        echo "<script>alert('공모전 매칭 기능은 회원만 사용 가능한 기능입니다. 로그인 후 이용해주세요 : )'); history.back();</script>";
        exit;
    }

    $contest_id = $_POST['contest_id'];
    $userid = $_SESSION['userid'];
    $desired_members = $_POST['desired_members'];
    
    // 중복 매칭 신청 방지
    $query_check = "SELECT * FROM matches WHERE contest_id = ? AND userid = ?";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bind_param("is", $contest_id, $userid);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>alert('이미 해당 공모전 매칭을 신청하셨습니다. 희망 매칭 인원수 변경을 희망하시면 취소 후 다시 신청해주시기 바랍니다 : )'); history.back();</script>";
        $stmt_check->close();
        $conn->close();
        exit;
    }

    $stmt_check->close();

    // 해당 contest_id의 매칭 개수 가져오기
    $query_count_matches = "SELECT COUNT(*) AS match_count FROM matches WHERE contest_id = ?";
    $stmt_count_matches = $conn->prepare($query_count_matches);
    $stmt_count_matches->bind_param("i", $contest_id);
    $stmt_count_matches->execute();
    $result_count_matches = $stmt_count_matches->get_result();
    $row = $result_count_matches->fetch_assoc();
    $current_members = $row['match_count']; // 현재 매칭 수에 신규 매칭 한 개 추가
    $stmt_count_matches->close();

    // 매칭 신청 처리
    $query = "INSERT INTO matches (contest_id, userid, desired_members, current_members) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isii", $contest_id, $userid, $desired_members, $current_members);

    if ($stmt->execute()) {
        // 매칭이 완료된 후, 해당 공모전에 대해 매칭된 모든 사용자들의 current_members 값을 1씩 증가시킴
        $update_query = "UPDATE matches SET current_members = current_members + 1 WHERE contest_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("i", $contest_id);
        $update_stmt->execute();
        $update_stmt->close();

        echo "<script>alert('공모전 매칭 신청이 완료되었습니다. 매칭을 기다려주세요 : )'); window.location.href='match.php';</script>";
    } else {
        echo "오류: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>공모전 자세히보기 | ROLLING STONE</title>

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
            background-color: #f5f5f5;
            font-family: 'Nunito Sans', sans-serif;
        }
        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 80px);
            padding: 20px;
            flex-direction: column;
            margin-top: -80px;
            margin-bottom: -80px;
        }
        .contest-title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .contest-box {
            display: flex;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 60%; 
            margin-bottom: 20px; 
            align-items: center; 
        }
        .contest-column {
            flex: 1;
            padding: 20px;
            text-align: center;
        }
        .contest-column img {
            max-width: 100%;
            height: auto; /* 이미지 비율 유지 */
            border-radius: 20px;
            margin-bottom: 20px;
        }
        .contest-detail-content {
            text-align: left;
            padding: 0 20px;
            flex: 2;
            display: flex;
            flex-direction: column;
            justify-content: center; /* 내부 요소들을 수직 중앙 정렬 */
        }
        .contest-detail-content p {
            font-size: 18px;
            margin: 10px 0; /* 위아래 마진 비율 동일하게 조정 */
        }
        .homepage-link {
            font-size: 18px;
            margin: 10px 0; /* 위아래 마진 비율 동일하게 조정 */
            display: block;
            text-decoration: none;
            color: #000;
            transition: color 0.3s ease;
        }
        .homepage-link:visited {
            color: #555; /* 방문한 링크 색 */
        }
        .homepage-link:hover,
        .homepage-link:active {
            color: #E53637; /* 호버 및 클릭 시 색 변경 */
        }
        .field-btn {
            font-size: 18px;
            display: inline-block;
            margin-right: 10px;
            margin-bottom: 10px;
            padding: 10px 20px;
            border-radius: 50px;
            background-color: #ccc;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .field-btn.selected {
            background-color: #000;
            color: #fff;
        }
        .match-btn {
            font-size: 18px;
            background-color: #000;
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }
        .match-btn:hover {
            background-color: #555;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.field-btn');
            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    buttons.forEach(btn => btn.classList.remove('selected'));
                    this.classList.add('selected');
                    document.getElementById('desired_members').value = this.dataset.value;
                });
            });
        });
    </script>
</head>

<body>
    <!-- Header Section Begin -->
    <?php include 'header.php'; ?>
    <!-- Header Section End -->

    <!-- Main Content Begin -->
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
                        $days_left = $interval->format('%a');
                    ?>
                    <p><strong>접수 마감</strong> : <?php echo htmlspecialchars($days_left); ?>일</p>
                    <p><strong>홈페이지</strong> : <a href="<?php echo htmlspecialchars($homepage); ?>" target="_blank" class="homepage-link"><?php echo htmlspecialchars($homepage); ?></a></p>
                    <hr>
                    <form action="contest_detail.php?contest_id=<?php echo htmlspecialchars($contest_id); ?>" method="post">
                        <input type="hidden" name="userid" value="<?php echo htmlspecialchars($userid); ?>">    
                        <input type="hidden" name="contest_id" value="<?php echo htmlspecialchars($contest_id); ?>">
                        <input type="hidden" name="desired_members" id="desired_members" value="">
                        <div class="option-container">
                            <label><strong>희망 매칭 인원수 선택</strong> : </label>
                            <div class="field-btn" data-value="2">2명</div> /&nbsp;&nbsp;
                            <div class="field-btn" data-value="3">3명</div> /&nbsp;&nbsp;
                            <div class="field-btn" data-value="4">4명</div>
                        </div>
                        <button type="submit" name="submit" class="match-btn">매칭 신청</button>
                    </form>
                </div>
            </div>
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