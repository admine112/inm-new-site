# Инструкция: Как исправить внешние изображения

## Проблема
Найдено изображение с внешнего сайта:
```
https://www.onco.cv.ua/wp-content/uploads/2021/11/img_20211025_130816_edit_237680936353836-768x1024.jpg
```

**Риски:**
- ❌ Изображение может исчезнуть
- ❌ Замедляет загрузку сайта
- ❌ Нет ALT-текста (плохо для SEO)
- ❌ Зависимость от чужого сервера

---

## Решение

### Шаг 1: Скачать изображение

```bash
wget https://www.onco.cv.ua/wp-content/uploads/2021/11/img_20211025_130816_edit_237680936353836-768x1024.jpg -O inmunoflam-article-image.jpg
```

### Шаг 2: Оптимизировать

**Онлайн:**
- Открыть https://squoosh.app/
- Загрузить изображение
- Конвертировать в WebP
- Качество: 80%
- Размер: уменьшить до 600x800px
- Скачать как `inmunoflam-article.webp`

**Или через командную строку:**
```bash
convert inmunoflam-article-image.jpg -resize 600x800 -quality 80 inmunoflam-article.webp
```

### Шаг 3: Загрузить на сервер

```bash
# Через SFTP
sshpass -p "aP9ypC9buY" sftp is501201@is501201.ftp.tools <<EOF
cd inmunoflam.com.ua/www/images/articles
put inmunoflam-article.webp
bye
EOF
```

### Шаг 4: Обновить в базе данных

```sql
UPDATE content 
SET text = REPLACE(
    text, 
    'https://www.onco.cv.ua/wp-content/uploads/2021/11/img_20211025_130816_edit_237680936353836-768x1024.jpg',
    '/images/articles/inmunoflam-article.webp'
)
WHERE text LIKE '%onco.cv.ua%';
```

### Шаг 5: Добавить ALT-текст

Найти в админке статью и заменить:
```html
<!-- Было -->
<img src="/images/articles/inmunoflam-article.webp">

<!-- Стало -->
<img src="/images/articles/inmunoflam-article.webp" 
     alt="Инмунофлам - натуральный иммуномодулятор" 
     loading="lazy" 
     width="600" 
     height="800">
```

---

## Автоматический поиск всех внешних изображений

Запустите скрипт:
```bash
bash find_external_images.sh
```

Он найдет все статьи с внешними ссылками на изображения.

---

## Рекомендации на будущее

1. **Всегда загружайте изображения на свой сервер**
2. **Используйте WebP формат** (меньше размер)
3. **Добавляйте ALT-теги** (важно для SEO)
4. **Используйте lazy loading** (`loading="lazy"`)
5. **Указывайте размеры** (`width` и `height`)

---

## Проверка после исправления

1. Открыть статью на сайте
2. Проверить, что изображение загружается
3. Проверить через Google PageSpeed Insights
4. Убедиться, что ALT-текст присутствует

**Ожидаемый результат:**
- ✅ Изображение загружается быстро
- ✅ Не зависит от внешних сайтов
- ✅ Имеет правильный ALT-текст
- ✅ Оптимизировано для SEO
