<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    echo "<script>
    alert('공모전 등록 기능은 회원만 가능합니다. 로그인 후 사용 가능합니다 : )');
    location.href = 'login.php';
    </script>";
    exit;
}
$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>공모전 등록 | ROLLING STONE</title>
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
            width: 550px;
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
        .form label {
            text-align: left;
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form input[type="text"],
        .form input[type="url"],
        .form input[type="date"],
        .form textarea {
            width: calc(100% - 1px);
            height: 40px;
            margin-bottom: 5px;
            padding: 0 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form textarea {
            height: 80px;
            padding-top: 10px;
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
            transition: background-color 0.3s;
        }
        .form .form_btn:hover {
            background-color: #505050;
        }
        header, footer {
            width: 100%;
            background-color: #fff;
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
        .field-label {
            text-align: left;
            margin-bottom: 5px;
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
    <header>
        <?php include 'header.php'; ?>
    </header>
    <!-- Header Section End -->

    <!-- Create Contest Section Begin -->
    <div class="content">
        <div class="wrap">
            <h3>공모전 등록</h3>
            <form id="contestForm" action="create_contest_proc.php" method="post" class="form">
                <p><label for="img">이미지 URL</label><input type="text" id="img" name="img" placeholder="ex) http://localhost/rollingstone/img/logo.png" required></p>
                <p><label for="title">제목</label><input type="text" id="title" name="title" placeholder="ex) 롤링스톤" required></p>
                <p><label for="organizer">주최/주관</label><input type="text" id="organizer" name="organizer" placeholder="ex) 건국대학교" required></p>
                <p class="field-label">분야 (중복선택 가능)</p><br>
                <div id="fieldContainer">
                    <span class="field-btn" data-value="기획/아이디어">기획/아이디어</span>
                    <span class="field-btn" data-value="광고/마케팅">광고/마케팅</span>
                    <span class="field-btn" data-value="논문/리포트">논문/리포트</span>
                    <span class="field-btn" data-value="영상/UCC/사진">영상/UCC/사진</span>
                    <span class="field-btn" data-value="디자인/캐릭터/웹툰">디자인/캐릭터/웹툰</span>
                    <span class="field-btn" data-value="웹/모바일/IT">웹/모바일/IT</span>
                    <span class="field-btn" data-value="게임/소프트웨어">게임/소프트웨어</span>
                    <span class="field-btn" data-value="과학/공학">과학/공학</span>
                    <span class="field-btn" data-value="문학/글/시나리오">문학/글/시나리오</span>
                    <span class="field-btn" data-value="건축/건설/인테리어">건축/건설/인테리어</span>
                    <span class="field-btn" data-value="네이밍/슬로건">네이밍/슬로건</span>
                    <span class="field-btn" data-value="예체능/미술/음악">예체능/미술/음악</span>
                    <span class="field-btn" data-value="봉사활동">봉사활동</span>
                    <span class="field-btn" data-value="취업/창업">취업/창업</span>
                    <span class="field-btn" data-value="해외">해외</span>
                    <span class="field-btn" data-value="기타">기타</span>
                </div><br>
                <p><label for="homepage">홈페이지 URL</label><input type="url" id="homepage" name="homepage" placeholder="ex) http://localhost/rollingstone/index.php" required></p>
                <p><label for="start_day">시작일</label><input type="date" id="start_day" name="start_day" required></p>
                <p><label for="finish_day">마감일</label><input type="date" id="finish_day" name="finish_day" required></p>
                <input type="button" value="등록하기" class="form_btn" onclick="validateForm()">
            </form>
        </div>
    </div>
    <!-- Create Contest Section End -->

    <!-- Footer Section Begin -->
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(document).ready(function() {
            $('.field-btn').click(function() {
                $(this).toggleClass('selected');
            });
        });

        function validateForm() {
            var img = document.getElementById('img').value;
            var title = document.getElementById('title').value;
            var organizer = document.getElementById('organizer').value;
            var homepage = document.getElementById('homepage').value;
            var start_day = document.getElementById('start_day').value;
            var finish_day = document.getElementById('finish_day').value;
            var selectedFields = [];

            $('.field-btn.selected').each(function() {
                selectedFields.push($(this).data('value'));
            });

            if (!img || !title || !organizer || selectedFields.length === 0 || !homepage || !start_day || !finish_day) {
                alert("모든 항목을 작성해주세요 : )");
                return;
            }

            var form = document.getElementById('contestForm');
            var hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = 'field';
            hiddenField.value = selectedFields.join(', ');
            form.appendChild(hiddenField);

            var username = "<?php echo $username; ?>";
            var userid = "<?php echo $userid; ?>";
            document.getElementById('organizer').value = "(" + username + "/" + userid + ") " + organizer;

            form.submit();
        }
    </script>
</body>
</html>
