<?php  

/**
 * Display the Home page content
 */
function showHomeContent() {
    echo   '<h1>Home</h1>
            <div class="row">
                <div class="column">
                    <p id="welcome" class="home">Hi! I\'m Quincy.<br>Welcome to my website.</p>
                </div>
                <div class="column">
                    <img class="home" src="UI/Images/me.JPG" alt="A profile picture of me">
                </div>
            </div>
            <button type="button" class="click_btn"><a href="index.php?page=contact">Contact Me</a></button>';
}
