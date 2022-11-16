<!DOCTYPE html>
<html>
	<head>
		<title>{{ config('app.name') }}</title>
	</head>
	<body style="color: #444444; font: 14px/1.42857 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;">
		<div style="background-color: #ffffff;">
			<div style="margin: 0 auto; width: 600px;">
				<div style="padding: 10px 0;">
					<img
						alt="{{ config('app.name') }} Logo"
						src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg"
						style="display: block; width: 142px !important;"
					/>
				</div>
			</div>
		</div>
		<div style="background: #e6e6e6">
			<div style="margin: 0 auto; width: 600px;">
				<div style="background: #ffffff; padding: 10px;">
					@yield('content')
				</div>
			</div>
		</div>
		<div style="background: #e6e6e6">
			<div style="margin: 0 auto; width: 600px">
				<div style="padding: 10px;">
					{{ config('app.name').' '.config('app.now')->format('Y') }}
				</div>
			</div>
		</div>
	</body>
</html>
