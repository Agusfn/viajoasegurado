		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<!--li><a href="{{ url('') }}" @if(@$section == 'home') class="active" @endif><i class="lnr lnr-home"></i> <span>Inicio</span></a></li-->
						<li><a href="{{ url('quotations') }}" @if(@$section == 'quotations') class="active" @endif><i class="fa fa-usd" style="width: 18px;text-align: center;"></i> <span>Cotizaciones</span></a></li>
						<li><a href="{{ url('contracts') }}" @if(@$section == 'contracts') class="active" @endif><i class="fa fa-file-text-o" aria-hidden="true" style="width: 18px;"></i> <span>Contrataciones</span></a></li>
						<!--li><a href="{{ url('payments') }}" @if(@$section == 'payments') class="active" @endif><i class="fa fa-credit-card" aria-hidden="true" style="width: 18px; font-size: 16px;"></i> <span>Pagos</span></a></li-->
						@if(Auth::user()->isAdmin(true))
						<li><a href="{{ url('users') }}" @if(@$section == 'users') class="active" @endif><i class="fa fa-user-o" aria-hidden="true"></i>  <span>Cuentas de admin</span></a></li>
						<li><a href="{{ url('settings') }}" @if(@$section == 'settings') class="active" @endif><i class="lnr lnr-cog"></i> <span>Configuración</span></a></li>
						@endif
						
					</ul>
				</nav>
			</div>
		</div>