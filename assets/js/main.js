/**
 * ScodeTheme Main JavaScript - MI VIETNAM.VN Style
 * 
 * @package ScodeTheme
 */

(function() {
    'use strict';
    
    // DOM Ready
    document.addEventListener('DOMContentLoaded', function() {
        initTheme();
    });
    
    /**
     * Initialize theme functionality
     */
    function initTheme() {
        initMobileMenu();
        initSearch();
        initBackToTop();
        initSmoothScrolling();
        initProductCards();
        initCountdownTimer();
        initWooCommerce();
        initCategoryLinks();
        initSlideShow();
        initHeroCountdownTimer();
        initSmoothScroll();
        initProductShowcase();
        initCircularIconMenu();
    }
    
    /**
     * Mobile menu functionality
     */
    function initMobileMenu() {
        const categoryToggle = document.getElementById('category-toggle');
        const sidebarLeft = document.getElementById('sidebar-left');
        const body = document.body;
        
        if (categoryToggle && sidebarLeft) {
            categoryToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                sidebarLeft.classList.toggle('active');
                this.classList.toggle('active');
                body.classList.toggle('sidebar-open');
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!sidebarLeft.contains(e.target) && !categoryToggle.contains(e.target)) {
                    sidebarLeft.classList.remove('active');
                    categoryToggle.classList.remove('active');
                    body.classList.remove('sidebar-open');
                }
            });
            
            // Close menu on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebarLeft.classList.contains('active')) {
                    sidebarLeft.classList.remove('active');
                    categoryToggle.classList.remove('active');
                    body.classList.remove('sidebar-open');
                }
            });
            
            // Add overlay for mobile
            const overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            `;
            
            document.body.appendChild(overlay);
            
            // Show/hide overlay
            categoryToggle.addEventListener('click', function() {
                if (sidebarLeft.classList.contains('active')) {
                    overlay.style.opacity = '1';
                    overlay.style.visibility = 'visible';
                } else {
                    overlay.style.opacity = '0';
                    overlay.style.visibility = 'hidden';
                }
            });
            
            // Close menu when clicking overlay
            overlay.addEventListener('click', function() {
                sidebarLeft.classList.remove('active');
                categoryToggle.classList.remove('active');
                body.classList.remove('sidebar-open');
                overlay.style.opacity = '0';
                overlay.style.visibility = 'hidden';
            });
        }
    }
    
    /**
     * Search functionality
     */
    function initSearch() {
        const searchForm = document.querySelector('.search-form');
        const searchInput = document.querySelector('.search-input');
        
        if (searchForm && searchInput) {
            // Auto-focus search input
            searchInput.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            searchInput.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
            
            // Search suggestions (placeholder for future implementation)
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                if (query.length > 2) {
                    // Implement search suggestions here
                    console.log('Search query:', query);
                }
            });
        }
    }
    
    /**
     * Back to top functionality
     */
    function initBackToTop() {
        const backToTop = document.getElementById('back-to-top');
        
        if (backToTop) {
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTop.classList.add('visible');
                } else {
                    backToTop.classList.remove('visible');
                }
            });
            
            backToTop.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    }
    
    /**
     * Smooth scrolling for anchor links
     */
    function initSmoothScrolling() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }
    
    /**
     * Product card interactions
     */
    function initProductCards() {
        const productCards = document.querySelectorAll('.product-card');
        
        productCards.forEach(card => {
            // Hover effects
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
            
            // Quick view functionality (placeholder)
            const quickViewBtn = card.querySelector('.quick-view-btn');
            if (quickViewBtn) {
                quickViewBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;
                    openQuickView(productId);
                });
            }
        });
    }
    
    /**
     * Category links functionality
     */
    function initCategoryLinks() {
        const categoryItems = document.querySelectorAll('.category-item');
        
        categoryItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    }
    
    /**
     * Countdown timer for flash sale
     */
    function initCountdownTimer() {
        const countdownTimer = document.getElementById('countdown-timer');
        
        if (countdownTimer) {
            let countdownInterval = setInterval(updateCountdown, 1000);
            
            function updateCountdown() {
                const now = new Date().getTime();
                const endTime = new Date().getTime() + (24 * 60 * 60 * 1000); // 24 hours from now
                
                const distance = endTime - now;
                
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                const hoursElement = document.getElementById('countdown-hours');
                const minutesElement = document.getElementById('countdown-minutes');
                const secondsElement = document.getElementById('countdown-seconds');
                
                if (hoursElement && minutesElement && secondsElement) {
                    hoursElement.textContent = hours.toString().padStart(2, '0');
                    minutesElement.textContent = minutes.toString().padStart(2, '0');
                    secondsElement.textContent = seconds.toString().padStart(2, '0');
                }
                
                if (distance < 0) {
                    clearInterval(countdownInterval);
                    if (countdownTimer) {
                        countdownTimer.innerHTML = '<span>Flash Sale đã kết thúc!</span>';
                    }
                }
            }
            
            updateCountdown(); // Initial call
        }
    }
    
    /**
     * WooCommerce specific functionality
     */
    function initWooCommerce() {
        if (typeof scode_ajax !== 'undefined' && scode_ajax.is_woocommerce) {
            initAddToCart();
            initCartCount();
        }
    }
    
    /**
     * Add to cart functionality
     */
    function initAddToCart() {
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-to-cart')) {
                const productId = e.target.dataset.productId;
                if (productId) {
                    addToCart(productId, e.target);
                }
            }
        });
    }
    
    /**
     * Add product to cart via AJAX
     */
    function addToCart(productId, button) {
        const originalText = button.textContent;
        button.textContent = 'Đang thêm...';
        button.disabled = true;
        
        fetch(scode_ajax.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=add_to_cart&product_id=' + productId
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                button.textContent = 'Đã thêm!';
                updateCartCount();
                
                // Show success message
                showNotification('Sản phẩm đã được thêm vào giỏ hàng!', 'success');
                
                // Reset button after 2 seconds
                setTimeout(() => {
                    button.textContent = originalText;
                    button.disabled = false;
                }, 2000);
            } else {
                button.textContent = 'Lỗi!';
                button.disabled = false;
                showNotification('Không thể thêm sản phẩm vào giỏ hàng.', 'error');
            }
        })
        .catch(error => {
            button.textContent = 'Lỗi!';
            button.disabled = false;
            showNotification('Đã xảy ra lỗi khi thêm sản phẩm.', 'error');
        });
    }
    
    /**
     * Update cart count
     */
    function initCartCount() {
        updateCartCount();
    }
    
    function updateCartCount() {
        fetch(scode_ajax.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=get_cart_count'
        })
        .then(response => response.json())
        .then(data => {
            const cartCount = document.querySelector('.cart-count');
            if (cartCount && data.count !== undefined) {
                cartCount.textContent = data.count;
            }
        })
        .catch(error => {
            console.error('Error updating cart count:', error);
        });
    }
    
    /**
     * Show notification
     */
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        // Add styles
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            max-width: 300px;
        `;
        
        // Set background color based on type
        switch (type) {
            case 'success':
                notification.style.backgroundColor = '#10b981';
                break;
            case 'error':
                notification.style.backgroundColor = '#ef4444';
                break;
            case 'warning':
                notification.style.backgroundColor = '#f59e0b';
                break;
            default:
                notification.style.backgroundColor = '#f26522';
        }
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remove after 5 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 5000);
    }
    
    /**
     * Open quick view modal (placeholder)
     */
    function openQuickView(productId) {
        console.log('Opening quick view for product:', productId);
        // Implement quick view functionality here
    }
    
    /**
     * Slide show functionality
     */
    function initSlideShow() {
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.slide-dot');
        const prevArrow = document.querySelector('.slide-arrow.prev');
        const nextArrow = document.querySelector('.slide-arrow.next');
        let currentSlide = 0;

        function showSlide(index) {
            // Hide all slides
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            // Show current slide
            if (slides[index]) {
                slides[index].classList.add('active');
            }
            if (dots[index]) {
                dots[index].classList.add('active');
            }
            
            currentSlide = index;
        }

        function nextSlide() {
            const next = (currentSlide + 1) % slides.length;
            showSlide(next);
        }

        function prevSlide() {
            const prev = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(prev);
        }

        // Event listeners
        if (dots.length > 0) {
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => showSlide(index));
            });
        }

        if (prevArrow) {
            prevArrow.addEventListener('click', prevSlide);
        }

        if (nextArrow) {
            nextArrow.addEventListener('click', nextSlide);
        }

        // Auto-advance slides every 5 seconds
        if (slides.length > 1) {
            setInterval(nextSlide, 5000);
        }
    }

    /**
     * Utility functions
     */
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }
    
    /**
     * Hero Banner Special Offer Countdown Timer
     */
    function initHeroCountdownTimer() {
        const countdownElement = document.querySelector('.countdown');
        if (!countdownElement) return;

        // Set target date (24 hours from now)
        const targetDate = new Date();
        targetDate.setHours(targetDate.getHours() + 24);

        function updateCountdown() {
            const now = new Date();
            const difference = targetDate - now;

            if (difference > 0) {
                const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                countdownElement.textContent = 
                    `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            } else {
                countdownElement.textContent = '00:00:00';
                countdownElement.style.background = '#ef4444';
            }
        }

        // Update every second
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    /**
     * Smooth scroll for anchor links
     */
    function initSmoothScroll() {
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        
        anchorLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    /**
     * Product showcase hover effects
     */
    function initProductShowcase() {
        const heroProducts = document.querySelectorAll('.hero-product');
        
        heroProducts.forEach(product => {
            product.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-15px) scale(1.02)';
            });
            
            product.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    }

    /**
     * Circular icon menu interactions
     */
    function initCircularIconMenu() {
        const circularIcons = document.querySelectorAll('.circular-icon-item');
        
        circularIcons.forEach(icon => {
            icon.addEventListener('mouseenter', function() {
                const glow = this.querySelector('.icon-glow');
                if (glow) {
                    glow.style.animationDuration = '1s';
                }
            });
            
            icon.addEventListener('mouseleave', function() {
                const glow = this.querySelector('.icon-glow');
                if (glow) {
                    glow.style.animationDuration = '3s';
                }
            });
        });
    }
    
    // Expose functions globally if needed
    window.scodeTheme = {
        showNotification,
        addToCart,
        updateCartCount
    };
    
})();
