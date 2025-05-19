<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Windkracht 12</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <header>
        <nav class="absolute w-full justify-end flex z-10">
            <div class="p-5 bg-[#cae9ffb1] rounded-bl-lg shadow-lg">
                @auth
                <a href="{{ url('/dashboard') }}" class="font-semibold hover:underline">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="font-semibold hover:underline">Log in</a> |
                <a href="{{ route('register') }}" class="font-semibold hover:underline">Register</a>
                @endauth
            </div>
        </nav>
        <div class="w-full relative h-[60vh] flex items-center justify-center z-0	">
            <img class="object-center object-cover w-full h-full absolute top-0 left-0 z-0 brightness-75"
                src="/img/home.jpg" alt="home banner img">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-10"></div>
            <h1
                class="relative z-20 right-10 top-0 text-4xl md:text-6xl font-serif text-white drop-shadow-lg text-right">
                Kite surf school <br> windkracht 12
            </h1>
        </div>
    </header>
    <main>
            @if (session('error'))
        <div class="max-w-3xl mx-auto mt-6 mb-4 px-6 py-4 bg-red-100 border-l-4 border-red-500 text-red-800 rounded shadow">
            {{ session('error') }}
        </div>
    @endif
        <section
            class="bg-gradient-to-br from-[#CAE9FF] to-[#A6D4FF] grid md:grid-cols-2 sm:grid-cols-1 p-6 md:p-10 gap-8">
            <div class="mt-8 md:mt-[10%]">
                <h3 class="font-serif text-2xl md:text-3xl my-4 text-[#1B4965]">Welkom bij Kitesurfschool Windkracht 12
                </h3>
                <p class="text-lg leading-relaxed text-[#22223b]">
                    Bij Windkracht 12 draait alles om passie voor de wind, de zee en de vrijheid van het kitesurfen.
                    Gevestigd aan de kust (vul locatie in), bieden wij kitesurflessen voor zowel beginners als
                    gevorderden, in een veilige en professionele omgeving. Onze ervaren en gecertificeerde instructeurs
                    zorgen ervoor dat jij het maximale uit elke les haalt – met plezier, veiligheid en persoonlijke
                    aandacht voorop. <br><br>
                    Of je nu voor het eerst een kite vasthoudt of je techniek wilt verfijnen, Windkracht 12 staat garant
                    voor kwaliteit, adrenaline en een onvergetelijke ervaring op het water. Dankzij onze kleine
                    lesgroepen, topmateriaal en ideale leslocatie ben je bij ons in goede handen. <br><br>
                    Laat de wind je meevoeren. Ontdek kitesurfen bij Windkracht 12 – voel de kracht, beleef de vrijheid.
                </p>
            </div>
            <div class="flex justify-center items-center w-full">
                <img class="object-center object-cover w-[80%] md:w-[60%] rounded-xl shadow-lg border-4 border-white"
                    src="/img/home2.jpg" alt="surfer">
            </div>
        </section>
        <section class="bg-[#A6D4FF] p-6 md:p-10">
            <div class="w-full">
                <h3 class="font-serif text-2xl md:text-3xl my-4 text-[#1B4965]">Prijzen</h3>
                <p class="text-lg text-[#22223b]">
                    U kunt telefonisch een les boeken door 06 1234 567 89 te bellen of via de website door op boeken te
                    klikken bij één van de les opties.
                </p>
            </div>
            <div class="grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-8 md:gap-10 mt-10 px-0 md:px-10">
                <div class="bg-[#FFFCEA] rounded-2xl shadow-lg h-min transition-transform hover:scale-105">
                    <h4 class="w-full text-2xl text-center my-4 font-semibold text-[#1B4965]">Privéles <br> 2.5 uur</h4>
                    <div class="bg-[#FFF8D0] w-full p-4 rounded-b-xl">
                        <ul class="list-disc m-auto w-2/3 text-xl text-[#22223b]">
                            <li>inclusief alle materialen</li>
                            <li>Eén persoon</li>
                        </ul>
                        <p class="w-full text-center text-2xl mt-4 font-bold text-[#1B4965]">€175,-</p>
                    </div>
                    <div class="my-4 flex justify-center">
                        <a href=""
                            class="bg-[#95E794] hover:bg-[#6fcf97] transition-colors p-2 px-6 text-xl rounded-full shadow font-semibold">boeken</a>
                    </div>
                </div>
                <div class="bg-[#FFFCEA] rounded-2xl shadow-lg h-min transition-transform hover:scale-105">
                    <h4 class="w-full text-2xl text-center my-4 font-semibold text-[#1B4965]">1 dagdeel <br> Losse Duo
                        Kiteles <br>3.5 uur</h4>
                    <div class="bg-[#FFF8D0] w-full p-4 rounded-b-xl">
                        <ul class="list-disc m-auto w-2/3 text-xl text-[#22223b]">
                            <li>inclusief alle materialen</li>
                            <li>Max 2 personen</li>
                        </ul>
                        <p class="w-full text-center text-2xl mt-4 font-bold text-[#1B4965]">€135,- pp</p>
                    </div>
                    <div class="my-4 flex justify-center">
                        <a href=""
                            class="bg-[#95E794] hover:bg-[#6fcf97] transition-colors p-2 px-6 text-xl rounded-full shadow font-semibold">boeken</a>
                    </div>
                </div>
                <div class="bg-[#FFFCEA] rounded-2xl shadow-lg h-min transition-transform hover:scale-105">
                    <h4 class="w-full text-2xl text-center my-4 font-semibold text-[#1B4965]">1 dagdeel <br>Losse Duo
                        Kiteles <br>3 lessen <br>10.5 uur</h4>
                    <div class="bg-[#FFF8D0] w-full p-4 rounded-b-xl">
                        <ul class="list-disc m-auto w-2/3 text-xl text-[#22223b]">
                            <li>inclusief alle materialen</li>
                            <li>Max 2 personen</li>
                            <li>3 dagdelen</li>
                        </ul>
                        <p class="w-full text-center text-2xl mt-4 font-bold text-[#1B4965]">€375,- pp</p>
                    </div>
                    <div class="my-4 flex justify-center">
                        <a href=""
                            class="bg-[#95E794] hover:bg-[#6fcf97] transition-colors p-2 px-6 text-xl rounded-full shadow font-semibold">boeken</a>
                    </div>
                </div>
                <div class="bg-[#FFFCEA] rounded-2xl shadow-lg h-min transition-transform hover:scale-105">
                    <h4 class="w-full text-2xl text-center my-4 font-semibold text-[#1B4965]">3 dagdelen <br>Losse Duo
                        Kiteles <br>5 lessen <br>17.5 uur</h4>
                    <div class="bg-[#FFF8D0] w-full p-4 rounded-b-xl">
                        <ul class="list-disc m-auto w-2/3 text-xl text-[#22223b]">
                            <li>inclusief alle materialen</li>
                            <li>Max 2 personen</li>
                            <li>5 dagdelen</li>
                        </ul>
                        <p class="w-full text-center text-2xl mt-4 font-bold text-[#1B4965]">€675,- pp</p>
                    </div>
                    <div class="my-4 flex justify-center">
                        <a href=""
                            class="bg-[#95E794] hover:bg-[#6fcf97] transition-colors p-2 px-6 text-xl rounded-full shadow font-semibold">boeken</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="h-[20vh] relative">
        <img src="/img/footer.jpg" alt=""
            class="object-center object-cover w-full h-full absolute blur-sm brightness-75">
        <div class="h-full w-full bg-[#00000075] z-10 relative grid grid-cols-2 text-white text-xl pt-20">
            <div class="text-right p-4 border-r-4 border-white h-2/3 pt-7">
                @auth
                <a href="{{ url('/dashboard') }}" class="hover:underline">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="hover:underline">Log in</a> <br>
                <a href="{{ route('register') }}" class="hover:underline">Register</a>
                @endauth
            </div>
            <div class="p-4 h-2/3">
                <h2 class="text-2xl font-bold">Contact</h2>
                <ul>
                    <li>Tel: 06 1234 4567 89</li>
                    <li>Email: windkracht12@mail.com</li>
                </ul>
            </div>
        </div>
    </footer>


</body>

</html>