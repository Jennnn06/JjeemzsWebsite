// Track user activity
let userIsActive = true;

// Set the inactivity timeout (in milliseconds)
const inactivityTimeout = 3600000; // 1 hour

// Function to logout the user
function logoutUser() {
    // Redirect to the logout route
    window.location.href = '/logout';
}

// Function to reset user activity and log countdown
function resetUserActivity() {
    userIsActive = true;
    clearTimeout(timeoutId); // Clear the timeout
    timeoutId = setTimeout(logoutUser, inactivityTimeout); // Set the timeout again
}

// Start the timer
let timeoutId = setTimeout(logoutUser, inactivityTimeout);

// Event listener for mouse move and keypress events to reset the timeout
document.addEventListener('mousemove', resetUserActivity);
document.addEventListener('keypress', resetUserActivity);
