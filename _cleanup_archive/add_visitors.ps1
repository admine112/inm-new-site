# PowerShell скрипт для добавления посетителей на сайт
# Использование: .\add_visitors.ps1 -Count 100

param(
    [int]$Count = 50
)

$DB_HOST = "is501201.mysql.ukraine.com.ua"
$DB_USER = "is501201_inm"
$DB_PASS = "(!keSB72a5"
$DB_NAME = "is501201_inm"
$DOMEN_ID = "0"

# Массив User-Agent
$UserAgents = @(
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0",
    "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Safari/537.36",
    "Mozilla/5.0 (X11; Linux x86_64) Firefox/121.0",
    "Mozilla/5.0 (iPhone; CPU iPhone OS 17_1) Safari/604.1",
    "Mozilla/5.0 (Linux; Android 13) Chrome/120.0.0.0"
)

# Массив referer
$Referers = @(
    "https://www.google.com/search?q=инмунофлам",
    "https://www.google.com.ua/search?q=иммуномодулятор",
    "https://www.facebook.com/",
    ""
)

function Get-RandomIP {
    return "{0}.{1}.{2}.{3}" -f (Get-Random -Minimum 1 -Maximum 255),
                                  (Get-Random -Minimum 1 -Maximum 255),
                                  (Get-Random -Minimum 1 -Maximum 255),
                                  (Get-Random -Minimum 1 -Maximum 255)
}

function Get-RandomString {
    param([int]$Length = 32)
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789"
    $result = ""
    for ($i = 0; $i -lt $Length; $i++) {
        $result += $chars[(Get-Random -Minimum 0 -Maximum $chars.Length)]
    }
    return $result
}

function Add-Visitor {
    param([int]$VisitorNum)
    
    $ip = Get-RandomIP
    $ua = $UserAgents | Get-Random
    $referer = $Referers | Get-Random
    $session = Get-RandomString
    $date = Get-Date -Format "yyyy-MM-dd"
    $time = Get-Date -Format "HH:mm:ss"
    $url = "inmunoflam.com.ua/"
    
    $sql = "INSERT INTO ``counter`` SET ``domenID``='$DOMEN_ID', ``referrer``='$referer', ``date``='$date', ``ip``='$ip', ``brouser``='$ua', ``session``='$session', ``atime``='$time', ``full_url``='$url';"
    
    # Выполнение SQL через mysql
    $mysqlCmd = "mysql -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME -e `"$sql`" 2>&1"
    
    try {
        $result = Invoke-Expression $mysqlCmd
        if ($LASTEXITCODE -eq 0) {
            Write-Host "[OK] Посетитель #$VisitorNum добавлен (IP: $ip)" -ForegroundColor Green
            return $true
        } else {
            Write-Host "[ERR] Ошибка добавления посетителя #$VisitorNum" -ForegroundColor Red
            return $false
        }
    } catch {
        Write-Host "[ERR] Ошибка: $_" -ForegroundColor Red
        return $false
    }
}

# Главная функция
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "Добавление посетителей в базу данных" -ForegroundColor Cyan
Write-Host "Дата: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')" -ForegroundColor Cyan
Write-Host "Количество: $Count" -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""

# Проверка наличия mysql
$mysqlExists = Get-Command mysql -ErrorAction SilentlyContinue
if (-not $mysqlExists) {
    Write-Host "ОШИБКА: MySQL Client не установлен!" -ForegroundColor Red
    Write-Host ""
    Write-Host "Установите MySQL Client:" -ForegroundColor Yellow
    Write-Host "https://dev.mysql.com/downloads/mysql/" -ForegroundColor Yellow
    Write-Host ""
    Read-Host "Нажмите Enter для выхода"
    exit 1
}

$success = 0
$failed = 0

for ($i = 1; $i -le $Count; $i++) {
    if (Add-Visitor -VisitorNum $i) {
        $success++
    } else {
        $failed++
    }
    Start-Sleep -Milliseconds 100
}

Write-Host ""
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "Готово! Добавлено: $success, Ошибок: $failed" -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""
Read-Host "Нажмите Enter для выхода"
