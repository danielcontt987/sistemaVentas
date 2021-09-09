<script src="{{ asset('assets/js/loader.js') }}"></script>
<link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
<link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/structure.css') }}" rel="stylesheet" type="text/css" class="structure" />
<link href="{{ asset('assets/css/elements/avatar.css') }}" rel="stylesheet" type="text/css" class="structure" />
<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/widgets/modules-widgets.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/fontawesome.css') }}" rel="stylesheet" type="text/css" class="structure" />
<link href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" class="dashboard-sales" />

<link href="{{ asset('plugins/font-icons/fontawesome/css/fontawesome.css') }}" rel="stylesheet" type="text/css" class="structure" />
<link href="{{ asset('plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" class="structure" />
<link href="{{ asset('plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" class="structure" />
<link href="{{ asset('plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/apps/scrumboard.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/apps/notes.css') }}">

<style>
    a:hover .boton{
        color:aqua;
    }
    aside{
        display: none!important
    }

    .page-item.active .page-link{
        z-index: 3;
        color: #000;
        background: #3b3f5c;
        border-color: #3b3f5c;
    }
    a .tbmenu:hover{
        color:beige;
    }

    @media (max-width:480){
        .mtmobile{
            margin-bottom: 20px!important;
        }
        .mbmobile{
            margin-bottom: 10!important;
        }
        .hideonsm{
            display:none!important;
        }
        .inblock{
            display: block;
        }
    }

    .sidebar-theme #compactSidebar{
        background: #191e3a!important;
    }

    
    .header-container .sidebarCollapse {
    color: #3b3f5c!important;
}

</style>

@livewireStyles