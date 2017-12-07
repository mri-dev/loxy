var szinvalaszto = angular.module('Szinvalaszto', ['colorpicker']);

szinvalaszto.controller('FormSelector', ['$scope', '$http', function($scope, $http)
{
  $scope.settings = {};
  $scope.settings.groups = {};
  $scope.settings_group = [];
  $scope.loaded = false;

  $scope.init = function() {
    $scope.prepareDefaultSettings();
    $scope.loadSettings();
  }

  $scope.prepareDefaultSettings = function(){
    $scope.settings_group.push({
      'key': 'haz_alap',
      'title': 'A ház alapjának választható színei'
    });
    $scope.settings_group.push({
      'key': 'haz_teteje',
      'title': 'A ház tetejének választható színei'
    });
    $scope.settings_group.push({
      'key': 'haz_hatfal',
      'title': 'A ház hátfalának választható színei'
    });
  }

  $scope.loadSettings = function()
  {
    $scope.loaded = false;
		$http({
			method: 'POST',
			url: '/wp-admin/admin-ajax.php?action=szinvalaszto',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			data: jQuery.param({
        type: 'getSettings'
			})
		}).then(function successCallback(r) {
      console.log(r.data);
      if (r.data.data) {
        $scope.settings = r.data.data;
        $scope.loaded = true;
      }
    }, function errorCallback(response) {
    });
	}

}]);

szinvalaszto.controller('Konfigurator', ['$scope', '$http', function($scope, $http)
{
  $scope.settings = {};
  $scope.settings.groups = {};
  $scope.settings_group = [];
  $scope.loaded = false;
  $scope.saveprogress = false;

  $scope.init = function(){
    $scope.prepareDefaultSettings();
    $scope.loadSettings();
  }

  $scope.addItemValue = function(key){
    if (typeof $scope.settings.groups[key] === 'undefined') {
      $scope.settings.groups[key] = [];
    }
    $scope.settings.groups[key].push({
      'name': '# név',
      'value': '#AAAAAA'
    });
  }

  $scope.prepareDefaultSettings = function(){
    $scope.settings_group.push({
      'key': 'haz_alap',
      'title': 'A ház alapjának választható színei'
    });
    $scope.settings_group.push({
      'key': 'haz_teteje',
      'title': 'A ház tetejének választható színei'
    });
    $scope.settings_group.push({
      'key': 'haz_hatfal',
      'title': 'A ház hátfalának választható színei'
    });
  }

  $scope.removeItem = function(key, index){
    $scope.settings.groups[key].splice(index, true);
  }

  $scope.saveSettigns = function(){
    $scope.saveprogress = true;
    $http({
			method: 'POST',
			url: '/wp-admin/admin-ajax.php?action=szinvalaszto',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			data: jQuery.param({
        type: 'saveSettings',
        settings: angular.toJson($scope.settings)
			})
		}).then(function successCallback(r) {
      $scope.saveprogress = false;
      console.log(r);
    }, function errorCallback(r) {
    });
  }

  $scope.loadSettings = function()
  {
    $scope.loaded = false;
		$http({
			method: 'POST',
			url: '/wp-admin/admin-ajax.php?action=szinvalaszto',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			data: jQuery.param({
        type: 'getSettings'
			})
		}).then(function successCallback(r) {
      console.log(r.data);
      if (r.data.data) {
        $scope.settings = r.data.data;
        $scope.loaded = true;
      }
    }, function errorCallback(response) {
    });
	}

}]);
