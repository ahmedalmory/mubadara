// Custom JavaScript for Laravel Breeze without Vite
// This file replaces the need for Alpine.js and Axios npm packages

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Alpine.js functionality manually
    initializeAlpineComponents();
    
    // Initialize Axios-like functionality
    initializeHttpClient();
    
    // Initialize form handling
    initializeFormHandling();
});

// Alpine.js-like reactive functionality
function initializeAlpineComponents() {
    // Handle dropdowns
    const dropdownToggles = document.querySelectorAll('[x-data*="open"]');
    dropdownToggles.forEach(toggle => {
        let isOpen = false;
        const button = toggle.querySelector('button');
        const menu = toggle.querySelector('[x-show]');
        
        if (button && menu) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                isOpen = !isOpen;
                menu.style.display = isOpen ? 'block' : 'none';
            });
            
            // Close on outside click
            document.addEventListener('click', function(e) {
                if (!toggle.contains(e.target)) {
                    isOpen = false;
                    menu.style.display = 'none';
                }
            });
        }
    });
    
    // Handle mobile menu toggles
    const mobileMenuToggles = document.querySelectorAll('[data-mobile-menu-toggle]');
    mobileMenuToggles.forEach(toggle => {
        let isOpen = false;
        const menu = document.querySelector('[data-mobile-menu]');
        
        if (menu) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                isOpen = !isOpen;
                menu.style.display = isOpen ? 'block' : 'none';
            });
        }
    });
    
    // Handle password visibility toggles
    const passwordToggles = document.querySelectorAll('[data-password-toggle]');
    passwordToggles.forEach(toggle => {
        const input = toggle.previousElementSibling;
        if (input && input.type === 'password') {
            toggle.addEventListener('click', function() {
                if (input.type === 'password') {
                    input.type = 'text';
                    toggle.textContent = 'Hide';
                } else {
                    input.type = 'password';
                    toggle.textContent = 'Show';
                }
            });
        }
    });
}

// HTTP Client functionality (Axios replacement)
function initializeHttpClient() {
    // Create a simple HTTP client
    window.http = {
        get: function(url, config = {}) {
            return this.request('GET', url, null, config);
        },
        
        post: function(url, data = null, config = {}) {
            return this.request('POST', url, data, config);
        },
        
        put: function(url, data = null, config = {}) {
            return this.request('PUT', url, data, config);
        },
        
        delete: function(url, config = {}) {
            return this.request('DELETE', url, null, config);
        },
        
        request: function(method, url, data = null, config = {}) {
            const defaultHeaders = {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            };
            
            const headers = { ...defaultHeaders, ...(config.headers || {}) };
            
            const options = {
                method: method,
                headers: headers,
                credentials: 'same-origin'
            };
            
            if (data && (method === 'POST' || method === 'PUT' || method === 'PATCH')) {
                if (data instanceof FormData) {
                    delete options.headers['Content-Type'];
                    options.body = data;
                } else {
                    options.body = JSON.stringify(data);
                }
            }
            
            return fetch(url, options)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    }
                    return response.text();
                });
        }
    };
    
    // Make it available globally for backward compatibility
    window.axios = window.http;
}

// Form handling functionality
function initializeFormHandling() {
    // Handle CSRF token for all forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        // Add CSRF token if not present
        if (!form.querySelector('input[name="_token"]')) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (csrfToken) {
                const tokenInput = document.createElement('input');
                tokenInput.type = 'hidden';
                tokenInput.name = '_token';
                tokenInput.value = csrfToken;
                form.appendChild(tokenInput);
            }
        }
        
        // Handle form validation
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                const firstInvalid = form.querySelector('.border-red-500');
                if (firstInvalid) {
                    firstInvalid.focus();
                }
            }
        });
    });
    
    // Handle file upload previews
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.querySelector(`[data-preview-for="${input.id}"]`);
            
            if (file && preview) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (preview.tagName === 'IMG') {
                        preview.src = e.target.result;
                    } else {
                        preview.style.backgroundImage = `url(${e.target.result})`;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    });
}

// Utility functions
window.utils = {
    // Show/hide elements
    show: function(element) {
        if (typeof element === 'string') {
            element = document.querySelector(element);
        }
        if (element) {
            element.style.display = 'block';
        }
    },
    
    hide: function(element) {
        if (typeof element === 'string') {
            element = document.querySelector(element);
        }
        if (element) {
            element.style.display = 'none';
        }
    },
    
    toggle: function(element) {
        if (typeof element === 'string') {
            element = document.querySelector(element);
        }
        if (element) {
            element.style.display = element.style.display === 'none' ? 'block' : 'none';
        }
    },
    
    // Add/remove classes
    addClass: function(element, className) {
        if (typeof element === 'string') {
            element = document.querySelector(element);
        }
        if (element) {
            element.classList.add(className);
        }
    },
    
    removeClass: function(element, className) {
        if (typeof element === 'string') {
            element = document.querySelector(element);
        }
        if (element) {
            element.classList.remove(className);
        }
    },
    
    toggleClass: function(element, className) {
        if (typeof element === 'string') {
            element = document.querySelector(element);
        }
        if (element) {
            element.classList.toggle(className);
        }
    },
    
    // Simple notification system
    notify: function(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type}`;
        notification.textContent = message;
        notification.style.position = 'fixed';
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.zIndex = '9999';
        notification.style.maxWidth = '300px';
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
};

// Export for module compatibility
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { http: window.http, utils: window.utils };
}
