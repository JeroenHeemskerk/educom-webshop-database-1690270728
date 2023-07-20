<?php

/**
 * Function that displays the 'Login' page content
 * @param array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors => array : (Empty/Error messages),
 *                  "user" => array : (Empty/User data from database),
 *                  "valid" => boolean : Data validity ]
 */
function showLoginPage($data) {
    echo '  <div class="content">
                <h1>Login</h1>
                <form action="../Business/index.php" method="POST">
                    <input type="hidden" name="page" value="login">

                    <label for="email">Email</label>
                    <br>
                    <input type="email" name="email" value="' . getArrayValue($data["values"], "email") . '">
                    ' . showFormError($data, "email") . '
                    <br>

                    <label for="password">Password</label>
                    <br>
                    <input type="text" name="password" value="' . getArrayValue($data["values"], "password") . '">
                    ' . showFormError($data, "password") . '
                    <br>
                    ' . showFormError($data, "authentication") . '
                    <br>

                    <input class="submit" type="submit" value="Sign In">
                </form>
            </div>';
}