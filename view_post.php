<?php
    session_start();
    include 'db.php';

    if ($conn->connect_error) {
        die("데이터베이스 연결 실패: " . $conn->connect_error);
    }

    if (!isset($_SESSION['userid'])) {
        echo "<script>
            if (confirm('커뮤니티 게시글 확인은 회원만 가능합니다. 로그인 후 이용해주세요 : )')) {
                window.location.href = 'login.php';
            } else {
                window.location.href = 'board.php';
            }
        </script>";
        exit;
    }

    $post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // 게시물 조회수 증가
    $update_views_sql = "UPDATE posts SET views = views + 1 WHERE id = ?";
    $stmt = $conn->prepare($update_views_sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $stmt->close();

    // 게시물 조회 및 게시판 정보 가져오기
    $sql = "SELECT posts.*, boards.name AS board_name FROM posts JOIN boards ON posts.board_id = boards.id WHERE posts.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $post_result = $stmt->get_result();
    $post = $post_result->fetch_assoc();

    // 댓글 조회
    $comments_sql = "SELECT * FROM comments WHERE post_id = ?";
    $comments_stmt = $conn->prepare($comments_sql);
    $comments_stmt->bind_param("i", $post_id);
    $comments_stmt->execute();
    $comments_result = $comments_stmt->get_result();

    // 로그인된 사용자의 사용자 이름과 아이디 가져오기 (변수 이름 수정)
    $user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
    $user_id = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;

    $stmt->close();
    $comments_stmt->close();
    $conn->close();
?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= htmlspecialchars($post['title']) ?></title>

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
        body, html {
            height: 100%;
        }
        .btn-primary {
            background-color: #E53637 !important;
            border-color: #E53637 !important;
            color: #fff;
            transition: background-color 0.3s, border-color 0.3s, color 0.3s; /* 트랜지션 추가 */
        }
        .btn-primary:hover {
            background-color: #ff6b6e !important;
            border-color: #ff6b6e !important;
            color: #fff;
        }
        .comment-form-container {
            margin-bottom: 60px;
        }
        .comment {
            margin-bottom: 60px;
        }
        .comment-form-divider {
            border-top: 1px solid #ccc;
            margin-top: 20px;
            margin-bottom: 30px;
            padding-top: 30px;
        }
        .post-options {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .post-options a {
            margin-right: 10px;
            color: #9e9fa3;
        }
        .post-meta,
        .comment-meta {
            color: #9e9fa3;
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

    <!-- view_post Section Begin -->
    <div class="container">
        <h4 style="font-weight: bold;"><?= htmlspecialchars($post['title']) ?></h4><br>
        <div><?= nl2br(htmlspecialchars($post['content'])) ?></div><br>
        <p><?= htmlspecialchars($post['board_name']) ?> 게시판 | 작성자 : <?= htmlspecialchars($post['user_name']) ?> | 작성일 : <?= htmlspecialchars($post['created_at']) ?> | 조회수 : <?= htmlspecialchars($post['views']) ?></p>
        
        <!-- 수정/삭제 옵션 -->
        <div class="post-options">
            <a href="edit_post.php?id=<?= $post_id ?>">수정</a>
            <a href="delete_post.php?id=<?= $post_id ?>">삭제</a>
        </div>
        <hr style="margin-top: 30px; margin-bottom: 30px;">
        <h4 style="margin-bottom: 20px; font-weight: bold;">댓글</h4>
        <?php if ($comments_result->num_rows > 0) { ?>
            <?php while ($comment = $comments_result->fetch_assoc()) { ?>
                <div class="comment" style="margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                    <p><?= htmlspecialchars($comment['user_name']) ?> | <?= $comment['created_at'] ?>
                        <?php if ($comment['user_id'] == $user_id) { ?>
                            | <a href="delete_comment.php?id=<?= $comment['id'] ?>" style="color: #9e9fa3;">삭제</a>
                        <?php } ?>
                    </p>
                    <div><?= nl2br(htmlspecialchars($comment['content'])) ?></div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>댓글이 없습니다.</p>
            <hr class="comment-form-divider">
        <?php } ?>
        <div class="comment-form-container">
            <form action="create_comment.php" method="post">
                <input type="hidden" name="post_id" value="<?= $post_id ?>">
                <div class="form-group">
                    <label for="content" style="font-weight: bold;">댓글 입력</label>
                    <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">댓글 작성</button>
                </div>
            </form>
        </div>
    </div>
    <!-- view_post Section End -->

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
