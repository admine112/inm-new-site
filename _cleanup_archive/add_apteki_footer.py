#!/usr/bin/env python3
# -*- coding: utf-8 -*-

# Read the file
filepath = '/home/linuxuser/Загрузки/Лидия/Сайт/ inmunoflam.com.ua(Резерв)/www/www/templates/shop1/main.tpl'

with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

# Define the current footer with 5 items
old_footer = '''                <a href="/">Главная</a><a href="/p3">Консультации</a><a href="/p15">Видеопередачи</a><a href="/stati">Статьи</a><a href="/p25">Отзывы</a>'''

# Define the new footer with 6 items (added Аптеки)
new_footer = '''                <a href="/">Главная</a><a href="/p3">Консультации</a><a href="/p15">Видеопередачи</a><a href="/stati">Статьи</a><a href="/p25">Отзывы</a><a href="/apteki">Аптеки</a>'''

# Replace the footer menu
content = content.replace(old_footer, new_footer)

# Write back
with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)

print("Footer menu updated - added Аптеки link!")
