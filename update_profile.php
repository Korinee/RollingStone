<?php
include 'db.php'; // 데이터베이스 연결 파일을 포함

session_start();

if (!isset($_SESSION['userid'])) {
    echo "<script>
        if (confirm('개인정보 변경은 회원만 가능합니다. 로그인 후 이용해주세요 : )')) {
            window.location.href = 'login.php';
        } else {
            window.location.href = 'index.php';
        }
    </script>";
    exit;
}

$userid = $_SESSION['userid'];
$query = "SELECT * FROM users WHERE userid='$userid'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // 유효성 검사 추가
    if (empty($username) || empty($email) || empty($phone)) {
        echo "<script>alert('모든 정보를 입력해주세요.');</script>";
    } else {
        // 변경 여부 확인
        if ($username !== $row['username'] || $email !== $row['email'] || $phone !== $row['phone']) {
            echo "<script>
                    if (confirm('작성하진 개인 정보로 변경하시겠습니까?')) {
                        window.location.href = 'update_profile.php?username=$username&email=$email&phone=$phone';
                    } else {
                        window.location.reload();
                    }
                </script>";
            
            // SQL 쿼리를 통해 데이터베이스 정보 업데이트
            $update_query = "UPDATE users SET username='$username', email='$email', phone='$phone' WHERE userid='$userid'";
            mysqli_query($conn, $update_query);
        } else {
            echo "<script>alert('변경된 정보가 없습니다. 다시 확인해주세요 : )');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>개인정보 변경 | ROLLING STONE</title>

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
            max-width: 400px;
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
        .form-container input {
            width: 100%;
            height: 40px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 0 10px;
            margin-bottom: 15px;
        }
        .form-container button {
            width: 100%;
            height: 40px;
            background: black;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .form-container button:hover {
            background: #505050;
        }
        .form-container input[readonly] {
            background-color: #ccc;
            color: black;
        }
        .form-container a {
            color: #E53637;
        }
    </style>
</head>
<body>
    <!-- Header Section Begin -->
    <?php include 'header.php'; ?>
    <!-- Header Section End -->

    <!-- Main Content Begin -->
    <div class="main-container">
        <div class="form-container">
            <h3>개인정보 변경</h3><br>
            <form action="" method="post">
                <label for="userid">아이디(변경불가)</label>
                <input type="text" id="userid" name="userid" value="<?php echo $row['userid']; ?>" readonly>
                <label for="username">이름</label>
                <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>">
                <label for="email">이메일</label>
                <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>">
                <label for="phone">핸드폰 번호</label>
                <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>"><br><br>
                <button id="submitBtn" type="submit">변경하기</button>
            </form><br>
            <a href="change_pw.php" style="font-weight: bold;">비밀번호 변경</a>
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