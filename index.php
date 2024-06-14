<?php
    include 'db.php';
    session_start();

    // 공모전 데이터 가져오기
    $heroSql = "SELECT img, homepage 
    FROM contests 
    WHERE DATEDIFF(finish_day, CURDATE()) > 0 
    ORDER BY DATEDIFF(finish_day, CURDATE()) DESC 
    LIMIT 20";
    $heroResult = $conn->query($heroSql);

    $heroImages = [];
    if ($heroResult->num_rows > 0) {
    while ($row = $heroResult->fetch_assoc()) {
    $heroImages[] = $row;
    }
    }

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>대학생 공모전 모음 | ROLLING STONE</title>

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
</head>

<body>
    <!-- Header Section Begin -->
    <?php include 'header.php'; ?>
    <!-- Header Section End -->

    <!-- Hero Section Begin -->
<section class="hero">
    <div class="hero__slider owl-carousel">
        <?php 
        // 중복 체크를 위한 배열
        $uniqueImages = [];
        
        foreach ($heroImages as $image) {
            // 이미지가 중복인지 확인
            if (!in_array($image['img'], array_column($uniqueImages, 'img'))) {
                $uniqueImages[] = $image; // 중복이 아니면 추가
            }
        }

        foreach (array_chunk($uniqueImages, 4) as $imageGroup) : ?>
            <div class="hero__slide">
                <?php foreach ($imageGroup as $image) : ?>
                    <div class="hero__card">
                        <a href="<?php echo htmlspecialchars($image['homepage']); ?>" target="_blank">
                            <img src="<?php echo htmlspecialchars($image['img']); ?>" alt="공모전 이미지">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Custom Navigation -->
    <div class="custom-nav">
        <button class="custom-prev">&#x2039;</button>
        <span class="custom-pagination">7/9</span>
        <button class="custom-next">&#x203A;</button>
    </div>
</section>
<!-- Hero Section End -->


    <!-- Product1 Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contest-header">
                        <h2 class="contest-title">공모전/대외활동</h2>
                    </div>
                    <ul class="filter__controls" id="contestFilters">
                        <li class="active" data-filter="전체">전체</li>
                        <li data-filter="기획, 아이디어">기획/아이디어</li>
                        <li data-filter="광고, 마케팅">광고/마케팅</li>
                        <li data-filter="논문, 리포트">논문/리포트</li>
                        <li data-filter="영상, UCC, 사진">영상/UCC/사진</li>
                        <li data-filter="디자인, 캐릭터, 웹툰">디자인/캐릭터/웹툰</li>
                        <li data-filter="웹, 모바일, IT">웹/모바일/IT</li>
                        <li data-filter="게임, 소프트웨어">게임/소프트웨어</li>
                        <li data-filter="과학, 공학">과학/공학</li>
                        <li data-filter="문학, 글, 시나리오">문학/글/시나리오</li>
                        <li data-filter="건축, 건설, 인테리어">건축/건설/인테리어</li>
                        <li data-filter="네이밍, 슬로건">네이밍/슬로건</li>
                        <li data-filter="예체능, 미술, 음악">예체능/미술/음악</li>
                        <li data-filter="봉사활동">봉사활동</li>
                        <li data-filter="취업, 창업">취업/창업</li>
                        <li data-filter="해외">해외</li>
                        <li data-filter="기타">기타</li>
                    </ul>
                </div>
            </div>
            <div class="row product__filter1">
                <!-- 공모전 항목 로드 -->
            </div>
            <div class="col-lg-12 text-center">
                <a href="#" class="view-more-button">더보기</a>
            </div>
        </div>
    </section>
    <!-- Product1 Section End -->

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
    <script>
        $(document).ready(function() {
            // Hero 슬라이더 초기화
            $(".hero__slider").owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 5000,
                nav: true,
                dots: true,
            });

            // 공모전 섹션 초기 로딩
            loadContests("전체");

            // 공모전 필터링 컨트롤 클릭 이벤트
            $('#contestFilters').on('click', 'li', function() {
                var category = $(this).attr('data-filter');
                loadContests(category);
                $('#contestFilters li').removeClass('active');
                $(this).addClass('active');
            });

            function loadContests(category) {
                $.ajax({
                    url: 'fetch_contests.php',
                    type: 'GET',
                    data: { category: category },
                    dataType: 'json',
                    success: function(data) {
                        var contestHtml = '';
                        $.each(data, function(index, contest) {
                            var daysLeft = calculateDaysLeft(contest.finish_day);
                            contestHtml += '<div class="col-lg-3 col-md-6 col-sm-6 mix ' + contest.field + '">';
                            contestHtml += '    <div class="product__item">';
                            contestHtml += '        <div class="product__item__pic" style="background-image: url(\'' + contest.img + '\');">';
                            contestHtml += '            <ul class="product__hover">';
                            contestHtml += '                <li><a href="#" onclick="addFavorite(' + contest.num + '); return false;"><img src="img/icon/heart.png" alt="Add to Favorites"></a></li>';  // contest.num을 contestId로 사용
                            contestHtml += '                <li><a href="' + contest.homepage + '" target="_blank"><img src="img/icon/search.png" alt="View Details"></a></li>';
                            contestHtml += '            </ul>';
                            contestHtml += '        </div>';
                            contestHtml += '        <div class="product__item__text">';
                            contestHtml += '            <h4>' + daysLeft + '</h4>'; 
                            contestHtml += '            <h5>' + contest.title + '</h5>';
                            contestHtml += '            <h6>' + contest.organizer + '</h6>';
                            contestHtml += '            <h7>' + contest.field + '</h7>';
                            contestHtml += '        </div>';
                            contestHtml += '    </div>';
                            contestHtml += '</div>';
                        });
                        $('.product__filter1').html(contestHtml);
                    }
                });
            }

            // 마감일로부터 남은 일수 계산
            function calculateDaysLeft(finishDay) {
                var now = new Date();
                var finishDate = new Date(finishDay);
                var timeDiff = finishDate.getTime() - now.getTime();
                var daysLeft = Math.ceil(timeDiff / (1000 * 3600 * 24));
                
                // 한 자리 수인 경우에는 "D-"와 함께 표시
                if (daysLeft >= 0) {
                    return 'D-' + (daysLeft < 10 ? '0' + daysLeft : daysLeft);
                } else {
                    return 'D' + (daysLeft > -10 ? '-0' + Math.abs(daysLeft) : daysLeft);
                }
            }

            // '더 보기' 버튼 클릭 이벤트
            $('.view-more-button').on('click', function(event) {
                event.preventDefault(); // 기본 동작 방지
                
                // 현재 활성화된 필터를 가져옴
                var activeFilter = $('#contestFilters li.active').attr('data-filter');
                
                // 필터에 대응하는 PHP 파일 이름 매핑
                var phpFileNames = {
                    '전체': 'contest_exhibit.php?category=전체',
                    '기획, 아이디어': 'contest_exhibit.php?category=기획/아이디어',
                    '광고, 마케팅': 'contest_exhibit.php?category=광고/마케팅',
                    '논문, 리포트': 'contest_exhibit.php?category=논문/리포트',
                    '영상, UCC, 사진': 'contest_exhibit.php?category=영상/UCC/사진',
                    '디자인, 캐릭터, 웹툰': 'contest_exhibit.php?category=디자인/캐릭터/웹툰',
                    '웹, 모바일, IT': 'contest_exhibit.php?category=웹/모바일/IT',
                    '게임, 소프트웨어': 'contest_exhibit.php?category=게임/소프트웨어',
                    '과학, 공학': 'contest_exhibit.php?category=과학/공학',
                    '문학, 글, 시나리오': 'contest_exhibit.php?category=문학/글/시나리오',
                    '건축, 건설, 인테리어': 'contest_exhibit.php?category=건축/건설/인테리어',
                    '네이밍, 슬로건': 'contest_exhibit.php?category=네이밍/슬로건',
                    '예체능, 미술, 음악': 'contest_exhibit.php?category=예체능/미술/음악',
                    '봉사활동': 'contest_exhibit.php?category=봉사활동',
                    '취업, 창업': 'contest_exhibit.php?category=취업/창업',
                    '해외': 'contest_exhibit.php?category=해외',
                    '기타': 'contest_exhibit.php?category=기타'
                };

                // 매핑된 파일 이름으로 이동
                var phpFileName = phpFileNames[activeFilter];
                if (phpFileName) {
                    window.location.href = phpFileName;
                } else {
                    console.error('매핑된 PHP 파일이 없습니다.');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var owl = $(".hero__slider").owlCarousel({
                loop: true,
                margin: 10,
                nav: false,
                autoplay: true,
                autoplayTimeout: 3000,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:2
                    },
                    1000:{
                        items:3
                    }
                }
            });

            // Custom Navigation Events
            $(".custom-prev").click(function() {
                owl.trigger('prev.owl.carousel');
            });

            $(".custom-next").click(function() {
                owl.trigger('next.owl.carousel');
            });

            // Update pagination dynamically (optional)
            owl.on('changed.owl.carousel', function(event) {
                var items = event.item.count;
                var item = event.item.index - event.relatedTarget._clones.length / 2;
                var currentIndex = item % items + 1;
                $(".custom-pagination").text(currentIndex + '/' + items);
            });
        });
    </script>
    <script type="text/javascript">
        function addFavorite(contestId) {
            var userId = '<?php echo isset($_SESSION['userid']) ? $_SESSION['userid'] : ''; ?>';
            
            if (!userId) {
                alert('로그인이 필요합니다.');
                window.location.href = 'login.php';
                return;
            }

            $.ajax({
                url: 'add_favorite.php',
                type: 'POST',
                data: {
                    'userId': userId,
                    'contestId': contestId
                },
                success: function(response) {
                    alert(response); // 성공 응답 메시지 출력
                },
                error: function(xhr, status, error) {
                    alert("Error: " + xhr.responseText); // 오류 응답 메시지 출력
                }
            });
        }
    </script>
</body>
</html>
