# CampusLost

A minimal PHP + MySQL college lost-and-found portal. Students can create accounts, post lost or found listings with photos, search listings, and submit claim requests. Admins can moderate listings.

## Run locally with XAMPP

1. Start **Apache** and **MySQL** from the XAMPP Control Panel.
2. Copy this `CampusLost` folder into `C:\xampp\htdocs\`.
3. Open `http://localhost/phpmyadmin`, select **Import**, and import `database.sql`.
4. Visit `http://localhost/CampusLost/` in your browser.
5. Register an account. To make it an admin, run the SQL statement at the end of `database.sql` in phpMyAdmin's SQL tab.

## Database tables

| Table | Purpose |
|---|---|
| `users` | Students and administrators |
| `items` | Lost, found, and returned items |
| `claims` | Ownership claim requests |

## Submission notes

Use the included `database.sql` for the DBMS portion. The relationship is `users → items → claims`; each item belongs to one user and can receive multiple claims.

For a live college deployment, add email verification, CSRF protection, rate limiting, and a private messaging system before publishing.
