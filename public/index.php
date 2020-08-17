<?php

// load bootstrap app
require __DIR__ . '/../bootstrap/app.php';

// load container
require __DIR__ . '/../bootstrap/container.php';

// includes routes
require __DIR__ . '/../app/routes/general.php';


// run the app
$app->run();
