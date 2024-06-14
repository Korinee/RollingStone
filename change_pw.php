<?php
session_start();
include 'db.php';

if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];
    $query = "SELECT username, userid, email, phone FROM users WHERE userid = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('s', $userId);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($username, $userid, $email, $phone);
        if ($stmt->fetch()) {
            $defaultUsername = htmlspecialchars($username);
            $defaultUserId = htmlspecialchars($userid);
            $defaultEmail = htmlspecialchars($email);
            $defaultPhone = htmlspecialchars($phone);
        }
        $stmt->close();
    } else {
        die('prepare() failed: ' . htmlspecialchars($conn->error));
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>비밀번호 변경 | ROLLING STONE</title>

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
            font-family: 'Nunito Sans', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #F5F5F5;
            font-family: 'Nunito Sans', sans-serif;
        }
        .content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 60px; 
            padding-bottom: 60px;
        }
        .wrap {
            width: 450px;
            background-color: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .wrap h3 {
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        .form {
            text-align: center;
        }
        .form input[type="text"],
        .form input[type="password"] {
            width: calc(100% - 1px);
            height: 40px;
            margin-bottom: 5px;
            padding: 0 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form .form_btn {
            width: 100%;
            height: 50px;
            margin-top: 20px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .form .pre_btn {
            text-align: center;
        }
        .form .pre_btn a {
            color: #E53637;
            text-decoration: none;
            font-size: 14px;
        }
        .form_btn {
            width: 100%;
            height: 50px;
            margin-top: 20px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .form_btn:hover {
            background-color: #505050;
        }
        header, footer {
            width: 100%;
            background-color: #fff;
        }
    </style>
</head>
<body>
    <!-- Page Preloader -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header>
        <?php include 'header.php'; ?>
    </header>
    <!-- Header Section End -->

    <!-- Change Password Section Begin -->
    <div class="content">
        <div class="wrap">
            <h3>비밀번호 변경</h3><br>
            <form id="infoForm" class="form">
                <p><input type="text" name="username" id="username" placeholder="이름" value="<?php echo isset($defaultUsername) ? $defaultUsername : ''; ?>"></p>
                <p><input type="text" name="userid" id="userid" placeholder="아이디" value="<?php echo isset($defaultUserId) ? $defaultUserId : ''; ?>"></p>
                <p><input type="text" name="email" id="email" placeholder="이메일" value="<?php echo isset($defaultEmail) ? $defaultEmail : ''; ?>"></p>
                <p><input type="text" name="phone" id="phone" placeholder="핸드폰 번호 (예시 : 01012345678)" value="<?php echo isset($defaultPhone) ? $defaultPhone : ''; ?>"></p>
                <p><input type="password" name="newPassword" id="newPassword" placeholder="새로운 비밀번호"></p>
                <p><input type="password" name="confirmPassword" id="confirmPassword" placeholder="비밀번호 검사"></p>
                <input type="button" value="변경" class="form_btn" onclick="checkPassword()">
            </form>
        </div>
    </div>
    <!-- Change Password Section End -->

    <!-- Footer Section Begin -->
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript"></script>
    <script>
        function checkPassword() {
            var username = document.getElementById('username').value;
            var userid = document.getElementById('userid').value;
            var email = document.getElementById('email').value;
            var phone = document.getElementById('phone').value;
            var newPassword = document.getElementById('newPassword').value;
            var confirmPassword = document.getElementById('confirmPassword').value;

            if (!username || !userid || !email || !phone || !newPassword || !confirmPassword) {
                alert("모든 항목을 작성해주세요 : )");
                return;
            }

            if (newPassword !== confirmPassword) {
                alert("새로운 비밀번호와 확인 비밀번호가 일치하지 않습니다.");
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'change_pw_proc.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText);
                }
            };
            xhr.send('username=' + username + '&userid=' + userid + '&email=' + email + '&phone=' + phone + '&newPassword=' + newPassword);
        }
    </script>

</body>
</html>