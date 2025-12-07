# ⚠️ CRITICAL: Schema Sync Required

## Problem
Your InstantDB dashboard only shows `$files` and `$users` because the **custom schema hasn't been synced yet**. 

Without syncing the schema, the app cannot:
- Store memes in the database
- Store upvotes
- Display memes on the feed

## Quick Fix (Choose One Method)

### Method 1: InstantDB CLI (Fastest - Recommended)

1. Open terminal/command prompt
2. Run these commands:

```bash
npm install -g @instantdb/cli
instant login
cd d:\xampp\htdocs\cursor2
instant sync instant.schema.js --app-id 2cc27c95-cf7d-4fe7-9fe4-4c56c35cda96
```

### Method 2: Manual Dashboard Setup

1. Go to https://www.instantdb.com/dashboard
2. Login and select your app (ID: `2cc27c95-cf7d-4fe7-9fe4-4c56c35cda96`)
3. Click "Schema" in the sidebar
4. Click "Add Entity" and create:

**Entity 1: `memes`**
- Fields:
  - `imageData` (string, required)
  - `title` (string, optional)
  - `authorId` (string, required)
  - `authorEmail` (string, required)
  - `createdAt` (number, required)

**Entity 2: `upvotes`**
- Fields:
  - `memeId` (string, required)
  - `userId` (string, required)
  - `createdAt` (number, required)

5. Set permissions (see `instant.schema.js` for details)

### Method 3: Copy-Paste Schema

1. Open `instant.schema.js` in your editor
2. Copy the entire file content
3. Go to InstantDB Dashboard → Schema → Import
4. Paste the schema code

## After Syncing

Once synced, you should see:
- ✅ `$files` (system)
- ✅ `$users` (system)
- ✅ `memes` (your custom entity)
- ✅ `upvotes` (your custom entity)

Then the app will work correctly!

## Testing

After syncing:
1. Sign in (guest or email)
2. Generate a meme
3. Click "Post Meme"
4. Go to feed.php
5. You should see your meme!

