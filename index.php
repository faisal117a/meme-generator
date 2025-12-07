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
        
        /* Scrollbar styling */
        .sidebar::-webkit-scrollbar {
            width: 8px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: var(--bg-section);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--text-light);
        }
        
        /* Dark mode scrollbar */
        [data-theme="dark"] .sidebar::-webkit-scrollbar-track {
            background: var(--bg-section);
        }
        
        [data-theme="dark"] .sidebar::-webkit-scrollbar-thumb {
            background: var(--border);
        }
        
        [data-theme="dark"] .sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--text-secondary);
        }
        
        /* Firefox scrollbar */
        .sidebar {
            scrollbar-width: thin;
            scrollbar-color: var(--border) var(--bg-section);
        }
        
        [data-theme="dark"] .sidebar {
            scrollbar-color: var(--border) var(--bg-section);
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
            margin-right: 8px; /* Add right margin to avoid scrollbar conflict */
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
            .container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                height: auto;
                max-height: 120px;
                flex-direction: row;
                border-right: none;
                border-bottom: 1px solid var(--border);
                overflow-x: auto;
                overflow-y: hidden;
            }
            
            .sidebar-header {
                flex-direction: row;
                padding: 12px;
                border-bottom: none;
                border-right: 1px solid var(--border);
                min-width: 100px;
            }
            
            .template-list {
                flex-direction: row;
                padding: 8px;
                gap: 8px;
            }

            .template-item {
                width: 64px;
                height: 64px;
                margin-right: 8px;
                flex-shrink: 0;
            }

            .upload-btn {
                width: 64px;
                height: 64px;
                font-size: 18px;
                flex-shrink: 0;
            }

            .upload-btn-label {
                font-size: 0.6rem;
            }

            .main-content {
                height: calc(100vh - 120px);
            }
            
            .canvas-area {
                padding: 12px;
            }

            .utility-bar {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                max-width: 100%;
                padding: 12px;
                gap: 8px;
                border-radius: 0;
                border-left: none;
                border-right: none;
                border-bottom: none;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .utility-section {
                flex-wrap: wrap;
                gap: 8px;
            }

            .text-input-compact input[type="text"] {
                width: 80px;
                font-size: 0.75rem;
            }

            .slider-compact input[type="range"] {
                width: 60px;
            }
            
            .slider-compact label {
                font-size: 0.7rem;
            }

            .canvas-title {
                font-size: 1.25rem;
            }
            
            .auth-section {
                top: 12px;
                right: 12px;
                padding: 12px;
                min-width: auto;
                max-width: calc(100% - 24px);
            }
            
            .nav-link {
                top: 12px;
                left: 12px;
                padding: 8px 16px;
                font-size: 0.8rem;
            }
            
            .post-meme-section {
                bottom: 80px;
                right: 12px;
                left: 12px;
                max-width: calc(100% - 24px);
            }
        }

        @media (max-width: 480px) {
            .utility-bar {
                padding: 8px;
                gap: 6px;
            }
            
            .utility-section {
                gap: 6px;
            }

            .divider-vertical {
                display: none;
            }
            
            .text-input-compact input[type="text"] {
                width: 70px;
                padding: 8px;
            }
            
            .slider-compact input[type="range"] {
                width: 50px;
            }
            
            .color-picker-compact input[type="color"] {
                width: 40px;
                height: 28px;
            }
            
            .add-text-btn,
            .generate-btn,
            .download-btn {
                padding: 8px 12px;
                font-size: 0.75rem;
            }
            
            .canvas-title {
                font-size: 1rem;
            }
        }

        /* Auth UI Styles */
        .auth-section {
            position: absolute;
            top: 24px;
            right: 24px;
            z-index: 20;
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 16px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
            min-width: 200px;
        }

        .auth-section h3 {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: var(--text-primary);
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .auth-form input {
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 0.875rem;
            background: var(--bg-section);
            color: var(--text-primary);
        }

        .auth-form input:focus {
            outline: none;
            border-color: var(--border-focus);
        }

        .auth-btn {
            padding: 8px 16px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .auth-btn:hover {
            background: var(--primary-dark);
        }

        .auth-btn.secondary {
            background: var(--bg-section);
            color: var(--text-primary);
            border: 1px solid var(--border);
        }

        .auth-btn.secondary:hover {
            background: var(--border);
        }

        .user-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .user-info span {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .user-info .user-email {
            font-weight: 600;
            color: var(--text-primary);
        }

        .nav-link {
            position: absolute;
            top: 24px;
            left: 24px;
            z-index: 20;
            padding: 10px 20px;
            background: var(--bg-card);
            color: var(--text-primary);
            text-decoration: none;
            border-radius: var(--radius);
            font-size: 0.875rem;
            font-weight: 600;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .post-meme-section {
            position: absolute;
            bottom: 24px;
            right: 24px;
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 16px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
            min-width: 250px;
            z-index: 15;
            display: none;
        }

        .post-meme-section.show {
            display: block;
        }

        .post-meme-section input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 0.875rem;
            background: var(--bg-section);
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .post-meme-btn {
            width: 100%;
            padding: 10px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .post-meme-btn:hover {
            background: #059669;
        }

        .post-meme-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .notification {
            position: fixed;
            top: 80px;
            right: 24px;
            z-index: 100;
            padding: 12px 20px;
            border-radius: var(--radius);
            font-size: 0.875rem;
            font-weight: 500;
            box-shadow: var(--shadow-lg);
            animation: slideIn 0.3s ease-out;
            max-width: 300px;
        }

        .notification.success {
            background: #10b981;
            color: white;
        }

        .notification.error {
            background: #ef4444;
            color: white;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Hide InstantDB default auth UI */
        [data-instant-auth],
        [id*="instant"],
        [class*="instant-auth"],
        iframe[src*="instant"],
        button[aria-label*="Instant"],
        div[role="button"][aria-label*="Instant"] {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
            position: absolute !important;
            left: -9999px !important;
        }
        
        /* Hide any SVG buttons from InstantDB */
        svg[class*="instant"],
        button svg,
        div[role="button"] svg {
            display: none !important;
        }
        
        /* Hide any floating buttons in bottom right */
        button[style*="position: fixed"][style*="bottom"],
        div[style*="position: fixed"][style*="bottom"][style*="right"] {
            display: none !important;
        }

        /* Fix text element selection and resize */
        .text-element.selected {
            border-color: var(--primary);
            border-style: solid;
            border-width: 2px;
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
            <a href="feed.php" class="nav-link">View Feed</a>
            
            <!-- Auth Section -->
            <div class="auth-section" id="authSection">
                <div id="loginForm">
                    <h3>Sign In</h3>
                    <div class="auth-form" id="emailForm">
                        <input type="email" id="emailInput" placeholder="Email address" required>
                        <button class="auth-btn" onclick="handleEmailSignIn()">Sign In with Email</button>
                        <button class="auth-btn secondary" onclick="handleGuestSignIn()">Continue as Guest</button>
                    </div>
                    <div class="auth-form" id="codeForm" style="display: none;">
                        <p style="font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 8px;">Enter the 6-digit code sent to your email:</p>
                        <input type="text" id="codeInput" placeholder="000000" maxlength="6" pattern="[0-9]{6}" style="text-align: center; font-size: 1.2rem; letter-spacing: 0.2em;" inputmode="numeric">
                        <button class="auth-btn" onclick="handleCodeVerification()">Verify Code</button>
                        <button class="auth-btn secondary" onclick="cancelCodeInput()">Cancel</button>
                    </div>
                </div>
                <div class="user-info" id="userInfo" style="display: none;">
                    <span>Signed in as:</span>
                    <span class="user-email"></span>
                    <button class="auth-btn secondary" onclick="handleSignOut()" style="margin-top: 8px;">Sign Out</button>
                </div>
            </div>
            
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
            
            <!-- Post Meme Section -->
            <div class="post-meme-section" id="postMemeSection">
                <input type="text" id="memeTitle" placeholder="Optional title for your meme...">
                <button class="post-meme-btn" id="postMemeBtn" onclick="handlePostMeme()">Post Meme</button>
            </div>
        </div>
    </div>
    
    <!-- InstantDB SDK -->
    <script type="module">
        import { init } from 'https://esm.sh/@instantdb/react@latest';
        window.init = init;
        
        // Initialize InstantDB
        const APP_ID = '2cc27c95-cf7d-4fe7-9fe4-4c56c35cda96';
        window.db = init({ appId: APP_ID });
        
        // Debug: Log auth methods to see what's available
        console.log('InstantDB auth methods:', Object.keys(window.db.auth || {}));
        if (window.db.auth && window.db.auth.signInWithMagicCode) {
            console.log('signInWithMagicCode function exists');
        }
        
        // Initialize auth and memes modules
        if (typeof initAuth === 'function') {
            initAuth(window.db);
        }
        if (typeof initMemes === 'function') {
            initMemes(window.db);
        }
        
        // InstantDB React SDK doesn't have onAuthStateChange
        // We'll use polling to check auth state changes
        let lastAuthState = null;
        function checkAuthState() {
            // Try multiple ways to get current user
            let currentUser = null;
            
            // Method 1: Standard currentUser property
            if (window.db && window.db.auth) {
                currentUser = window.db.auth.currentUser;
            }
            
            // Method 2: Check InstantDB's internal storage
            if (!currentUser && window.db && window.db.auth && window.db.auth.db) {
                if (window.db.auth.db._currentUserCached && window.db.auth.db._currentUserCached.user) {
                    currentUser = window.db.auth.db._currentUserCached.user;
                } else if (window.db.auth.db.kv && window.db.auth.db.kv.currentValue && window.db.auth.db.kv.currentValue.currentUser) {
                    currentUser = window.db.auth.db.kv.currentValue.currentUser;
                }
            }
            
            // Method 3: Check db.user
            if (!currentUser && window.db && window.db.user) {
                currentUser = window.db.user;
            }
            
            // Check if auth state changed
            const authChanged = JSON.stringify(currentUser) !== JSON.stringify(lastAuthState);
            if (authChanged) {
                console.log('Auth state changed:', currentUser);
                lastAuthState = currentUser ? JSON.parse(JSON.stringify(currentUser)) : null;
                window.currentUser = currentUser;
                updateAuthUI();
            }
        }
        
        // Poll for auth state changes every 500ms
        setInterval(checkAuthState, 500);
        checkAuthState(); // Initial check
        
        // Update auth UI function
        function updateAuthUI() {
            // Try multiple ways to get the current user
            let user = null;
            
            // Method 1: Check currentUser property (standard)
            if (window.db && window.db.auth) {
                user = window.db.auth.currentUser;
            }
            
            // Method 2: Check InstantDB's internal storage (where it actually stores the user)
            if (!user && window.db && window.db.auth && window.db.auth.db) {
                // Check _currentUserCached
                if (window.db.auth.db._currentUserCached && window.db.auth.db._currentUserCached.user) {
                    user = window.db.auth.db._currentUserCached.user;
                }
                // Check kv storage
                if (!user && window.db.auth.db.kv && window.db.auth.db.kv.currentValue && window.db.auth.db.kv.currentValue.currentUser) {
                    user = window.db.auth.db.kv.currentValue.currentUser;
                }
            }
            
            // Method 3: Check if there's a user in the db object
            if (!user && window.db && window.db.user) {
                user = window.db.user;
            }
            
            // Method 4: Check if there's a getUser method
            if (!user && window.db && window.db.auth && typeof window.db.auth.getUser === 'function') {
                try {
                    user = window.db.auth.getUser();
                } catch (e) {
                    console.log('getUser method not available or failed');
                }
            }
            
            const authSection = document.getElementById('authSection');
            const userInfo = document.getElementById('userInfo');
            const loginForm = document.getElementById('loginForm');
            
            if (!authSection) return;
            
            console.log('updateAuthUI - user:', user);
            
            if (user) {
                if (loginForm) loginForm.style.display = 'none';
                if (userInfo) {
                    userInfo.style.display = 'block';
                    const emailSpan = userInfo.querySelector('.user-email');
                    if (emailSpan) {
                        emailSpan.textContent = user.email || user.id || 'Guest User';
                    }
                }
                // Reset code form if user is signed in
                if (pendingEmail) {
                    cancelCodeInput();
                }
            } else {
                if (loginForm) loginForm.style.display = 'block';
                if (userInfo) userInfo.style.display = 'none';
                
                // Only reset forms if we're not in the middle of code verification
                // Check if code form is already visible (user is entering code)
                const emailForm = document.getElementById('emailForm');
                const codeForm = document.getElementById('codeForm');
                
                // If code form is visible and we have pending email, don't reset
                if (pendingEmail && codeForm && codeForm.style.display !== 'none') {
                    // Keep code form visible, hide email form
                    if (emailForm) emailForm.style.display = 'none';
                } else {
                    // Show email form by default
                    if (emailForm) emailForm.style.display = 'flex';
                    if (codeForm) codeForm.style.display = 'none';
                }
            }
        }
        
        window.updateAuthUI = updateAuthUI;
        
        // Code input - only allow numbers
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('codeInput');
            if (codeInput) {
                codeInput.addEventListener('input', function(e) {
                    // Only allow numbers
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
                
                // Allow Enter key to submit
                codeInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        handleCodeVerification();
                    }
                });
            }
        });
        
        // Initial UI update
        updateAuthUI();
    </script>
    
    <!-- Auth and Memes Scripts -->
    <script src="js/auth.js"></script>
    <script src="js/memes.js"></script>
    
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
                
                // Clear existing text elements and redraw
                drawCanvas();
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
                    
                    // Clear existing text elements when new image is loaded
                    textElements = [];
                    selectedTextElement = null;
                    
                    // Redraw canvas
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
                    
                    // Draw selection rectangle with better visibility
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
                    
                    // Draw resize handle (bottom-right corner) - make it larger and more visible
                    const handleSize = 16;
                    const handleX = element.x + width/2 + padding;
                    const handleY = element.y + height/2 + padding;
                    
                    // Draw handle background
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
                    
                    // Draw corner indicator
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(
                        handleX - handleSize/2 + 2,
                        handleY - handleSize/2 + 2,
                        handleSize - 4,
                        handleSize - 4
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
            const handleSize = 16; // Match the size in drawCanvas
            const handleX = element.x + width/2 + padding;
            const handleY = element.y + height/2 + padding;
            
            // Add some tolerance for easier clicking
            const tolerance = 5;
            return (x >= handleX - handleSize/2 - tolerance && x <= handleX + handleSize/2 + tolerance &&
                    y >= handleY - handleSize/2 - tolerance && y <= handleY + handleSize/2 + tolerance);
        }
        
        
        // Update font size display
        fontSizeSlider.addEventListener('input', function() {
            fontSizeValue.textContent = this.value;
            // Update selected text element font size if one is selected
            if (selectedTextElement) {
                selectedTextElement.fontSize = parseInt(this.value);
                drawCanvas();
            }
        });
        
        // Update text color for selected element
        textColorPicker.addEventListener('input', function() {
            textColor = this.value;
            if (selectedTextElement) {
                selectedTextElement.color = textColor;
                drawCanvas();
            }
        });
        
        // Update border color for selected element
        borderColorPicker.addEventListener('input', function() {
            borderColor = this.value;
            if (selectedTextElement) {
                selectedTextElement.borderColor = borderColor;
                drawCanvas();
            }
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
                const padding = 10;
                const handleX = selectedTextElement.x + initialWidth/2 + padding;
                const handleY = selectedTextElement.y + selectedTextElement.fontSize/2 + padding;
                const initialDistance = Math.sqrt(Math.pow(x - selectedTextElement.x, 2) + Math.pow(y - selectedTextElement.y, 2));
                
                const resizeHandler = (e) => {
                    const rect = previewCanvas.getBoundingClientRect();
                    const newX = e.clientX - rect.left;
                    const newY = e.clientY - rect.top;
                    
                    // Calculate distance from text center to mouse
                    const newDistance = Math.sqrt(Math.pow(newX - selectedTextElement.x, 2) + Math.pow(newY - selectedTextElement.y, 2));
                    
                    // Scale font size based on distance
                    const scale = newDistance / initialDistance;
                    const newFontSize = Math.max(12, Math.min(150, Math.round(initialFontSize * scale)));
                    
                    if (newFontSize !== selectedTextElement.fontSize) {
                        selectedTextElement.fontSize = newFontSize;
                        drawCanvas();
                    }
                };
                
                const stopResize = () => {
                    previewCanvas.removeEventListener('mousemove', resizeHandler);
                    previewCanvas.removeEventListener('mouseup', stopResize);
                    document.removeEventListener('mouseup', stopResize);
                    isResizing = false;
                    previewCanvas.style.cursor = 'default';
                };
                
                previewCanvas.addEventListener('mousemove', resizeHandler);
                previewCanvas.addEventListener('mouseup', stopResize);
                document.addEventListener('mouseup', stopResize);
                previewCanvas.style.cursor = 'nwse-resize';
                
                e.preventDefault();
                e.stopPropagation();
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
                    
                    // Store blob for posting
                    window.generatedMemeBlob = blob;
                    
                    // Show post meme section if authenticated
                    const user = getCurrentUser();
                    const postSection = document.getElementById('postMemeSection');
                    if (postSection) {
                        if (user) {
                            console.log('User authenticated, showing post meme section:', user);
                            postSection.classList.add('show');
                        } else {
                            console.log('No user found, hiding post meme section');
                            postSection.classList.remove('show');
                            showNotification('Sign in to post your meme!', 'error');
                        }
                    }
                } else {
                    // If response is not an image, it might be an error message
                    blob.text().then(text => {
                        showNotification('Error generating meme: ' + text, 'error');
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error generating meme. Please try again. Make sure PHP GD extension is enabled.', 'error');
            })
            .finally(() => {
                generateBtn.disabled = false;
                generateBtn.textContent = 'Generate Meme';
            });
        });
        
        // Helper function to get current user from InstantDB
        function getCurrentUser() {
            let user = null;
            if (window.db && window.db.auth) {
                user = window.db.auth.currentUser;
                if (!user && window.db.auth.db) {
                    if (window.db.auth.db._currentUserCached && window.db.auth.db._currentUserCached.user) {
                        user = window.db.auth.db._currentUserCached.user;
                    } else if (window.db.auth.db.kv && window.db.auth.db.kv.currentValue && window.db.auth.db.kv.currentValue.currentUser) {
                        user = window.db.auth.db.kv.currentValue.currentUser;
                    }
                }
            }
            return user;
        }
        
        // Auth handlers
        let pendingEmail = null;
        
        // Store magic code session if returned
        let magicCodeSession = null;
        
        async function handleEmailSignIn() {
            const emailInput = document.getElementById('emailInput');
            const email = emailInput.value.trim();
            
            if (!email) {
                showNotification('Please enter an email address', 'error');
                return;
            }
            
            // Get button element - try event.target first, then find by ID
            let btn = null;
            if (event && event.target) {
                btn = event.target;
            } else {
                // Fallback: find the button by looking for the one with "Sign In with Email" text
                const buttons = document.querySelectorAll('.auth-btn');
                for (let b of buttons) {
                    if (b.textContent.includes('Sign In with Email')) {
                        btn = b;
                        break;
                    }
                }
            }
            
            if (!btn) {
                console.error('Could not find sign-in button');
                showNotification('Error: Could not find sign-in button', 'error');
                return;
            }
            
            const originalText = btn.textContent;
            btn.disabled = true;
            btn.textContent = 'Sending...';
            
            try {
                // InstantDB has sendMagicCode method - use it first to send the code
                if (window.db.auth.sendMagicCode) {
                    await window.db.auth.sendMagicCode({ email: email });
                } else {
                    // Fallback: try signInWithMagicCode with just email
                    await window.db.auth.signInWithMagicCode({ email: email });
                }
                
                pendingEmail = email;
                showNotification('Check your email for the 6-digit code!', 'success');
                
                // Show code input form and hide email form
                const emailForm = document.getElementById('emailForm');
                const codeForm = document.getElementById('codeForm');
                
                if (emailForm) emailForm.style.display = 'none';
                if (codeForm) {
                    codeForm.style.display = 'flex';
                    // Focus on code input
                    const codeInput = document.getElementById('codeInput');
                    if (codeInput) {
                        setTimeout(() => codeInput.focus(), 100);
                    }
                }
                
                // Re-enable button (it will be hidden anyway)
                btn.disabled = false;
                btn.textContent = originalText;
                
                // Force a UI update to ensure forms are displayed correctly
                // Use setTimeout to ensure DOM updates are complete
                setTimeout(() => {
                    // Double-check forms are in correct state
                    const emailFormCheck = document.getElementById('emailForm');
                    const codeFormCheck = document.getElementById('codeForm');
                    if (emailFormCheck) emailFormCheck.style.display = 'none';
                    if (codeFormCheck) codeFormCheck.style.display = 'flex';
                }, 100);
            } catch (error) {
                console.error('Email sign-in error:', error);
                console.error('Full error object:', error);
                const errorMsg = error.message || 'Failed to send code. Please try again.';
                showNotification('Error: ' + errorMsg, 'error');
                btn.disabled = false;
                btn.textContent = originalText;
            }
        }
        
        async function handleCodeVerification() {
            const codeInput = document.getElementById('codeInput');
            const code = codeInput.value.trim();
            
            if (!code || code.length !== 6) {
                showNotification('Please enter a valid 6-digit code', 'error');
                return;
            }
            
            if (!pendingEmail) {
                showNotification('Email session expired. Please start over.', 'error');
                cancelCodeInput();
                return;
            }
            
            const btn = event.target;
            btn.disabled = true;
            btn.textContent = 'Verifying...';
            
            try {
                // InstantDB magic code verification
                console.log('Verifying code for email:', pendingEmail);
                console.log('Code:', code);
                console.log('Magic code session:', magicCodeSession);
                
                // The error "Missing parameter: ['body' 'code']" is unusual.
                // Let's try different approaches based on what InstantDB might expect.
                
                let result;
                
                // Approach 1: Standard format (email + code)
                // This is the documented format for InstantDB React SDK
                try {
                    result = await window.db.auth.signInWithMagicCode({ 
                        email: pendingEmail,
                        code: String(code).trim()
                    });
                } catch (err) {
                    console.error('Standard format failed:', err);
                    console.error('Error details:', {
                        message: err.message,
                        stack: err.stack,
                        name: err.name
                    });
                    
                    // If we have a session from the first call, try including it
                    if (magicCodeSession) {
                        try {
                            result = await window.db.auth.signInWithMagicCode({ 
                                email: pendingEmail,
                                code: String(code).trim(),
                                session: magicCodeSession
                            });
                        } catch (err2) {
                            console.error('Session format also failed:', err2);
                            throw err; // Throw original error
                        }
                    } else {
                        throw err;
                    }
                }
                
                // Check if result contains user info
                let currentUser = null;
                
                // Check return value first
                if (result && result.user) {
                    currentUser = result.user;
                } else if (result && typeof result === 'object' && result.id) {
                    currentUser = result;
                }
                
                // Also check currentUser property (might be set immediately)
                if (!currentUser) {
                    currentUser = window.db.auth.currentUser;
                }
                
                // Wait a moment for auth state to update if needed
                if (!currentUser) {
                    await new Promise(resolve => setTimeout(resolve, 500));
                    currentUser = window.db.auth.currentUser;
                }
                
                // Try one more time with longer wait
                if (!currentUser) {
                    await new Promise(resolve => setTimeout(resolve, 1000));
                    currentUser = window.db.auth.currentUser;
                }
                
                // Check if sign-in was successful - check multiple locations
                let verifiedUser = currentUser;
                if (!verifiedUser && window.db && window.db.auth && window.db.auth.db) {
                    if (window.db.auth.db._currentUserCached && window.db.auth.db._currentUserCached.user) {
                        verifiedUser = window.db.auth.db._currentUserCached.user;
                    } else if (window.db.auth.db.kv && window.db.auth.db.kv.currentValue && window.db.auth.db.kv.currentValue.currentUser) {
                        verifiedUser = window.db.auth.db.kv.currentValue.currentUser;
                    }
                }
                
                if (verifiedUser) {
                    console.log('Sign-in successful, user:', verifiedUser);
                    showNotification('Signed in successfully!', 'success');
                    pendingEmail = null;
                    codeInput.value = '';
                    // Force UI update
                    updateAuthUI();
                } else {
                    console.error('Sign-in failed - no user found after verification');
                    console.log('Result from signInWithMagicCode:', result);
                    console.log('currentUser after wait:', window.db.auth.currentUser);
                    console.log('_currentUserCached:', window.db.auth.db?._currentUserCached);
                    throw new Error('Verification completed but sign-in failed. Please check your code and try again.');
                }
            } catch (error) {
                console.error('Code verification error:', error);
                console.error('Error details:', {
                    message: error.message,
                    stack: error.stack,
                    name: error.name,
                    error: error
                });
                
                let errorMsg = 'Invalid code. Please try again.';
                
                // Parse error message
                if (error && error.message) {
                    const msg = error.message.toLowerCase();
                    if (msg.includes('missing parameter') || msg.includes('code')) {
                        errorMsg = 'Code is required. Please enter the 6-digit code from your email.';
                    } else if (msg.includes('invalid') || msg.includes('expired')) {
                        errorMsg = 'Invalid or expired code. Please request a new code.';
                    } else if (msg.includes('verification completed')) {
                        // This is our custom error - the code was verified but user wasn't set
                        errorMsg = 'Code verified but sign-in failed. The code may be correct but there was an issue completing sign-in. Please try signing in again.';
                    } else {
                        errorMsg = error.message;
                    }
                } else if (error && error.toString) {
                    errorMsg = error.toString();
                }
                
                showNotification('Error: ' + errorMsg, 'error');
                btn.disabled = false;
                btn.textContent = 'Verify Code';
                // Don't clear the code input so user can try again
            }
        }
        
        function cancelCodeInput() {
            document.getElementById('emailForm').style.display = 'flex';
            document.getElementById('codeForm').style.display = 'none';
            document.getElementById('codeInput').value = '';
            pendingEmail = null;
            magicCodeSession = null;
        }
        
        // Alternative: Try using InstantDB's direct API if SDK method fails
        async function verifyMagicCodeDirect(email, code) {
            // This is a fallback - try making a direct API call
            // Note: This requires knowing InstantDB's API endpoint structure
            try {
                const response = await fetch(`https://api.instantdb.com/auth/magic-code`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: email,
                        code: code,
                        appId: '2cc27c95-cf7d-4fe7-9fe4-4c56c35cda96'
                    })
                });
                
                if (response.ok) {
                    const data = await response.json();
                    return data;
                } else {
                    throw new Error('API call failed');
                }
            } catch (err) {
                console.error('Direct API call failed:', err);
                return null;
            }
        }
        
        async function handleGuestSignIn() {
            const btn = event.target;
            btn.disabled = true;
            btn.textContent = 'Signing in...';
            
            try {
                // Use signInAsGuest instead of signInAnonymously
                await window.db.auth.signInAsGuest();
                
                // Wait a moment for auth state to update
                await new Promise(resolve => setTimeout(resolve, 500));
                
                // Force UI update
                updateAuthUI();
                
                showNotification('Signed in as guest', 'success');
            } catch (error) {
                console.error('Guest sign-in error:', error);
                showNotification('Error: ' + (error.message || 'Failed to sign in as guest'), 'error');
                btn.disabled = false;
                btn.textContent = 'Continue as Guest';
            } finally {
                // Re-enable button after a delay (in case of success)
                setTimeout(() => {
                    btn.disabled = false;
                    btn.textContent = 'Continue as Guest';
                }, 1000);
            }
        }
        
        async function handleSignOut() {
            try {
                await window.db.auth.signOut();
                showNotification('Signed out successfully', 'success');
                
                // Hide post meme section
                const postSection = document.getElementById('postMemeSection');
                if (postSection) {
                    postSection.classList.remove('show');
                }
            } catch (error) {
                showNotification('Error signing out: ' + error.message, 'error');
            }
        }
        
        // Post meme handler
        async function handlePostMeme() {
            const user = getCurrentUser();
            
            if (!user) {
                showNotification('Please sign in to post memes', 'error');
                return;
            }
            
            if (!window.generatedMemeBlob) {
                showNotification('Please generate a meme first', 'error');
                return;
            }
            
            const btn = document.getElementById('postMemeBtn');
            const titleInput = document.getElementById('memeTitle');
            const title = titleInput.value.trim();
            const postSection = document.getElementById('postMemeSection');
            
            btn.disabled = true;
            btn.textContent = 'Posting...';
            if (postSection) postSection.classList.add('loading');
            
            try {
                // Convert blob to base64
                showNotification('Converting image...', 'success');
                const base64 = await blobToBase64(window.generatedMemeBlob);
                
                // Post to InstantDB
                showNotification('Uploading to database...', 'success');
                const result = await postMeme(base64, title);
                
                if (result.error) {
                    let errorMsg = result.error;
                    // Check if it's a schema error
                    if (errorMsg.includes('Schema not synced') || errorMsg.includes('not found') || errorMsg.includes('does not exist')) {
                        errorMsg = 'Schema not synced. Please sync your InstantDB schema. See sync-schema.html for instructions.';
                    }
                    showNotification('Error: ' + errorMsg, 'error');
                } else {
                    showNotification('Meme posted successfully! Redirecting to feed...', 'success');
                    titleInput.value = '';
                    
                    // Redirect to feed after short delay
                    setTimeout(() => {
                        window.location.href = 'feed.php';
                    }, 1500);
                }
            } catch (error) {
                console.error('Post meme error:', error);
                showNotification('Error: ' + (error.message || 'Failed to post meme'), 'error');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Post Meme';
                if (postSection) postSection.classList.remove('loading');
            }
        }
        
        // Helper functions
        // Generate a unique ID
        function generateId() {
            if (typeof crypto !== 'undefined' && crypto.randomUUID) {
                return crypto.randomUUID();
            }
            // Fallback for older browsers
            return 'id_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        }
        
        function blobToBase64(blob) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onloadend = () => resolve(reader.result);
                reader.onerror = reject;
                reader.readAsDataURL(blob);
            });
        }
        
        async function postMeme(imageData, title = '') {
            const user = getCurrentUser();
            
            if (!user) {
                return { error: 'User must be authenticated to post memes' };
            }
            
            // Validate image data size (base64 can be large)
            if (imageData.length > 5000000) { // ~5MB limit
                return { error: 'Image is too large. Please use a smaller image.' };
            }
            
            try {
                console.log('Posting meme with user:', user);
                console.log('Image data length:', imageData.length);
                
                const memeId = generateId();
                const memeData = {
                    imageData: imageData,
                    title: title || null,
                    authorId: user.id,
                    authorEmail: user.email || (user.isGuest ? 'Guest' : 'User'),
                    createdAt: Date.now(),
                };
                
                console.log('Meme data to post:', { ...memeData, imageData: '[base64 data...]' });
                console.log('Available tx entities:', Object.keys(window.db.tx || {}));
                
                // Check if memes entity exists
                if (!window.db.tx || !window.db.tx.memes) {
                    console.error('memes entity not found in tx. Available:', Object.keys(window.db.tx || {}));
                    return { error: 'Schema not synced. Please sync your InstantDB schema. See sync-schema.html for instructions.' };
                }
                
                await window.db.transact(window.db.tx.memes[memeId].update(memeData));
                
                console.log('Meme posted successfully with ID:', memeId);
                return { success: true, memeId: memeId };
            } catch (error) {
                console.error('Post meme error:', error);
                console.error('Error details:', {
                    message: error.message,
                    stack: error.stack,
                    name: error.name,
                    error: error
                });
                
                let errorMessage = 'Failed to post meme';
                if (error.message) {
                    errorMessage = error.message;
                    // Check for schema-related errors
                    if (error.message.includes('not found') || error.message.includes('does not exist') || error.message.includes('schema')) {
                        errorMessage = 'Schema not synced. Please sync your InstantDB schema. The "memes" entity needs to be created in your InstantDB dashboard. See sync-schema.html for instructions.';
                    }
                } else if (error.toString) {
                    errorMessage = error.toString();
                }
                return { error: errorMessage };
            }
        }
        
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideIn 0.3s ease-out reverse';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }
        
        // Listen for auth state changes to show/hide post button
        // Use polling since onAuthStateChange doesn't exist
        function checkPostMemeSection() {
            const postSection = document.getElementById('postMemeSection');
            if (!postSection || !window.generatedMemeBlob) {
                if (postSection) postSection.classList.remove('show');
                return;
            }
            
            const user = getCurrentUser();
            if (user) {
                postSection.classList.add('show');
            } else {
                postSection.classList.remove('show');
            }
        }
        
        // Check post meme section periodically
        setInterval(checkPostMemeSection, 500);
        checkPostMemeSection(); // Initial check
        
        // Hide InstantDB default auth UI elements
        function hideInstantDBUI() {
            // Hide any InstantDB default UI elements
            const instantElements = document.querySelectorAll('[data-instant-auth], [id*="instant"], [class*="instant-auth"]');
            instantElements.forEach(el => {
                el.style.display = 'none';
                el.style.visibility = 'hidden';
            });
            
            // Hide any iframes from InstantDB
            const iframes = document.querySelectorAll('iframe');
            iframes.forEach(iframe => {
                if (iframe.src && iframe.src.includes('instant')) {
                    iframe.style.display = 'none';
                }
            });
        }
        
        // Run on page load and periodically
        setTimeout(hideInstantDBUI, 100);
        setInterval(hideInstantDBUI, 1000);
        
        // Check auth state on page load
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                if (window.db && window.db.auth && window.db.auth.currentUser && window.generatedMemeBlob) {
                    const postSection = document.getElementById('postMemeSection');
                    if (postSection) {
                        postSection.classList.add('show');
                    }
                }
            }, 1000);
        });
    </script>
</body>
</html>
