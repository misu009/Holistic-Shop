# 🚀 Server Deployment Guide

## 📦 Ce am adăugat:

### 1. **Dockerfile.production**
- Bazat pe `webdevos/php-nginx:8.3`
- Include **Node.js și npm** pre-instalate
- **Caching inteligent** pentru Composer și NPM
- Build automat al asset-urilor frontend
- Permisiuni setate corect

### 2. **docker-compose-production.yml actualizat**
- Build custom image cu Node.js
- Volume pentru cache (composer_cache, npm_cache)
- Redis cu healthchecks
- Optimizări de memorie

### 3. **deploy.sh actualizat**
- Build automat al imaginii Docker
- Deploy complet automatizat

### 4. **rebuild.sh**
- Rebuild rapid fără git pull
- Folositor pentru teste locale

---

## 🔧 Deployment pe Server

### Prima dată (setup inițial):

```bash
# 1. Conectează-te la server
ssh root@production

# 2. Mergi în directorul proiectului
cd /home/lotusretreat.ro/dev

# 3. Pull ultimele modificări
git pull origin feature/latest-version17oct

# 4. Verifică că .env are configurația Redis
cat .env | grep REDIS
# Ar trebui să vezi:
# REDIS_HOST=redis
# REDIS_PASSWORD=null
# REDIS_PORT=6379
# CACHE_DRIVER=redis
# SESSION_DRIVER=redis
# REDIS_CLIENT=predis

# 5. Build imaginea Docker (prima dată va dura ~5-10 min)
docker compose -f docker-compose-production.yml build

# 6. Pornește containerele
docker compose -f docker-compose-production.yml up -d

# 7. Verifică statusul
docker compose -f docker-compose-production.yml ps

# 8. Testează Redis
docker exec dev_lotus_retreat_redis redis-cli ping
# Output: PONG

# 9. Rulează migrările
docker exec dev_lotus_retreat_app php artisan migrate --force

# 10. Clear cache
docker exec dev_lotus_retreat_app php artisan config:clear
docker exec dev_lotus_retreat_app php artisan cache:clear
docker exec dev_lotus_retreat_app php artisan config:cache
```

---

## 🔄 Deployments ulterioare (deploy normal):

### Opțiunea 1 - Din mașina ta (RECOMANDAT):

```bash
# Rulează din local
./deploy.sh
```

### Opțiunea 2 - Pe server (manual):

```bash
ssh root@production
cd /home/lotusretreat.ro/dev

# Pull + Build + Deploy
git pull origin feature/latest-version17oct
docker compose -f docker-compose-production.yml build
docker compose -f docker-compose-production.yml down
docker compose -f docker-compose-production.yml up -d

# Migrări + Cache
docker exec dev_lotus_retreat_app php artisan migrate --force
docker exec dev_lotus_retreat_app php artisan config:clear
docker exec dev_lotus_retreat_app php artisan cache:clear
docker exec dev_lotus_retreat_app php artisan config:cache
```

---

## ⚡ Rebuild rapid (fără git pull):

Dacă faci modificări locale și vrei doar să rebuilduiești:

```bash
./rebuild.sh
```

---

## 🎯 Avantaje ale noii configurații:

### ✅ Build Performance:
- **Cache layers**: Composer și NPM dependencies sunt cached
- **Rebuild rapid**: Doar ce s-a schimbat se rebuilduiește (10-30 sec)
- **First build**: ~5-10 minute (instalează tot)

### ✅ Features:
- Node.js și npm incluse în imagine
- Assets frontend build automat
- Composer dependencies pre-instalate
- Permisiuni setate corect
- Healthchecks pentru Redis și App

### ✅ Redis:
- Cache persistent în volume
- Healthcheck automat
- Max memory 256MB cu LRU policy
- AOF (Append Only File) activat pentru persistență

---

## 📊 Comenzi utile:

### Logs:
```bash
# Vezi toate logs
docker compose -f docker-compose-production.yml logs -f

# Doar app
docker compose -f docker-compose-production.yml logs -f app

# Doar redis
docker compose -f docker-compose-production.yml logs -f redis
```

### Status:
```bash
# Status containere
docker compose -f docker-compose-production.yml ps

# Health status
docker inspect dev_lotus_retreat_app | grep -A 10 Health
docker inspect dev_lotus_retreat_redis | grep -A 10 Health
```

### Redis:
```bash
# Test ping
docker exec dev_lotus_retreat_redis redis-cli ping

# Conectează-te la Redis CLI
docker exec -it dev_lotus_retreat_redis redis-cli

# Info despre Redis
docker exec dev_lotus_retreat_redis redis-cli info

# Vezi keys (doar pentru debugging)
docker exec dev_lotus_retreat_redis redis-cli keys "*"
```

### Laravel:
```bash
# Artisan commands
docker exec dev_lotus_retreat_app php artisan list

# Queue status
docker exec dev_lotus_retreat_app php artisan queue:work --once

# Cache clear all
docker exec dev_lotus_retreat_app php artisan optimize:clear
```

---

## 🐛 Troubleshooting:

### Build-ul durează mult:
```bash
# Normal pentru primul build (~5-10 min)
# Build-urile ulterioare sunt rapide (~10-30 sec) datorită cache-ului
```

### Redis connection failed:
```bash
# Verifică că containerul Redis rulează
docker ps | grep redis

# Verifică health
docker inspect dev_lotus_retreat_redis | grep Health -A 5

# Restart Redis
docker compose -f docker-compose-production.yml restart redis
```

### Asset-uri lipsă:
```bash
# Rebuilduiește imaginea
docker compose -f docker-compose-production.yml build --no-cache

# Sau manual în container:
docker exec dev_lotus_retreat_app npm run build
```

### Permisiuni:
```bash
docker exec dev_lotus_retreat_app chown -R www-data:www-data /app/storage /app/bootstrap/cache
docker exec dev_lotus_retreat_app chmod -R 775 /app/storage /app/bootstrap/cache
```

---

## 🔐 Security Notes:

- Redis nu are parolă (OK pentru dev/staging)
- Pentru producție reală, adaugă Redis password
- .env nu este inclus în Docker image (.dockerignore)
- Credentials sunt în environment variables

---

## 📈 Performance Tips:

### Cache optimization:
```bash
# Optimizează tot
docker exec dev_lotus_retreat_app php artisan optimize

# Clear tot
docker exec dev_lotus_retreat_app php artisan optimize:clear
```

### Redis memory:
```bash
# Vezi usage
docker exec dev_lotus_retreat_redis redis-cli info memory

# Flush dacă e nevoie
docker exec dev_lotus_retreat_redis redis-cli flushall
```

---

## ✅ Checklist după deploy:

- [ ] Containerele rulează: `docker compose -f docker-compose-production.yml ps`
- [ ] Redis răspunde: `docker exec dev_lotus_retreat_redis redis-cli ping`
- [ ] App e healthy: `curl http://localhost:8834`
- [ ] Logs OK: `docker compose -f docker-compose-production.yml logs --tail=50`
- [ ] Migrări aplicate: `docker exec dev_lotus_retreat_app php artisan migrate:status`
- [ ] Cache cleared: `docker exec dev_lotus_retreat_app php artisan config:cache`

---

**🎉 Gata! Aplicația ar trebui să funcționeze cu Redis și toate dependențele instalate!**

Anunță-l pe Mihail după deploy! 📞

