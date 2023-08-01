<?php

/**
 * Clean input for security reason
 * 
 * @param string $value: The input to be cleaned
 * 
 * @return string $value: Clean input
 */
function cleanInput($value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
}

/**
 * Validate the input and record error
 * 
 * @param array $data: The form data
 * @param string $key: The name of the input
 * @param string $value: The form input
 * 
 * @return $data: The data array holding the key, value, and possible error
 */
function validateInput($data, $key, $value) {
    if (empty($value)) { 
        $data["errors"][$key] = ucfirst(str_replace("_", " ", $key)) .  " is required";
    }
    else {
        switch($key) { 
            case "name":
                if (!preg_match("/^[a-zA-Z-' ]*$/",$value)) { 
                    $data["errors"][$key] = "Only letters and white space allowed";
                }
                break;
            case "email":
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) { 
                    $data["errors"][$key] = "Invalid email format";
                }
                break;
            case "phone":
                if(!preg_match('/^[0-9]{10}+$/', $value)) {
                    $data['errors'][$key] = "Not a valid Phone number";
                }
                break;
        }   
    } 
    return $data;
}


/**
 * Start the validation process
 * 
 * @param array $data [
 *                  $values => array: Empty fields,
 *                  $errors => array: Empty,
 * @return array $data [
 *                  $values => array: The form inputs,
 *                  $errors => array: Empty if no errors -or- Errors message(s),
 */
function startValidate($data) {
    foreach ($data["values"] as $key => $value) {
        $value = cleanInput(getPostValue($key));
        $data["values"][$key] = $value;
        $data = validateInput($data, $key, $value);
    }
    return $data;
}


/**
 * Check the form for errors
 * 
 * @param array $data: The form data to be checked
 * 
 * @return array $data["valid"]: TRUE -or- FALSE
 */
function checkForError($data) {
    if (empty($data["errors"])) {
        $data["valid"] = true;
    }
    return $data;
}


/**
 * Validate the Contact form
 * 
 * @param string $page : The requested page
 * 
 * @return array $data [
 *                      "page" => string: The name of the form page,
 *                      "values" => array: The form inputs,
 *                      "errors" => array: Empty if no errors -or- Errors message(s),
 *                      "valid" => boolean: TRUE if form is valid -or- FALSE if form is invalid 
 *                     ]
 */
function validateContact($page) {
    $data = array("values"=>getFormFields($page),"errors"=>array(),"valid"=>false);
    if (requestMethodIsPost()) {
        $data["page"] = getPostValue("page");
        $data = startValidate($data);
        $data = checkForError($data);
    }
    return $data;
}


/**
 * Check by email if user already exists in database
 * 
 * @param string $email: The user email
 * 
 * @return boolean: TRUE if user exists -or- FALSE if not
 */
function doesEmailExist($email) {
    return (!is_null(findUserByEmail($email)));
}


/**
 * Validate the Registration form
 * 
 * @param string $page : The requested page
 * 
 * @return array $data [
 *                      "page" => string: The name of the form page,
 *                      "values" => array: The form inputs,
 *                      "errors" => array: Empty if no errors -or- Errors message(s),
 *                      "valid" => boolean: TRUE if form is valid -or- FALSE if form is invalid 
 *                     ]
 */
function validateRegister($page) {
    $data = array("values"=>getFormFields($page),"errors"=>array(),"valid"=>false);

    if (requestMethodIsPost()) {
        $data["page"] = getPostValue("page");
        $data = startValidate($data);
        try {
            if (!empty($data["values"]["email"])) {
                if (doesEmailExist($data["values"]["email"])) {
                    $data["errors"]["user_already_exists"] = "Email already exists";
                }
            }
            if (!$data["values"]["password"] == $data["values"]["confirm_password"]) {
                $data["errors"]["confirm_password"] = "Passwords do not match. Try again";
            }
        }
        catch (Exception $e) {
            $data["errors"]["generic"] = 'Due to technical error, we cannot proceed with this process';
            showLog($e->getMessage());
        }
        $data = checkForError($data);
    }
    return $data;
}


/**
 * Validate and authenticate the Login form
 * 
 * @param string $page : The requested page
 * 
 * @return array $data [
 *                      "page" => string: The name of the form page,
 *                      "values" => array: The form inputs,
 *                      "errors" => array: Empty if no errors -or- Errors message(s),
 *                      "user" => array: Empty if user does not exist -or- user ID and username,
 *                      "valid" => boolean: TRUE if form is valid -or- FALSE if form is invalid 
 *                     ]
 */
function validateLogin($page) {
    $data = array("values"=>getFormFields($page),"errors"=>array(),"user"=>array(),"valid"=>false);
    if (requestMethodIsPost()) {
        $data["page"] = getPostValue("page");
        $data = startValidate($data);
        try {
            if (!empty($data["values"]["email"])) {
                if (!doesEmailExist($data["values"]["email"])) {
                    $data["errors"]["no_existing_user"] = "This user doesn't seem to exist";
                }
                else {
                    $user = findUserByEmail($data["values"]["email"]);
                    if (!$data["values"]["password"] == $user["password"]) {
                        $data["errors"]["authentication"] = "Your password is incorrect";
                    }
                    else {
                        $data["user"]["user_id"] = $user["user_id"];
                        $data["user"]["name"] = $user["name"];
                    }
                }
            }   
        }
        catch (Exception $e) {
            $data["errors"]["generic"] = 'Due to technical error, we cannot proceed with this process';
            showLog($e->getMessage());
        }
        $data = checkForError($data);
    }
    return $data;
}


/**
 * Validate the Change Password form
 * 
 * @param string $page : The requested page
 * 
 * @return array $data [
 *                      "page" => string: The name of the form page,
 *                      "values" => array: The form inputs,
 *                      "errors" => array: Empty if no errors -or- Errors message(s),
 *                      "user" => array: Empty if user does not exist -or- user ID and username,
 *                      "valid" => boolean: TRUE if form is valid -or- FALSE if form is invalid 
 *                     ]
 */
function validateNewPassword($page) {
    $data = array("values"=>getFormFields($page),"errors"=>array(),"user"=>array(),"valid"=>false);

    if (requestMethodIsPost()) {
        if (isUserLoggedIn()) {
            $data["page"] = getPostValue("page");
            $data = startValidate($data);
            try {
                $user = findUserById(getLoggedInUserId());

                if ($data["values"]["current_password"] != $user["password"]) { 
                    $data["errors"]["current_password"] = "Your password is incorrect";
                }
                elseif ($data["values"]["new_password"] != $data["values"]["confirm_new_password"]) {
                        $data["errors"]["confirm_new_password"] = "Passwords do not match. Try again";
                }
                else {
                    $data["user"]["user_id"] = $user["user_id"];
                    $data["user"]["name"] = $user["name"];
                }
            }
            catch (Exception $e) {
                $data["errors"]["generic"] = 'Due to technical error, we cannot proceed with this process';
                showLog($e->getMessage());
            }
            $data = checkForError($data);
        }
    }
    return $data;
}


/**
 * Check by product ID if product exists in database
 * 
 * @param string $product_id: The requested product ID
 * 
 * @return boolean: TRUE if product exists -or- FALSE if not
 */
function doesProductExist($product_id) {
    return (!is_null(getProductById($product_id)));
}