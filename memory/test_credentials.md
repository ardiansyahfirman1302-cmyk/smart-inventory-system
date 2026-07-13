# Test Credentials — Smart Inventory AI

All demo accounts share the same password: `password`

| Role    | Email              | Password   | Purpose                       |
|---------|--------------------|------------|-------------------------------|
| Admin   | admin@demo.com     | password   | Full-access administrator     |
| Manager | manager@demo.com   | password   | Approval + reports focus      |
| Staff   | staff@demo.com     | password   | Data entry (transactions)     |

## Database (MariaDB)
- **Host**: 127.0.0.1:3306
- **Database**: `smart_inventory`
- **User**: `laravel`
- **Password**: `laravel_password`
- Root local access via socket: `mysql --socket=/var/run/mysqld/mysqld.sock` (no password)

## App URL
- **Preview**: https://6d0a9fd8-9f88-4efd-bc71-554482b9e070.preview.emergentagent.com
- **Local port 3000/8001**: same Laravel app (both serve /login /dashboard etc.)

## Notes
- Users are seeded via `UserSeeder` (idempotent — updateOrCreate).
- Roles are seeded via `RoleSeeder` (Admin, Manager, Staff — Spatie Permission).
- Demo data (products, suppliers, categories, stock transactions) is seeded via `DemoDataSeeder`.
