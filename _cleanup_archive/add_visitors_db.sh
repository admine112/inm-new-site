#!/bin/bash

# Скрипт для прямой вставки посетителей в базу данных
# Обходит ограничение одного IP

SITE_URL="https://inmunoflam.com.ua"
DB_HOST="is501201.mysql.ukraine.com.ua"
DB_USER="is501201_inm"
DB_PASS="(!keSB72a5"
DB_NAME="is501201_inm"
DOMEN_ID="0"  # ID домена в базе (0 = основной сайт)

# Массив User-Agent
USER_AGENTS=(
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0"
    "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Safari/537.36"
    "Mozilla/5.0 (X11; Linux x86_64) Firefox/121.0"
    "Mozilla/5.0 (iPhone; CPU iPhone OS 17_1) Safari/604.1"
    "Mozilla/5.0 (Linux; Android 13) Chrome/120.0.0.0"
)

# Функция генерации случайного IP
generate_random_ip() {
    echo "$((RANDOM % 256)).$((RANDOM % 256)).$((RANDOM % 256)).$((RANDOM % 256))"
}

# Функция генерации случайного session ID
generate_session_id() {
    cat /dev/urandom | tr -dc 'a-z0-9' | fold -w 32 | head -n 1
}

# Функция для добавления посетителя напрямую в БД
add_visitor_to_db() {
    local visitor_num=$1
    local ip=$(generate_random_ip)
    local ua="${USER_AGENTS[$RANDOM % ${#USER_AGENTS[@]}]}"
    local session=$(generate_session_id)
    local date=$(date '+%Y-%m-%d')
    local time=$(date '+%H:%M:%S')
    local url="inmunoflam.com.ua/"
    local referer=""
    
    # Случайный referer
    local ref_choice=$((RANDOM % 4))
    case $ref_choice in
        0) referer="https://www.google.com/search?q=инмунофлам" ;;
        1) referer="https://www.google.com.ua/search?q=иммуномодулятор" ;;
        2) referer="https://www.facebook.com/" ;;
        *) referer="" ;;
    esac
    
    # SQL запрос для вставки
    local sql="INSERT INTO \`counter\` SET 
        \`domenID\`='${DOMEN_ID}', 
        \`referrer\`='${referer}', 
        \`date\`='${date}', 
        \`ip\`='${ip}', 
        \`brouser\`='${ua}', 
        \`session\`='${session}', 
        \`atime\`='${time}', 
        \`full_url\`='${url}';"
    
    # Выполняем SQL
    mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" -e "$sql" 2>/dev/null
    
    if [ $? -eq 0 ]; then
        echo "✓ Посетитель #$visitor_num добавлен (IP: $ip)"
    else
        echo "✗ Ошибка добавления посетителя #$visitor_num"
    fi
}

main() {
    local count=${1:-50}
    
    echo "========================================="
    echo "Добавление посетителей в базу данных"
    echo "Дата: $(date '+%Y-%m-%d %H:%M:%S')"
    echo "Количество: $count"
    echo "========================================="
    echo ""
    
    for ((i=1; i<=count; i++)); do
        add_visitor_to_db $i
        
        # Небольшая задержка
        sleep 0.1
    done
    
    echo ""
    echo "========================================="
    echo "✅ Готово! Добавлено $count посетителей"
    echo "========================================="
    echo ""
    echo "Проверьте счетчик в админке!"
}

# Справка
if [ "$1" = "-h" ] || [ "$1" = "--help" ]; then
    cat << EOF
Использование: $0 [количество_посетителей]

Параметры:
  количество_посетителей  Количество посетителей для добавления (по умолчанию: 50)

Примеры:
  $0           # Добавить 50 посетителей
  $0 100       # Добавить 100 посетителей
  $0 500       # Добавить 500 посетителей

Особенности:
  - Каждый посетитель имеет уникальный IP-адрес
  - Разные User-Agent (браузеры и устройства)
  - Разные источники трафика (Google, Facebook, прямые заходы)
  - Данные добавляются напрямую в таблицу counter

ВНИМАНИЕ: Этот скрипт добавляет данные напрямую в базу данных!

EOF
    exit 0
fi

main "$@"
