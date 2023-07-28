<?php

/**
 * Display the Register page form
 * 
 * @param array $data: The data from register form validation
 */
function showRegisterPage($data) {
    echo   '<h1>Registration</h1>
            <form action="index.php" method="POST">
                <input type="hidden" name="page" value="register">

                <label for="email">Email</label>
                <br>
                <input type="email" name="email" value="' . getValue($data, "email") . '">
                ' . showError($data, "email") . '
                ' . showError($data, "user_already_exists") . '
                <br>

                <label for="name">Name</label>
                <br>
                <input type="text" name="name" value="' . getValue($data, "name") . '">
                ' . showError($data, "name") . '
                <br>

                <label for="password">Password</label>
                <br>
                <input type="password" name="password" value="' . getValue($data, "password") . '">
                ' . showError($data, "password") . '
                <br>

                <label for="confirm_password">Confirm password</label>
                <br>
                <input type="password" name="confirm_password" value="' . getValue($data, "confirm_password") . '">
                ' . showError($data, "confirm_password") . '
                <br>
        
                <input class="submit" type="submit" value="Submit">
            </form>';
}