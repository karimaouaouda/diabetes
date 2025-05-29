<x-filament-panels::page>
    @vite('resources/css/app.css')
        <div class="flex flex-col space-y-4">
            <!-- Barre des avatars en haut -->
            <div class="flex space-x-4 overflow-x-auto p-2 bg-gray-100 rounded items-center">
                <!-- Exemple d'avatars -->
                <div class="flex flex-col items-center w-14 h-14">
                    <img src="{{ asset('images/avatar.jpeg') }}" alt="karimaouaouda" class="w-14 h-14 rounded-full border-2 border-blue-500">
                    <span class="text-xs text-gray-600 mt-1">Karim Aouaouda</span>
                </div>
                <div class="flex flex-col items-center w-14 h-14">
                    <img src="{{ asset('images/avatar.jpeg') }}" alt="karimaouaouda" class="w-14 h-14 rounded-full border-2 border-blue-500">
                    <span class="text-xs text-gray-600 mt-1">Karim Aouaouda</span>
                </div>
                <div class="flex flex-col items-center w-14 h-14">
                    <img src="{{ asset('images/avatar.jpeg') }}" alt="karimaouaouda" class="w-14 h-14 rounded-full border-2 border-blue-500">
                    <span class="text-xs text-gray-600 mt-1">Karim Aouaouda</span>
                </div>

            </div>

            <!-- Section principale des messages -->
            <div class="bg-white shadow rounded-lg p-4">
                <h1 class="text-xl font-bold">Messages</h1>
                <div class="mt-4">
                    <!-- Zone d'affichage des messages -->
                    <div id="chatMessages" class="space-y-2 h-96 overflow-y-auto p-4 border rounded bg-gray-100">
                        <!-- Exemple de messages -->
                        <div class="{{ true ? 'bg-blue-100 text-right' : 'bg-gray-200' }} p-2 rounded shadow">
                            i send this
                        </div>
                        <div class="{{ false ? 'bg-blue-100 text-right' : 'bg-gray-200' }} p-2 rounded shadow">
                           i receive this
                        </div>
                    </div>
                    <!-- Zone de saisie -->
                    <div class="mt-4 flex items-center space-x-2">
                        <input type="text" id="chatInput" placeholder="Écrivez votre message..."
                               class="w-full rounded border-gray-300 shadow focus:ring-1 focus:ring-blue-500">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                            Envoyer
                        </button>
                    </div>
                </div>
            </div>
        </div>
</x-filament-panels::page>
