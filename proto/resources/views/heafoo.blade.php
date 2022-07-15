<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Willkommen bei BSWeb</title>
    <!-- app.css contains Tailwind.css-Classes -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://unpkg.com/@themesberg/flowbite@latest/dist/flowbite.bundle.js"></script>

</head>

<body class="background-main min-h-screen top-0 left-0 right-0">
    <nav class="bg-green-500 shadow xl:flex xl:items-center xl:justify-between py-2 whitespace-nowrap">
        <div class="flex justify-between items-center">
            <span class="text-xl cursor-pointer">
                BSWeb
            </span>
            <span class="cursor-pointer xl:hidden block">
                <img src="{{ url('/images/menu_icon.png') }}" name="btMenu" alt='menu button' onclick="Menu(this)" />
            </span>
        </div>
        <ul class="xl:flex xl:items-center z-[-1] xl:z-auto xl:static absolute bg-green-500 w-full left-0 xl:w-auto xl:py-4 xl:pl-0 pl-7 xl:opacity-100 opacity-0 top-[-400px] transition-all ease-in duration-400">
            <li class="mx-5 xl:my-0">
                <a href="../" class="{{ request()->is('/') ? 'underline' : '' }} text-xl hover:text-gray-500 transition duration-400">Home</a>
            </li>
            <li class="mx-5 xl:my-0">
                <a href="../player_overview" class="{{ request()->is('player_overview') ? 'underline' : '' }} text-xl hover:text-gray-500 transition duration-400">Spielersuche</a>
            </li>
            <li class="mx-5 xl:my-0">
                <a href="../teams_overview" class="{{ request()->is('teams_overview') ? 'underline' : '' }} text-xl hover:text-gray-500 transition duration-400">Mannschaften</a>
            </li>
            <li class="mx-5 xl:my-0">
                <a href="../upload" class="{{ request()->is('upload') ? 'underline' : '' }} text-xl hover:text-gray-500 transition duration-400">Spielbericht hochladen</a>
            </li>
            <li class="mx-5 xl:my-0">
                <a href="../overview" class="{{ request()->is('overview') ? 'underline' : '' }} text-xl hover:text-gray-500 transition duration-400">Spielberichte prüfen</a>
            </li>
            <li class="mx-5 xl:my-0">
                <a href="../match_ok" class="{{ request()->is('match_ok') ? 'underline' : '' }} text-xl hover:text-gray-500 transition duration-400">Spielberichte ansehen</a>
            </li>
            <li class="mx-5 xl:my-0">
                <a href="../login" class="{{ request()->is('login') ? 'underline' : '' }} text-xl hover:text-gray-500 transition duration-400">Login</a>
            </li>
        </ul>
    </nav>
    <main>
        @yield('page-content')
    </main>
    <footer>
        <div class="container mx-auto p-4 flex  justify-center items-center">
            <p>FTR | BSWeb</p>
        </div>
    </footer>
    <script type="text/javascript">
        //Funktion zum bedienen des Menu Buttons bei kleinem Fenster
        function Menu(elem) {
            console.log('test');
            var list = document.querySelector('ul');
            var elems = document.getElementById('li');
            elem.name === 'btMenu' ? (elem.name = 'btClose', list.classList.add('top-[80px]'),
                list.classList.add('opacity-100'), list.classList.remove('hidden'), elems.classList.remove('hidden')) : (elem.name = "btMenu", list.classList.remove('top-[80px]'),
                list.classList.remove('opacity-100'), list.classList.add('hidden'), elems.classList.add('hidden'));
        }
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


        $(document).ready(function() {
            if (document.getElementById("region").value.trim().length == 0) {
                document.getElementById("liga").disabled = true;
            }
            if (document.getElementById("liga").value.trim().length == 0) {
                document.getElementById("saison").disabled = true;
            }
            if (document.getElementById("saison").value.trim().length == 0) {
                document.getElementById("runde").disabled = true;
            }
            if (document.getElementById("runde").value.trim().length == 0) {
                document.getElementById("tag").disabled = true;
            }

            saison();
            runde();
            tag();
            $("#region").autocomplete({
                minLength: 0,
                minChars: 0,

                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('alleRegionen') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            response(data.map(function(value) {
                                return {
                                    'label': value.Name,
                                    'value': value.ID

                                };
                            }));
                        }
                    });
                },
                // focus:function() {if (this.value == ""){
                //  $(this).autocomplete("search");}}
                select: function(event, ui) {
                    // Set selection
                    event.preventDefault();
                    var label = ui.item.label;
                    var value = ui.item.value;
                    $('#region').val(ui.item.label);
                    $('#regionID').val(ui.item.value);
                    document.getElementById("saison").disabled = true;
                    document.getElementById("tag").disabled = true;
                    document.getElementById("runde").disabled = true;
                    ligaregion();
                    document.getElementById("liga").disabled = false;
                    document.getElementById("liga").value = "";
                    document.getElementById("ligaID").value = "";
                    document.getElementById("saison").value = "";
                    document.getElementById("saisonID").value = "";
                    document.getElementById("runde").value = "";
                    document.getElementById("rundeID").value = "";
                    document.getElementById("tag").value = "";
                    document.getElementById("tagID").value = "";
                    document.getElementById("tfHome").value = "";
                    document.getElementById("HeimID").value = "";
                    document.getElementById("tfAway").value = "";
                    document.getElementById("GastID").value = "";
                    // $("#employee_search").text(ui.item.label); // display the selected text
                    //$("#liga").text(ui.item.label);
                    return false;
                }
            });

        });

        function regioncheck() {
            if (!$('#region').val()) {

                document.getElementById("liga").disabled = true;
                document.getElementById("saison").disabled = true;
                document.getElementById("tag").disabled = true;
                document.getElementById("runde").disabled = true;
                document.getElementById("liga").value = "";
                document.getElementById("ligaID").value = "";
                document.getElementById("regionID").value = "";
                document.getElementById("saison").value = "";
                document.getElementById("saisonID").value = "";
                document.getElementById("runde").value = "";
                document.getElementById("rundeID").value = "";
                document.getElementById("tag").value = "";
                document.getElementById("tagID").value = "";
                document.getElementById("tfHome").value = "";
                document.getElementById("HeimID").value = "";
                document.getElementById("tfAway").value = "";
                document.getElementById("GastID").value = "";


            }
        }

        function check() {
            if (!$('#liga').val()) {
                document.getElementById("ligaID").value = "";
                document.getElementById("saison").value = "";
                document.getElementById("saisonID").value = "";
                document.getElementById("runde").value = "";
                document.getElementById("rundeID").value = "";
                document.getElementById("tag").value = "";
                document.getElementById("tagID").value = "";
                document.getElementById("tfHome").value = "";
                document.getElementById("HeimID").value = "";
                document.getElementById("tfAway").value = "";
                document.getElementById("GastID").value = "";
                document.getElementById("saison").disabled = true;
                document.getElementById("tag").disabled = true;
                document.getElementById("runde").disabled = true;
            }



        }

        function alleLigen() {
            $("#liga").autocomplete({
                minLength: 0,
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('alleLigen2') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term

                        },
                        success: function(data) {
                            response(data.map(function(value) {
                                return {
                                    'label': value.Name,
                                    'value': value.ID
                                };
                            }));
                        }
                    });
                },
                select: function(event, ui) {
                    // Set selection
                    event.preventDefault();
                    var label = ui.item.label;
                    var value = ui.item.value;
                    $('#liga').val(ui.item.label);
                    $('#ligaID').val(ui.item.value);
                    document.getElementById("saison").disabled = false;
                    return false;
                }
            });


        }

        function ligaregion() {

            $("#liga").autocomplete({
                minLength: 0,
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('regionLigen') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            region: $("#region").val()

                        },
                        success: function(data) {
                            response(data.map(function(value) {
                                return {
                                    'label': value.Name,
                                    'value': value.ID
                                };
                            }));
                        }
                    });
                },
                select: function(event, ui) {
                    // Set selection
                    event.preventDefault();
                    var label = ui.item.label;
                    var value = ui.item.value;
                    $('#liga').val(ui.item.label);
                    $('#ligaID').val(ui.item.value);
                    document.getElementById("saison").disabled = false;
                    return false;
                }
            });
        }

        function saisoncheck() {
            if (!$('#saison').val()) {
                document.getElementById("saisonID").value = "";
                document.getElementById("rundeID").value = "";
                document.getElementById("runde").value = "";
                document.getElementById("tag").value = "";
                document.getElementById("tagID").value = "";
                document.getElementById("runde").disabled = true;
                document.getElementById("tag").disabled = true;
            }
        }

        function saison() {
            $("#saison").autocomplete({
                minLength: 0,
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('saison') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            ligaID: $("#ligaID").val()

                        },
                        success: function(data) {
                            response(data.map(function(value) {
                                return {
                                    'label': value.Name,
                                    'value': value.ID
                                };
                            }));
                        }
                    });
                },
                select: function(event, ui) {
                    // Set selection
                    event.preventDefault();
                    var label = ui.item.label;
                    var value = ui.item.value;
                    $('#saison').val(ui.item.label);
                    $('#saisonID').val(ui.item.value);
                    document.getElementById("runde").disabled = false;
                    return false;
                }
            });

        }

        function rundecheck() {
            if (!$('#runde').val()) {

                document.getElementById("rundeID").value = "";
                document.getElementById("tag").value = "";
                document.getElementById("tagID").value = "";

                document.getElementById("tag").disabled = true;

            }
        }

        function runde() {


            $("#runde").autocomplete({
                minLength: 0,
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('runde') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            saisonID: $("#saisonID").val()

                        },
                        success: function(data) {
                            response(data.map(function(value) {
                                return {
                                    'label': value.Name,
                                    'value': value.ID
                                };
                            }));
                        }
                    });
                },
                select: function(event, ui) {
                    // Set selection
                    event.preventDefault();
                    var label = ui.item.label;
                    var value = ui.item.value;
                    $('#runde').val(ui.item.label);
                    $('#rundeID').val(ui.item.value);
                    document.getElementById("tag").disabled = false;
                    return false;
                }
            });

        }

        function tagcheck() {
            if (!$('#tag').val()) {
                document.getElementById("tagID").value = "";
            }
        }

        function tag() {


            $("#tag").autocomplete({
                minLength: 0,
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('tag') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            rundeID: $("#rundeID").val()

                        },
                        success: function(data) {
                            response(data.map(function(value) {
                                return {
                                    'label': value.Name,
                                    'value': value.ID
                                };
                            }));
                        }
                    });
                },
                select: function(event, ui) {
                    // Set selection
                    event.preventDefault();
                    var label = ui.item.label;
                    var value = ui.item.value;
                    $('#tag').val(ui.item.label);
                    $('#tagID').val(ui.item.value);;
                    return false;
                }
            });

        }


        function MannschaftenH() { // findet Id der Liga raus, dann erstellt datalist mit mannschaften dieser liga
            if ($("#liga").val().length > 0) {
                $("#tfHome").autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('alleMannschaften') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                liga: $("#liga").val()

                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Name,
                                        'value': value.ID
                                    };
                                }));
                            }
                        });
                    },
                    select: function(event, ui) {
                        // Set selection
                        event.preventDefault();
                        var label = ui.item.label;
                        var value = ui.item.value;
                        $('#tfHome').val(ui.item.label);
                        $('#HeimID').val(ui.item.value);
                        // $("#employee_search").text(ui.item.label); // display the selected text
                        //$("#liga").text(ui.item.label);
                        return false;
                    }
                });
            } else if ($("#region").val().length > 0) {
                $("#tfHome").autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('regionMannschaften') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                region: $("#regionID").val()

                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Name,
                                        'value': value.ID
                                    };
                                }));
                            }
                        });
                    },
                    select: function(event, ui) {
                        // Set selection
                        event.preventDefault();
                        var label = ui.item.label;
                        var value = ui.item.value;
                        $('#tfHome').val(ui.item.label);
                        $('#HeimID').val(ui.item.value);

                        return false;
                    }
                });
            } else {
                $("#tfHome").autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('mannschaften') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,


                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Name,
                                        'value': value.ID
                                    };
                                }));
                            }
                        });
                    },
                    select: function(event, ui) {
                        // Set selection
                        event.preventDefault();
                        var label = ui.item.label;
                        var value = ui.item.value;
                        $('#tfHome').val(ui.item.label);
                        $('#HeimID').val(ui.item.value);

                        return false;
                    }
                });


            }
        }

        function MannschaftenG() { // findet Id der Liga raus, dann erstellt datalist mit mannschaften dieser liga

            if ($("#liga").val().length > 0) {
                $("#tfAway").autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('alleMannschaften') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                liga: $("#liga").val()

                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Name,
                                        'value': value.ID
                                    };
                                }));
                            }
                        });
                    },
                    select: function(event, ui) {
                        // Set selection
                        event.preventDefault();
                        var label = ui.item.label;
                        var value = ui.item.value;
                        $('#tfAway').val(ui.item.label);
                        $('#GastID').val(ui.item.value);
                        // $("#employee_search").text(ui.item.label); // display the selected text
                        //$("#liga").text(ui.item.label);
                        return false;
                    }
                });
            } else if ($("#region").val().length > 0) {
                $("#tfAway").autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('regionMannschaften') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                region: $("#regionID").val()

                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Name,
                                        'value': value.ID
                                    };
                                }));
                            }
                        });
                    },
                    select: function(event, ui) {
                        // Set selection
                        event.preventDefault();
                        var label = ui.item.label;
                        var value = ui.item.value;
                        $('#tfAway').val(ui.item.label);
                        $('#GastID').val(ui.item.value);

                        return false;
                    }
                });
            } else {
                $("#tfAway").autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('mannschaften') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,


                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Name,
                                        'value': value.ID
                                    };
                                }));
                            }
                        });
                    },
                    select: function(event, ui) {
                        // Set selection
                        event.preventDefault();
                        var label = ui.item.label;
                        var value = ui.item.value;
                        $('#tfAway').val(ui.item.label);
                        $('#GastID').val(ui.item.value);

                        return false;
                    }
                });


            }
        }

        function NnameH(elem) {
            var id = document.getElementById(elem);
            var fNameID = elem.replace("Nname", "Vname");
            var fName = document.getElementById(fNameID);
            $(id).autocomplete({
                minLength: 0,
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('getSpielerNname') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            team: $("#HeimID").val()

                        },
                        success: function(data) {
                            response(data.map(function(value) {
                                return {
                                    'label': value.Vname + ' ' + value.Nname,
                                    'labelV': value.Vname,
                                    'labelN': value.Nname,
                                    'value': value.ID
                                };
                            }));
                        }
                    });
                },
                select: function(event, ui) {
                    // Set selection
                    event.preventDefault();
                    var label = ui.item.label;
                    var value = ui.item.value;
                    $(id).val(ui.item.labelN);
                    $(fName).val(ui.item.labelV);

                    // $("#employee_search").text(ui.item.label); // display the selected text
                    //$("#liga").text(ui.item.label);
                    return false;
                }
            });

        }

        function VnameH(elem) { // findet Id der Liga raus, dann erstellt datalist mit mannschaften dieser liga
            var id = document.getElementById(elem);
            var nNameID = elem.replace("Vname", "Nname");
            console.log(nNameID);
            var nName = document.getElementById(nNameID);
            $(id).autocomplete({
                minLength: 0,
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('getSpielerVname') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            team: $("#HeimID").val()

                        },
                        success: function(data) {
                            response(data.map(function(value) {
                                return {
                                    'label': value.Vname + ' ' + value.Nname,
                                    'labelV': value.Vname,
                                    'labelN': value.Nname,
                                    'value': value.ID
                                };
                            }));
                        }
                    });
                },
                select: function(event, ui) {
                    // Set selection
                    event.preventDefault();
                    var label = ui.item.label;
                    var value = ui.item.value;
                    $(id).val(ui.item.labelV);
                    $(nName).val(ui.item.labelN);

                    // $("#employee_search").text(ui.item.label); // display the selected text
                    //$("#liga").text(ui.item.label);
                    return false;
                }
            });

        }

        function NnameG(elem) {
            var id = document.getElementById(elem);
            var fNameID = elem.replace("Nname", "Vname");
            var fName = document.getElementById(fNameID);
            $(id).autocomplete({
                minLength: 0,
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('getSpielerNname') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            team: $("#GastID").val()

                        },
                        success: function(data) {
                            response(data.map(function(value) {
                                return {
                                    'label': value.Vname + ' ' + value.Nname,
                                    'labelV': value.Vname,
                                    'labelN': value.Nname,
                                    'value': value.ID
                                };
                            }));
                        }
                    });
                },
                select: function(event, ui) {
                    // Set selection
                    event.preventDefault();
                    var label = ui.item.label;
                    var value = ui.item.value;
                    $(id).val(ui.item.labelN);
                    $(fName).val(ui.item.labelV);

                    // $("#employee_search").text(ui.item.label); // display the selected text
                    //$("#liga").text(ui.item.label);
                    return false;
                }
            });

        }

        function VnameG(elem) {
            var id = document.getElementById(elem);
            var nNameID = elem.replace("Vname", "Nname");
            var nName = document.getElementById(nNameID);
            $(id).autocomplete({
                minLength: 0,
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('getSpielerVname') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            team: $("#GastID").val()

                        },
                        success: function(data) {
                            response(data.map(function(value) {
                                return {
                                    'label': value.Vname + ' ' + value.Nname,
                                    'labelV': value.Vname,
                                    'labelN': value.Nname,
                                    'value': value.ID
                                };
                            }));
                        }
                    });
                },
                select: function(event, ui) {
                    // Set selection
                    event.preventDefault();
                    var label = ui.item.label;
                    var value = ui.item.value;
                    $(id).val(ui.item.labelV);
                    $(nName).val(ui.item.labelN);

                    // $("#employee_search").text(ui.item.label); // display the selected text
                    //$("#liga").text(ui.item.label);
                    return false;
                }
            });

        }
    </script>
</body>

</html>
