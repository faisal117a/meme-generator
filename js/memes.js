// Meme posting and upvote logic
// Helper functions for meme operations
// The actual InstantDB database instance is accessed via window.db

// Generate a unique ID
function generateId() {
    if (typeof crypto !== 'undefined' && crypto.randomUUID) {
        return crypto.randomUUID();
    }
    // Fallback for older browsers
    return 'id_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
}

// Convert blob to base64
function blobToBase64(blob) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onloadend = () => resolve(reader.result);
        reader.onerror = reject;
        reader.readAsDataURL(blob);
    });
}

// Post meme to InstantDB
async function postMeme(imageData, title = '') {
    if (!window.db) {
        return { error: 'Database not initialized' };
    }
    
    const user = window.db.auth.currentUser;
    if (!user) {
        return { error: 'User must be authenticated to post memes' };
    }
    
    try {
        const memeId = generateId();
        const memeData = {
            imageData: imageData,
            title: title.trim() || null,
            authorId: user.id,
            authorEmail: user.email || 'Guest',
            createdAt: Date.now(),
        };
        
        await window.db.transact(window.db.tx.memes[memeId].update(memeData));
        
        return { success: true };
    } catch (error) {
        console.error('Post meme error:', error);
        return { error: error.message };
    }
}

// Get upvote count for a meme
function getUpvoteCount(memeId, upvotesData) {
    if (!upvotesData || !upvotesData.upvotes) return 0;
    return upvotesData.upvotes.filter(upvote => upvote.memeId === memeId).length;
}

