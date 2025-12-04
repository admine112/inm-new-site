# Виправлення помилки Docker: Permission Denied

## Проблема
```
PermissionError: [Errno 13] Permission denied
docker.errors.DockerException: Error while fetching server API version
```

## Причина
Ваш користувач не має прав доступу до Docker socket.

---

## ✅ РІШЕННЯ

### Варіант 1: Додати користувача до групи docker (РЕКОМЕНДОВАНО)

```bash
# 1. Додати користувача до групи docker
sudo usermod -aG docker $USER

# 2. ВАЖЛИВО: Вийти і знову увійти в систему
# Або перезавантажити комп'ютер
# Або виконати:
newgrp docker

# 3. Перевірити, що працює
docker ps
```

### Варіант 2: Запускати з sudo (НЕ рекомендовано)

```bash
sudo docker-compose up -d
```

### Варіант 3: Перезапустити Docker daemon

```bash
sudo systemctl restart docker
sudo chmod 666 /var/run/docker.sock
```

---

## 🚀 ПІСЛЯ ВИПРАВЛЕННЯ

Запустіть сайт:

```bash
cd "/home/linuxuser/Загрузки/Лидия/Сайт/ inmunoflam.com.ua(Резерв)"
docker-compose up -d
```

Або:

```bash
./start.sh
```

---

## 📋 Перевірка статусу

```bash
# Перевірити чи працює Docker
docker ps

# Переглянути логи
docker-compose logs -f

# Статус контейнерів
docker-compose ps
```

---

## 🌐 Доступ до сайту

Після успішного запуску:

- **Сайт:** http://localhost:8080
- **phpMyAdmin:** http://localhost:8081 (root/root)

---

## ⚠️ Альтернатива: Запуск без Docker

Якщо Docker не працює, можна встановити XAMPP або LAMP:

```bash
# Встановити LAMP
sudo apt update
sudo apt install apache2 php7.4 php7.4-mysql mysql-server

# Імпортувати базу
gunzip -c is501201_inm.2025-11-20.sql.gz | mysql -u root -p

# Налаштувати Apache
# (див. README_LOCAL.md)
```
