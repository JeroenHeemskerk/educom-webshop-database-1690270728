<?php  

/**
 * Function that displays the 'Home' content
 */
function showHomeContent() {
    echo   '<div class="content">
                <h1>Home</h1>
                <div class="row">
                    <div class="column">
                        <p id="welcome" class="home">Hi! I\'m Quincy.<br>Welcome to my website.</p>
                    </div>
                    <div class="column">
                        <img class="home" src="'.DISPLAY.'/Images/me.JPG" alt="A profile picture of me">
                    </div>
                </div>
                <button type="button" class="get_in_touch"><a href="index.php?page=contact">Contact Me</a></button>
            </div>';
}
