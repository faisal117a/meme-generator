# Font Setup Guide - Fix Small Text Issue

## Problem
If text appears very small in generated memes on your server, it's because **no TTF font file was found**. PHP GD falls back to a small built-in font when no TTF font is available.

## Quick Fix

### Step 1: Check Current Font Status
Visit: `https://yourdomain.com/check-fonts.php`

This will show you:
- Which fonts are available on your server
- Where to place a font file
- Whether PHP GD supports TTF fonts

**⚠️ Delete `check-fonts.php` after checking for security reasons.**

### Step 2: Add a Font File

**Option A: Download and Upload a Font (Easiest)**

1. Download Liberation Sans (free, open-source):
   - Direct link: https://github.com/liberationfonts/liberation-fonts/releases
   - Download `liberation-fonts-ttf-*.tar.gz`
   - Extract and find `LiberationSans-Regular.ttf`

2. Rename it to `arial.ttf`

3. Upload to your project root directory (same folder as `index.php`)

**Option B: Use System Font**
If your server already has fonts installed, the script will try to find them automatically. However, adding a font to your project is more reliable.

### Step 3: Verify
1. Visit `check-fonts.php` again
2. You should see: ✅ **Project root** font found
3. Test generating a meme - text should now be the correct size!

## Common Font Locations on Linux

The script checks these locations automatically:
- `/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf`
- `/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf`
- `/usr/share/fonts/TTF/DejaVuSans.ttf`

## Troubleshooting

### Still seeing small text?

1. **Check PHP GD Extension:**
   ```php
   <?php phpinfo(); ?>
   ```
   Look for "GD" section and verify "FreeType Support" is enabled.

2. **Check File Permissions:**
   ```bash
   chmod 644 arial.ttf
   ```

3. **Verify Font File:**
   - File should be a valid TTF file
   - Size should be > 10 KB
   - File should be readable by web server user

4. **Check Error Logs:**
   Look in your server's error log for any font-related errors.

### Font Not Found on Server?

If your server doesn't have any fonts and you can't upload one:
1. Contact your hosting provider to install fonts
2. Or use a VPS where you have full control
3. The built-in font fallback will work but text will be small

## Technical Details

- **With TTF Font:** Text size is fully customizable (12-150px)
- **Without TTF Font:** PHP uses built-in font size 5 (very small, ~13px equivalent)

The code automatically tries multiple font paths, but having a font in your project root (`arial.ttf`) is the most reliable solution.

