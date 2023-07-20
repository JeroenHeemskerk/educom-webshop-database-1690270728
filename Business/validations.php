<?php

/**
 * Function that cleans $_POST array (from POST request), and stores the 'clean' values inside the $data["values"] array
 * @param array $data [
 *                  "values" => array : User data submitted,
 *                  "errors" => array : (Empty),
 *                  "valid" => boolean : Data validity ] 
 * @return array $data [
 *                  "page" => string: Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors => array : (Empty),
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
 * Function that validates the $data array according to business logic. 
 * Important! The $data["user"] only present when page == 'registration' or 'login'
 * @param array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors" => array : (Empty),
 *                  "user" => array : (Empty)
 *                  "valid" => boolean: Data validity ]
 * @return array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors" => array : Error messages,
 *                  "user" => array : User data from database (email, name, password)
 *                  "valid" => boolean: Data validity ]
 */
function validateData($data) {
    $data = cleanData($data);
    foreach ($data["values"] as $key => $value) {
        if (empty($value)) {
            $data["errors"][$key] = ucfirst(str_replace("_", " ", $key)) .  " is required";
        }
        else {
            switch($key) {
                case "name":
                    if (!preg_match("/^[a-zA-Z-' ]*$/",$data["values"]["name"])) {
                        $data["errors"]["name"] = "Only letters and white space allowed";
                        break;
                    }
                case "email":
                    if (!filter_var($data["values"]["email"], FILTER_VALIDATE_EMAIL)) {
                        $data["errors"]["email"] = "Invalid email format";
                        break;
                    }
                }   
            } 
    }  
    if ($data["page"] == "register") {
        if ($data["values"]["confirm_password"] != $data["values"]["password"]) {
            $data["errors"]["confirm_password"] = "Passwords do not match. Try again";
        }
        else {
            require "../Data/DML.php";
            $data = findUserByEmail($data);
            if ($data["user"]["user_exists"]) {
                $data["errors"]["user_exists"] = "A user with the same email already exists";
            }
        }
    }
    elseif ($data["page"] == "login") {
        require "../Data/DML.php";
        $data = findUserByEmail($data);
        if ($data["user"]["user_exists"]) {
            if (!userIsAuthenticated($data)) {
                $data["errors"]["authentication"] = "The email and/or password do not match";
            }
        } 
    }
    if (empty($data["errors"])) {
        $data["valid"] = true;
    }
    return $data;
}


/**
 * Function that validates the 'Contact Me' data from user, sent through POST request
 * @return array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors" => array : Error messages,
 *                  "user" => array : User data from database (email, name, password)
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
 * Function that validates the 'Registration' data from user, sent through POST request
 * @return array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors" => array : Error messages,
 *                  "valid" => boolean: Data validity ]
 */
function validateRegister() {
    $register_fields = array("email"=>"","name"=>"","password"=>"","confirm_password"=>"");
    $data = array("values"=>$register_fields,"errors"=>array(),"user"=>array(),"valid"=>false);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = validateData($data);
    }
    return $data;
}


/**
 * Function that returns TRUE, IF user email AND user password matches with existing data
 * @param array $data [
 *                  "page" => string : Requested page
 *                  "values" => array : User data submitted (clean),
 *                  "errors" => array : (Empty),
 *                  "user" => array : User data from database (email, name, password),
 *                  "valid" => boolean : Data validity ]
 * @return boolean
 */
function userIsAuthenticated($data) {
    return ($data["values"]["email"] == $data["user"]["email"] && $data["values"]["password"] == $data["user"]["password"]);
}


/**
 * Function that validates the 'Login' data from user, sent through POST request
 * @return array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors" => array : Error messages,
 *                  "user" => array : User data from database (email, name, password)
 *                  "valid" => boolean: Data validity ]
 */
function validateLogin() {
    $data = array("values"=>array(),"errors"=>array(),"user"=>array(),"valid"=>false);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = validateData($data);
    }
    return $data;
}