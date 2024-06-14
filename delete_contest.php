<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username']) || !isset($_SESSION['userid'])) {
    echo "<script>
    alert('공모전 삭제 기능은 회원만 가능합니다. 로그인 후 사용 가능합니다 : )');
    location.href = 'login.php';
    </script>";
    exit;
}
$username = $_SESSION['username'];
$userid = $_SESSION['userid'];

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "DELETE FROM contests WHERE num = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('공모전이 삭제되었습니다 : )');</script>";
    } else {
        echo "<script>alert('공모전 삭제에 실패했습니다 : (');</script>";
    }
    $stmt->close();
}

$sql = "SELECT num, title, organizer FROM contests WHERE organizer LIKE ?";
$stmt = $conn->prepare($sql);
$search_organizer = "%$userid%";
$stmt->bind_param("s", $search_organizer);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>공모전 삭제 | ROLLING STONE</title>
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
            background-color: #f5f5f5;
            font-family: 'Nunito Sans', sans-serif;
        }
        .content {
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
        .form .contest-item {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .form .contest-item .title {
            font-weight: bold;
            color: #000;
            text-decoration: none;
            transition: color 0.3s;
        }
        .form .contest-item .title:hover {
            color: #E53637;
        }
        .form .contest-item .organizer {
            color: #555;
            margin-right: 10px;
        }
        .form .contest-item .delete-btn {
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }
        footer {
            position: fixed; /* 페이지 하단에 고정 */
            width: 100%;
            background-color: #fff;
            text-align: center;
            padding: 20px 0;
            bottom: 0; /* 페이지 하단에 위치하도록 설정 */
            left: 0;
            right: 0;
        }
    </style>
</head>
<body>
    <!-- Header Section Begin -->
    <header>
        <?php include 'header.php'; ?>
    </header>
    <!-- Header Section End -->

    <!-- Delete Contest Section Begin -->
    <div class="content">
        <div class="wrap">
            <h3>공모전 삭제</h3>
            <form id="deleteContestForm" method="post" class="form">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='contest-item'>
                            <a href='contest_detail.php?contest_id={$row['num']}' class='title'>{$row['title']}</a>
                            <span class='organizer'>{$row['organizer']}</span>
                            <button type='submit' class='delete-btn' name='delete_id' value='{$row['num']}'>삭제</button>
                        </div>";
                    }
                } else {
                    echo "<p>아직 등록하신 공모전이 없습니다 : )</p>";
                }
                ?>
            </form>
        </div>
    </div>
    <!-- Delete Contest Section End -->

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

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
