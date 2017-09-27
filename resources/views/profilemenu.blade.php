
  @if(Auth::check())
    <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
      {{Auth::user()->name}}&nbsp;<small>[{{Auth::user()->role->name}}]</small>
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
	  <li><a href="{{url('/')}}">Мой кабинет</a></li>
      <li><a href="#">Настройки</a></li>

      <li role="separator" class="divider"></li>
      <li><a href="{{ url('/auth/logout') }}">Выход</a></li>
    </ul>
  </li>
  @else
    <li><a href="{{ url('/auth/login') }}">Вход</a></li>
  @endif
