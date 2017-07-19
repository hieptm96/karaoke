var ktv_app = angular.module('ktv-form', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});
ktv_app.controller('ktv-ctl', ['$scope', '$http', 'ktv_factory', function($scope, $http, ktv_factory) {
    // get districts
    $scope.provinces = (typeof provinces !== 'undefined') ? provinces : [];
    $scope.districts = (typeof districts !== 'undefined') ? districts : [];
    $scope.get_districts = function() {
        var province_id = $('#province').val();
        // ktv_factory.get_districts($scope.province, url).then(function(data) {
        ktv_factory.get_districts(province_id, url).then(function(data) {
            if (data) {
                $scope.districts = data;
            }
        });
    };
}]);

// Factory ajax
ktv_app.factory('ktv_factory', ['$http', function($http) {
    return {
        get_districts: function(province_id, url) {
            return $http({
                url: url,
                method: "GET",
                responseType: 'text',
                params: {
                    province_id: province_id,
                }
            }).then(function(response) {
                return response.data.data;
            })
        },
    };
}]);

$(document).ready(function() {
    $(document).on('click', '.ktv-delete', function(e) {
        if (!confirm('Bạn chắc chắn muốn xóa?')) return;
        e.preventDefault();
        $('#ktv-delete-form').attr('action', '/admin/ktvs/' + $(this).attr('data-id'));
        $('#ktv-delete-form').submit();
    });
});