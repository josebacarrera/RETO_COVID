angular.module('MyApp', ['ngMaterial', 'ngMessages', 'material.svgAssetsCache'])
.controller('AppCtrl', function($scope) {
  $scope.isDisabled = true;
  $scope.googleUrl = 'http://google.com';
});