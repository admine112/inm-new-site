#!/bin/bash

echo "🚀 Запуск inmunoflam.com.ua локально..."
echo ""

# Перевірка Docker
if ! command -v docker &> /dev/null; then
    echo "❌ Docker не встановлено!"
    echo "Встановіть Docker: https://docs.docker.com/get-docker/"
    exit 1
fi

if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose не встановлено!"
    echo "Встановіть Docker Compose: https://docs.docker.com/compose/install/"
    exit 1
fi

# Перехід до директорії
cd "$(dirname "$0")"

# Копіювання локальної конфігурації
echo "📝 Налаштування конфігурації..."
cp www/www/settings/conf.local.php www/www/settings/conf.php

# Запуск Docker Compose
echo "🐳 Запуск Docker контейнерів..."
docker-compose up -d

# Очікування запуску БД
echo "⏳ Очікування запуску MySQL..."
sleep 10

# Перевірка статусу
echo ""
echo "✅ Сайт запущено!"
echo ""
echo "📍 Доступ:"
echo "   Сайт:        http://localhost:8080"
echo "   phpMyAdmin:  http://localhost:8081"
echo ""
echo "📊 Статус контейнерів:"
docker-compose ps
echo ""
echo "📝 Переглянути логи: docker-compose logs -f web"
echo "🛑 Зупинити:         docker-compose down"
