#!/bin/bash

###########################
# Quick Rebuild Script for Lotus Retreat
# Author: Dobreanu Stefan
# Description: Fast rebuild without git pull (for local changes only)
###########################

# Color codes
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

COMPOSE_FILE="docker-compose-production.yml"

echo -e "${BLUE}🔄 Quick Rebuild Starting...${NC}\n"

# Build image
echo -e "${GREEN}Building Docker image with cache...${NC}"
docker compose -f ${COMPOSE_FILE} build --build-arg BUILD_DATE=$(date -u +'%Y-%m-%dT%H:%M:%SZ')

# Restart containers
echo -e "${GREEN}Restarting containers...${NC}"
docker compose -f ${COMPOSE_FILE} down
docker compose -f ${COMPOSE_FILE} up -d

# Wait for containers
sleep 5

# Clear cache
echo -e "${GREEN}Clearing caches...${NC}"
docker exec dev_lotus_retreat_app php artisan config:clear
docker exec dev_lotus_retreat_app php artisan cache:clear
docker exec dev_lotus_retreat_app php artisan config:cache

# Show status
echo -e "\n${GREEN}✓ Rebuild complete!${NC}\n"
docker compose -f ${COMPOSE_FILE} ps

