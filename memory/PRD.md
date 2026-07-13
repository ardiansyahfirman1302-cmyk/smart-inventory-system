# Smart Inventory AI — PRD

## Original Problem Statement
Existing Laravel 12 project "Smart Inventory AI" (Inventory & Asset Management System) with Breeze auth already installed. Continue development professionally with Clean Code + SOLID + Laravel Best Practices, Resource Controller, Form Request Validation, Eloquent Relationships, Reusable Blade Components, Responsive Design.

- **Theme**: Enterprise Dashboard, Dark Sidebar, Modern UI, Tailwind
- **Roles**: Admin, Staff, Manager
- **Modules**: Dashboard, Master Barang, Kategori, Supplier, Lokasi Gudang, Barang Masuk, Barang Keluar, Maintenance, Reports, Settings, AI Recommendation
- **DB**: MySQL/MariaDB with proper foreign keys + Eloquent relationships

## Architecture (as built)
- **Stack**: PHP 8.2 + Laravel 12 + Breeze + Spatie Permission + Blade + Tailwind CSS 3 + Alpine.js + Chart.js + Lucide Icons + MariaDB 10.11
- **Environment**: Emergent preview (PHP CLI serve on port 3000 & 8001). Bootstrap script re-installs PHP/MariaDB on container restart (`/app/scripts/bootstrap.sh`). MariaDB DB `smart_inventory`, user `laravel/laravel_password`.
- **Reverse Proxy**: TrustProxies configured in `bootstrap/app.php` to detect HTTPS via X-Forwarded-* headers.

## User Personas
1. **Admin** — full access, manages master data + all transactions
2. **Manager** — approval + reporting focus
3. **Staff** — data entry (stock in/out, maintenance)

## What's Been Implemented

### 2026-07-07 — MVP Task 1 (Dashboard Foundation)
- ✅ Environment: PHP 8.2 + Composer + MariaDB installed via bootstrap script (idempotent)
- ✅ Supervisor: `bootstrap`, `mariadb`, `backend` (port 8001), `frontend` (port 3000) all running Laravel
- ✅ TrustProxies + `URL::forceScheme('https')` for correct URL generation behind Emergent ingress
- ✅ Migrations for all future modules: `categories`, `suppliers`, `locations`, `products`, `stock_ins`, `stock_outs`, `maintenances` (with FK + indexes)
- ✅ Eloquent Models with relationships: `Category hasMany Products`, `Supplier hasMany Products+StockIns`, `Location hasMany Products`, `Product belongsTo Category/Supplier/Location, hasMany StockIn/StockOut/Maintenance`, `StockIn/StockOut/Maintenance belongsTo Product+User`
- ✅ Spatie Roles: Admin, Manager, Staff (RoleSeeder)
- ✅ Demo Users: admin@demo.com, manager@demo.com, staff@demo.com (all password: `password`)
- ✅ DemoDataSeeder: 5 categories, 4 suppliers, 3 locations, 12 products, 27 stock-ins, 23 stock-outs, 8 maintenances
- ✅ **Reusable Blade Components**: `x-sidebar` (dark), `x-topbar`, `x-stat-card`, `x-section-card`, `x-quick-action`, `x-ai-card`
- ✅ **Dashboard Layout**: Dark sidebar (fixed, 64 rem, gradient logo, module nav w/ active state, user card, logout), sticky top bar (title, date, notifications, avatar dropdown), main content area, footer
- ✅ **Dashboard Content**: 6 KPI cards (Total Barang/Supplier/Barang Masuk Hari Ini/Barang Keluar Hari Ini/Low Stock/Out of Stock w/ delta vs kemarin), Monthly Chart (Chart.js line, 6 months), AI Recommendation card (rule-based via `RecommendationService` — low stock, out of stock, fast mover, dead stock, urgent maintenance), 5 Quick Action buttons, Recent Stock In (5), Recent Stock Out (5), Low Stock list w/ progress bars
- ✅ **Branded Auth Pages**: Login, Register, Forgot Password redesigned with split layout (dark left panel featuring "Kendalikan stok, tingkatkan efisiensi." + feature bullets, right panel with modern form). Demo accounts hint on login. Password visibility toggle via Alpine.js.
- ✅ Testing subagent: 53/54 assertions PASSED (98% frontend). Only issue: HTML5 `required` attr blocks empty-form server validation (intended UX, not a bug).

### 2026-07-07 — Task 2 Complete: All 9 CRUD Modules
- ✅ **CRUD Barang** (Products): Controller + FormRequest + views (index w/ search+filter+pagination, create, edit, delete). Filter by category & stock status. Status badge (In Stock/Low Stock/Out of Stock).
- ✅ **CRUD Kategori**: Controller + FormRequest + views. Prevents delete when products still linked.
- ✅ **CRUD Supplier**: Controller + FormRequest + views. Search across code/name/contact/email.
- ✅ **CRUD Lokasi Gudang**: Controller + FormRequest + views.
- ✅ **Barang Masuk (Stock In)**: Controller + FormRequest + views. Auto reference_no (`IN-YYMMDD###`). **Atomic stock update via DB::transaction — increments product.stock on create, adjusts on edit, reverts on delete**.
- ✅ **Barang Keluar (Stock Out)**: Controller + FormRequest + views. Auto reference_no (`OUT-YYMMDD###`). **Validates stock availability via withValidator (prevents negative stock)**. Atomic stock decrement.
- ✅ **Maintenance**: Controller + FormRequest + views. Ticket status pipeline (pending→in_progress→completed/cancelled), priority (low/medium/high/urgent), auto-fill `completed_at` when status = completed, filters.
- ✅ **Reports**: KPI (Total In/Out qty, purchase value, mnt count) + Top-5 fast movers + stock-by-category chart + maintenance status distribution. Date range filter. Print CSS.
- ✅ **AI Recommendation Page**: Full dedicated page with hero AI card + Out-of-Stock list w/ direct "Restock →" link + Low Stock w/ progress bar + Dead Stock (>90 days) list.
- ✅ **Reusable Form Components**: `x-form-input`, `x-form-select`, `x-form-textarea`, `x-btn`, `x-toolbar`, `x-empty-state`, `x-status-badge` — used by every CRUD.
- ✅ **Sidebar**: All 10 modules now clickable (no more "soon" badges). Active state per route.
- ✅ **Pagination**: Tailwind pagination view published + `Paginator::useTailwind()`.
- ✅ **Localization**: Carbon setLocale('id') for Indonesian date formatting.
- ✅ Testing: 100% pass rate — all 75+ assertions across 9 CRUD flows, stock business logic verified.

## Prioritized Backlog

### P0 (Next Session — Sequential per user instruction)
- [ ] CRUD Barang (Products) — migration/model DONE, need Controller + FormRequest + Views + Route
- [ ] CRUD Kategori (Categories)
- [ ] CRUD Supplier
- [ ] CRUD Lokasi (Locations)

### P1
- [ ] Barang Masuk (Stock In) — transaction form + auto stock update
- [ ] Barang Keluar (Stock Out) — validation of available stock
- [ ] Maintenance ticket flow (status pipeline)

### P2
- [ ] Reports (export Excel/PDF, filter by period/category)
- [ ] AI Recommendation page (dedicated view expanding on dashboard card)
- [ ] Role-based access control middleware per module
- [ ] Settings page (app-level config, user management for Admin)

### Future Enhancements
- Upgrade AI from rule-based to **Gemini 3 Flash / GPT-5.2** via Emergent Universal Key (RecommendationService is ready to swap)
- Barcode/QR scanner integration
- Bulk import (CSV upload) for products
- Notification system (email when stock low)
- Multi-warehouse transfer module

## Test Credentials
See `/app/memory/test_credentials.md`

## Key File Locations
- **Controllers**: `/app/app/Http/Controllers/`
- **Models**: `/app/app/Models/`
- **Migrations**: `/app/database/migrations/`
- **Seeders**: `/app/database/seeders/`
- **Views**: `/app/resources/views/`
- **Components**: `/app/resources/views/components/`
- **Routes**: `/app/routes/web.php`
- **Bootstrap Scripts**: `/app/scripts/`
- **AI Service**: `/app/app/Services/RecommendationService.php`

## Access
- **Preview URL**: https://6d0a9fd8-9f88-4efd-bc71-554482b9e070.preview.emergentagent.com
- **/** → redirects to /login (guest) or /dashboard (authenticated)
- **/login** — branded Smart Inventory AI login
- **/dashboard** — main dashboard (auth required)
