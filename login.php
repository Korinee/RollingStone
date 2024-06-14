<?php
    include 'db.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>로그인 | ROLLING STONE</title>

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
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        body {
            background-color: #F5F5F5;
            font-family: 'Nunito Sans', sans-serif;
        }
        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .wrap {
            width: 450px;
            padding: 20px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }
        .wrap h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .wrap .form input:not([type="submit"], [type="checkbox"]) {
            width: 100%;
            height: 40px;
            margin: 5px 0;
            padding-left: 10px;
            border: 1px solid #d9d9d9;
            border-radius: 10px;
            font-size: 16px;
        }
        .wrap .form_btn {
            width: 100%;
            height: 50px;
            margin: 10px 0;
            border-radius: 5px;
            border: 0;
            background: black;
            color: #fff;
            font-weight: bold;
            font-size: 18px;
            cursor: pointer;
        }
        .wrap .pre_btn a,
        .wrap .changepw a {
            color: red;
            text-decoration: none;
        }
        .wrap .pre_btn {
            text-align: center;
        }
        .wrap .pre_btn a {
            color: gray;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <!-- Header Section Begin -->
    <?php include 'header.php'; ?>
    <!-- Header Section End -->

    <!-- Container Section Begin -->
    <div class="main-container">
        <div id="login_wrap" class="wrap">
            <div>
                <h2>로그인</h2>
                <form action="login_proc.php" method="post" name="loginform" id="login_form" class="form" onsubmit="return login_check();">
                    <p><input type="text" name="id" id="id" placeholder="아이디"></p>
                    <span class="err_id"></span>
                    <p><input type="password" name="pw" id="pw" placeholder="비밀번호"></p>
                    <span class="err_pw"></span>
                    <p><input type="submit" value="로그인" class="form_btn"></p>
                    <p class="pre_btn"><a href="regist.php">회원가입</a></p>
                    <p class="changepw"><a href="change_pw.php">비밀번호를 잊으셨나요?</a></p>
                </form>
            </div>
        </div>
    </div>
    <!-- Container Section End -->

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
    <script type="text/javascript"></script>
    <script>
        function login_check() {
            var userid = document.getElementById("id");
            var userpw = document.getElementById("pw");

            var id_pattern = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{6,}$/; // 영문자와 숫자를 포함한 6자 이상
            var pw_pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/; // 대소문자, 숫자, 특수문자 포함 8자 이상

            if (userid.value == "") {
                alert("아이디를 입력하세요.");
                userid.focus();
                return false;
            } else if (!id_pattern.test(userid.value)) {
                alert("아이디는 영문자와 숫자를 포함하여 6자 이상이어야 합니다.");
                userid.focus();
                return false;
            }

            if (userpw.value == "") {
                alert("비밀번호를 입력하세요.");
                userpw.focus();
                return false;
            } else if (!pw_pattern.test(userpw.value)) {
                alert("비밀번호는 특수문자, 대문자, 소문자, 숫자를 포함하여 8자 이상이어야 합니다.");
                userpw.focus();
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
