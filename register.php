<?php

function showRegisterPage($data) {
    echo '  <div class="content">
                <h1>Registration</h1>
                <form action="index.php" method="POST">
                    <input type="hidden" name="page" value="register">

            <!- TEXTFIELDS ->
                    <label for="email">Email</label>
                    <br>
                    <input type="email" name="email" value="' . getArrayValue($data["values"], "email") . '">
                    ' . showFormError($data, "email") . '
                    ' . showFormError($data, "user_exists") . '
                    <br>

                    <label for="name">Name</label>
                    <br>
                    <input type="text" name="name" value="' . getArrayValue($data["values"], "name") . '">
                    ' . showFormError($data, "name") . '
                    <br>

                    <label for="password">Password</label>
                    <br>
                    <input type="text" name="password" value="' . getArrayValue($data["values"], "password") . '">
                    ' . showFormError($data, "password") . '
                    <br>

                    <label for="confirm_password">Confirm password</label>
                    <br>
                    <input type="text" name="confirm_password" value="' . getArrayValue($data["values"], "confirm_password") . '">
                    ' . showFormError($data, "confirm_password") . '
                    <br>
            <!- SUBMIT ->
                    <input class="submit" type="submit" value="Submit">
                    <br>
                </form>
            </div>';
}