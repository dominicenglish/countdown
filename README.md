# Countdown
Basic web application for generating "live" countdown images for use in email marketing.

Javascript does not get run be email clients so to get a countdown graphic we need to.

- Add an HTML img tag in the email 
- Point the image src to point to wherever you have hosted gif.php
- When the user opens the email the image request will get set to gif.php
- gif.php will then generate a one minute long animated countdown gif based on the current time left
- User gets what looks like a completely dynamic countdown
