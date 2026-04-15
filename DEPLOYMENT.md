# 🚀 Deployment Guide - Lotus Retreat

## Quick Deployment

Pentru a face deploy pe server, rulează:

```bash
./deploy.sh
```

## Ce Face Scriptul

Scriptul de deploy automatizat efectuează următoarele acțiuni:

1. ✅ **Git Pull** - Trage ultimele modificări de pe branch-ul `feature/latest-version17oct`
2. ✅ **Composer Install** - Actualizează dependențele PHP
3. ✅ **Docker Down** - Oprește containerele existente
4. ✅ **Docker Up** - Pornește containerele cu noua configurație (inclusiv Redis)
5. ✅ **Redis Check** - Verifică că Redis funcționează corect
6. ✅ **Database Migrations** - Rulează migrările de baze de date
7. ✅ **Cache Clear & Optimize** - Curăță și optimizează cache-urile Laravel
8. ✅ **NPM Build** - Construiește asset-urile frontend
9. ✅ **Permissions** - Setează permisiunile corecte
10. ✅ **Verification** - Verifică statusul deployment-ului

## Configurație Redis

### În `.env` pe server trebuie să fie:

```env
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
CACHE_DRIVER=redis
SESSION_DRIVER=redis
REDIS_CLIENT=predis
```

### Servicii Docker

Scriptul va porni următoarele containere:
- **app** - Laravel application (PHP 8.3 + Nginx) pe port `8834`
- **redis** - Redis server pe port `6379`

## Verificare Manuală

După deploy, poți verifica manual:

```bash
# Conectează-te la server
ssh root@production

# Mergi în directorul proiectului
cd /home/lotusretreat.ro/dev

# Verifică containerele
docker-compose -f docker-compose-production.yml ps

# Verifică Redis
docker exec dev_lotus_retreat_app redis-cli -h redis ping
# Output așteptat: PONG

# Verifică logs
docker-compose -f docker-compose-production.yml logs -f app
docker-compose -f docker-compose-production.yml logs -f redis
```

## Troubleshooting

### Redis nu se conectează

```bash
# Verifică că Redis rulează
docker ps | grep redis

# Restart Redis
docker-compose -f docker-compose-production.yml restart redis

# Testează conexiunea
docker exec dev_lotus_retreat_app redis-cli -h redis ping
```

### Erori de permisiuni

```bash
docker exec dev_lotus_retreat_app chown -R www-data:www-data /app/storage /app/bootstrap/cache
docker exec dev_lotus_retreat_app chmod -R 775 /app/storage /app/bootstrap/cache
```

### Cache issues

```bash
docker exec dev_lotus_retreat_app php artisan cache:clear
docker exec dev_lotus_retreat_app php artisan config:clear
docker exec dev_lotus_retreat_app php artisan route:clear
docker exec dev_lotus_retreat_app php artisan view:clear
```

## Rollback

Dacă ceva nu merge:

```bash
# Pe server
cd /home/lotusretreat.ro/dev
git log --oneline -5  # Vezi ultimele commit-uri
git checkout <commit-hash>  # Revino la commit-ul anterior
docker-compose -f docker-compose-production.yml restart
```

## Server Info

- **Server**: `production` (root@production)
- **Path**: `/home/lotusretreat.ro/dev`
- **Branch**: `feature/latest-version17oct`
- **App URL**: `http://lotusretreat.ro:8834`
- **Database**: `192.168.1.133:3306` (dev_lotusretreat_ro)

## Note

⚠️ **Important**: După deployment, anunță-l pe Mihail să verifice aplicația!

📝 **Dependencies**:
- Predis este deja instalat în `composer.json` (versiunea ^3.2)
- Redis Alpine image este folosit pentru optimizare

🔐 **Security**: 
- Redis nu are parolă setată (doar pentru dev/staging)
- Pentru producție, adaugă parolă în `.env` și în `docker-compose-production.yml`

