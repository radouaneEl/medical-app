# Medical Consultations Management

A simple PHP MVC web application for doctors and admins to manage medical consultations.

---

## About

This project aims to provide a clean, secure, and responsive web application for:
- Doctors: record and track their consultations (type, date, amount)
- Admin: overview all consultations and access statistics

Built with:
- PHP (native, MVC)
- MySQL
- Bootstrap

**Work in progress — main structure and database setup completed.**

---

## Project Structure

```plaintext
medical-app/
│
├── index.php
├── config/
├── controllers/
├── models/
├── views/
├── public/
├── assets/
└── README.md

## Configuration

1. Copy `/config/database.example.php` to `/config/database.php`
2. Edit `/config/database.php` with your local MySQL credentials


## How to run

1. Clone the repo  
   `git clone https://github.com/radoncode/medical-app.git`

2. Set up the database (see `/config/database.php`)

3. Start your Apache/MySQL server (XAMPP, LAMP, etc.)

4. Access [http://localhost/medical-app](http://localhost/medical-app)

## Initial Setup — Admin Account Creation

On first launch, the application provides a setup wizard (`setup.php`) that allows you to create the initial admin account, only if no admin user exists yet.  
This ensures secure onboarding and prevents public self-registration.

**Important:**  
Before using the setup wizard, make sure the `roles` table is seeded with at least the following entries:

**sql Insertion **
INSERT INTO roles (id, name) VALUES
    (1, 'admin'),
    (2, 'doctor');

If not, you may encounter a foreign key constraint error when creating the first user.

Once the admin account is created, the setup wizard is automatically disabled and all users must log in via the standard login page (index.php).

Tip: For demo/testing, you can delete or rename setup.php after use for extra security.


## Contact

Feel free to contact me on LinkedIn: https://www.linkedin.com/in/radouane-elbouni/
