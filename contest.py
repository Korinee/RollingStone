import requests
from bs4 import BeautifulSoup
import csv
import re
from datetime import datetime

num = 0
wevityList = []

for page in range(1, 31):
    url = f"https://www.wevity.com/?c=find&s=1&gp={page}"
    r = requests.get(url)
    html = r.text
    soup = BeautifulSoup(html, "html.parser")
        
    title_tags = soup.find_all("div", class_="tit")
    
    for index, item in enumerate(title_tags):
        if index == 0:
            continue  # 첫 번째 반복에서는 출력하지 않음
        
        temp = []

        # 순번
        num += 1
        temp.append(num)
        
        # 링크 추출
        href = item.find("a")["href"]
        link = f"https://www.wevity.com{href}"
        
        # 링크 페이지에 접속하여 접수날짜, 마감날짜, 이미지 링크 가져오기
        link_r = requests.get(link)
        link_html = link_r.text
        link_soup = BeautifulSoup(link_html, "html.parser")
        
        # 이미지
        img_tag = link_soup.find("div", class_="thumb").find("img")
        if img_tag:
            img_src = img_tag["src"]
            img_link = f"https://www.wevity.com{img_src}"
        else:
            img_link = "이미지 없음"
        
        temp.append(img_link)

        # 제목
        title_tag = item.find("a")
        title_text = title_tag.text.strip()
        title_text = re.sub(r'(신규|SPECIAL|IDEA)', '', title_text).strip()
        temp.append(title_text)

        # 분야
        field = ""
        field_tags = item.find_next("div")
        field_text = field_tags.text.strip()[5:]  # 필드 정보 추출
        field_split = [part.strip() for part in re.split(r'[\/,]', field_text)]
        field_str = ', '.join(field_split)  # 리스트를 문자열로 변환
        temp.append(field_str)

        # 주최/주관
        organizer_tags = field_tags.find_next("div", class_="organ")
        organizer = organizer_tags.text.strip()
        temp.append(organizer)

        # 접수날짜, 마감날짜
        period_text = link_soup.find("li", class_="dday-area").text.strip()
        start_day, finish_day = re.findall(r'\d{4}-\d{2}-\d{2}', period_text)
        temp.append(start_day)
        temp.append(finish_day)

        # 공모전 홈페이지 링크
        homepage_tag = link_soup.find("span", class_="tit", string="홈페이지")
        homepage = "홈페이지 링크 없음"
        if homepage_tag:
            homepage_link = homepage_tag.find_next_sibling("a")
            if homepage_link:
                homepage = homepage_link["href"]
        temp.append(homepage)
        
        wevityList.append(temp)
        
        print(num)

with open("contest.csv", "w", encoding="utf-8", newline= "") as f:
    writer = csv.writer(f)
    writer.writerow(["num", "img", "title", "field", "organizer", "start_day", "finish_day", "homepage"])
    writer.writerows(wevityList)

print("크롤링 완료!")