<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - AstraCore.cloud</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #0a0a0a;
            color: #f9f9f9;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Animated Grid Background */
        .grid-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.3;
            background-image: 
                linear-gradient(rgba(15, 157, 102, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(15, 157, 102, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Holographic overlay effects */
        .grid-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(15, 157, 102, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(16, 185, 129, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 40% 80%, rgba(15, 157, 102, 0.08) 0%, transparent 50%);
            animation: holographicShift 15s ease-in-out infinite;
        }

        @keyframes holographicShift {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.05); }
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(15, 157, 102, 0.2);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: slideDown 0.8s ease-out;
        }

        @keyframes slideDown {
            from { transform: translateY(-100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #f9f9f9;
            text-decoration: none;
            position: relative;
        }

        .logo::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #0f9d66, #10b981);
            transition: width 0.3s ease;
        }

        .logo:hover::after {
            width: 100%;
        }

        .nav-links {
            display: flex;
            gap: 1rem;
        }

        .nav-link {
            color: #e9e9e9;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .nav-link:hover {
            color: #0f9d66;
            border-color: rgba(15, 157, 102, 0.3);
            background: rgba(15, 157, 102, 0.05);
        }

        /* Main Container */
        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            padding-top: 6rem;
        }

        /* Auth Card */
        .auth-card {
            background: rgba(10, 10, 10, 0.8);
            border: 1px solid rgba(15, 157, 102, 0.2);
            border-radius: 16px;
            padding: 3rem;
            max-width: 450px;
            width: 100%;
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4),
                        0 0 0 1px rgba(15, 157, 102, 0.1),
                        inset 0 1px 0 rgba(255, 255, 255, 0.1);
            animation: cardFadeIn 1s ease-out;
            position: relative;
            overflow: hidden;
        }

        @keyframes cardFadeIn {
            from { 
                opacity: 0; 
                transform: translateY(30px) scale(0.95); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(15, 157, 102, 0.1), transparent);
            animation: cardRotate 10s linear infinite;
            z-index: -1;
        }

        @keyframes cardRotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #f9f9f9, #e9e9e9);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: titleGlow 2s ease-in-out infinite alternate;
        }

        @keyframes titleGlow {
            from { filter: drop-shadow(0 0 10px rgba(15, 157, 102, 0.3)); }
            to { filter: drop-shadow(0 0 20px rgba(15, 157, 102, 0.5)); }
        }

        .auth-subtitle {
            color: #e9e9e9;
            opacity: 0.8;
            font-size: 0.9rem;
        }

        /* Form Styles */
        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            transition: transform 0.3s ease;
        }

        .form-label {
            color: #e9e9e9;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .form-input {
            background: rgba(249, 249, 249, 0.05);
            border: 1px solid rgba(233, 233, 233, 0.2);
            border-radius: 8px;
            padding: 0.875rem 1rem;
            color: #f9f9f9;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input::placeholder {
            color: rgba(233, 233, 233, 0.5);
        }

        .form-input:focus {
            border-color: #0f9d66;
            box-shadow: 0 0 0 3px rgba(15, 157, 102, 0.1),
                        0 0 20px rgba(15, 157, 102, 0.2);
            background: rgba(249, 249, 249, 0.08);
            transform: translateY(-1px);
        }

        /* Buttons */
        .btn {
            padding: 0.875rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0f9d66, #10b981);
            color: white;
            box-shadow: 0 4px 20px rgba(15, 157, 102, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(15, 157, 102, 0.4);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover:not(:disabled)::before {
            left: 100%;
        }

        /* Social Login */
        .social-login {
            margin: 1.5rem 0;
        }

        .social-divider {
            display: flex;
            align-items: center;
            margin: 1rem 0;
            color: rgba(233, 233, 233, 0.6);
            font-size: 0.875rem;
        }

        .social-divider::before,
        .social-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(233, 233, 233, 0.2);
        }

        .social-divider::before {
            margin-right: 1rem;
        }

        .social-divider::after {
            margin-left: 1rem;
        }

        .social-buttons {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
        }

        .social-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(249, 249, 249, 0.05);
            border: 1px solid rgba(233, 233, 233, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #e9e9e9;
            font-weight: 600;
        }

        .social-btn:hover {
            border-color: #0f9d66;
            background: rgba(15, 157, 102, 0.1);
            transform: translateY(-2px);
        }

        /* Links */
        .auth-link {
            color: #0f9d66;
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .auth-link:hover {
            color: #10b981;
            text-shadow: 0 0 10px rgba(15, 157, 102, 0.5);
        }

        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(233, 233, 233, 0.1);
        }

        /* Footer */
        .footer {
            background: #0a0a0a;
            border-top: 1px solid rgba(15, 157, 102, 0.2);
            padding: 2rem;
            text-align: center;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 1rem;
        }

        .footer-link {
            color: #e9e9e9;
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: #0f9d66;
        }

        .footer-copyright {
            color: rgba(233, 233, 233, 0.6);
            font-size: 0.875rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                padding: 1rem;
            }
            
            .auth-card {
                padding: 2rem;
                margin: 1rem;
            }
            
            .main-container {
                padding: 1rem;
                padding-top: 5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Grid Background -->
    <div class="grid-background"></div>

    <!-- Navigation -->
    <nav class="navbar">
        <a href="#" class="logo">AstraCore</a>
        <div class="nav-links">
            <a href="#" class="nav-link" onclick="showLoginDemo()">Login</a>
        </div>
    </nav>

    <!-- Signup Page -->
    <div class="main-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Create your AstraCore account</h1>
                <p class="auth-subtitle">Join the future of cloud computing and data intelligence</p>
            </div>

            <form class="auth-form" onsubmit="handleSubmit(event)">
                <div class="form-group">
                    <label class="form-label" for="signup-name">Full Name</label>
                    <input 
                        type="text" 
                        id="signup-name" 
                        class="form-input" 
                        placeholder="Enter your full name"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="signup-email">Email Address</label>
                    <input 
                        type="email" 
                        id="signup-email" 
                        class="form-input" 
                        placeholder="you@company.com"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="signup-password">Password</label>
                    <input 
                        type="password" 
                        id="signup-password" 
                        class="form-input" 
                        placeholder="Create a strong password"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="signup-confirm">Confirm Password</label>
                    <input 
                        type="password" 
                        id="signup-confirm" 
                        class="form-input" 
                        placeholder="Confirm your password"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary">Create Account</button>
            </form>

            <div class="social-login">
                <div class="social-divider">or continue with</div>
                <div class="social-buttons">
                    <button class="social-btn" title="Continue with Google">G</button>
                    <button class="social-btn" title="Continue with GitHub">GH</button>
                    <button class="social-btn" title="Continue with Discord">D</button>
                </div>
            </div>

            <div class="auth-footer">
                <p>Already have an account? <a href="#" class="auth-link" onclick="showLoginDemo()">Sign in here</a></p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-links">
            <a href="#" class="footer-link">Privacy Policy</a>
            <a href="#" class="footer-link">Terms of Service</a>
            <a href="#" class="footer-link">Contact Support</a>
        </div>
        <div class="footer-copyright">
            © 2025 AstraCore.cloud - All rights reserved
        </div>
    </footer>

    <script>
        // Form submission handler
        function handleSubmit(event) {
            event.preventDefault();
            const form = event.target;
            
            // Password confirmation validation
            const password = document.getElementById('signup-password').value;
            const confirmPassword = document.getElementById('signup-confirm').value;
            
            if (password !== confirmPassword) {
                alert('Passwords do not match. Please try again.');
                return;
            }
            
            // Add loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Creating Account...';
            submitBtn.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                alert('Account created successfully! Welcome to AstraCore.');
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
                form.reset();
            }, 2000);
        }

        // Enhanced input focus effects
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', () => {
                input.parentElement.style.transform = 'translateY(0)';
            });
        });

        // Social button interactions
        document.querySelectorAll('.social-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                alert(`${btn.title} integration coming soon!`);
            });
        });

        // Demo navigation (since we can't actually navigate to separate files)
        function showLoginDemo() {
            alert('In a real implementation, this would navigate to login.html. For now, I\'ll create the login page as a separate artifact.');
        }

        // Add subtle mouse movement parallax effect
        document.addEventListener('mousemove', (e) => {
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;
            
            const background = document.querySelector('.grid-background');
            const translateX = (mouseX - 0.5) * 20;
            const translateY = (mouseY - 0.5) * 20;
            
            background.style.transform = `translate(${translateX}px, ${translateY}px)`;
        });
    </script>
</body>
</html>