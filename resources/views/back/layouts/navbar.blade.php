		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand" style="padding: 25px 39px;">
				<a href="{{ url('') }}"><h2 style="margin: 0;color: #4a4a4a;font-size: 25px;"><img src="{{ asset('back/img/logo2.png') }}" alt="{{ config('app.name') }}" width="200"></h2></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="{{ url(config('app.url')) }}" target="_blank"><span class="glyphicon glyphicon-link"></span></a>
						</li>						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
								<i class="lnr lnr-alarm"></i>
								@if (sizeof($notifications) > 0)
								<span class="badge bg-danger">{{ sizeof($notifications) }}</span>
								@endif
							</a>
							<ul class="dropdown-menu notifications">
								@if (sizeof($notifications) > 0)
								@foreach ($notifications as $notification)
									<li><a href="{{ $notification['url'] }}" class="notification-item"><span class="dot bg-warning"></span>{{ $notification['message'] }}</a></li>
								@endforeach
								@else
								<li><a href="#" class="notification-item">No hay notificaciones</a></li>
								@endif
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{ asset('back/img/user.png') }}" class="img-circle" alt="Avatar"> <span>{{ Auth::user()->name }}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="{{ url('account') }}"><i class="lnr lnr-user"></i> <span>Mi cuenta</span></a></li>
								<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="lnr lnr-exit"></i> <span>Cerrar sesión</span></a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>