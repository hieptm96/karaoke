var ktv_app = angular.module('ktv-form', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});
ktv_app.controller('ktv-ctl', ['$scope', '$http', 'districts', function($scope, $http, districts) {
    $scope.districts = [];
    $scope.get_districts = function() {
//            districts.get($scope.province).then(function(data) {
//                if (data) {
//                    $scope.districts = data;
//                    console.log($scope.districts);
//                }
//            });
        $http({
            url: url,
            method: "GET",
            responseType: 'text',
            params: {
                _token: '{{ csrf_token() }}',
                province_id: $scope.province,
            }
        }).then(function(response) {
            $scope.districts = response.data.data;
        })
    }
}]);
// Factory ajax
ktv_app.factory('districts', ['$http', function($http) {
    return {
        get: function(province_id) {
            $http({
                url: "{{ route('ktvs.getdistricts') }}",
                method: "GET",
                responseType: 'text',
                data: {
                    _token: '{{ csrf_token() }}',
                    province_id: province_id,
                }
            }).then(function(response) {
                return response.data.data;
            })
        }
    };
}]);