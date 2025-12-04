#!/bin/bash
# Скрипт для создания страницы Контакты путем копирования Аптеки

# Получаем ID страницы Аптеки
APTEKI_ID=$(docker exec inmunoflam_db mysql -u is501201_inm -p'(!keSB72a5' is501201_inm -e "SELECT articleID FROM content_articles WHERE alias='apteki';" 2>&1 | grep -v Warning | tail -1)

echo "ID Аптеки: $APTEKI_ID"

# Удаляем старую страницу Контакты если есть
docker exec inmunoflam_db mysql -u is501201_inm -p'(!keSB72a5' is501201_inm -e "DELETE FROM content_articles WHERE alias='kontakti';" 2>&1 | grep -v Warning

# Копируем запись Аптеки
docker exec inmunoflam_db mysql -u is501201_inm -p'(!keSB72a5' is501201_inm -e "INSERT INTO content_articles SELECT NULL, dom_id, lng_id, name, h1, title, description, keywords, content, alias, use_alias, text, add_date, \`order\`, image, parent, visible, menu, block, type_id FROM content_articles WHERE articleID=$APTEKI_ID;" 2>&1 | grep -v Warning

# Получаем ID новой записи
NEW_ID=$(docker exec inmunoflam_db mysql -u is501201_inm -p'(!keSB72a5' is501201_inm -e "SELECT LAST_INSERT_ID();" 2>&1 | grep -v Warning | tail -1)

echo "ID новой записи: $NEW_ID"

# Обновляем alias
docker exec inmunoflam_db mysql -u is501201_inm -p'(!keSB72a5' is501201_inm -e "UPDATE content_articles SET alias='kontakti' WHERE articleID=$NEW_ID;" 2>&1 | grep -v Warning

echo "Страница Контакты создана с ID: $NEW_ID"
echo "Проверьте: http://localhost:8090/kontakti"
