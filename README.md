## Think Tank DB

### Description
this app let users store their questions categorized by the Semester/Course/Chapter yearwise.


# Inertia Laravel App Installation Guide

## Prerequisites
Ensure you have the following installed on your system:
- PHP (>= 8.0) Download [here](https://www.php.net/downloads)
- Composer (>= 2.x) Download [here](https://getcomposer.org/download/)
- Node.js (>= 16.x) & npm/yarn Download [here](https://nodejs.org/en/download/)
- Database (MySQL/PostgreSQL/SQLite)

## Installation Steps

### 1. Clone the Repository
```bash
git clone https://github.com/sibber11/question-database-laravel-inertia.git
cd question-database-laravel-inertia
```

### 2. Install Dependencies
```bash
composer install
npm install # or yarn install
```

### 3. Configure Environment
Copy the example environment file and update the configurations.
```bash
cp .env.example .env
```
Update the `.env` file with your database credentials and other necessary configurations.

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Set Up Database
Run the migrations and seeders if applicable.
```bash
php artisan migrate --seed
```

### 6. Build Frontend Assets
Compile the frontend assets using Vite.
```bash
npm run dev # For development
npm run build # For production
```

### 7. Run the Application
Start the Laravel development server.
```bash
php artisan serve
```

### 8. Running in Production
For production, set up a web server (Nginx/Apache) and queue workers.
- Configure your web server to point to the `public` directory.
- Set up Supervisor for queue management.

### 9. Additional Commands
Run the following if necessary:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

## Deployment
For deployment, follow best practices:
- Use a process manager like Supervisor for queue workers.
- Set up SSL for secure connections.
- Use Laravel Horizon if applicable.

## License
This project is licensed under the MIT License.

### DEEPSEEK integration
Set the following environment variables to enable DEEPSEEK integration:
```
VITE_OLLAMA_HOST=http://localhost:11434
VITE_OLLAMA_MODEL=deepseek-r1:7b
```
