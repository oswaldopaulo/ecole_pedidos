<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pedidos Ebras') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

   <style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  
}

li {
  float: left;
}

li a {
  display: block;
  
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover {
  background-color: #eee;
}
</style>
    
    

</head>
<body>
    <div id="app">
    @if (Auth::user())
        <nav class="navbar navbar-default navbar-static-top">
    <h1>Controle de Pedidos</h1>         
            
 <ul>
                        <!-- Authentication Links -->
                        
                            <li>
                              

                                <ul>
                                		<li><a href="{{ url('pedidos') }}">Pedidos Recebidos</a></li>
                                        <li><a href="{{ url('pedidos/check') }}">Pedidos Checados</a></li>
                                        <li><a href="{{ url('emails') }}">Emails</a><li>
                                        <li><a href="{{ url('pedidos/arquivos') }}">Arquivos</a><li>
                                    <li>
                                    	
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                      
                    </ul>
            
        </nav>
        
		@endif
        @yield('content')
    </div>
    

    <!-- Scripts -->
     
   
</body>
</html>
