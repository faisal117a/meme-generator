# InstantDB Setup Guide

This application uses InstantDB for database and authentication. Follow these steps to complete the setup:

## ⚠️ IMPORTANT: Schema Sync Required

**If you only see `$files` and `$users` in your InstantDB dashboard, you need to sync the schema first!**

The schema is defined in `instant.schema.js`, but it needs to be synced with InstantDB. You have three options:

### Option 1: Using InstantDB CLI (Recommended)
```bash
npm install -g @instantdb/cli
instant login
instant sync instant.schema.js --app-id 2cc27c95-cf7d-4fe7-9fe4-4c56c35cda96
```

### Option 2: Manual Setup via Dashboard
1. Go to [InstantDB Dashboard](https://www.instantdb.com/dashboard)
2. Select your app (App ID: `2cc27c95-cf7d-4fe7-9fe4-4c56c35cda96`)
3. Navigate to Schema section
4. Create the `memes` and `upvotes` entities manually (see details below)

### Option 3: Import Schema File
1. Copy content from `instant.schema.js`
2. Go to InstantDB Dashboard → Schema → Import
3. Paste the schema definition

See `sync-schema.html` for detailed instructions.

## 1. Schema Configuration

The schema is defined in `instant.schema.js`. This file defines:
- **memes** entity: Stores meme images (as base64), titles, author info, and timestamps
- **upvotes** entity: Tracks which users upvoted which memes

## 2. Permissions Setup

The schema file includes permission definitions, but you may need to configure them in the InstantDB dashboard:

1. Go to [InstantDB Dashboard](https://www.instantdb.com/dashboard)
2. Select your app (App ID: `2cc27c95-cf7d-4fe7-9fe4-4c56c35cda96`)
3. Navigate to the Schema/Permissions section
4. Ensure the following permissions are set:

### Memes Entity:
- **Read**: Everyone (public)
- **Create**: Authenticated users only
- **Update**: Author only (user.id === entity.authorId)
- **Delete**: Author only (user.id === entity.authorId)

### Upvotes Entity:
- **Read**: Everyone (public)
- **Create**: Authenticated users only
- **Update**: Disabled (upvotes cannot be changed)
- **Delete**: User can delete their own upvotes (user.id === entity.userId)

## 3. Authentication

The app supports two authentication methods:
- **Magic Code**: Users sign in with email and receive a code
- **Guest Auth**: Anonymous users can sign in as guests

Both methods require authentication before users can:
- Post memes
- Upvote memes

## 4. Testing

1. Start your PHP server (XAMPP, etc.)
2. Open `index.php` in your browser
3. Sign in (as guest or with email)
4. Create a meme using the generator
5. Click "Post Meme" to save it to InstantDB
6. Navigate to `feed.php` to see all posted memes
7. Try upvoting memes (requires authentication)

## 5. Troubleshooting

### Database not initialized
- Check that InstantDB SDK is loaded correctly
- Verify the App ID is correct: `2cc27c95-cf7d-4fe7-9fe4-4c56c35cda96`
- Check browser console for errors

### Permissions errors
- Verify permissions are set correctly in InstantDB dashboard
- Ensure users are authenticated before posting/upvoting
- Check that the schema matches the dashboard configuration

### Images not loading
- Base64 images can be large - check browser console for errors
- Ensure images are properly converted to base64
- Check InstantDB storage limits

### Real-time updates not working
- The app uses polling (every 3 seconds) as a fallback
- Check browser console for subscription errors
- Verify InstantDB connection is active

## 6. Notes

- Images are stored as base64 strings in InstantDB (not ideal for large images, but works for this implementation)
- The app polls for updates every 3 seconds if real-time subscriptions don't work
- Guest authentication allows users to try the app without creating an account
- All memes and upvotes are publicly readable, but only authenticated users can create them

