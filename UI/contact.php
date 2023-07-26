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
                Gender: ' . getValue($data, "gender") . '<br>
                Name: ' . getValue($data, "name") . '<br>
                Email: ' . getValue($data, "email") . '<br>
                Phone: ' . getValue($data, "phone") . '<br>
                Subject: ' . getValue($data, "subject") . '<br>
                Communication preference: ' . getValue($data, "communication_preference") . '<br>
                Message: ' . getValue($data, "message") . '<br>
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

                    <label for="gender">Gender</label> 
                    <br>
                    <select id="gender" name="gender">
                        <option value="">Choose</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    ' . getError($data, "gender") . '
                    <br>
  

                    <label for="name">Name</label>
                    <br>
                    <input type="text" name="name" value="' . getArrayValue($data["values"], "name") . '">
                    ' . getError($data, "name") . '
                    <br>

                    <label for="email">Email</label>
                    <br>
                    <input type="email" name="email" value="' . getArrayValue($data["values"], "email") . '">
                    ' . getError($data, "email") . '
                    <br>

                    <label for="phone">Phone</label>
                    <br>
                    <input type="text" name="phone" value="' . getArrayValue($data["values"], "phone") . '">
                    ' . getError($data, "phone") . '
                    <br>

                    <label for="subject">Subject</label>
                    <br>
                    <input type="text" name="subject" value="' . getArrayValue($data["values"], "subject") . '">
                    ' . getError($data, "subject") . '
                    <br>

                    
                    <label for="communication_preference">Communication preference</label>
                    <br>
                    <input type="radio" value="Email" name="communication_preference">
                    <label for="email" class="radio">Email</label>
                    <input type="radio" value="Phone" name="communication_preference">
                    <label for="phone" class="radio">Phone</label>
                    ' . getError($data, "communication_preference") . '
                    <br>

                    <label for="message">Message</label>
                    <br>
                    <textarea name="message" cols="30" rows="10" value="' . getArrayValue($data["values"], "message") . '"></textarea>
                    ' . getError($data, "message") . '
                    <br>

                    <input class="submit" type="submit" value="Submit">
                </form>
            </div>';
}