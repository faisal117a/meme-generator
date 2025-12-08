# Deployment Guide

This guide covers how to deploy the Meme Generator application to various hosting environments.

## Pre-Deployment Checklist

### 1. Verify InstantDB Setup
- Ensure your InstantDB schema is synced (see `INSTANTDB_SETUP.md`)
- Verify App ID: `2cc27c95-cf7d-4fe7-9fe4-4c56c35cda96` is correct
- Test authentication and database operations locally first

### 2. Server Requirements
- **PHP**: 7.0 or higher (7.4+ recommended)
- **PHP Extensions**: 
  - GD extension with FreeType support (required for TTF fonts)
  - File uploads enabled
- **Web Server**: Apache or Nginx
- **Storage**: Sufficient space for uploaded images (temporary storage)
- **Font File**: TTF font file (highly recommended - see Font Setup below)

### 3. PHP Configuration
Ensure these settings in `php.ini`:
```ini
upload_max_filesize = 10M
post_max_size = 10M
memory_limit = 128M
max_execution_time = 30
```

### 4. Font Setup (IMPORTANT)
**The meme generator requires a TTF font file for proper text rendering.** Without it, text will appear very small.

#### Option A: Add Font to Project (Recommended)
1. Download a free TTF font (e.g., Liberation Sans, Arial, or Roboto)
2. Save it as `arial.ttf` in your project root directory
3. Or create a `fonts/` folder and place it there as `fonts/arial.ttf`

**Recommended Fonts:**
- Liberation Sans: https://github.com/liberationfonts/liberation-fonts/releases
- Any Arial-compatible font

#### Option B: Use System Font
The script will automatically try to find system fonts on Linux/Windows/macOS, but having a font in the project is more reliable.

#### Verify Font Installation
After deployment, visit `https://yourdomain.com/check-fonts.php` to verify fonts are detected correctly. **Delete this file after verification for security.**

## Deployment Methods

### Method 1: Shared Hosting (cPanel, etc.)

#### Step 1: Prepare Files
1. Upload all project files to your hosting account via FTP/SFTP or cPanel File Manager
2. Recommended directory structure:
   ```
   public_html/
   ├── index.php
   ├── feed.php
   ├── process.php
   ├── instant.schema.js
   ├── sync-schema.html
   ├── js/
   │   ├── auth.js
   │   └── memes.js
   └── assets/
       └── (all image files)
   ```

#### Step 2: Verify PHP Settings
1. Log into cPanel
2. Go to "Select PHP Version" or "MultiPHP INI Editor"
3. Ensure PHP 7.0+ is selected
4. Verify GD extension is enabled
5. Adjust `upload_max_filesize` and `post_max_size` if needed

#### Step 3: Set Permissions
Set appropriate file permissions:
- Files: `644` (rw-r--r--)
- Directories: `755` (rwxr-xr-x)
- `assets/` folder: `755` with write permissions if needed

#### Step 4: Test Deployment
1. Visit `https://yourdomain.com/index.php`
2. Test image upload
3. Test meme generation
4. Test authentication (sign in as guest or with email)
5. Test posting to feed (`feed.php`)

### Method 2: VPS/Cloud Hosting (DigitalOcean, AWS, etc.)

#### Step 1: Server Setup

**For Ubuntu/Debian:**

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install Apache
sudo apt install apache2 -y

# Install PHP and required extensions
sudo apt install php php-gd php-mbstring php-xml -y

# Enable Apache modules
sudo a2enmod rewrite
sudo systemctl restart apache2
```

**For CentOS/RHEL:**

```bash
# Install Apache
sudo yum install httpd -y

# Install PHP and extensions
sudo yum install php php-gd php-mbstring -y

# Start services
sudo systemctl start httpd
sudo systemctl enable httpd
```

#### Step 2: Configure Apache

Create or edit virtual host configuration:

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    DocumentRoot /var/www/cursor2
    
    <Directory /var/www/cursor2>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/cursor2_error.log
    CustomLog ${APACHE_LOG_DIR}/cursor2_access.log combined
</VirtualHost>
```

Enable the site and restart Apache:
```bash
sudo a2ensite cursor2.conf
sudo systemctl restart apache2
```

#### Step 3: Deploy Files

```bash
# Clone or upload files to /var/www/cursor2
cd /var/www
sudo mkdir -p cursor2
sudo chown -R www-data:www-data cursor2

# Upload files (via git, FTP, or SCP)
# Then set permissions
sudo chmod -R 755 cursor2
sudo chmod -R 644 cursor2/*.php
```

#### Step 4: Configure PHP

Edit `/etc/php/7.4/apache2/php.ini` (adjust version as needed):
```ini
upload_max_filesize = 10M
post_max_size = 10M
memory_limit = 128M
```

Restart Apache:
```bash
sudo systemctl restart apache2
```

### Method 3: Nginx + PHP-FPM

#### Step 1: Install Nginx and PHP-FPM

```bash
sudo apt install nginx php-fpm php-gd php-mbstring -y
```

#### Step 2: Configure Nginx

Create `/etc/nginx/sites-available/cursor2`:

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/cursor2;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/cursor2 /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### Method 4: Docker Deployment

Create `Dockerfile`:

```dockerfile
FROM php:7.4-apache

# Install GD extension
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Copy application files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Configure PHP
RUN echo "upload_max_filesize = 10M" >> /usr/local/etc/php/php.ini
RUN echo "post_max_size = 10M" >> /usr/local/etc/php/php.ini

EXPOSE 80
```

Build and run:
```bash
docker build -t meme-generator .
docker run -d -p 80:80 --name meme-app meme-generator
```

## Post-Deployment Steps

### 1. Verify PHP GD Extension
Create `phpinfo.php`:
```php
<?php phpinfo(); ?>
```
Visit `yourdomain.com/phpinfo.php` and search for "gd" to verify it's enabled. **Delete this file after verification for security.**

### 2. Test All Features
- [ ] Image upload works
- [ ] Meme generation works
- [ ] Text overlay appears correctly
- [ ] Download functionality works
- [ ] Authentication (guest and email) works
- [ ] Posting to feed works
- [ ] Feed displays memes correctly
- [ ] Upvoting works

### 3. Security Hardening

#### Remove Development Files
```bash
# Remove or protect these files in production:
rm phpinfo.php  # If created for testing
# Consider password-protecting sync-schema.html
```

#### Set Proper File Permissions
```bash
# Restrict access to sensitive files
chmod 600 .gitignore
chmod 644 *.php
chmod 755 js/ assets/
```

#### Enable HTTPS
- Install SSL certificate (Let's Encrypt recommended)
- Force HTTPS redirects
- Update InstantDB settings if required

### 4. Performance Optimization

#### Enable Caching
Add to `.htaccess` (Apache):
```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

#### Enable Gzip Compression
Add to `.htaccess`:
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>
```

## Troubleshooting

### Images Not Uploading
- Check PHP `upload_max_filesize` and `post_max_size`
- Verify file permissions on upload directory
- Check Apache/Nginx error logs

### GD Extension Not Working
- Verify GD is installed: `php -m | grep gd`
- Restart web server after installing GD
- Check PHP version compatibility

### InstantDB Connection Issues
- Verify App ID is correct in `index.php` and `feed.php`
- Check browser console for JavaScript errors
- Ensure schema is synced in InstantDB dashboard
- Verify CORS settings if needed

### 500 Internal Server Error
- Check web server error logs
- Verify PHP syntax: `php -l index.php`
- Check file permissions
- Verify `.htaccess` syntax (if using Apache)

## Environment-Specific Notes

### Shared Hosting
- May have limited PHP configuration options
- Contact support to enable GD extension if not available
- Some hosts block certain PHP functions - test thoroughly

### VPS/Cloud
- Full control over server configuration
- Can optimize PHP settings for your needs
- Consider setting up automated backups

### Docker
- Easy to scale horizontally
- Consistent environment across deployments
- Can use Docker Compose for multi-container setup

## Monitoring

### Recommended Tools
- **Uptime Monitoring**: UptimeRobot, Pingdom
- **Error Tracking**: Sentry, Rollbar
- **Analytics**: Google Analytics, Plausible

### Log Files to Monitor
- Apache: `/var/log/apache2/error.log`
- Nginx: `/var/log/nginx/error.log`
- PHP: Check `php.ini` for `error_log` location

## Backup Strategy

### Files to Backup
- All PHP files
- `assets/` folder
- `js/` folder
- Configuration files

### Database Backup
- InstantDB data is managed by InstantDB
- Export data via InstantDB dashboard if needed
- Consider regular exports for critical data

## Support

If you encounter issues:
1. Check error logs
2. Verify all requirements are met
3. Test locally first
4. Check InstantDB dashboard for database issues
5. Review browser console for JavaScript errors

---

**Note**: This application uses InstantDB which is a cloud service. No database server setup is required, but ensure your InstantDB account and schema are properly configured before deployment.

