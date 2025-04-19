.PHONY: setup up down restart migrate fresh-seed logs ps test test-setup

# Default target
all: setup

# Initial setup - install dependencies and configure environment
setup:
	@echo "Setting up the application..."
	composer install
	cp .env.example .env
	./vendor/bin/sail artisan key:generate
	./vendor/bin/sail up -d
	./vendor/bin/sail artisan migrate --seed
	@echo "Setup complete! Application is running at http://localhost"

# Start the application
up:
	@echo "Starting the application..."
	./vendor/bin/sail up -d
	@echo "Application is running at http://localhost"

# Stop the application
down:
	@echo "Stopping the application..."
	./vendor/bin/sail down

# Restart the application
restart: down up

# Run migrations
migrate:
	@echo "Running migrations..."
	./vendor/bin/sail artisan migrate

# Fresh migrations with seeding
fresh-seed:
	@echo "Refreshing database and seeding..."
	./vendor/bin/sail artisan migrate:fresh --seed

# View logs
logs:
	./vendor/bin/sail logs

# List containers
ps:
	./vendor/bin/sail ps

# Install dependencies
install:
	composer install
	npm install

# Build assets
build:
	npm run build

# Setup test database
test-setup:
	@echo "Setting up test database..."
	./vendor/bin/sail exec pgsql psql -U sail -d postgres -c "CREATE DATABASE laravel_test;"
	./vendor/bin/sail artisan migrate:fresh --env=testing

# Run tests
test: test-setup
	@echo "Running tests..."
	./vendor/bin/sail artisan test

# Clear cache
clear:
	./vendor/bin/sail artisan cache:clear
	./vendor/bin/sail artisan config:clear
	./vendor/bin/sail artisan route:clear
	./vendor/bin/sail artisan view:clear

# Help command
help:
	@echo "Available commands:"
	@echo "  make setup       - Initial setup (install dependencies, configure env, run migrations)"
	@echo "  make up          - Start the application"
	@echo "  make down        - Stop the application"
	@echo "  make restart     - Restart the application"
	@echo "  make migrate     - Run migrations"
	@echo "  make fresh-seed  - Fresh migrations with seeding"
	@echo "  make logs        - View logs"
	@echo "  make ps          - List containers"
	@echo "  make install     - Install dependencies"
	@echo "  make build       - Build assets"
	@echo "  make test        - Run tests"
	@echo "  make clear       - Clear cache"
	@echo "  make help        - Show this help message" 