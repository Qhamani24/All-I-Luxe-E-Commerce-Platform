# All I Luxe — System Architecture & Site Map

This document provides a comprehensive technical overview of the system architecture, component relationships, user workflows, and navigation hierarchy of the **All I Luxe** platform.

---

## 🏛️ System Architecture

```mermaid
graph TD
    Client["Client Web Browser<br/>(Desktop, Tablet, Mobile)"]
    
    subgraph Frontend["Front-End Presentation Layer"]
        Views["Semantic HTML5 Views<br/>(Catalog, Cart, Checkout, Info)"]
        Styles["CSS3 Modular Stylesheets<br/>(assets/css/)"]
        Scripts["Vanilla JavaScript Modules<br/>(assets/js/)"]
        Storage["Browser localStorage<br/>(Auth tokens, Cart items, Wishlist count)"]
    end
    
    subgraph Backend["Server-Side & Data Layer (backend/)"]
        AuthModule["Authentication Endpoints<br/>(userLogin.php, sellerLogin.php)"]
        AdminModule["Admin Panel & Approvals<br/>(admin.php, adminLogin.php)"]
        ProductsModule["Product & File Uploads<br/>(uploadFurniture.php, uploadImages.php)"]
        DBConfig["Centralized DB Module<br/>(backend/config/db.php)"]
    end
    
    Database[("MySQL / MariaDB<br/>(users, sellers, furniture, orders)")]
    
    Client --> Views
    Views --> Styles
    Views --> Scripts
    Scripts <--> Storage
    Views -- "Form Submissions / POST" --> AuthModule
    Views -- "Upload Media" --> ProductsModule
    
    AuthModule --> DBConfig
    AdminModule --> DBConfig
    ProductsModule --> DBConfig
    DBConfig --> Database
```

---

## 🗺️ Sitemap & Page Hierarchy

```
Homepage (index.html)
│
├── Catalog & Product Discovery
│   ├── Browse All Categories (browseFurniture.html)
│   ├── Shop Bedroom (shopBedroom.html)
│   │   ├── Product View: Vivian Suite (viewProduct.html)
│   │   └── Product View: Monarch Suite (viewProductMonarch.html)
│   ├── Shop Dining (shopDining.html)
│   └── Shop Lounge (shopLounge.html)
│       ├── Product View: Aurora Lounge (viewProductAuroraLounge.html)
│       ├── Product View: Nest Chair (viewProductNestChair.html)
│       ├── Product View: Valentina Corner (viewProductValentinaCorner.html)
│       └── Product View: Velvet Luxury Sofa (viewVelvetSofa.html)
│
├── Customer Transactions & Cart
│   ├── Saved Items (wishlist.html)
│   ├── Shopping Cart (addtoCart.html)
│   ├── Payment & Checkout (payment.html)
│   └── Order Confirmation & Invoice (thankyou.html)
│
├── Consignment & Seller Portal
│   ├── Sell to Us Landing (sellToUsPage.html)
│   ├── Seller Onboarding Registration (backend/products/sellersSignUpPage.php)
│   ├── Seller Dashboard (sellersdashboard.html)
│   └── Furniture Upload Portal (backend/products/uploadFurniture.php)
│
├── Customer Accounts & Auth
│   ├── Login Portal (assignmentRegistration.html)
│   └── Customer Registration (signupPage.html)
│
├── White-Glove Support & Services
│   ├── In-Home Consultation (homeConsultation.html)
│   ├── Consultation Confirmation (consultationSuccess.html)
│   ├── Furniture Valuation (evaluation.html)
│   └── Showroom Locator (findLocation.html)
│
├── Legal & Customer Care
│   ├── About Us (aboutUsPage.html)
│   ├── Contact Us (contactUs.html)
│   ├── FAQs (faq.html)
│   ├── Shipping & Delivery (shipping.html)
│   ├── Returns Policy (returns.html)
│   └── Privacy Policy (privacy.html)
│
└── Administration Portal (backend/admin/)
    ├── Admin Gate (adminLogin.php)
    └── Admin Management Dashboard (admin.php)
```

---

## 🔄 User State & Lifecycle

```mermaid
stateDiagram-v2
    [*] --> Guest
    
    Guest --> Browsing : View Catalog & Details
    Browsing --> CartActive : Add Item to Cart
    CartActive --> Checkout : Proceed to Payment
    Checkout --> OrderComplete : Submit Payment (thankyou.html)
    OrderComplete --> [*]
    
    Guest --> RegisteredCustomer : Register (signupPage.html)
    Guest --> SellerAccount : Apply to Sell (sellersSignUpPage.php)
    
    RegisteredCustomer --> CustomerSession : Login (assignmentRegistration.html)
    CustomerSession --> Browsing : Personalised Experience
    
    SellerAccount --> SellerDashboard : Login (auth.js / sellerLogin.php)
    SellerDashboard --> AddListing : Submit Photos & Details
    AddListing --> PendingAdminApproval : Awaiting Verification
    
    AdminUser --> AdminPortal : Login (adminLogin.php)
    AdminPortal --> ReviewListings : Approve / Reject
    ReviewListings --> ActiveStoreCatalog : Listed Live in Catalog
```
