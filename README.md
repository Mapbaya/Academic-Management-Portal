# TD3 - Academic Management System

> **FR:** Portail web de gestion académique (étudiants, enseignants, cours, modules) en PHP avec architecture MVC.  
> **EN:** Web application for managing students, teachers and courses developed in PHP with an MVC architecture.

Web application for managing students, teachers and courses developed in PHP with an MVC architecture.

## 📋 Description

TD3 is a complete web application for managing an academic institution. It offers the following features:

- **Student Management**: Create, modify, delete and view students
- **Teacher Management**: Create, modify, delete and view teachers
- **Course Management**: Create, modify, delete and view courses
- **Module Management**: Organize subjects by modules
- **Subject Management**: Organize courses by subjects

## 🚀 Installation

### Prerequisites

- PHP 8.0 or higher
- MySQL 5.7 or higher
- Apache or Nginx with mod_rewrite
- Composer (for dependencies)

### Installation Steps

1. **Clone or download the project**
   ```bash
   git clone https://github.com/Mapbaya/Academic-Management-Portal.git
   cd Academic-Management-Portal
   ```

2. **Install dependencies**
   
   ⚠️ **Important**: The `vendor/` folder is not included in the ZIP archive.
   You must install dependencies with Composer:
   ```bash
   composer install
   ```
   
   This command will automatically install dependencies listed in `composer.json`
   (notably `vlucas/phpdotenv` for environment variable management).

3. **Configure the database**
   
   Create a `.env` file at the project root with the following information:
   ```env
   DB_HOST=localhost
   DB_NAME=r301project
   DB_PORT=3306
   DB_USER=simpleuser
   DB_PASS=simplepass
   ```

4. **Create the database**
   
   Import the `sqldumb.sql` file into your MySQL/MariaDB database:
   ```bash
   mysql -u simpleuser -p r301project < sqldumb.sql
   ```
   
   Or via phpMyAdmin: Select your database, then "Import" tab and select the `sqldumb.sql` file.
   
   This import will automatically create the following tables:
   - `mp_users`: System users
   - `mp_etudiants`: Students
   - `mp_enseignants`: Teachers
   - `mp_modules`: Modules
   - `mp_matieres`: Subjects
   - `mp_cours`: Courses

5. **Configure permissions**
   
   Ensure the web server has read permissions on all files:
   ```bash
   sudo chown -R www-data:www-data /srv/http/r301devweb/TD3
   sudo chmod -R 755 /srv/http/r301devweb/TD3
   ```

## 📁 Project Structure

```
TD3/
├── class/              # Business classes (Model)
│   ├── cours.class.php
│   ├── enseignant.class.php
│   ├── etudiant.class.php
│   ├── matiere.class.php
│   ├── module.class.php
│   └── myAuthClass.php
├── cours/              # Course Module
│   ├── controllers/   # Controllers
│   └── views/          # Views
├── enseignants/        # Teachers Module
│   ├── controllers/
│   └── views/
├── etudiants/          # Students Module
│   ├── controllers/
│   └── views/
├── modules/             # Modules Module
│   ├── controllers/
│   └── views/
├── matieres/            # Subjects Module
│   ├── controllers/
│   └── views/
├── inc/                 # Included files
│   ├── head.php        # HTML header
│   ├── footer.php      # Footer
│   ├── top.php         # Navigation bar
│   └── content.php     # MVC router
├── lib/                 # Libraries
│   ├── mypdo.php       # PDO connection
│   ├── security.lib.php # Security and authentication
│   └── myproject.lib.php # Utility functions
├── css/                 # Stylesheets
│   └── styles.css
├── js/                  # JavaScript scripts
│   └── scripts.js
├── docs/                # Generated documentation (PHPDoc)
├── vendor/              # Composer dependencies
├── index.php            # Main entry point
├── login.php            # Login page
├── main.inc.php         # Main MVC structure
├── phpdoc.xml           # PHPDoc configuration
├── composer.json        # PHP dependencies
└── README.md            # This file
```

## 🔐 Authentication

The application uses a PHP session-based authentication system. Login credentials are stored in the `mp_users` table.

**Note**: For first use, create an administrator user in the database.

## 🎨 User Interface

The application features a modern and responsive interface with:

- **Interactive Design**: Smooth animations and transitions
- **Font Awesome Icons**: For a better user experience
- **Address Autocomplete**: Uses Adresse Data Gouv API to facilitate data entry
- **Tooltips**: Contextual information on action buttons
- **Confirmation Modals**: For critical actions (deletion)

## ⚙️ Main Features

### Student Management
- Creation with automatic associated user generation
- Automatic capitalization of names and first names
- Address autocomplete with automatic city and zip code filling
- Modification and deletion

### Teacher Management
- Creation with automatic associated user generation
- Automatic capitalization of names and first names
- Address autocomplete
- Modification and deletion

### Course Management
- Course creation with association to a subject and a teacher
- Ability to create a module or subject when creating a course
- Modification and deletion

### Module Management
- Complete CRUD (Create, Read, Update, Delete)
- Coefficient assignment

### Subject Management
- Complete CRUD
- Association with a module
- Coefficient assignment

## 📚 Documentation

PHPDoc documentation is automatically generated. To generate it:

```bash
cd /srv/http/r301devweb/TD3
php /home/lazou/tools/phpdoc/phpDocumentor.phar run -v -c "./phpdoc.xml"
```

Documentation will be available in the `docs/` folder and accessible via:
```
http://localhost/r301devweb/TD3/docs/index.html
```

## 🛠️ Technologies Used

- **Backend**: PHP 8.4
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **CSS Framework**: Custom CSS (replacement of W3.CSS)
- **Libraries**:
  - Font Awesome 6.4.0 (icons)
  - Google Fonts (Quicksand)
  - vlucas/phpdotenv (environment variable management)
- **Documentation**: PHPDoc

## 📝 Configuration

### Environment Variables (.env)

The `.env` file must contain:

```env
DB_HOST=localhost      # Database host
DB_NAME=r301project    # Database name
DB_PORT=3306          # MySQL port
DB_USER=simpleuser    # MySQL user
DB_PASS=simplepass    # MySQL password
```

### Apache Configuration

For the application to work correctly, enable the `mod_rewrite` module:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Database Configuration

Tables are created with the following prefixes:
- `mp_users`: Users
- `mp_etudiants`: Students
- `mp_enseignants`: Teachers
- `mp_modules`: Modules
- `mp_matieres`: Subjects
- `mp_cours`: Courses

## 🐛 Troubleshooting

### Database Connection Error

1. Check that MySQL is running: `sudo systemctl status mysql`
2. Check the information in `.env`
3. Verify that the MySQL user has the necessary permissions

### Styles Not Applied

1. Clear browser cache (Ctrl+F5)
2. Verify that the `css/styles.css` file is accessible
3. Check CSS file permissions

### Type Errors (TypeError)

Type errors are generally due to non-casted values. All numeric fields must be explicitly cast to `int` or `float` when assigned.

## 👤 Author

**Kime Marwa**
- Date: November 2, 2025
- Version: 1.0

## 📄 License

This project is an academic work carried out as part of TD3.

## 🔄 Changelog

### Version 1.0 (November 2, 2025)
- Project initialization
- MVC architecture implementation
- Complete management of students, teachers and courses
- Modern and interactive user interface
- Complete PHPDoc documentation
- Address autocomplete with Adresse Data Gouv API
- Automatic capitalization of names and first names
