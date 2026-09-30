# Client-Side JavaScript Directory (`assets/js/`)

This directory houses the client-side JavaScript modules powering the dynamic user experience, state management, and asynchronous workflows across **All I Luxe**.

---

## 📦 Script Inventory & Module Responsibilities

| Script | Responsibility | Primary Views |
| :--- | :--- | :--- |
| `auth.js` | Manages seller session persistence via `localStorage`, login state checks, and route protection. | `sellersdashboard.html`, login forms |
| `dashboard.js` | Renders dynamic seller inventory items, calculates active listings, handles item deletion and edit modals. | `sellersdashboard.html` |
| `upload.js` | Handles drag-and-drop / file input image previewing, photo count badges, and client-side form validation before upload. | `sellersdashboard.html`, `backend/products/uploadFurniture.php` |
| `addToCart.js` | Manages cart state in `localStorage`, updates navbar shopping cart badges, and calculates totals. | `addtoCart.html`, catalog pages |
| `contactUs.js` | Validates contact form inputs (name, email, phone format, message length) with real-time feedback. | `contactUs.html` |
| `aboutUs.js` | Controls the hero image slideshow carousel, thumbnail dots, and automated transitions. | `aboutUsPage.html` |
| `registration.js` | Client-side password match checks, mobile phone format validation, and terms checkbox enforcement. | `assignmentRegistration.html`, `signupPage.html` |

---

## 💾 State Persistence Pattern

Client interactions leverage browser `localStorage` for rapid, zero-latency state handling:

```javascript
// Auth Session Pattern (in auth.js)
const AUTH_KEY = 'alliluxe_auth';
const user = {
    email: 'seller@alliluxe.com',
    id: 'seller_1710000000',
    name: 'Seller Name',
    loggedInAt: new Date().toISOString()
};
localStorage.setItem(AUTH_KEY, JSON.stringify(user));
```

---

## 🔒 Security Best Practices

1. **Client-Side vs. Server-Side Validation**:
   Client scripts validate user input for immediate visual feedback, while backend PHP endpoints (`backend/auth/`) perform strict server-side validation and sanitization.
2. **Graceful Degradation**:
   If a script fails or JavaScript is disabled, semantic HTML form actions (`<form action="backend/auth/..." method="post">`) allow forms to still submit safely to the server.
