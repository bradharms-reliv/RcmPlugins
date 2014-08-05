/**
 * Created by idavis on 7/2/14.
 */
angular.module('rcmLocales', ['RcmHtmlEditor'])
    .controller('rcmTranslations', ['$scope', '$log', '$http', 'rcmHtmlEditorState',
        function ($scope, $log, $http, rcmHtmlEditorState) {
            var self = this;
            self.url = {
                locales: '/rcmi18n/locales'
            };
            $scope.locales = [];
            $scope.loading = false;//loadin ng-show set to false
            $scope.messageQuery = '';
            $scope.rcmHtmlEditorState = rcmHtmlEditorState;
            self.getLocales = function () {
                $scope.loading = true;//loadin ng-show set to true when getLocales is called

                $http({method: 'GET', url: self.url.locales}).//method get to get all locales
                    success(function (data) {
                        $scope.locales = data.locales;
                        $scope.selectedLocale = data['currentSiteLocale'];
                        $scope.loading = false;
                        $scope.OpenLocale();
                        // this callback will be called asynchronously
                        // when the response is available
                    }).
                    error(function () {
                        $scope.loading = false;
                        // called asynchronously if an error occurs
                        // or server returns response with an error status.
                    });

            };


            self.getLocales();
            $scope.selectedLocale = null;
            $scope.messages = [];
            $scope.translations = false;
            $scope.OpenLocale = function () {
                $scope.loading = true;//loadin ng-show set to true when ng change OpenLocale() is called
                var locale = $scope.selectedLocale;
                if (locale) {
                    $scope.loading = true;
                    $http({
                        method: 'GET',//method get to get selected locale
                        url: '/rcmi18n/messages/'
                            + encodeURIComponent($scope.selectedLocale)
                    }).
                        success(function (data) {
                            //adding id to match up keys
                            angular.forEach(data, function (value, key) {
                                    value.id = 'trans' + key;
                                }
                            );
                            $scope.messages = data;
                            $scope.loading = false;
                        }

                    ).
                        error(function () {
                            alert('Couldn\'t load messages!');
                            $scope.loading = false;
                            // called asynchronously if an error occurs
                            // or server returns response with an error status.
                        });

                }
            };

            $scope.saveText = function (message) {

                $http({
                    method: 'PUT',//method put to update selected locale
                    url: '/rcmi18n/messages/'
                        + encodeURIComponent($scope.selectedLocale)
                        + '/' + encodeURIComponent(message['defaultText']),
                    data: message

                }).
                    success(function () {
                        message.dirty = false;
                    }
                ).
                    error(function () {
                        alert('Couldn\'t save!');
                        // called asynchronously if an error occurs
                        // or server returns response with an error status.
                    });


            }

        }


    ])
    .filter('filter', function () { //search for text and Default text

        var compareStr = function (stra, strb) {
            stra = ("" + stra).toLowerCase();
            strb = ("" + strb).toLowerCase();

            return stra.indexOf(strb) !== -1;
        };

        return function (input, query) {
            if (!query) {
                return input
            }
            var result = [];
            angular.forEach(input, function (message) {
                if (compareStr(message['defaultText'], query) || compareStr(message.text, query)) {
                    result.push(message);
                }
            });

            return result;
        };
    });
rcm.addAngularModule('rcmLocales'/*, {files: ['/modules/rcm-i18n/rcmTranslationsCtrl.js']}*/);
//angular.element(document).ready(
//    function () {
//        angular.bootstrap(
//            document.querySelectorAll('[ng-controller=rcmTranslations]'),
//            ['rcmLocales']
//        );
//    }
//);
