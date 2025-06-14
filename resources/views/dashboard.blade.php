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
            font-family: 'Tajawal', 'Arial', sans-serif;
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
            padding: 0.5rem 1rem 0.5rem 2.5rem;
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

        .meals-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .meal-card {
            background-color: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
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

        .carbs-info {
            background-color: var(--gray-50);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid var(--gray-200);
        }

        .carbs-per-gram {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .carbs-per-gram-value {
            font-weight: 600;
            color: var(--primary-700);
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .quantity-label {
            font-size: 0.875rem;
            color: var(--gray-600);
            min-width: 60px;
        }

        .quantity-input-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex: 1;
        }

        .quantity-btn {
            width: 2rem;
            height: 2rem;
            border: 1px solid var(--primary-300);
            background-color: white;
            border-radius: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--primary-600);
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .quantity-btn:hover {
            background-color: var(--primary-50);
            border-color: var(--primary-400);
        }

        .quantity-btn:active {
            background-color: var(--primary-100);
        }

        .quantity-input {
            width: 4rem;
            padding: 0.25rem 0.5rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.25rem;
            text-align: center;
            font-family: inherit;
            font-size: 0.875rem;
        }

        .quantity-input:focus {
            outline: none;
            border-color: var(--primary-400);
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }

        .total-carbs {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.75rem;
            border-top: 1px solid var(--gray-200);
            font-weight: 600;
        }

        .total-carbs-label {
            color: var(--gray-700);
            font-size: 0.875rem;
        }

        .total-carbs-value {
            color: var(--primary-700);
            font-size: 1.125rem;
            font-weight: 700;
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
                    <span>Algerian Cuisine</span>
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
                <h1 class="dashboard-title">Popular Meals - Carbohydrate Content</h1>
                <button class="add-meal-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add New Meal
                </button>
            </div>

            <div class="meals-grid">
                <!-- Traditional Couscous -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6d/Couscous-1.jpg" alt="Couscous" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Traditional Couscous</h3>
                        <p class="meal-description">Traditional couscous with meat and vegetables, one of the most famous Algerian dishes</p>

                        <div class="carbs-info">
                            <div class="carbs-per-gram">
                                <span>Carbs per 100g:</span>
                                <span class="carbs-per-gram-value">23g</span>
                            </div>

                            <div class="quantity-controls">
                                <span class="quantity-label">Quantity:</span>
                                <div class="quantity-input-group">
                                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                                    <input type="number" class="quantity-input" value="100" min="1" onchange="updateTotalCarbs(this)">
                                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                                    <span style="font-size: 0.875rem; color: var(--gray-600);">g</span>
                                </div>
                            </div>

                            <div class="total-carbs">
                                <span class="total-carbs-label">Total Carbs:</span>
                                <span class="total-carbs-value">23g</span>
                            </div>
                        </div>

                        <div class="carbs-badge carbs-medium">Medium</div>
                    </div>
                </div>

                <!-- Chakhchoukha -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Chakhchoukha.jpg" alt="Chakhchoukha" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Chakhchoukha</h3>
                        <p class="meal-description">Traditional dish with broth and spices, famous from eastern Algeria</p>

                        <div class="carbs-info">
                            <div class="carbs-per-gram">
                                <span>Carbs per 100g:</span>
                                <span class="carbs-per-gram-value">18g</span>
                            </div>

                            <div class="quantity-controls">
                                <span class="quantity-label">Quantity:</span>
                                <div class="quantity-input-group">
                                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                                    <input type="number" class="quantity-input" value="100" min="1" onchange="updateTotalCarbs(this)">
                                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                                    <span style="font-size: 0.875rem; color: var(--gray-600);">g</span>
                                </div>
                            </div>

                            <div class="total-carbs">
                                <span class="total-carbs-label">Total Carbs:</span>
                                <span class="total-carbs-value">18g</span>
                            </div>
                        </div>

                        <div class="carbs-badge carbs-medium">Medium</div>
                    </div>
                </div>

                <!-- Makrout -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/3/3e/Makroudh.jpg" alt="Makrout" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Makrout</h3>
                        <p class="meal-description">Traditional pastry with date filling, dipped in honey</p>

                        <div class="carbs-info">
                            <div class="carbs-per-gram">
                                <span>Carbs per 100g:</span>
                                <span class="carbs-per-gram-value">65g</span>
                            </div>

                            <div class="quantity-controls">
                                <span class="quantity-label">Quantity:</span>
                                <div class="quantity-input-group">
                                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                                    <input type="number" class="quantity-input" value="50" min="1" onchange="updateTotalCarbs(this)">
                                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                                    <span style="font-size: 0.875rem; color: var(--gray-600);">g</span>
                                </div>
                            </div>

                            <div class="total-carbs">
                                <span class="total-carbs-label">Total Carbs:</span>
                                <span class="total-carbs-value">32.5g</span>
                            </div>
                        </div>

                        <div class="carbs-badge carbs-high">High</div>
                    </div>
                </div>

                <!-- Grilled Lamb -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/8/8c/Mechoui.jpg" alt="Grilled Lamb" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Grilled Lamb</h3>
                        <p class="meal-description">Grilled lamb with traditional Algerian spices</p>

                        <div class="carbs-info">
                            <div class="carbs-per-gram">
                                <span>Carbs per 100g:</span>
                                <span class="carbs-per-gram-value">0g</span>
                            </div>

                            <div class="quantity-controls">
                                <span class="quantity-label">Quantity:</span>
                                <div class="quantity-input-group">
                                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                                    <input type="number" class="quantity-input" value="150" min="1" onchange="updateTotalCarbs(this)">
                                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                                    <span style="font-size: 0.875rem; color: var(--gray-600);">g</span>
                                </div>
                            </div>

                            <div class="total-carbs">
                                <span class="total-carbs-label">Total Carbs:</span>
                                <span class="total-carbs-value">0g</span>
                            </div>
                        </div>

                        <div class="carbs-badge carbs-low">Low</div>
                    </div>
                </div>

                <!-- Bourek -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/9c/Bourek_Algerien.jpg" alt="Bourek" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Bourek with Meat</h3>
                        <p class="meal-description">Crispy pastry filled with minced meat and spices</p>

                        <div class="carbs-info">
                            <div class="carbs-per-gram">
                                <span>Carbs per 100g:</span>
                                <span class="carbs-per-gram-value">25g</span>
                            </div>

                            <div class="quantity-controls">
                                <span class="quantity-label">Quantity:</span>
                                <div class="quantity-input-group">
                                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                                    <input type="number" class="quantity-input" value="80" min="1" onchange="updateTotalCarbs(this)">
                                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                                    <span style="font-size: 0.875rem; color: var(--gray-600);">g</span>
                                </div>
                            </div>

                            <div class="total-carbs">
                                <span class="total-carbs-label">Total Carbs:</span>
                                <span class="total-carbs-value">20g</span>
                            </div>
                        </div>

                        <div class="carbs-badge carbs-medium">Medium</div>
                    </div>
                </div>

                <!-- Rechta -->
                <div class="meal-card">
                    <span class="meal-tag">Algerian</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/9d/Rechta.jpg" alt="Rechta" class="meal-image">
                    <div class="meal-content">
                        <h3 class="meal-title">Rechta</h3>
                        <p class="meal-description">Traditional handmade pasta with vegetables and meat</p>

                        <div class="carbs-info">
                            <div class="carbs-per-gram">
                                <span>Carbs per 100g:</span>
                                <span class="carbs-per-gram-value">30g</span>
                            </div>

                            <div class="quantity-controls">
                                <span class="quantity-label">Quantity:</span>
                                <div class="quantity-input-group">
                                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                                    <input type="number" class="quantity-input" value="120" min="1" onchange="updateTotalCarbs(this)">
                                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                                    <span style="font-size: 0.875rem; color: var(--gray-600);">g</span>
                                </div>
                            </div>

                            <div class="total-carbs">
                                <span class="total-carbs-label">Total Carbs:</span>
                                <span class="total-carbs-value">36g</span>
                            </div>
                        </div>

                        <div class="carbs-badge carbs-medium">Medium</div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function increaseQuantity(button) {
            const input = button.previousElementSibling;
            const currentValue = parseInt(input.value) || 0;
            input.value = currentValue + 10;
            updateTotalCarbs(input);
        }

        function decreaseQuantity(button) {
            const input = button.nextElementSibling;
            const currentValue = parseInt(input.value) || 0;
            if (currentValue > 10) {
                input.value = currentValue - 10;
                updateTotalCarbs(input);
            }
        }

        function updateTotalCarbs(input) {
            const quantity = parseInt(input.value) || 0;
            const carbsInfo = input.closest('.carbs-info');
            const carbsPerGram = parseFloat(carbsInfo.querySelector('.carbs-per-gram-value').textContent);
            const totalCarbsElement = carbsInfo.querySelector('.total-carbs-value');

            const totalCarbs = (quantity * carbsPerGram / 100).toFixed(1);
            totalCarbsElement.textContent = totalCarbs + 'g';
        }

        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const mealCards = document.querySelectorAll('.meal-card');

            mealCards.forEach(card => {
                const title = card.querySelector('.meal-title').textContent.toLowerCase();
                const description = card.querySelector('.meal-description').textContent.toLowerCase();

                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
