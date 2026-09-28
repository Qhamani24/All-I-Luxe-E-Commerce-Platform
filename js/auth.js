// ============================================
// AUTH — Login / Logout / Session
// ============================================

const AUTH_KEY = 'alliluxe_auth';

function initAuth() {
    // Check if on login page and already logged in
    const isLoginPage = document.getElementById('loginForm');
    const isDashboardPage = document.getElementById('listingsSection');
    
    const user = getCurrentUser();
    
    if (isLoginPage && user) {
        window.location.href = 'dashboard.html';
        return;
    }
    
    if (isDashboardPage && !user) {
        window.location.href = 'index.html';
        return;
    }
    
    if (isDashboardPage && user) {
        document.getElementById('sellerEmail').textContent = user.email;
    }
    
    if (isLoginPage) {
        document.getElementById('loginForm').addEventListener('submit', handleLogin);
    }
}

function handleLogin(e) {
    e.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    // Demo auth — in production, validate against backend
    const user = {
        email: email,
        id: 'seller_' + Date.now(),
        name: email.split('@')[0],
        loggedInAt: new Date().toISOString()
    };
    
    localStorage.setItem(AUTH_KEY, JSON.stringify(user));
    window.location.href = 'dashboard.html';
}

function getCurrentUser() {
    try {
        return JSON.parse(localStorage.getItem(AUTH_KEY));
    } catch {
        return null;
    }
}

function logout() {
    localStorage.removeItem(AUTH_KEY);
    window.location.href = 'index.html';
}

// Initialize on load
document.addEventListener('DOMContentLoaded', initAuth);