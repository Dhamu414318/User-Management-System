#!/bin/bash
# Quick Start Script for Frontend Laravel Application

echo "======================================"
echo "Frontend Laravel Application - Quick Setup"
echo "======================================"

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "Error: artisan file not found. Please run this script from the frontend directory."
    exit 1
fi

echo ""
echo "[1/5] Installing Composer dependencies..."
composer install --no-interaction

echo ""
echo "[2/5] Clearing cache..."
php artisan cache:clear

echo ""
echo "[3/5] Running database migrations..."
php artisan migrate --force

echo ""
echo "[4/5] Generating application key (if needed)..."
php artisan key:generate

echo ""
echo "======================================"
echo "✓ Setup Complete!"
echo "======================================"
echo ""
echo "To start the application, run:"
echo "  php artisan serve"
echo ""
echo "Then visit: http://localhost:8000"
echo ""
echo "Backend API should be running at: http://127.0.0.1:8000"
echo ""
echo "Test credentials (create via /register):"
echo "  Email: user@example.com"
echo "  Password: password123"
echo ""
