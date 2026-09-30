# Assets Directory — All I Luxe

This directory consolidates all client-side static resources for the **All I Luxe** platform, partitioned by resource type into three distinct subdirectories:

```
assets/
├── css/         # Modular CSS stylesheets for layouts, components, and pages
├── js/          # Client-side JavaScript modules and interactive features
└── images/      # Product images, marketing hero graphics, and payment icons
```

---

## 📂 Subdirectory Overview

| Subdirectory | Description | Documentation |
| :--- | :--- | :--- |
| [`css/`](css/) | Contains all 27 component and page stylesheets, color palettes, and typography configurations. | [CSS Guide](css/README.md) |
| [`js/`](js/) | Houses modular JavaScript scripts handling user authentication, seller dashboard state, cart calculation, and UI interactions. | [JS Guide](js/README.md) |
| [`images/`](images/) | Master media repository containing high-resolution furniture suite photographs, hero banners, and brand icons. | [Image Catalog](images/README.md) |

---

## 🔗 Standard Path Linking Conventions

To maintain consistency and portability across servers and environments, always adhere to the following relative linking conventions:

### From Root HTML Files (`index.html`, `shopBedroom.html`, etc.)
```html
<!-- Stylesheet link -->
<link rel="stylesheet" href="assets/css/homePage.css">

<!-- Script tag -->
<script src="assets/js/addToCart.js"></script>

<!-- Image source -->
<img src="assets/images/bedroomHero.jpg" alt="Luxury Bedroom Suite">
```

### From Stylesheets in `assets/css/`
Stylesheets referencing images must traverse up one level to the sibling directory:
```css
/* In assets/css/homePage.css */
.bedroom {
  background-image: url("../images/homepageBedroomDesign.jpg");
}
```

### From Backend Scripts in `backend/products/` or `backend/admin/`
Backend PHP templates that output HTML views must traverse up two levels:
```html
<link rel="stylesheet" href="../../assets/css/admin.css">
<script src="../../assets/js/dashboard.js"></script>
```

---

## 🎨 Asset Optimization Standards

- **Images**:
  - Always compress images to balance high visual fidelity with rapid page load speeds.
  - Recommended dimensions for product suite cards: minimum 600px width.
  - Standard formats: `.jpg` for photography, `.png` for icons requiring transparency, `.webp` for modern web delivery.
- **CSS**:
  - Maintain consistent class naming (`kebab-case`).
  - Rely on global gold accents (`#bfa14a`) and neutral darks (`#222`, `#333`) to preserve the luxury design identity.
- **JavaScript**:
  - Ensure error boundaries (e.g. `try/catch` around `localStorage` parsing) so missing stored data fails gracefully.
