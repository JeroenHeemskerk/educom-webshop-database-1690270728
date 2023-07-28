<?php

/**
 * Display the About page content
 */
function showAboutContent() {
    echo   '<h1>About Me</h1>
            <div class="aboutme">
                <img src="UI/Images/me.JPG" alt="A profile picture of me">
                <p>I\'m an application/software development trainee. My ambition is to become a data engineer.</p>
                <p>I\'m currently working at Educom, to get a solid foundation in programming.</p>
                <p>I enjoy:
                    <ul>
                        <li>Exercising</li>
                        <li>Cooking</li>
                        <li>Reading</li>
                    </ul>
                </p>
                <button class="click_btn" type="button"><a href="index.php?page=contact">Contact Me</a></button>
            </div>';
}