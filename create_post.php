<?php
include 'db.php';

session_start();

if (!isset($_SESSION['userid'])) {
    echo "<script>
        if (confirm('커뮤니티 게시글 작성은 회원만 가능합니다. 로그인 후 이용해주세요 : )')) {
            window.location.href = 'login.php';
        } else {
            window.location.href = 'board.php';
        }
    </script>";
    exit;
}

$boards_sql = "SELECT * FROM boards";
$boards_result = $conn->query($boards_sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $board_id = intval($_POST['board_id']);
    $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_STRING);
    $user_id = $_SESSION['userid'];  
    $user_name = $_SESSION['username'];
    $content = filter_var(trim($_POST['content']), FILTER_SANITIZE_STRING);

    $sql = "INSERT INTO posts (board_id, title, user_id, user_name, content) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $board_id, $title, $user_id, $user_name, $content);

    if ($stmt->execute()) {
        header("Location: board.php?board_id=$board_id");
    } else {
        $error_message = "오류: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>새 글 작성 | ROLLING STONE</title>

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
        .container {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            margin-top: 20px;
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

    <!-- create_post Section Begin -->
    <div class="container">
        <h3 style="margin-bottom: 20px;">새 글 작성</h3>
        <?php if (!empty($error_message)) { ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
        <?php } ?>
        <form action="create_post.php" method="post">
            <div class="form-group">
                <label for="board_id" style="margin-bottom: 10px;">게시판 종류</label><br>
                <select name="board_id" id="board_id" class="form-control" style="margin-bottom: 20px;">
                    <?php while ($board = $boards_result->fetch_assoc()) { ?>
                        <option value="<?= $board['id'] ?>"><?= htmlspecialchars($board['name']) ?></option>
                    <?php } ?>
                </select><br><br>
            </div>
            <div class="form-group">
                <label for="title" style="margin-bottom: 10px;">제목</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="content" style="margin-bottom: 10px;">내용</label>
                <textarea name="content" id="content" class="form-control" rows="10" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 20px; background-color: #E53637; border-color: #E53637;">등록</button>
        </form>
    </div>
    <!-- create_post Section End -->

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
