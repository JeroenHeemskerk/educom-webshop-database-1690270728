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
            
                    <label for="current_password">Current password</label>
                    <br>
                    <input type="text" name="current_password" value="' . getArrayValue($data["values"], "current_password") . '">
                    ' . showFieldError($data, "current_password") . '
                    <br>
                    <label for="new_password">New password</label>
                    <br>
                    <input type="text" name="new_password" value="' . getArrayValue($data["values"], "new_password") . '">
                    ' . showFieldError($data, "new_password") . '
                    <br>
                    <label for="confirm_new_password">Confirm new password</label>
                    <br>
                    <input type="text" name="confirm_new_password" value="' . getArrayValue($data["values"], "confirm_new_password") . '">
                    ' . showFieldError($data, "confirm_new_password") . '
                    <br>
            
                    <input class="submit" type="submit" value="Submit">
                    <br>

                </form>
            </div>';
}