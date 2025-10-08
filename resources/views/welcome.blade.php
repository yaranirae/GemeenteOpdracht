<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Klachten - Gemeente</title>
</head>
<body class="bg-stone-50 min-h-screen flex flex-col">
<header class="bg-green-900 flex justify-between items-center py-4 px-6 border-b border-stone-200">
    <div class="flex items-center space-x-2">
        <div class="bg-green-600 text-white font-bold text-lg rounded-full h-10 w-10 flex items-center justify-center">
            GR
        </div>
        <h1 class="text-xl font-semibold text-white">Gemeente Rotterdam</h1>
    </div>
    <nav class="space-x-4 hidden sm:block">
        <a href="#" class="text-white hover:text-green-600">Over</a>
        <a href="#" class="text-white hover:text-green-600">Contact</a>
    </nav>
</header>

<main class="flex-grow flex items-center justify-center px-4">
    <div class="flex flex-col md:flex-row-reverse items-center gap-10 max-w-5xl w-full">

        <div class="w-full md:w-1/2 flex justify-center">
            <img src="https://images.unsplash.com/photo-1508780709619-79562169bc64?auto=format&fit=crop&w=600&q=80"
                 alt="Klachten afbeelding"
                 class="rounded-xl shadow-sm object-cover w-full h-auto max-h-96">
        </div>

        <div class="w-full md:w-1/2">
            <h2 class="text-3xl font-semibold mb-3 text-stone-800">Heeft u een klacht? Wij luisteren.</h2>
            <p class=" text-base text-stone-600 mb-4 leading-relaxed">
                Vertel ons wat er is gebeurd. We behandelen klachten vertrouwelijk en komen binnen 7 werkdagen bij je terug met een ontvangstbevestiging.
            </p>

            <div class="flex flex-wrap gap-3 mb-6">
                <a href="http://127.0.0.1:8000/map" class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition" id="openForm">Dien uw klacht in</a>
                <button class="bg-stone-200 text-stone-800 px-5 py-2 rounded-lg hover:bg-stone-300 transition" id="faqBtn">Bekijk FAQ</button>
            </div>

            <p class="text-sm text-green-800 mb-6">
                <strong>Belangrijk:</strong> bij noodgevallen bel je eerst de lokale hulpdiensten. Deze klachtenpagina is niet voor acute problemen.
            </p>

            <div class="bg-stone-100 rounded-lg p-4 border border-stone-200">
                <strong class="block text-green-800 mb-1">Wat je nodig hebt</strong>
                <p class="text-stone-700">Adres, beschrijving, foto (optioneel) en contactgegevens.</p>
                <p class="mt-2 text-sm text-stone-600">U kunt ook kiezen voor anoniem indienen.</p>
            </div>
        </div>
    </div>
</main>

<footer class="border-t border-stone-200 py-4 text-center text-sm text-stone-600">
    <p>
        Nog niet klaar om te melden? Je kunt ook per e-mail contact opnemen:
        <a href="mailto:klachten@example.com" class="text-green-800 hover:underline">klachten@example.com</a>
    </p>
</footer>
</body>
</html>
