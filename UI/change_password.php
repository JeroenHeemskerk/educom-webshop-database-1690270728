<?php

/**
 * Function displays the 'Change Password' page content
 * @param array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors => array : (Empty/Error messages),
 *                  "user" => array : (Empty/User data from database),
 *                  "valid" => boolean : Data validity ]
 */
function showChangePassword($data) {
    echo '  <div class="content">
                <h1>Change Password</h1>

                <form action="index.php" method="POST">
                    
                    <input type="hidden" name="page" value="change_password">

                    ' . getError($data, "generic") . '<br>
                    <label for="current_password">Current password</label>
                    <br>
                    <input type="password" name="current_password" value="' . getValue($data, "current_password") . '">
                    ' . getError($data, "current_password") . '
                    <br>
                    <label for="new_password">New password</label>
                    <br>
                    <input type="password" name="new_password" value="' . getValue($data, "new_password") . '">
                    ' . getError($data, "new_password") . '
                    <br>
                    <label for="confirm_new_password">Confirm new password</label>
                    <br>
                    <input type="password" name="confirm_new_password" value="' . getValue($data, "confirm_new_password") . '">
                    ' . getError($data, "confirm_new_password") . '
                    <br>
            
                    <input class="submit" type="submit" value="Submit">
                    <br>

                </form>
            </div>';
}