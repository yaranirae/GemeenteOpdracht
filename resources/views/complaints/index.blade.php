<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gemeente Klachten</title>
    <link
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css"
        rel="stylesheet"
    />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans flex flex-col min-h-screen">


<header class="bg-[#2D6A4F] text-white py-5">
    <div class="container mx-auto flex flex-col sm:flex-row items-center justify-center space-y-3 sm:space-y-0 sm:space-x-4 px-4">

        <div class="bg-[#1b4332] text-white font-bold text-base sm:text-lg rounded-full h-10 w-10 sm:h-12 sm:w-12 flex items-center justify-center shadow-md">
            GR
        </div>


        <h1 class="text-xl sm:text-3xl font-semibold text-center leading-tight">
            Gemeente Rotterdam
        </h1>
    </div>
</header>


<!-- Main content -->
<main class="flex-grow container mx-auto px-4 py-8">
    <p class="text-2xl sm:text-3xl font-semibold text-center mb-10 leading-snug">
        Wat voor probleem bevindt zich op deze locatie?
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Card 1 -->
        <a href="{{ route('complaints.create') }}?category=omgewaaide bomen" class="block">
            <div class="bg-white rounded-xl shadow-md p-6 sm:p-8 text-center transform transition hover:-translate-y-1 hover:shadow-lg">
                <div class="text-5xl text-green-600 mb-4">
                    <i class="fas fa-tree"></i>
                </div>
                <h4 class="text-xl font-semibold mb-2">Omgewaaide bomen</h4>
                <p class="text-gray-500">Gevallen bomen of takken die de weg blokkeren</p>
            </div>
        </a>

        <!-- Card 2 -->
        <a href="{{ route('complaints.create') }}?category=kapotte straatverlichting" class="block">
            <div class="bg-white rounded-xl shadow-md p-6 sm:p-8 text-center transform transition hover:-translate-y-1 hover:shadow-lg">
                <div class="text-5xl text-yellow-500 mb-4">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h4 class="text-xl font-semibold mb-2">Kapotte straatverlichting</h4>
                <p class="text-gray-500">Lantaarnpalen die niet werken of kapot zijn</p>
            </div>
        </a>

        <!-- Card 3 -->
        <a href="{{ route('complaints.create') }}?category=zwerfvuil" class="block">
            <div class="bg-white rounded-xl shadow-md p-6 sm:p-8 text-center transform transition hover:-translate-y-1 hover:shadow-lg">
                <div class="text-5xl text-red-600 mb-4">
                    <i class="fas fa-trash"></i>
                </div>
                <h4 class="text-xl font-semibold mb-2">Zwerfvuil</h4>
                <p class="text-gray-500">Afval op straat of in parken dat niet is opgeruimd</p>
            </div>
        </a>
    </div>


    @if(session('location_data'))
        <div class="bg-green-100 border border-green-400 text-green-800 text-center p-6 rounded-lg shadow-md">
            <h5 class="text-xl font-semibold mb-2">📍 تم تحديد موقعك بنجاح!</h5>
            <p class="mb-4">adres: {{ session('location_data')['address'] }}</p>
            <a
                href="{{ route('complaints.create') }}"
                class="inline-block bg-[#1e3c72] hover:bg-[#2a5298] text-white font-bold py-3 px-6 rounded-lg transition"
            >
                تقديم شكوى جديدة
            </a>
        </div>
    @endif
</main>

<!-- Footer -->
<footer class="bg-gradient-to-r from-[#2D6A4F] to-[#52B788] text-sm font-semibold text-white text-left py-4 mt-auto">
    <div class="container mx-auto px-4">
        <p>&copy; 2025 Gemeente Rotterdam. Alle rechten voorbehouden.</p>
    </div>
</footer>
</body>
</html>
