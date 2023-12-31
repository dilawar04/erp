"use strict";
var KTLoginGeneral = function () {
    var t = $("#kt_login"), i = function (t, i, e) {
        var n = $('<div class="kt-alert kt-alert--outline alert alert-' + i + ' alert-dismissible" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\t\t\t<span></span>\t\t</div>');
        t.find(".alert").remove(), n.prependTo(t), KTUtil.animateClass(n[0], "fadeIn animated"), n.find("span").html(e)
    }, e = function () {
        t.removeClass("kt-login--forgot"), t.removeClass("kt-login--signup"), t.addClass("kt-login--signin"), KTUtil.animateClass(t.find(".kt-login__signin")[0], "flipInX animated")
    }, n = function () {
        $("#kt_login_forgot").click(function (i) {
            i.preventDefault(), t.removeClass("kt-login--signin"), t.removeClass("kt-login--signup"), t.addClass("kt-login--forgot"), KTUtil.animateClass(t.find(".kt-login__forgot")[0], "flipInX animated")
        }), $("#kt_login_forgot_cancel").click(function (t) {
            t.preventDefault(), e()
        }), $("#kt_login_signup").click(function (i) {
            i.preventDefault(), t.removeClass("kt-login--forgot"), t.removeClass("kt-login--signin"), t.addClass("kt-login--signup"), KTUtil.animateClass(t.find(".kt-login__signup")[0], "flipInX animated")
        }), $("#kt_login_signup_cancel").click(function (t) {
            t.preventDefault(), e()
        })
    };
    return {
        init: function () {
            n(), $("#kt_login_signin_submit").click(function (t) {
                t.preventDefault();
                var e = $(this), n = $(this).closest("form");
                n.validate({
                    rules: {
                        username: {required: !0},
                        password: {required: !0, minlength:3, maxlength:16}
                    }
                }), n.valid() && (e.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0), n.ajaxSubmit({
                    url: n.attr('action'),
                    success: function (t, s, r, a) {
                        setTimeout(function () {
                            e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light")
                                .attr("disabled", !1)
                                , i(n, (!t.status ? 'danger' : 'success'), t.message);

                                if(t.status) {
                                    window.location = t.redirect;
                                }
                        }, 2e3)
                    }
                }))
            }), $("#kt_login_signup_submit").click(function (n) {
                n.preventDefault();
                var s = $(this), r = $(this).closest("form");
                r.validate({
                    rules: {
                        fullname: {required: !0},
                        email: {required: !0, email: !0},
                        password: {required: !0},
                        rpassword: {required: !0},
                        agree: {required: !0}
                    }
                }), r.valid() && (s.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0), r.ajaxSubmit({
                    url: n.attr('action'),
                    success: function (n, a, l, o) {
                        setTimeout(function () {
                            s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), r.clearForm(), r.validate().resetForm(), e();
                            var n = t.find(".kt-login__signin form");
                            n.clearForm(), n.validate().resetForm(), i(n, "success", "Thank you. To complete your registration please check your email.")
                        }, 2e3)
                    }
                }))
            }), $("#kt_login_forgot_submit").click(function (n) {
                n.preventDefault();
                var s = $(this), r = $(this).closest("form");
                r.validate({
                    rules: {
                        email: {
                            required: !0,
                            email: !0
                        }
                    }
                }), r.valid() && (s.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0), r.ajaxSubmit({
                    url: n.attr('action'),
                    success: function (n, a, l, o) {
                        setTimeout(function () {
                            s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), r.clearForm(), r.validate().resetForm(), e();
                            var n = t.find(".kt-login__signin form");
                            n.clearForm(), n.validate().resetForm(), i(n, "success", "Cool! Password recovery instruction has been sent to your email.")
                        }, 2e3)
                    }
                }))
            })
        }
    }
}();
jQuery(document).ready(function () {
    KTLoginGeneral.init()
});
