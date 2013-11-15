/**
 *  The following code is needed for every use of angular JS (with modification using variables specific to plug-in).
 *  Because of the following declaration, the directive 'ng-app' is NOT needed in the view
 */

angular.element(document).ready(function () {
    $.each($('[ng-controller=BrightcoveCtrl]'), function (key, element) {
        angular.bootstrap(element, ['brightcovePlayer']);
    });
});

/**
 * Angular JS controller for this plugin
 * @param $scope
 * @constructor
 */
var brightcovePlayer = angular.module('brightcovePlayer', []);

brightcovePlayer.controller('BrightcoveCtrl', function BrightcoveCtrl($scope) {

    $.brightcove.find_all_videos().done(function (data) {
        //Do something with the API
        $scope.videos = data.items;
        $scope.selectedVideos = $scope.videos[0];
        $scope.$apply();
    });
    $.brightcove.find_all_playlists(false).done(function (data) {
        //Do something with the API
        $scope.playlists = data.items;
        $scope.selectedPlaylists = $scope.playlists[0];
        $scope.$apply();
    });
    $scope.items = [
        { id: 0, name: 'single embed' },
        { id: 1, name: 'multiple video player' },
    ];
});
$(function () {
$('#brightcoveObject').html('<object id="myExperience2110662112001" class="BrightcoveExperience"><param name="bgcolor" value="#FFFFFF" /><param name="width" value="400" /><param name="height" value="225" /><param name="playerID" value="2660464886001" /><param name="playerKey" value="AQ~~,AAABWA8lTok~,NLWj-wltGTwPRfYtwg9pVEh-A2jBVrQE" /><param name="isVid" value="true" /><param name="isUI" value="true" /> <param name="dynamicStreaming" value="true" /><param name="@videoPlayer" value="2110662112001" /></object>');
});