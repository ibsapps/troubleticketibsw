	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
	</ul>

	<!-- Right navbar links -->

	<ul class="navbar-nav ml-auto">
		<li class="nav-item">
			<a class="nav-link" href="#" role="button"><i class="fas fa-user-ninja"></i></a>
		</li>


		<!-- <button class="btn btn-danger">Logout</button> -->
		<li class="nav-item">
			<a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" role="button"><i class="fas fa-sign-out-alt"></i></a>
		</li>
		<form id="logout-form" action="{{ route('logout') }}" method="POST">
			@csrf
		</form>

	</ul>