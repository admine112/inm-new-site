#!/bin/bash

# Скрипт для имитации посещений сайта через прокси
# Использует бесплатные прокси для разных IP-адресов

SITE_URL="https://inmunoflam.com.ua"
PROXY_FILE="/tmp/proxy_list.txt"
LOG_FILE="traffic_simulation.log"

# Массив User-Agent
USER_AGENTS=(
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36"
    "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36"
    "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36"
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:121.0) Gecko/20100101 Firefox/121.0"
    "Mozilla/5.0 (iPhone; CPU iPhone OS 17_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Mobile/15E148 Safari/604.1"
    "Mozilla/5.0 (Linux; Android 13; SM-S918B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36"
)

# Список бесплатных HTTP прокси (обновляйте периодически)
get_proxy_list() {
    cat > "$PROXY_FILE" << 'EOF'
47.88.62.42:80
47.251.43.115:33333
20.111.54.16:8123
103.152.112.162:80
185.217.137.244:1337
47.243.177.210:8088
EOF
}

# Функция для посещения сайта через прокси
visit_site_via_proxy() {
    local visitor_num=$1
    local proxy=$2
    local ua="${USER_AGENTS[$RANDOM % ${#USER_AGENTS[@]}]}"
    local cookie_file="/tmp/visitor_${visitor_num}_cookies.txt"
    
    # Случайный referer
    local referers=(
        "https://www.google.com/search?q=инмунофлам"
        "https://www.google.com.ua/search?q=иммуномодулятор"
        "https://www.facebook.com/"
        ""
    )
    local referer="${referers[$RANDOM % ${#referers[@]}]}"
    
    echo "[$(date '+%H:%M:%S')] Посетитель #$visitor_num через прокси $proxy" | tee -a "$LOG_FILE"
    
    # Выполняем запрос через прокси
    if [ -z "$referer" ]; then
        curl -s -L -m 10 \
            -x "$proxy" \
            -A "$ua" \
            -b "$cookie_file" \
            -c "$cookie_file" \
            -H "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8" \
            -H "Accept-Language: ru-RU,ru;q=0.9,uk;q=0.8" \
            "$SITE_URL/" > /dev/null 2>&1
    else
        curl -s -L -m 10 \
            -x "$proxy" \
            -A "$ua" \
            -e "$referer" \
            -b "$cookie_file" \
            -c "$cookie_file" \
            -H "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8" \
            -H "Accept-Language: ru-RU,ru;q=0.9,uk;q=0.8" \
            "$SITE_URL/" > /dev/null 2>&1
    fi
    
    if [ $? -eq 0 ]; then
        echo "  ✓ Успешно" | tee -a "$LOG_FILE"
        return 0
    else
        echo "  ✗ Ошибка (прокси не работает)" | tee -a "$LOG_FILE"
        return 1
    fi
}

# Функция без прокси (с вашего IP)
visit_site_direct() {
    local visitor_num=$1
    local ua="${USER_AGENTS[$RANDOM % ${#USER_AGENTS[@]}]}"
    local cookie_file="/tmp/visitor_${visitor_num}_cookies.txt"
    
    echo "[$(date '+%H:%M:%S')] Посетитель #$visitor_num (прямое подключение)" | tee -a "$LOG_FILE"
    
    curl -s -L -m 10 \
        -A "$ua" \
        -b "$cookie_file" \
        -c "$cookie_file" \
        -H "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8" \
        -H "Accept-Language: ru-RU,ru;q=0.9,uk;q=0.8" \
        "$SITE_URL/" > /dev/null 2>&1
    
    echo "  ✓ Успешно" | tee -a "$LOG_FILE"
}

main() {
    local count=${1:-10}
    local use_proxy=${2:-no}
    
    echo "=========================================" | tee "$LOG_FILE"
    echo "Имитация трафика на сайт" | tee -a "$LOG_FILE"
    echo "Дата: $(date '+%Y-%m-%d %H:%M:%S')" | tee -a "$LOG_FILE"
    echo "Количество посещений: $count" | tee -a "$LOG_FILE"
    echo "Режим: $([ "$use_proxy" = "yes" ] && echo "Через прокси" || echo "Прямое подключение")" | tee -a "$LOG_FILE"
    echo "=========================================" | tee -a "$LOG_FILE"
    echo "" | tee -a "$LOG_FILE"
    
    if [ "$use_proxy" = "yes" ]; then
        echo "⚠️  ВНИМАНИЕ: Бесплатные прокси часто не работают!" | tee -a "$LOG_FILE"
        echo "Для надежной работы нужны платные прокси-сервисы" | tee -a "$LOG_FILE"
        echo "" | tee -a "$LOG_FILE"
        
        get_proxy_list
        
        local success=0
        local failed=0
        
        for ((i=1; i<=count; i++)); do
            # Выбираем случайный прокси
            local proxy=$(shuf -n 1 "$PROXY_FILE")
            
            if visit_site_via_proxy $i "$proxy"; then
                ((success++))
            else
                ((failed++))
            fi
            
            sleep $((RANDOM % 3 + 1))
        done
        
        echo "" | tee -a "$LOG_FILE"
        echo "Успешно: $success, Ошибок: $failed" | tee -a "$LOG_FILE"
    else
        for ((i=1; i<=count; i++)); do
            visit_site_direct $i
            sleep $((RANDOM % 3 + 1))
        done
    fi
    
    echo "" | tee -a "$LOG_FILE"
    echo "=========================================" | tee -a "$LOG_FILE"
    echo "✅ Завершено!" | tee -a "$LOG_FILE"
    echo "=========================================" | tee -a "$LOG_FILE"
}

show_help() {
    cat << EOF
Использование: $0 [количество] [режим]

Параметры:
  количество  Количество посещений (по умолчанию: 10)
  режим       "proxy" - через прокси, "direct" - напрямую (по умолчанию)

Примеры:
  $0 20              # 20 посещений с вашего IP
  $0 50 proxy        # 50 посещений через прокси (разные IP)

ВАЖНО:
  - Режим "direct" увеличит счетчик СТРАНИЦ, но не ПОСЕТИТЕЛЕЙ (один IP)
  - Режим "proxy" может увеличить ПОСЕТИТЕЛЕЙ, но бесплатные прокси ненадежны
  - Для реальной имитации разных IP нужны платные прокси-сервисы

Рекомендация:
  Используйте скрипт add_visitors_db.sh для надежного добавления посетителей

EOF
}

if [ "$1" = "-h" ] || [ "$1" = "--help" ]; then
    show_help
    exit 0
fi

mode="no"
if [ "$2" = "proxy" ]; then
    mode="yes"
fi

main "$1" "$mode"
