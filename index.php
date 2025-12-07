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

        [data-theme="dark"] {
            --primary: #ff7a47;
            --primary-dark: #ff6b35;
            --primary-light: #ff9a70;
            --secondary: #f7931e;
            --accent: #ffd23f;
            --bg-gradient-start: #1a1a1a;
            --bg-gradient-end: #2a2a2a;
            --text-primary: #e5e5e5;
            --text-secondary: #b0b0b0;
            --text-light: #808080;
            --border: #3a3a3a;
            --border-focus: #ff7a47;
            --bg-card: #1e1e1e;
            --bg-section: #252525;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.5);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg-section);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            color: var(--text-primary);
            line-height: 1.6;
            transition: background 0.3s ease, color 0.3s ease;
            overflow: hidden;
        }
        
        .container {
            display: flex;
            height: 100vh;
            position: relative;
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
        
        /* Left Sidebar */
        .sidebar {
            width: 140px;
            background: var(--bg-card);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            transition: background 0.3s ease, border-color 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .sidebar-header {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-align: center;
            line-height: 1;
        }

        .theme-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-switch {
            position: relative;
            width: 48px;
            height: 48px;
            background: var(--bg-section);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            border: 1px solid var(--border);
        }

        .toggle-switch:hover {
            background: var(--border);
        }

        .toggle-switch.active {
            background: var(--bg-section);
        }
        
        .template-list {
            padding: 12px 8px 12px 12px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .canvas-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            overflow: auto;
            background: var(--bg-section);
        }

        .canvas-header {
            position: absolute;
            top: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 5;
        }

        .canvas-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
            transition: color 0.3s ease;
        }
        
        /* Bottom Utility Bar */
        .utility-bar {
            position: absolute;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--bg-card);
            border-radius: 16px;
            padding: 20px 32px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 24px;
            max-width: calc(100% - 200px);
            z-index: 10;
            transition: all 0.3s ease;
        }

        .utility-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .divider-vertical {
            width: 1px;
            height: 40px;
            background: var(--border);
        }
        
        .upload-btn {
            width: 116px;
            height: 116px;
            background: var(--bg-section);
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            position: relative;
            gap: 8px;
        }

        .upload-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .upload-btn input[type="file"] {
            display: none;
        }

        .upload-btn-label {
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* Text Elements on Canvas */
        .text-element {
            position: absolute;
            cursor: move;
            user-select: none;
            padding: 8px 12px;
            min-width: 100px;
            border: 2px dashed transparent;
            transition: border-color 0.2s;
        }

        .text-element:hover,
        .text-element.selected {
            border-color: var(--primary);
        }

        .text-element-content {
            font-family: Arial, sans-serif;
            font-weight: bold;
            text-align: center;
            white-space: nowrap;
            -webkit-text-stroke-width: 2px;
            -webkit-text-stroke-color: #000000;
            paint-order: stroke fill;
        }

        .text-element-delete {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 24px;
            height: 24px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .text-element:hover .text-element-delete,
        .text-element.selected .text-element-delete {
            display: flex;
        }

        .text-element-resize {
            position: absolute;
            bottom: -10px;
            right: -10px;
            width: 24px;
            height: 24px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: nwse-resize;
            font-size: 12px;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .text-element:hover .text-element-resize,
        .text-element.selected .text-element-resize {
            display: flex;
        }

        .add-text-btn {
            padding: 10px 20px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: inherit;
            white-space: nowrap;
        }

        .add-text-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .text-input-compact {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .text-input-compact label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .text-input-compact input[type="text"] {
            width: 150px;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.875rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background: var(--bg-section);
            color: var(--text-primary);
        }
        
        .text-input-compact input[type="text"]:focus {
            outline: none;
            border-color: var(--border-focus);
            box-shadow: 0 0 0 2px rgba(255, 107, 53, 0.1);
        }

        .text-input-compact input[type="text"]::placeholder {
            color: var(--text-light);
        }
        
        .slider-compact {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .slider-compact label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-weight: 600;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .slider-compact input[type="range"] {
            width: 100px;
            height: 4px;
            border-radius: 2px;
            background: var(--border);
            outline: none;
            -webkit-appearance: none;
            appearance: none;
        }

        .slider-compact input[type="range"]::-webkit-slider-thumb {
            appearance: none;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--primary);
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(255, 107, 53, 0.3);
            transition: all 0.2s;
        }

        .slider-compact input[type="range"]::-webkit-slider-thumb:hover {
            transform: scale(1.1);
        }

        .slider-compact input[type="range"]::-moz-range-thumb {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--primary);
            cursor: pointer;
            border: none;
            box-shadow: 0 2px 4px rgba(255, 107, 53, 0.3);
        }
        
        .slider-value {
            font-weight: 600;
            color: var(--primary);
            font-size: 0.75rem;
        }
        
        .color-picker-compact {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .color-picker-compact label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .color-picker-compact input[type="color"] {
            width: 48px;
            height: 32px;
            border: 1px solid var(--border);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            background: var(--bg-section);
        }

        .color-picker-compact input[type="color"]:hover {
            border-color: var(--border-focus);
            transform: scale(1.05);
        }
        
        .preview-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 90%;
            max-height: 90%;
            background: var(--bg-card);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
        }
        
        .preview-container.show {
            animation: fadeIn 0.3s ease-out;
        }
        
        .preview-image {
            max-width: 100%;
            max-height: 100%;
            display: block;
        }
        
        #previewCanvas {
            max-width: 100%;
            max-height: calc(100vh - 200px);
            cursor: move;
            display: block;
        }
        
        .generate-btn {
            padding: 10px 20px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: inherit;
            letter-spacing: -0.01em;
            box-shadow: 0 2px 8px rgba(255, 107, 53, 0.3);
            white-space: nowrap;
        }
        
        .generate-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.4);
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
            padding: 10px 20px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: none;
            text-decoration: none;
            text-align: center;
            font-family: inherit;
            letter-spacing: -0.01em;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
            white-space: nowrap;
        }
        
        .download-btn.show {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }
        
        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
            background: #059669;
        }

        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: var(--text-light);
            transition: color 0.3s ease;
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 12px;
            opacity: 0.5;
        }

        .empty-state-text {
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .template-item {
            position: relative;
            width: 116px;
            height: 116px;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid var(--border);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--bg-card);
            flex-shrink: 0;
        }
        
        .template-item:hover {
            transform: scale(1.05);
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
        
        @media (max-width: 1024px) {
            .utility-bar {
                max-width: calc(100% - 200px);
                flex-wrap: wrap;
                padding: 16px 20px;
            }

            .text-input-compact input[type="text"] {
                width: 120px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }

            .template-item {
                width: 64px;
                height: 64px;
            }

            .upload-btn {
                width: 64px;
                height: 64px;
                font-size: 18px;
            }

            .upload-btn-label {
                font-size: 0.6rem;
            }

            .utility-bar {
                max-width: calc(100% - 120px);
                padding: 12px 16px;
                gap: 16px;
            }

            .text-input-compact input[type="text"] {
                width: 100px;
            }

            .slider-compact input[type="range"] {
                width: 80px;
            }

            .canvas-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .utility-bar {
                bottom: 12px;
                max-width: calc(100% - 80px);
                flex-wrap: wrap;
                justify-content: center;
            }

            .divider-vertical {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="logo">🎨</div>
                <div class="theme-toggle">
                    <div class="toggle-switch" id="themeToggle">🌙</div>
                </div>
            </div>
            <div class="template-list" id="templateGrid">
                <label class="upload-btn" for="imageUpload" title="Upload Image">
                    <span>📁</span>
                    <span class="upload-btn-label">Upload</span>
                    <input type="file" id="imageUpload" name="image" accept="image/*">
                </label>
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
                            echo '<div class="template-item" data-template="' . htmlspecialchars($imagePath) . '" title="' . htmlspecialchars($file) . '">';
                            echo '<img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($file) . '">';
                            echo '</div>';
                        }
                    }
                }
                ?>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="main-content">
            <div class="canvas-header">
                <h1 class="canvas-title">Meme Generator</h1>
            </div>
            <div class="canvas-area">
                <div class="preview-container" id="previewContainer">
                    <div class="empty-state" id="emptyState">
                        <div class="empty-state-icon">🖼️</div>
                        <div class="empty-state-text">Select a template or upload an image</div>
                    </div>
                    <img id="previewImage" class="preview-image" alt="Preview" style="display: none;">
                    <canvas id="previewCanvas"></canvas>
                </div>
            </div>
            
            <!-- Bottom Utility Bar -->
            <form id="memeForm" method="POST" action="process.php" enctype="multipart/form-data">
                <input type="hidden" id="selectedTemplate" name="template">
                <input type="hidden" id="textElementsData" name="textElements">
                <div class="utility-bar">
                    <div class="utility-section">
                        <div class="text-input-compact">
                            <label for="newText">Text</label>
                            <input type="text" id="newText" placeholder="Enter text...">
                        </div>
                    </div>
                    
                    <button type="button" class="add-text-btn" id="addTextBtn">Add Text</button>
                    
                    <div class="divider-vertical"></div>
                    
                    <div class="utility-section">
                        <div class="slider-compact">
                            <label for="fontSize">Size <span class="slider-value" id="fontSizeValue">40</span></label>
                            <input type="range" id="fontSize" name="fontSize" min="20" max="100" value="40">
                        </div>
                    </div>
                    
                    <div class="divider-vertical"></div>
                    
                    <div class="utility-section">
                        <div class="color-picker-compact">
                            <label for="textColor">Text</label>
                            <input type="color" id="textColor" name="textColor" value="#ffffff">
                        </div>
                    </div>
                    
                    <div class="utility-section">
                        <div class="color-picker-compact">
                            <label for="borderColor">Border</label>
                            <input type="color" id="borderColor" name="borderColor" value="#000000">
                        </div>
                    </div>
                    
                    <div class="divider-vertical"></div>
                    
                    <button type="submit" class="generate-btn" id="generateBtn">Generate</button>
                    <a id="downloadBtn" class="download-btn" download="meme.png">Download</a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Dark mode toggle functionality
        const themeToggle = document.getElementById('themeToggle');
        const htmlElement = document.documentElement;
        
        // Load saved theme preference or default to light
        const savedTheme = localStorage.getItem('theme') || 'light';
        htmlElement.setAttribute('data-theme', savedTheme);
        if (savedTheme === 'dark') {
            themeToggle.classList.add('active');
            themeToggle.textContent = '☀️';
        } else {
            themeToggle.textContent = '🌙';
        }
        
        // Toggle theme on click
        themeToggle.addEventListener('click', function() {
            const currentTheme = htmlElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            htmlElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            if (newTheme === 'dark') {
                themeToggle.classList.add('active');
                themeToggle.textContent = '☀️';
            } else {
                themeToggle.classList.remove('active');
                themeToggle.textContent = '🌙';
            }
        });

        const imageUpload = document.getElementById('imageUpload');
        const previewImage = document.getElementById('previewImage');
        const previewCanvas = document.getElementById('previewCanvas');
        const previewContainer = document.getElementById('previewContainer');
        const emptyState = document.getElementById('emptyState');
        const fontSizeSlider = document.getElementById('fontSize');
        const fontSizeValue = document.getElementById('fontSizeValue');
        const memeForm = document.getElementById('memeForm');
        const downloadBtn = document.getElementById('downloadBtn');
        const generateBtn = document.getElementById('generateBtn');
        const newTextInput = document.getElementById('newText');
        const addTextBtn = document.getElementById('addTextBtn');
        const textColorPicker = document.getElementById('textColor');
        const borderColorPicker = document.getElementById('borderColor');
        const selectedTemplate = document.getElementById('selectedTemplate');
        const templateItems = document.querySelectorAll('.template-item');
        const textElementsData = document.getElementById('textElementsData');
        
        let currentImage = null;
        let imageScale = 1;
        let textElements = [];
        let selectedTextElement = null;
        let isDragging = false;
        let isResizing = false;
        let dragOffset = { x: 0, y: 0 };
        let textColor = textColorPicker.value;
        let borderColor = borderColorPicker.value;
        let currentTemplate = null;
        let currentUploadedFile = null;
        
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
                
                // Load template image
                loadTemplateImage(templatePath);
            });
        });
        
        function loadTemplateImage(path) {
            const img = new Image();
            img.onload = function() {
                currentImage = img;
                imageScale = 1;
                
                previewCanvas.width = img.width;
                previewCanvas.height = img.height;
                
                const ctx = previewCanvas.getContext('2d');
                ctx.drawImage(img, 0, 0);
                
                previewImage.style.display = 'none';
                previewCanvas.style.display = 'block';
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
        
        // Preview uploaded image
        imageUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Clear template selection
                templateItems.forEach(t => t.classList.remove('selected'));
                currentTemplate = null;
                selectedTemplate.value = '';
                currentUploadedFile = file;
                handleImageUpload(file);
            }
        });

        function handleImageUpload(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    currentImage = img;
                    imageScale = 1;
                    
                    previewCanvas.width = img.width;
                    previewCanvas.height = img.height;
                    
                    const ctx = previewCanvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'none';
                    previewCanvas.style.display = 'block';
                    emptyState.style.display = 'none';
                    previewContainer.classList.add('show');
                    
                    // Clear and redraw text elements
                    drawCanvas();
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
        
        // Add text element
        addTextBtn.addEventListener('click', function() {
            const text = newTextInput.value.trim();
            if (!text || !currentImage) {
                if (!currentImage) alert('Please select a template or upload an image first.');
                return;
            }
            
            const fontSize = parseInt(fontSizeSlider.value);
            const textElement = {
                id: Date.now(),
                text: text,
                x: currentImage.width / 2,
                y: currentImage.height / 2,
                fontSize: fontSize,
                color: textColor,
                borderColor: borderColor
            };
            
            textElements.push(textElement);
            newTextInput.value = '';
            drawCanvas();
        });
        
        // Draw canvas with image and text elements
        function drawCanvas() {
            if (!currentImage) return;
            
            const ctx = previewCanvas.getContext('2d');
            ctx.clearRect(0, 0, previewCanvas.width, previewCanvas.height);
            ctx.drawImage(currentImage, 0, 0);
            
            // Draw all text elements
            textElements.forEach(element => {
                ctx.font = `bold ${element.fontSize}px Arial`;
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.lineWidth = 3;
                ctx.lineJoin = 'round';
                
                // Draw border
                ctx.strokeStyle = element.borderColor;
                ctx.strokeText(element.text, element.x, element.y);
                
                // Draw text
                ctx.fillStyle = element.color;
                ctx.fillText(element.text, element.x, element.y);
                
                // Draw selection handles if this element is selected
                if (selectedTextElement && selectedTextElement.id === element.id) {
                    const metrics = ctx.measureText(element.text);
                    const width = metrics.width;
                    const height = element.fontSize;
                    const padding = 10;
                    
                    // Draw selection rectangle
                    ctx.strokeStyle = '#ff6b35';
                    ctx.lineWidth = 2;
                    ctx.setLineDash([5, 5]);
                    ctx.strokeRect(
                        element.x - width/2 - padding,
                        element.y - height/2 - padding,
                        width + padding * 2,
                        height + padding * 2
                    );
                    ctx.setLineDash([]);
                    
                    // Draw resize handle (bottom-right corner)
                    const handleSize = 12;
                    const handleX = element.x + width/2 + padding;
                    const handleY = element.y + height/2 + padding;
                    
                    ctx.fillStyle = '#ff6b35';
                    ctx.fillRect(
                        handleX - handleSize/2,
                        handleY - handleSize/2,
                        handleSize,
                        handleSize
                    );
                    
                    // Draw white border around handle
                    ctx.strokeStyle = '#ffffff';
                    ctx.lineWidth = 2;
                    ctx.strokeRect(
                        handleX - handleSize/2,
                        handleY - handleSize/2,
                        handleSize,
                        handleSize
                    );
                }
            });
        }
        
        // Delete text element
        function deleteTextElement(id) {
            textElements = textElements.filter(el => el.id !== id);
            selectedTextElement = null;
            drawCanvas();
        }
        
        // Find text element at position
        function findTextElementAt(x, y) {
            for (let i = textElements.length - 1; i >= 0; i--) {
                const element = textElements[i];
                const ctx = previewCanvas.getContext('2d');
                ctx.font = `bold ${element.fontSize}px Arial`;
                const metrics = ctx.measureText(element.text);
                const width = metrics.width;
                const height = element.fontSize;
                
                if (x >= element.x - width/2 && x <= element.x + width/2 &&
                    y >= element.y - height/2 && y <= element.y + height/2) {
                    return element;
                }
            }
            return null;
        }
        
        // Check if click is on resize handle
        function isResizeHandle(x, y, element) {
            if (!element) return false;
            const ctx = previewCanvas.getContext('2d');
            ctx.font = `bold ${element.fontSize}px Arial`;
            const metrics = ctx.measureText(element.text);
            const width = metrics.width;
            const height = element.fontSize;
            const padding = 10;
            const handleSize = 12;
            const handleX = element.x + width/2 + padding;
            const handleY = element.y + height/2 + padding;
            
            return (x >= handleX - handleSize/2 && x <= handleX + handleSize/2 &&
                    y >= handleY - handleSize/2 && y <= handleY + handleSize/2);
        }
        
        // Color picker handlers
        textColorPicker.addEventListener('input', function() {
            textColor = this.value;
        });
        
        borderColorPicker.addEventListener('input', function() {
            borderColor = this.value;
        });
        
        // Update font size display
        fontSizeSlider.addEventListener('input', function() {
            fontSizeValue.textContent = this.value;
        });
        
        // Mouse events for text elements
        previewCanvas.addEventListener('mousedown', function(e) {
            if (!currentImage) return;
            
            const rect = previewCanvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            // Check if clicking on resize handle of selected element
            if (selectedTextElement && isResizeHandle(x, y, selectedTextElement)) {
                isResizing = true;
                const ctx = previewCanvas.getContext('2d');
                ctx.font = `bold ${selectedTextElement.fontSize}px Arial`;
                const metrics = ctx.measureText(selectedTextElement.text);
                const initialWidth = metrics.width;
                const initialFontSize = selectedTextElement.fontSize;
                const initialDistance = Math.sqrt(Math.pow(x - selectedTextElement.x, 2) + Math.pow(y - selectedTextElement.y, 2));
                
                previewCanvas.addEventListener('mousemove', resizeHandler);
                previewCanvas.addEventListener('mouseup', stopResize);
                
                function resizeHandler(e) {
                    const rect = previewCanvas.getBoundingClientRect();
                    const newX = e.clientX - rect.left;
                    const newY = e.clientY - rect.top;
                    const newDistance = Math.sqrt(Math.pow(newX - selectedTextElement.x, 2) + Math.pow(newY - selectedTextElement.y, 2));
                    const scale = newDistance / initialDistance;
                    const newFontSize = Math.max(12, Math.min(150, Math.round(initialFontSize * scale)));
                    selectedTextElement.fontSize = newFontSize;
                    drawCanvas();
                }
                
                function stopResize() {
                    previewCanvas.removeEventListener('mousemove', resizeHandler);
                    previewCanvas.removeEventListener('mouseup', stopResize);
                    isResizing = false;
                }
                
                e.preventDefault();
                return;
            }
            
            // Find text element at mouse position
            const element = findTextElementAt(x, y);
            if (element) {
                selectedTextElement = element;
                isDragging = true;
                dragOffset.x = x - element.x;
                dragOffset.y = y - element.y;
                previewCanvas.style.cursor = 'grabbing';
                drawCanvas();
            } else {
                selectedTextElement = null;
                drawCanvas();
            }
        });
        
        previewCanvas.addEventListener('mousemove', function(e) {
            if (!currentImage || isResizing) return;
            
            const rect = previewCanvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            if (isDragging && selectedTextElement) {
                selectedTextElement.x = Math.max(20, Math.min(x - dragOffset.x, previewCanvas.width - 20));
                selectedTextElement.y = Math.max(20, Math.min(y - dragOffset.y, previewCanvas.height - 20));
                drawCanvas();
            } else {
                // Change cursor on hover
                if (selectedTextElement && isResizeHandle(x, y, selectedTextElement)) {
                    previewCanvas.style.cursor = 'nwse-resize';
                } else {
                    const element = findTextElementAt(x, y);
                    previewCanvas.style.cursor = element ? 'move' : 'default';
                }
            }
        });
        
        previewCanvas.addEventListener('mouseup', function() {
            if (isDragging) {
                isDragging = false;
                previewCanvas.style.cursor = 'default';
            }
        });
        
        previewCanvas.addEventListener('mouseleave', function() {
            if (isDragging) {
                isDragging = false;
                previewCanvas.style.cursor = 'default';
            }
        });
        
        // Keyboard event for deleting selected text
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Delete' || e.key === 'Backspace') {
                if (selectedTextElement) {
                    deleteTextElement(selectedTextElement.id);
                    e.preventDefault();
                }
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
            
            const formData = new FormData();
            
            // If using a template, set template path
            if (currentTemplate) {
                formData.set('template', currentTemplate);
            } else if (currentUploadedFile) {
                // If using an uploaded file, add it
                formData.set('image', currentUploadedFile);
            } else {
                alert('Error: Please select a template or upload an image.');
                generateBtn.disabled = false;
                generateBtn.textContent = 'Generate';
                return;
            }
            
            // Add text elements data as JSON
            formData.append('textElements', JSON.stringify(textElements));
            
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
