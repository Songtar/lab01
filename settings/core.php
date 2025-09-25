if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(){
    if (!isset($_SESSION['user_id'])) {
        return false;
    } else {
        return true;
    }
}


function isAdmin(){
    if (isLoggedIn()) {
        return $_SESSION['user_role'] == 1;
    }
}