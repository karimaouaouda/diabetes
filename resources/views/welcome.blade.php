<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title> {{ env('APP_NAME') }} </title>
    <style>
        /* Existing animations... */
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

        .animate-slide-in-left {
            animation: slideInLeft 0.5s ease-out forwards;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.5s ease-out forwards;
        }

        /* New background styles */
        .background-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }

        .background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            filter: brightness(1.7);
            z-index: 1;
        }

        .content-overlay {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
        }
    </style>
     <!-- ... (keep existing head content) ... -->
     <style>
        /* Add header styles */
        .header {
            position: relative;
            z-index: 3;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            animation: slideInLeft 0.5s ease-out forwards;
        }

        .logo {
            height: 50px;
            width: auto;
        }

        .app-name {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0ea5e9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .app-tagline {
            font-size: 0.9rem;
            color: #64748b;
            margin-top: 0.2rem;
        }
    </style>
</head>
<body>
     <div class="background-container">
        <!-- Added Header with Logo and Name -->
        <header class="header">
            <img src="{{ asset('logo.png') }}" alt="Diabetes Care Logo" class="logo">
            <div>
                <div class="app-name">{{ env('APP_NAME', 'DiabetaCare') }}</div>
                <div class="app-tagline">Diabetes Management System</div>
            </div>
        </header>

        <div class="background-image"></div>

        <!-- Existing content overlay with cards -->
        <div class="w-screen min-h-screen flex items-center justify-center space-x-10 content-overlay">
            <!-- ... (keep existing patient and doctor cards) ... -->
        </div>
    </div>
    <div class="background-container">
        <div class="background-image"></div>
        <div class="w-screen min-h-screen flex items-center justify-center space-x-10 content-overlay">
            <!-- Patient Card -->
            <div class="card w-72 flex flex-col space-y-4 p-4 border shadow rounded-md items-center transition-all duration-300 hover:scale-105 hover:shadow-lg group animate-slide-in-left">
                <img src="{{ asset('patient.jpeg') }}"
                     class="w-40 h-auto transition-transform duration-300 ease-in-out group-hover:scale-105"
                     alt="Patient illustration">
                <h1 class="text-xl text-slate-800">
                    Patient
                </h1>
                <p class="text-sm font-semibold">
                    Continue as a patient, add medical characteristics and see results from our doctors
                </p>
                <a href="{{ route('filament.patient.pages.dashboard') }}"
                   class="p-2 rounded bg-sky-500 hover:bg-sky-800 duration-300 ease-in-out text-white transition-all hover:-translate-y-1">
                    Continue as a patient
                </a>
            </div>

            <!-- Doctor Card -->
            <div class="card w-72 flex flex-col space-y-4 p-4 border shadow rounded-md items-center transition-all duration-300 hover:scale-105 hover:shadow-lg group animate-slide-in-right">
                <img src="{{ asset('doctor.jpeg') }}"
                     class="w-40 h-auto transition-transform duration-300 ease-in-out group-hover:scale-105"
                     alt="Doctor illustration">
                <h1 class="text-xl text-slate-800">
                    Doctor
                </h1>
                <p class="text-sm font-semibold">
                    Continue as a doctor, review patient information and provide medical insights
                </p>
                <a href="{{ route('filament.doctor.pages.dashboard') }}"
                   class="p-2 rounded bg-sky-500 hover:bg-sky-800 duration-300 ease-in-out text-white transition-all hover:-translate-y-1">
                    Continue as a doctor
                </a>
            </div>
        </div>
    </div>

</body>
</html>
