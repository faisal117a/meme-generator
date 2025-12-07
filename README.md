# 🎭 Meme Generator

A simple and elegant PHP-based meme generator that allows users to upload images, add customizable text overlays, and download their creations.

## ✨ Features

- **Image Upload**: Support for JPG, PNG, and GIF formats
- **Text Overlay**: Add text to the top and/or bottom of images
- **Customizable Font Size**: Adjustable font size slider (20-100px)
- **Styled Text**: White text with black border for better visibility
- **Live Preview**: See your image and meme in real-time
- **Download**: Download your generated meme as PNG
- **Responsive Design**: Works on desktop and mobile devices
- **Modern UI**: Beautiful gradient design with smooth animations

## 🚀 Requirements

- PHP 7.0 or higher
- PHP GD extension (usually enabled by default in XAMPP)
- Web server (Apache/Nginx) or XAMPP/WAMP/MAMP
- Modern web browser

## 📦 Installation

1. **Clone or download this repository** to your web server directory:
   - For XAMPP: `C:\xampp\htdocs\cursor2\`
   - For WAMP: `C:\wamp64\www\cursor2\`
   - For MAMP: `/Applications/MAMP/htdocs/cursor2/`

2. **Ensure PHP GD extension is enabled**:
   - In XAMPP, it's usually enabled by default
   - Check `phpinfo()` if unsure

3. **Optional: Add TTF Font (for better text quality)**:
   - Download a free font (e.g., Arial, Roboto, or any TTF font)
   - Save it as `arial.ttf` in the project root directory
   - The application will automatically use it if available

## 🎯 Usage

1. **Start your web server** (if using XAMPP, start Apache)

2. **Open your browser** and navigate to:
   ```
   http://localhost/cursor2/index.php
   ```

3. **Create your meme**:
   - Click the upload area to select an image
   - Enter your top text (optional)
   - Enter your bottom text (optional)
   - Adjust the font size using the slider
   - Click "Generate Meme"

4. **Download your meme**:
   - Once generated, click the "Download Meme" button
   - The meme will be saved as a PNG file

## 📁 Project Structure

```
cursor2/
│
├── index.php          # Main interface (HTML, CSS, JavaScript)
├── process.php        # Backend image processing (PHP)
├── README.md          # Project documentation
└── arial.ttf          # Optional TTF font file (not included)
```

## 🔧 How It Works

### Frontend (`index.php`)
- Provides a user-friendly interface for uploading images and entering text
- Uses JavaScript to preview uploaded images
- Sends form data to `process.php` via AJAX
- Displays the generated meme and provides download functionality

### Backend (`process.php`)
- Receives the uploaded image and form data
- Validates the image format (JPG, PNG, GIF)
- Loads the image using PHP GD library
- Calculates text positions (centered horizontally)
- Renders text with white color and black border
- Outputs the final meme as PNG

## 🎨 Text Styling

- **Color**: White text
- **Border**: Black border (2px thickness) for visibility
- **Position**: 
  - Top text: Centered, near the top with padding
  - Bottom text: Centered, near the bottom with padding
- **Font**: Uses TTF font if available, otherwise falls back to built-in fonts

## 🌐 Browser Compatibility

- Chrome (recommended)
- Firefox
- Safari
- Edge
- Opera

## 📝 Notes

- Maximum file size is determined by your PHP `upload_max_filesize` setting
- The generated meme is output directly to the browser (not saved on the server)
- For best results, use images with good contrast
- TTF fonts provide better quality and sizing than built-in fonts

## 🐛 Troubleshooting

### Image not uploading?
- Check PHP `upload_max_filesize` and `post_max_size` in `php.ini`
- Ensure the `tmp` directory has write permissions

### Text not appearing?
- Verify PHP GD extension is enabled
- Check browser console for JavaScript errors
- Ensure image format is supported (JPG, PNG, GIF)

### Poor text quality?
- Add a TTF font file (`arial.ttf`) to improve text rendering
- Increase font size for better visibility

## 🔒 Security Considerations

- This is a basic implementation for local/development use
- For production, consider:
  - File type validation (beyond MIME type)
  - File size limits
  - Sanitizing user input
  - Rate limiting
  - Secure file upload handling

## 📄 License

This project is open source and available for personal and educational use.

## 🤝 Contributing

Feel free to fork this project and submit pull requests for improvements!

## 📧 Support

For issues or questions, please check the troubleshooting section or review the code comments.

---

**Enjoy creating memes! 🎉**

