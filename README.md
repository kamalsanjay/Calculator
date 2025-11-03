# Calculator Website - 300+ Free Online Calculators

A professional, full-featured calculator website with 300+ tools across 14 categories. Built with PHP, MySQL, and modern web technologies.

## 🚀 Features

- **300+ Calculators** across 14 categories
- **Responsive Design** - Works on all devices
- **SEO Optimized** - Meta tags, Schema.org, Sitemap
- **User Authentication** - Registration, Login, Profile
- **Admin Panel** - Complete dashboard with analytics
- **Email System** - SMTP integration with templates
- **API Support** - RESTful API endpoints
- **Security** - CSRF protection, XSS prevention, Rate limiting
- **Dark Mode** - Theme switcher
- **Search** - Live search with autocomplete
- **Analytics** - Google Analytics integration
- **AdSense** - Monetization ready

## 📋 Categories

1. 💰 Financial (58 calculators)
2. 🏥 Health & Fitness (40 calculators)
3. 🔢 Math (42 calculators)
4. 🔄 Conversion (40 calculators)
5. 📅 Date & Time (16 calculators)
6. 🏗️ Construction (18 calculators)
7. ⚡ Electronics (12 calculators)
8. 🚗 Automotive (11 calculators)
9. 🎓 Education (10 calculators)
10. 🛠️ Utility (15 calculators)
11. 🌤️ Weather (9 calculators)
12. 🍳 Cooking (9 calculators)
13. 🎮 Gaming (8 calculators)
14. ⚽ Sports (8 calculators)

## 🛠️ Tech Stack

- **Backend**: PHP 8.0+
- **Database**: MySQL 8.0+ / MariaDB 10.5+
- **Frontend**: HTML5, CSS3, JavaScript ES6+
- **Styling**: Bootstrap 5 / Tailwind CSS
- **Charts**: Chart.js 4.0+
- **Icons**: Font Awesome 6
- **Fonts**: Google Fonts (Inter, Roboto)

## 📦 Installation

### Prerequisites

- PHP 8.0 or higher
- MySQL 8.0 or MariaDB 10.5
- Apache/Nginx web server
- Composer (optional)
- Node.js (optional, for build tools)

### Step 1: Clone Repository
```bash
git clone https://github.com/yourusername/calculator.git
cd calculator
```

### Step 2: Configure Environment
```bash
cp .env.example .env
```

Edit `.env` file with your configuration:
- Database credentials
- Email SMTP settings
- API keys
- Security keys

### Step 3: Create Database
```bash
mysql -u root -p
CREATE DATABASE calculator_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 4: Import Database Schema
```bash
mysql -u root -p calculator_db < database/schema.sql
mysql -u root -p calculator_db < database/seeds.sql
```

### Step 5: Set Permissions
```bash
chmod 755 cache logs uploads backup
chmod 644 .env
```

### Step 6: Configure Web Server

**Apache**: Already configured via `.htaccess`

**Nginx**: Add this to your server block:
```nginx
location / {
    try_files $uri $uri/ $uri.php?$query_string;
}

location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
    fastcgi_index index.php;
    include fastcgi_params;
}
```

### Step 7: Install Dependencies (Optional)
```bash
composer install
npm install
```

## 🔐 Default Admin Credentials
```
Email: admin@calculator.com
Password: Admin@123
```

**⚠️ Change these immediately after first login!**

## 📁 Folder Structure
```
calculator/
├── assets/          # CSS, JS, Images
├── auth/            # Authentication pages
├── calculators/     # All calculator files (296 files)
├── config/          # Configuration files
├── core/            # Core classes
├── includes/        # PHP includes
├── admin/           # Admin panel
├── api/             # API endpoints
├── database/        # SQL files
├── logs/            # Log files
├── uploads/         # User uploads
└── cache/           # Cache files
```

## 🚀 Usage

### Access Website
```
http://localhost/
```

### Access Admin Panel
```
http://localhost/admin/
```

### API Documentation
```
http://localhost/api/documentation/
```

## 🔧 Configuration

### Database (`config/database.php`)
Configure database connection settings

### Email (`config/mail.php`)
Configure SMTP settings for email

### Security (`config/security.php`)
Configure security settings, rate limiting

### SEO (`config/seo.php`)
Configure default meta tags

### Ads (`config/ads.php`)
Configure Google AdSense

## 📊 Features

### User Features
- Calculator usage without login
- Save calculations (requires login)
- User profile management
- Calculation history
- Share results

### Admin Features
- Dashboard with analytics
- User management
- Calculator management
- Ad performance tracking
- Email template editor
- Backup & restore
- Security logs

## 🔒 Security

- Password hashing (bcrypt)
- CSRF protection
- XSS prevention
- SQL injection prevention
- Rate limiting
- Session security
- Input validation
- File upload restrictions
- HTTPS enforcement

## 📈 SEO Features

- Dynamic meta tags
- Schema.org markup
- XML sitemap (auto-generated)
- Robots.txt
- Open Graph tags
- Twitter Cards
- Breadcrumb navigation
- Clean URLs
- Mobile-friendly

## 🎨 Customization

### Colors (`assets/css/style.css`)
```css
--primary-color: #007bff;
--secondary-color: #6c757d;
```

### Logo
Replace `assets/images/logo.png`

### Favicon
Replace `assets/images/favicon.ico`

## 🧪 Testing
```bash
php tests/run-tests.php
```

## 📝 License

MIT License - See LICENSE file

## 👥 Support

- Email: support@calculator.com
- Documentation: https://docs.calculator.com
- Issues: https://github.com/yourusername/calculator/issues

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/NewCalculator`)
3. Commit changes (`git commit -m 'Add new calculator'`)
4. Push to branch (`git push origin feature/NewCalculator`)
5. Open Pull Request

## 📅 Changelog

### Version 1.0.0 (2025-01-01)
- Initial release
- 296 calculators across 14 categories
- User authentication system
- Admin panel
- API endpoints
- SEO optimization

## 🙏 Credits

- Bootstrap 5
- Font Awesome
- Chart.js
- Google Fonts

---

**Made with ❤️ by Calculator Team**
