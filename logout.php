<?php
session_start();

session_unset();
session_destroy();

echo "<script>
    alert('로그아웃 되었습니다. 또 롤링스톤에 방문해주세요 : )');
    window.location.href = 'index.php';
</script>";
exit;
?>