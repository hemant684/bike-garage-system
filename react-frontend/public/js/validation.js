/**
 * Bike Garage Management System - Client-side Validation
 */

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    initializeFormValidations();
});

/**
 * Initialize all form validations
 */
function initializeFormValidations() {
    // Login Form Validation
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', validateLoginForm);
    }

    // Registration Form Validation
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', validateRegisterForm);
        initializeRealTimeValidation(registerForm);
    }

    // Forgot Password Form Validation
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');
    if (forgotPasswordForm) {
        forgotPasswordForm.addEventListener('submit', validateForgotPasswordForm);
    }

    // Booking Form Validation
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', validateBookingForm);
    }

    // Bill Form Validation
    const billForm = document.getElementById('billForm');
    if (billForm) {
        billForm.addEventListener('submit', validateBillForm);
    }

    // Admin Booking Form Validation
    const adminBookingForm = document.getElementById('adminBookingForm');
    if (adminBookingForm) {
        adminBookingForm.addEventListener('submit', validateAdminBookingForm);
    }
}

/**
 * Validate Login Form
 */
function validateLoginForm(e) {
    e.preventDefault();
    let isValid = true;
    clearErrors();

    const email = document.getElementById('email');
    const password = document.getElementById('password');

    // Email validation
    if (!email.value.trim()) {
        showError(email, 'Email is required');
        isValid = false;
    } else if (!isValidEmail(email.value.trim())) {
        showError(email, 'Please enter a valid email address');
        isValid = false;
    }

    // Password validation
    if (!password.value) {
        showError(password, 'Password is required');
        isValid = false;
    } else if (password.value.length < 6) {
        showError(password, 'Password must be at least 6 characters');
        isValid = false;
    }

    if (isValid) {
        this.submit();
    }
}

/**
 * Validate Registration Form
 */
function validateRegisterForm(e) {
    e.preventDefault();
    let isValid = true;
    clearErrors();

    const fullName = document.getElementById('fullName');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');
    const bikeModel = document.getElementById('bikeModel');
    const bikeNumber = document.getElementById('bikeNumber');
    const terms = document.getElementById('terms');

    // Full Name validation
    if (!fullName.value.trim()) {
        showError(fullName, 'Full name is required');
        isValid = false;
    } else if (fullName.value.trim().length < 3) {
        showError(fullName, 'Name must be at least 3 characters');
        isValid = false;
    }

    // Email validation
    if (!email.value.trim()) {
        showError(email, 'Email is required');
        isValid = false;
    } else if (!isValidEmail(email.value.trim())) {
        showError(email, 'Please enter a valid email address');
        isValid = false;
    }

    // Phone validation
    if (!phone.value.trim()) {
        showError(phone, 'Phone number is required');
        isValid = false;
    } else if (!isValidPhone(phone.value.trim())) {
        showError(phone, 'Please enter a valid phone number (10 digits)');
        isValid = false;
    }

    // Password validation
    if (!password.value) {
        showError(password, 'Password is required');
        isValid = false;
    } else if (password.value.length < 6) {
        showError(password, 'Password must be at least 6 characters');
        isValid = false;
    } else if (!isStrongPassword(password.value)) {
        showError(password, 'Password must contain at least one letter and one number');
        isValid = false;
    }

    // Confirm Password validation
    if (!confirmPassword.value) {
        showError(confirmPassword, 'Please confirm your password');
        isValid = false;
    } else if (confirmPassword.value !== password.value) {
        showError(confirmPassword, 'Passwords do not match');
        isValid = false;
    }

    // Bike Model validation
    if (!bikeModel.value.trim()) {
        showError(bikeModel, 'Bike model is required');
        isValid = false;
    }

    // Bike Number validation
    if (!bikeNumber.value.trim()) {
        showError(bikeNumber, 'Bike number is required');
        isValid = false;
    }

    // Terms validation
    if (terms && !terms.checked) {
        showError(terms, 'You must accept the terms and conditions');
        isValid = false;
    }

    if (isValid) {
        this.submit();
    }
}

/**
 * Validate Forgot Password Form
 */
function validateForgotPasswordForm(e) {
    e.preventDefault();
    let isValid = true;
    clearErrors();

    const email = document.getElementById('email');

    if (!email.value.trim()) {
        showError(email, 'Email is required');
        isValid = false;
    } else if (!isValidEmail(email.value.trim())) {
        showError(email, 'Please enter a valid email address');
        isValid = false;
    }

    if (isValid) {
        this.submit();
    }
}

/**
 * Validate Booking Form
 */
function validateBookingForm(e) {
    e.preventDefault();
    let isValid = true;
    clearErrors();

    const bikeModel = document.getElementById('bikeModel');
    const bikeNumber = document.getElementById('bikeNumber');
    const serviceType = document.getElementById('serviceType');
    const serviceDescription = document.getElementById('serviceDescription');
    const bookingDate = document.getElementById('bookingDate');
    const preferredTime = document.getElementById('preferredTime');

    // Bike Model validation
    if (!bikeModel.value.trim()) {
        showError(bikeModel, 'Bike model is required');
        isValid = false;
    }

    // Bike Number validation
    if (!bikeNumber.value.trim()) {
        showError(bikeNumber, 'Bike number is required');
        isValid = false;
    }

    // Service Type validation
    if (!serviceType.value) {
        showError(serviceType, 'Please select a service type');
        isValid = false;
    }

    // Service Description validation
    if (!serviceDescription.value.trim()) {
        showError(serviceDescription, 'Please describe the service needed');
        isValid = false;
    } else if (serviceDescription.value.trim().length < 10) {
        showError(serviceDescription, 'Please provide more details (at least 10 characters)');
        isValid = false;
    }

    // Booking Date validation
    if (!bookingDate.value) {
        showError(bookingDate, 'Please select a booking date');
        isValid = false;
    } else if (!isValidFutureDate(bookingDate.value)) {
        showError(bookingDate, 'Please select a valid future date');
        isValid = false;
    }

    // Preferred Time validation
    if (!preferredTime.value) {
        showError(preferredTime, 'Please select preferred time');
        isValid = false;
    }

    if (isValid) {
        this.submit();
    }
}

/**
 * Validate Bill Form
 */
function validateBillForm(e) {
    e.preventDefault();
    let isValid = true;
    clearErrors();

    const laborCharge = document.getElementById('laborCharge');
    const partsCost = document.getElementById('partsCost');

    if (laborCharge && laborCharge.value === '') {
        showError(laborCharge, 'Labor charge is required');
        isValid = false;
    } else if (laborCharge && parseFloat(laborCharge.value) < 0) {
        showError(laborCharge, 'Labor charge cannot be negative');
        isValid = false;
    }

    if (partsCost && partsCost.value === '') {
        showError(partsCost, 'Parts cost is required');
        isValid = false;
    } else if (partsCost && parseFloat(partsCost.value) < 0) {
        showError(partsCost, 'Parts cost cannot be negative');
        isValid = false;
    }

    if (isValid) {
        this.submit();
    }
}

/**
 * Validate Admin Booking Form
 */
function validateAdminBookingForm(e) {
    e.preventDefault();
    let isValid = true;
    clearErrors();

    const status = document.getElementById('status');
    const adminNotes = document.getElementById('adminNotes');

    if (!status.value) {
        showError(status, 'Please select a status');
        isValid = false;
    }

    if (isValid) {
        this.submit();
    }
}

/**
 * Initialize real-time validation for registration form
 */
function initializeRealTimeValidation(form) {
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            // Remove error state when user starts typing
            const errorDiv = this.parentNode.querySelector('.error-message');
            if (errorDiv && errorDiv.style.display === 'block') {
                this.classList.remove('error');
                errorDiv.style.display = 'none';
            }
        });
    });
}

/**
 * Validate individual field
 */
function validateField(field) {
    const fieldName = field.id || field.name;
    let isValid = true;
    let errorMessage = '';

    switch (fieldName) {
        case 'fullName':
            if (!field.value.trim()) {
                errorMessage = 'Full name is required';
                isValid = false;
            } else if (field.value.trim().length < 3) {
                errorMessage = 'Name must be at least 3 characters';
                isValid = false;
            }
            break;

        case 'email':
            if (!field.value.trim()) {
                errorMessage = 'Email is required';
                isValid = false;
            } else if (!isValidEmail(field.value.trim())) {
                errorMessage = 'Please enter a valid email address';
                isValid = false;
            }
            break;

        case 'phone':
            if (!field.value.trim()) {
                errorMessage = 'Phone number is required';
                isValid = false;
            } else if (!isValidPhone(field.value.trim())) {
                errorMessage = 'Please enter a valid phone number';
                isValid = false;
            }
            break;

        case 'password':
            if (!field.value) {
                errorMessage = 'Password is required';
                isValid = false;
            } else if (field.value.length < 6) {
                errorMessage = 'Password must be at least 6 characters';
                isValid = false;
            } else if (!isStrongPassword(field.value)) {
                errorMessage = 'Password must contain letter and number';
                isValid = false;
            }
            break;

        case 'confirmPassword':
            const password = document.getElementById('password');
            if (!field.value) {
                errorMessage = 'Please confirm your password';
                isValid = false;
            } else if (field.value !== password.value) {
                errorMessage = 'Passwords do not match';
                isValid = false;
            }
            break;
    }

    if (!isValid) {
        showError(field, errorMessage);
    } else {
        clearFieldError(field);
    }
}

/**
 * Show error message for a field
 */
function showError(field, message) {
    field.classList.add('error');
    let errorDiv = field.parentNode.querySelector('.error-message');
    
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        field.parentNode.appendChild(errorDiv);
    }
    
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
}

/**
 * Clear error message for a field
 */
function clearFieldError(field) {
    field.classList.remove('error');
    const errorDiv = field.parentNode.querySelector('.error-message');
    if (errorDiv) {
        errorDiv.style.display = 'none';
    }
}

/**
 * Clear all form errors
 */
function clearErrors() {
    const errorMessages = document.querySelectorAll('.error-message');
    const errorFields = document.querySelectorAll('.error');
    
    errorMessages.forEach(msg => msg.style.display = 'none');
    errorFields.forEach(field => field.classList.remove('error'));
}

/**
 * Validate email format
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Validate phone number format (Indian format)
 */
function isValidPhone(phone) {
    // Indian phone numbers: 10 digits, can start with 6-9
    const phoneRegex = /^[6-9]\d{9}$/;
    return phoneRegex.test(phone.replace(/\s/g, ''));
}

/**
 * Check if password is strong enough
 */
function isStrongPassword(password) {
    // At least one letter and one number
    const hasLetter = /[a-zA-Z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    return hasLetter && hasNumber;
}

/**
 * Check if date is in the future
 */
function isValidFutureDate(dateString) {
    const selectedDate = new Date(dateString);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    return selectedDate >= today;
}

/**
 * Format currency
 */
function formatCurrency(amount) {
    return '₹' + parseFloat(amount).toFixed(2);
}

/**
 * Calculate total bill
 */
function calculateTotal() {
    const laborCharge = parseFloat(document.getElementById('laborCharge')?.value) || 0;
    const partsCost = parseFloat(document.getElementById('partsCost')?.value) || 0;
    const taxRate = 0.09; // 9% tax
    const taxAmount = (laborCharge + partsCost) * taxRate;
    const total = laborCharge + partsCost + taxAmount;

    // Update display elements if they exist
    const taxDisplay = document.getElementById('taxAmount');
    const totalDisplay = document.getElementById('totalAmount');

    if (taxDisplay) taxDisplay.value = taxAmount.toFixed(2);
    if (totalDisplay) totalDisplay.value = total.toFixed(2);
}

/**
 * Confirm action dialog
 */
function confirmAction(message) {
    return confirm(message || 'Are you sure you want to proceed?');
}

/**
 * Show modal
 */
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
    }
}

/**
 * Hide modal
 */
function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

/**
 * Close modal when clicking outside
 */
window.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal')) {
        e.target.style.display = 'none';
    }
});

/**
 * Auto-hide alerts after 5 seconds
 */
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.opacity = '0';
        alert.style.transition = 'opacity 0.5s ease';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);

/**
 * Export table data to CSV
 */
function exportToCSV(tableId, filename) {
    const table = document.getElementById(tableId);
    if (!table) return;

    let csv = [];
    const rows = table.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        const rowData = [];
        cols.forEach(col => {
            // Escape quotes and wrap in quotes
            let data = col.innerText.replace(/"/g, '""');
            rowData.push(`"${data}"`);
        });
        csv.push(rowData.join(','));
    });

    const csvFile = new Blob([csv.join('\n')], {type: 'text/csv'});
    const downloadLink = document.createElement('a');
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = 'none';
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

/**
 * Print functionality
 */
function printPage() {
    window.print();
}

/**
 * Handle keyboard events
 */
document.addEventListener('keydown', function(e) {
    // Close modal on Escape key
    if (e.key === 'Escape') {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => modal.style.display = 'none');
    }
});

