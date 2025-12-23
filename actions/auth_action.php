<?php
include_once('../config/db.php');

// ==========================================
// 1. USER REGISTRATION LOGIC
// ==========================================
if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    // Default values for new users
    $role = 'user'; 
    $status = 'active';

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "Email already registered!";
        header("Location: ../register.php");
    } else {
        // Status column database mein hona lazmi hai
        $query = "INSERT INTO users (username, email, password, role, status) VALUES ('$username', '$email', '$password', '$role', '$status')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['success'] = "Registration successful! Please login.";
            header("Location: ../login.php");
        } else {
            $_SESSION['error'] = "Something went wrong. Try again.";
            header("Location: ../register.php");
        }
    }
    exit();
}

// ==========================================
// 2. USER LOGIN LOGIC (With Blocked Status Check)
// ==========================================
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Password Verification
        if (password_verify($password, $user['password'])) {
            
            // --- CRITICAL FIX: Account Status Check ---
            if (isset($user['status']) && $user['status'] == 'blocked') {
                $_SESSION['error'] = "ACCESS DENIED: Your account has been blocked by the Administrator.";
                header("Location: ../login.php");
                exit();
            }

            // Set Sessions if not blocked
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Role-based Redirection
            if ($user['role'] == 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../user/dashboard.php");
            }
        } else {
            $_SESSION['error'] = "Incorrect password!";
            header("Location: ../login.php");
        }
    } else {
        $_SESSION['error'] = "No account found with this email!";
        header("Location: ../login.php");
    }
    exit();
}

// ==========================================
// 3. PROFILE UPDATE LOGIC (Username & Picture)
// ==========================================
if (isset($_POST['update_profile'])) {
    if(!isset($_SESSION['user_id'])) { exit("Unauthorized"); }
    
    $user_id = $_SESSION['user_id'];
    $new_username = mysqli_real_escape_string($conn, $_POST['username']);
    
    // Handle Profile Picture Upload
    if (!empty($_FILES['profile_pic']['name'])) {
        $img_name = time() . '_' . $_FILES['profile_pic']['name'];
        $target = "../uploads/profiles/" . $img_name;
        
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target)) {
            // Update image in database
            mysqli_query($conn, "UPDATE users SET profile_pic = '$img_name' WHERE id = '$user_id'");
        }
    }
    
    // Update Username
    $update_user = "UPDATE users SET username = '$new_username' WHERE id = '$user_id'";
    if (mysqli_query($conn, $update_user)) {
        $_SESSION['username'] = $new_username; // Session refresh
        $_SESSION['success'] = "Profile updated successfully!";
        
        // Redirect back to correct dashboard based on role
        if($_SESSION['role'] == 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../user/dashboard.php");
        }
    } else {
        $_SESSION['error'] = "Failed to update profile.";
        header("Location: ../user/profile-settings.php");
    }
    exit();
}

// ==========================================
// 4. PASSWORD RECOVERY (FORGOT PASSWORD)
// ==========================================
if (isset($_POST['forgot_password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        header("Location: ../reset-password.php?email=$email");
    } else {
        $_SESSION['error'] = "Email not found in our records.";
        header("Location: ../forgot-password.php");
    }
    exit();
}

// ==========================================
// 5. PASSWORD RESET (ACTUAL UPDATE)
// ==========================================
if (isset($_POST['reset_password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($new_pass === $confirm_pass) {
        $hashed_password = password_hash($new_pass, PASSWORD_BCRYPT);
        $update_query = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
        
        if (mysqli_query($conn, $update_query)) {
            $_SESSION['success'] = "Password reset successful! Please login.";
            header("Location: ../login.php");
        } else {
            $_SESSION['error'] = "Database error. Could not update password.";
            header("Location: ../reset-password.php?email=$email");
        }
    } else {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: ../reset-password.php?email=$email");
    }
    exit();
}
?>