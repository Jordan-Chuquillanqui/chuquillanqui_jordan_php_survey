<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../helpers.php';

$requestType = $_SERVER['REQUEST_METHOD'];

if ($requestType !== 'POST') {
    http_response_code(500);
    exit('Must be a POST request!');
}

$formInput = $_POST;

$_SESSION['form_input'] = $formInput;


$errors = [];

// name validation
if (!array_key_exists('first_name', $formInput)) {
    $errors['first_name'] = 'First name must be filled out!';
} 
    
$firstName = $formInput['first_name'];
// set a range from 3 to 30 characteres to ensure users don't submit a single letter or long text
if (strlen($firstName) < 3 || strlen($firstName) > 30) {
    $errors['first_name'] = 'First name must be more than 3 characters and less than 30';
}

if (!array_key_exists('last_name', $formInput)) {
    $errors['last_name'] = 'Last name must be filled out!';
} 
    
$lastName = $formInput['last_name'];
if (strlen($lastName) < 3 || strlen($lastName) > 30) {
    $errors['last_name'] = 'Last name must be more than 3 characters and less than 30';
}

// phone validation
if (!array_key_exists('phone', $formInput)) {
    $errors['phone'] = 'Phone number must be filled out!';
}
$phone = $formInput['phone'];

if (!array_key_exists('email', $formInput)) {
    $errors['email'] = 'Email is required!';
}

// email validation
$email = $formInput['email'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email'] = 'Email must be a correct format!';
}

// dietary preferences validation is optional, meaning the user can select 0 or more options.
$diet = $formInput['diet'] ?? [];

if (!is_array($diet)) {
    $errors['diet'] = 'Dietary preferences must be an array!';
}

$validDiets = ['vegetarian', 'vegan', 'gluten_free', 'halal'];
if (count($diet) > count($validDiets)) {
    $errors['diet'] = 'Too many dietary preferences selected!';
}

foreach ($diet as $preference) {
    if (!in_array($preference, $validDiets)) {
        $errors['diet'] = $preference . ' is not a valid dietary preference!';
    }
}

// favourite dish validation only validate the length if the user type something.
$dish = $formInput['dish'] ?? '';
if ($dish != '') {
    if (strlen($dish) < 3 || strlen($dish) > 30) {
        $errors['dish'] = 'Dish must be more than 3 characters and less than 30';
    }
}

// favourite drink validation only validate the length if the user type something.
$drink = $formInput['drink'] ?? '';
if ($drink != '') {
    if (strlen($drink) < 3 || strlen($drink) > 30) {
        $errors['drink'] = 'Drink must be more than 3 characters and less than 30';
    }
}

// locations validation is the same as dietary preferences, the user can select 0 or more options.
$locations = $formInput['locations'] ?? [];

if (!is_array($locations)) {
    $errors['locations'] = 'Locations must be an array!';
}

$validLocations = ['london', 'toronto', 'mississauga', 'hamilton'];
if (count($locations) > count($validLocations)) {
    $errors['locations'] = 'Too many locations selected!';
}

foreach ($locations as $loc) {
    if (!in_array($loc, $validLocations)) {
        $errors['locations'] = $loc . ' is not a valid location!';
    }
}

// social media validation
$socialMedia = $formInput['social_media'] ?? [];

if (!is_array($socialMedia)) {
    $errors['social_media'] = 'Social Media must be an array!';
}

$validsocialMedia = ['facebook', 'instagram', 'tiktok', 'youtube'];
if (count($socialMedia) > count($validsocialMedia)) {
    $errors['social_media'] = 'Too many Social Media selected!';
}

foreach ($socialMedia as $sm) {
    if (!in_array($sm, $validsocialMedia)) {
        $errors['social_media'] = $sm . ' is not a valid social media!';
    }
}

// promo code validation only validate the length if the user types something.
// in this case the range is shorter because the restaurant controls the length.
$promo = $formInput['promo'] ?? '';
if ($promo != '') {
    if (strlen($promo) < 3 || strlen($promo) > 20) {
        $errors['promo'] = 'Promo code must be more than 3 characters and less than 20';
    }
}


$_SESSION['form_errors'] = $errors;

if (count($errors) === 0) {
    $to      = 'restaurant@email.com';
    $subject = 'New Table Reservation';
    $message = '';

    $message .= '<h1>New Reservation Details</h1>';
    $message .= '<ul>';
    $message .= '<li>Name: ' . $firstName . ' ' . $lastName . '</li>';
    $message .= '<li>Email: ' . $email . '</li>';
    $message .= '<li>Phone Number: ' . $phone . '</li>';
    if ($dish != '')  $message .= '<li>Favorite Dish: ' . $dish . '</li>';
    if ($drink != '') $message .= '<li>Favorite Drink: ' . $drink . '</li>';
    if ($promo != '') $message .= '<li>Promo Code: ' . $promo . '</li>';
    $message .= '</ul>';

    $message .= '<p>Dietary Preferences:</p>';
    $message .= '<ul>';
    foreach ($diet as $preference) {
        $message .= '<li>' . $preference . '</li>';
    }
    $message .= '</ul>';

    $message .= '<p>Other Locations Visited:</p>';
    $message .= '<ul>';
    foreach ($locations as $loc) {
        $message .= '<li>' . $loc . '</li>';
    }
    $message .= '</ul>';

    mail($to, $subject, $message);
}


header('Location: /chuquillanqui_jordan_php_survey/index.php');