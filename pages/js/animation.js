// Smooth scrolling for navigation links
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

// Fade-in animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, observerOptions);

document.querySelectorAll('.fade-in').forEach(el => {
    observer.observe(el);
});

// Navbar scroll effect
let lastScrollTop = 0;
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > lastScrollTop && scrollTop > 100) {
        navbar.style.transform = 'translateY(-100%)';
    } else {
        navbar.style.transform = 'translateY(0)';
    }

    lastScrollTop = scrollTop;
});



// GSAP Animations
// Navbar animations
gsap.from(".navbar .logo", {
    y: -50,
    opacity: 0,
    duration: 1,
    ease: "power2.out"
});
gsap.from(".nav-links li", {
    y: -50,
    opacity: 0,
    duration: 1,
    stagger: 0.2,
    ease: "power2.out",
    delay: 0.2
});

// Hero section animations
gsap.from(".hero-content h1", {
    y: 50,
    opacity: 0,
    duration: 1.2,
    ease: "power3.out",
    delay: 0.5
});
gsap.from(".hero-subtitle", {
    y: 30,
    opacity: 0,
    duration: 1,
    ease: "power2.out",
    delay: 0.7
});


// Scroll-triggered animations for sections
gsap.utils.toArray(".overview, .organisation, .final-cta").forEach(section => {
    gsap.from(section, {
        scrollTrigger: {
            trigger: section,
            start: "top 80%",
            toggleActions: "play none none none"
        },
        y: 50,
        opacity: 0,
        duration: 1,
        ease: "power2.out"
    });
});

// Feature cards animations
gsap.utils.toArray(".feature-card").forEach(card => {
    gsap.from(card, {
        scrollTrigger: {
            trigger: card,
            start: "top 85%",
            toggleActions: "play none none none"
        },
        y: 30,
        opacity: 0,
        duration: 0.8,
        ease: "power2.out"
    });
    // Hover animation
    card.addEventListener("mouseenter", () => {
        gsap.to(card, {
            scale: 1.05,
            boxShadow: "0 20px 40px rgba(15, 157, 102, 0.3)",
            duration: 0.3,
            ease: "power2.out"
        });
    });
    card.addEventListener("mouseleave", () => {
        gsap.to(card, {
            scale: 1,
            boxShadow: "0 20px 40px rgba(15, 157, 102, 0)",
            duration: 0.3,
            ease: "power2.out"
        });
    });
});

// Team cards animations
gsap.utils.toArray(".team-card").forEach(card => {
    gsap.from(card, {
        scrollTrigger: {
            trigger: card,
            start: "top 85%",
            toggleActions: "play none none none"
        },
        y: 30,
        opacity: 0,
        duration: 0.8,
        ease: "power2.out"
    });
});

// Footer animation
gsap.from(".footer", {
    scrollTrigger: {
        trigger: ".footer",
        start: "top 90%",
        toggleActions: "play none none none"
    },
    y: 50,
    opacity: 0,
    duration: 1,
    ease: "power2.out"
});

gsap.fromTo(".nav-buttons", { opacity: 0, y: -50 }, { opacity: 1, y: 0, duration: 1 });

gsap.fromTo("hero-buttons", { opacity: 0, y: 50 }, { opacity: 1, y: 0, duration: 1, delay: 1.2 });