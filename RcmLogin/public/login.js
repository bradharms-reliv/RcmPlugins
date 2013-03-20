var RcmLoginBoxJs = function(loginMgr, sessionId) {

    var me = this;

    me.loginMgr = loginMgr;
    me.sessionId = sessionId;

    me.init = function() {

        me.loginMgr.setSuccessCallback(me.rcmLoginBoxSuccessFunction);
        me.loginMgr.setMissingCallback(me.rcmLoginBoxMissingItemsCallback);
        me.loginMgr.setInvalidCallback(me.rcmLoginBoxInvalidLoginCallback);
        me.loginMgr.setSystemFailureCallback(me.rcmLoginBoxSystemFailureCallback);

        $(function(){
            $("#rcmLoginBoxLoginForm").submit(function(event){
                me.submitBind();
                event.preventDefault();
            });

            $("#rcmLoginBoxLoginSubmit").click(function(event){
                me.submitBind();
                event.preventDefault();
            });

            if (typeof(rcm) === 'object') {
                var urlParms = rcm.getUrlParams();

                if (urlParms.rcmLoginError) {
                    me.loginMgr.processError(urlParms.rcmLoginError);
                }
            }
        });
    };

    me.submitBind = function() {
        me.loginMgr.doLogin($("#rcmLoginBoxUserName").val(), $("#rcmLoginBoxPassword").val());
    };

    me.rcmLoginBoxSuccessFunction = function(data) {

        var redirectUrl = '';

        if (typeof(rcm) === 'object') {
            var urlParms = rcm.getUrlParams();

            if (urlParms.redirect) {
                redirectUrl = urlParms.redirect
            }
        } else {
            redirectUrl ='https://portal.local.reliv.com';
        }

        var redirectWithSession = rcm.updateURLParameter(redirectUrl,'sess_id', me.sessionId);

        window.location.replace(redirectWithSession);
    };

    me.rcmLoginBoxInvalidLoginCallback = function(data) {
        console.log('invalid called');
    };

    me.rcmLoginBoxMissingItemsCallback = function(data) {
        console.log('missing called');
    };

    me.rcmLoginBoxSystemFailureCallback = function(data) {
        console.log('system failure called');
    }
};

