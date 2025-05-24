# Task-4-Secure-App
# Secure Web Application

A secure PHP web application with user authentication, role-based access control, form validation, and prepared statements.

## Features
- **Security**:
  - PDO prepared statements to prevent SQL injection
  - CSRF protection with token validation
  - Input sanitization and validation (client and server-side)
  - Password hashing with bcrypt
  - Role-based access control (admin, editor, user)
- **UI/UX**:
  - Responsive design with Tailwind CSS
  - Client-side validation with jQuery
  - Clean and intuitive interface with sidebar navigation
  - Font Awesome icons for enhanced visuals
- **Functionality**:
  - User registration and login
  - Post creation (for admins and editors)
  - Admin panel for user management
  - Secure session management

## Setup Instructions
1. **Prerequisites**:
   - XAMPP with PHP 7.4+ and MySQL
   - Composer (optional for future enhancements)
2. **Database Setup**:
   - Import `sql/database.sql` into MySQL via phpMyAdmin
   - Update `includes/config.php` with your database credentials
3. **Project Setup**:
   - Place the project in `C:\xampp\htdocs\Internship-Tasks-for-Web-Development-PHP-MySQL\Task-4`
   - Ensure Apache and MySQL are running in XAMPP
4. **Access**:
   - Open `http://localhost/Internship-Tasks-for-Web-Development-PHP-MySQL/Task-4/` in your browser
   - Register a new user or create an admin account manually in the database with `role = 'admin'`

## Security Measures
- **SQL Injection**: Prevented using PDO prepared statements with disabled emulated prepares
- **XSS**: Mitigated with htmlspecialchars and strip_tags
- **CSRF**: Protected with token-based validation
- **Session Security**: Secure session management with proper logout
- **Access Control**: Role-based permissions for admin, editor, and user roles

## Dependencies
- Tailwind CSS (CDN)
- jQuery (CDN)
- Font Awesome (CDN)

## Future Enhancements
- Add two-factor authentication
- Implement rate limiting
- Add password strength validation
- Include security headers (CSP, X-Frame-Options, etc.)
- Add logging for security events

## Maintenance
- Regularly update dependencies
- Monitor for security vulnerabilities
- Backup database regularly
