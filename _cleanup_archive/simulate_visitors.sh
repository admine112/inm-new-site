#!/bin/bash

# Скрипт для имитации посетителей сайта
# Симулирует реальных пользователей с разными User-Agent, cookies и поведением

SITE_URL="https://inmunoflam.com.ua"
COOKIE_DIR="/tmp/visitor_cookies"
LOG_FILE="visitor_simulation.log"

# Создаем директорию для cookies
mkdir -p "$COOKIE_DIR"

# Массив User-Agent (разные браузеры и устройства)
USER_AGENTS=(
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36"
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:121.0) Gecko/20100101 Firefox/121.0"
    "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36"
    "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Safari/605.1.15"
    "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36"
    "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:121.0) Gecko/20100101 Firefox/121.0"
    "Mozilla/5.0 (iPhone; CPU iPhone OS 17_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Mobile/15E148 Safari/604.1"
    "Mozilla/5.0 (iPad; CPU OS 17_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Mobile/15E148 Safari/604.1"
    "Mozilla/5.0 (Linux; Android 13; SM-S918B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36"
    "Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36"
)

# Массив страниц для посещения
PAGES=(
    "/"
    "/sostav-inmunoflama"
    "/videoperedachi"
    "/stati"
    "/otzivi"
    "/apteki"
    "/kontakti"
)

# Функция для генерации случайного реферера
get_random_referer() {
    local referers=(
        "https://www.google.com/search?q=инмунофлам"
        "https://www.google.com.ua/search?q=иммуномодулятор"
        "https://www.google.com/search?q=укрепление+иммунитета"
        "https://www.bing.com/search?q=инмунофлам"
        "https://www.facebook.com/"
        "https://www.youtube.com/"
        ""  # Прямой заход
        ""
    )
    echo "${referers[$RANDOM % ${#referers[@]}]}"
}

# Функция для имитации одного посетителя
simulate_visitor() {
    local visitor_id=$1
    local cookie_file="$COOKIE_DIR/visitor_${visitor_id}.txt"
    local user_agent="${USER_AGENTS[$RANDOM % ${#USER_AGENTS[@]}]}"
    local referer=$(get_random_referer)
    
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Посетитель #$visitor_id начал сессию" | tee -a "$LOG_FILE"
    echo "  User-Agent: $user_agent" >> "$LOG_FILE"
    echo "  Referer: ${referer:-'Direct'}" >> "$LOG_FILE"
    
    # Количество страниц для просмотра (1-5)
    local pages_to_view=$((RANDOM % 5 + 1))
    
    for ((i=1; i<=pages_to_view; i++)); do
        local page="${PAGES[$RANDOM % ${#PAGES[@]}]}"
        local url="${SITE_URL}${page}"
        
        echo "  → Страница $i/$pages_to_view: $page" >> "$LOG_FILE"
        
        # Выполняем запрос с сохранением cookies
        if [ -z "$referer" ]; then
            curl -s -L \
                -A "$user_agent" \
                -b "$cookie_file" \
                -c "$cookie_file" \
                -H "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8" \
                -H "Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7,uk;q=0.6" \
                -H "Accept-Encoding: gzip, deflate, br" \
                -H "Connection: keep-alive" \
                -H "Upgrade-Insecure-Requests: 1" \
                "$url" > /dev/null
        else
            curl -s -L \
                -A "$user_agent" \
                -e "$referer" \
                -b "$cookie_file" \
                -c "$cookie_file" \
                -H "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8" \
                -H "Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7,uk;q=0.6" \
                -H "Accept-Encoding: gzip, deflate, br" \
                -H "Connection: keep-alive" \
                -H "Upgrade-Insecure-Requests: 1" \
                "$url" > /dev/null
        fi
        
        # Задержка между страницами (5-30 секунд)
        if [ $i -lt $pages_to_view ]; then
            local delay=$((RANDOM % 26 + 5))
            echo "    Задержка: ${delay}с" >> "$LOG_FILE"
            sleep $delay
        fi
        
        # После первой страницы referer становится предыдущей страницей
        referer="$url"
    done
    
    echo "  ✓ Сессия завершена ($pages_to_view страниц)" >> "$LOG_FILE"
    echo "" >> "$LOG_FILE"
}

# Основная функция
main() {
    local num_visitors=${1:-10}  # По умолчанию 10 посетителей
    local delay_between=${2:-30}  # Задержка между посетителями (секунды)
    
    echo "========================================" | tee -a "$LOG_FILE"
    echo "Симуляция посетителей сайта" | tee -a "$LOG_FILE"
    echo "Дата: $(date '+%Y-%m-%d %H:%M:%S')" | tee -a "$LOG_FILE"
    echo "Количество посетителей: $num_visitors" | tee -a "$LOG_FILE"
    echo "Задержка между посетителями: ${delay_between}с" | tee -a "$LOG_FILE"
    echo "========================================" | tee -a "$LOG_FILE"
    echo "" | tee -a "$LOG_FILE"
    
    for ((visitor=1; visitor<=num_visitors; visitor++)); do
        simulate_visitor $visitor
        
        # Задержка перед следующим посетителем
        if [ $visitor -lt $num_visitors ]; then
            local wait_time=$((RANDOM % delay_between + 10))
            echo "⏳ Ожидание следующего посетителя: ${wait_time}с..." | tee -a "$LOG_FILE"
            sleep $wait_time
        fi
    done
    
    echo "" | tee -a "$LOG_FILE"
    echo "========================================" | tee -a "$LOG_FILE"
    echo "✅ Симуляция завершена!" | tee -a "$LOG_FILE"
    echo "Всего посетителей: $num_visitors" | tee -a "$LOG_FILE"
    echo "Лог сохранен в: $LOG_FILE" | tee -a "$LOG_FILE"
    echo "========================================" | tee -a "$LOG_FILE"
}

# Справка
show_help() {
    cat << EOF
Использование: $0 [количество_посетителей] [задержка_между_посетителями]

Параметры:
  количество_посетителей       Количество уникальных посетителей (по умолчанию: 10)
  задержка_между_посетителями  Максимальная задержка в секундах (по умолчанию: 30)

Примеры:
  $0                    # 10 посетителей с задержкой до 30 сек
  $0 50                 # 50 посетителей с задержкой до 30 сек
  $0 100 60             # 100 посетителей с задержкой до 60 сек

Особенности:
  - Каждый посетитель имеет уникальную сессию (cookies)
  - Используются разные User-Agent (браузеры и устройства)
  - Имитируются разные источники трафика (Google, Facebook, прямые заходы)
  - Посетители просматривают 1-5 страниц
  - Задержка между страницами: 5-30 секунд
  - Все действия логируются в $LOG_FILE

EOF
}

# Проверка аргументов
if [ "$1" = "-h" ] || [ "$1" = "--help" ]; then
    show_help
    exit 0
fi

# Запуск
main "$@"
