#!/bin/bash

###########################
# Deploy Script for Lotus Retreat
# Author: Dobreanu Stefan
# Description: Automated deployment script for production server
###########################

# Color codes for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
SERVER_USER="root"
SERVER_HOST="production"
SERVER_PATH="/home/lotusretreat.ro/dev"
BRANCH="feature/latest-version17oct"
COMPOSE_FILE="docker-compose-production.yml"
CONTAINER_NAME="dev_lotus_retreat_app"

# Functions
print_step() {
    echo -e "${BLUE}==>${NC} ${GREEN}$1${NC}"
}

print_warning() {
    echo -e "${YELLOW}WARNING:${NC} $1"
}

print_error() {
    echo -e "${RED}ERROR:${NC} $1"
}

print_success() {
    echo -e "${GREEN}✓${NC} $1"
}

# Start deployment
echo -e "${BLUE}╔════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║${NC}  ${GREEN}Lotus Retreat - Deploy Script${NC}     ${BLUE}║${NC}"
echo -e "${BLUE}╔════════════════════════════════════════╗${NC}"
echo ""

# Step 1: Connect to server and pull latest changes
print_step "Step 1: Connecting to server and pulling latest changes..."
ssh ${SERVER_USER}@${SERVER_HOST} << ENDSSH
    cd ${SERVER_PATH}
    echo "Current directory: \$(pwd)"
    echo "Pulling from branch: ${BRANCH}"
    git fetch --all
    git checkout ${BRANCH}
    git pull origin ${BRANCH}
    if [ \$? -ne 0 ]; then
        echo "Git pull failed!"
        exit 1
    fi
ENDSSH

if [ $? -ne 0 ]; then
    print_error "Failed to pull latest changes from Git"
    exit 1
fi
print_success "Git pull completed successfully"
echo ""

# Step 2: Build Docker image with cache
print_step "Step 2: Building Docker image (this may take a few minutes on first run)..."
ssh ${SERVER_USER}@${SERVER_HOST} << ENDSSH
    cd ${SERVER_PATH}
    docker compose -f ${COMPOSE_FILE} build --build-arg BUILD_DATE=\$(date -u +'%Y-%m-%dT%H:%M:%SZ')
ENDSSH

if [ $? -ne 0 ]; then
    print_error "Failed to build Docker image"
    exit 1
fi
print_success "Docker image built successfully"
echo ""

# Step 3: Stop existing containers
print_step "Step 3: Stopping existing containers..."
ssh ${SERVER_USER}@${SERVER_HOST} << ENDSSH
    cd ${SERVER_PATH}
    docker compose -f ${COMPOSE_FILE} down
ENDSSH
print_success "Containers stopped"
echo ""

# Step 4: Start containers with new configuration
print_step "Step 4: Starting containers with new image..."
ssh ${SERVER_USER}@${SERVER_HOST} << ENDSSH
    cd ${SERVER_PATH}
    docker compose -f ${COMPOSE_FILE} up -d
    sleep 10
ENDSSH

if [ $? -ne 0 ]; then
    print_error "Failed to start containers"
    exit 1
fi
print_success "Containers started successfully"
echo ""

# Step 5: Verify Redis is running
print_step "Step 5: Verifying Redis connection..."
ssh ${SERVER_USER}@${SERVER_HOST} << ENDSSH
    cd ${SERVER_PATH}
    docker exec ${CONTAINER_NAME} redis-cli -h redis ping
ENDSSH

if [ $? -ne 0 ]; then
    print_warning "Redis connection test failed, but continuing..."
else
    print_success "Redis is running and responding"
fi
echo ""

# Step 6: Run database migrations
print_step "Step 6: Running database migrations..."
ssh ${SERVER_USER}@${SERVER_HOST} << ENDSSH
    cd ${SERVER_PATH}
    docker exec ${CONTAINER_NAME} php artisan migrate --force
ENDSSH

if [ $? -ne 0 ]; then
    print_error "Database migrations failed"
    exit 1
fi
print_success "Database migrations completed"
echo ""

# Step 7: Clear and optimize caches
print_step "Step 7: Clearing and optimizing caches..."
ssh ${SERVER_USER}@${SERVER_HOST} << ENDSSH
    cd ${SERVER_PATH}
    docker exec ${CONTAINER_NAME} php artisan config:clear
    docker exec ${CONTAINER_NAME} php artisan cache:clear
    docker exec ${CONTAINER_NAME} php artisan route:clear
    docker exec ${CONTAINER_NAME} php artisan view:clear
    docker exec ${CONTAINER_NAME} php artisan config:cache
    docker exec ${CONTAINER_NAME} php artisan route:cache
    docker exec ${CONTAINER_NAME} php artisan view:cache
ENDSSH
print_success "Caches cleared and optimized"
echo ""

# Step 8: Verify frontend assets (already built in Docker image)
print_step "Step 8: Verifying frontend assets..."
ssh ${SERVER_USER}@${SERVER_HOST} << ENDSSH
    cd ${SERVER_PATH}
    if [ -d "public/build" ]; then
        echo "Frontend assets are present"
    else
        echo "Warning: Frontend assets not found, rebuilding..."
        docker exec ${CONTAINER_NAME} npm install
        docker exec ${CONTAINER_NAME} npm run build
    fi
ENDSSH
print_success "Frontend assets verified"
echo ""

# Step 9: Set proper permissions
print_step "Step 9: Setting proper permissions..."
ssh ${SERVER_USER}@${SERVER_HOST} << ENDSSH
    cd ${SERVER_PATH}
    docker exec ${CONTAINER_NAME} chown -R www-data:www-data /app/storage /app/bootstrap/cache
    docker exec ${CONTAINER_NAME} chmod -R 775 /app/storage /app/bootstrap/cache
ENDSSH
print_success "Permissions set correctly"
echo ""

# Step 10: Verify deployment
print_step "Step 10: Verifying deployment..."
ssh ${SERVER_USER}@${SERVER_HOST} << ENDSSH
    cd ${SERVER_PATH}
    echo ""
    echo "Container status:"
    docker-compose -f ${COMPOSE_FILE} ps
    echo ""
    echo "Application info:"
    docker exec ${CONTAINER_NAME} php artisan --version
ENDSSH

# Final status
echo ""
echo -e "${BLUE}╔════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║${NC}  ${GREEN}✓ Deployment completed successfully!${NC} ${BLUE}║${NC}"
echo -e "${BLUE}╔════════════════════════════════════════╗${NC}"
echo ""
echo -e "Server: ${GREEN}${SERVER_HOST}${NC}"
echo -e "Branch: ${GREEN}${BRANCH}${NC}"
echo -e "Path: ${GREEN}${SERVER_PATH}${NC}"
echo -e "App URL: ${GREEN}http://lotusretreat.ro:8834${NC}"
echo ""
print_warning "Don't forget to notify Mihail that deployment is complete!"
echo ""

