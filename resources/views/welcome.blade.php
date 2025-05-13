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
            <div class="p-5 bg-[#cae9ffb1] rounded-bl-lg">

                @auth
                <a href="{{ url('/dashboard') }}">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}">
                    Log in
                </a> |
                <a href="{{ route('register') }}">Register
                </a>
                @endauth
            </div>
        </nav>
        <div class="w-full relative">
            <h1 class="absolute right-10 top-[50%] text-4xl font-serif text-white">Kite surf school <br> windkracht 12
            </h1>
            <img class="object-center object-cover" src="/img/home.jpg" alt="home banner img">
        </div>
    </header>
    <main>
        <section class="bg-[#CAE9FF] grid md:grid-cols-2 sm:grid-cols-1 p-10">
            <div class="mt-[10%]">
                <h3 class="font-serif text-2xl my-4">Welkom bij Kitesurfschool Windkracht 12</h3>
                <p class="text-lg">
                    Bij Windkracht 12 draait alles om passie voor de wind, de zee en de vrijheid van het kitesurfen.
                    Gevestigd aan de kust (vul locatie in), bieden wij kitesurflessen voor zowel beginners als
                    gevorderden, in een veilige en professionele omgeving. Onze ervaren en gecertificeerde instructeurs
                    zorgen ervoor dat jij het maximale uit elke les haalt – met plezier, veiligheid en persoonlijke
                    aandacht voorop. <br> <br>

                    Of je nu voor het eerst een kite vasthoudt of je techniek wilt verfijnen, Windkracht 12 staat garant
                    voor kwaliteit, adrenaline en een onvergetelijke ervaring op het water. Dankzij onze kleine
                    lesgroepen, topmateriaal en ideale leslocatie ben je bij ons in goede handen. <br> <br>

                    Laat de wind je meevoeren. Ontdek kitesurfen bij Windkracht 12 – voel de kracht, beleef de vrijheid.
                </p>
            </div>
            <div class=" justify-center flex w-full">
                <img class="object-center object-cover w-[40%] rounded" src="/img/home2.jpg" alt="surfer">
            </div>
        </section>
        <section class="bg-[#A6D4FF] p-10">
            <div class="w-full">
                <h3 class="font-serif text-2xl my-4">Prijzen</h3>
                <p class="text-lg">
                    U kunt telefonisch een les boeken door 06 1234 567 89 te bellen of via de website door op boeken te
                    kliken bij één van de les opties
                </p>
            </div>
            <div class="grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-20 mt-10 px-10">
                <div class="bg-[#FFFCEA] h-min">
                    <h4 class="w-full text-2xl text-center my-4">Privéles <br> 2.5 uur</h4>
                    <div class="bg-[#FFF8D0] w-full p-4">
                        <ul class="list-disc m-auto w-2/3 text-xl">
                            <li>
                                inclusief alle matrialen
                            </li>
                            <li>
                                Eén persoon
                            </li>
                        </ul>
                        <p class="w-full text-center text-2xl mt-4">€175,-</p>
                    </div>
                    <div class="my-4 flex justify-center">
                        <a href="" class="bg-[#95E794] p-2 text-xl">boeken</a>
                    </div>
                </div>
                <div class="bg-[#FFFCEA] h-min">
                    <h4 class="w-full text-2xl text-center my-4">1 dagdeel <br> Losse Duo Kiteles <br>3.5 uur</h4>
                    <div class="bg-[#FFF8D0] w-full p-4">
                        <ul class="list-disc m-auto w-2/3 text-xl">
                            <li>
                                inclusief alle matrialen
                            </li>
                            <li>
                                Max 2 personen
                            </li>
                        </ul>
                        <p class="w-full text-center text-2xl mt-4">€135,- pp</p>
                    </div>
                    <div class="my-4 flex justify-center">
                        <a href="" class="bg-[#95E794] p-2 text-xl">boeken</a>
                    </div>
                </div>
                <div class="bg-[#FFFCEA] h-min">
                    <h4 class="w-full text-2xl text-center my-4">1 dagdeel <br>Losse Duo Kiteles <br>3 lessen <br>10.5
                        uur</h4>
                    <div class="bg-[#FFF8D0] w-full p-4">
                        <ul class="list-disc m-auto w-2/3 text-xl">
                            <li>
                                inclusief alle matrialen
                            </li>
                            <li>
                                Max 2 personen
                            </li>
                            <li>
                                3 dagdelen
                            </li>
                        </ul>
                        <p class="w-full text-center text-2xl mt-4">€375,- pp</p>
                    </div>
                    <div class="my-4 flex justify-center">
                        <a href="" class="bg-[#95E794] p-2 text-xl">boeken</a>
                    </div>
                </div>
                <div class="bg-[#FFFCEA] h-min">
                    <h4 class="w-full text-2xl text-center my-4">3 dagdelen <br>Losse Duo Kiteles <br>5 lessen <br>17.5
                        uur</h4>
                    <div class="bg-[#FFF8D0] w-full p-4">
                        <ul class="list-disc m-auto w-2/3 text-xl">
                            <li>
                                inclusief alle matrialen
                            </li>
                            <li>
                                Max 2 personen
                            </li>
                            <li>
                                5 dagdelen
                            </li>
                        </ul>
                        <p class="w-full text-center text-2xl mt-4">€675,- pp</p>
                    </div>
                    <div class="my-4 flex justify-center">
                        <a href="" class="bg-[#95E794] text-xl p-2">boeken</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="h-[20vh] relative">
        <img src="/img/footer.jpg" alt="" class="object-center object-cover w-full h-full absolute">
        <div class="h-full w-full bg-[#00000075] z-10 relative grid grid-cols-2 text-white text-xl pt-20">
            <div class="text-right p-4 border-r-4 border-white h-2/3 pt-7">
                @auth
                <a href="{{ url('/dashboard') }}">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}">
                    Log in
                </a> <br>
                <a href="{{ route('register') }}">Register
                </a>
                @endauth
            </div>
            <div class="p-4 h-2/3">
                <h2 class="text-2xl">Contact</h2>
                <ul>
                    <li>Tel: 06 1234 4567 89</li>
                    <li>Email: windkracht12@mail.com</li>
                </ul>
            </div>
        </div>
    </footer>


</body>

</html>