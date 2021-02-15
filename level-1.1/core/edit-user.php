<?php
session_start();
require "functions.php";

// Security if someone will open this page directly
check_if_post_not_empty($_POST, '../users.php');

// Extract all $_POST values with keys and create dynamic variables
extract($_POST, EXTR_OVERWRITE);

edit_user_information( $fullname, $position, $phone, $address, $edit_user_id);

set_flash_message('success', 'Профиль успешно обновлен.');
redirect_to('../users.php');