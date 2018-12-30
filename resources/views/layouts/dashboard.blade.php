<!DOCTYPE html>
<html lang="en">

<head>
    @include('imports.import_css')
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        Só Questões - Dashboard
    </title>
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="img/apple-icon.png">
    <link rel="icon" href="img/favicon.png">
    {{-- temporário! o estilo deve ficar dentro de um arquivo .css e não aqui :-) --}}
    <style type="text/css">
        .question-form{
        }

        .question-form label{
            position: relative !important;
        }

        .question-form .simple-row input{
            border: 1px solid rgb(204,204,204);
            border-radius: 2px;
            background-image: none;
            background-color: white;
        }
    </style>

</head>

<body class="">
    <div class="wrapper">
        <div class="sidebar" data-color="orange" data-background-color="black" data-image="{{ asset('img/dashboard/sidebar-3.jpg') }}">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="logo">
                <a href="#" id="dashboard-home" class="simple-text logo-normal">
                    Só Questões
                </a>
                <div class="logo-normal text-center">
                    <a class="dashboard-menu" id="user" href="#">
                        @if(is_null(Auth::user()->avatar))
                        <img src="{{ asset(Config::get('constants.avatar_path_access') . Config::get('constants.avatar_name')) }}" class="img-responsive rounded-circle" alt="{{Auth::user()->name}}" width="80px" height="80px">  
                        @else      
                        <img src="{{asset(Config::get('constants.avatar_path_access') . Auth::user()->avatar)}}" class="img-responsive rounded-circle" alt="{{Auth::user()->name}}" width="80px" height="80px">  
                        @endif
                </div>

                        <div class="simple-text logo-normal">
                            {{ Auth::user()->name }}
                        </div>
                    </a>
                <div class="simple-text">
                    <a class="" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> {{ __('Sair') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item " id='question-menu'>
                        <a class="nav-link dashboard-menu" id="questions" href="#">
                            <div class="row">
                                <div class="col-md-10">
                                    <i class="fa fa-question-circle"></i>
                                    <p>Questões</p>
                                </div>
                                <div class="col-md-2">
                                    <img class='img-responsive' width="20px" height="20px" src="{{asset('img/dashboard/loading.gif')}}" alt="loading" id="loading-questions" style="display: none;">
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item " id="user-menu">
                        <a class="nav-link dashboard-menu" id="user" href="#">
                            <div class="row">
                                <div class="col-md-10">
                                    <i class="material-icons">person</i>
                                    <p>Usuário</p>
                                </div>
                                <div class="col-md-2">
                                    <img class='img-responsive' width="20px" height="20px" src="{{asset('img/dashboard/loading.gif')}}" alt="loading" id="loading-user" style="display: none;">
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item " id="topic-menu">
                        <a class="nav-link dashboard-menu" id="topics" href="#">
                            <div class="row">
                                <div class="col-md-10">
                                    <i class="fa fa-book"></i>
                                    <p>Tópicos</p>
                                </div>
                                <div class="col-md-2">
                                    <img class='img-responsive' width="20px" height="20px" src="{{asset('img/dashboard/loading.gif')}}" alt="loading" id="loading-user" style="display: none;">
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link dashboard-menu" id="exams" href="#">
                            <div class="row">
                                <div class="col-md-10">
                                    <i class="fas fa-file-alt"></i>
                                    <p>Provas</p>
                                </div>
                                <div class="col-md-2">
                                    <img class='img-responsive' width="20px" height="20px" src="{{asset('img/dashboard/loading.gif')}}" alt="loading" id="loading-user" style="display: none;">
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link dashboard-menu" id="simulations" href="#">
                            <div class="row">
                                <div class="col-md-10">
                                    <i class="fas fa-clipboard-list"></i>
                                    <p>Simulados</p>
                                </div>
                                <div class="col-md-2">
                                    <img class='img-responsive' width="20px" height="20px" src="{{asset('img/dashboard/loading.gif')}}" alt="loading" id="loading-user" style="display: none;">
                                </div>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link dashboard-menu" id="backups" href="#">
                            <div class="row">
                                <div class="col-md-10">
                                    <i class="fas fa-database"></i>
                                    <p>Backups</p>
                                </div>
                                <div class="col-md-2">
                                    <img class='img-responsive' width="20px" height="20px" src="{{asset('img/dashboard/loading.gif')}}" alt="loading" id="loading-user" style="display: none;">
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
                   <footer class="footer ">
        <div class="container-fluid">
        
            <div class="copyright pull-right">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script>
            </div>
        </div>
    </footer> 
            </div>
        </div>
        <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-relative">
                <div class="container-fluid">                    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <form class="navbar-form">
                            <div class="row input-group no-border">
                                <div class="col-md-6">
                                    <a id="refresh" title="Atualizar Busca" class="btn-sm btn-primary rounded-circle text-white float-right" href=""><i class="fas fa-sync-alt"></i></a>
                                    
                                </div>
                                <div class="col-md-6 row">
                                    <div class="col-md-10 pr-0">
                                        <input type="text" name='search' value="" class="form-control" placeholder="Buscar...">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                            <i class="material-icons">search</i>
                                            <div class="ripple-container"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>                        
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            
        <!-- Content -->
        <div class="main-panel container-fluid" id="dashboard-content"></div>
        <!-- End Content -->
    </body>
    @include('imports.import_js')
    <script type="text/javascript">
        $(document).ready(function() {
            demo.initDashboardPageCharts();
            demo.initCharts();
        });
    </script>
</html>
