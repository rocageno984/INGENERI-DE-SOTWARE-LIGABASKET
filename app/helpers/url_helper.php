<?php

// Simple page redirect
function redirect($page) {
    header('location: ' . URL_BASE . $page);
}
