<?php
session_start();
include 'db.php';

// 카테고리에 따른 필터링 조건 정의
$categoryFilters = array(
    '예체능' => "field LIKE '%예체능%' OR field LIKE '%미술%' OR field LIKE '%음악%'",
    '기획/아이디어' => "field LIKE '%기획%' OR field LIKE '%아이디어%'",
    '웹/모바일/IT' => "field LIKE '%웹%' OR field LIKE '%모바일%' OR field LIKE '%IT%'",
    '봉사활동' => "field LIKE '%봉사활동%'",
    '논문/리포트' => "field LIKE '%논문%' OR field LIKE '%리포트%'",
    '과학/공학' => "field LIKE '%과학%' OR field LIKE '%공학%'",
    '해외' => "field LIKE '%해외%'",
    '기타' => "field LIKE '%기타%'",
    '네이밍/슬로건' => "field LIKE '%네이밍%' OR field LIKE '%슬로건%'",
    '광고/마케팅' => "field LIKE '%광고%' OR field LIKE '%마케팅%'",
    '건축/건설/인테리어' => "field LIKE '%건축%' OR field LIKE '%건설%' OR field LIKE '%인테리어%'",
    '디자인/캐릭터/웹툰' => "field LIKE '%디자인%' OR field LIKE '%캐릭터%' OR field LIKE '%웹툰%'",
    '취업/창업' => "field LIKE '%취업%' OR field LIKE '%창업%'",
    '게임/소프트웨어' => "field LIKE '%게임%' OR field LIKE '%소프트웨어%'",
    '영상/UCC/사진' => "field LIKE '%영상%' OR field LIKE '%UCC%' OR field LIKE '%사진%'",
    '문학/글/시나리오' => "field LIKE '%문학%' OR field LIKE '%글%' OR field LIKE '%시나리오%'"
);

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>공모전/대외활동 검색 | ROLLING STONE</title>

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
            background-color: #F5F5F5;
        }

        .main-content {
            background-color: #ffffff;
            padding: 40px 20px;
            margin: 20px auto;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
        }

        .container_row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px; /* 카드 간격 */
            padding: 20px;
            margin: 0 auto; /* 양쪽 공백 균형 */
        }

        .card {
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
            transition: box-shadow 0.3s ease-in-out;
            width: calc(25% - 40px); /* 4개 열로 맞추기 위한 너비 */
            margin: 10px;
            text-align: center;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card h3 {
            font-size: clamp(1rem, 1.1vw, 1.1rem);
            margin: 15px 10px;
            color: #333;
            height: 3em;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .days-left {
            font-size: 18px;
            color: #ffffff;
            font-weight: bold;
            background-color: #ff6f61;
            padding: 5px 10px;
            border-radius: 10px;
            animation: pulse 2s infinite;
            display: inline-block;
            margin-bottom: 5px;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 5px rgba(255, 111, 97, 0.6);
            }
            50% {
                transform: scale(1.1);
                box-shadow: 0 0 15px rgba(255, 111, 97, 1);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 5px rgba(255, 111, 97, 0.6);
            }
        }

        .apply-btn {
            display: block;
            background-color: #666666;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 0;
            transition: background-color 0.3s;
        }

        .apply-btn:hover {
            background-color: #000000;
        }

        .pagination {
            display: flex;
            justify-content: center;
            padding: 20px 0;
            margin-top: 40px; /* 페이지네이션과 카드 사이의 마진 */
            margin-bottom: 40px; /* 페이지네이션과 푸터 사이의 마진 */
            list-style: none;
        }

        .page-item {
            margin: 0 5px;
        }

        .page-link {
            display: block;
            padding: 10px 15px;
            color: #fff; /* 글자 색상을 하얀색으로 설정 */
            background-color: #666666; /* 배경색을 #666666으로 설정 */
            border: 1px solid #dee2e6;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }

        .page-link:hover {
            background-color: #000000; /* 호버 시 배경색을 검정색으로 설정 */
            border-color: #000000;
            color: #fff; /* 호버 시 글자 색상을 하얀색으로 유지 */
        }

        .page-item.active .page-link {
            color: #fff;
            background-color: #000000;
            border-color: #000000;
        }

        .page-item:first-child .page-link,
        .page-item:last-child .page-link {
            border-radius: 5px;
        }

        .contest-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .contest-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            padding: 10px 20px;
            border-bottom: 2px solid #ff6f61;
            display: inline-block;
        }

        /* 컨테이너 스타일 */
        .form-and-filters-container {
            display: flex;
            justify-content: space-between; /* 양쪽으로 공간 분배 */
            align-items: center; /* 세로축 가운데 정렬 */
            padding: 20px;
        }

        .filter-buttons {
            display: flex;
            justify-content: right;
            gap: 10px;
            margin-bottom: 5px;
            margin-left: 2vw;
        }
        .filter-buttons button {
            padding: 10px 20px;
            border: none;
            background-color: #2e2e2e;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .filter-buttons button:hover {
            background-color: #000000;
            transform: scale(1.05);
        }
        .form-container {
            display: flex;
            justify-content: flex-end; /* 폼을 오른쪽으로 정렬 */
        }
        /* 검색 폼 스타일 */
        .form-container {
            display: flex;
            justify-content: flex-end; /* 폼을 오른쪽으로 정렬 */
        }

        /* 검색 폼 스타일 */
        .search-form {
            display: flex;
            align-items: center;
        }

        /* 입력 필드 스타일 */
        input[type="text"] {
            width: 250px; /* 고정된 너비 설정 */
            padding: 11px;
            border: 2px solid #ff6f61; /* 테두리 색상 변경 */
            border-radius: 5px; /* 왼쪽 모서리 둥글게 */
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
        }

        /* 검색 버튼 스타일 */
        button {
            padding: 9px 20px;
            font-size: 18px;
            font-family: 'Poppins', sans-serif;
            background-image: linear-gradient(to right, #ff6f61, #ff6f61); /* 그라디언트 배경 색상 변경 */
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-block;
            vertical-align: middle; /* 버튼이 인풋 필드와 동일한 높이에 위치하도록 조정 */
            flex-shrink: 0; /* 버튼의 크기가 줄어들지 않도록 설정 */
        }

        /* 검색 버튼에 마우스를 올렸을 때의 스타일 */
        button:hover {
            background-image: linear-gradient(to right, #e04e3d, #e04e3d); /* 진한 색상으로 변경 */
            box-shadow: 0 4px 15px rgba(255,111,97,0.4); /* 부드러운 그림자 효과 */
            transform: scale(1.05);
        }

        @media (max-width: 992px) {
            .card {
                width: calc(50% - 40px); /* 모바일에서도 균일하게 조정 */
            }
        }
        @media (max-width: 768px) {
            .card {
                width: calc(50% - 40px); /* 모바일에서도 균일하게 조정 */
            }
        }
        @media (max-width: 480px) {
            .card {
                width: 100%; /* 매우 작은 화면에서 전체 폭 사용 */
            }
        }
    </style>
</head>
<body>
    <!-- Header Section Begin -->
    <?php include 'header.php'; ?>
    <!-- Header Section End -->

    <?php
    include 'db.php';

    // 검색 쿼리를 변수에 저장
    $query = isset($_GET['query']) ? $_GET['query'] : '';

    // 페이지 번호 설정
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 12;  // 한 페이지에 표시할 항목 수
    $offset = ($page - 1) * $limit;
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'finish_day';  // 정렬 기준
    ?>
    <!-- Main Content Begin -->
    <div class="main-content">
        <div class="container_poster">
            <div class="contest-header">
                <!-- 검색어가 없을 때 "전체"로 출력 -->
                <h2 class='contest-title'>공모전/대외활동 - <?php echo htmlspecialchars($query ? $query : '전체'); ?></h2>
            </div>

            <!-- Form and Filter Buttons Container -->
            <div class="form-and-filters-container">
                <!-- Filter Buttons Begin -->
                <div class="filter-buttons">
                    <button id="sort-random" onclick="sortContests('random')">랜덤</button>
                    <button id="sort-deadline" onclick="sortContests('deadline')">마감순</button>
                    <button id="sort-remaining" onclick="sortContests('remaining')">여유순</button>
                </div>
                <!-- Filter Buttons End -->

                <div class="form-container">
                    <div class="search-form">
                        <form action="search.php" method="get">
                            <input type="text" name="query" placeholder="공모전의 제목을 검색해보세요 : )" required value="<?php echo htmlspecialchars($query); ?>">
                            <button type="submit">검색</button>
                        </form>
                    </div>
                </div>
            </div>

            <?php
                // 검색 쿼리나 카테고리가 설정되어 있는지 확인
                $isSearch = isset($_GET['query']) || isset($_GET['category']);
                $query = isset($_GET['query']) ? $_GET['query'] : '';
                $category = isset($_GET['category']) ? $_GET['category'] : '';
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 12;
                $offset = ($page - 1) * $limit;
                $sort = isset($_GET['sort']) ? $_GET['sort'] : 'finish_day';

                try {
                    $db = new PDO("mysql:host=localhost;dbname=rollingstone_db", "root", "park9570");
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // 카테고리 조건 설정
                    $categoryCondition = '1=1';

                    // 정렬 옵션에 따라 SQL 쿼리를 생성
                    $orderBy = '';
                    switch ($sort) {
                        case 'random':
                            $orderBy = 'ORDER BY RAND()';
                            break;
                        case 'deadline':
                            $orderBy = 'ORDER BY finish_day';
                            break;
                        case 'remaining':
                            $orderBy = 'ORDER BY daysLeft DESC';
                            break;
                        default:
                            $orderBy = 'ORDER BY finish_day';
                            break;
                    }

                    // SQL 쿼리 생성
                    if ($isSearch) {
                        $sql = "SELECT *, DATEDIFF(finish_day, CURDATE()) AS daysLeft 
                                FROM contests 
                                WHERE (title LIKE :query OR :query = '') 
                                  AND finish_day > CURDATE() 
                                  AND ($categoryCondition)
                                $orderBy 
                                LIMIT :limit OFFSET :offset";
                    } else {
                        $sql = "SELECT *, DATEDIFF(finish_day, CURDATE()) AS daysLeft 
                                FROM contests 
                                WHERE finish_day > CURDATE() 
                                $orderBy 
                                LIMIT :limit OFFSET :offset";
                    }

                    $stmt = $db->prepare($sql);
                    $likeQuery = '%' . $query . '%';
                    if ($isSearch) {
                        $stmt->bindParam(':query', $likeQuery);
                    }
                    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                    $stmt->execute();
                    $contests = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $sqlCount = "SELECT COUNT(*) 
                                 FROM contests 
                                 WHERE (title LIKE :query OR :query = '') 
                                   AND finish_day > CURDATE() 
                                   AND ($categoryCondition)";
                    $stmtCount = $db->prepare($sqlCount);
                    if ($isSearch) {
                        $stmtCount->execute(['query' => '%' . $query . '%']);
                    } else {
                        $stmtCount->execute(['query' => '%%']);
                    }
                    $total_results = $stmtCount->fetchColumn();
                    $total_pages = ceil($total_results / $limit);

                    // daysLeft가 0인 항목 분리
                    $zeroDaysContests = array_filter($contests, function($contest) {
                        return $contest['daysLeft'] <= 0;
                    });

                    // daysLeft가 0이 아닌 항목들만 남김
                    $contests = array_filter($contests, function($contest) {
                        return $contest['daysLeft'] > 0;
                    });

                    // 정렬 방식에 따라 정렬
                    if ($sort == 'remaining') {
                        usort($contests, function($a, $b) {
                            return $b['daysLeft'] - $a['daysLeft'];
                        });
                    } elseif ($sort == 'random') {
                        shuffle($contests);
                    } else {
                        usort($contests, function($a, $b) {
                            return $a['daysLeft'] - $b['daysLeft'];
                        });
                    }

                    // 0일 남은 항목을 마지막에 추가
                    $contests = array_merge($contests, $zeroDaysContests);

                    // 결과 출력
                    if ($contests) {
                        echo "<div class='container_row'>";
                        foreach ($contests as $contest) {
                            $daysLeft = max($contest['daysLeft'], 0);
                            echo "<div class='card'>";
                            echo "<img src='" . htmlspecialchars($contest["img"]) . "' alt='Image'>";
                            echo "<h3>" . htmlspecialchars($contest["title"]) . "</h3>";
                            echo "<span class='days-left'>D-" . $daysLeft . "</span>";
                            echo "<a class='apply-btn' href='contest_detail.php?contest_id=" . $contest["num"] . "'>자세히보기</a>";
                            echo "</div>";
                        }
                        echo "</div>";

                        // 페이지네이션 로직
                        $pages_per_segment = 10;
                        $current_segment = ceil($page / $pages_per_segment);

                        echo "<nav aria-label='Page navigation' style='margin-bottom: 40px;'>";
                        echo "<ul class='pagination justify-content-center'>";

                        $start_page = ($current_segment - 1) * $pages_per_segment + 1;
                        $end_page = min($total_pages, $current_segment * $pages_per_segment);

                        if ($current_segment > 1) {
                            $prev_segment_start = $start_page - $pages_per_segment;
                            echo "<li class='page-item'><a class='page-link' href='?query=" . urlencode($query) . "&page=" . $prev_segment_start . "&sort=" . $sort . "' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
                        }

                        for ($i = $start_page; $i <= $end_page; $i++) {
                            $active_class = $i == $page ? 'active' : '';
                            echo "<li class='page-item " . $active_class . "'><a class='page-link' href='?query=" . urlencode($query) . "&page=" . $i . "&sort=" . $sort . "'>" . $i . "</a></li>";
                        }

                        if ($end_page < $total_pages) {
                            $next_segment_start = $end_page + 1;
                            echo "<li class='page-item'><a class='page-link' href='?query=" . urlencode($query) . "&page=" . $next_segment_start . "&sort=" . $sort . "' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
                        }

                        echo "</ul>";
                        echo "</nav>";
                    } else {
                        echo "<div class='container_row'>";
                        echo '<p>검색 결과가 없습니다. 정확한 검색어를 입력해보세요 : )</p>';
                        echo '</div>';
                    }
                } catch (PDOException $e) {
                    echo '데이터베이스 연결 실패: ' . $e->getMessage();
                }
            ?>
        </div>
    </div>

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
        function sortContests(sortType) {
            const urlParams = new URLSearchParams(window.location.search);
            const query = urlParams.get('query') || '';
            window.location.href = '?query=' + query + '&sort=' + sortType;
        }
    </script>
</body>
</html>