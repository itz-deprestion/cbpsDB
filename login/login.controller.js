app.controller('loginController',function($rootScope, $scope, $http, $location, $css){
	
	$css.removeAll();
	$css.add([
		'templates/lumino/css/styles-' + $rootScope.theme + '.css',
		'css/style-' + $rootScope.theme + '.css',
		'css/vitadb-' + $rootScope.theme + '.css',
	]);
	
	// submit function, execute an user login
	$scope.submit = function () {
		var data = {
			email: $scope.user.email,
			password: $scope.user.password
		}
		
		// Login request to the server
		$http.post('login.php', data).then(res => {
			if (res.data[0].name != null){
				$rootScope.user = res.data[0]
				alertify.success('Welcome, ' + $rootScope.user.name + '!')
				
				$location.path('/')
				if ($scope.remember) { // If remember me is selected we save id and token to localStorage
					localStorage.setItem('id', $rootScope.user.email)
					localStorage.setItem('token', $rootScope.user.password)
					localStorage.setItem('name', $rootScope.user.name)
					localStorage.setItem('role', $rootScope.user.role)
					localStorage.setItem('theme', $rootScope.theme)
				} else {
					localStorage.removeItem('id')
					localStorage.removeItem('token')
					localStorage.removeItem('name')
					localStorage.removeItem('role')
					localStorage.removeItem('theme')
				}
			}else alertify.error('User not found.')
		})
	}
	
})
