// autologout.js

// Track user activity
let userIsActive = true;

// Set the inactivity timeout (in milliseconds)
const inactivityTimeout = 60 * 60 * 1000; // 60 minutes

// Function to logout the user
function logoutUser() {
    // Redirect to the logout route
    window.location.href = 'logout';

    // Reload the page after logout
    window.location.reload(true);
}

// Function to reset user activity
function resetUserActivity() {
    userIsActive = true;
}

// Start the timer
let timeoutId = setTimeout(logoutUser, inactivityTimeout);

// Event listener for mouse move and keypress events to reset the timeout
document.addEventListener('mousemove', resetUserActivity);
document.addEventListener('keypress', resetUserActivity);

// Function to check user activity periodically
function checkUserActivity() {
    if (!userIsActive) {
        clearTimeout(timeoutId);
        logoutUser();
    } else {
        // Reset the timer
        timeoutId = setTimeout(logoutUser, inactivityTimeout);
    }
    // Reset user activity status
    userIsActive = false;
}

// Check user activity every minute (adjust as needed)
setInterval(checkUserActivity, 60000); // 60 seconds
