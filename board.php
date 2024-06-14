<?php
    include 'db.php';

    session_start();

    $board_id = isset($_GET['board_id']) ? intval($_GET['board_id']) : 0;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $posts_per_page = 10;
    $offset = ($page - 1) * $posts_per_page;

    // 검색 조건 처리
    $search_type = isset($_GET['search_type']) ? $_GET['search_type'] : '';
    $search_keyword = isset($_GET['search_keyword']) ? trim($_GET['search_keyword']) : '';

    // 정렬 기준 처리
    $order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'created_at';
    $order_dir = isset($_GET['order_dir']) ? $_GET['order_dir'] : 'DESC';

    // 최신순 및 오래된순의 option 값 변경에 따른 처리
    if ($order_by == 'created_at_new') {
        $order_by = 'created_at';
        $order_dir = 'DESC';
    } elseif ($order_by == 'created_at_old') {
        $order_by = 'created_at';
        $order_dir = 'ASC';
    }

    $where_clause = "1=1";
    $params = [];
    $types = "";

    if ($board_id != 0) {
        $where_clause .= " AND board_id = ?";
        $params[] = $board_id;
        $types .= "i";
    }

    if (!empty($search_keyword)) {
        if ($search_type == 'title') {
            $where_clause .= " AND title LIKE ?";
        } elseif ($search_type == 'user_name') {
            $where_clause .= " AND user_name LIKE ?"; 
        }
        $params[] = "%" . $search_keyword . "%";
        $types .= "s";
    }

    // 게시물 가져오기 쿼리
    $sql = "SELECT * FROM posts WHERE $where_clause ORDER BY $order_by $order_dir LIMIT ? OFFSET ?";
    $params[] = $posts_per_page;
    $params[] = $offset;
    $types .= "ii";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    // 게시판 목록 가져오기 쿼리
    $boards_sql = "SELECT * FROM boards";
    $boards_result = $conn->query($boards_sql);

    // 총 게시물 수 가져오기 쿼리
    $total_posts_sql = "SELECT COUNT(*) as total FROM posts WHERE $where_clause";
    $total_stmt = $conn->prepare($total_posts_sql);

    // total_stmt를 위한 $params에서 LIMIT과 OFFSET 제거
    $total_params = array_slice($params, 0, count($params) - 2);
    $total_types = substr($types, 0, strlen($types) - 2);

    if (!empty($total_types)) {
        $total_stmt->bind_param($total_types, ...$total_params);
    }
    $total_stmt->execute();
    $total_result = $total_stmt->get_result();
    $total_posts = $total_result->fetch_assoc()['total'];
    $total_pages = ceil($total_posts / $posts_per_page);
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>커뮤니티 게시판 | ROLLING STONE</title>

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
        }
        .container {
            margin-top: 20px;
        }
        .table {
            margin-top: 20px;
        }
        .table a {
            color: #3e424f; 
        }
        .table a:hover {
            color: #E53637; 
        }
        .list-group-item a {
            color: #3e424f;
        }
        .list-group-item a:hover {
            color: #E53637;
        }
        .pagination {
            justify-content: center;
        }
        #preloder .loader {
            width: 50px;
            height: 50px;
            border: 5px solid #003cff;
            border-radius: 50%;
            border-top: 5px solid #3e424f;
            animation: spin 2s linear infinite;
        }
        footer {
            margin-top: 100px;
        }
        .btn-primary {
            background-color: #E53637 !important;
            border-color: #E53637 !important;
            color: #fff; /* 버튼 텍스트 색상 추가 */
            transition: background-color 0.3s, border-color 0.3s, color 0.3s; /* 트랜지션 추가 */
        }
        .btn-primary:hover {
            background-color: #ff6b6e !important;
            border-color: #ff6b6e !important;
            color: #fff; /* 버튼 텍스트 색상 추가 */
        }
        .page-item .page-link {
            color: #3e424f; /* 페이지 버튼 숫자 색상 */
            background-color: #fff; /* 페이지 버튼 배경색 */
            border-color: #dee2e6; /* 페이지 버튼 테두리 색상 */
        }
        .page-item.active .page-link {
            background-color: #E53637; /* 선택된 페이지 버튼 배경색 */
            border-color: #E53637; /* 선택된 페이지 버튼 테두리 색상 */
            color: #fff; /* 선택된 페이지 버튼 숫자 색상 */
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .code-box {
            border: 1px solid #eaeaea;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            overflow-x: auto;
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

    <!-- board Section Begin -->
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            <br><br><h4 style="font-weight: bold;">게시판 종류</h4><br>
                <nav>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="board.php?board_id=0">전체</a></li>
                        <?php while ($board = $boards_result->fetch_assoc()) { ?>
                            <li class="list-group-item"><a href="board.php?board_id=<?= $board['id'] ?>"><?= htmlspecialchars($board['name']) ?></a></li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
            <div class="col-md-9">
                <?php
                    $board_names = array(0 => "전체", 1 => "자유", 2 => "연애", 3 => "꿀팁", 4 => "논쟁", 5 => "기타");
                    $selected_board_name = isset($board_names[$board_id]) ? $board_names[$board_id] : "커뮤니티";
                    if ($selected_board_name === "전체") {
                        echo "<h4 style='font-weight: bold;'>{$selected_board_name} 게시판</h4>";
                    } else {
                        echo "<h4>{$selected_board_name} 게시판</h4>";
                    }
                ?>
            <div class="text-right mb-3">
                <a href="create_post.php" class="btn btn-primary">새 글 작성</a>
            </div>

            <!-- 검색 폼 추가 -->
            <form method="GET" action="board.php" class="form-inline mb-3">
                <input type="hidden" name="board_id" value="<?= $board_id ?>">
                <div class="form-group">
                    <label for="search_type" class="mr-2">검색 : </label>
                    <select name="search_type" id="search_type" class="form-control mr-2">
                        <option value="title" <?= $search_type == 'title' ? 'selected' : '' ?>>제목</option>
                        <option value="user_name" <?= $search_type == 'usrid' ? 'selected' : '' ?>>작성자</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="search_keyword" id="search_keyword" class="form-control mr-2" value="<?= htmlspecialchars($search_keyword) ?>" placeholder="검색어">
                </div>
                <button type="submit" class="btn btn-secondary">검색</button>
            </form>

            <!-- 정렬 폼 추가 -->
            <form method="GET" action="board.php" class="form-inline mb-3">
                <input type="hidden" name="board_id" value="<?= $board_id ?>">
                <div class="form-group">
                    <label for="order_by" class="mr-2">정렬 : </label>
                    <select name="order_by" id="order_by" class="form-control mr-2">
                        <option value="created_at_new" <?= $order_by == 'created_at' && $order_dir == 'DESC' ? 'selected' : '' ?>>최신순</option>
                        <option value="created_at_old" <?= $order_by == 'created_at' && $order_dir == 'ASC' ? 'selected' : '' ?>>오래된순</option>
                        <option value="views" <?= $order_by == 'views' ? 'selected' : '' ?>>조회수순</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-secondary">정렬</button>
            </form>

            <table class="table">
                <thead>
                    <tr>
                        <th>번호</th>
                        <th>제목</th>
                        <th>작성자</th> 
                        <th>작성일</th>
                        <th>조회수</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($post = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($post['id']) ?></td>
                            <td><a href="view_post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></td>
                            <td><?= htmlspecialchars($post['user_name']) ?></td>
                            <td><?= htmlspecialchars($post['created_at']) ?></td>
                            <td><?= htmlspecialchars($post['views']) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link" href="board.php?board_id=<?= $board_id ?>&page=<?= $i ?>&order_by=<?= $order_by ?>&order_dir=<?= $order_dir ?>"><?= $i ?></a></li>
                    <?php } ?>
                </ul>
            </nav>
            </div>
        </div>
    </div>
    <!-- board Section End -->

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