<?php
require_once 'config.php';

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
function logged_in()
{
    return isset($_SESSION['user']);
}
function is_admin()
{
    return logged_in() && $_SESSION['user']['role'] === 'admin';
}
function redirect($url)
{
    header("Location: $url");
    exit;
}
function flash($key, $message = null)
{
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return;
    }
    $message = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $message;
}
function require_login()
{
    if (!logged_in()) {
        flash('error', 'Please sign in to continue.');
        redirect('login.php');
    }
}
function require_admin()
{
    if (!is_admin()) {
        flash('error', 'Administrator access required.');
        redirect('index.php');
    }
}
function upload_image($field = 'image')
{
    if (empty($_FILES[$field]['name']) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE)
        return null;
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK || $_FILES[$field]['size'] > 3 * 1024 * 1024)
        return false;
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $type = mime_content_type($_FILES[$field]['tmp_name']);
    if (!isset($allowed[$type]))
        return false;
    $name = bin2hex(random_bytes(12)) . '.' . $allowed[$type];
    return move_uploaded_file($_FILES[$field]['tmp_name'], __DIR__ . '/uploads/' . $name) ? $name : false;
}
?>