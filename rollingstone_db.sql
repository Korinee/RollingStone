-- 초기 설정
DROP DATABASE IF EXISTS rollingstone_db;
CREATE DATABASE rollingstone_db;
USE rollingstone_db;


-- 서버 연결
CREATE USER 'root'@'%' IDENTIFIED WITH mysql_native_password BY 'park9570';
GRANT ALL PRIVILEGES ON * . * TO 'root'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;


-- 회원
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    userid VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL
);

-- 회원 확인
SELECT * FROM users;


-- 관심분야
CREATE TABLE user_interests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userid VARCHAR(50),
    username VARCHAR(100),
    field VARCHAR(100),
    FOREIGN KEY (userid) REFERENCES users(userid),
    FOREIGN KEY (username) REFERENCES users(username)
);

SELECT * FROM user_interests;

-- 불편사항
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (name) REFERENCES users(username),
    FOREIGN KEY (email) REFERENCES users(email)
);

SELECT * FROM messages;


-- 게시판
CREATE TABLE boards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- 게시판 종류
INSERT INTO boards (name) VALUES ('자유'), ('연애'), ('꿀팁'), ('논쟁'), ('후기');

SELECT * FROM boards;


-- 게시물
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    board_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    user_id VARCHAR(255) NOT NULL,
    user_name VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    views INT DEFAULT 0,
    FOREIGN KEY (board_id) REFERENCES boards(id),
    FOREIGN KEY (user_id) REFERENCES users(userid),
    FOREIGN KEY (user_name) REFERENCES users(username)
);

SELECT * FROM posts;


-- 댓글
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id VARCHAR(255) NOT NULL,
    user_name VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id),
    FOREIGN KEY (user_id) REFERENCES users(userid),
    FOREIGN KEY (user_name) REFERENCES users(username)
);

SELECT * FROM comments;


-- 공모전 리스트
CREATE TABLE contests (
    num INT AUTO_INCREMENT PRIMARY KEY,
	img VARCHAR(255),
	title VARCHAR(255),
	organizer VARCHAR(255),
	field TEXT,
	homepage VARCHAR(255),
	start_day DATE,
	finish_day DATE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SELECT * FROM contests;
DELETE FROM contests WHERE num =  815;


-- 관심 공모전
CREATE TABLE favorite_contests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userid VARCHAR(255) NOT NULL,
    contestnum INT NOT NULL,
    FOREIGN KEY (userid) REFERENCES users(userid),
    FOREIGN KEY (contestnum) REFERENCES contests(num)
);

SELECT * FROM favorite_contests;


-- 매칭
CREATE TABLE matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contest_id INT NOT NULL,
    userid VARCHAR(255) NOT NULL,
    desired_members INT NOT NULL,
    current_members INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userid) REFERENCES users(userid),
    FOREIGN KEY (contest_id) REFERENCES contests(num)
);

SELECT * FROM matches;