#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import re

# Read the file
filepath = '/home/linuxuser/Загрузки/Лидия/Сайт/ inmunoflam.com.ua(Резерв)/www/www/templates/shop1/main.tpl'

with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

# Define the current 6-item menu
old_menu = '''            <div class="topmenu">
				<a href="/" title="ГЛАВНАЯ">
					ГЛАВНАЯ
				</a>

				<a href="/p3" title="ЧТО ТАКОЕ ИНМУНОФЛАМ">
					ЧТО ТАКОЕ ИНМУНОФЛАМ
				</a>

				<a href="/stati" title="СТАТЬИ">
					СТАТЬИ
				</a>

				<a href="/p15" title="ВИДЕОПЕРЕДАЧИ">
					ВИДЕОПЕРЕДАЧИ
				</a>

				<a href="/p25" title="ОТЗЫВЫ">
					ОТЗЫВЫ
				</a>

				<a href="/shop" title="ПРОДУКЦИЯ">
					ПРОДУКЦИЯ
				</a>
            </div>'''

# Define the new 3-item menu with correct links
new_menu = '''            <div class="topmenu">




				<a href="/p3" title="ЧТО СОБОЙ ПРЕДСТАВЛЯЕТ ИНМУНОФЛАМ">
					ЧТО СОБОЙ ПРЕДСТАВЛЯЕТ ИНМУНОФЛАМ
				</a>




				<a href="/p15" title="Видеопередачи">
					Видеопередачи
				</a>




				<a href="/p25" title="Отзывы">
					Отзывы
				</a>



            </div>'''

# Replace the menu
content = content.replace(old_menu, new_menu)

# Write back
with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)

print("Menu reverted to 3 items with correct links!")
