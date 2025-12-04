# Schema.org Implementation Guide

## Готовые блоки для вставки

### 1. Для товаров (Product Schema)

**Файл:** `schema_product_inmunoflam_30.html`

**Куда вставить:** В шаблон товара `shop.commodity.full.tpl` перед закрывающим `</head>`

**Что изменить:**
- `name` - название товара
- `image` - URL изображения товара
- `description` - описание товара
- `price` - цена товара
- `url` - URL страницы товара

**Пример для других товаров:**
```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "{$product_name}",
  "image": "https://inmunoflam.com.ua{$product_image}",
  "description": "{$product_description}",
  "brand": {
    "@type": "Brand",
    "name": "Инмунофлам"
  },
  "offers": {
    "@type": "Offer",
    "url": "https://inmunoflam.com.ua/{$product_url}/",
    "priceCurrency": "UAH",
    "price": "{$product_price}",
    "availability": "https://schema.org/InStock"
  }
}
</script>
```

---

### 2. Для статей (Article Schema)

**Файл:** `schema_article_template.html`

**Куда вставить:** В шаблон статьи `content.full_page.tpl` перед закрывающим `</head>`

**Что изменить:**
- `headline` - заголовок статьи
- `datePublished` - дата публикации (формат: YYYY-MM-DD)
- `image` - URL изображения статьи
- `description` - краткое описание статьи
- `@id` - URL страницы статьи

**Пример для CMS:**
```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "{$article_title}",
  "datePublished": "{$article_date}",
  "author": {
    "@type": "Organization",
    "name": "Инмунофлам"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Инмунофлам",
    "logo": {
      "@type": "ImageObject",
      "url": "https://inmunoflam.com.ua/templates/shop1/images/logo.png"
    }
  },
  "image": "https://inmunoflam.com.ua{$article_image}",
  "description": "{$article_description}"
}
</script>
```

---

## Проверка после внедрения

1. **Google Rich Results Test**
   https://search.google.com/test/rich-results
   
2. **Schema.org Validator**
   https://validator.schema.org/

---

## Ожидаемый результат

- Товары будут отображаться в поиске с ценой, наличием и рейтингом
- Статьи получат расширенные сниппеты с датой и автором
- Улучшится CTR (кликабельность) в поисковой выдаче
