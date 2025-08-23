/**
 * Product Detail Page JavaScript
 * Enhanced version with sticky bar and smooth interactions
 * 
 * @package SCODE_Theme
 * @version 2.0.0
 */

(function() {
    'use strict';
    
    // ===== VARIABLES =====
    let stickyBar = null;
    let countdownTimer = null;
    let isStickyVisible = false;
    
    // ===== INITIALIZATION =====
    function init() {
        if (!document.querySelector('.otnt-pdp')) return;
        
        console.log('=== PDP JS INITIALIZED ===');
        
        initStickyBar();
        initCountdown();
        initVideoThumbs();
        initSmoothAnimations();
        initScrollEffects();
        
        console.log('=== PDP JS READY ===');
    }
    
    // ===== STICKY BAR FUNCTIONALITY =====
    function initStickyBar() {
        stickyBar = document.getElementById('otnt-sticky');
        if (!stickyBar) return;
        
        console.log('Sticky bar initialized');
        
        // Show sticky bar on scroll
        window.addEventListener('scroll', handleStickyBarScroll);
        
        // Add smooth scroll to buttons
        const stickyButtons = stickyBar.querySelectorAll('.button');
        stickyButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                if (href) {
                    window.location.href = href;
                }
            });
        });
    }
    
    function handleStickyBarScroll() {
        if (!stickyBar) return;
        
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight;
        
        // Show sticky bar when user scrolls down 300px or near bottom
        if (scrollTop > 300 || scrollTop + windowHeight > documentHeight - 100) {
            if (!isStickyVisible) {
                showStickyBar();
            }
        } else {
            if (isStickyVisible) {
                hideStickyBar();
            }
        }
    }
    
    function showStickyBar() {
        if (!stickyBar) return;
        
        stickyBar.classList.add('show');
        isStickyVisible = true;
        
        // Add entrance animation
        stickyBar.style.animation = 'slideInUp 0.3s ease-out';
        
        console.log('Sticky bar shown');
    }
    
    function hideStickyBar() {
        if (!stickyBar) return;
        
        stickyBar.classList.remove('show');
        isStickyVisible = false;
        
        console.log('Sticky bar hidden');
    }
    
    // ===== COUNTDOWN FUNCTIONALITY =====
    function initCountdown() {
        const countdownElement = document.querySelector('.otnt-countdown');
        if (!countdownElement) return;
        
        const deadline = countdownElement.dataset.deadline;
        if (!deadline) return;
        
        console.log('Countdown initialized with deadline:', deadline);
        
        // Start countdown
        startCountdown(countdownElement, deadline);
    }
    
    function startCountdown(element, deadline) {
        const timeElement = element.querySelector('.otnt-countdown__time');
        if (!timeElement) return;
        
        function updateCountdown() {
            const now = new Date().getTime();
            const target = new Date(deadline).getTime();
            const difference = target - now;
            
            if (difference <= 0) {
                // Time's up
                timeElement.textContent = '00:00:00';
                element.style.background = 'linear-gradient(135deg, #ffebee, #fff)';
                element.style.borderColor = '#f44336';
                element.querySelector('.otnt-countdown__label').textContent = 'KẾT THÚC';
                return;
            }
            
            // Calculate time units
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);
            
            // Format time
            const timeString = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            timeElement.textContent = timeString;
            
            // Add urgency effect when less than 1 hour
            if (hours === 0 && minutes < 60) {
                element.style.animation = 'pulse 1s infinite';
                element.style.borderColor = '#ff5722';
            }
        }
        
        // Update immediately and then every second
        updateCountdown();
        countdownTimer = setInterval(updateCountdown, 1000);
    }
    
    // ===== VIDEO THUMBNAILS =====
    function initVideoThumbs() {
        const videoThumbs = document.querySelectorAll('.otnt-video-thumb');
        if (videoThumbs.length === 0) return;
        
        console.log('Video thumbnails initialized:', videoThumbs.length);
        
        videoThumbs.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const videoUrl = this.dataset.video;
                if (videoUrl) {
                    openVideoModal(videoUrl);
                }
            });
            
            // Add hover effect
            thumb.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
            });
            
            thumb.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    }
    
    function openVideoModal(videoUrl) {
        // Extract YouTube video ID
        const videoId = extractYouTubeId(videoUrl);
        if (!videoId) return;
        
        // Create modal
        const modal = document.createElement('div');
        modal.className = 'video-modal';
        modal.innerHTML = `
            <div class="video-modal-content">
                <button class="video-modal-close">&times;</button>
                <div class="video-container">
                    <iframe src="https://www.youtube.com/embed/${videoId}?autoplay=1" 
                            frameborder="0" 
                            allowfullscreen>
                    </iframe>
                </div>
            </div>
        `;
        
        // Add to page
        document.body.appendChild(modal);
        
        // Show modal
        setTimeout(() => modal.classList.add('show'), 10);
        
        // Close functionality
        const closeBtn = modal.querySelector('.video-modal-close');
        closeBtn.addEventListener('click', () => closeVideoModal(modal));
        
        // Close on outside click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeVideoModal(modal);
            }
        });
        
        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeVideoModal(modal);
            }
        });
        
        console.log('Video modal opened for:', videoId);
    }
    
    function closeVideoModal(modal) {
        modal.classList.remove('show');
        setTimeout(() => {
            if (modal.parentNode) {
                modal.parentNode.removeChild(modal);
            }
        }, 300);
    }
    
    function extractYouTubeId(url) {
        const regex = /(?:youtu\.be\/|youtube\.com\/(?:shorts\/|watch\?v=|embed\/))([A-Za-z0-9_-]{6,})/;
        const match = url.match(regex);
        return match ? match[1] : null;
    }
    
    // ===== SMOOTH ANIMATIONS =====
    function initSmoothAnimations() {
        // Add intersection observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
    
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        // Observe elements for animation
        const animatedElements = document.querySelectorAll('.otnt-save, .otnt-countdown, .otnt-gifts, .otnt-policies, .otnt-hotline, .otnt-specs');
        animatedElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    }
    
    // ===== SCROLL EFFECTS =====
    function initScrollEffects() {
        let ticking = false;
        
        function updateScrollEffects() {
            if (ticking) return;
            
            ticking = true;
            requestAnimationFrame(() => {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                // Parallax effect for gallery
                const gallery = document.querySelector('.otnt-pdp__gallery');
                if (gallery) {
                    const scrolled = scrollTop * 0.1;
                    gallery.style.transform = `translateY(${scrolled}px)`;
                }
                
                // Fade effect for summary
                const summary = document.querySelector('.otnt-pdp__summary');
                if (summary && window.innerWidth > 1024) {
                    const opacity = Math.max(0.8, 1 - (scrollTop * 0.001));
                    summary.style.opacity = opacity;
                }
                
                ticking = false;
            });
        }
        
        window.addEventListener('scroll', updateScrollEffects);
    }
    
    // ===== UTILITY FUNCTIONS =====
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
    
    // ===== EVENT LISTENERS =====
    document.addEventListener('DOMContentLoaded', init);
    
    // Handle window resize
    window.addEventListener('resize', debounce(() => {
        if (stickyBar && window.innerWidth <= 768) {
            // Adjust sticky bar for mobile
            stickyBar.style.bottom = '-120px';
        }
    }, 250));
    
    // Handle page visibility change
    document.addEventListener('visibilitychange', () => {
        if (document.hidden && countdownTimer) {
            // Pause countdown when page is hidden
            clearInterval(countdownTimer);
        } else if (!document.hidden && countdownTimer === null) {
            // Resume countdown when page becomes visible
            initCountdown();
        }
    });
    
    // ===== EXPOSE TO GLOBAL SCOPE =====
    window.OTNT_PDP = {
        showStickyBar,
        hideStickyBar,
        openVideoModal
    };
    
})();