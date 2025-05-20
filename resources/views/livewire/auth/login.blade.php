<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diabetes Care - Login</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .dark body {
            background-color: #121212;
            color: #f3f4f6;
        }

        .container {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .dark .container {
            background-color: #1f2937;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .glucose-meter {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #f3f4f6;
            border: 2px solid #e5e7eb;
            overflow: hidden;
            opacity: 0.9;
        }

        .dark .glucose-meter {
            background-color: #374151;
            border: 2px solid #4b5563;
        }

        .meter-screen {
            width: 70%;
            height: 40%;
            background-color: #dcfce7;
            border-radius: 3px;
            margin: 6px auto 4px;
            position: relative;
            overflow: hidden;
        }

        .dark .meter-screen {
            background-color: #065f46;
        }

        .meter-button {
            width: 8px;
            height: 8px;
            background-color: #9ca3af;
            border-radius: 50%;
            margin: 2px auto;
        }

        .reading {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            font-weight: bold;
            color: #166534;
        }

        .dark .reading {
            color: #dcfce7;
        }

        .blood-drop {
            position: absolute;
            bottom: -20px;
            left: 50%;
            width: 8px;
            height: 12px;
            background-color: #ef4444;
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            transform: translateX(-50%);
            opacity: 0;
            animation: blood-test 3s infinite;
        }

        @keyframes blood-test {
            0% { bottom: -20px; opacity: 0; }
            15% { bottom: 5px; opacity: 1; }
            30% { bottom: 5px; opacity: 1; transform: translateX(-50%) scale(0.8); }
            40% { bottom: 5px; opacity: 0; transform: translateX(-50%) scale(0.5); }
            100% { bottom: 5px; opacity: 0; }
        }

        .reading-animation {
            animation: reading-change 3s infinite;
        }

        @keyframes reading-change {
            0% { opacity: 0; }
            40% { opacity: 0; }
            45% { opacity: 1; }
            95% { opacity: 1; }
            100% { opacity: 0; }
        }

        .pulse-ring {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: rgba(16, 185, 129, 0.3);
            opacity: 0;
            transform: scale(0.8);
        }

        .animate-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.8); opacity: 0; }
            50% { opacity: 0.5; }
            100% { transform: scale(1.5); opacity: 0; }
        }

        .header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #111827;
        }

        .dark .header h1 {
            color: #f9fafb;
        }

        .header p {
            color: #6b7280;
            font-size: 0.875rem;
            margin: 0;
        }

        .dark .header p {
            color: #d1d5db;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
        }

        .dark label {
            color: #d1d5db;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.625rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            background-color: #fff;
            color: #111827;
            transition: border-color 0.15s ease-in-out;
        }

        .dark input[type="email"],
        .dark input[type="password"] {
            background-color: #374151;
            border-color: #4b5563;
            color: #f9fafb;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: 2px solid #2563eb;
            border-color: transparent;
        }

        .dark input[type="email"]:focus,
        .dark input[type="password"]:focus {
            outline: 2px solid #3b82f6;
        }

        .forgot-password {
            position: absolute;
            right: 0;
            top: 0;
            font-size: 0.75rem;
            color: #2563eb;
            text-decoration: none;
        }

        .dark .forgot-password {
            color: #60a5fa;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
        }

        input[type="checkbox"] {
            margin-right: 0.5rem;
        }

        .checkbox-label {
            font-size: 0.875rem;
            color: #4b5563;
        }

        .dark .checkbox-label {
            color: #9ca3af;
        }

        button {
            width: 100%;
            padding: 0.625rem;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
        }

        button:hover {
            background-color: #1d4ed8;
        }

        .signup-text {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .dark .signup-text {
            color: #9ca3af;
        }

        .signup-link {
            color: #2563eb;
            text-decoration: none;
            margin-left: 0.25rem;
        }

        .dark .signup-link {
            color: #60a5fa;
        }

        /* Blood sugar range indicators */
        .range-indicators {
            position: absolute;
            bottom: 10px;
            left: 10px;
            display: flex;
            gap: 4px;
            opacity: 0.7;
        }

        .indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .low {
            background-color: #f59e0b;
        }

        .normal {
            background-color: #10b981;
        }

        .high {
            background-color: #ef4444;
        }

        /* Login animation */
        .login-animation {
            position: absolute;
            bottom: -100px;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #3b82f6, #8b5cf6);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .login-animation.active {
            opacity: 1;
            animation: progress 2s ease-in-out;
        }

        @keyframes progress {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Glucose Meter Animation -->
        <div class="glucose-meter">
            <div class="meter-screen">
                <div class="reading reading-animation">124</div>
                <div class="blood-drop"></div>
            </div>
            <div class="meter-button"></div>
            <div class="meter-button"></div>
            <div class="pulse-ring animate-pulse"></div>
            <div class="range-indicators">
                <div class="indicator low"></div>
                <div class="indicator normal"></div>
                <div class="indicator high"></div>
            </div>
        </div>

        <!-- Login Form -->
        <div class="header">
            <h1>Log in to your account</h1>
            <p>Enter your email and password below to log in</p>
        </div>

        <form id="loginForm">
            <div class="form-group">
                <div class="input-group">
                    <label for="email">Email address</label>
                    <input id="email" type="email" required autofocus autocomplete="email" placeholder="email@example.com">
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" required autocomplete="current-password" placeholder="Password">
                    <a href="#" class="forgot-password">Forgot your password?</a>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="remember">
                    <label for="remember" class="checkbox-label">Remember me</label>
                </div>
            </div>

            <button type="submit" id="loginButton">Log in</button>
            <div class="login-animation" id="loginProgress"></div>
        </form>

        <div class="signup-text">
            Don't have an account? <a href="#" class="signup-link">Sign up</a>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Start the login animation
            const progress = document.getElementById('loginProgress');
            progress.classList.add('active');

            // Simulate loading delay
            setTimeout(function() {
                // Change the glucose meter reading to show patient data is loading
                const reading = document.querySelector('.reading');
                reading.textContent = '...';

                // Simulate more loading time for diabetes data
                setTimeout(function() {
                    // Update glucose reading with "success" reading
                    reading.textContent = '118';

                    // Simulate redirect to dashboard
                    setTimeout(function() {
                        alert('Successfully logged in to your diabetes management account!');
                        progress.classList.remove('active');
                    }, 1000);
                }, 1000);
            }, 1000);
        });

        // Cycle through different glucose readings for the animation
        const readings = ['124', '118', '135', '106'];
        let currentIndex = 0;

        setInterval(() => {
            const reading = document.querySelector('.reading');
            currentIndex = (currentIndex + 1) % readings.length;
            reading.textContent = readings[currentIndex];
        }, 3000);
    </script>
</body>
</html>
