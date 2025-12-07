<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meme Generator</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #ff6b35;
            --primary-dark: #e55a2b;
            --primary-light: #ff8c66;
            --secondary: #f7931e;
            --accent: #ffd23f;
            --bg-gradient-start: #ff9a56;
            --bg-gradient-end: #ff6a88;
            --text-primary: #1a1a1a;
            --text-secondary: #666;
            --text-light: #999;
            --border: #e0e0e0;
            --border-focus: #ff6b35;
            --bg-card: #ffffff;
            --bg-section: #fafafa;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.16);
            --radius: 12px;
            --radius-lg: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
            min-height: 100vh;
            padding: 24px;
            color: var(--text-primary);
            line-height: 1.6;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 48px;
            box-shadow: var(--shadow-lg);
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .header {
            text-align: center;
            margin-bottom: 48px;
        }

        h1 {
            font-size: 3rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 12px;
            letter-spacing: -0.02em;
        }

        .subtitle {
            font-size: 1.125rem;
            color: var(--text-secondary);
            font-weight: 400;
        }
        
        .meme-generator {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
        }
        
        .upload-section, .preview-section {
            background: var(--bg-section);
            padding: 32px;
            border-radius: var(--radius);
            border: 1px solid var(--border);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }
        
        h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }
        
        .file-upload {
            border: 2px dashed var(--border);
            border-radius: var(--radius);
            padding: 48px 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: white;
            position: relative;
            overflow: hidden;
        }

        .file-upload::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 107, 53, 0.1), transparent);
            transition: left 0.5s;
        }

        .file-upload:hover::before {
            left: 100%;
        }
        
        .file-upload:hover {
            background: #fff5f2;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .file-upload.dragover {
            background: #fff5f2;
            border-color: var(--primary);
            border-style: solid;
        }
        
        .file-upload input[type="file"] {
            display: none;
        }
        
        .file-upload-label {
            display: block;
            cursor: pointer;
            color: var(--text-primary);
            font-size: 1rem;
            font-weight: 500;
        }

        .file-upload-icon {
            font-size: 3rem;
            margin-bottom: 16px;
            display: block;
        }

        .file-upload-text {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .file-upload-hint {
            font-size: 0.875rem;
            color: var(--text-light);
        }
        
        .text-inputs {
            margin-top: 32px;
        }
        
        .text-input-group, .slider-group, .color-group {
            margin-bottom: 24px;
        }
        
        .text-input-group label, .slider-group label, .color-group label {
            display: block;
            margin-bottom: 10px;
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.9375rem;
            letter-spacing: -0.01em;
        }
        
        .text-input-group input[type="text"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.2s;
            background: white;
            color: var(--text-primary);
        }
        
        .text-input-group input[type="text"]:focus {
            outline: none;
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .text-input-group input[type="text"]::placeholder {
            color: var(--text-light);
        }
        
        .slider-container {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .slider-container input[type="range"] {
            flex: 1;
            height: 6px;
            border-radius: 3px;
            background: var(--border);
            outline: none;
            -webkit-appearance: none;
            appearance: none;
        }

        .slider-container input[type="range"]::-webkit-slider-thumb {
            appearance: none;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(255, 107, 53, 0.3);
            transition: all 0.2s;
        }

        .slider-container input[type="range"]::-webkit-slider-thumb:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.4);
        }

        .slider-container input[type="range"]::-moz-range-thumb {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            cursor: pointer;
            border: none;
            box-shadow: 0 2px 8px rgba(255, 107, 53, 0.3);
        }
        
        .slider-value {
            min-width: 60px;
            text-align: center;
            font-weight: 700;
            color: var(--primary);
            font-size: 1.125rem;
            background: #fff5f2;
            padding: 6px 12px;
            border-radius: 6px;
        }
        
        .color-picker-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .color-picker-container input[type="color"] {
            width: 70px;
            height: 48px;
            border: 2px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .color-picker-container input[type="color"]:hover {
            border-color: var(--border-focus);
            transform: scale(1.05);
        }
        
        .color-picker-container input[type="text"] {
            flex: 1;
            padding: 14px 16px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 0.9375rem;
            font-family: 'Courier New', monospace;
            transition: all 0.2s;
            background: white;
        }

        .color-picker-container input[type="text"]:focus {
            outline: none;
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }
        
        .preview-container {
            position: relative;
            display: none;
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        
        .preview-container.show {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }
        
        .preview-image {
            max-width: 100%;
            display: block;
        }
        
        #previewCanvas {
            max-width: 100%;
            cursor: move;
            display: none;
        }
        
        #previewCanvas.show {
            display: block;
        }
        
        .generate-btn {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.125rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 32px;
            font-family: inherit;
            letter-spacing: -0.01em;
            box-shadow: 0 4px 16px rgba(255, 107, 53, 0.3);
        }
        
        .generate-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(255, 107, 53, 0.4);
        }
        
        .generate-btn:active {
            transform: translateY(0);
        }

        .generate-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .download-btn {
            width: 100%;
            padding: 16px 24px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.125rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 16px;
            display: none;
            text-decoration: none;
            text-align: center;
            font-family: inherit;
            letter-spacing: -0.01em;
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
        }
        
        .download-btn.show {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }
        
        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(16, 185, 129, 0.4);
            background: #059669;
        }

        .empty-state {
            text-align: center;
            padding: 64px 24px;
            color: var(--text-light);
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state-text {
            font-size: 1rem;
            font-weight: 500;
        }
        
        .template-section {
            margin-bottom: 32px;
        }
        
        .template-header {
            margin-bottom: 20px;
        }
        
        .template-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        
        .template-subtitle {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin: 0;
        }
        
        .template-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 12px;
            margin-bottom: 24px;
        }
        
        .template-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid var(--border);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: white;
        }
        
        .template-item:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary);
        }
        
        .template-item.selected {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.2);
        }
        
        .template-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        
        .template-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            color: white;
            padding: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            text-align: center;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .template-item:hover .template-overlay {
            opacity: 1;
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 24px 0;
            color: var(--text-light);
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border);
        }
        
        .divider span {
            padding: 0 16px;
        }
        
        @media (max-width: 1024px) {
            .container {
                padding: 32px;
            }

            h1 {
                font-size: 2.5rem;
            }

            .meme-generator {
                gap: 24px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 16px;
            }

            .container {
                padding: 24px;
            }

            h1 {
                font-size: 2rem;
            }

            .meme-generator {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .upload-section, .preview-section {
                padding: 24px;
            }
            
            .template-grid {
                grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
                gap: 10px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.75rem;
            }

            .subtitle {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Meme Generator</h1>
            <p class="subtitle">Create hilarious memes in seconds</p>
        </div>
        
        <form id="memeForm" method="POST" action="process.php" enctype="multipart/form-data">
            <div class="meme-generator">
                <div class="upload-section">
                    <div class="section-header">
                        <div class="section-icon">📤</div>
                        <h2>Upload & Customize</h2>
                    </div>
                    
                    <div class="template-section">
                        <div class="template-header">
                            <h3>Choose a Template</h3>
                            <p class="template-subtitle">Select from our templates or upload your own</p>
                        </div>
                        <div class="template-grid" id="templateGrid">
                            <?php
                            $assetsDir = __DIR__ . '/assets';
                            $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];
                            if (is_dir($assetsDir)) {
                                $files = scandir($assetsDir);
                                foreach ($files as $file) {
                                    if ($file === '.' || $file === '..') continue;
                                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                    if (in_array($ext, $allowedExtensions)) {
                                        $imagePath = 'assets/' . htmlspecialchars($file);
                                        echo '<div class="template-item" data-template="' . htmlspecialchars($imagePath) . '">';
                                        echo '<img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($file) . '">';
                                        echo '<div class="template-overlay">Select</div>';
                                        echo '</div>';
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                    
                    <div class="divider">
                        <span>OR</span>
                    </div>
                    
                    <div class="file-upload" id="fileUpload">
                        <label for="imageUpload" class="file-upload-label">
                            <span class="file-upload-icon">📁</span>
                            <span class="file-upload-text">Click to select an image</span>
                            <span class="file-upload-hint">JPG, PNG, or GIF</span>
                        </label>
                        <input type="file" id="imageUpload" name="image" accept="image/*">
                    </div>
                    <input type="hidden" id="selectedTemplate" name="template">
                    
                    <div class="text-inputs">
                        <div class="text-input-group">
                            <label for="topText">Top Text</label>
                            <input type="text" id="topText" name="topText" placeholder="Enter top text...">
                        </div>
                        
                        <div class="text-input-group">
                            <label for="bottomText">Bottom Text</label>
                            <input type="text" id="bottomText" name="bottomText" placeholder="Enter bottom text...">
                        </div>
                        
                        <div class="slider-group">
                            <label for="fontSize">Font Size: <span class="slider-value" id="fontSizeValue">40</span>px</label>
                            <div class="slider-container">
                                <input type="range" id="fontSize" name="fontSize" min="20" max="100" value="40">
                            </div>
                        </div>
                        
                        <div class="color-group">
                            <label for="textColor">Text Color</label>
                            <div class="color-picker-container">
                                <input type="color" id="textColor" name="textColor" value="#ffffff">
                                <input type="text" id="textColorHex" value="#ffffff" placeholder="#ffffff">
                            </div>
                        </div>
                        
                        <div class="color-group">
                            <label for="borderColor">Border Color</label>
                            <div class="color-picker-container">
                                <input type="color" id="borderColor" name="borderColor" value="#000000">
                                <input type="text" id="borderColorHex" value="#000000" placeholder="#000000">
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="generate-btn" id="generateBtn">Generate Meme</button>
                </div>
                
                <div class="preview-section">
                    <div class="section-header">
                        <div class="section-icon">👁️</div>
                        <h2>Preview</h2>
                    </div>
                    <div class="preview-container" id="previewContainer">
                        <div class="empty-state" id="emptyState">
                            <div class="empty-state-icon">🖼️</div>
                            <div class="empty-state-text">Upload an image to see preview</div>
                        </div>
                        <img id="previewImage" class="preview-image" alt="Preview" style="display: none;">
                        <canvas id="previewCanvas"></canvas>
                    </div>
                    <a id="downloadBtn" class="download-btn" download="meme.png">Download Meme</a>
                </div>
            </div>
        </form>
    </div>
    
    <script>
        const imageUpload = document.getElementById('imageUpload');
        const fileUpload = document.getElementById('fileUpload');
        const previewImage = document.getElementById('previewImage');
        const previewCanvas = document.getElementById('previewCanvas');
        const previewContainer = document.getElementById('previewContainer');
        const emptyState = document.getElementById('emptyState');
        const fontSizeSlider = document.getElementById('fontSize');
        const fontSizeValue = document.getElementById('fontSizeValue');
        const memeForm = document.getElementById('memeForm');
        const downloadBtn = document.getElementById('downloadBtn');
        const generateBtn = document.getElementById('generateBtn');
        const topTextInput = document.getElementById('topText');
        const bottomTextInput = document.getElementById('bottomText');
        const textColorPicker = document.getElementById('textColor');
        const textColorHex = document.getElementById('textColorHex');
        const borderColorPicker = document.getElementById('borderColor');
        const borderColorHex = document.getElementById('borderColorHex');
        const selectedTemplate = document.getElementById('selectedTemplate');
        const templateItems = document.querySelectorAll('.template-item');
        
        let currentImage = null;
        let imageScale = 1;
        let textPositions = {
            top: { x: 0, y: 0 },
            bottom: { x: 0, y: 0 }
        };
        let isDragging = false;
        let dragTarget = null;
        let dragOffset = { x: 0, y: 0 };
        let textColor = textColorPicker.value;
        let borderColor = borderColorPicker.value;
        let currentTemplate = null;
        
        // Initialize color hex inputs
        textColorHex.value = textColor;
        borderColorHex.value = borderColor;
        
        // Template selection
        templateItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove selected class from all items
                templateItems.forEach(t => t.classList.remove('selected'));
                // Add selected class to clicked item
                this.classList.add('selected');
                
                const templatePath = this.getAttribute('data-template');
                currentTemplate = templatePath;
                selectedTemplate.value = templatePath;
                
                // Clear file upload
                imageUpload.value = '';
                const label = fileUpload.querySelector('.file-upload-label');
                label.innerHTML = `
                    <span class="file-upload-icon">📁</span>
                    <span class="file-upload-text">Click to select an image</span>
                    <span class="file-upload-hint">JPG, PNG, or GIF</span>
                `;
                
                // Load template image
                loadTemplateImage(templatePath);
            });
        });
        
        function loadTemplateImage(path) {
            const img = new Image();
            img.onload = function() {
                currentImage = img;
                imageScale = Math.min(600 / img.width, 600 / img.height);
                
                previewCanvas.width = img.width;
                previewCanvas.height = img.height;
                previewCanvas.style.width = (img.width * imageScale) + 'px';
                previewCanvas.style.height = (img.height * imageScale) + 'px';
                
                const ctx = previewCanvas.getContext('2d');
                ctx.drawImage(img, 0, 0);
                
                previewImage.style.display = 'none';
                previewCanvas.classList.add('show');
                emptyState.style.display = 'none';
                previewContainer.classList.add('show');
                
                // Initialize text positions
                initializeTextPositions();
                drawTexts();
            };
            img.onerror = function() {
                alert('Error loading template image. Please try another template.');
            };
            img.src = path;
        }
        
        // Drag and drop support
        fileUpload.addEventListener('dragover', function(e) {
            e.preventDefault();
            fileUpload.classList.add('dragover');
        });

        fileUpload.addEventListener('dragleave', function(e) {
            e.preventDefault();
            fileUpload.classList.remove('dragover');
        });

        fileUpload.addEventListener('drop', function(e) {
            e.preventDefault();
            fileUpload.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0 && files[0].type.startsWith('image/')) {
                imageUpload.files = files;
                handleImageUpload(files[0]);
            }
        });
        
        // Preview uploaded image
        imageUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Clear template selection
                templateItems.forEach(t => t.classList.remove('selected'));
                currentTemplate = null;
                selectedTemplate.value = '';
                handleImageUpload(file);
            }
        });

        function handleImageUpload(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    currentImage = img;
                    imageScale = Math.min(600 / img.width, 600 / img.height);
                    
                    previewCanvas.width = img.width;
                    previewCanvas.height = img.height;
                    previewCanvas.style.width = (img.width * imageScale) + 'px';
                    previewCanvas.style.height = (img.height * imageScale) + 'px';
                    
                    const ctx = previewCanvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'none';
                    previewCanvas.classList.add('show');
                    emptyState.style.display = 'none';
                    previewContainer.classList.add('show');
                    
                    // Update file upload label
                    const label = fileUpload.querySelector('.file-upload-label');
                    label.innerHTML = `
                        <span class="file-upload-icon">✓</span>
                        <span class="file-upload-text">${file.name}</span>
                        <span class="file-upload-hint">Click to change image</span>
                    `;
                    
                    // Initialize text positions
                    initializeTextPositions();
                    drawTexts();
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
        
        // Wrap text into multiple lines based on canvas width
        // This must match PHP's wrapping logic exactly
        function wrapText(ctx, text, maxWidth, fontSize) {
            if (!text || text.trim() === '') return [];
            
            // Ensure font is set before measuring
            const originalFont = ctx.font;
            ctx.font = `bold ${fontSize}px Arial`;
            
            const words = text.split(' ');
            const lines = [];
            let currentLine = '';
            
            for (let i = 0; i < words.length; i++) {
                const word = words[i];
                if (word === '') continue;
                
                const testLine = currentLine === '' ? word : currentLine + ' ' + word;
                const metrics = ctx.measureText(testLine);
                
                if (metrics.width > maxWidth && currentLine !== '') {
                    lines.push(currentLine);
                    currentLine = word;
                } else {
                    currentLine = testLine;
                }
            }
            
            if (currentLine !== '') {
                lines.push(currentLine);
            }
            
            // Restore original font
            ctx.font = originalFont;
            
            return lines.length > 0 ? lines : [text];
        }
        
        // Initialize text positions (centered)
        // Ensures positions are within canvas bounds
        function initializeTextPositions() {
            if (!currentImage) return;
            
            const ctx = previewCanvas.getContext('2d');
            const fontSize = parseInt(fontSizeSlider.value);
            ctx.font = `bold ${fontSize}px Arial`;
            
            const padding = 40;
            const maxWidth = currentImage.width - (padding * 2) - 10;
            
            // Top text position
            if (topTextInput.value) {
                const lines = wrapText(ctx, topTextInput.value, maxWidth, fontSize);
                let maxLineWidth = 0;
                lines.forEach(line => {
                    ctx.font = `bold ${fontSize}px Arial`;
                    const metrics = ctx.measureText(line);
                    if (metrics.width > maxLineWidth) {
                        maxLineWidth = metrics.width;
                    }
                });
                
                // Center horizontally, but ensure it stays within bounds
                let x = (currentImage.width - maxLineWidth) / 2;
                x = Math.max(padding, Math.min(x, currentImage.width - maxLineWidth - padding));
                
                // Ensure top position is within bounds
                let y = 50;
                y = Math.max(padding, Math.min(y, currentImage.height - padding));
                
                textPositions.top.x = x;
                textPositions.top.y = y;
            }
            
            // Bottom text position
            if (bottomTextInput.value) {
                const lines = wrapText(ctx, bottomTextInput.value, maxWidth, fontSize);
                let maxLineWidth = 0;
                lines.forEach(line => {
                    ctx.font = `bold ${fontSize}px Arial`;
                    const metrics = ctx.measureText(line);
                    if (metrics.width > maxLineWidth) {
                        maxLineWidth = metrics.width;
                    }
                });
                
                // Center horizontally, but ensure it stays within bounds
                let x = (currentImage.width - maxLineWidth) / 2;
                x = Math.max(padding, Math.min(x, currentImage.width - maxLineWidth - padding));
                
                const lineHeight = fontSize * 1.2;
                const totalHeight = lines.length * lineHeight;
                
                // Position near bottom, but ensure it stays within bounds
                let y = currentImage.height - totalHeight - 50;
                y = Math.max(padding, Math.min(y, currentImage.height - totalHeight - padding));
                
                textPositions.bottom.x = x;
                textPositions.bottom.y = y;
            }
        }
        
        // Draw texts on canvas
        function drawTexts() {
            if (!currentImage) return;
            
            const ctx = previewCanvas.getContext('2d');
            // Clear and redraw image
            ctx.clearRect(0, 0, previewCanvas.width, previewCanvas.height);
            ctx.drawImage(currentImage, 0, 0);
            
            const fontSize = parseInt(fontSizeSlider.value);
            ctx.font = `bold ${fontSize}px Arial`;
            ctx.textAlign = 'left';
            ctx.textBaseline = 'top';
            
            // Draw top text (with wrapping)
            if (topTextInput.value && topTextInput.value.trim()) {
                drawTextWithBorder(ctx, topTextInput.value, textPositions.top.x, textPositions.top.y, fontSize);
            }
            
            // Draw bottom text (with wrapping)
            if (bottomTextInput.value && bottomTextInput.value.trim()) {
                drawTextWithBorder(ctx, bottomTextInput.value, textPositions.bottom.x, textPositions.bottom.y, fontSize);
            }
        }
        
        // Draw text with custom color and border (supports multi-line)
        // Ensures text NEVER goes outside canvas bounds
        function drawTextWithBorder(ctx, text, x, y, fontSize) {
            if (!currentImage || !text) return;
            
            const padding = 40;
            const maxWidth = currentImage.width - (padding * 2) - 10;
            const maxHeight = currentImage.height - (padding * 2);
            
            ctx.font = `bold ${fontSize}px Arial`;
            ctx.lineWidth = 4;
            ctx.lineJoin = 'round';
            ctx.miterLimit = 2;
            ctx.textAlign = 'left';
            ctx.textBaseline = 'top';
            
            let lines = wrapText(ctx, text, maxWidth, fontSize);
            if (!lines || lines.length === 0) return;
            
            let lineHeight = fontSize * 1.2;
            let totalHeight = lines.length * lineHeight;
            let currentFontSize = fontSize;
            
            // Reduce font size if text height exceeds canvas height
            while (totalHeight > maxHeight && currentFontSize > 12) {
                currentFontSize -= 2;
                ctx.font = `bold ${currentFontSize}px Arial`;
                lines = wrapText(ctx, text, maxWidth, currentFontSize);
                lineHeight = currentFontSize * 1.2;
                totalHeight = lines.length * lineHeight;
            }
            
            // Ensure text doesn't exceed canvas boundaries
            lines.forEach((line, index) => {
                if (!line) return;
                
                const lineY = y + (index * lineHeight);
                
                // Skip if line would be outside canvas vertically
                if (lineY < 0 || lineY + currentFontSize > currentImage.height) return;
                
                ctx.font = `bold ${currentFontSize}px Arial`;
                const metrics = ctx.measureText(line);
                const lineWidth = metrics.width;
                
                // Adjust x position if text would go outside canvas horizontally
                let adjustedX = x;
                if (adjustedX < padding) adjustedX = padding;
                if (adjustedX + lineWidth > currentImage.width - padding) {
                    adjustedX = currentImage.width - padding - lineWidth;
                }
                if (adjustedX < padding) adjustedX = padding; // Ensure minimum padding
                
                // Draw border
                ctx.strokeStyle = borderColor;
                ctx.strokeText(line, adjustedX, lineY);
                
                // Draw text
                ctx.fillStyle = textColor;
                ctx.fillText(line, adjustedX, lineY);
            });
        }
        
        // Sync color picker with hex input
        textColorPicker.addEventListener('input', function() {
            textColorHex.value = this.value;
            textColor = this.value;
            if (currentImage) {
                drawTexts();
            }
        });
        
        textColorHex.addEventListener('input', function() {
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                textColorPicker.value = this.value;
                textColor = this.value;
                if (currentImage) {
                    drawTexts();
                }
            }
        });
        
        borderColorPicker.addEventListener('input', function() {
            borderColorHex.value = this.value;
            borderColor = this.value;
            if (currentImage) {
                drawTexts();
            }
        });
        
        borderColorHex.addEventListener('input', function() {
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                borderColorPicker.value = this.value;
                borderColor = this.value;
                if (currentImage) {
                    drawTexts();
                }
            }
        });
        
        // Update font size display and redraw
        fontSizeSlider.addEventListener('input', function() {
            fontSizeValue.textContent = this.value;
            if (currentImage) {
                initializeTextPositions();
                drawTexts();
            }
        });
        
        // Update text when input changes
        topTextInput.addEventListener('input', function() {
            if (currentImage) {
                initializeTextPositions();
                drawTexts();
            }
        });
        
        bottomTextInput.addEventListener('input', function() {
            if (currentImage) {
                initializeTextPositions();
                drawTexts();
            }
        });
        
        // Mouse events for dragging
        previewCanvas.addEventListener('mousedown', function(e) {
            if (!currentImage) return;
            
            const rect = previewCanvas.getBoundingClientRect();
            const x = (e.clientX - rect.left) / imageScale;
            const y = (e.clientY - rect.top) / imageScale;
            
            const fontSize = parseInt(fontSizeSlider.value);
            const ctx = previewCanvas.getContext('2d');
            ctx.font = `bold ${fontSize}px Arial`;
            
            // Check if clicking on top text
            if (topTextInput.value) {
                const metrics = ctx.measureText(topTextInput.value);
                if (x >= textPositions.top.x && x <= textPositions.top.x + metrics.width &&
                    y >= textPositions.top.y - fontSize && y <= textPositions.top.y + fontSize) {
                    isDragging = true;
                    dragTarget = 'top';
                    dragOffset.x = x - textPositions.top.x;
                    dragOffset.y = y - textPositions.top.y;
                    previewCanvas.style.cursor = 'grabbing';
                }
            }
            
            // Check if clicking on bottom text
            if (bottomTextInput.value && !isDragging) {
                const metrics = ctx.measureText(bottomTextInput.value);
                if (x >= textPositions.bottom.x && x <= textPositions.bottom.x + metrics.width &&
                    y >= textPositions.bottom.y - fontSize && y <= textPositions.bottom.y + fontSize) {
                    isDragging = true;
                    dragTarget = 'bottom';
                    dragOffset.x = x - textPositions.bottom.x;
                    dragOffset.y = y - textPositions.bottom.y;
                    previewCanvas.style.cursor = 'grabbing';
                }
            }
        });
        
        previewCanvas.addEventListener('mousemove', function(e) {
            if (!currentImage || !isDragging) return;
            
            const rect = previewCanvas.getBoundingClientRect();
            const x = (e.clientX - rect.left) / imageScale;
            const y = (e.clientY - rect.top) / imageScale;
            const padding = 40;
            const fontSize = parseInt(fontSizeSlider.value);
            const ctx = previewCanvas.getContext('2d');
            ctx.font = `bold ${fontSize}px Arial`;
            
            if (dragTarget === 'top') {
                let newX = x - dragOffset.x;
                let newY = y - dragOffset.y;
                
                // Get text width to check bounds
                const textWidth = ctx.measureText(topTextInput.value).width;
                
                // Ensure text stays within canvas bounds
                newX = Math.max(padding, Math.min(newX, currentImage.width - textWidth - padding));
                newY = Math.max(padding, Math.min(newY, currentImage.height - fontSize - padding));
                
                textPositions.top.x = newX;
                textPositions.top.y = newY;
            } else if (dragTarget === 'bottom') {
                let newX = x - dragOffset.x;
                let newY = y - dragOffset.y;
                
                // Get text width to check bounds
                const textWidth = ctx.measureText(bottomTextInput.value).width;
                
                // Ensure text stays within canvas bounds
                newX = Math.max(padding, Math.min(newX, currentImage.width - textWidth - padding));
                newY = Math.max(padding, Math.min(newY, currentImage.height - fontSize - padding));
                
                textPositions.bottom.x = newX;
                textPositions.bottom.y = newY;
            }
            
            drawTexts();
        });
        
        previewCanvas.addEventListener('mouseup', function() {
            if (isDragging) {
                isDragging = false;
                dragTarget = null;
                previewCanvas.style.cursor = 'move';
            }
        });
        
        previewCanvas.addEventListener('mouseleave', function() {
            if (isDragging) {
                isDragging = false;
                dragTarget = null;
                previewCanvas.style.cursor = 'move';
            }
        });
        
        // Handle form submission
        memeForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!currentImage) {
                alert('Please select a template or upload an image first.');
                return;
            }
            
            generateBtn.disabled = true;
            generateBtn.textContent = 'Generating...';
            
            const formData = new FormData(memeForm);
            
            // If using a template, ensure template is set and image is cleared
            if (currentTemplate) {
                formData.set('template', currentTemplate);
                // Remove the file input requirement
                if (formData.has('image')) {
                    formData.delete('image');
                }
            }
            
            // Add text positions to form data
            formData.append('topX', Math.round(textPositions.top.x));
            formData.append('topY', Math.round(textPositions.top.y));
            formData.append('bottomX', Math.round(textPositions.bottom.x));
            formData.append('bottomY', Math.round(textPositions.bottom.y));
            
            // Add color values
            formData.append('textColor', textColor);
            formData.append('borderColor', borderColor);
            
            fetch('process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.blob();
            })
            .then(blob => {
                if (blob.type.startsWith('image/')) {
                    const url = window.URL.createObjectURL(blob);
                    previewImage.src = url;
                    previewImage.style.display = 'block';
                    previewCanvas.style.display = 'none';
                    previewContainer.classList.add('show');
                    downloadBtn.href = url;
                    downloadBtn.classList.add('show');
                } else {
                    // If response is not an image, it might be an error message
                    blob.text().then(text => {
                        alert('Error: ' + text);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error generating meme. Please try again. Make sure PHP GD extension is enabled.');
            })
            .finally(() => {
                generateBtn.disabled = false;
                generateBtn.textContent = 'Generate Meme';
            });
        });
    </script>
</body>
</html>
