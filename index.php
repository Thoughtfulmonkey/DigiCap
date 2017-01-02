<?php

session_start();

// Initialise framework
$f3=require('lib/base.php');
$f3->set('DEBUG',1);
$f3->set('AUTOLOAD','app/controllers/');
$f3->set('APPROOT','/digicap');

// Set dev mode
$f3->set('DEV',1);

// Connection to database
$f3->set('DB', new DB\SQL(
    'mysql:host=localhost;port=3306;dbname=digicap',
    'root',
    ''
));

// Using SQL sessions
new \DB\SQL\Session( $f3->get('DB') );

// Routes
$f3->route('GET /',
    function($f3) {
		echo Template::instance()->render('app/views/mainfilter.php');
    }
);

// Auth links
$f3->route('GET /login', 'MyAuth->showlogin');			// Show login page
$f3->route('POST /login', 'MyAuth->attemptlogin');		// Attempt to login
$f3->route('GET /logout', 'MyAuth->logout');			// Log the user out

// Content links
$f3->route('GET /search/@tags', 'ContentPool->search');	// Searching for content
$f3->route('GET /loadlo/@label', 'ContentPool->load');	// Loading a single Learning Object

// Authoring areas
$f3->route('GET /author', 'Author->listing');			// List the available content
$f3->route('GET /loadlist/@author', 'Author->loadList');// Loading list for chosen author
$f3->route('GET /addnew', 'Author->addNew');			// Loading list for chosen author
$f3->route('POST /buildlo', 'Author->buildNew');		// Process form submission to build the learning object

// Dev calls
// TODO: remove before shipping
$f3->route('GET /purge', 'DevTools->purge');			// Wipe non-essential data for fresh restart


$f3->run();



?>