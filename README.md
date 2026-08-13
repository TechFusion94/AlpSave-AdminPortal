# AlpSave, Admin Portal

A role-based admin dashboard for AlpSave, a fictional Swiss fintech platform. Built as a self-contained PHP application to manage users, pricing plans, and uploaded assets behind an authenticated, permission-aware interface.

## Overview

Where the main AlpSave site is the public-facing landing page, the Admin Portal is the internal tool AlpSave's team would use to run the business day to day: onboarding staff accounts, adjusting pricing plans, and managing uploaded media. The focus of this project was backend fundamentals: authentication, session handling, role-based permissions, and safe interaction with a relational database, all built from scratch in PHP without a framework.

## Screenshots

![AlpSave Admin Portal demo](storage/site/assets/screenshots/AlpSave-AdminPortal.gif)

## Features

- **Authentication**: Session-based login with password hashing (bcrypt) and CSRF-protected forms
- **Role-based access control**: Four roles (Super Admin, Admin, Data Manager, Read Only) with distinct capabilities, checked server-side before any sensitive action
- **Multi-step registration**: Three-step account creation flow with per-step validation, profile photo upload, and live field feedback
- **User management**: View, list, and manage registered accounts, with role assignment restricted to authorized users
- **Pricing management**: Create, edit, and remove pricing plans that feed the public site's pricing page
- **Data uploads**: Image upload with server-side MIME type, extension, and size validation, stored in date-partitioned folders with unique filenames
- **Dashboard overview**: At-a-glance stats for total users, uploads, and pricing plans, plus a feed of recent registrations

## Tech Stack

- **Backend**: PHP 8.4 (vanilla, no framework)
- **Database**: MySQL 8.4, accessed via PDO with prepared statements throughout
- **Server**: Apache (via Docker)
- **Admin tooling**: phpMyAdmin
- **Frontend**: HTML, CSS (no JS framework)
- **Infrastructure**: Docker Compose (web, database, and phpMyAdmin services)

The project intentionally avoids a PHP framework to build a solid understanding of routing, sessions, and database access at the language level before relying on abstractions.

## Getting Started

This project runs via Docker Compose.

1. Clone the repository
2. Create a `.env` file in the project root with the following variables, then fill in your own values:
   ```
   PROJECT_NAME=
   WEB_PORT=
   PMA_PORT=
   MYSQL_DATABASE=
   MYSQL_ROOT_PASSWORD=
   MYSQL_USER=
   MYSQL_PASSWORD=
   ```
3. Start the stack:
   ```bash
   docker compose up -d
   ```
4. The app is available at `http://localhost:<WEB_PORT>` and phpMyAdmin at `http://localhost:<PMA_PORT>`
5. Import `storage/site/data/dump.sql` via phpMyAdmin (or the MySQL CLI) to seed the database with demo users and pricing plans
6. Log in with the seeded demo account:

   | Username | Password |
   |----------|----------|
   | `testadmin` | `Test1234!` |

   This account has the Super Admin role, so it has full access to every area of the portal.

## Project Structure

```
AlpSave-AdminPortal/
├── config/                  Apache and PHP configuration overrides
├── docker/                  Dockerfile and entrypoint for the web service
├── docker-compose.yml       Service definitions: web, db, phpMyAdmin
└── storage/
    ├── logs/                Apache logs (runtime, not tracked)
    └── site/                Application root
        ├── assets/          CSS, fonts, images
        ├── class/            Core classes: Database, User, Role, Pricing, Upload, FileUpload, Csrf
        ├── data/             SQL dump for seeding the database
        ├── scripts/          Page controllers (login, register, dashboard, pricing, users, dataupload)
        ├── uploads/          User-uploaded files (runtime, not tracked)
        ├── views/            Page templates
        ├── config.php        App configuration
        ├── index.php         Front controller
        └── validate.php      Shared validation logic
```

## Security Notes

- Passwords are hashed with bcrypt and never stored or logged in plain text
- All database queries use prepared statements to prevent SQL injection
- Forms are protected against CSRF via per-session tokens
- Uploaded files are validated by MIME type, extension, and size before being moved into storage
- Environment-specific secrets (database credentials, ports) are kept in `.env`, excluded from version control

## Design & Credits

Design system and branding shared with the main AlpSave site, created in Figma. Fonts: [Inter](https://fonts.google.com/specimen/Inter) and [Share Tech](https://fonts.google.com/specimen/Share+Tech) (Google Fonts, OFL licensed).

---

Built by **Luca Meier** as part of the Backend Development module at SAE Institute.
