<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>

    {{-- icon --}}
    <link rel="icon" href="{{ asset('icon/android-chrome-512x512.png') }}">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@3.2/dist/css/coreui.min.css" rel="stylesheet" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css'
        integrity='sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=='
        crossorigin='anonymous' />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css"
        rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />

    {{-- fresui --}}
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('frestui/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    </link>
    <link rel="stylesheet" type="text/css" href="{{ asset('frestui/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('frestui/app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('frestui/app-assets/vendors/css/pickers/daterange/daterangepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frestui/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('frestui/app-assets/vendors/css/calendars/tui-time-picker.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('frestui/app-assets/vendors/css/calendars/tui-date-picker.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('frestui/app-assets/vendors/css/calendars/tui-calendar.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frestui/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frestui/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frestui/app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frestui/app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frestui/app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frestui/app-assets/css/themes/semi-dark-layout.css') }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('frestui/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('frestui/app-assets/css/plugins/calendars/app-calendar.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frestui/assets/css/style.css') }}">
    <!-- END: Custom CSS-->

    {{-- bootstrap icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <style>
    .custom-datatable-th::before {
        content: "\e9b9";
        font-size: 1.1rem;
    }

    .dt-buttons,
    .dataTables_filter {
        display: none;
    }

    /* .custom-datatable-th::after {
            content: "\e9ac";
            padding-top: 0.5rem !important;
            font-size: 1.1rem;
        } */
    .table.dataTable thead .sorting:after,
    .table.dataTable thead .sorting_asc:after,
    .table.dataTable thead .sorting_desc:after,
    .table.dataTable thead .sorting_desc_disabled:after {
        content: "\e9ac";
        padding-top: 0.7em;
        font-size: 1.1rem;
    }

    .menu-content li a {
        transition: all 0.35s ease !important;
    }

    th::after,
    th::before {
        margin: 0 1rem 0.5rem 1rem !important;

    }

    .open .menu-title::after {
        transform: rotate(180deg) !important;
    }

    .has-sub .menu-title::after {
        content: "\e9b9";
        font-family: "boxicons";
        font-size: 1.2rem;
        color: #8494a7;
        display: inline-block;
        position: absolute;
        right: 7px;
        transform: rotate(0deg);
        transition: -webkit-transform 0.4s ease-in-out;
    }

    .main-menu i {
        width: 1.6rem !important;
        min-width: 1.6rem;
        margin-right: 1rem;
        float: left;
    }

    .dataTables_wrapper .dataTables_length {
        float: none !important;
    }

    .disabled .page-link {
        color: #828D99 !important;
        background-color: #eeeff1 !important;
    }

    .disabled .page-link:hover {
        color: #828D99 !important;
        background-color: #eeeff1 !important;
    }

    .page-link {
        border-radius: 0.3rem;
        text-align: center;
        margin-left: 0.3rem !important;
        background-color: rgba(90, 141, 238, 0.17);
        color: #5A8DEE !important;
    }

    .page-link:hover {
        border-color: #2c6de9 !important;
        background-color: #5A8DEE !important;
        color: #fff !important;
    }

    .active .page-link {
        border-color: #2c6de9 !important;
        background-color: #5A8DEE !important;
        color: #fff !important;
    }

    .pagination {
        margin: 0 !important;
    }

    .dataTables_info {
        padding: 0 !important;
    }
    </style>
    @yield('styles')
</head>

<body class="c-app">
    @include('partials.menu')
    <div class="c-wrapper">
        <header class="c-header c-header-fixed px-3">
            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
                data-class="c-sidebar-show">
                <i class="fas fa-fw fa-bars"></i>
            </button>

            <a class="c-header-brand d-lg-none" href="#">{{ trans('panel.site_title') }}</a>

            <button class="c-header-toggler mfs-3 d-md-down-none" type="button" responsive="true">
                <i class="fas fa-fw fa-bars"></i>
            </button>

            <ul class="c-header-nav ml-auto">
                @if (count(config('panel.available_languages', [])) > 1)
                <li class="c-header-nav-item dropdown d-md-down-none">
                    <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach (config('panel.available_languages') as $langLocale => $langName)
                        <a class="dropdown-item"
                            href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }}
                            ({{ $langName }})
                        </a>
                        @endforeach
                    </div>
                </li>
                @endif


            </ul>
        </header>

        <div class="c-body">
            <main class="c-main">


                <div class="container-fluid">
                    @if (session('message'))
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                        </div>
                    </div>
                    @endif
                    @if ($errors->count() > 0)
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @yield('content')

                </div>


            </main>
            <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </div>

    {{-- frest ui js --}}
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('frestui/app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('frestui/app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/vendors/js/editors/quill/highlight.min.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/vendors/js/editors/quill/quill.min.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/vendors/js/calendar/tui-code-snippet.min.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/vendors/js/calendar/tui-dom.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/vendors/js/calendar/tui-time-picker.min.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/vendors/js/calendar/tui-date-picker.min.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/vendors/js/extensions/moment.min.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/vendors/js/calendar/chance.min.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/vendors/js/calendar/tui-calendar.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('frestui/app-assets/js/scripts/configs/vertical-menu-light.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/js/core/app.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/js/scripts/components.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/js/scripts/footer.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('frestui/app-assets/js/scripts/editors/editor-quill.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/js/scripts/extensions/calendar/calendars-data.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/js/scripts/extensions/calendar/schedules.js') }}"></script>
    <script src="{{ asset('frestui/app-assets/js/scripts/extensions/calendar/app-calendar.js') }}"></script>
    <!-- END: Page JS-->

    {{-- fresh ui end --}}


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js">
    </script>
    <script src="https://unpkg.com/@coreui/coreui@3.2/dist/js/coreui.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <sc ript src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></sc>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
    $(function() {
        let copyButtonTrans = '{{ trans('
        global.datatables.copy ') }}'
        let csvButtonTrans = '{{ trans('
        global.datatables.csv ') }}'
        let excelButtonTrans = '{{ trans('
        global.datatables.excel ') }}'
        let pdfButtonTrans = '{{ trans('
        global.datatables.pdf ') }}'
        let printButtonTrans = '{{ trans('
        global.datatables.print ') }}'
        let colvisButtonTrans = '{{ trans('
        global.datatables.colvis ') }}'
        let selectAllButtonTrans = '{{ trans('
        global.select_all ') }}'
        let selectNoneButtonTrans = '{{ trans('
        global.deselect_all ') }}'

        let languages = {
            'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
        };

        $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {
            className: 'btn'
        })
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                url: languages['{{ app()->getLocale() }}']
            },
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }, {
                orderable: false,
                searchable: false,
                targets: -1
            }],
            select: {
                style: 'multi+shift',
                selector: 'td:first-child'
            },
            order: [],
            scrollX: true,
            pageLength: 100,
            dom: 'lBfrtip<"actions">',
            buttons: [{
                    extend: 'selectAll',
                    className: 'btn-light-primary rounded glow',
                    text: selectAllButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    },
                    action: function(e, dt) {
                        e.preventDefault()
                        dt.rows().deselect();
                        dt.rows({
                            search: 'applied'
                        }).select();
                    }
                },
                {
                    extend: 'selectNone',
                    className: 'btn-primary rounded glow',
                    text: selectNoneButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'copy',
                    className: 'btn-light-secondary glow rounded',
                    text: copyButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-light-secondary glow rounded',
                    text: csvButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-light-secondary glow rounded',
                    text: excelButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn-light-secondary glow rounded',
                    text: pdfButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    className: 'btn-light-secondary glow rounded',
                    text: printButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }


                },
                {
                    extend: 'colvis',
                    className: 'btn-light-secondary glow rounded',
                    text: colvisButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        });

        $.fn.dataTable.ext.classes.sPageButton = '';
    });
    </script>

    <script>
    $(document).ready(function() {


        function formatItem(item) {
            if (item.loading) {
                return '{{ trans('
                global.searching ') }}...';
            }
            var markup = "<div class='searchable-link' href='" + item.url + "'>";
            markup += "<div class='searchable-title'>" + item.model + "</div>";
            $.each(item.fields, function(key, field) {
                markup += "<div class='searchable-fields'>" + item.fields_formated[field] + " : " +
                    item[field] + "</div>";
            });
            markup += "</div>";

            return markup;
        }






        function formatItemSelection(item) {
            if (!item.model) {
                return '{{ trans('

                global.search ') }}...';
            }
            return item.model;
        }
        $(document).delegate('.searchable-link', 'click', function() {
            var url = $(this).attr('href');
            window.location = url;
        });
    });
    </script>
    @yield('scripts')
</body>

</html>
