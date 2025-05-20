<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Algerian Cuisine - Carbohydrate Content</title>
    <style>
        :root {
            --primary-50: #eef2ff;
            --primary-100: #e0e7ff;
            --primary-200: #c7d2fe;
            --primary-300: #a5b4fc;
            --primary-400: #818cf8;
            --primary-500: #6366f1;
            --primary-600: #4f46e5;
            --primary-700: #4338ca;
            --primary-800: #3730a3;
            --primary-900: #312e81;
            --green-500: #10b981;
            --green-600: #059669;
            --yellow-500: #f59e0b;
            --red-500: #ef4444;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', 'Arial', sans-serif;
            background-color: var(--gray-100);
            color: var(--gray-800);
            line-height: 1.5;
        }

        header {
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-700);
        }

        .logo-icon {
            width: 2rem;
            height: 2rem;
            background-color: var(--primary-600);
            color: white;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .search-container {
            position: relative;
        }

        .search-input {
            padding: 0.5rem 2.5rem 0.5rem 1rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            outline: none;
            width: 100%;
            max-width: 20rem;
            font-family: inherit;
            transition: all 0.2s;
        }

        .search-input:focus {
            border-color: var(--primary-400);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .search-icon {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
            pointer-events: none;
        }

        .main-content {
            padding: 2rem 0;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .dashboard-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .filters {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            background-color: white;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-family: inherit;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-btn.active {
            background-color: var(--primary-50);
            border-color: var(--primary-300);
            color: var(--primary-700);
        }

        .filter-btn:hover {
            border-color: var(--primary-400);
        }

        .filter-btn-icon {
            width: 1rem;
            height: 1rem;
        }

        .meals-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .meal-card {
            background-color: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .meal-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .meal-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .meal-content {
            padding: 1rem;
        }

        .meal-title {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--gray-900);
        }

        .meal-description {
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-bottom: 1rem;
            height: 3em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .meal-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.75rem;
            border-top: 1px solid var(--gray-200);
        }

        .carbs-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        .carbs-label {
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .carbs-value {
            color: var(--primary-700);
            font-size: 1rem;
        }

        .carbs-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .carbs-low {
            background-color: #d1fae5;
            color: var(--green-600);
        }

        .carbs-medium {
            background-color: #fef3c7;
            color: var(--yellow-500);
        }

        .carbs-high {
            background-color: #fee2e2;
            color: var(--red-500);
        }

        .meal-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .meal-btn {
            border: none;
            background-color: transparent;
            cursor: pointer;
            color: var(--gray-500);
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .meal-btn:hover {
            background-color: var(--gray-100);
            color: var(--gray-700);
        }

        .add-meal-btn {
            background-color: var(--primary-600);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-family: inherit;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .add-meal-btn:hover {
            background-color: var(--primary-700);
        }

        .pagination {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .page-btn {
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            background-color: white;
            color: var(--gray-700);
            font-family: inherit;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .page-btn.active {
            background-color: var(--primary-600);
            border-color: var(--primary-600);
            color: white;
        }

        .page-btn:hover:not(.active) {
            border-color: var(--primary-400);
            color: var(--primary-600);
        }

        .meal-tag {
            position: absolute;
            top: 0.5rem;
            left: 0.5rem;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .meal-card {
            position: relative;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .search-input {
                max-width: 100%;
            }

            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .meals-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <div class="logo-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                            <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                            <line x1="6" y1="1" x2="6" y2="4"></line>
                            <line x1="10" y1="1" x2="10" y2="4"></line>
                            <line x1="14" y1="1" x2="14" y2="4"></line>
                        </svg>
                    </div>
                    <span>Algerian Kitchen</span>
                </div>
                <div class="header-actions">
                    <div class="search-container">
                        <input type="text" class="search-input" placeholder="Search for a meal...">
                        <div class="search-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="dashboard-header">
                <h1 class="dashboard-title">Popular Algerian & International Meals - Carbohydrate Content</h1>
                <button class="add-meal-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add New Meal
                </button>
            </div>

            <div class="filters">
                <button class="filter-btn active">All Meals</button>
                <button class="filter-btn">
                    <span>Low Carb</span>
                    <svg class="filter-btn-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <button class="filter-btn">
                    <span>Main Dishes</span>
                    <svg class="filter-btn-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <button class="filter-btn">
                    <span>Desserts</span>
                    <svg class="filter-btn-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <button class="filter-btn">
                    <span>Algerian</span>
                    <svg class="filter-btn-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <button class="filter-btn">
                    <span>International</span>
                    <svg class="filter-btn-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
            </div>

            <div class="meals-grid">
                <!-- Algerian Meals -->

                <!-- Couscous -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="/api/placeholder/400/200" alt="Couscous" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Traditional Couscous</h3>
                        <p class="meal-description">Traditional couscous with meat and vegetables, one of the most famous Algerian dishes</p>
                        <div class="meal-meta">
                            <div class="carbs-indicator">
                                <span class="carbs-label">Carbs:</span>
                                <span class="carbs-value">45g</span>
                            </div>
                            <div class="carbs-badge carbs-medium">Medium</div>
                        </div>
                    </div>
                </div>

                <!-- Chakhchoukha -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="/api/placeholder/400/200" alt="Chakhchoukha" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Chakhchoukha</h3>
                        <p class="meal-description">Traditional Chakhchoukha with broth and spices, a famous dish from eastern Algeria</p>
                        <div class="meal-meta">
                            <div class="carbs-indicator">
                                <span class="carbs-label">Carbs:</span>
                                <span class="carbs-value">35g</span>
                            </div>
                            <div class="carbs-badge carbs-medium">Medium</div>
                        </div>
                    </div>
                </div>

                <!-- Shorba -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="/api/placeholder/400/200" alt="Shorba" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Freekeh Soup</h3>
                        <p class="meal-description">Traditional Freekeh soup, essential on the Ramadan table</p>
                        <div class="meal-meta">
                            <div class="carbs-indicator">
                                <span class="carbs-label">Carbs:</span>
                                <span class="carbs-value">20g</span>
                            </div>
                            <div class="carbs-badge carbs-low">Low</div>
                        </div>
                    </div>
                </div>

                <!-- Bourek -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="/api/placeholder/400/200" alt="Bourek" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Meat Bourek</h3>
                        <p class="meal-description">Crispy bourek stuffed with minced meat and spices</p>
                        <div class="meal-meta">
                            <div class="carbs-indicator">
                                <span class="carbs-label">Carbs:</span>
                                <span class="carbs-value">30g</span>
                            </div>
                            <div class="carbs-badge carbs-medium">Medium</div>
                        </div>
                    </div>
                </div>

                <!-- Grilled Meat -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="/api/placeholder/400/200" alt="Grilled Meat" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Grilled Lamb</h3>
                        <p class="meal-description">Grilled lamb with traditional Algerian spices</p>
                        <div class="meal-meta">
                            <div class="carbs-indicator">
                                <span class="carbs-label">Carbs:</span>
                                <span class="carbs-value">0g</span>
                            </div>
                            <div class="carbs-badge carbs-low">Low</div>
                        </div>
                    </div>
                </div>

                <!-- Makrout -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="/api/placeholder/400/200" alt="Makrout" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Makrout</h3>
                        <p class="meal-description">Traditional sweet made from dough and dates, dipped in honey</p>
                        <div class="meal-meta">
                            <div class="carbs-indicator">
                                <span class="carbs-label">Carbs:</span>
                                <span class="carbs-value">60g</span>
                            </div>
                            <div class="carbs-badge carbs-high">High</div>
                        </div>
                    </div>
                </div>

                <!-- Kalb El Louz -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="/api/placeholder/400/200" alt="Kalb El Louz" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Kalb El Louz</h3>
                        <p class="meal-description">Delicious dessert made from almonds and sugar</p>
                        <div class="meal-meta">
                            <div class="carbs-indicator">
                                <span class="carbs-label">Carbs:</span>
                                <span class="carbs-value">50g</span>
                            </div>
                            <div class="carbs-badge carbs-high">High</div>
                        </div>
                    </div>
                </div>

                <!-- Rechta -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="/api/placeholder/400/200" alt="Rechta" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Rechta</h3>
                        <p class="meal-description">Traditional dish of handmade pasta with vegetables and meat</p>
                        <div class="meal-meta">
                            <div class="carbs-indicator">
                                <span class="carbs-label">Carbs:</span>
                                <span class="carbs-value">40g</span>
                            </div>
                            <div class="carbs-badge carbs-medium">Medium</div>
                        </div>
                    </div>
                </div>

                <!-- Dolma -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="/api/placeholder/400/200" alt="Dolma" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Dolma</h3>
                        <p class="meal-description">Stuffed vegetables with rice and minced meat in a tomato sauce</p>
                        <div class="meal-meta">
                            <div class="carbs-indicator">
                                <span class="carbs-label">Carbs:</span>
                                <span class="carbs-value">25g</span>
                            </div>
                            <div class="carbs-badge carbs-medium">Medium</div>
                        </div>
                    </div>
                </div>

                <!-- Berkoukes -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="/api/placeholder/400/200" alt="Berkoukes" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Berkoukes</h3>
                        <p class="meal-description">Traditional dish with hand-rolled pasta pearls, vegetables and meat</p>
                        <div class="meal-meta">
                            <div class="carbs-indicator">
                                <span class="carbs-label">Carbs:</span>
                                <span class="carbs-value">45g</span>
                            </div>
                            <div class="carbs-badge carbs-medium">Medium</div>
                        </div>
                    </div>
                </div>

                <!-- Mhadjeb -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="/api/placeholder/400/200" alt="Mhadjeb" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Mhadjeb</h3>
                        <p class="meal-description">Flatbread stuffed with tomato, onion and spice mixture</p>
                        <div class="meal-meta">
                            <div class="carbs-indicator">
                                <span class="carbs-label">Carbs:</span>
                                <span class="carbs-value">35g</span>
                            </div>
                            <div class="carbs-badge carbs-medium">Medium</div>
                        </div>
                    </div>
                </div>

                <!-- Hrira -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="/api/placeholder/400/200" alt="Hrira" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Hrira</h3>
                        <p class="meal-description">Rich tomato-based soup with lentils, chickpeas, and meat</p>
                        <div class="meal-meta">
                            <div class="carbs-indicator">
                                <span class="carbs-label">Carbs:</span>
                                <span class="carbs-value">30g</span>
                            </div>
                            <div class="carbs-badge carbs-medium">Medium</div>
                        </div>
                    </div>
                </div>

                <!-- Zlabia -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="/api/placeholder/400/200" alt="Zlabia" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Zlabia</h3>
                        <p class="meal-description">Sweet deep-fried batter soaked in honey or sugar syrup</p>
                        <div class="meal-meta">
                            <div class="carbs-indicator">
                                <span class="carbs-label">Carbs:</span>
                                <span class="carbs-value">55g</span>
                            </div>
                            <div class="carbs-badge carbs-high">High</div>
                        </div>
                    </div>
                </div>

                <!-- Tajine Zitoune -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="/api/placeholder/400/200" alt="Tajine Zitoune" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Tajine Zitoune</h3>
                        <p class="meal-description">Chicken tajine with olives and preserved lemon in a flavorful sauce</p>
                        <div class="meal-meta">
                            <div class="carbs-indicator">
                                <span class="carbs-label">Carbs:</span>
                                <span class="carbs-value">15g</span>
                            </div>
                            <div class="carbs-badge carbs-low">Low</div>
                        </div>
                    </div>
                </div>

                <!-- Baklava -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="/api/placeholder/400/200" alt="Baklava" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Baklava</h3>
                        <p class="meal-description">Sweet layered pastry filled with chopped nuts and soaked in honey</p>
                        <div class="meal-meta">
                            <div class="carbs-indicator">
                                <span class="carbs-label">Carbs:</span>
                                <span class="carbs-value">65g</span>
                            </div>
                            <div class="carbs-badge carbs-high">High</div>
                        </div>
                    </div>
                </div>

                <!-- Tamina -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="/api/placeholder/400/200" alt="Tamina" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Tamina</h3>
                        <p class="meal-description">Sweet dessert made from toasted semolina, honey, and butter</p>
                        <div class="meal-meta">
                            <div class="carbs-indicator">
                                <span class="carbs-label">Carbs:</span>
                                <span class="carbs-value">50g</span>
                            </div>
                            <div class="carbs-badge carbs-high">High</div>
                        </div>
                    </div>
                </div>
                <!-- International Meals -->

<!-- Spaghetti Bolognese -->
               <div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Spaghetti Bolognese" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Spaghetti Bolognese</h3>
        <p class="meal-description">Classic Italian pasta with rich meat sauce</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">60g</span>
            </div>
            <div class="carbs-badge carbs-high">High</div>
        </div>
    </div>
</div>

<!-- Sushi -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Sushi" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Sushi</h3>
        <p class="meal-description">Japanese rice rolls with fish and vegetables</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">40g</span>
            </div>
            <div class="carbs-badge carbs-medium">Medium</div>
        </div>
    </div>
</div>

<!-- Chicken Tikka Masala -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Chicken Tikka Masala" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Chicken Tikka Masala</h3>
        <p class="meal-description">Indian chicken curry in creamy tomato sauce</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">25g</span>
            </div>
            <div class="carbs-badge carbs-medium">Medium</div>
        </div>
    </div>
</div>

<!-- Caesar Salad -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Caesar Salad" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Caesar Salad</h3>
        <p class="meal-description">Fresh salad with romaine, croutons, and parmesan</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">15g</span>
            </div>
            <div class="carbs-badge carbs-low">Low</div>
        </div>
    </div>
</div>

<!-- Cheeseburger -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Cheeseburger" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Cheeseburger</h3>
        <p class="meal-description">Classic American burger with cheese and toppings</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">35g</span>
            </div>
            <div class="carbs-badge carbs-medium">Medium</div>
        </div>
    </div>
</div>

<!-- Pad Thai -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Pad Thai" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Pad Thai</h3>
        <p class="meal-description">Thai stir-fried rice noodles with shrimp and peanuts</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">55g</span>
            </div>
            <div class="carbs-badge carbs-high">High</div>
        </div>
    </div>
</div>
<!-- International Meals -->

<!-- Spaghetti Bolognese -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Spaghetti Bolognese" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Spaghetti Bolognese</h3>
        <p class="meal-description">Classic Italian pasta with rich meat sauce</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">60g</span>
            </div>
            <div class="carbs-badge carbs-high">High</div>
        </div>
    </div>
</div>

<!-- Sushi -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Sushi" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Sushi</h3>
        <p class="meal-description">Japanese rice rolls with fish and vegetables</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">40g</span>
            </div>
            <div class="carbs-badge carbs-medium">Medium</div>
        </div>
    </div>
</div>

<!-- Chicken Tikka Masala -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Chicken Tikka Masala" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Chicken Tikka Masala</h3>
        <p class="meal-description">Indian chicken curry in creamy tomato sauce</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">25g</span>
            </div>
            <div class="carbs-badge carbs-medium">Medium</div>
        </div>
    </div>
</div>

<!-- Caesar Salad -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Caesar Salad" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Caesar Salad</h3>
        <p class="meal-description">Fresh salad with romaine, croutons, and parmesan</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">15g</span>
            </div>
            <div class="carbs-badge carbs-low">Low</div>
        </div>
    </div>
</div>

<!-- Cheeseburger -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Cheeseburger" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Cheeseburger</h3>
        <p class="meal-description">Classic American burger with cheese and toppings</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">35g</span>
            </div>
            <div class="carbs-badge carbs-medium">Medium</div>
        </div>
    </div>
</div>

<!-- Pad Thai -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Pad Thai" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Pad Thai</h3>
        <p class="meal-description">Thai stir-fried rice noodles with shrimp and peanuts</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">55g</span>
            </div>
            <div class="carbs-badge carbs-high">High</div>
        </div>
    </div>
</div>
<!-- Greek Salad -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Greek Salad" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Greek Salad</h3>
        <p class="meal-description">Fresh salad with tomatoes, cucumber, olives, and feta cheese</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">10g</span>
            </div>
            <div class="carbs-badge carbs-low">Low</div>
        </div>
    </div>
</div>

<!-- Grilled Salmon with Veggies -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Grilled Salmon" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Grilled Salmon & Veggies</h3>
        <p class="meal-description">Salmon fillet grilled and served with steamed vegetables</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">8g</span>
            </div>
            <div class="carbs-badge carbs-low">Low</div>
        </div>
    </div>
</div>

<!-- Quinoa & Chickpea Bowl -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Quinoa Chickpea Bowl" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Quinoa & Chickpea Bowl</h3>
        <p class="meal-description">Protein-rich bowl with quinoa, chickpeas, and fresh veggies</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">28g</span>
            </div>
            <div class="carbs-badge carbs-medium">Medium</div>
        </div>
    </div>
</div>

<!-- Chicken Stir Fry -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Chicken Stir Fry" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Chicken Stir Fry</h3>
        <p class="meal-description">Lean chicken breast stir-fried with colorful vegetables</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">18g</span>
            </div>
            <div class="carbs-badge carbs-low">Low</div>
        </div>
    </div>
</div>

<!-- Lentil Soup -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Lentil Soup" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Lentil Soup</h3>
        <p class="meal-description">Hearty soup made with lentils, carrots, and celery</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">22g</span>
            </div>
            <div class="carbs-badge carbs-medium">Medium</div>
        </div>
    </div>
</div>

<!-- Caprese Salad -->
<div class="meal-card">
    <span class="meal-tag">International</span>
    <img src="/api/placeholder/400/200" alt="Caprese Salad" class="meal-image">
    <div class="meal-content">
        <h3 class="meal-title">Caprese Salad</h3>
        <p class="meal-description">Italian salad with tomatoes, mozzarella, basil, and olive oil</p>
        <div class="meal-meta">
            <div class="carbs-indicator">
                <span class="carbs-label">Carbs:</span>
                <span class="carbs-value">7g</span>
            </div>
            <div class="carbs-badge carbs-low">Low</div>
        </div>
    </div>
</div>

