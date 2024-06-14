<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-7">
                    <div class="header__top__left">
                        <p>대학생 공모전 모음 | ROLLING STONE</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-5">
                    <div class="header__top__right">
                        <div class="header__top__links">
                            <a href="#" onclick="showAdminPopup()">Admin</a>
                            <?php if (isset($_SESSION['username'])): ?>
                                <a href="logout.php">Logout</a>
                                <span style="color: white;">Hi, <?php echo $_SESSION['username']; ?> : )</span>
                            <?php else: ?>
                                <a href="login.php">Login</a>
                                <a href="regist.php">Sign in</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="header__logo">
                    <a href="index.php"><img src="img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <nav class="header__menu mobile-menu">
                    <ul>
                        <li><a href="#">소개/등록</a>
                            <ul class="dropdown">
                                <li><a href="about.php">롤링스톤 소개</a></li>
                                <li><a href="create_contest.php">공모전 등록</a></li>
                                <li><a href="delete_contest.php">공모전 삭제</a></li>
                            </ul>
                        </li>
                        <li><a href="contest_exhibit.php?category=전체">공모전/대외활동</a>
                            <ul class="dropdown">
                                <li><a href="contest_exhibit.php?category=전체">전체</a></li>
                                <li><a href="contest_exhibit.php?category=기획/아이디어">기획/아이디어</a></li>
                                <li><a href="contest_exhibit.php?category=광고/마케팅">광고/마케팅</a></li>
                                <li><a href="contest_exhibit.php?category=논문/리포트">논문/리포트</a></li>
                                <li><a href="contest_exhibit.php?category=영상/UCC/사진">영상/UCC/사진</a></li>
                                <li><a href="contest_exhibit.php?category=디자인/캐릭터/웹툰">디자인/캐릭터/웹툰</a></li>
                                <li><a href="contest_exhibit.php?category=웹/모바일/IT">웹/모바일/IT</a></li>
                                <li><a href="contest_exhibit.php?category=게임/소프트웨어">게임/소프트웨어</a></li>
                                <li><a href="contest_exhibit.php?category=과학/공학">과학/공학</a></li>
                                <li><a href="contest_exhibit.php?category=문학/글/시나리오">문학/글/시나리오</a></li>
                                <li><a href="contest_exhibit.php?category=건축/건설/인테리어">건축/건설/인테리어</a></li>
                                <li><a href="contest_exhibit.php?category=네이밍/슬로건">네이밍/슬로건</a></li>
                                <li><a href="contest_exhibit.php?category=예체능/미술/음악">예체능/미술/음악</a></li>
                                <li><a href="contest_exhibit.php?category=봉사활동">봉사활동</a></li>
                                <li><a href="contest_exhibit.php?category=취업/창업">취업/창업</a></li>
                                <li><a href="contest_exhibit.php?category=해외">해외</a></li>
                                <li><a href="contest_exhibit.php?category=기타">기타</a></li>
                            </ul>
                        </li>
                        <li><a href="board.php">커뮤니티</a>
                            <ul class="dropdown">
                                <li><a href="board.php?board_id=0">전체</a></li>
                                <li><a href="board.php?board_id=1">자유</a></li>
                                <li><a href="board.php?board_id=2">연애</a></li>
                                <li><a href="board.php?board_id=3">꿀팁</a></li>
                                <li><a href="board.php?board_id=4">논쟁</a></li>
                                <li><a href="board.php?board_id=5">후기</a></li>
                            </ul>
                        </li>
                        <li><a href="#">마이페이지</a>
                            <ul class="dropdown">
                                <li><a href="heart.php">관심 목록 확인</a></li>
                                <li><a href="interest_field.php">관심 분야 선택</a></li>
                                <li><a href="match.php">공모전 매칭 현황</a></li>
                                <li><a href="update_profile.php">개인정보 변경</a></li>
                            </ul> 
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="header__nav__option">
                    <a href="search.php" class="search-switch"><img src="img/icon/search.png" alt=""></a>
                    <a href="heart.php"><img src="img/icon/heart.png" alt=""></a>
                </div>
            </div>
        </div>
        <div class="canvas__open"><i class="fa fa-bars"></i></div>
    </div>
    <script>
    function showAdminPopup() {
        var password = prompt("해당 페이지는 관리자용 페이지입니다. 관리자만 접근 가능합니다 : )");
        if (password !== null) {
            window.location.href = "admin_password.php?password=" + password;
        }
    }
    </script> 
</header>
