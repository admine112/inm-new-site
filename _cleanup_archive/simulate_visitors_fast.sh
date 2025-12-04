#!/bin/bash

# Быстрая версия - для тестирования счетчика
# Создает много посетителей за короткое время

SITE_URL="https://inmunoflam.com.ua"
COOKIE_DIR="/tmp/fast_visitors"
mkdir -p "$COOKIE_DIR"

USER_AGENTS=(
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0"
    "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Safari/537.36"
    "Mozilla/5.0 (X11; Linux x86_64) Firefox/121.0"
    "Mozilla/5.0 (iPhone; CPU iPhone OS 17_1) Safari/604.1"
    "Mozilla/5.0 (Linux; Android 13) Chrome/120.0.0.0 Mobile"
)

simulate_fast_visitor() {
    local id=$1
    local cookie_file="$COOKIE_DIR/visitor_${id}.txt"
    local ua="${USER_AGENTS[$RANDOM % ${#USER_AGENTS[@]}]}"
    
    # Посещаем главную страницу
    curl -s -L \
        -A "$ua" \
        -b "$cookie_file" \
        -c "$cookie_file" \
        -H "Accept-Language: ru-RU,ru;q=0.9" \
        "$SITE_URL/" > /dev/null
    
    echo "✓ Посетитель #$id"
}

main() {
    local count=${1:-50}
    echo "🚀 Быстрая симуляция $count посетителей..."
    echo ""
    
    for ((i=1; i<=count; i++)); do
        simulate_fast_visitor $i &
        
        # Небольшая задержка чтобы не перегрузить сервер
        if [ $((i % 10)) -eq 0 ]; then
            wait
            sleep 1
        fi
    done
    
    wait
    echo ""
    echo "✅ Готово! Создано $count уникальных посетителей"
}

main "$@"
