@extends('heafoo')
@section('page-content')
    <style>
        html,
        body {
            height: 100%;
        }

        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid green;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 2s linear infinite;
            visibility: hidden;
            margin: auto;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <section class="flex  justify-center items-center"> <br>
        <h3 class=" font-bold  text-2xl">Spielbericht hochladen</h3>
    </section>
    <br> <br>
    <br>
    <section class="flex justify-center items-center ">
        <div>
            <form action="{{ route('imageUploadPost') }}" method="POST" enctype="multipart/form-data" id="upload">
                @csrf
                <div class="row">
                    <input type="file" name="image" class="form-control bg-green-500 disabled:opacity-90 hover:bg-green-700 text-white font-bold py-2 px-4 mx-8 border-green-700 rounded">
                    <button type="submit" class="btn btn-success bg-green-500 disabled:opacity-90 hover:bg-green-700 text-white font-bold py-2 px-4 mx-8 border-green-700 rounded">Bild hochladen</button>
                    <!-- warten auf Antwort,  Bericht mit A ausfüllen  -->
            </form>
            <button class="bg-green-500 disabled:opacity-90 hover:bg-green-700 text-white font-bold py-2 px-4 m-8 border-green-700 rounded" type="button" onclick="window.location='{{ url('/make_report') }}'">Bericht ausfüllen </button>
        </div>

        <div class="loader" id="loader"></div>
    </section>

    <div class="">
        <h2 class="font-bold text-2xl">Tipps für bessere Ergebnisse:</h2>
        <h3 class="font-bold text-xl my-3">Um die Erkennung zu verbessern sollte bei der Aufnahme des Bildes auf folgendes geachtet werden:</h3>
        <div>
            <h4 class="font-bold text-xl">Aufnahme:</h4>
            <div class="mt-2">
                <div class="max-w-3xl">
                    <ol>
                        <li>
                            <p class="text-xl mb-3">⇒ Die Aufnahme des Berichtes sollte möglichst gerade von oben erfolgen. Als Hilfsmittel dienen die Orientierungslinien an den Ecken des Berichts.</p>
                        </li>
                        <li>
                            <p class="text-xl mb-3">⇒ Es sollte auf ausreichend Beleuchtung geachtet werden</p>
                        </li>
                        <li>
                            <p class="text-xl mb-3">⇒ Der Hintergrund sollte möglichst neutral sein. Am Besten wird das Bild so nah aufgenommen, dass kaum etwas vom Hintergrund zu erkennen ist.</p>
                        </li>
                        <li>
                            <p class="text-xl mb-3">⇒ Der komplette Bericht sollte auf der Aufnahme sichtbar sein.</p>
                        </li>

                        <li>
                            <p class="text-xl mb-3">⇒ Das Foto sollte möglichst Scharf sein, sodass Buchstaben gut erkannt werden können</p>
                        </li>
                    </ol>
                </div>
                <div class="flex">
                    <div class="mt-2">
                        <img src="{{ asset('img/goodBer.png') }}" width="500" alt="Bild eines korrekt aufgenommenen Berichtes">
                    </div>
                    <div class="max-w-3xl">
                        <img class="ml-2 mb-2" src="{{ asset('img/tilt.png') }}" width="500" alt="Bild eines schief aufgenommenen Berichtes">
                    </div>
                    <div class="mt-2">
                        <img src="{{ asset('img/unv.png') }}" width="500" alt="Bild eines unvollständig aufgenommenen Berichtes">
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h4 class="font-bold text-xl">Schrift</h4>
            <div class="mt-2">
                <div class="max-w-3xl">
                    <ol>
                        <li>
                            <p class="text-xl mb-3">⇒ Die geschriebenen Buchstaben sollten klar erkennbar sein</p>
                        </li>
                        <li>
                            <p class="text-xl mb-3">⇒ Zwischen den einzelnen Buchstaben sollte ein ausreichend großer Abstand sein, damit die Handschrifterkennung diese nicht zusammenfügt.</p>
                        </li>
                        <li>
                            <p class="text-xl mb-3">⇒ Jeder Einzelne Vor- und Nachname sowie die Satzergebnisse sollten in separaten Zellen stehen.</p>
                        </li>
                        <li>
                            <p class="text-xl mb-3">⇒ Die Zellengrenzen sollten nicht überschrieben werden</p>
                        </li>
                        <li>
                            <p class="text-xl mb-3">⇒ Am Besten sollte man dunkle Farben wie dunkelblau oder schwarz zum Schreiben verwenden</p>
                        </li>
                    </ol>
                </div>
                <div class="flex">
                    <div class="mt-2">
                        <img src="{{ asset('img/clean.png') }}" width="500" alt="Vergleich klare und unklare Schrift">
                    </div>
                    <div>
                        <img src="{{ asset('img/abstand.png') }}" width="500" alt="Vergleich klare und unklare Schrift">
                    </div>
                    <div>
                        <img src="{{ asset('img/overline.png') }}" width="500" alt="Vergleich klare und unklare Schrift">
                    </div>
                    <div>
                        <img src="{{ asset('img/color.png') }}" width="500" alt="Vergleich klare und unklare Schrift">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#upload").on("submit", function() {
                document.getElementById("loader").style.visibility = "visible";
            }); //submit
        }); //document ready
    </script>
@endsection
