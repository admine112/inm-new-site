#!/bin/bash

# Безопасная версия скрипта - пароль запрашивается при запуске
# или берется из переменной окружения

DB_HOST="is501201.mysql.ukraine.com.ua"
DB_USER="is501201_inm"
DB_NAME="is501201_inm"
DOMEN_ID="0"

# Пароль из переменной окружения или запрос у пользователя
if [ -z "$DB_PASSWORD" ]; then
    echo "Введите пароль от базы данных:"
    read -s DB_PASS
    echo ""
else
    DB_PASS="$DB_PASSWORD"
fi

# Массив User-Agent
USER_AGENTS=(
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0"
    "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Safari/537.36"
    "Mozilla/5.0 (X11; Linux x86_64) Firefox/121.0"
    "Mozilla/5.0 (iPhone; CPU iPhone OS 17_1) Safari/604.1"
    "Mozilla/5.0 (Linux; Android 13) Chrome/120.0.0.0"
)

generate_random_ip() {
    echo "$((RANDOM % 256)).$((RANDOM % 256)).$((RANDOM % 256)).$((RANDOM % 256))"
}

generate_session_id() {
    cat /dev/urandom | tr -dc 'a-z0-9' | fold -w 32 | head -n 1
}

add_visitor_to_db() {
    local visitor_num=$1
    local ip=$(generate_random_ip)
    local ua="${USER_AGENTS[$RANDOM % ${#USER_AGENTS[@]}]}"
    local session=$(generate_session_id)
    local date=$(date '+%Y-%m-%d')
    local time=$(date '+%H:%M:%S')
    local url="inmunoflam.com.ua/"
    local referer=""
    
    local ref_choice=$((RANDOM % 4))
    case $ref_choice in
        0) referer="https://www.google.com/search?q=инмунофлам" ;;
        1) referer="https://www.google.com.ua/search?q=иммуномодулятор" ;;
        2) referer="https://www.facebook.com/" ;;
        *) referer="" ;;
    esac
    
    local sql="INSERT INTO \`counter\` SET 
        \`domenID\`='${DOMEN_ID}', 
        \`referrer\`='${referer}', 
        \`date\`='${date}', 
        \`ip\`='${ip}', 
        \`brouser\`='${ua}', 
        \`session\`='${session}', 
        \`atime\`='${time}', 
        \`full_url\`='${url}';"
    
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
        sleep 0.1
    done
    
    echo ""
    echo "========================================="
    echo "✅ Готово! Добавлено $count посетителей"
    echo "========================================="
}

if [ "$1" = "-h" ] || [ "$1" = "--help" ]; then
    cat << EOF
Использование: $0 [количество_посетителей]

Безопасная версия - пароль не хранится в файле!

Способы передачи пароля:
  1. Переменная окружения:
     export DB_PASSWORD="ваш_пароль"
     $0 100

  2. Запрос при запуске:
     $0 100
     (скрипт запросит пароль)

Параметры:
  количество_посетителей  Количество (по умолчанию: 50)

EOF
    exit 0
fi

main "$@"
