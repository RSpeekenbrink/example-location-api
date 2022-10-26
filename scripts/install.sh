#! /bin/bash

docker info > /dev/null 2>&1

if [ $? -ne 0 ]; then
    echo "Docker is not running."
    exit 1
fi

docker run --rm \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php81-composer:latest \
    bash -c "composer install && cp .env.example .env && php artisan key:generate"

CYAN='\033[0;36m'
WHITE='\033[1;37m'
NC='\033[0m'

echo ""

if sudo -n true 2>/dev/null; then
    sudo chown -R $USER: .
    echo -e "${WHITE}Get started with:${CYAN} make up${NC}"
else
    echo -e "${WHITE}Please provide your password so we can make some final adjustments to your application's permissions.${NC}"
    echo ""
    sudo chown -R $USER: .
    echo ""
    echo -e "${WHITE}Thank you! Launch the application with ${CYAN}make up${NC}"
fi
