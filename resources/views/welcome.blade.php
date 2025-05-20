<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <title>{{ env('APP_NAME', 'DiabetaCare') }}</title>
    <style>
        /* Color palette */
        :root {
            --primary: #0891b2;
            --primary-light: #22d3ee;
            --primary-dark: #0e7490;
            --secondary: #6366f1;
            --secondary-light: #a5b4fc;
            --accent: #f59e0b;
            --accent-light: #fcd34d;
            --success: #10b981;
            --warning: #f97316;
            --danger: #ef4444;
            --neutral-light: #f8fafc;
            --neutral: #cbd5e1;
            --neutral-dark: #475569;
            --background: #f8fafc;
            --text: #1e293b;
            --text-light: #64748b;
        }

        /* Animations */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }
            70% {
                transform: scale(1.1);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Animation classes */
        .animate-slide-in-left {
            animation: slideInLeft 0.5s ease-out forwards;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.5s ease-out forwards;
        }

        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }

        .animate-bounce-in {
            animation: bounceIn 0.5s ease-out forwards;
        }

        /* Body and base styles */
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text);
            background-color: var(--background);
            margin: 0;
            padding: 0;
        }

        /* Layout styles */
        .background-container {
            position: relative;
            width: 100vw;
            min-height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .background-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            filter: brightness(1.5) saturate(1.2);
            z-index: 1;
        }

        /* Header styles */
        .header {
            position: relative;
            z-index: 3;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            background: linear-gradient(90deg, rgba(8, 145, 178, 0.95) 0%, rgba(99, 102, 241, 0.9) 100%);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: gradient 15s ease infinite;
            background-size: 200% 200%;
        }

        .logo {
            height: 60px;
            width: auto;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .app-name {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .app-tagline {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
            margin-top: 0.2rem;
        }

        /* Content styles */
        .content-overlay {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 16px;
            margin: 2rem auto;
            max-width: 1200px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(203, 213, 225, 0.5);
        }

        /* Card container */
        .cards-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 2.5rem;
            margin: 3rem 0;
        }

        /* Card styles */
        .card {
            width: 320px;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            transition: height 0.3s ease;
        }

        .card:nth-child(1) {
            background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
            border: 1px solid rgba(8, 145, 178, 0.2);
        }

        .card:nth-child(1)::before {
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 100%);
        }

        .card:nth-child(2) {
            background: linear-gradient(135deg, #ffffff 0%, #eff6ff 100%);
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .card:nth-child(2)::before {
            background: linear-gradient(90deg, var(--secondary) 0%, var(--secondary-light) 100%);
        }

        .card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .card:hover::before {
            height: 12px;
        }

        .card img {
            width: 160px;
            height: auto;
            margin: 1rem auto;
            transition: transform 0.4s ease;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.15));
        }

        .card:hover img {
            transform: scale(1.08) translateY(-5px);
        }

        .card h2 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0.5rem 0;
            background: linear-gradient(90deg, var(--primary-dark) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card p {
            font-size: 1rem;
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .card-button {
            margin-top: auto;
            padding: 0.9rem 1.75rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            z-index: 1;
            color: white;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card:nth-child(1) .card-button {
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
        }

        .card:nth-child(2) .card-button {
            background: linear-gradient(90deg, var(--secondary) 0%, var(--primary-dark) 100%);
        }

        .card-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s ease;
            z-index: -1;
        }

        .card-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .card-button:hover::before {
            left: 100%;
        }

        /* App presentation styles */
        .app-presentation {
            max-width: 900px;
            margin: 4rem auto;
            padding: 2.5rem;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(203, 213, 225, 0.5);
        }

        .app-presentation h2 {
            font-size: 2.2rem;
            margin-bottom: 1.5rem;
            text-align: center;
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .app-presentation p {
            font-size: 1.1rem;
            line-height: 1.7;
            color: var(--text-light);
            text-align: center;
            margin-bottom: 2rem;
        }

        .app-features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-item {
            flex: 1 1 250px;
            max-width: 300px;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(203, 213, 225, 0.3);
            position: relative;
            overflow: hidden;
        }

        .feature-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            transition: all 0.3s ease;
        }

        .feature-item:nth-child(1)::before {
            background: var(--primary);
        }

        .feature-item:nth-child(2)::before {
            background: var(--secondary);
        }

        .feature-item:nth-child(3)::before {
            background: var(--accent);
        }

        .feature-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }

        .feature-item:hover::before {
            height: 8px;
        }

        .feature-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
            padding-bottom: 0.5rem;
        }

        .feature-item:nth-child(1) .feature-title {
            color: var(--primary);
        }

        .feature-item:nth-child(2) .feature-title {
            color: var(--secondary);
        }

        .feature-item:nth-child(3) .feature-title {
            color: var(--accent);
        }

        .feature-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 25%;
            width: 50%;
            height: 2px;
            background: currentColor;
            opacity: 0.5;
        }

        .feature-item p {
            font-size: 1rem;
            color: var(--text-light);
            line-height: 1.6;
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .content-overlay {
                margin: 2rem 1rem;
                padding: 2rem;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
                padding: 1.5rem 1rem;
            }

            .app-name {
                font-size: 1.8rem;
            }

            .cards-container {
                flex-direction: column;
                align-items: center;
                gap: 2rem;
            }

            .app-features {
                flex-direction: column;
                align-items: center;
                gap: 1.5rem;
            }

            .feature-item {
                max-width: 100%;
                padding: 1.75rem;
            }

            .app-presentation h2 {
                font-size: 1.8rem;
            }

            .app-presentation p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="background-container">
        <!-- Background Image -->
        <div class="background-image"></div>

        <!-- Header with Logo and Name -->
        <header class="header animate-slide-in-left">
            <img src="{{ asset('logo.png') }}" alt="DiabetaCare Logo" class="logo">
            <div>
                <div class="app-name">{{ env('APP_NAME', 'DiabetaCare') }}</div>
                <div class="app-tagline">Diabetes Management System</div>
            </div>
        </header>

        <div class="content-overlay">
            <!-- App Introduction -->
            <div class="app-presentation animate-fade-in">
                <h2 class="animate-slide-in-left">Welcome to DiabeteCare</h2>
                <p class="my-4">
                    Our innovative platform offers a comprehensive solution for monitoring and managing diabetes.
                    Designed to facilitate communication between patients and doctors, it enables personalized
                    and real-time tracking of essential diabetes-related parameters.
                </p>

                <!-- Features Section -->
                <div class="app-features">
                    <div class="feature-item animate-bounce-in" style="animation-delay: 0.2s;">
                        <div class="feature-title">Glucose Monitoring</div>
                        <p>Record and visualize your blood glucose levels with intuitive charts and detailed trend analysis</p>
                    </div>

                    <div class="feature-item animate-bounce-in" style="animation-delay: 0.4s;">
                        <div class="feature-title">Insulin Calculator</div>
                        <p>Accurately estimate your insulin doses based on your meals and glucose readings with our smart algorithm</p>
                    </div>

                    <div class="feature-item animate-bounce-in" style="animation-delay: 0.6s;">
                        <div class="feature-title">Medical Dashboard</div>
                        <p>Share your data with your healthcare team for optimized medical monitoring and personalized care plans</p>
                    </div>
                </div>
            </div>

            <!-- User Role Cards -->
            <div class="cards-container">
                <!-- Patient Card -->
                <div class="card animate-slide-in-left">
                    <img src="{{ asset('patient.jpeg') }}" alt="Patient illustration">
                    <h2>Patient</h2>
                    <p>
                        Continue as a patient, add your medical characteristics and receive guidance from our doctors
                    </p>
                    <a href="{{ route('filament.patient.pages.dashboard') }}" class="card-button">
                      Continuer en tant que patient
                    </a>
                </div>

                <!-- Doctor Card -->
                <div class="card animate-slide-in-right">
                    <img src="{{ asset('doctor.jpeg') }}" alt="Doctor illustration">
                    <h2>Doctor</h2>
                    <p>
                        Continue as a doctor, review patient information and provide medical insights
                    </p>
                    <a href="{{ route('filament.doctor.pages.dashboard') }}" class="card-button">
                        Continuer en tant que medecin
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background: linear-gradient(90deg, rgba(8, 145, 178, 0.95) 0%, rgba(99, 102, 241, 0.9) 100%); padding: 20px; text-align: center; color: white; margin-top: 40px; position: relative; z-index: 10;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px;">
                <div>
                    <h3 style="margin: 0; font-size: 1.2rem; font-weight: 600;">DiabetaCare</h3>
                    <p style="margin: 5px 0 0; font-size: 0.9rem;">Diabetes Management System</p>
                </div>
                <div style="display: flex; gap: 20px;">
                    <a href="#" style="color: white; text-decoration: none; font-size: 0.9rem;">Privacy Policy</a>
                    <a href="#" style="color: white; text-decoration: none; font-size: 0.9rem;">Terms of Service</a>
                    <a href="#" style="color: white; text-decoration: none; font-size: 0.9rem;">Contact Us</a>
                </div>
            </div>
            <div style="margin-top: 20px; font-size: 0.8rem;">
                &copy; 2025 DiabetaCare. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
