<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Klachten - Gemeente</title>
</head>

<body class="bg-stone-50 min-h-screen flex flex-col">

<header class="bg-[#2D6A4F] flex justify-between items-center py-4 px-4 sm:px-6 border-b border-stone-200">
    <div class="flex items-center space-x-2">
        <div class="bg-[#1b4332] text-white font-bold text-lg rounded-full h-10 w-10 flex items-center justify-center">
            GR
        </div>
        <h1 class="text-lg sm:text-xl font-semibold text-white">Gemeente Rotterdam</h1>
    </div>

    <nav class="space-x-4 hidden md:block">
        <a href="#" class="text-white hover:text-[#b7e4c7] transition">Over</a>
        <a href="#" class="text-white hover:text-[#b7e4c7] transition">Contact</a>
    </nav>

    <!-- Menu voor telefoon -->
    <button id="menuBtn" class="md:hidden text-white focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
    </button>
</header>

<nav id="mobileMenu" class="hidden flex-col bg-[#2D6A4F] text-white text-center py-3 space-y-2 md:hidden">
    <a href="#" class="block hover:text-[#b7e4c7] transition">Over</a>
    <a href="#" class="block hover:text-[#b7e4c7] transition">Contact</a>
</nav>

<main class="flex-grow flex items-center justify-center px-4 py-8 sm:py-12">
    <div class="flex flex-col md:flex-row-reverse items-center gap-8 md:gap-12 max-w-6xl w-full">

        <div class="w-full md:w-1/2 flex justify-center">
            <img
                src="https://images.unsplash.com/photo-1508780709619-79562169bc64?auto=format&fit=crop&w=600&q=80"
                alt="Klachten afbeelding"
                class="rounded-xl shadow-sm object-cover w-full h-auto max-h-96"
            />
        </div>

        <div class="w-full md:w-1/2">
            <h2 class="text-2xl sm:text-3xl font-semibold mb-3 text-stone-800">
                Heeft u een klacht? Wij luisteren.
            </h2>
            <p class="text-base sm:text-lg text-stone-600 mb-4 leading-relaxed">
                Vertel ons wat er is gebeurd. We behandelen klachten vertrouwelijk en komen binnen 7 werkdagen bij je terug met een ontvangstbevestiging.
            </p>

            <div class="flex flex-wrap gap-3 mb-6">
                <a
                    href="http://127.0.0.1:8000/map"
                    class="bg-[#2d6a4f] text-white px-5 py-2 rounded-lg hover:bg-[#1b4332] transition w-full sm:w-auto text-center"
                >
                    Dien uw klacht in
                </a>
                <button
                    class="bg-stone-200 text-stone-800 px-5 py-2 rounded-lg hover:bg-stone-300 transition w-full sm:w-auto"
                    id="faqBtn"
                >
                    Bekijk FAQ
                </button>
            </div>

            <p class="text-sm text-[#1b4332] mb-6">
                <strong>Belangrijk:</strong> bij noodgevallen bel je eerst de lokale hulpdiensten. Deze klachtenpagina is niet voor acute problemen.
            </p>

            <div class="bg-stone-100 rounded-lg p-4 border border-stone-200">
                <strong class="block text-[#1b4332] mb-1">Wat je nodig hebt</strong>
                <p class="text-stone-700">
                    Adres, beschrijving, foto (optioneel) en contactgegevens.
                </p>
                <p class="mt-2 text-sm text-stone-600">U kunt ook kiezen voor anoniem indienen.</p>
            </div>
        </div>
    </div>
</main>

<footer class="border-t border-stone-200 py-4 px-4 text-center text-sm text-stone-600">
    <p>
        Nog niet klaar om te melden? Je kunt ook per e-mail contact opnemen:
        <a href="mailto:klachten@example.com" class=" font-bold text-[#1b4332] hover:underline">klachten@example.com</a>
    </p>
</footer>

<script>
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
</body>
</html>
