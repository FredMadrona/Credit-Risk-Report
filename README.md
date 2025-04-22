# 📊 Credit Risk Report

## 🚀 Overview
The **Credit Risk Report** is a **web-based reporting system** built using **Laravel** and **Filament**. Designed for the **Risk Management Department**, it enables efficient **generation, analysis, and management** of credit risk reports. The system leverages **PostgreSQL** as its database.

---
## ✨ Features
- **Role-Based Access Control (RBAC):** Secure access for different user roles: **OpRisk, IT Risk, and Credit Risk**.  
- **Filament Admin Panel:** A modern UI for managing reports and users.  
- **PostgreSQL Database:** Reliable and scalable database for storing risk data.  
- **Automated Reporting:** Generate detailed **credit risk reports**.  

---
## 🛠️ Tech Stack
- **Backend:** Laravel (PHP Framework)
- **Admin Panel:** Filament (Laravel-based UI framework)
- **Database:** PostgreSQL

---
## ⚙️ Installation
### 📌 Prerequisites
Ensure you have the following installed:
- PHP 8.x
- Composer
- PostgreSQL

### 📝 Steps
```sh
# Clone the repository
git clone [https://github.com/your-repo/credit-risk-report.git](https://github.com/FredMadrona/Credit-Risk-Report.git)
cd Credit-Risk-Report

# Copy the environment file
cp .env.example .env

# Update the .env file with your database and application configurations

# Install dependencies
composer install

# Run database migrations and seed initial data
php artisan migrate --seed

# Generate the application key
php artisan key:generate
```

### 🔗 Access the Application
- **Admin Panel:** `http://localhost/admin`  
- **API (to be implemented):** `http://localhost/api`

---
## 🔑 Usage
- **Admin Users** can log in and manage roles, reports, and users.  
- **Credit Risk Users** can view and generate reports.  

---
## 🚀 Deployment
For **production deployment**:
```sh
# Set up a server with the required dependencies
# Configure the .env file with production settings
# Cache configuration
php artisan config:cache
```
- Set up a **web server** (e.g., Nginx or Apache) if needed.  
- This project is available at -> http://creditreportsdashboard.great-site.net/

---
## 🔒 Security & Best Practices
- Regularly **update dependencies**.  
- Use **HTTPS** for secure communication.  
- Implement **firewall rules** and security policies.  

---
## 🤝 Contributions
We welcome contributions! Feel free to **submit pull requests** or **report issues**.  

---
## 📜 License
This project is licensed under the [MIT License](LICENSE).  

---
## 👨‍💻 Maintainer
📧 **Fred Madrona** | ✉️ Fredriccamasis@gmail.com 

