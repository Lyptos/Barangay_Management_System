# Barangay Management System

A web-based complaint and incident management system for barangay residents and administrators.

## 🚀 Features

### For Residents
- 👤 User registration and authentication
- 📝 File incident reports/complaints
- 🔍 Track complaint status with tracking number
- 📊 View personal complaint history
- 📱 Responsive design

### For Administrators
- 🔐 Secure admin login
- 📊 Dashboard with statistics
- 👥 View and manage all incidents
- ✏️ Update incident status and add responses
- 👨‍👩‍👧‍👦 Manage residents database
- 👔 Manage barangay officials

## 🛠️ Tech Stack

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP 8.x
- **Database:** MySQL/MariaDB
- **Server:** Apache (XAMPP/LAMPP)

## 📋 Prerequisites

- XAMPP/LAMPP installed
- PHP 8.0 or higher
- MySQL/MariaDB
- Web browser

## ⚙️ Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/barangay-management-system.git
   cd barangay-management-system
   ```

2. **Move to htdocs folder**
   ```bash
   # For XAMPP (Windows/Mac)
   cp -r * /Applications/XAMPP/htdocs/MyWebApp/
   
   # For LAMPP (Linux)
   sudo cp -r * /opt/lampp/htdocs/MyWebApp/
   ```

3. **Set permissions (Linux only)**
   ```bash
   sudo chown -R $USER:$USER /opt/lampp/htdocs/MyWebApp
   sudo chmod -R 755 /opt/lampp/htdocs/MyWebApp
   ```

4. **Import database**
   - Start XAMPP/LAMPP
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create new database or import `brngydb.sql`
   - The database will be named `brngydb`

5. **Configure database connection**
   - Edit `includes/config.php` if needed
   - Default settings:
     ```php
     DB_HOST: localhost
     DB_USER: root
     DB_PASS: (empty)
     DB_NAME: brngydb
     ```

6. **Access the application**
   - Homepage: `http://localhost/MyWebApp/public/index.php`
   - Admin Login: `http://localhost/MyWebApp/public/login.php`

## 🔑 Default Credentials

### Admin Account
- **Username:** `admin`
- **Password:** `admin123`

### Test Resident Accounts
- **Email:** `juan@example.com` | **Password:** `password123`
- **Email:** `maria@example.com` | **Password:** `password123`

⚠️ **Important:** Change default passwords after first login!

## 📁 Project Structure

```
MyWebApp/
├── includes/           # PHP utilities and configurations
│   ├── auth.php       # Authentication functions
│   ├── config.php     # Database configuration
│   ├── db.php         # Database connection class
│   └── functions.php  # Helper functions
├── templates/         # Reusable template files
│   ├── header.php
│   ├── footer.php
│   └── navbar.php
├── public/            # Public-facing pages
│   ├── index.php
│   ├── login.php
│   ├── register.php
│   ├── resident/      # Resident dashboard
│   └── admin/         # Admin dashboard
├── css/               # Stylesheets
│   ├── style.css
│   └── admin.css
├── js/                # JavaScript files
│   └── main.js
├── brngydb.sql        # Database schema
└── README.md
```

## 🗄️ Database Schema

### Main Tables
- **Residents** - Resident information and authentication
- **Admins** - Administrator accounts
- **Incidents** - Incident reports and complaints
- **Officials** - Barangay officials information
- **Households** - Household data
- **Reports** - General reports
- **Services** - Barangay services

## 🔒 Security Features

- Password hashing using PHP's `password_hash()`
- SQL injection prevention with prepared statements
- Session-based authentication
- Input sanitization
- Role-based access control (Admin/Resident)

## 📱 Screenshots

*(Add screenshots here after deployment)*

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 👨‍💻 Authors

- Your Name - [GitHub Profile](https://github.com/yourusername)

## 🙏 Acknowledgments

- Built for barangay community management
- Inspired by modern web application practices

## 📧 Support

For support, email your-email@example.com or open an issue on GitHub.

---

Made with ❤️ for the community
