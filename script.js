 function showPage(pageId) {
            // Hide all pages
            const pages = document.querySelectorAll('.page');
            pages.forEach(page => {
                page.classList.remove('active');
            });
            
            // Show the selected page
            document.getElementById(pageId).classList.add('active');
            
            // Close mobile menu if open
            document.querySelector('nav ul').classList.remove('show');
            
            // Scroll to top
            window.scrollTo(0, 0);
        }

        function toggleFAQ(element) {
            const faqItem = element.parentElement;
            faqItem.classList.toggle('active');
            
            // Change the plus/minus icon
            const icon = element.querySelector('span:last-child');
            icon.textContent = faqItem.classList.contains('active') ? '-' : '+';
        }

        function openWhatsApp() {
            const phoneNumber = "254769924070";
            const message = "Hello, I'm interested in your SEO and e-commerce services.";
            const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
            window.open(url, '_blank');
        }

        function openTelegram() {
            const username = "nyotecreation";
            const url = `https://t.me/mrteslaman${username}`;
            window.open(url, '_blank');
        }

        // Mobile menu toggle
        document.querySelector('.mobile-menu').addEventListener('click', function() {
            document.querySelector('nav ul').classList.toggle('show');
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('nav ul li a').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelector('nav ul').classList.remove('show');
            });
        });

        // Add animation to elements when they come into view
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'slideInUp 0.5s ease forwards';
                }
            });
        }, observerOptions);

        // Observe service cards and benefit items
        document.querySelectorAll('.service-card, .benefit-item').forEach(el => {
            el.style.opacity = '0';
            observer.observe(el);
        });

         const image = document.getElementById('glowImage');

    document.addEventListener('mousemove', (e) => {
      const x = (window.innerWidth / 2 - e.pageX) / 40;
      const y = (window.innerHeight / 2 - e.pageY) / 40;

      image.style.transform = `rotateY(${x}deg) rotateX(${y}deg) scale(1.05)`;
    });

    document.addEventListener('mouseleave', () => {
      image.style.transform = 'rotateY(0deg) rotateX(0deg) scale(1)';
    });


    //digital javascript code

     // Mobile menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const dmMobileMenuBtn = document.getElementById('dmMobileMenuBtn');
            const dmMobileMenu = document.getElementById('dmMobileMenu');
            
            if (dmMobileMenuBtn && dmMobileMenu) {
                dmMobileMenuBtn.addEventListener('click', function() {
                    dmMobileMenu.classList.toggle('active');
                });
                
                // Close menu when clicking on a link
                const dmMobileLinks = dmMobileMenu.querySelectorAll('a');
                dmMobileLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        dmMobileMenu.classList.remove('active');
                    });
                });
            }
            
            // Add floating animation to elements
            const dmFloatingElements = document.querySelectorAll('.dm-floating');
            dmFloatingElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.3}s`;
            });
        });

         // Mobile menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const wmMobileMenuBtn = document.getElementById('wmMobileMenuBtn');
            const wmMobileMenu = document.getElementById('wmMobileMenu');
            
            if (wmMobileMenuBtn && wmMobileMenu) {
                wmMobileMenuBtn.addEventListener('click', function() {
                    wmMobileMenu.classList.toggle('active');
                });
                
                // Close menu when clicking on a link
                const wmMobileLinks = wmMobileMenu.querySelectorAll('a');
                wmMobileLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        wmMobileMenu.classList.remove('active');
                    });
                });
            }
            
            // Add floating animation to elements
            const wmFloatingElements = document.querySelectorAll('.wm-floating');
            wmFloatingElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.3}s`;
            });
        });


         // Mobile menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const wmMobileMenuBtn = document.getElementById('wmMobileMenuBtn');
            const wmMobileMenu = document.getElementById('wmMobileMenu');
            
            if (wmMobileMenuBtn && wmMobileMenu) {
                wmMobileMenuBtn.addEventListener('click', function() {
                    wmMobileMenu.classList.toggle('active');
                });
                
                // Close menu when clicking on a link
                const wmMobileLinks = wmMobileMenu.querySelectorAll('a');
                wmMobileLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        wmMobileMenu.classList.remove('active');
                    });
                });
            }
            
            // Add floating animation to elements
            const wmFloatingElements = document.querySelectorAll('.wm-floating');
            wmFloatingElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.3}s`;
            });
        });

                // Mobile menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const hostingMobileMenuBtn = document.getElementById('hostingMobileMenuBtn');
            const hostingMobileMenu = document.getElementById('hostingMobileMenu');
            
            if (hostingMobileMenuBtn && hostingMobileMenu) {
                hostingMobileMenuBtn.addEventListener('click', function() {
                    hostingMobileMenu.classList.toggle('active');
                });
                
                // Close menu when clicking on a link
                const hostingMobileLinks = hostingMobileMenu.querySelectorAll('a');
                hostingMobileLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        hostingMobileMenu.classList.remove('active');
                    });
                });
            }
            
            // Add floating animation to elements
            const hostingFloatingElements = document.querySelectorAll('.hosting-floating');
            hostingFloatingElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.3}s`;
            });
        });



        // Global variables
let selectedAmount = 0;
let selectedMethod = '';
let transactionId = '';

// Initialize the payment page
document.addEventListener('DOMContentLoaded', function() {
    // Check if amount is passed via URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const amount = urlParams.get('amount');
    
    if (amount && !isNaN(amount) && amount > 0) {
        selectAmount(parseInt(amount));
    }
});

// Amount selection functions
function selectAmount(amount) {
    selectedAmount = amount;
    
    // Update button states
    document.querySelectorAll('.py-amount-btn').forEach(btn => {
        btn.classList.remove('active');
        if (parseInt(btn.textContent.replace(/[^\d]/g, '')) === amount) {
            btn.classList.add('active');
        }
    });
    
    // Update display
    document.getElementById('displayAmount').textContent = `KES ${amount.toLocaleString()}`;
    document.getElementById('c2bAmount').textContent = `KES ${amount.toLocaleString()}`;
    
    // Generate random account number for C2B
    document.getElementById('c2bAccount').textContent = `ORDER${Math.floor(100000 + Math.random() * 900000)}`;
    
    // Show payment methods if amount is selected
    if (selectedAmount > 0) {
        document.querySelector('.py-method-section').style.display = 'block';
    }
}

function setCustomAmount() {
    const customAmount = document.getElementById('customAmount').value;
    if (customAmount && customAmount > 0) {
        selectAmount(parseInt(customAmount));
        document.getElementById('customAmount').value = '';
    } else {
        showError('Please enter a valid amount');
    }
}

// Payment method selection
function selectMethod(method) {
    if (selectedAmount <= 0) {
        showError('Please select an amount first');
        return;
    }
    
    selectedMethod = method;
    
    // Show payment form
    const paymentForm = document.getElementById('paymentForm');
    paymentForm.style.display = 'block';
    
    // Update form title
    const formTitle = document.getElementById('formTitle');
    const methodNames = {
        'mpesa_stk': 'M-Pesa STK Push',
        'mpesa_c2b': 'M-Pesa C2B',
        'flutterwave': 'Flutterwave',
        'paypal': 'PayPal',
        'pesapal': 'PesaPal'
    };
    formTitle.textContent = `${methodNames[method]} Payment - KES ${selectedAmount.toLocaleString()}`;
    
    // Hide all method forms
    document.querySelectorAll('.py-method-form').forEach(form => {
        form.style.display = 'none';
    });
    
    // Show selected method form
    document.getElementById(`${method}Form`).style.display = 'block';
    
    // Scroll to form
    paymentForm.scrollIntoView({ behavior: 'smooth' });
}

// Payment processing functions
async function processMpesaSTK() {
    const phone = document.getElementById('mpesaPhone').value;
    
    if (!phone) {
        showError('Please enter your phone number');
        return;
    }
    
    if (!phone.startsWith('254') || phone.length !== 12) {
        showError('Please enter a valid Kenyan phone number (254XXXXXXXXX)');
        return;
    }
    
    showLoading();
    
    try {
        const response = await fetch('backend/mpesa_stk_push.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                phone: phone,
                amount: selectedAmount
            })
        });
        
        const data = await response.json();
        
        hideLoading();
        
        if (data.success) {
            transactionId = data.transaction_id;
            showSuccess();
        } else {
            showError(data.message || 'Failed to initiate M-Pesa payment');
        }
    } catch (error) {
        hideLoading();
        showError('Network error. Please try again.');
    }
}

function processMpesaC2B() {
    showLoading();
    
    // Simulate payment verification
    setTimeout(() => {
        // In a real implementation, you would verify the payment with M-Pesa C2B API
        transactionId = 'C2B_' + Math.floor(1000000000 + Math.random() * 9000000000);
        hideLoading();
        showSuccess();
    }, 3000);
}

async function processFlutterwavePayment() {
    const email = document.getElementById('flutterwaveEmail').value;
    
    if (!email) {
        showError('Please enter your email address');
        return;
    }
    
    showLoading();
    
    try {
        const response = await fetch('backend/flutterwave_payment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: email,
                amount: selectedAmount
            })
        });
        
        const data = await response.json();
        
        hideLoading();
        
        if (data.success) {
            // Redirect to Flutterwave payment page
            window.location.href = data.payment_url;
        } else {
            showError(data.message || 'Failed to initiate Flutterwave payment');
        }
    } catch (error) {
        hideLoading();
        showError('Network error. Please try again.');
    }
}

async function processPaypalPayment() {
    const email = document.getElementById('paypalEmail').value;
    
    if (!email) {
        showError('Please enter your PayPal email');
        return;
    }
    
    showLoading();
    
    try {
        const response = await fetch('backend/paypal_payment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: email,
                amount: selectedAmount
            })
        });
        
        const data = await response.json();
        
        hideLoading();
        
        if (data.success) {
            // Redirect to PayPal payment page
            window.location.href = data.payment_url;
        } else {
            showError(data.message || 'Failed to initiate PayPal payment');
        }
    } catch (error) {
        hideLoading();
        showError('Network error. Please try again.');
    }
}

async function processPesapalPayment() {
    const email = document.getElementById('pesapalEmail').value;
    const phone = document.getElementById('pesapalPhone').value;
    
    if (!email || !phone) {
        showError('Please enter both email and phone number');
        return;
    }
    
    showLoading();
    
    try {
        const response = await fetch('backend/pesapal_payment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: email,
                phone: phone,
                amount: selectedAmount
            })
        });
        
        const data = await response.json();
        
        hideLoading();
        
        if (data.success) {
            // Redirect to PesaPal payment page
            window.location.href = data.payment_url;
        } else {
            showError(data.message || 'Failed to initiate PesaPal payment');
        }
    } catch (error) {
        hideLoading();
        showError('Network error. Please try again.');
    }
}

// UI Helper functions
function showLoading() {
    document.getElementById('loadingSpinner').style.display = 'block';
    document.getElementById('paymentForm').style.display = 'none';
}

function hideLoading() {
    document.getElementById('loadingSpinner').style.display = 'none';
}

function showSuccess() {
    document.getElementById('successAmount').textContent = `KES ${selectedAmount.toLocaleString()}`;
    document.getElementById('transactionId').textContent = transactionId;
    document.getElementById('successMessage').style.display = 'block';
    document.getElementById('paymentForm').style.display = 'none';
    
    // Scroll to success message
    document.getElementById('successMessage').scrollIntoView({ behavior: 'smooth' });
}

function showError(message) {
    document.getElementById('errorText').textContent = message;
    document.getElementById('errorMessage').style.display = 'block';
    
    // Scroll to error message
    document.getElementById('errorMessage').scrollIntoView({ behavior: 'smooth' });
}

function hideError() {
    document.getElementById('errorMessage').style.display = 'none';
}

function resetPayment() {
    selectedAmount = 0;
    selectedMethod = '';
    transactionId = '';
    
    // Reset UI
    document.querySelectorAll('.py-amount-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.getElementById('displayAmount').textContent = 'KES 0';
    document.getElementById('paymentForm').style.display = 'none';
    document.getElementById('successMessage').style.display = 'none';
    document.querySelector('.py-method-section').style.display = 'none';
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Integration with e-commerce site
function setPaymentAmount(amount) {
    selectAmount(amount);
}

// Export functions for global access
window.setPaymentAmount = setPaymentAmount;
window.selectAmount = selectAmount;
window.selectMethod = selectMethod;
    