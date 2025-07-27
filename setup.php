<?php
    // this file is the set up wizard for the first creation of the admin 
    // It can be deleted when it' s done!

    require_once __DIR__ . '/models/Database.php';

    // Step 1: Check if an admin user already exists
    $pdo = Database::getInstance()->getConnection();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role_id = 1 ");
    $stmt->execute();
    $adminExists = $stmt->fetchColumn() > 0;    


    /*if ($adminExists) {
        // If an admin user already exists, redirect to the login page
        header("Location: /login.php");
        exit;
    }*/     

    // Step 2: Handle form submission for creating the admin user

    $errors = [];
    $success = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirmPassword = trim($_POST['confirm_password'] ?? '');

        // Basic validation
        if (!$name) $errors[] = "Name is required.";
        if (!$email) $errors[] = "Email is required.";
        if (!$password) $errors[] = "Password is required.";
        if (!$confirmPassword) $errors[] = "Confirm Password is required.";


        // Email validation
        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email address.";
        }

        // Check if email already exists
        if ($email) {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "Email already exists. Please use a different email.";
            }
        }

        // Password strength validation
        if ($password && strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }

        // Password match validation
        if ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }

        // If no errors, create the admin user
        if (empty($errors)) {
            // hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert Admin User
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, 1)");
            $stmt->execute([$name, $email, $hashedPassword]); 
            $success = true;

            // Simulate email (just display a message)
            $msg = "Admin account created!<br>An email would be sent to <strong>$email</strong> in production.<br><a href='index.php'>Login here</a>";
        }
    }
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Setup Wizard - Create Admin</title>
        <link rel="stylesheet" href="public/css/bootstrap.min.css">
    </head>
    <body class="container mt-5">
        <h2>Initial Setup — Create Admin Account</h2>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $msg ?></div>
        <?php else: ?>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                    <?php foreach ($errors as $e) echo "<li>$e</li>"; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form method="post" class="mt-4" autocomplete="off">
                <div class="mb-3">
                    <label>Name:</label>
                    <input class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label>Email:</label>
                    <input class="form-control" name="email" type="email" required>
                </div>
                <div class="mb-3">
                    <label>Password:</label>
                    <input class="form-control" name="password" type="password" required minlength="8">
                    <div class="form-text">Minimum 8 characters.</div>
                </div>
                <div class="mb-3">
                    <label>Password confirmation:</label>
                    <input class="form-control" name="confirm_password" type="password" required minlength="8">
                    <div class="form-text">Minimum 8 characters.</div>
                </div>
                <button class="btn btn-primary">Create Admin</button>
            </form>
        <?php endif; ?>
    </body>
</html>

