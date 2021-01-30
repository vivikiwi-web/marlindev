<?php
session_start();
require 'functions.php';

// Security if someone will open this page directly
check_if_post_not_empty($_POST, '../users.php');

// Extract all $_POST values with keys and create dynamic variables
extract($_POST, EXTR_OVERWRITE);

// Upload user avatar image
upload_avatar ( $_FILES['image'], $edit_user_id );

// Delete user old image
delete_avatar('../' . $edit_user_image);

// Set flash success message
set_flash_message('success', 'Профиль успешно добавлен.');

// Redirect to the user list page
redirect_to('../users.php');