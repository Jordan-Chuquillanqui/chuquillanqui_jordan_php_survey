<?php
session_start();

$errors = $_SESSION['form_errors'] ?? [];

// variables
$submittedInputs      = $_SESSION['form_input']   ?? [];
$submittedFirstName   = $submittedInputs['first_name']  ?? '';
$submittedLastName    = $submittedInputs['last_name']  ?? '';
$submittedEmail       = $submittedInputs['email'] ?? '';
$submittedPhone       = $submittedInputs['phone'] ?? '';
$submittedDate        = $submittedInputs['date']  ?? '';
$submittedGuests      = $submittedInputs['guests'] ?? '';
$submittedPromo       = $submittedInputs['promo'] ?? '';
$submittedDish        = $submittedInputs['dish'] ?? '';
$submittedDrink       = $submittedInputs['drink'] ?? '';

// for reset info
$_SESSION['form_input'] = [];
$_SESSION['form_errors'] = [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <title>Restaurant Reservation Form</title>
</head>
<body>
    <header>
        <h1>Restaurant Reservation Form</h1>
    </header>
    <main>
        <form action="includes/scripts/process_reservation.php" method="POST">
            <div>
                <?php 
                    if (array_key_exists('first_name', $errors)) {
                        echo '<p style="color:red">' . $errors['first_name'] . '</p>';
                     }
                ?>
                <label for="first_name">First Name:</label>
                <input 
                    id="first_name" 
                    name="first_name" 
                    type="text" 
                    placeholder="First Name"
                    <?php if (count($errors) > 0 && $submittedFirstName) {
                        echo 'value="'. $submittedFirstName . '"';
                    } ?>
                >
            </div>
            <div>
                <?php 
                    if (array_key_exists('last_name', $errors)) {
                        echo '<p style="color:red">' . $errors['last_name'] . '</p>';
                     }
                ?>
                <label for="last_name">Last Name:</label>
                <input 
                    id="last_name" 
                    name="last_name" 
                    type="text" 
                    placeholder="Last Name"
                    <?php if (count($errors) > 0 && $submittedLastName) {
                        echo 'value="'. $submittedLastName . '"';
                    } ?>
                >
            </div>
            <div>
                <?php 
                    if (array_key_exists('phone', $errors)) {
                        echo '<p style="color:red">' . $errors['phone'] . '</p>';
                     }
                ?>
                <label for="phone">Phone Number:</label>
                <input 
                    id="phone" 
                    name="phone" 
                    type="tel" 
                    placeholder="888 888 8888"
                    <?php if (count($errors) > 0 && $submittedPhone) {
                        echo 'value="'. $submittedPhone . '"';
                    } ?>
                >
            </div>
            <div>
                <?php 
                    if (array_key_exists('email', $errors)) {
                        echo '<p style="color:red">' . $errors['email'] . '</p>';
                     }
                ?>
                <label for="email">Email:</label>
                <input 
                    id="email" 
                    name="email" 
                    type="email" 
                    placeholder="info@email.com"
                    <?php if (count($errors) > 0 && $submittedEmail) {
                        echo 'value="'. $submittedEmail . '"';
                    } ?>
                >
            </div>
            <div>
                <?php 
                    if (array_key_exists('date', $errors)) {
                        echo '<p style="color:red">' . $errors['date'] . '</p>';
                     }
                ?>
                <label for="date">Date:</label>
                <!-- no placeholder because it's alreadye by default. -->
                <!-- use of the min attribute to lock past dates. -->
                <input 
                    id="date" 
                    name="date" 
                    type="date"
                    min="<?php echo date('Y-m-d'); ?>"
                    <?php if (count($errors) > 0 && $submittedDate) {
                        echo 'value="'. $submittedDate . '"';
                    } ?>
                >
            </div>
            <div>
                <?php 
                    if (array_key_exists('guests', $errors)) {
                        echo '<p style="color:red">' . $errors['guests'] . '</p>';
                     }
                ?>
                <label for="guests">Number of Guests:</label>
                <input 
                    id="guests" 
                    name="guests" 
                    type="number" 
                    placeholder="Number of Guests"
                    <?php if (count($errors) > 0 && $submittedGuests) {
                        echo 'value="'. $submittedGuests . '"';
                    } ?>
                >
            </div>
            <div>
                <label for="time">Time of Day:</label>
                <select id="time" name="time">
                    <option value="morning">Morning</option>
                    <option value="afternoon">Afternoon</option>
                    <option value="night">Night</option>
                </select>
            </div>
            <div>
                <label for="seat">Preferred Seating:</label>
                <select id="seat" name="seat">
                    <option value="first_floor">First Floor</option>
                    <option value="second_floor">Second Floor</option>
                    <option value="terrace">Terrace</option>
                </select>
            </div>
            <fieldset>
                <legend>Dietary Preferences:</legend>
                
                <label for="vegetarian">Vegetarian</label>
                <input id="vegetarian" type="checkbox" name="diet[]" value="vegetarian">

                <label for="vegan">Vegan</label>
                <input id="vegan" type="checkbox" name="diet[]" value="vegan">

                <label for="gluten_free">Gluten-Free</label>
                <input id="gluten_free" type="checkbox" name="diet[]" value="gluten_free">

                <label for="halal">Halal</label>
                <input id="halal" type="checkbox" name="diet[]" value="halal">
            </fieldset>
            <div>
                <label for="accommodations">Special Accommodations:</label>
                <textarea id="accommodations" name="accommodations"></textarea>
            </div>
            <div>
                <label for="allergies">Food Allergies:</label>
                <textarea id="allergies" name="allergies"></textarea>
            </div>
            <div>
                <label for="frequency">Visit Frequency:</label>
                <select id="frequency" name="frequency">
                    <option value="first_time">First Time</option>
                    <option value="monthly">Monthly</option>
                    <option value="bimonthly">Bimonthly</option>
                </select>
            </div>
            <div>
                <?php 
                    if (array_key_exists('dish', $errors)) {
                        echo '<p style="color:red">' . $errors['dish'] . '</p>';
                     }
                ?>
                <label for="dish">Favourite Dish:</label>
                <input 
                    id="dish" 
                    name="dish" 
                    type="text" 
                    placeholder="Favourite Dish"
                    <?php if (count($errors) > 0 && $submittedDish) {
                        echo 'value="'. $submittedDish . '"';
                    } ?>
                >
            </div>
            <div>
                <?php 
                    if (array_key_exists('drink', $errors)) {
                        echo '<p style="color:red">' . $errors['drink'] . '</p>';
                     }
                ?>
                <label for="drink">Favourite Drink:</label>
                <input 
                    id="drink" 
                    name="drink" 
                    type="text" 
                    placeholder="Favourite Drink"
                    <?php if (count($errors) > 0 && $submittedDrink) {
                        echo 'value="'. $submittedDrink . '"';
                    } ?>
                >
            </div>
            <div>
                <label for="about_us">How did you hear about us?:</label>
                <select id="about_us" name="about_us">
                    <option value="referral">Referral</option>
                    <option value="social_media">Social Media</option>
                    <option value="google_search">Google Search</option>
                </select>
            </div>
            <fieldset>
                <legend>Other Locations Visited:</legend>
                
                <label for="london">London</label>
                <input id="london" type="checkbox" name="locations[]" value="london">

                <label for="toronto">Toronto</label>
                <input id="toronto" type="checkbox" name="locations[]" value="toronto">

                <label for="mississauga">Mississauga</label>
                <input id="mississauga" type="checkbox" name="locations[]" value="mississauga">

                <label for="hamilton">Hamilton</label>
                <input id="hamilton" type="checkbox" name="locations[]" value="hamilton">
            </fieldset>
            <fieldset>
                <legend>Follow us on:</legend>
                
                <label for="fb">Facebook</label>
                <input id="fb" type="checkbox" name="social_media[]" value="facebook">

                <label for="ig">Instagram</label>
                <input id="ig" type="checkbox" name="social_media[]" value="instagram">

                <label for="tt">TikTok</label>
                <input id="tt" type="checkbox" name="social_media[]" value="tiktok">

                <label for="yt">Youtube</label>
                <input id="yt" type="checkbox" name="social_media[]" value="youtube">

            </fieldset>
            <div>
                <?php 
                    if (array_key_exists('promo', $errors)) {
                        echo '<p style="color:red">' . $errors['promo'] . '</p>';
                     }
                ?>
                <label for="promo">Promo Code:</label>
                <input 
                    id="promo" 
                    name="promo" 
                    type="text" 
                    placeholder="Promo Code"
                    <?php if (count($errors) > 0 && $submittedPromo) {
                        echo 'value="'. $submittedPromo . '"';
                    } ?>
                >
            </div>
            <footer>
                <button type="submit">Reserve Now</button>
            </footer>
        </form>
    </main>
</body>
</html>