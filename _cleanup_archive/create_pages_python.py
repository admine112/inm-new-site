#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import mysql.connector

# Подключение к базе данных
conn = mysql.connector.connect(
    host='localhost',
    port=33060,
    user='is501201_inm',
    password='(!keSB72a5',
    database='is501201_inm',
    charset='utf8mb4',
    use_unicode=True
)

cursor = conn.cursor()

# Аптеки
apteki_text = '''<h2>Где вы находитесь? — Днепропетровск</h2>
<h3>"Аптека24"</h3>
<p>г. Днепропетровск, бул. Славы, 40 (ж/м Сокол 2)</p>
<p><strong>Телефоны:</strong><br>
(044) 223-44-55<br>
+38 (067) 611 28 27<br>
+38 (095) 294 24 24</p>

<h3>"Аптека на Крещатике"</h3>
<p>г. Киев, ул. Крещатик, 24</p>
<p><strong>Телефоны:</strong><br>
+38 (050) 412 53 33<br>
+38 (067) 979 72 96</p>'''

# Контакты
kontakti_text = '''<h1>Контакты</h1>
<table border="0" cellpadding="1" cellspacing="1" style="width: 100%;">
<tbody>
<tr>
<td valign="top">
<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="color: rgb(0, 128, 0); font-size: medium;"><strong>График работы магазина:</strong></span></p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="font-size: small;">Вы можете связаться с нами в любое время&nbsp;</span><strong style="font-size: small;">с 8:00 до 22:00.</strong></p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><strong><span style="font-size: small;">Мы работаем без выходных.</span></strong></p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;">&nbsp;</p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="color: rgb(0, 128, 0); font-size: medium;"><strong>Наши контакты:</strong></span></p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="font-size: small;">По всем вопросам обращайтесь по телефонам:</span></p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="font-size: small;">(044) 578-17-48&nbsp;</span></p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="font-size: small;">(063) 578-17-48</span></p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="font-size: small;">(067) 233-74-80 &nbsp;&nbsp;</span></p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="font-size: small;">(050) 857-25-64</span></p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="font-size: small;">или email:&nbsp;<strong><span style="text-decoration: underline;">shop@inmunoflam.com</span></strong></span></p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;">&nbsp;</p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="color: rgb(0, 128, 0); font-size: medium;"><strong>Работает доставка по всей Украине Новой почтой и курьером по Киеву.</strong></span></p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><strong><span style="font-size: small;">Стоимость доставки:</span></strong></p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="font-size: small;">- доставка&nbsp;Новой почтой - согласно тарифам перевозчика;</span></p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="font-size: small;">-&nbsp;курьером по Киеву -&nbsp;</span><span style="font-size: small; color: rgb(0, 128, 0);">50 грн.</span></p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="font-size: small;"><strong>Оплата:</strong>&nbsp;<br/>
-&nbsp;</span><span style="font-size: small;">наложенным платежом;</span></p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="font-size: small;">- на карту Приват банка.</span><br/>
&nbsp;</p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="color: rgb(255, 0, 0);"><strong><span style="font-size: large;">БЕСПЛАТНАЯ доставка при заказе 3х и более препаратов.</span></strong></span>&nbsp;</p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="font-size: small;"><strong>Вы также можете забрать препараты у нас в офисе по адресу:</strong></span></p>

<p style="margin: 0px 0px 10px; padding: 0px; border: 0px;"><span style="font-size: small;">пл. Дружбы Народов, 5, оф.№3, Киев, 04205</span></p>
</td>
</tr>
</tbody>
</table>'''

# Вставка Аптеки
cursor.execute("""
INSERT INTO content_articles 
(dom_id, lng_id, name, h1, title, description, keywords, content, alias, use_alias, text, add_date, `order`, image, parent, visible, menu, block, type_id)
VALUES 
(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, NOW(), %s, %s, %s, %s, %s, %s, %s)
""", (0, 1, 'Аптеки', 'Аптеки', 'Аптеки - где купить Инмунофлам', 'Список аптек где можно приобрести Инмунофлам', 'аптеки, купить, Инмунофлам', '', 'apteki', 1, apteki_text, 0, 0, 0, 1, 1, 0, 1))

# Вставка Контакты
cursor.execute("""
INSERT INTO content_articles 
(dom_id, lng_id, name, h1, title, description, keywords, content, alias, use_alias, text, add_date, `order`, image, parent, visible, menu, block, type_id)
VALUES 
(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, NOW(), %s, %s, %s, %s, %s, %s, %s)
""", (0, 1, 'Контакты', 'Контакты', 'Контакты - Инмунофлам', 'Контактная информация магазина Инмунофлам', 'контакты, телефон, адрес, доставка', '', 'kontakti', 1, kontakti_text, 0, 0, 0, 1, 1, 0, 1))

conn.commit()

print("Страницы успешно созданы с правильной кодировкой!")
print(f"Аптеки ID: {cursor.lastrowid - 1}")
print(f"Контакты ID: {cursor.lastrowid}")

cursor.close()
conn.close()
