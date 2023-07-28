<?php

/**
 * Display the Login page form
 * 
 * @param array $data: The data from login validation
 */
function showLoginPage($data) {
    echo   '<h1>Login</h1>
            <form action="index.php" method="POST">
                <input type="hidden" name="page" value="login">

                <label for="email">Email</label>
                <br>
                <input type="email" name="email" value="' . getValue($data, "email") . '">
                ' . showError($data, "email") . '
                ' . showError($data, "no_existing_user") . '
                <br>

                <label for="password">Password</label>
                <br>
                <input type="password" name="password" value="' . getValue($data, "password") . '">
                ' . showError($data, "password") . '
                <br>
                ' . showError($data, "authentication") . '
                <br>

                <input class="submit" type="submit" value="Sign In">
            </form>';
}