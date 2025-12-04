// Login function
function handleLogin(event) {
    event.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const remember = document.getElementById('remember').checked;

    if (!email || !password) {
        alert('Please fill in all fields');
        return;
    }

    console.log('Login attempt:', { email, remember });

    if (email === "testemail@gmail.com" && password === "usertest123") {
        alert('Login successful! Welcome to ParkWise.');
        window.location.href = 'dashboard.html';
    } else {
        alert("Invalid email or password. Please try again.");
    }
}


// Mobile menu toggle
function toggleMenu() {
    const sideNav = document.getElementById('sideNav');
    sideNav.classList.toggle('active');
}

// Close menu when clicking outside on mobile
document.addEventListener('click', function(event) {
    const sideNav = document.getElementById('sideNav');
    const menuToggle = document.querySelector('.menu-toggle');
    
    if (window.innerWidth <= 768 && 
        !sideNav.contains(event.target) && 
        !menuToggle.contains(event.target) &&
        sideNav.classList.contains('active')) {
        sideNav.classList.remove('active');
    }
});

// Parking spot selection function
function selectSpot(spotNumber) {
    if (confirm(`Do you want to book parking spot ${spotNumber}?`)) {
        alert(`Spot ${spotNumber} has been reserved! Proceeding to payment...`);
        // Here you can add code to redirect to payment page or show booking confirmation
    }
}

// Vehicle management functions
function editVehicle(vehicleId) {
    alert('Edit vehicle functionality - To be implemented');
    // Add your edit vehicle logic here
}

function deleteVehicle(vehicleId) {
    if (confirm('Are you sure you want to delete this vehicle?')) {
        alert('Vehicle deleted successfully!');
        // Add your delete vehicle logic here
    }
}

// Add new vehicle
function addNewVehicle() {
    alert('Add new vehicle form - To be implemented');
    // Add your add vehicle logic here
}

// Payment method functions
function removePaymentMethod(methodId) {
    if (confirm('Are you sure you want to remove this payment method?')) {
        alert('Payment method removed successfully!');
        // Add your remove payment logic here
    }
}

function addPaymentMethod() {
    alert('Add payment method form - To be implemented');
    // Add your add payment method logic here
}

// Profile update
function updateProfile() {
    alert('Profile updated successfully!');
    // Add your profile update logic here
}

// Search parking spots
function searchParkingSpots() {
    const location = document.querySelector('.booking-form select').value;
    alert(`Searching for available parking spots at ${location}...`);
    // Add your search logic here
}

// Extend booking
function extendBooking() {
    alert('Extend booking functionality - To be implemented');
    // Add your extend booking logic here
}

// Auto-close mobile menu when window is resized
window.addEventListener('resize', function() {
    const sideNav = document.getElementById('sideNav');
    if (window.innerWidth > 768) {
        sideNav.classList.remove('active');
    }
});

// Initialize date input with today's date
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.querySelector('input[type="date"]');
    if (dateInput && !dateInput.value) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.value = today;
    }
});