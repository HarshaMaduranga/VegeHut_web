// Firebase Configuration
const firebaseConfig = {
    apiKey: "AIzaSyBZ1DHcUds2-E1HiwigpIY7U4vEBKN1vJc",
    authDomain: "vegehut-909e9.firebaseapp.com",
    projectId: "vegehut-909e9",
    storageBucket: "vegehut-909e9.firebasestorage.app",
    messagingSenderId: "576972977093",
    appId: "1:576972977093:web:a8074579872e7a5cba91ac",
    measurementId: "G-B30Q31KZ7K"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
const auth = firebase.auth();

// DOM Elements
const loginPage = document.getElementById('loginPage');
const signupPage = document.getElementById('signupPage');
const homePage = document.getElementById('homePage');
const loginForm = document.getElementById('loginForm');
const signupForm = document.getElementById('signupForm');
const showSignupForm = document.getElementById('showSignupForm');
const showLoginForm = document.getElementById('showLoginForm');
const googleSignInBtn = document.getElementById('googleSignInBtn');
const googleSignUpBtn = document.getElementById('googleSignUpBtn');
const logoutBtn = document.getElementById('logoutBtn');
const userEmail = document.getElementById('userEmail');
const userInitial = document.getElementById('userInitial');
const loginError = document.getElementById('loginError');
const signupError = document.getElementById('signupError');

function showPage(pageId) {
    // Hide all pages
    document.getElementById('loginPage').classList.add('hidden');
    document.getElementById('signupPage').classList.add('hidden');
    document.getElementById('homePage').classList.add('hidden');
    
    // Show the requested page
    document.getElementById(pageId).classList.remove('hidden');
}

// Google Auth Provider
const googleProvider = new firebase.auth.GoogleAuthProvider();

// Image Carousel Class
class ImageCarousel {
    constructor() {
        this.images = document.querySelectorAll('.carousel-image');
        this.indicators = document.querySelectorAll('.indicator');
        this.currentSlide = 0;
        this.slideInterval = null;
        
        this.init();
    }
    
    init() {
        if (this.images.length === 0 || this.indicators.length === 0) {
            console.log('Carousel elements not found, retrying...');
            setTimeout(() => this.init(), 100);
            return;
        }
        
        // Add click listeners to indicators
        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                this.goToSlide(index);
            });
        });
        
        // Start auto-slide
        this.startAutoSlide();
    }
    
    goToSlide(slideIndex) {
        if (this.images.length === 0) return;
        
        // Remove active class from current slide and indicator
        this.images[this.currentSlide].classList.remove('active');
        this.indicators[this.currentSlide].classList.remove('active');
        
        // Update current slide
        this.currentSlide = slideIndex;
        
        // Add active class to new slide and indicator
        this.images[this.currentSlide].classList.add('active');
        this.indicators[this.currentSlide].classList.add('active');
        
        // Reset auto-slide timer
        this.resetAutoSlide();
    }
    
    nextSlide() {
        const nextIndex = (this.currentSlide + 1) % this.images.length;
        this.goToSlide(nextIndex);
    }
    
    startAutoSlide() {
        this.slideInterval = setInterval(() => {
            this.nextSlide();
        }, 4000); // Change slide every 4 seconds
    }
    
    resetAutoSlide() {
        clearInterval(this.slideInterval);
        this.startAutoSlide();
    }
}

// Initialize carousel
let carousel;

// Auth State Observer
auth.onAuthStateChanged((user) => {
    if (user) {
        // User is signed in - show home page
        showHomePage(user);
    } else {
        // User is signed out - show login page
        showLoginPage();
        // Initialize carousel when login page is shown
        setTimeout(() => {
            carousel = new ImageCarousel();
        }, 100);
    }
});

// Event Listeners
showSignupForm.addEventListener('click', () => {
    loginPage.classList.add('hidden');
    signupPage.classList.remove('hidden');
    clearForms();
});

showLoginForm.addEventListener('click', () => {
    signupPage.classList.add('hidden');
    loginPage.classList.remove('hidden');
    clearForms();
    // Re-initialize carousel when returning to login
    setTimeout(() => {
        carousel = new ImageCarousel();
    }, 100);
});

// Google Sign-In
googleSignInBtn.addEventListener('click', () => {
    auth.signInWithPopup(googleProvider)
        .catch((error) => {
            showError(loginError, getErrorMessage(error.code));
        });
});

googleSignUpBtn.addEventListener('click', () => {
    auth.signInWithPopup(googleProvider)
        .catch((error) => {
            showError(signupError, getErrorMessage(error.code));
        });
});

// Email/Password Login
loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;
    
    try {
        hideError(loginError);
        await auth.signInWithEmailAndPassword(email, password);
    } catch (error) {
        showError(loginError, getErrorMessage(error.code));
    }
});

// Email/Password Signup
signupForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const email = document.getElementById('signupEmail').value;
    const password = document.getElementById('signupPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (password !== confirmPassword) {
        showError(signupError, 'Passwords do not match');
        return;
    }
    
    if (password.length < 6) {
        showError(signupError, 'Password must be at least 6 characters long');
        return;
    }
    
    try {
        hideError(signupError);
        await auth.createUserWithEmailAndPassword(email, password);
    } catch (error) {
        showError(signupError, getErrorMessage(error.code));
    }
});

// Logout
logoutBtn.addEventListener('click', async () => {
    try {
        await auth.signOut();
    } catch (error) {
        console.error('Error signing out:', error);
    }
});

// Helper Functions
function showLoginPage() {
    homePage.classList.add('hidden');
    signupPage.classList.add('hidden');
    loginPage.classList.remove('hidden');
    document.body.className = 'gradient-bg min-h-screen flex items-center justify-center p-4';
}

function showHomePage(user) {
    loginPage.classList.add('hidden');
    signupPage.classList.add('hidden');
    homePage.classList.remove('hidden');
    document.body.className = 'bg-gray-50';
    
    // Update user info
    userEmail.textContent = user.email;
    userInitial.textContent = user.email.charAt(0).toUpperCase();
    
    // Clear carousel interval when leaving login page
    if (carousel && carousel.slideInterval) {
        clearInterval(carousel.slideInterval);
    }
}

function showError(errorElement, message) {
    errorElement.textContent = message;
    errorElement.classList.remove('hidden');
}

function hideError(errorElement) {
    errorElement.classList.add('hidden');
}

function clearForms() {
    document.getElementById('loginEmail').value = '';
    document.getElementById('loginPassword').value = '';
    document.getElementById('signupEmail').value = '';
    document.getElementById('signupPassword').value = '';
    document.getElementById('confirmPassword').value = '';
    hideError(loginError);
    hideError(signupError);
}

function getErrorMessage(errorCode) {
    switch (errorCode) {
        case 'auth/user-not-found':
            return 'No user found with this email address';
        case 'auth/wrong-password':
            return 'Incorrect password';
        case 'auth/email-already-in-use':
            return 'An account with this email already exists';
        case 'auth/weak-password':
            return 'Password is too weak';
        case 'auth/invalid-email':
            return 'Invalid email address';
        case 'auth/too-many-requests':
            return 'Too many attempts, please try again later.';
        default:
            return 'An unknown error occurred. Please try again.';
    }
}