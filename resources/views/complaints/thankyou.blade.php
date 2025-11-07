<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bedankt - Gemeente</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-[#2D6A4F] text-white py-6">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-4xl font-semibold flex justify-center items-center gap-2">
            <i class="fas fa-check-circle"></i>
            Bedankt!
        </h1>
    </div>
</header>

<!-- Main content -->
<main class="flex-grow container mx-auto my-10 px-4 flex justify-center items-center">
    <div class="bg-white shadow-lg rounded-2xl p-8 sm:p-10 md:p-12 text-center max-w-xl w-full">
        <i class="fas fa-check-circle text-[#2D6A4F] text-5xl sm:text-6xl mb-6"></i>
        <h3 class="text-xl sm:text-2xl font-semibold mb-2">Uw klacht is succesvol ingediend</h3>
        <p class="text-gray-500 mb-6">
            Wij hebben uw melding ontvangen en zullen deze zo spoedig mogelijk behandelen.
        </p>

        <div class="flex flex-col gap-3">
            <a href="{{ route('complaints.index') }}"
               class="bg-gradient-to-tr from-[#52b788] to-[#74c69d] hover:bg-blue-700 text-white font-medium py-3 rounded-lg transition">
                Nieuwe klacht indienen
            </a>
            <a href="/"
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-3 rounded-lg transition">
                Terug naar homepagina
            </a>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-gradient-to-r from-[#2D6A4F] to-[#52B788] text-white text-center py-5 mt-auto">
    <p class="text-sm">&copy; 2025 Gemeente. Alle rechten voorbehouden.</p>
</footer>

</body>

</html>
