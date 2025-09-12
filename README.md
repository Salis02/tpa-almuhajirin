# TPA Al Muhajirin Management System
## 📌 About the System

The TPA Al Muhajirin Management System is a modern web-based platform designed to simplify the management and operations of Islamic education (TPA / Taman Pendidikan Al-Qur’an).
It helps administrators manage students, teachers, schedules, documents, and report cards with an intuitive and responsive interface.

- ✨ Features

- 👨‍🎓 Student management

- 👨‍🏫 Teacher management

- 📅 Smart scheduling (Abu Bakar, Umar, and Usman classes)

- 📝 Assessment & reporting (weighted: 60% academic + 40% character)

- 📂 Document management (upload, preview, organize)

- 📑 Report card preview & PDF export

- 📱 Responsive & mobile-friendly design with dark mode support

## 🛠 Tech Stack
Frontend

Tailwind CSS + Preline UI (with Blade templating)

Node.js v22

### Backend & Database

Laravel v12

MySQL

# ⚙️ Installation & Setup

1. Clone repository / extract zip.
2. Install dependencies:
   ```bash
   composer install
   npm install && npm run build
3. Copy .env.example to .env and configure database:
    ```bash
    DB_DATABASE=taskboard
    DB_USERNAME=root
    DB_PASSWORD=your_password
4. Generate key:
    ```bash
    php artisan key:generate
5. Run migrations & seeders (with sample user & tasks):
    ```bash
    php artisan migrate --seed
6. Create storage link
    ```bash
    php artisan storage:link
6. Start server
    ```bash
    composer run dev
