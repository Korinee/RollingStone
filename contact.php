<?php
include 'db.php';

session_start();

if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];
    $query = "SELECT username, email FROM users WHERE userid = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('s', $userId);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($username, $email);
        if ($stmt->fetch()) {
            $defaultUsername = htmlspecialchars($username);
            $defaultEmail = htmlspecialchars($email);
        }
        $stmt->close();
    } else {
        die('prepare() failed: ' . htmlspecialchars($conn->error));
    }
}

$success_message = "불편 사항이 있으시다면 양식에 맞게 작성해 주세요 : )";
$error_message = "오류로 인해 접수되지 않았습니다. 다시 시도해 주세요 : (";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 데이터 검증 및 필터링
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);

    // 이메일 검증
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "유효한 이메일 주소를 입력하세요.";
    } else {
        // SQL 인젝션 방지 (준비된 문장 사용)
        $sql = "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            $success_message = "접수되었습니다. 불편을 드려 죄송합니다.";
        } else {
            $error_message = "오류: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>고객센터 | ROLLING STONE</title>

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
            min-height: calc(100vh - 150px); /* Adjusted for header and footer */
            padding: 20px 0;
        }
        .form-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 1100px;
            width: 100%;
            margin: 5px 0; /* Add margin to avoid touching header and footer */
        }
        .section-title span {
            color: #E53637; /* 색상 지정 */
            font-weight: bold;
        }
        .map {
            margin-bottom: -150px; /* 맵과 글 사이 간격 조정 */
        }
        .contact.spad {
            margin-bottom: -100px; /* 글과 푸터 사이 간격 조정 */
        }
        .site-btn {
            background-color: #E53637;
            border-color: #E53637;
            color: #fff;
            border-radius: 5px; /* 모서리를 둥글게 만듦 */
        }
        .site-btn:hover {
            background-color: #ff6b6e;
            border-color: #ff6b6e;
            color: #fff;
            border-radius: 5px; /* hover 상태에서도 적용 */
        }
        .contact__text h4 {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Page Preloader -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <?php include 'header.php'; ?>
    <!-- Header Section End -->

    <!-- Map Begin -->
    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1594.276436353739!2d127.90609594429075!3d36.94885056928862!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x356488a4fe3a0ea5%3A0xb31182a2346d85c9!2z6rG06rWt64yA7ZWZ6rWQIOyekOyXsOqzvO2VmeuMgO2VmQ!5e0!3m2!1sko!2skr!4v1715926307991!5m2!1sko!2skr" height="450" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>
    <!-- Map End -->

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="main-container">
                <div class="form-container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="contact__text">
                                <div class="section-title">
                                    <span>Information</span><br>
                                    <h2>고객센터</h2>
                                    <p>홈페이지 내에 문제가 발생하였다면 오른쪽 폼에 이름과 이메일을 입력하신 후 내용을 입력해 주십시오. 이른 시일 내에 연락드리겠습니다.</p>
                                </div>
                                <ul>
                                    <li>
                                        <h4>소속</h4>
                                        <p>대한민국 충청북도 충주시 충원대로 268,<br> 건국대학교 글로컬캠퍼스 과학기술대학 컴퓨터공학과<br />+82 043-840-3518</p>
                                    </li>
                                    <li>
                                        <h4>개발자</h4>
                                        <p>컴퓨터공학과 20학번 박경민 <br/>컴퓨터공학과 22학번 최우진</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="contact__form">
                                <?php if (!empty($success_message)) { ?>
                                    <div class="alert alert-success">
                                        <?php echo htmlspecialchars($success_message); ?>
                                    </div>
                                <?php } elseif (!empty($error_message)) { ?>
                                    <div class="alert alert-danger">
                                        <?php echo htmlspecialchars($error_message); ?>
                                    </div>
                                <?php } ?>

                                <form action="contact.php" method="post">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" name="name" placeholder="이름" value="<?php echo isset($defaultUsername) ? $defaultUsername : ''; ?>" required>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="email" name="email" placeholder="이메일" value="<?php echo isset($defaultEmail) ? $defaultEmail : ''; ?>" required>
                                        </div>
                                        <div class="col-lg-12">
                                            <textarea name="message" placeholder="불편사항을 입력해주세요  : )" required></textarea>
                                            <button type="submit" class="site-btn">불편사항 접수</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- Footer Section Begin -->
    <?php include 'footer.php'; ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
