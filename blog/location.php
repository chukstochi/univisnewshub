<?php
require 'partials/header.php';
require 'config/database.php';

// Set your address here (or fetch it from a database)
$location_address = "Based in Lagos, Nigeria";
?>

<ul class="about__links">
     <li><a href="#" id="locationToggle">Locations</a></li>
</ul>

<!-- Hidden Address Section -->
<div id="locationInfo" class="location__info" style="display: none;">
     <p><strong>Our Headquarters:</strong> <?= htmlspecialchars($location_address) ?></p>
</div>