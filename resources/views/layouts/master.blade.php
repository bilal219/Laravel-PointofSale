<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.partials._head')
</head>
<body>
	<div class="wrapper">
		
        @include('layouts.partials._header')
		@include('layouts.partials._sidebar')

		<div class="main-panel">
			
                @yield('content')
				
			
			
            @include('layouts.partials._footer')
		</div>
		
		@include('layouts.partials._custom')
		@include('layouts.partials._modals')
	</div>
	@include('layouts.partials._footer-script')
</body>
</html>