import requests
from bs4 import BeautifulSoup

url = "https://go2senkyo.com/local/senkyo/24151"
r = requests.get(url)

soup = BeautifulSoup(r.content, "html.parser")



import openpyxl
wb = openpyxl.Workbook()
sheet = wb.active
sheet .title = "スクレイピング結果"

# シートの番号用変数

	
cnt = 1
# 特定のクラスだけを抜き出して表示
for a in soup.select("a"):
    data = str(a.string).rstrip()
    if data == "None":
        continue
    sel1 = "B"+str(cnt)
    sheet[sel1].value = data
    cnt += 1

# エクセルにデータを保存する
wb.save("text2.xlsx")

wb.close()