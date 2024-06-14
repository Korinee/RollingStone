<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "park9570";
$dbname = "rollingstone_db";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$category = $_GET['category'];

if ($category == "전체") {
    $contestSql = "SELECT num, title, img, organizer, field, homepage, finish_day FROM contests";
} else {
    $contestSql = "SELECT num, title, img, organizer, field, homepage, finish_day FROM contests WHERE field = ?";
}

$stmt = $con->prepare($contestSql);

if ($category != "전체") {
    $stmt->bind_param("s", $category);
}

$stmt->execute();
$result = $stmt->get_result();

$contests = [];
$currentDate = new DateTime();
while ($row = $result->fetch_assoc()) {
    $finishDate = new DateTime($row['finish_day']);
    $interval = $currentDate->diff($finishDate);
    $daysLeft = $interval->format('%a');

    if ($daysLeft > 1) {
        $row['days_left'] = $daysLeft;
        $contests[] = $row;
    }
}

shuffle($contests);
$contests = array_slice($contests, 0, 12);

$stmt->close();
$con->close();

echo json_encode($contests);
?>
