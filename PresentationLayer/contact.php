<?php 

/**
 * Function that displays the 'Contact Me' thank you content
 * @param array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors => array : (Empty),
 *                  "valid" => boolean : Data validity (TRUE) ]
 */
function showContactThanks($data) {
    echo   '<div class="content">
                Thank you for reaching out.<br><br>
                Gender: ' . getArrayValue($data["values"], "gender") . '<br>
                Name: ' . getArrayValue($data["values"], "name") . '<br>
                Email: ' . getArrayValue($data["values"], "email") . '<br>
                Phone: ' . getArrayValue($data["values"], "phone") . '<br>
                Subject: ' . getArrayValue($data["values"], "subject") . '<br>
                Communication preference: ' . getArrayValue($data["values"], "communication_preference") . '<br>
                Message: ' . getArrayValue($data["values"], "message") . '<br>
            </div>';  
}


/**
 * Function that displays the 'Contact Me' form
 * Important! The $data["errors"] contains errors messages when submitted user data is not valid
 * @param array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors => array : (Empty/Error messages),
 *                  "valid" => boolean : Data validity ]
 */
function showContactForm($data) {
    echo   '<div class="content">
                <h1>Contact Me</h1>
                <form action="index.php" method="POST">
                    <input type="hidden" id="page" name="page" value="contact">

            <!- DROPDOWN ->
                    <label for="gender">Gender</label> 
                    <br>
                    <select id="gender" name="gender">
                        <option value="">Choose</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    ' . showFieldError($data, "gender") . '
                    <br>

            <!- TEXTFIELDS ->     
                        <label for="name">Name</label>
                        <br>
                        <input type="text" name="name" value="' . getArrayValue($data["values"], "name") . '">
                        ' . showFieldError($data, "name") . '
                        <br>

                        <label for="email">Email</label>
                        <br>
                        <input type="email" name="email" value="' . getArrayValue($data["values"], "email") . '">
                        ' . showFieldError($data, "email") . '
                        <br>

                        <label for="phone">Phone</label>
                        <br>
                        <input type="text" name="phone" value="' . getArrayValue($data["values"], "phone") . '">
                        ' . showFieldError($data, "phone") . '
                        <br>

                        <label for="subject">Subject</label>
                        <br>
                        <input type="text" name="subject" value="' . getArrayValue($data["values"], "subject") . '">
                        ' . showFieldError($data, "subject") . '
                        <br>

            <!- RADIO BUTTONS ->
                        <label for="communication_preference">Communication preference</label>
                        <br>
                        <input type="radio" value="Email" name="communication_preference">
                        <label for="email" class="radio">Email</label>
                        <input type="radio" value="Phone" name="communication_preference">
                        <label for="phone" class="radio">Phone</label>
                        ' . showFieldError($data, "communication_preference") . '
                        <br>

            <!- TEXTAREA ->
                        <label for="message">Message</label>
                        <br>
                        <textarea name="message" cols="30" rows="10" value="' . getArrayValue($data["values"], "message") . '"></textarea>
                        ' . showFieldError($data, "message") . '
                        <br>

            <!- SUBMIT ->
                    <input class="submit" type="submit" value="Submit">
                </form>
            </div>';
}