<?php
session_start();
include 'db.php';

if (!isset($_SESSION['userid'])) {
    echo "<script>
        if (confirm('관심 분야 선택은 회원만 가능합니다. 로그인 후 이용해주세요 : )')) {
            window.location.href = 'login.php';
        } else {
            window.location.href = 'index.php';
        }
    </script>";
    exit;
}

$userId = $_SESSION['userid'];
$username = $_SESSION['username'];

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 기존에 선택한 관심 분야 로드
$query = "SELECT field FROM user_interests WHERE userid = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('s', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $selectedInterests = [];
    while ($row = $result->fetch_assoc()) {
        $selectedInterests[] = $row['field'];
    }
    $stmt->close();
} else {
    die('prepare() failed: ' . htmlspecialchars($conn->error));
}

$currentInterests = implode(", ", $selectedInterests);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>관심 분야 선택 | ROLLING STONE</title>

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
            height: 70vh;
        }
        .form-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 450px;
            width: 100%;
        }
        .form-container h3 {
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        .form-container label {
            display: block;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .form-container button {
            width: 100%;
            height: 40px;
            background: #000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
        }
        .field-btn {
            display: inline-block;
            margin-right: 10px;
            margin-bottom: 10px;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #ccc;
            cursor: pointer;
        }
        .field-btn.selected {
            background-color: #000;
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- Header Section Begin -->
    <?php include 'header.php'; ?>
    <!-- Header Section End -->

    <!-- Interest Field Begin -->
    <div class="main-container">
        <div class="form-container">
            <h3>관심 분야 선택</h3>
            <?php
            if (!empty($currentInterests)) {
                echo "<p>현재 <strong>$username</strong>님의 관심 분야는 <strong>$currentInterests</strong> 입니다.</p>";
            } else {
                echo "<p>현재 <strong>$username</strong>님은 관심 분야 등록을 하지 않았습니다.</p>";
            }
            ?>
            <form id="interest-form">
                <div>
                    <?php
                    $allInterests = ["기획/아이디어", "광고/마케팅", "논문/리포트", "영상/UCC/사진", "디자인/캐릭터/웹툰", 
                    "웹/모바일/IT", "게임/소프트웨어", "과학/공학", "문학/글/시나리오", "건축/건설/인테리어", "네이밍/슬로건", 
                    "예체능/미술/음악", "봉사활동", "취업/창업", "해외", "기타"];
                    foreach ($allInterests as $interest) {
                        $selectedClass = in_array($interest, $selectedInterests) ? 'selected' : '';
                        echo "<span class='field-btn $selectedClass' data-value='$interest'>$interest</span>";
                    }
                    ?>
                </div><br>
                <button type="button" id="save-btn">저장하기</button>
                <button type="button" id="reset-btn">초기화</button>
            </form>
        </div>
    </div>
    <!-- Interest Field End -->


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
    <script>
        $(document).ready(function() {
            $('.field-btn').click(function() {
                $(this).toggleClass('selected');
            });

            $('#save-btn').click(function() {
                var selectedFields = [];
                $('.field-btn.selected').each(function() {
                    selectedFields.push($(this).data('value'));
                });

                $.ajax({
                    url: 'save_interest.php',
                    method: 'POST',
                    data: { fields: selectedFields },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.status === 'success') {
                            alert(response.message);
                            location.reload(); // 저장 후 페이지 새로고침
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        console.error('Response:', xhr.responseText);
                        alert('관심 분야를 저장하지 못했습니다. 다시 시도해주세요.');
                    }
                });
            });

            $('#reset-btn').click(function() {
                $.ajax({
                    url: 'reset_interest.php',
                    method: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.status === 'success') {
                            alert(response.message);
                            $('.field-btn').removeClass('selected');
                            location.reload(); // 초기화 후 페이지 새로고침
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        console.error('Response:', xhr.responseText);
                        alert('관심 분야를 초기화하지 못했습니다. 다시 시도해주세요.');
                    }
                });
            });
        });
    </script>
</body>
</html>
