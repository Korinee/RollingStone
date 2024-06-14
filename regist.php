<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $userid = $_SESSION['userid'];
    echo "<script>
    alert('해당 페이지는 회원가입 페이지입니다. 이미 $username($userid)(으)로 로그인 중 입니다.');
    location.href = 'index.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>회원가입 | ROLLING STONE</title>

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
        * {
            padding: 0;
            margin: 0;
        }
        body {
            background-color: #F5F5F5;
            font-family: 'Nunito Sans', sans-serif;
        }
        a {
            text-decoration: none;
            color: #000;
        }
        html, body {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
        }
        body {
            font-family: 'Nunito Sans', sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100vh;
        }
        .wrap {
            width: 500px;
            margin: 20px 0;
            background-color: #fff;
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }
        .wrap > div {
            width: 100%;
            margin: 0 50px;
            padding: 20px 0;
        }
        h3 {
            margin-bottom: 10px;
        }
        .wrap .form input:not([type="submit"], [type="checkbox"]) {
            border: 1px solid #d9d9d9;
            width: 100%;
            height: 40px;
            margin: 5px 0;
            padding-left: 10px;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 16px;
        }
        #regist_wrap #regist_form input#checkIdBtn {
            position: relative;
            top: -2px;
            width: 45px;
            height: 35px;
            margin-left: 0;
            padding-left: 0;
            border: 0;
            box-sizing: content-box;
            background: gray;
            font-size: 12px;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
        }
        #regist_wrap #regist_form input#check_button {
            position: relative;
            top: -2px;
            width: 100px;
            height: 28px;
            font-size: 12px;
            margin-left: 0;
            padding-left: 0;
            border: 0;
            box-sizing: content-box;
            background: white;
            border-color: black;
            cursor: pointer;
        }
        #regist_wrap #regist_form #result {
            display: none;
        }
        #login_wrap .forgetpw {
            text-align: left;
            font-size: 14px;
            margin: 0 0 10px 10px;
            cursor: pointer;
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
        #login_wrap .forgetpw a,
        #regist_wrap .pre_btn a {
            color: red;
        }
        #login_wrap .pre_btn a {
            font-size: 13px;
            color: gray;
        }
        .error-popup {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
            border-radius: 4px;
            padding: 15px;
            z-index: 1000;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .error-popup.show {
            display: block;
        }
        header, footer {
            width: 100%;
            background-color: #fff;
            flex-shrink: 0;
        }
    </style>
</head>
<body>
    <!-- Header Section Begin -->
    <Header>
        <?php include 'header.php'; ?>
    </Header>
    <!-- Header Section End -->

    <!-- register Section Begin -->
    <?php
    if (isset($_SESSION['name'])) {
        echo "<script>
        alert(\"이미 로그인 하셨습니다.\");
        location.href = \"index.php\";
        </script>";
    } else { ?>
        <div id="regist_wrap" class="wrap">
        <div>
            <h3 style="text-align: center; font-weight: bold;">회원가입</h3><br>
            <form action="regist_proc.php" method="post" name="regiform" id="regist_form" class="form" onsubmit="return sendit()">
            <p><input type="text" name="username" id="username" placeholder="이름"></p>
            <p style="display: flex; align-items: center;">
                <input type="text" name="userid" id="userid" placeholder="아이디 (영문자와 숫자를 포함 6자 이상)" style="flex-grow: 1;"></p>
            <p><span id="decide" style='color:red; font-size:13px;'>* ID 중복 여부를 확인해주세요.&nbsp;</span>
                <input type="button" id="check_button" value="ID 중복체크" onclick="checkId();">
            <p><input type="password" name="password" id="userpw" placeholder="비밀번호(대소문자, 숫자, 특수문자 포함 8자 이상)"></p>
            <p><input type="password" name="pw_ch" id="userpw_ch" placeholder="비밀번호 검사"></p>
            <p><input style="width:160px;" type="text" name="email" id="useremail" placeholder="이메일">&nbsp;&nbsp;@&nbsp;
                <input style="width:200px; height:40px; border: 1px solid #d9d9d9; border-radius: 10px;font-size: 15px;" type="text" name="custom_email" id="custom_email" placeholder="이메일 주소">
            </p>
            <p><input type="text" name="phone" id="userphone" placeholder="휴대폰 번호 (예시 : 01012345678)"></p>
                <input type="submit" value="회원가입" id="join_button" class="form_btn">
            </p>
            <p style="text-align: center;">
                <a href="login.php" style="color: gray; font-size:13px;">로그인</a>
            </p>
            </form>
        </div>
        </div>
        <?php
    }
    ?>
    <!-- register Section End -->

    <!-- Footer Section Begin -->
    <Footer>
        <?php include 'footer.php'; ?>
    </Footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

    <script type="text/javascript">
        var isIdChecked = false;

        function showError(message) {
            const errorPopup = document.createElement('div');
            errorPopup.className = 'error-popup show';
            errorPopup.innerText = message;
            document.body.appendChild(errorPopup);
            setTimeout(() => {
                errorPopup.classList.remove('show');
                document.body.removeChild(errorPopup);
            }, 3000);
        }

        function sendit() {
            var username = document.getElementById("username");
            var userid = document.getElementById("userid");
            var userpw = document.getElementById("userpw");
            var userpw_ch = document.getElementById("userpw_ch");
            var useremail = document.getElementById("useremail");
            var custom_email = document.getElementById("custom_email");
            var userphone = document.getElementById("userphone");

            if (username.value == "") {
                alert("이름을 입력하세요.");
                username.focus();
                return false;
            }

            if (userid.value == "") {
                alert("아이디를 입력하세요.");
                userid.focus();
                return false;
            }

            if (userpw.value == "") {
                alert("비밀번호를 입력하세요.");
                userpw.focus();
                return false;
            }

            if (userpw.value != userpw_ch.value) {
                alert("비밀번호가 일치하지 않습니다.");
                userpw_ch.focus();
                return false;
            }

            if (useremail.value == "") {
                alert("이메일을 입력하세요.");
                useremail.focus();
                return false;
            }

            if (custom_email.value == "") {
                alert("이메일 주소를 입력하세요.");
                custom_email.focus();
                return false;
            }

            if (userphone.value == "") {
                alert("휴대폰 번호를 입력하세요.");
                userphone.focus();
                return false;
            }

            if (userphone.value.length != 11) {
                alert("휴대폰 번호는 11자리 숫자여야 합니다.");
                userphone.focus();
                return false;
            }

            if (!/^[0-9]+$/.test(userphone.value)) {
                alert("휴대폰 번호는 숫자만 입력해야 합니다.");
                userphone.focus();
                return false;
            }

            return true;
        }

        function checkId() {
            var userid = document.getElementById("userid").value;

            if (userid == "") {
                showError("아이디를 입력하세요.");
                return false;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "check_id.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var resultText = xhr.responseText;
                    var decide = document.getElementById("decide");
                    decide.innerText = resultText;
                    if (resultText === "사용 가능한 아이디입니다.") {
                        isIdChecked = true;
                    } else {
                        isIdChecked = false;
                    }
                }
            };
            xhr.send("userid=" + userid);
        }
    </script>
</body>
</html>
