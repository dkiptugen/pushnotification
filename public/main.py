from requests_html import HTMLSession
import sqlite3

def link(x):
    conn = sqlite3.connect('../database/citizeninfo.db')
    c = conn.cursor()
    s = HTMLSession()
    r = s.get(x)
    r.html.render(sleep=1)
    news = r.html.xpath('/html/body/div/div/div/main/div/div[10]', first=True)

    for item in news.absolute_links:
        r = s.get(item)
        title = r.html.find('h2.page-title', first=True).text
        published = r.html.find('span.datepublished', first=True).text
        caption = r.html.find('p.caption', first=True).text
        author = r.html.find('span.authorinfo a', first=True).text
        c.execute('''SELECT * FROM info WHERE link = ?''', [item])
        result = c.fetchone()
        print(item)
        if not result:
            c.execute('''INSERT INTO info VALUES(?,?,?,?,?)''', (title, caption, published, item, author))
            conn.commit()
    conn.close()

link('https://citizen.digital/news')

