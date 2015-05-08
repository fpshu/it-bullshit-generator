'use strict';

var itBullshit = angular.module('itBullshit', []);

itBullshit.constant('config', {
    appName: 'IT Bullshit Generator',
    appVersion: 1.0,
    apiUrl: 'api.php'
});

itBullshit.config(['$locationProvider', function ($locationProvider) {
    $locationProvider.html5Mode(true).hashPrefix('!');
}]);

itBullshit.controller('MainController', ['$location', '$scope', '$http', 'config', function ($location, $scope, $http, config) {

    $scope.showTheBullshit = function (id) {
        $http({
            method: 'JSONP',
            url: config.apiUrl + '?id=' + (id ? id : '') + '&callback=JSON_CALLBACK'
        }).success(function (response) {
            $scope.theBullshit = response.bullshit;
            $location.search('b', response.hash);
            if(response.error){
                console.error(response.error);
            }
        });
    };

    if ($location.search().b) {
        $scope.showTheBullshit($location.search().b);
    } else {
		$scope.showTheBullshit();
	}

}]);
