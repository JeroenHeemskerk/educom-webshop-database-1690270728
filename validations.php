<?php

/**
 * Function cleans POST data, and stores the 'clean' values inside the $data["values"] array
 * @param array $data [
 *                  "values" => array : User data submitted,
 *                  "errors" => array : Empty,
 *                  "valid" => boolean : Data validity ] 
 * @return array $data [
 *                  "page" => string: Requested page,
 *                  "values" => array : User data submitted (cleaned),
 *                  "errors => array : Empty,
 *                  "valid" => boolean : Data validity ]
 */
function cleanData($data) {
    foreach ($_POST as $key => $value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);

        if ($key == "page") {
            $data["page"] = $value;
        }
        else {
            $data["values"][$key] = $value;
        }
    }
    return $data;
}


/**
 * Function validates the $data array according to business logic, and records the errors if any
 * Important! The $data["user"] and $data["user_already_existst"] only present when page == 'registration' or 'login'
 * @param array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted,
 *                  "errors" => array : Empty,
 *                  "user" => array : Empty,
 *                  "user_already_exists" => boolean : Flag variable,
 *                  "valid" => boolean: Data validity ]
 * @return array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (cleaned),
 *                  "errors" => array : Empty/Error messages,
 *                  "user" => array : Empty/User data from database (id, email, name, password),
 *                  "user_already_exists" => boolean : Flag variable,
 *                  "valid" => boolean: Data validity ]
 */
function validateData($data) {

    $data = cleanData($data); # Clean data

    foreach ($data["values"] as $key => $value) {
        if (empty($value)) { #Check if field is empty
            $data["errors"][$key] = ucfirst(str_replace("_", " ", $key)) .  " is required";
        }
        else {
            switch($key) { 
                case "name":
                    if (!preg_match("/^[a-zA-Z-' ]*$/",$data["values"]["name"])) { # Check if 'name' is valid
                        $data["errors"]["name"] = "Only letters and white space allowed";
                        break;
                    }
                case "email":
                    if (!filter_var($data["values"]["email"], FILTER_VALIDATE_EMAIL)) { # Check if 'email' is valid
                        $data["errors"]["email"] = "Invalid email format";
                        break;
                    }
                }   
            } 
    }  

    switch ($data["page"]) {
        case "register":
            if (!($data["values"]["confirm_password"] == $data["values"]["password"])) { # Check if 'password' and 'confirm password' match
                $data["errors"]["confirm_password"] = "Passwords do not match. Try again";
            }
            else {
                $data = runQuery("findUserByEmail", $data);
                if ($data["user_already_exists"]) { # Check if user data exists in database
                    $data["errors"]["user_already_exists"] = "A user with the same email already exists";
                }
            }
            break;
        case "login":
            $data = runQuery("findUserByEmail", $data);
            if ($data["user_already_exists"]) { # Check if user data exists in database
                if (!($data["values"]["email"] == $data["user"]["email"] && $data["values"]["password"] == $data["user"]["password"])) { # Check if 'email' and 'password' match user data in database, to authenticate user
                    $data["errors"]["authentication"] = "The email and password do not match";
                }
            } 
            else {
                $data["errors"]["no_existing_user"] = "This user doesn't seem to exist";
            }
            break;
        case "change_password":
            if (!($data["values"]["current_password"] == $data["user"]["password"])) { # Check if 'current password' matches 'password' in database
                $data["errors"]["current_password"] = "Your current password is incorrect";
            }
            elseif (!$data["values"]["new_password"] == $data["values"]["confirm_new_password"]) { # Check if 'new password' and 'confirm new password' match
                    $data["errors"]["confirm_new_password"] = "Passwords do not match. Try again";
            }
            break;
    }
    
    if (empty($data["errors"])) { # Check if there were any error messages recorded in the 'errors' array
        $data["valid"] = true; 
    }
    return $data;
}


/**
 * Function validates the 'Contact Me' data from user, sent through POST request
 * @return array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (contact_fields),
 *                  "errors" => array : Empty/Error messages,
 *                  "valid" => boolean: Data validity ]
 */
function validateContact() {
    $contact_fields = array("gender"=>"","name"=>"","email"=>"","phone"=>"","subject"=>"","communication_preference"=>"","message"=>"");
    $data = array("values"=>$contact_fields,"errors"=>array(),"valid"=>false);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = validateData($data);
    }
    return $data;
}


/**
 * Function validates the 'Registration' data from user, sent through POST request
 * @return array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (register_fields),
 *                  "errors" => array : Empty/Error messages,
 *                  "user" => array : Empty/User data from database (id, email, name, password),
 *                  "user_already_exists" => boolean : Flag variable,
 *                  "valid" => boolean: Data validity ]
 */
function validateRegister() {
    $register_fields = array("email"=>"","name"=>"","password"=>"","confirm_password"=>"");
    $data = array("values"=>$register_fields,"errors"=>array(),"user"=>array(),"user_already_exists"=>false,"valid"=>false);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = validateData($data);
    }
    return $data;
}


/**
 * Function validates the 'Login' data from user, sent through POST request
 * @return array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (login_fields),
 *                  "errors" => array : Empty/Error messages,
 *                  "user" => array : Empty/User data from database (id, email, name, password),
 *                  "user_already_exists" => boolean : Flag variable,
 *                  "valid" => boolean: Data validity ]
 */
function validateLogin() {
    $login_fields = array("email"=>"","password"=>"");
    $data = array("values"=>$login_fields,"errors"=>array(),"user"=>array(),"user_already_exists"=>false,"valid"=>false);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = validateData($data);
    }
    return $data;
}


/**
 * Function validates the 'Change Password' data from user, sent through POST request
 * @return array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (change_password_fields)
 *                  "errors" => array : Empty/Error messages,
 *                  "user" => array : User data from database (id, email, name, password),
 *                  "user_already_exists" => boolean : Flag variable,
 *                  "valid" => boolean: Data validity ]
 */
function validateNewPassword() {
    $change_password_fields = array("current_password"=>"","new_password"=>"","confirm_new_password"=>"");
    $data = array("values"=>$change_password_fields,"errors"=>array(),"user"=>array(),"valid"=>false);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isUserLoggedIn()) {

            $data = runQuery("findUserById", $data);
        }
        $data = validateData($data);
    }
    return $data;
}