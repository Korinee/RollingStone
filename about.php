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
    <title>소개 | ROLLING STONE</title>

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
        .main-content {
            background-color: #ffffff;
            padding: 40px 20px;
            margin: 20px auto;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
        }
        .about {
            padding-top: 40px; /* 더 위에 위치하도록 패딩 조정 */
        }
        .about__text,
        .about__item {
            text-align: center;
        }
        .about__text .section-title img {
            margin: 0 auto;
            display: block;
        }
        .about__text p {
            font-size: 16px;
            line-height: 1.6;
            font-weight: 400;
        }
        .about__text h2 {
            font-size: 24px;
            margin: 20px 0;
            font-weight: 700;
        }
        .about__text h2.italic {
            font-style: italic;
            color: #E53637; /* 색상 지정 */
        }
        .about__item h4 {
            font-size: 20px;
            margin: 30px 0 15px 0; /* 더 아래에 위치하도록 위쪽 마진 추가 */
            font-weight: 600;
            color: #E53637; /* 색상 지정 */
        }
        .about__item p {
            font-size: 14px;
            line-height: 1.6;
            font-weight: 400;
        }
        .section-title span {
            color: #E53637; /* 색상 지정 */
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

    <!-- About Section Begin -->
    <div class="main-content">
        <div class="container_poster">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about__text">
                        <div class="section-title">
                            <span>ABOUT US</span>
                            <img src="img/logo.png" alt="ROLLING STONE 로고" style="width: 600px; height: auto;">
                            <h7>(이는 2024년 건국대학교 글로컬캠퍼스 컴퓨터공학과 재학생의 데이터베이스 Term Project 과제로 제작됨.)</h7><br><br><br>
                            <h5>롤링스톤은 대학생 혹은 공모전에 관심 있는 누구나 공모전에 더 효율적으로 참여할 수 있도록 도와주는 플랫폼입니다. <br>
                                아래는 롤링스톤의 간단 소개와 주요 기능에 대한 소개입니다.</h5>
                        </div>
                        <h2 class="italic">"A rolling stone gathers no moss"</h2><br>
                        <p>롤링스톤은 고대 로마의 작가 푸블릴리우스 시루스(Publilius Syrus)의 명언 "A rolling stone gathers no moss"에 영감을 받았습니다.
                            이 문구는 "굴러가는 돌은 이끼가 끼지 않는다"는 뜻으로, 부지런하고 꾸준히 노력하는 사람은 침체되지 않고 계속 발전한다는 의미를 담고 있습니다.
                            꿈을 향해 노력하는 여러분들은 굴러가는 돌과 같습니다.
                            정체되거나 이끼가 끼지 않도록 꾸준히 꿈을 향해 나아가는 여러분들을 위해 저희는 롤링스톤을 제작하였습니다.
                            많은 관심과 이용 부탁드리며, 여러분의 무궁무진한 밝은 미래를 기원합니다 : )
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="about__item">
                        <h4>공모전/대외활동</h4>
                        <p>롤링스톤은 현재 모집 중인 또는 새롭게 모집 중인 공모전과 대외활동들을 소개해줍니다.
                            공모전을 총 16가지 분야별로 구분하여 사용자가 관심 있는 분야의 공모전을 쉽게 찾을 수 있도록 도와줍니다.
                            관심 있는 공모전의 원본 홈페이지로 이동할 수 있는 하이퍼링크 기능도 제공합니다.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="about__item">
                        <h4>검색/매칭</h4>
                        <p>롤링스톤은 사용자가 관심있는 공모전을 검색할 수 있도록 제공합니다.
                            또한, 여러 사용자와 함께 공모전에 참여하고 싶은 사용자의 니즈를 파악하여 팀을 매칭해주는 서비스도 포함합니다.
                            롤링스톤만의 매칭 시스템을 통해 다른 사용자와 팀을 꾸려보세요.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="about__item">
                        <h4>커뮤니티</h4>
                        <p>롤링스톤을 이용하는 모든 사용자들은 공모전뿐만 아니라 진로를 향해 끊임없이 나아가는 굴러가는 돌입니다.
                            이러한 사용자들이 함께하는 커뮤니티에 참여하여 생각과 의견을 공유할 수 있습니다.
                            커뮤니티는 총 5가지로 나누어집니다. 각 커뮤니티 성격에 맞지 않는 글들은 무단 삭제됩니다.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Section End -->

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
