<?php
    session_start(); // 세션 시작
    include 'db.php';

    $post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // 게시물 조회
    $sql = "SELECT * FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    $stmt->close();

    // 게시물이 존재하지 않을 경우 처리
    if (!$post) {
        echo "<script>alert('존재하지 않는 게시물입니다.'); window.history.back();</script>";
        exit;
    }

    // 현재 로그인한 사용자의 ID 가져오기
    $user_id = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;

    // 현재 로그인한 사용자의 ID와 게시물 작성자의 ID가 같은지 확인
    if ($user_id == $post['user_id']) {
        echo "<script>alert('해당 게시물의 작성자입니다. 게시물을 수정하시겠습니까?'); </script>";
    } else {
        echo "<script>alert('해당 게시물의 작성자가 아닙니다. 게시물 수정의 권한이 없습니다.'); window.history.back();</script>";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_STRING);
        $content = filter_var(trim($_POST['content']), FILTER_SANITIZE_STRING);

        $update_sql = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssi", $title, $content, $post_id);

        if ($stmt->execute()) {
            header("Location: view_post.php?id=$post_id");
            exit();
        } else {
            $error_message = "오류: " . $stmt->error;
        }
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>게시물 수정 | ROLLING STONE</title>

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
            background-color: #E53637;
            border-color: #E53637;
            transition: background-color 0.3s, border-color 0.3s; 
        }
        .btn-primary:hover {
            background-color: #ff6b6e;
            border-color: #ff6b6e;
        }
        .footer-spacing {
            margin-top: 40px;
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

    <!-- edit post form Section Begin -->
    <div class="container">
        <h3 style="font-weight: bold;">게시물 수정</h3><br>
        <?php if (!empty($error_message)) { ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
        <?php } ?>
        <form action="edit_post.php?id=<?= $post_id ?>" method="post">
            <div class="form-group">
                <label for="title">제목</label>
                <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($post['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="content">내용</label>
                <textarea name="content" id="content" class="form-control" rows="10" required><?= htmlspecialchars($post['content']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">수정</button>
        </form>
    </div>
    <!-- edit post form Section End -->

    <div class="footer-spacing"></div>

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