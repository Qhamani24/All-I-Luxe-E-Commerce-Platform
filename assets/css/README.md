# Stylesheets Directory (`assets/css/`)

This directory houses the CSS stylesheets responsible for the visual identity and layout of the **All I Luxe** platform.

---

## 🎨 Design System & Color Palette

The All I Luxe aesthetic is founded on high-contrast luxury minimalism, editorial typography, and warm metallic accents:

| Token / Color | Hex / Value | Description |
| :--- | :--- | :--- |
| **Primary Accent** | `#bfa14a` | Signature brushed gold accent for buttons, badges, highlights, and hovers. |
| **Dark Charcoal** | `#1a1a1a` / `#222222` | Core text, footer background, and strong editorial headers. |
| **Pure White** | `#ffffff` | Primary background, cards, and modal containers. |
| **Warm Neutral** | `#f8f7f5` / `#f4f1ea` | Subtle page section backgrounds, input fills, and borders. |
| **Border Gray** | `#e5e2dc` | Hairline borders for luxury card framing and form controls. |

### Typography Hierarchy
- **Headings & Accents**: `'Playfair Display', serif` & `'Cormorant Garamond', serif`
- **Body & Captions**: `'Lora', serif` & `'Montserrat', sans-serif`

---

## 📑 Stylesheet Registry

The 27 stylesheets are grouped into logical application domains:

### 1. Global & Landing
- `homePage.css`: Homepage hero carousel, navigation bar, curated categories, inspiration grid, and global footer.
- `aboutUsPageStyle.css`: Editorial heritage layout, values cards, and image showcase.
- `styleContactUsForm.css`: Contact page, responsive form grid, office locations, and social links.

### 2. Catalog & Product Detail
- `browseFurniture.css`: Main category catalog, promotional banners, and filter toggles.
- `shopBedroom.css`: Bedroom collection hero, suite cards, price badges, and card hover effects.
- `shopDining.css`: Dining furniture gallery, tables, chairs, credenzas, and luxury sets.
- `shopLounge.css`: Lounge suites, chaise lounges, coffee tables, and accent decor.
- `viewProduct.css`: Product detail page layout, thumbnail switcher, tabs, and specs table.

### 3. Shopping & Checkout
- `wishlist.css`: Saved item cards, remove buttons, and "Move to Cart" actions.
- `addToCart.css`: Cart item drawer/view, quantity steppers, subtotal summary.
- `payment.css`: Multi-step checkout, card input form, delivery options, security badges.
- `thankyou.css`: Order confirmation banner, order summary, and printable invoice styling.

### 4. Seller & Consignment
- `sellToUsPage.css`: Consignment marketing landing, process step cards, and FAQ accordion.
- `sellersDashboard.css`: Comprehensive seller portal, statistics counter, listing grid, and upload modal.
- `uploadFurniture.css`: Furniture upload form, photo dropzones, and condition selectors.

### 5. Authentication & Accounts
- `registrationStyle.css`: Split-screen login/register layout, input styling, Google auth button.
- `signupPage.css`: Customer registration form, terms agreement, password inputs.
- `adminLogin.css`: Dedicated administration login gate.
- `admin.css`: Admin control panel, statistics charts, pending approvals table, and order logs.

### 6. Informational & Legal
- `faq.css`: Interactive question and answer accordions.
- `shipping.css`: Delivery zones, white-glove delivery timelines, and transit insurance.
- `returns.css`: Return guidelines, refund criteria, and collection scheduling.
- `privacy.css`: Data protection notices, cookies, and POPIA / GDPR compliance clauses.
- `findLocation.css`: Showroom map layout, opening hours, and contact details.
- `homeConsultation.css`: In-home design consultation scheduling and form styling.
- `consultationSuccess.css`: Consultation booking acknowledgment screen.
- `evaluation.css`: Furniture valuation request form styling.

---

## 🛠️ Linking Example
```html
<link rel="stylesheet" href="assets/css/homePage.css">
```
