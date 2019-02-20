// create angular app
	var dgnApp = angular.module('dgnApp', []);

	// create angular controller
	dgnApp.controller('signUpValidationCtrl', ['$scope', '$uibModal', 'SignUpValidationFactory', function ($scope, $uibModal, SignUpValidationFactory)  {

		// function to submit the form after all validation has occurred			
		$scope.submitForm = function() {

			// check to make sure the form is completely valid
			if ($scope.userForm.$valid) {
				SignUpValidationFactory.SignupUser($scope.user).then(function (response) {
		            
		        });
			}

		};

	}]);



	(function () {
    var SignUpValidationFactory = function ($http) {

        var signupUser = function (model) {
            return $http.post('?controller=users&action=signup',
               { model: model })
               .then(function (response) {
                   return response;
               });
        };

        
        return {
            SignupUser: signupUser
        };
    };

    dgnApp.factory('SignUpValidationFactory', SignUpValidationFactory);

})();