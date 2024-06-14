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
    <title>이용약관 | ROLLING STONE</title>

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
        .terms__text h4 {
            font-weight: bold;
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

    <!-- Terms Section Begin -->
    <section class="terms spad">
        <div class="container">
            <div class="main-container">
                <div class="terms__box">
                    <div class="terms__text">
                        <div class="section-title">
                            <span>이용약관</span>
                        </div>
                        <h4>제1조 (목적)</h4>
                        <p>본 약관은 전기통신사업법 및 동법 시행령에 의하여 롤링스톤(RollingStone)에서 운영하는 rollingstone.com(이하 "롤링스톤")과 이용자간에 정보 서비스를 이용하는 조건 및 절차에 관한 필요한 사항을 약속하여 규정하는데 그 목적이 있습니다.</p>
                        <br>
                        
                        <h4>제2조 (효력의 발생 및 변경)</h4>
                        <p>1. 본 약관은 온라인을 통하여 이용자에게 공시함으로써 효력을 발생합니다.</p>
                        <p>2. 본 약관은 롤링스톤(RollingStone)의 영업상 중요한 사유 또는 관계 법령에 의한 변경사유가 있을 때, 약관을 변경 할 수 있으며, 약관을 개정할 경우에는 적용일자 및 개정사유를 명시하여 현행약관과 함께 회사 홈페이지의 공지게시판에 그 적용일자 7일 이전부터 적용일자 전일까지 공지합니다. 다만, 이용자에게 불리하게 약관내용을 변경하는 경우에는 최소한 30일 이상의 사전 유예기간을 두고 공지합니다. 이 경우 롤링스톤(RollingStone)은 개정 전 내용과 개정 후 내용을 명확하게 비교하여 이용자가 알기 쉽도록 표시합니다.</p>
                        <p>3. 본 약관에 명시되지 않은 사항은 전기통신기본법, 전기통신사업법, 정보통신망이용촉진 등에 관한 법률 및 기타 관련 법령의 규정에 따릅니다.</p>
                        <br>

                        <h4>제3조 (이용자 구분)</h4>
                        <p>1. 일반 이용자 : 롤링스톤(RollingStone)의 모든 서비스는 회원가입 없이 무상으로 이용할 수 있습니다.</p>
                        <p>2. 메일링 이용자 : 본인의 이메일을 등록하여 롤링스톤(RollingStone)가 제공하는 다양한 대외활동 정보를 제공받을 수 있습니다.</p>
                        <p>3. 기업 이용자 : 개인, 기업, 단체, 기관 종사자가 대외활동 정보를 작성함으로써 기업 이용자가 됩니다.</p>
                        <br>

                        <h4>제4조 (이용계약의 성립)</h4>
                        <p>1. 이용 계약의 성립은 이용자의 이용신청에 대하여 당사의 이용승낙과 이용자의 약관 내용에 대한 동의로 성립됩니다.</p>
                        <p>2. 메일링 이용자, 기업 이용자는 롤링스톤(RollingStone)의 서비스의 이용을 원하시는 경우는 당사에서 요청하는 개인신상정보를 당사에 제공하여야 합니다.</p>
                        <p>3. 회사는 다음 사항에 대해서는 이용신청을 거절 할 수 있습니다.</p>
                        <ul>
                            <p> - 가명으로 신청을 한 경우</p>
                            <p> - 타인의 명의를 빌리거나 도용하여 차명으로 신청을 한 경우</p>
                            <p> - 이용신청서의 내용을 허위로 작성한 경우나 허위 서류를 첨부하여 신청한 경우</p>
                            <p> - 관계 법령에 위배되거나 사회의 안녕, 질서, 미풍양속을 저해할 수 있는 목적으로 신청을 한 경우</p>
                            <p> - 롤링스톤(RollingStone) 및 이용자의 이익에 위배되거나 저해할 목적으로 신청한 경우</p>
                            <p> - 롤링스톤(RollingStone)가 실시하는 설문에 불성실하게 응답하거나 참여를 거부하는 경우</p>
                        </ul>
                        <br>

                        <h4>제5조 (서비스의 이용)</h4>
                        <p>1. 서비스의 이용은 롤링스톤(RollingStone)의 업무상 또는 기술상 특별한 지장이 없는 한 연중무휴, 1년 24시간 서비스하는 것을 원칙으로 합니다.</p>
                        <p>2. 시스템 정기점검 등의 필요로 인하여 롤링스톤(RollingStone)가 정한 날 또는 시간은 예외로 합니다.</p>
                        <p>3. 이용계약이 성립된 후 당사의 동의 없이 임의로 회원 ID를 변경하여 서비스를 이용할 수 없습니다.</p>
                        <p>4. 스폰서회원의 요구에 의한 이용범위가 제한된 경우는 서비스 이용을 제한할 수 있습니다.</p>
                        <br>

                        <h4>제6조 (롤링스톤의 의무)</h4>
                        <p>1. 롤링스톤(RollingStone)은 특별한 사정이 없는 한 이용자의 서비스 이용신청에 대해 즉시 서비스를 이용 할 수 있도록 합니다.</p>
                        <p>2. 롤링스톤(RollingStone)은 이 약관에서 정한 바에 따라 계속적, 안정적으로 서비스를 제공할 의무가 있습니다.</p>
                        <p>3. 롤링스톤(RollingStone)은 이용자의 개인 신상정보를 본인의 승낙 없이 타인에게 누설, 배포하지 않습니다. 다만, 관계법령에 의한 국가 기관 등의 합법적인 요구가 있는 경우에는 예외로 합니다.</p>
                        <p>4. 롤링스톤(RollingStone)은 이용자로부터 제기되는 의견이나 불만이 정당하다고 인정되면 즉시 처리합니다. 다만, 즉시 처리가 곤란한 경우에는 이용자에게 그 사유와 처리 일정을 통보합니다.</p>
                        <br>

                        <h4>제7조 (이용자 권리와 의무)</h4>
                        <p>1. 메일링 신청 이용자는 롤링스톤(RollingStone)가 발송하는 메일에 대해 수신을 거부할 수 있습니다.</p>
                        <p>2. 롤링스톤(RollingStone)의 저작권, 소유권 또는 제3자의 저작권 등 기타 권리를 침해하지 않아야 합니다.</p>
                        <p>3. 이용자는 이 약관 및 관계 법령에서 규정한 사항을 준수해야 합니다.</p>
                        <br>

                        <h4>제8조 (이용자격의 제한 및 정지)</h4>
                        <p>1. 롤링스톤(RollingStone)은 이용자가 다음 각 호에 해당하는 사실이 발견되었을 경우 사전 통지 없이 이용 계약을 해지하거나 또는 기간을 정하여 서비스 이용을 제한할 수 있습니다.</p>
                        <ul>
                            <p> - 롤링스톤(RollingStone)가 제공하는 자원을 사용하여 공공질서, 사회적 통념에 반하는 행위를 한 경우</p>
                            <p> - 롤링스톤(RollingStone)가 제공하는 자원을 사용하여 사회적 공익을 저해할 목적으로 서비스 이용을 계획 또는 실행한 경우</p>
                            <p> - 롤링스톤(RollingStone)가 제공하는 자원을 이용하여 범죄적 행위에 관련된 행위를 한 경우</p>
                            <p> - 타인의 명예를 손상시키거나 불이익을 주는 행위를 한 경우</p>
                            <p> - 제 9 조에서 정한 각 호에 해당된다고 판단되는 경우</p>
                            <p> - 롤링스톤(RollingStone)에서 요구하는 개인정보에 대해 허위임이 판명된 경우</p>
                        </ul>
                        <br>

                        <h4>제9조 (게시물)</h4>
                        <p>1.롤링스톤(RollingStone)은 롤링스톤(RollingStone)가 제공하는 서비스의 이용자가 게시하거나 등록하는 내용물이 다음 각 호에 해당된다고 판단되는 경우 사전 통지 없이 삭제합니다.</p>
                        <ul>
                            <p> - 다른 이용자 또는 제3자의 명예를 손상시키는 내용인 경우</p>
                            <p> - 국가의 안전을 위태롭게 하는 내용인 경우</p>
                            <p> - 공공의 안녕질서 및 미풍약속을 해치는 내용인 경우</p>
                            <p> - 국가의 경제질서를 파괴하거나 경제발전에 위해가 되는 내용인 경우</p>
                            <p> - 범죄행위 및 기타 법률에서 금지하는 내용인 경우</p>
                            <p> - 광고성 게시물을 무단 게재한 경우 </p>
                            <p> - 기타 롤링스톤(RollingStone)에서 정한 규정에 위배되는 경우</p>
                            <p> - 서비스내에 게시되거나 등록된 자료의 지적재산권은 롤링스톤(RollingStone)에 있습니다.</p>
                            <p> - 이용자는 서비스를 이용하여 얻은 정보를 가공, 판매하는 행위 등 서비스에 게재된 자료를 상업적으로 이용할 수 없습니다.</p>
                        </ul>
                        <br>

                        <h4>제10조 (개인정보 삭제)</h4>
                        <p>1.롤링스톤(RollingStone)은 회원서비스를 운영하지 않고 있으며 상시적 이벤트나 정보 제공을 요청 할 경우 해당 목적이 끝나는 즉시 파기합니다. </p>
                        <p>2.롤링스톤(RollingStone)에 개인정보를 제공 한 경우 그 이용자는 상시적으로 개인정보 삭제를 요청할 수 있습니다.</p>
                        <br>

                        <h4>제11조 (정보제공)</h4>
                        <p>롤링스톤(RollingStone)은 이용자가 서비스 이용 중 반드시 필요하다고 인정되는 정보는 전자우편으로 이용자에게 제공할 수 있습니다.</p>
                        <br>

                        <h4>제12조 (유료서비스의 이용)</h4>
                        <p>1.롤링스톤(RollingStone) 내의 유료 서비스는 롤링스톤(RollingStone) 혹은 전문 제휴업체가 자체 운영합니다.</p>
                        <p>2.제휴 서비스의 경우, 해당 업체가 독자적으로 소유하고 운영하며 해당 업체의 전적인 책임 하에 있습니다.</p>
                        <p>3.롤링스톤(RollingStone)은 판매 업체의 온라인 혹은 오프라인 활동, 판매, 공급, 환불, A/S, 온라인 접속 또는 접속 불능으로 인한 어떠한 손해, 손실, 상해 등 이용자와 입점업체간에 행하여지는 거래에 대해서 명시적으로 어떠한 책임이나 의무도 부담하지 아니합니다.</p>
                        <p>4.모든 제휴 서비스에 대한 문의는 명시된 각 서비스 업체의 고객센터로 하실 수 있습니다.</p>
                        <br>
                        
                        <h4>제13조 (유료 서비스 대금 결제)</h4>
                        <p>1.롤링스톤(RollingStone) 내에서 구매한 재화 또는 용역에 대한 대금 지급은 신용카드 결제, 인터넷계좌이체, 핸드폰 결제 등의 방법으로 할 수 있습니다.</p>
                        <p>2.결제 정보 유출로 인한 피해가 발생할 경우 롤링스톤(RollingStone)가 책임을 집니다. 단, 이용자의 과실인 경우 책임은 해당 이용자에게 있으며 롤링스톤(RollingStone)은 책임을 지지 않습니다.</p>
                        <br>

                        <h4>제14조 (면책 조항)</h4>
                        <p>1.롤링스톤(RollingStone)은 천재지변 또는 기타 불가항력적인 사유로 인해 서비스를 제공할 수 없는 경우에는 서비스 제공 중지에 대한 책임을 면합니다.</p>
                        <p>2.롤링스톤(RollingStone)은 이용자의 귀책 사유로 인한 서비스 이용의 장애에 대하여 책임을 지지않습니다.</p>
                        <p>3.롤링스톤(RollingStone)은 이용자가 서비스를 이용하여 얻은 정보 등으로 인해 입은 손해등에 대해서는 책임을 지지 않습니다.</p>
                        <p>4.롤링스톤(RollingStone)은 회원이 게시판을 통해 게재한 정보, 자료, 사실의 신뢰성, 정확성 등 내용에 관해서는 책임을 지지 않습니다.</p>

                        <br>

                        <h4>제15조 (관할 법원)</h4>
                        <p>전자상거래등에서의소비자보호에관한법률 제36조(전속관할) 조항에 따라, 롤링스톤(RollingStone)와 이용자간에 발생한 전자거래 분쟁에 관한 소송은 제소 당시의 이용자의 주소에 의하고, 주소가 없는 경우에는 거소를 관할하는 지방법원의 전속 관할로 합니다.다만, 제소 당시 이용자의 주소 또는 거소가 분명하지 아니 하거나, 외국 거주자의 경우에는 민사소송법상의 관할법원에 제기합니다.</p>
                        <br>

                        <h4>제16조 (약관외 준칙)</h4>
                        <p>본 약관에 명시되지 않은 준칙에 대해서는 정보통신사업법등 관계 법령에 따릅니다.</p>
                        <br>

                        <p style="color: #E53637; font-weight: bold;">이 약관은 2024년 6월 3일부터 적용 됩니다.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Terms Section End -->

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