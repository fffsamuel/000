@extends('layouts.frontend')



    <!-- Navigation -->
    {{-- <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Laravel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{route('register')}}">Registrar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Entrar</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
 --}}

{{-- @section('content')
    <header class="masthead text-center text-white">
      <div class="masthead-content">
        <div class="container">
          <h1 class="masthead-heading mb-0">SÓ QUESTÕES</h1>
          <h2 class="masthead-subheading mb-0">TUDO PARA VOCÊ TESTAR SEU CONHECIMENTO</h2>
          <a href="#" class="btn btn-primary btn-xl rounded-pill mt-5">Registre-se</a>
        </div>
      </div>
      <div class="bg-circle-1 bg-circle"></div>
      <div class="bg-circle-2 bg-circle"></div>
      <div class="bg-circle-3 bg-circle"></div>
      <div class="bg-circle-4 bg-circle"></div>
    </header>

    <section>
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 order-lg-2">
            <div class="p-5">
              <img class="img-fluid rounded-circle" src="img/01.jpg" alt="">
            </div>
          </div>
          <div class="col-lg-6 order-lg-1">
            <div class="p-5">
              <h2 class="display-4">For those about to rock...</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod aliquid, mollitia odio veniam sit iste esse assumenda amet aperiam exercitationem, ea animi blanditiis recusandae! Ratione voluptatum molestiae adipisci, beatae obcaecati.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="p-5">
              <img class="img-fluid rounded-circle" src="img/02.jpg" alt="">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="p-5">
              <h2 class="display-4">We salute you!</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod aliquid, mollitia odio veniam sit iste esse assumenda amet aperiam exercitationem, ea animi blanditiis recusandae! Ratione voluptatum molestiae adipisci, beatae obcaecati.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 order-lg-2">
            <div class="p-5">
              <img class="img-fluid rounded-circle" src="img/03.jpg" alt="">
            </div>
          </div>
          <div class="col-lg-6 order-lg-1">
            <div class="p-5">
              <h2 class="display-4">Let there be rock!</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod aliquid, mollitia odio veniam sit iste esse assumenda amet aperiam exercitationem, ea animi blanditiis recusandae! Ratione voluptatum molestiae adipisci, beatae obcaecati.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 bg-black">
      <div class="container">
        <p class="m-0 text-center text-white small">Copyright &copy; Your Website 2018</p>
      </div>
      <!-- /.container -->
    </footer>

@endsection    
 --}}

@section('content')
  <div class="jumbotron text-center frontpage">

    <section>
      <div class="container title-soquestoes rounded-pill">
        <div class="row">
          <div class="col-xl-12" >
              <h1 class="title">SÓ QUESTÕES</h1>
          </div>        
        </div>
        <div class="row">
          <div class="col-xl-12">
            <h2 class="title">TUDO PARA VOCÊ TESTAR SEU CONHECIMENTO</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-xl-12">
            <a href="{{ route('register') }}" class="btn btn-secondary btn-xl rounded-pill">
              Registre-se
            </a>
          </div>
        </div>
      </div>
    </section>

    

    <section>
      <div class="container">
        <div class="row">
          <div class="col-xl-4"></div>
          <div class="postit-one text-center col-xl-4">
            <h2 class="section-heading">SOBRE NOS</h2>
            <hr>
          </div>
          <div class="col-xl-4"></div>
        </div>
        <div class="row">
          <div class="col-xl-2"></div>
          <div class="col-xl-4 postit-one text-center">            
            <p class="text-faded mb-4">Somos uma empresa que oferece um serviço de simulação de teste para exames.</p>
          </div>        
        </div>
        <div class="row">
          <div class="col-xl-6"></div>
          <div class="col-xl-4 postit-two text-center">
            <p class="text-faded mb-4">Você pode realizar simulações de exames selecionando o tópico e o número de perguntas que você deseja.</p>
            </div>
        </div>
        <div class="row">
          <div class="col-xl-2"></div>
          <div class="col-xl-4 postit-two text-center">
            <p class="text-faded mb-4">Depois de realizar o teste, você pode ver a correção, assim como o histórico de todos os testes realizados.</p>
          </div>
        </div>
      </div>
    </section>

    <section id="contact">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading">Entre em contato!</h2>
            <hr class="my-4">
            <p class="mb-5">Pronto para começar seus testes para concursos? Isso é ótimo! Envie-nos um e-mail e nós retornaremos o mais rápido possível.</p>

            <div class="alert alert-success" id="message-sent" style="display: none;">
                O mensagem foi enviado!
            </div>

            <form id="contact-form" method="POST">
              <input class="form-control" type="text" name="name" placeholder="Nome">
              <br>
              <input class="form-control" type="text" name="email" placeholder="Email">
              <br>
              <textarea class="form-control" name="message" placeholder="Mensagem"></textarea>
              <br>
              <input type="submit" class="form-control btn btn-primary" value="Enviar">
            </form>
          </div>
        </div>
      </div>


@endsection