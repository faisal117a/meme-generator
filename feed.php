<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meme Feed</title>
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
        }

        .header {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            border: none;
            font-family: inherit;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: var(--bg-section);
            color: var(--text-primary);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--border);
        }

        .auth-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-info {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .user-email {
            font-weight: 600;
            color: var(--text-primary);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px;
        }

        .memes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
            margin-top: 24px;
        }

        .meme-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .meme-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .meme-image {
            width: 100%;
            height: auto;
            display: block;
            max-height: 500px;
            object-fit: contain;
            background: var(--bg-section);
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .meme-image:hover {
            transform: scale(1.02);
        }

        .meme-info {
            padding: 16px;
        }

        .meme-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .meme-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .meme-author {
            font-weight: 500;
        }

        .meme-date {
            color: var(--text-light);
        }

        .meme-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .delete-btn {
            padding: 8px 12px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
        }
        
        .delete-btn svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }
        
        .delete-btn:hover {
            background: #dc2626;
            transform: scale(1.05);
        }
        
        .delete-btn:active {
            transform: scale(0.95);
        }
        
        .delete-btn:focus {
            outline: 2px solid #ef4444;
            outline-offset: 2px;
        }

        .upvote-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: var(--bg-section);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--text-primary);
        }

        .upvote-btn:hover:not(:disabled) {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .upvote-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .upvote-btn.upvoted {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .upvote-count {
            font-weight: 700;
        }

        .empty-state {
            text-align: center;
            padding: 80px 24px;
            color: var(--text-light);
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state-text {
            font-size: 1.125rem;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .empty-state-subtext {
            font-size: 0.875rem;
            color: var(--text-light);
        }

        .loading {
            text-align: center;
            padding: 80px 24px;
            color: var(--text-secondary);
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

        /* Fullscreen Modal */
        .fullscreen-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            z-index: 1000;
            cursor: pointer;
            animation: fadeIn 0.3s ease;
        }

        .fullscreen-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fullscreen-content {
            position: relative;
            max-width: 95%;
            max-height: 95%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .fullscreen-image {
            max-width: 100%;
            max-height: 90vh;
            object-fit: contain;
            border-radius: var(--radius);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
        }

        .fullscreen-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            font-size: 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .fullscreen-close:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: rotate(90deg);
        }

        .fullscreen-info {
            margin-top: 20px;
            text-align: center;
            color: white;
            max-width: 600px;
        }

        .fullscreen-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .fullscreen-meta {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .fullscreen-actions {
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .fullscreen-upvote-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            color: white;
        }

        .fullscreen-upvote-btn:hover:not(:disabled) {
            background: var(--primary);
            border-color: var(--primary);
            transform: scale(1.05);
        }

        .fullscreen-upvote-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .fullscreen-upvote-btn.upvoted {
            background: var(--primary);
            border-color: var(--primary);
        }

        .fullscreen-upvote-count {
            font-weight: 700;
            font-size: 1.125rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .fullscreen-image {
                max-height: 85vh;
            }

            .fullscreen-close {
                top: 10px;
                right: 10px;
                width: 40px;
                height: 40px;
                font-size: 20px;
            }

            .fullscreen-title {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 768px) {
            .memes-grid {
                grid-template-columns: 1fr;
                gap: 16px;
                margin-top: 16px;
            }

            .header {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
                padding: 16px;
            }
            
            .header h1 {
                font-size: 1.25rem;
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
                gap: 12px;
            }
            
            .btn {
                padding: 8px 16px;
                font-size: 0.8rem;
                width: 100%;
                text-align: center;
            }

            .auth-section {
                width: 100%;
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            
            .user-info {
                width: 100%;
            }
            
            .container {
                padding: 16px;
            }
            
            .meme-card {
                border-radius: 8px;
            }
            
            .meme-info {
                padding: 12px;
            }
            
            .meme-title {
                font-size: 0.9rem;
            }
            
            .meme-meta {
                font-size: 0.75rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }
            
            .upvote-btn {
                padding: 6px 12px;
                font-size: 0.8rem;
            }
        }
        
        @media (max-width: 480px) {
            .header {
                padding: 12px;
            }
            
            .header h1 {
                font-size: 1.1rem;
            }
            
            .container {
                padding: 12px;
            }
            
            .memes-grid {
                gap: 12px;
            }
            
            .meme-image {
                max-height: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Meme Feed</h1>
        <div class="header-actions">
            <a href="index.php" class="btn btn-primary">Create Meme</a>
            <div class="auth-section" id="authSection">
                <div id="loginForm" style="display: none;">
                    <button class="btn btn-secondary" onclick="handleGuestSignIn()">Sign In as Guest</button>
                </div>
                <div class="user-info" id="userInfo" style="display: none;">
                    <span>Signed in as: <span class="user-email"></span></span>
                    <button class="btn btn-secondary" onclick="handleSignOut()" style="margin-top: 8px;">Sign Out</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="loadingState" class="loading">Loading memes...</div>
        <div id="emptyState" class="empty-state" style="display: none;">
            <div class="empty-state-icon">🖼️</div>
            <div class="empty-state-text">No memes yet</div>
            <div class="empty-state-subtext">Be the first to create and post a meme!</div>
        </div>
        <div id="memesGrid" class="memes-grid"></div>
    </div>

    <!-- Fullscreen Modal -->
    <div id="fullscreenModal" class="fullscreen-modal">
        <div class="fullscreen-content">
            <button class="fullscreen-close" onclick="closeFullscreen()" aria-label="Close">×</button>
            <img id="fullscreenImage" class="fullscreen-image" src="" alt="">
            <div class="fullscreen-info">
                <div id="fullscreenTitle" class="fullscreen-title"></div>
                <div id="fullscreenMeta" class="fullscreen-meta"></div>
                <div class="fullscreen-actions">
                    <button id="fullscreenUpvoteBtn" class="fullscreen-upvote-btn" onclick="handleFullscreenUpvote()">
                        <span>👍</span>
                        <span id="fullscreenUpvoteCount" class="fullscreen-upvote-count">0</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- InstantDB SDK -->
    <script type="module">
        // Use React SDK (works for vanilla JS too)
        import { init } from 'https://esm.sh/@instantdb/react@latest';
        
        const APP_ID = '2cc27c95-cf7d-4fe7-9fe4-4c56c35cda96';
        window.db = init({ appId: APP_ID });
        
        let memesData = [];
        let upvotesData = [];
        
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
        
        // Generate a unique ID
        function generateId() {
            if (typeof crypto !== 'undefined' && crypto.randomUUID) {
                return crypto.randomUUID();
            }
            // Fallback for older browsers
            return 'id_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        }
        
        // Update auth UI
        function updateAuthUI() {
            const user = getCurrentUser();
            
            const authSection = document.getElementById('authSection');
            const userInfo = document.getElementById('userInfo');
            const loginForm = document.getElementById('loginForm');
            
            if (!authSection) return;
            
            if (user) {
                if (loginForm) loginForm.style.display = 'none';
                if (userInfo) {
                    userInfo.style.display = 'block';
                    const emailSpan = userInfo.querySelector('.user-email');
                    if (emailSpan) {
                        emailSpan.textContent = user.email || (user.isGuest ? 'Guest User' : user.id || 'User');
                    }
                }
            } else {
                if (loginForm) loginForm.style.display = 'block';
                if (userInfo) userInfo.style.display = 'none';
            }
        }
        
        // Auth handlers
        async function handleGuestSignIn() {
            const btn = event.target;
            btn.disabled = true;
            btn.textContent = 'Signing in...';
            
            try {
                // Use signInAsGuest instead of signInAnonymously
                await window.db.auth.signInAsGuest();
                showNotification('Signed in as guest', 'success');
            } catch (error) {
                showNotification('Error: ' + (error.message || 'Failed to sign in as guest'), 'error');
                btn.disabled = false;
                btn.textContent = 'Sign In as Guest';
            }
        }
        
        async function handleSignOut() {
            try {
                await window.db.auth.signOut();
                showNotification('Signed out successfully', 'success');
                renderMemes();
            } catch (error) {
                showNotification('Error signing out: ' + error.message, 'error');
            }
        }
        
        window.handleGuestSignIn = handleGuestSignIn;
        window.handleSignOut = handleSignOut;
        
        // Define query
        // Note: createdAt might not be indexed, so we'll fetch all and sort in JS
        const query = {
            memes: {},
            upvotes: {},
        };
        
        // Load memes and upvotes using queryOnce
        async function loadMemes() {
            if (!window.db) {
                console.error('Database not initialized');
                const loadingState = document.getElementById('loadingState');
                if (loadingState) {
                    loadingState.textContent = 'Database not initialized. Please refresh the page.';
                }
                return;
            }
            
            // Use queryOnce method for one-time queries
            if (window.db.queryOnce) {
                console.log('Calling queryOnce with query:', query);
                return window.db.queryOnce(query).then((result) => {
                    console.log('QueryOnce result:', result);
                    console.log('QueryOnce result type:', typeof result);
                    console.log('QueryOnce result keys:', result ? Object.keys(result) : 'null');
                    
                    // Handle query result
                    let memes = [];
                    let upvotes = [];
                    
                    if (result) {
                        // Check result.data first (queryOnce returns {data: {...}})
                        const data = result.data || result;
                        
                        console.log('Data object:', data);
                        console.log('Data.memes:', data.memes);
                        console.log('Data.upvotes:', data.upvotes);
                        
                        if (data.memes) {
                            memes = Array.isArray(data.memes) ? data.memes : Object.values(data.memes || {});
                            console.log('Processed memes array length:', memes.length);
                        }
                        if (data.upvotes) {
                            upvotes = Array.isArray(data.upvotes) ? data.upvotes : Object.values(data.upvotes || {});
                            console.log('Processed upvotes array length:', upvotes.length);
                        }
                    } else {
                        console.log('Result is null or undefined');
                    }
                    
                    // Sort memes by createdAt (newest first) in JavaScript
                    memes.sort((a, b) => {
                        const timeA = a.createdAt || 0;
                        const timeB = b.createdAt || 0;
                        return timeB - timeA; // Descending order (newest first)
                    });
                    
                    memesData = memes;
                    upvotesData = upvotes;
                    
                    console.log('Loaded memes:', memesData.length, 'upvotes:', upvotesData.length);
                    console.log('First meme sample:', memesData[0]);
                    
                    renderMemes();
                }).catch((error) => {
                    console.error('Error loading memes:', error);
                    console.error('Error details:', {
                        message: error.message,
                        stack: error.stack,
                        name: error.name,
                        error: error
                    });
                    
                    const errorMsg = error.message || 'Unknown error';
                    
                    // Check if it's a schema error
                    if (errorMsg.includes('not found') || errorMsg.includes('does not exist') || errorMsg.includes('memes')) {
                        const loadingState = document.getElementById('loadingState');
                        if (loadingState) {
                            loadingState.innerHTML = 'Schema not synced. Please sync your InstantDB schema to create the "memes" and "upvotes" entities. <a href="sync-schema.html" style="color: #ff6b35; text-decoration: underline;">See instructions</a>';
                            loadingState.style.color = '#ef4444';
                        }
                    } else {
                        showNotification('Error loading memes: ' + errorMsg, 'error');
                        const loadingState = document.getElementById('loadingState');
                        if (loadingState) {
                            loadingState.textContent = 'Error loading memes. Please try refreshing the page.';
                            loadingState.style.color = '#ef4444';
                        }
                    }
                    
                    memesData = [];
                    upvotesData = [];
                    renderMemes();
                });
            } else {
                return Promise.resolve();
                console.error('queryOnce not available. Available methods:', Object.keys(window.db));
                const loadingState = document.getElementById('loadingState');
                if (loadingState) {
                    loadingState.textContent = 'Unable to query database. Please check InstantDB setup.';
                    loadingState.style.color = '#ef4444';
                }
            }
        }
        
        // Try to use core for subscriptions if available
        let unsubscribeFn = null;
        try {
            if (window.db && window.db.core) {
                // Try to access the core database for subscriptions
                const core = window.db.core || window.db._core;
                if (core && core.subscribe) {
                    unsubscribeFn = core.subscribe(query, (data) => {
                        console.log('Subscription data received:', data);
                        if (data) {
                            let memes = [];
                            let upvotes = [];
                            
                            if (data.memes) {
                                memes = Array.isArray(data.memes) ? data.memes : Object.values(data.memes || {});
                            }
                            if (data.upvotes) {
                                upvotes = Array.isArray(data.upvotes) ? data.upvotes : Object.values(data.upvotes || {});
                            }
                            
                            memesData = memes;
                            upvotesData = upvotes;
                            console.log('Subscription updated memes:', memesData.length);
                            renderMemes();
                        }
                    });
                    console.log('Subscription set up successfully');
                } else {
                    console.log('Core subscription not available, using polling');
                }
            } else {
                console.log('Core not available for subscription, using polling');
            }
        } catch (error) {
            console.log('Subscription not available, using polling:', error);
        }
        
        // Initial load
        loadMemes();
        
        // Refresh every 3 seconds as fallback
        const refreshInterval = setInterval(() => {
            loadMemes();
        }, 3000);
        
        // Render memes
        function renderMemes() {
            const loadingState = document.getElementById('loadingState');
            const emptyState = document.getElementById('emptyState');
            const memesGrid = document.getElementById('memesGrid');
            
            // Hide loading state
            if (loadingState) loadingState.style.display = 'none';
            
            console.log('Rendering memes. memesData:', memesData);
            console.log('memesData type:', Array.isArray(memesData) ? 'array' : typeof memesData);
            console.log('memesData length:', memesData ? (Array.isArray(memesData) ? memesData.length : Object.keys(memesData).length) : 0);
            
            // Ensure memesData is an array
            let memesArray = memesData;
            if (!Array.isArray(memesData)) {
                if (memesData && typeof memesData === 'object') {
                    memesArray = Object.values(memesData);
                } else {
                    memesArray = [];
                }
            }
            
            // Check if we have data
            if (!memesArray || memesArray.length === 0) {
                console.log('No memes to render, showing empty state');
                if (emptyState) emptyState.style.display = 'block';
                if (memesGrid) memesGrid.innerHTML = '';
                return;
            }
            
            console.log('Rendering', memesArray.length, 'memes');
            
            // Hide empty state
            if (emptyState) emptyState.style.display = 'none';
            
            const currentUser = getCurrentUser();
            const userId = currentUser ? currentUser.id : null;
            
            if (!memesGrid) return;
            
            try {
                memesGrid.innerHTML = memesArray.map(meme => {
                    if (!meme) {
                        console.warn('Empty meme object found');
                        return '';
                    }
                    
                    // Handle meme ID - could be in meme.id or as object key
                    const memeId = meme.id || meme._id;
                    if (!memeId) {
                        console.warn('Meme without ID:', meme);
                        return '';
                    }
                    
                    // Ensure upvotesData is an array
                    let upvotesArray = upvotesData;
                    if (!Array.isArray(upvotesData)) {
                        if (upvotesData && typeof upvotesData === 'object') {
                            upvotesArray = Object.values(upvotesData);
                        } else {
                            upvotesArray = [];
                        }
                    }
                    
                    const memeUpvotes = (upvotesArray || []).filter(u => u && (u.memeId === memeId || u.memeId === meme.id));
                    const upvoteCount = memeUpvotes.length;
                    const hasUpvoted = userId && memeUpvotes.some(u => u.userId === userId);
                    
                    let dateStr = 'Unknown date';
                    try {
                        if (meme.createdAt) {
                            const date = new Date(meme.createdAt);
                            dateStr = date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        }
                    } catch (e) {
                        console.error('Date parsing error:', e);
                    }
                    
                    const imageSrc = meme.imageData || '';
                    const title = meme.title || '';
                    const authorEmail = meme.authorEmail || 'Unknown';
                    const maskedEmail = maskEmail(authorEmail);
                    const isAuthor = userId && meme.authorId === userId;
                    
                    // Escape data for data attributes
                    const escapedImageSrc = imageSrc.replace(/'/g, "&#39;").replace(/"/g, "&quot;");
                    const escapedTitle = escapeHtml(title).replace(/'/g, "&#39;").replace(/"/g, "&quot;");
                    const escapedAuthor = escapeHtml(authorEmail).replace(/'/g, "&#39;").replace(/"/g, "&quot;");
                    const escapedDate = dateStr.replace(/'/g, "&#39;").replace(/"/g, "&quot;");
                    const escapedMemeId = escapeHtml(memeId).replace(/'/g, "&#39;").replace(/"/g, "&quot;");
                    
                    return `
                        <div class="meme-card">
                            <img src="${imageSrc}" alt="${escapeHtml(title || 'Meme')}" class="meme-image" loading="lazy" 
                                 data-image-src="${escapedImageSrc}" 
                                 data-title="${escapedTitle}" 
                                 data-author="${escapedAuthor}" 
                                 data-date="${escapedDate}"
                                 data-meme-id="${escapedMemeId}"
                                 data-upvote-count="${upvoteCount}"
                                 data-has-upvoted="${hasUpvoted ? 'true' : 'false'}"
                                 onclick="openFullscreenFromElement(this)" 
                                 onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22300%22%3E%3Crect fill=%22%23ddd%22 width=%22400%22 height=%22300%22/%3E%3Ctext fill=%22%23999%22 font-family=%22sans-serif%22 font-size=%2218%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22%3EImage failed to load%3C/text%3E%3C/svg%3E';">
                            <div class="meme-info">
                                ${title ? `<div class="meme-title">${escapeHtml(title)}</div>` : ''}
                                <div class="meme-meta">
                                    <span class="meme-author">by ${escapeHtml(maskedEmail)}</span>
                                    <span class="meme-date">${dateStr}</span>
                                </div>
                                <div class="meme-actions">
                                    <button class="upvote-btn ${hasUpvoted ? 'upvoted' : ''}" 
                                            onclick="handleUpvote('${escapeHtml(memeId)}', ${hasUpvoted})" 
                                            ${!userId ? 'disabled title="Sign in to upvote"' : ''}
                                            title="${hasUpvoted ? 'Click to remove upvote' : 'Upvote this meme'}">
                                        <span>👍</span>
                                        <span class="upvote-count">${upvoteCount}</span>
                                    </button>
                                    ${isAuthor ? `<button class="delete-btn" onclick="handleDeleteMeme('${escapeHtml(memeId)}')" title="Delete your meme" aria-label="Delete meme">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 6h18"></path>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </button>` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                }).filter(html => html).join('');
            } catch (error) {
                console.error('Error rendering memes:', error);
                if (memesGrid) {
                    memesGrid.innerHTML = '<div class="empty-state"><div class="empty-state-text">Error loading memes</div></div>';
                }
            }
        }
        
        // Upvote handler - now supports toggle (remove upvote if already upvoted)
        async function handleUpvote(memeId, isAlreadyUpvoted = false) {
            const user = getCurrentUser();
            
            if (!user) {
                showNotification('Please sign in to upvote memes', 'error');
                return;
            }
            
            // Ensure upvotesData is an array
            let upvotesArray = upvotesData;
            if (!Array.isArray(upvotesData)) {
                if (upvotesData && typeof upvotesData === 'object') {
                    upvotesArray = Object.values(upvotesData);
                } else {
                    upvotesArray = [];
                }
            }
            
            // Check if already upvoted
            const existingUpvote = upvotesArray.find(u => u && u.memeId === memeId && u.userId === user.id);
            
            // If already upvoted, remove the upvote (toggle off)
            if (existingUpvote || isAlreadyUpvoted) {
                try {
                    const upvoteId = existingUpvote ? (existingUpvote.id || existingUpvote._id) : null;
                    if (!upvoteId) {
                        // Try to find by matching memeId and userId
                        const allUpvotes = await window.db.queryOnce({ upvotes: {} });
                        const upvotesDataObj = allUpvotes.data || allUpvotes;
                        const upvotesList = Array.isArray(upvotesDataObj.upvotes) ? upvotesDataObj.upvotes : Object.values(upvotesDataObj.upvotes || {});
                        const foundUpvote = upvotesList.find(u => u && u.memeId === memeId && u.userId === user.id);
                        if (foundUpvote) {
                            await window.db.transact(window.db.tx.upvotes[foundUpvote.id || foundUpvote._id].delete());
                        } else {
                            showNotification('Upvote not found', 'error');
                            return;
                        }
                    } else {
                        await window.db.transact(window.db.tx.upvotes[upvoteId].delete());
                    }
                    
                    await loadMemes();
                    showNotification('Upvote removed', 'success');
                    return;
                } catch (error) {
                    console.error('Error removing upvote:', error);
                    showNotification('Error removing upvote: ' + (error.message || 'Unknown error'), 'error');
                    return;
                }
            }
            
            // Disable button and show loading
            const btn = event.target.closest('.upvote-btn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span>⏳</span><span class="upvote-count">...</span>';
            
            try {
                const upvoteId = generateId();
                const upvoteData = {
                    memeId: memeId,
                    userId: user.id,
                    createdAt: Date.now(),
                };
                
                await window.db.transact(window.db.tx.upvotes[upvoteId].update(upvoteData));
                
                // Reload data to get updated counts
                await loadMemes();
                
                // Update fullscreen modal if it's open and showing this meme
                if (currentFullscreenMemeId === memeId) {
                    const currentMeme = memesData.find(m => (m.id || m._id) === memeId);
                    if (currentMeme) {
                        const currentUser = getCurrentUser();
                        const userId = currentUser ? currentUser.id : null;
                        
                        // Ensure upvotesData is an array
                        let upvotesArray = upvotesData;
                        if (!Array.isArray(upvotesData)) {
                            if (upvotesData && typeof upvotesData === 'object') {
                                upvotesArray = Object.values(upvotesData);
                            } else {
                                upvotesArray = [];
                            }
                        }
                        
                        const memeUpvotes = (upvotesArray || []).filter(u => u && (u.memeId === memeId));
                        const upvoteCount = memeUpvotes.length;
                        const hasUpvoted = user && memeUpvotes.some(u => u.userId === user.id);
                        
                        const fullscreenUpvoteBtn = document.getElementById('fullscreenUpvoteBtn');
                        const fullscreenUpvoteCount = document.getElementById('fullscreenUpvoteCount');
                        
                        if (fullscreenUpvoteBtn && fullscreenUpvoteCount) {
                            fullscreenUpvoteCount.textContent = upvoteCount;
                            
                            if (hasUpvoted) {
                                fullscreenUpvoteBtn.classList.add('upvoted');
                                fullscreenUpvoteBtn.disabled = true;
                                fullscreenUpvoteBtn.title = 'You already upvoted this';
                            } else {
                                fullscreenUpvoteBtn.classList.remove('upvoted');
                                fullscreenUpvoteBtn.disabled = !userId;
                            }
                        }
                    }
                }
                
                showNotification('Upvoted!', 'success');
            } catch (error) {
                console.error('Upvote error:', error);
                btn.disabled = false;
                btn.innerHTML = originalText;
                let errorMessage = 'Failed to upvote';
                if (error.message) {
                    errorMessage = error.message;
                }
                showNotification('Error: ' + errorMessage, 'error');
            }
        }
        
        // Delete meme handler
        async function handleDeleteMeme(memeId) {
            const user = getCurrentUser();
            
            if (!user) {
                showNotification('Please sign in to delete memes', 'error');
                return;
            }
            
            // Confirm deletion
            if (!confirm('Are you sure you want to delete this meme? This action cannot be undone.')) {
                return;
            }
            
            try {
                // Delete the meme
                await window.db.transact(window.db.tx.memes[memeId].delete());
                
                // Also delete all upvotes for this meme
                const allUpvotes = await window.db.queryOnce({ upvotes: {} });
                const upvotesDataObj = allUpvotes.data || allUpvotes;
                const upvotesList = Array.isArray(upvotesDataObj.upvotes) ? upvotesDataObj.upvotes : Object.values(upvotesDataObj.upvotes || {});
                const memeUpvotes = upvotesList.filter(u => u && u.memeId === memeId);
                
                // Delete all upvotes for this meme
                for (const upvote of memeUpvotes) {
                    const upvoteId = upvote.id || upvote._id;
                    if (upvoteId) {
                        await window.db.transact(window.db.tx.upvotes[upvoteId].delete());
                    }
                }
                
                // Close fullscreen if showing this meme
                if (currentFullscreenMemeId === memeId) {
                    closeFullscreen();
                }
                
                // Reload memes
                await loadMemes();
                showNotification('Meme deleted successfully', 'success');
            } catch (error) {
                console.error('Delete meme error:', error);
                showNotification('Error deleting meme: ' + (error.message || 'Unknown error'), 'error');
            }
        }
        
        window.handleUpvote = handleUpvote;
        window.handleDeleteMeme = handleDeleteMeme;
        
        // Store current fullscreen meme ID for upvoting
        let currentFullscreenMemeId = null;
        
        // Fullscreen modal functions
        function openFullscreenFromElement(imgElement) {
            const imageSrc = imgElement.getAttribute('data-image-src') || imgElement.src;
            const title = imgElement.getAttribute('data-title') || '';
            const authorEmail = imgElement.getAttribute('data-author') || 'Unknown';
            const dateStr = imgElement.getAttribute('data-date') || '';
            const memeId = imgElement.getAttribute('data-meme-id') || '';
            const upvoteCount = parseInt(imgElement.getAttribute('data-upvote-count') || '0', 10);
            const hasUpvoted = imgElement.getAttribute('data-has-upvoted') === 'true';
            
            openFullscreen(imageSrc, title, authorEmail, dateStr, memeId, upvoteCount, hasUpvoted);
        }
        
        function openFullscreen(imageSrc, title, authorEmail, dateStr, memeId, upvoteCount, hasUpvoted) {
            const modal = document.getElementById('fullscreenModal');
            const fullscreenImage = document.getElementById('fullscreenImage');
            const fullscreenTitle = document.getElementById('fullscreenTitle');
            const fullscreenMeta = document.getElementById('fullscreenMeta');
            const fullscreenUpvoteBtn = document.getElementById('fullscreenUpvoteBtn');
            const fullscreenUpvoteCount = document.getElementById('fullscreenUpvoteCount');
            
            if (modal && fullscreenImage) {
                // Store meme ID for upvoting
                currentFullscreenMemeId = memeId;
                
                fullscreenImage.src = imageSrc;
                fullscreenImage.alt = title || 'Meme';
                
                if (fullscreenTitle) {
                    fullscreenTitle.textContent = title || '';
                    fullscreenTitle.style.display = title ? 'block' : 'none';
                }
                
                if (fullscreenMeta) {
                    const maskedEmail = maskEmail(authorEmail);
                    fullscreenMeta.textContent = `by ${maskedEmail} • ${dateStr}`;
                }
                
                // Update upvote button
                if (fullscreenUpvoteBtn && fullscreenUpvoteCount) {
                    const currentUser = getCurrentUser();
                    const userId = currentUser ? currentUser.id : null;
                    
                    fullscreenUpvoteCount.textContent = upvoteCount;
                    
                    // Update button state
                    if (hasUpvoted) {
                        fullscreenUpvoteBtn.classList.add('upvoted');
                        fullscreenUpvoteBtn.disabled = true;
                        fullscreenUpvoteBtn.title = 'You already upvoted this';
                    } else {
                        fullscreenUpvoteBtn.classList.remove('upvoted');
                        fullscreenUpvoteBtn.disabled = !userId;
                        fullscreenUpvoteBtn.title = userId ? 'Upvote this meme' : 'Sign in to upvote';
                    }
                }
                
                modal.classList.add('active');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }
        }
        
        // Handle upvote from fullscreen modal
        async function handleFullscreenUpvote() {
            if (!currentFullscreenMemeId) {
                return;
            }
            
            const user = getCurrentUser();
            
            if (!user) {
                showNotification('Please sign in to upvote memes', 'error');
                return;
            }
            
            // Ensure upvotesData is an array
            let upvotesArray = upvotesData;
            if (!Array.isArray(upvotesData)) {
                if (upvotesData && typeof upvotesData === 'object') {
                    upvotesArray = Object.values(upvotesData);
                } else {
                    upvotesArray = [];
                }
            }
            
            // Get button elements first
            const fullscreenUpvoteBtn = document.getElementById('fullscreenUpvoteBtn');
            const fullscreenUpvoteCount = document.getElementById('fullscreenUpvoteCount');
            
            // Check if already upvoted - if so, remove it (toggle)
            const existingUpvote = upvotesArray.find(u => u && u.memeId === currentFullscreenMemeId && u.userId === user.id);
            if (existingUpvote) {
                // Remove upvote
                if (fullscreenUpvoteBtn) {
                    const originalHTML = fullscreenUpvoteBtn.innerHTML;
                    fullscreenUpvoteBtn.disabled = true;
                    fullscreenUpvoteBtn.innerHTML = '<span>⏳</span><span class="fullscreen-upvote-count">...</span>';
                    
                    try {
                        const upvoteId = existingUpvote.id || existingUpvote._id;
                        if (upvoteId) {
                            await window.db.transact(window.db.tx.upvotes[upvoteId].delete());
                        } else {
                            // Try to find by matching memeId and userId
                            const allUpvotes = await window.db.queryOnce({ upvotes: {} });
                            const upvotesDataObj = allUpvotes.data || allUpvotes;
                            const upvotesList = Array.isArray(upvotesDataObj.upvotes) ? upvotesDataObj.upvotes : Object.values(upvotesDataObj.upvotes || {});
                            const foundUpvote = upvotesList.find(u => u && u.memeId === currentFullscreenMemeId && u.userId === user.id);
                            if (foundUpvote) {
                                await window.db.transact(window.db.tx.upvotes[foundUpvote.id || foundUpvote._id].delete());
                            }
                        }
                        
                        await loadMemes();
                        await new Promise(resolve => setTimeout(resolve, 100));
                        
                        // Update fullscreen modal
                        let updatedUpvotesArray = upvotesData;
                        if (!Array.isArray(upvotesData)) {
                            if (upvotesData && typeof upvotesData === 'object') {
                                updatedUpvotesArray = Object.values(upvotesData);
                            } else {
                                updatedUpvotesArray = [];
                            }
                        }
                        const memeUpvotes = updatedUpvotesArray.filter(u => u && u.memeId === currentFullscreenMemeId);
                        const upvoteCount = memeUpvotes.length;
                        
                        if (fullscreenUpvoteBtn && fullscreenUpvoteCount) {
                            fullscreenUpvoteCount.textContent = upvoteCount;
                            fullscreenUpvoteBtn.classList.remove('upvoted');
                            fullscreenUpvoteBtn.disabled = false;
                            fullscreenUpvoteBtn.title = 'Upvote this meme';
                        }
                        
                        showNotification('Upvote removed', 'success');
                    } catch (error) {
                        console.error('Error removing upvote:', error);
                        if (fullscreenUpvoteBtn) {
                            fullscreenUpvoteBtn.disabled = false;
                            fullscreenUpvoteBtn.innerHTML = originalHTML;
                        }
                        showNotification('Error removing upvote: ' + (error.message || 'Unknown error'), 'error');
                    }
                }
                return;
            }
            
            // Disable button and show loading
            
            if (fullscreenUpvoteBtn) {
                const originalHTML = fullscreenUpvoteBtn.innerHTML;
                fullscreenUpvoteBtn.disabled = true;
                fullscreenUpvoteBtn.innerHTML = '<span>⏳</span><span class="fullscreen-upvote-count">...</span>';
                
                try {
                    // If not removing (existingUpvote was handled above), add new upvote
                    if (!existingUpvote) {
                        const upvoteId = generateId();
                        const upvoteData = {
                            memeId: currentFullscreenMemeId,
                            userId: user.id,
                            createdAt: Date.now(),
                        };
                        
                        await window.db.transact(window.db.tx.upvotes[upvoteId].update(upvoteData));
                    }
                    
                    // Reload data to get updated counts
                    await loadMemes();
                    
                    // Wait a moment for data to update
                    await new Promise(resolve => setTimeout(resolve, 100));
                    
                    // Update fullscreen modal with new vote count
                    // Ensure upvotesData is an array (re-fetched)
                    let updatedUpvotesArray = upvotesData;
                    if (!Array.isArray(upvotesData)) {
                        if (upvotesData && typeof upvotesData === 'object') {
                            updatedUpvotesArray = Object.values(upvotesData);
                        } else {
                            updatedUpvotesArray = [];
                        }
                    }
                    
                    const memeUpvotes = (updatedUpvotesArray || []).filter(u => {
                        if (!u) return false;
                        // Handle both string and object ID formats
                        const uMemeId = u.memeId || u.meme_id;
                        return uMemeId === currentFullscreenMemeId;
                    });
                    
                    const upvoteCount = memeUpvotes.length;
                    const hasUpvoted = user && memeUpvotes.some(u => {
                        const uUserId = u.userId || u.user_id;
                        return uUserId === user.id;
                    });
                    
                    if (fullscreenUpvoteBtn && fullscreenUpvoteCount) {
                        fullscreenUpvoteCount.textContent = upvoteCount;
                        
                        if (hasUpvoted) {
                            fullscreenUpvoteBtn.classList.add('upvoted');
                            fullscreenUpvoteBtn.disabled = false; // Allow toggle
                            fullscreenUpvoteBtn.title = 'Click to remove upvote';
                        } else {
                            fullscreenUpvoteBtn.classList.remove('upvoted');
                            fullscreenUpvoteBtn.disabled = !user;
                            fullscreenUpvoteBtn.title = user ? 'Upvote this meme' : 'Sign in to upvote';
                        }
                    }
                    
                    showNotification(existingUpvote ? 'Upvote removed' : 'Upvoted!', 'success');
                } catch (error) {
                    console.error('Upvote error:', error);
                    console.error('Error details:', {
                        message: error.message,
                        stack: error.stack,
                        name: error.name,
                        error: error
                    });
                    
                    if (fullscreenUpvoteBtn) {
                        fullscreenUpvoteBtn.disabled = false;
                        fullscreenUpvoteBtn.innerHTML = originalHTML;
                    }
                    
                    let errorMessage = 'Failed to upvote';
                    if (error.message) {
                        errorMessage = error.message;
                    }
                    showNotification('Error: ' + errorMessage, 'error');
                }
            } else {
                console.error('Fullscreen upvote button not found');
                showNotification('Error: Upvote button not found', 'error');
            }
        }
        
        function closeFullscreen() {
            const modal = document.getElementById('fullscreenModal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = ''; // Restore scrolling
            }
        }
        
        window.openFullscreen = openFullscreen;
        window.openFullscreenFromElement = openFullscreenFromElement;
        window.closeFullscreen = closeFullscreen;
        window.handleFullscreenUpvote = handleFullscreenUpvote;
        window.maskEmail = maskEmail;
        
        // Close modal on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeFullscreen();
            }
        });
        
        // Close modal when clicking on the background (not on the image or content)
        function setupModalClickHandler() {
            const modal = document.getElementById('fullscreenModal');
            if (modal) {
                modal.addEventListener('click', (e) => {
                    // Close if clicking directly on the modal background (not on content or image)
                    if (e.target.id === 'fullscreenModal') {
                        closeFullscreen();
                    }
                });
            }
        }
        
        // Set up click handler when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setupModalClickHandler);
        } else {
            setupModalClickHandler();
        }
        
        // Helper functions
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        // Mask email address - show first 3-6 characters deterministically based on email hash
        function maskEmail(email) {
            if (!email || email === 'Unknown' || email === 'Guest') {
                return email;
            }
            
            const atIndex = email.indexOf('@');
            if (atIndex === -1) {
                return email; // Not a valid email format
            }
            
            const localPart = email.substring(0, atIndex);
            const domain = email.substring(atIndex);
            
            // Use a simple hash of the email to deterministically choose chars to show (3-6)
            // This ensures the same email always shows the same number of characters
            let hash = 0;
            for (let i = 0; i < email.length; i++) {
                hash = ((hash << 5) - hash) + email.charCodeAt(i);
                hash = hash & hash; // Convert to 32bit integer
            }
            const charsToShow = (Math.abs(hash) % 4) + 3; // 3-6 characters, consistent for same email
            const visiblePart = localPart.substring(0, Math.min(charsToShow, localPart.length));
            const maskedPart = '*'.repeat(Math.max(0, localPart.length - charsToShow));
            
            return visiblePart + maskedPart + domain;
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
        
        // InstantDB React SDK doesn't have onAuthStateChange
        // Use polling to check auth state changes
        let lastAuthState = null;
        function checkAuthState() {
            const currentUser = getCurrentUser();
            
            // Check if auth state changed
            const authChanged = JSON.stringify(currentUser) !== JSON.stringify(lastAuthState);
            if (authChanged) {
                lastAuthState = currentUser ? JSON.parse(JSON.stringify(currentUser)) : null;
                updateAuthUI();
                renderMemes();
            }
        }
        
        // Poll for auth state changes every 500ms
        setInterval(checkAuthState, 500);
        checkAuthState(); // Initial check
        
        // Initial UI update
        updateAuthUI();
        
        // Dark mode synchronization
        const htmlElement = document.documentElement;
        
        // Load saved theme preference or default to light
        const savedTheme = localStorage.getItem('theme') || 'light';
        htmlElement.setAttribute('data-theme', savedTheme);
        
        // Listen for theme changes from other pages
        window.addEventListener('storage', function(e) {
            if (e.key === 'theme') {
                const newTheme = e.newValue || 'light';
                htmlElement.setAttribute('data-theme', newTheme);
            }
        });
        
        // Also check theme on focus (in case localStorage was changed in another tab)
        window.addEventListener('focus', function() {
            const currentTheme = localStorage.getItem('theme') || 'light';
            htmlElement.setAttribute('data-theme', currentTheme);
        });
    </script>
</body>
</html>

