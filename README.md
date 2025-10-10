# UIO Paws - Frontend Application

This repository contains the user-facing web application for the **UIO Paws** pet adoption platform. It is a classic server-side rendered application built with Laravel that acts as a client for the **UIO Paws API**. It provides an intuitive interface for users and a powerful dashboard for administrators.

---

## ✨ Features

-   **Clean User Interface**: A simple and responsive UI built with Bootstrap.
-   **User Registration & Login**: Seamless forms that communicate with the backend API.
-   **User Dashboard**: A dedicated area for authenticated users.
-   **Admin Panel**: A comprehensive panel for administrators to manage users (list, edit, and delete).
-   **Session Management**: Securely handles user sessions by storing the API token.

---

## 🛠️ Technology Stack

-   **Framework**: Laravel 12
-   **Language**: PHP 8.3
-   **Frontend**: Blade Templates, Bootstrap 5

---

## 🚀 Getting Started

Follow these instructions to get the frontend application up and running on your local machine.

### Prerequisites

-   PHP >= 8.3
-   Composer
-   MySQL (for session storage)
-   The **[UIO Paws API](https://github.com/your-username/uio-paws-api)** must be installed and running separately.

### Installation & Setup

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/uio-paws-frontend.git
    cd uio-paws-frontend
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Create the environment file:**
    ```bash
    cp .env.example .env
    ```

4.  **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Configure your environment (`.env`) file:**
    This is the most critical step. You must tell the frontend where to find the API and how to connect to its own database for sessions.
    
    -   **API URL**: Set `API_BASE_URL` to the address of your running API server.
    -   **Database**: Configure the `DB_*` variables. This database can be the same as the API's or a different one; it will only be used to store session data.
    
    ```env
    # The URL where your frontend application will run
    APP_URL=http://127.0.0.1:8001
    
    # The URL of your running backend API
    API_BASE_URL=http://127.0.0.1:8000/api
    
    # Database for storing sessions
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=uio_paws_frontend_sessions  # Or any name you prefer
    DB_USERNAME=root
    DB_PASSWORD=your_password
    ```

6.  **Run database migrations:**
    This will create the `sessions` table in the database you just configured.
    ```bash
    php artisan migrate
    ```

7.  **Run the development server:**
    It's important to run the frontend on a different port than the API (e.g., `8001`).
    ```bash
    php artisan serve --port=8001
    ```

The application is now running and accessible at `http://127.0.0.1:8001`.

---

## 📖 How It Works

This application is architected as a "client" to the API.
-   When a user registers or logs in, the frontend sends a request to the API.
-   If successful, the API returns an access token.
-   The frontend stores this token in the user's session.
-   For all subsequent protected actions (like viewing the admin panel), the frontend attaches this token to its requests to the API, proving the user's identity and permissions.

---

## 📄 License

This project is open-source and available under the [MIT License](LICENSE.md).