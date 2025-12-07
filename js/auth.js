// Authentication logic using InstantDB
// This file provides helper functions for authentication
// The actual InstantDB initialization happens in the HTML files

// Check if user is authenticated
function isAuthenticated() {
    return window.db && window.db.auth && window.db.auth.currentUser !== null;
}

// Get current user
function getUser() {
    return window.db && window.db.auth ? window.db.auth.currentUser : null;
}

