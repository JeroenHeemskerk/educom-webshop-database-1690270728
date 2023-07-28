<?php

/**
 * Display the Change Password page form
 * 
 * @param array $data: The data from new password validation
 */
function showChangePassword($data) {
    echo   '<h1>Change Password</h1>
            <form action="index.php" method="POST">
                
                <input type="hidden" name="page" value="change_password">

                ' . showError($data, "generic") . '<br>
                <label for="current_password">Current password</label>
                <br>
                <input type="password" name="current_password" value="' . getValue($data, "current_password") . '">
                ' . showError($data, "current_password") . '
                <br>
                <label for="new_password">New password</label>
                <br>
                <input type="password" name="new_password" value="' . getValue($data, "new_password") . '">
                ' . showError($data, "new_password") . '
                <br>
                <label for="confirm_new_password">Confirm new password</label>
                <br>
                <input type="password" name="confirm_new_password" value="' . getValue($data, "confirm_new_password") . '">
                ' . showError($data, "confirm_new_password") . '
                <br>
        
                <input class="submit" type="submit" value="Submit">
            </form>';
}