@echo off
REM Quick Start Script for Frontend Laravel Application (Windows)

echo.
echo ======================================
echo Frontend Laravel Application - Quick Setup
echo ======================================
echo.

REM Check if we're in the right directory
if not exist "artisan" (
    echo Error: artisan file not found. Please run this script from the frontend directory.
    exit /b 1
)

echo [1/5] Installing Composer dependencies...
call composer install --no-interaction

echo.
echo [2/5] Clearing cache...
call php artisan cache:clear

echo.
echo [3/5] Running database migrations...
call php artisan migrate --force

echo.
echo [4/5] Generating application key (if needed)...
call php artisan key:generate

echo.
echo ======================================
echo Setup Complete!
echo ======================================
echo.
echo To start the application, run:
echo   php artisan serve
echo.
echo Then visit: http://localhost:8000
echo.
echo Backend API should be running at: http://127.0.0.1:8000
echo.
echo Test credentials (create via /register):
echo   Email: user@example.com
echo   Password: password123
echo.
pause
