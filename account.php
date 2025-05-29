<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$dbname = "users_db";
$conn = new mysqli($host, $user, $password, $dbname);

$userData = [
    'name' => 'User',
    'username' => 'username',
    'email' => 'user@example.com',
    'phone' => '',
    'created_at' => '2025'
];

if (!$conn->connect_error) {
    $stmt = $conn->prepare("SELECT name, username, email, phone, created_at FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($name, $username, $email, $phone, $created_at);
    if ($stmt->fetch()) {
        $userData = [
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'phone' => $phone,
            'created_at' => $created_at
        ];
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Account</title>
  <link rel="stylesheet" href="css/account.css" >
</head>
<body>
  <div class="wrapper">
    <form id="profileForm" action="update_profile.php" method="post" autocomplete="off">
      <div class="profile-header">
        <h1>
          Welcome,
          <span style="color:#fff;"><?= htmlspecialchars($userData['username']) ?></span>
          !
        </h1>
      </div>
      <div class="input-box">
        <span class="input-label">Username</span>
        <input class="edit-field" type="text" name="username" value="<?= htmlspecialchars($userData['username']) ?>" readonly required>
      </div>
      <div class="input-box">
        <span class="input-label">Email</span>
        <input class="edit-field" type="email" name="email" value="<?= htmlspecialchars($userData['email']) ?>" readonly required>
      </div>
      <div class="input-box">
        <span class="input-label">Phone</span>
        <input class="edit-field" type="text" name="phone" value="<?= htmlspecialchars($userData['phone']) ?>" readonly required>
      </div>
      <div class="input-box">
        <span class="input-label">Member since</span>
        <input class="edit-field" type="text" value="<?= htmlspecialchars($userData['created_at']) ?>" readonly disabled>
      </div>
      <div class="action-buttons">
        <button type="button" class="btn" id="editBtn" onclick="enableEdit()">Edit Profile</button>
        <button type="submit" class="btn" id="saveBtn" style="display:none;">Save</button>
        <button type="button" class="btn" id="cancelBtn" style="display:none;" onclick="cancelEdit()">Cancel</button>
        <button type="button" class="btn" onclick="togglePasswordForm()">Change Password</button>
      </div>
    </form>
    <form method="post" style="margin-top:10px;">
      <button type="submit" name="logout" class="btn logout">Logout</button>
    </form>
    <form class="password-form" id="passwordForm" action="change_password.php" method="post">
      <h3>Change Password</h3>
      <input type="password" name="old_password" placeholder="Current Password" required>
      <input type="password" name="new_password" placeholder="New Password" required>
      <button type="submit" class="btn">Update Password</button>
    </form>
    <div class="register-link">
      <p><a href="profile.php">Return</a></p>
    </div>
  </div>
  <script>
    let originalValues = {};
    function enableEdit() {
      document.querySelectorAll('.edit-field').forEach(function(input) {
        if (!input.disabled) {
          originalValues[input.name] = input.value;
          input.removeAttribute('readonly');
        }
      });
      document.getElementById('editBtn').style.display = 'none';
      document.getElementById('saveBtn').style.display = '';
      document.getElementById('cancelBtn').style.display = '';
    }
    function cancelEdit() {
      document.querySelectorAll('.edit-field').forEach(function(input) {
        if (originalValues[input.name] !== undefined) {
          input.value = originalValues[input.name];
          input.setAttribute('readonly', true);
        }
      });
      document.getElementById('editBtn').style.display = '';
      document.getElementById('saveBtn').style.display = 'none';
      document.getElementById('cancelBtn').style.display = 'none';
    }
    function togglePasswordForm() {
      const pf = document.getElementById('passwordForm');
      pf.style.display = pf.style.display === 'block' ? 'none' : 'block';
    }
  </script>
</body>
</html>