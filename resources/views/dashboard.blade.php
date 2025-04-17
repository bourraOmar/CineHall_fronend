<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Films Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Films Dashboard</h1>
                <button id="openModalBtn" class="px-4 py-2 bg-rose-600 text-white rounded-md hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <i class="fas fa-plus mr-2"></i> Add New Film
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <p class=" text-green-600" id="infopara"></p>
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-rose-100 text-rose-600">
                        <i class="fas fa-film text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Films</p>
                        <p class="text-2xl font-semibold text-gray-800">42</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-rose-100 text-rose-600">
                        <i class="fas fa-ticket-alt text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Tickets Sold</p>
                        <p class="text-2xl font-semibold text-gray-800">1,254</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-rose-100 text-rose-600">
                        <i class="fas fa-euro-sign text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                        <p class="text-2xl font-semibold text-gray-800">€15,245</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Create Film Modal -->
    <div id="createFilmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Add New Film</h2>
                    <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="createFilmForm" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                            <input type="text" id="title" name="title" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-rose-500">
                        </div>
                        
                        <div>
                            <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Genre *</label>
                            <input type="text" id="genre" name="genre" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-rose-500">
                        </div>
                        
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration (minutes) *</label>
                            <input type="number" id="duration" name="duration" required min="1" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-rose-500">
                        </div>
                        
                        <div>
                            <label for="minimum_age" class="block text-sm font-medium text-gray-700 mb-1">Minimum Age *</label>
                            <input type="number" id="minimum_age" name="minimum_age" required min="0" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-rose-500">
                        </div>
                        
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image URL *</label>
                            <input type="file" accept="image/*" id="image" name="image" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-rose-500">
                        </div>
                        
                        <div>
                            <label for="trailer_url" class="block text-sm font-medium text-gray-700 mb-1">Trailer URL *</label>
                            <input type="text" id="trailer_url" name="trailer_url" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-rose-500">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                            <textarea id="description" name="description" rows="4" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-rose-500"></textarea>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" id="cancelBtn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded-md hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500">
                            Add Film
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>