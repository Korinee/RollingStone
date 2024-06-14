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
    <title>책임한계와 법적고지 | ROLLING STONE</title>

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
        .terms__box {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 1100px;
            width: 100%;
            margin: 20px 0; /* Add margin to avoid touching header and footer */
        }
        .terms__text {
            margin-top: 20px;
        }
        .terms__text p {
            margin-top: 10px;
        }
        .section-title span {
            display: block;
            text-align: center;
            color: #333;
            font-weight: 700;
            font-size: 36px;
            margin-bottom: 20px;
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

    <!-- legal Section Begin -->
    <section class="terms spad">
        <div class="container">
            <div class="main-container">
                <div class="terms__box">
                    <div class="terms__text">
                        <div class="section-title">
                            <span>책임한계와 법적고지</span>
                        </div>
                        <p>롤링스톤(RollingStone)은 링크, 다운로드, 광고 등을 포함하여 본 웹 사이트에 포함되어 있거나, 본 웹 사이트를 통해 배포, 전송되거나, 본 웹 사이트에 포함되어 있는 서비스로부터 접근되는 정보(이하 "자료")의 정확성이나 신뢰성에 대해 어떠한 보증하지 않으며, 서비스상의, 또는 서비스와 관련된 광고, 기타 정보 또는 제안의 결과로서 디스플레이, 구매 또는 취득하게 되는 제품 또는 기타 정보(이하 "제품")의 질에 대해서도 어떠한 보증도 하지 않습니다.</p>
                        <br>
                        
                        <p>귀하는, 자료에 대한 신뢰 여부가 전적으로 귀하의 책임임을 인정합니다. 롤링스톤(RollingStone)은 자료 및 서비스의 내용을 수정할 의무를 지지 않으나, 필요에 따라 개선할 수는 있습니다.롤링스톤(RollingStone)은 자료와 서비스를 "있는 그대로" 제공하며, 서비스 또는 기타 자료 및 제품과 관련하여 상품성, 특정 목적에의 적합성에 대한 보증을 포함하되 이에 제한되지 않고 모든 명시적 또는 묵시적인 보증을 명시적으로 부인합니다.</p>
                        <br>

                        <p>이어떠한 경우에도 롤링스톤(RollingStone)은 서비스, 자료 및 제품과 관련하여 직접, 간접, 부수적, 징벌적, 파생적인 손해에 대해서 책임을 지지 않습니다. 롤링스톤(RollingStone)은 본 웹사이트를 통하여 인터넷을 접속함에 있어 사용자의 개인적인 판단에 따라 하시기를 바랍니다. 본 웹사이트를 통해 일부 사람들이 불쾌하거나 부적절 하다고 여기는 정보가 포함되어 있는 사이트로 연결될 수 있습니다. 롤링스톤(RollingStone)은 본 웹사이트 또는 자료에 열거되어 있는 사이트의 내용을 검토하려는 노력과 관련하여 어떠한 보증도 하지 않습니다. 또한 롤링스톤(RollingStone)은 본 웹사이트 또는 자료에 열거되어 있는 사이트상의 자료의 정확성, 저작권 준수, 적법성 또는 도덕성에 대해 아무런 책임을 지지 않습니다.</p>
                        <br>

                        <p>롤링스톤(RollingStone)은 지적재산권을 포함한 타인의 권리를 존중하며, 사용자들도 마찬가지로 행동해주시기를 기대합니다. 롤링스톤(RollingStone)은 필요한 경우 그 재량에 의해 타인의 권리를 침해하거나 위반하는 사용자에 대하여 사전 통지 없이 서비스 이용 제한 조치를 취할 수 있습니다.</p>
                        <br>

                        <p>상표에 관한 정보</p>
                        <br>

                        <p>본 웹사이트에 포함된 제품 및/또는 서비스의 명칭은 롤링스톤(RollingStone)의 상표 또는 등록 상표입니다.</p>
                        <br>

                        <p>롤링스톤(RollingStone)은 이에 대한 권리를 가지고 있으며, 다른 제품 및 회사의 명칭은 그 해당 사용자들의 상표일 수 있습니다.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- legal Section End -->

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
