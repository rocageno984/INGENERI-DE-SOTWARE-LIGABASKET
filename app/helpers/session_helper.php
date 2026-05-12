<?php
session_start();

// Flash message helper
function flash($name = '', $message = '', $class = 'success') {
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }

            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : 'success';
            $msg = $_SESSION[$name];
            
            // Map common alert classes to toast types
            $type = 'success';
            if (strpos($class, 'danger') !== false) $type = 'danger';
            if (strpos($class, 'warning') !== false) $type = 'warning';
            
            echo "<script>
                document.addEventListener('DOMContentLoaded', () => {
                    if (window.showToast) {
                        window.showToast('$msg', '$type');
                    }
                });
            </script>";
            
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}

function isLoggedIn() {
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}
