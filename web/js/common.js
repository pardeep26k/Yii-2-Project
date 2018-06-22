'use strict';
var Common = {
    init: function() {
        $('#searchSubmitID').on('click', function(){
                if($('#searchRegNo').val().trim() != ''){
                        $('#searchRegNumber').submit();
                }
        });

        $('button').on('click', function(){
           if($(this).attr('type')=='reset'){
                 var formID = $(this).parents("form:first").attr('id');
                 $('input, select', $('#'+formID)).each(function() {                        
                         Common.removeErrorParams($(this));
                 });
           }
        });

        $(document).ready(function(){
           (APPSIDEBARSTATUS == '1')?$('#app').addClass( 'app-sidebar-closed' ):$('#app').removeClass( 'app-sidebar-closed' );
           $('.sidebar-toggler').on('click',function(){
                var toggle_status = ($('#app').hasClass( 'app-sidebar-closed'))?1:0;
                var params = "name=sidebar_toggler&toggle_status="+toggle_status;
                var url = "commonajax";
                $.post(url, params, function (jsondata) {
                    return true;
                });
           });
        });

    },
    toastr: function() {
        toastr.options = {
            "closeButton": true,
            "positionClass": "toast-bottom-right",
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "10000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    },
    addErrorParams: function(selector) {
        $(selector).addClass('inputError');
        $(selector).parent().addClass('has-error');
        $(selector).parent().children('label').addClass('control-label');
    },
    removeErrorParams: function(selector) {
        $(selector).removeClass('inputError');
        $(selector).parent().removeClass('has-error');
        $(selector).parent().children('label').removeClass('control-label');
    },
    
    downloadPopUp : function(filePath){
        location.href = filePath;
    },
    showOverlay: function(){
        $('.pageoverlay').show();
    },
    hideOverlay: function(){
        $('.pageoverlay').hide();
    }
};

var CommonValidation = {
    validate: function(selector, checkFlag) {
        var status = true;
        if ((typeof checkFlag == 'undefined') || checkFlag == '' || checkFlag == '0') {
            $('input, select, textarea', $(selector)).each(function() {
                if (($.trim($(this).val()) == '') && (!$(this).hasClass('required'))) {
                    Common.addErrorParams($(this));
                    status = false;
                    //alert($(this).attr('name'));
                }
                else {
                    Common.removeErrorParams($(this));
                }
            });
        } else {
            $('input, select, textarea', $(selector)).each(function() {
                if($(this).attr("type") == 'checkbox' && $(this).hasClass('required') ){
                    var checkboxStatus = false;
                    var checkThis = $(this);
                    $("input[name='"+checkThis.attr('name')+"']").each( function () {
                        if ($(this).is(':checked')) {
                            checkboxStatus = true;                            
                        }
                    });
                    if(checkboxStatus === false){
                        $("input[name='"+checkThis.attr('name')+"']").each( function () {
                            $(this).addClass('inputError');
                            $(this).parent().addClass('has-error');
                        });
                        status = false;
                    }
                    else {
                        $("input[name='"+checkThis.attr('name')+"']").each( function () {
                            $(this).removeClass('inputError');
                            $(this).parent().removeClass('has-error');
                        });
                    }
 
                }else if($(this).attr("type") == 'radio' && $(this).hasClass('required') ){
                    var radioStatus = false;
                    var checkThis = $(this);
                    $("input[name='"+checkThis.attr('name')+"']").each( function () {
                        if ($(this).is(':checked')) {
                            radioStatus = true;                            
                        }
                    });
                    if(radioStatus === false){
                        $("input[name='"+checkThis.attr('name')+"']").each( function () {
                            $(this).addClass('inputError');
                            $(this).parent().addClass('has-error');
                        });
                        status = false;
                    }
                    else {
                        $("input[name='"+checkThis.attr('name')+"']").each( function () {
                            $(this).removeClass('inputError');
                            $(this).parent().removeClass('has-error');
                        });
                    }
 
                }
                else 
                {
                    if (($.trim($(this).val()) == '') && ($(this).hasClass('required'))) {
                        Common.addErrorParams($(this));
                        status = false;
                        //alert($(this).attr('name'));
                    }
                    else {
                        Common.removeErrorParams($(this));
                    }
                }
            });
        }


        return status;
    },
    validateEmail: function(selector) {
        var emailStatus = true;
        // testing regular expression
        var emailVal = $.trim($(selector).val());
        var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;

        if (emailVal !== '') {
            // if it's valid email
            if (filter.test(emailVal)) {
                Common.removeErrorParams(selector);
            } else {;
                Common.addErrorParams(selector);
                emailStatus = false;
            }
        }
        return emailStatus;
    },
    
    
    validateMultipleCommaSepartedEmails: function(selector) {
        var emailStatus = true;
        // testing regular expression
        var Val = $.trim($(selector).val());
        var emailVal = Val.replace(/(^,)|(,$)/g, "")
        var filter = /^\s*((\s*[a-zA-Z0-9\._%-]+@[a-zA-Z0-9\.-]+\.[a-zA-Z]{2,4}\s*[,]{1}\s*){1,100}?)?([a-zA-Z0-9\._%-]+@[a-zA-Z0-9\.-]+\.[a-zA-Z]{2,4})\s*$/;

        if (emailVal !== '') {
            // if it's valid email
            if (filter.test(emailVal)) {
                Common.removeErrorParams(selector);
            } else {
                Common.addErrorParams(selector);
                emailStatus = false;
            }
        }
        return emailStatus;
    },
    
    validateMobile: function(selector) {

        var mobileStatus = true;
        // testing regular expression
        var mobileVal = $.trim($(selector).val());
        var filter = /^[7-9][0-9]{9}$/;

        if (mobileVal !== '') {
            // if it's valid mobile
            if (filter.test(mobileVal)) {
                Common.removeErrorParams(selector);
            } else {
                Common.addErrorParams(selector);
                mobileStatus = false;
            }
        }
        return mobileStatus;
    },
    validateTel: function(selector) {

        var telStatus = true;
        // testing regular expression
        var telVal = $.trim($(selector).val());
        var filter = /^[0-9]{0,15}$/;

        if (telVal !== '') {
            // if it's valid mobile
            if (filter.test(telVal)) {
                Common.removeErrorParams(selector);
            } else {
                Common.addErrorParams(selector);
                telStatus = false;
            }
        }
        return telStatus;
    },
    validateName: function(selector) {
        var nameStatus = true;
        // testing regular expression
        var nameVal = $.trim($(selector).val());
        var filter = /^([A-Za-z]{3,30})+$/;

        if (nameVal !== '') {
            // if it's valid name
            if (filter.test(nameVal)) {
                Common.removeErrorParams(selector);
            } else {
                Common.addErrorParams(selector);
                nameStatus = false;
            }
        }
        return nameStatus;
    },
    validateAlphanumeric: function(selector) {

        var alphanumeric = true;
        // testing regular expression
        var alphaNumericVal = $.trim($(selector).val());
        var filter = /^[(a-z)(A-Z)(0-9)]+$/;

        if (alphaNumericVal !== '') {
            // if it's valid alphanumeric
            if (filter.test(alphaNumericVal)) {
                Common.removeErrorParams(selector);
            } else {
                Common.addErrorParams(selector);
                alphanumeric = false;
            }
        }
        return alphanumeric;
    },
    validateNumeric: function(selector) {

        var numericStatus = true;
        // testing regular expression
        var numericVal = $.trim($(selector).val());
        var filter = /[0-9]$/;

        if (numericVal !== '') {
            // if it's valid numeric
            if (filter.test(numericVal)) {
                Common.removeErrorParams(selector);
            } else {
                Common.addErrorParams(selector);
                numericStatus = false;
            }
        }
        return numericStatus;
    },
    
    validateUsername : function(selector){
        
        var usernameStatus = true;
        // testing regular expression
        var usernameVal = $.trim($(selector).val());
        var filter = /^[a-zA-Z0-9_.]+$/;

        if (usernameVal !== '') {
            // if it's valid username
            if (filter.test(usernameVal)) {
                Common.removeErrorParams(selector);
            } else {
                Common.addErrorParams(selector);
                usernameStatus = false;
            }
        }
        return usernameStatus;
    },
    
    validateEmailSub : function(selector){
      var emailSub    = true;
      var emailSubVal = $.trim($(selector).val());  
      var filter      = /^[a-zA-Z0-9-\s]+$/; 
      if (emailSubVal !== '') {
            // if it's valid username
            if (filter.test(emailSubVal)) {
                Common.removeErrorParams(selector);
            } else {
                Common.addErrorParams(selector);
                emailSub = false;
            }
        }
        return emailSub;
    },
    
    
    validateSpace : function(selector){
       
      var nameStatus    = true;
      var name          = $.trim($(selector).val());  
      var filter        = /^[a-zA-Z ]*$/; 
      if (name !== '') {
            // if it's valid username
            if (filter.test(name)) {
                Common.removeErrorParams(selector);
            } else {
                Common.addErrorParams(selector);
                nameStatus = false;
            }
        }
        return nameStatus;
    }
};
