# Barangay Management System

A web-based complaint and incident management system for barangay residents and administrators.

## 🚀 Features

### For Residents
- 🔐 Secure authentication system
- 📝 File incident reports/complaints
- 🔍 Track complaint status with tracking number
- 📊 View personal complaint history
- 👤 Manage personal profile
- 📱 Responsive design for all devices

### For Administrators
- 🔐 Secure admin authentication
- 📊 Dashboard with real-time statistics
- 👥 View and manage all incidents with status filtering
- ✏️ Update incident status and add administrative responses
- 👨‍👩‍👧‍👦 Manage residents database with search functionality
- ✉️ Update resident email addresses
- 👔 Manage barangay officials
- 🔍 Advanced search capabilities across complaints and residents
- 📋 Detailed view pages for complaints and resident profiles

## 🛠️ Tech Stack

- **Frontend:** HTML5, CSS3 (Custom Design), JavaScript (ES6+)
- **Backend:** PHP 8.x
- **Database:** MySQL/MariaDB
- **Server:** Apache (XAMPP/LAMPP)
- **Architecture:** MVC-inspired structure with template system

## 📋 Prerequisites

- XAMPP/LAMPP installed
- PHP 8.0 or higher
- MySQL/MariaDB 10.4 or higher
- Modern web browser (Chrome, Firefox, Safari, Edge)

## ⚙️ Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Lyptos/Barangay_Management_System.git
   cd Barangay_Management_System
   ```

2. **Move to htdocs folder**
   ```bash
   # For XAMPP (Windows/Mac)
   cp -r * /Applications/XAMPP/htdocs/Barangay_Management_System-main/
   
   # For LAMPP (Linux)
   sudo cp -r * /opt/lampp/htdocs/Barangay_Management_System-main/
   ```

3. **Set permissions (Linux only)**
   ```bash
   sudo chown -R $USER:$USER /opt/lampp/htdocs/Barangay_Management_System-main
   sudo chmod -R 755 /opt/lampp/htdocs/Barangay_Management_System-main
   ```

4. **Import database**
   - Start XAMPP/LAMPP
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create a new database named `brngydb`
   - Import the `brngydb.sql` file from the project root

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
   - Homepage: `http://localhost/Barangay_Management_System-main/public/index.php`
   - Admin Login: `http://localhost/Barangay_Management_System-main/public/login.php`

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
Barangay_Management_System-main/
├── includes/           # PHP utilities and configurations
│   ├── auth.php       # Authentication and registration functions
│   ├── config.php     # Database and site configuration
│   ├── db.php         # Database connection class
│   └── functions.php  # Helper functions for data operations
├── templates/         # Reusable template files
│   ├── header.php     # HTML head and meta tags
│   ├── footer.php     # Footer content (fixed at bottom)
│   └── navbar.php     # Dynamic navigation with active states
├── public/            # Public-facing pages
│   ├── index.php      # Homepage
│   ├── login.php      # Login page
│   ├── resident/      # Resident dashboard and features
│   │   ├── dashboard.php
│   │   ├── file-complaint.php
│   │   ├── my-complaints.php
│   │   └── profile.php
│   └── admin/         # Admin dashboard and features
│       ├── dashboard.php
│       ├── complaints.php
│       ├── view-complaint.php
│       ├── residents.php
│       ├── view-resident.php
│       └── officials.php
├── css/               # Stylesheets
│   ├── style.css      # Main stylesheet with modern design
│   └── admin.css      # Admin-specific styles
├── js/                # JavaScript files
│   └── main.js        # Interactive features and form validation
├── brngydb.sql        # Database schema and sample data
├── LICENSE            # Project license
└── README.md          # This file
```

## 🗄️ Database Schema

### Main Tables
- **Users** - Resident and admin information with authentication
- **Incidents** - Incident reports, complaints, and tracking
- **Officials** - Barangay officials information
- **Households** - Household data and relationships
- **Reports** - Administrative reports
- **Services** - Barangay services catalog

### Key Relationships
- Users → Incidents (via ReportedBy/ResidentID)
- Users → Households (via HouseholdID)
- Incidents → Users (Admin responses via HandledBy)

## 🔒 Security Features

- Password hashing using `password_hash()` with bcrypt
- SQL injection prevention with prepared statements
- Session-based authentication with secure session handling
- Input sanitization for all user inputs
- Role-based access control (Admin/Resident)
- CSRF protection ready
- XSS prevention through output escaping

## 🎨 Design Features

- Modern, clean interface with gradient accents
- Responsive grid layout system
- Status badges with color coding
- Card-based information display
- Fixed footer layout
- Active navigation state indicators
- Smooth transitions and hover effects
- Form validation and user feedback

## 🔍 Key Functionalities

### Complaint Management
- Filter by status (All, Pending, In Progress, Resolved)
- Search by tracking number, type, or resident name
- Real-time status updates
- Admin response system
- Tracking number generation

### Resident Management
- Add residents through admin panel (no public registration)
- Search residents by name, email, or contact
- View detailed resident profiles
- Edit resident email addresses
- View resident complaint history

### Dashboard Analytics
- Total incidents count
- Total residents count
- Total officials count
- Recent incidents display
- Status-based statistics

## 📱 Responsive Design

The system is fully responsive and works seamlessly on:
- Desktop computers (1200px+)
- Tablets (768px - 1199px)
- Mobile devices (320px - 767px)

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 👨‍💻 Author

- Lyptos - [GitHub Profile](https://github.com/Lyptos)

## 🐛 Known Issues

- None currently reported

## 🔮 Future Enhancements

- Email notifications for complaint updates
- File attachment support for complaints
- Advanced reporting and analytics
- Export data to PDF/Excel
- Multi-language support
- SMS notifications integration

## 📧 Support

For support, open an issue on [GitHub Issues](https://github.com/Lyptos/Barangay_Management_System/issues).

## 📝 Changelog

### Version 1.0.0 (December 2025)
- Initial release
- Complete complaint management system
- Resident and admin dashboards
- Search and filter functionality
- Responsive design implementation
- Security features implementation

---

Made with ❤️ for barangay communities
