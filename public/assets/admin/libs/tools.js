"use strict";
var KTPortletTools = {
    init: function () {
        var e;
        toastr.options.showDuration = 1e3, (e = new KTPortlet("kt_portlet_tools_1")).on("beforeCollapse", function (e) {
            setTimeout(function () {
                //toastr.info("Before collapse event fired!")
            }, 100)
        }), e.on("afterCollapse", function (e) {
            setTimeout(function () {
                //toastr.warning("Before collapse event fired!")
            }, 2e3)
        }), e.on("beforeExpand", function (e) {
            setTimeout(function () {
                //toastr.info("Before expand event fired!")
            }, 100)
        }), e.on("afterExpand", function (e) {
            setTimeout(function () {
                //toastr.warning("After expand event fired!")
            }, 2e3)
        }), e.on("beforeRemove", function (e) {
            return toastr.info("Before remove event fired!"), confirm("Are you sure to remove this portlet ?")
        }), e.on("afterRemove", function (e) {
            setTimeout(function () {
                toastr.warning("After remove event fired!")
            }, 2e3)
        }), e.on("reload", function (e) {
            toastr.info("Leload event fired!"), KTApp.block(e.getSelf(), {
                overlayColor: "#ffffff",
                type: "loader",
                state: "success",
                opacity: .3,
                size: "lg"
            }), setTimeout(function () {
                KTApp.unblock(e.getSelf())
            }, 2e3)
        }), e.on("afterFullscreenOn", function (e) {
            toastr.warning("After fullscreen on event fired!");
            var t = $(e.getBody()).find("> .kt-scroll");
            t && (t.data("original-height", t.css("height")), t.css("height", "100%"), KTUtil.scrollUpdate(t[0]))
        }), e.on("afterFullscreenOff", function (e) {
            var t;
            toastr.warning("After fullscreen off event fired!"), (t = $(e.getBody()).find("> .kt-scroll")) && ((t = $(e.getBody()).find("> .kt-scroll")).css("height", t.data("original-height")), KTUtil.scrollUpdate(t[0]))
        }), function () {
            var e = new KTPortlet("kt_portlet_tools_2");
            e.on("beforeCollapse", function (e) {
                setTimeout(function () {
                    toastr.info("Before collapse event fired!")
                }, 100)
            }), e.on("afterCollapse", function (e) {
                setTimeout(function () {
                    toastr.warning("Before collapse event fired!")
                }, 2e3)
            }), e.on("beforeExpand", function (e) {
                setTimeout(function () {
                    toastr.info("Before expand event fired!")
                }, 100)
            }), e.on("afterExpand", function (e) {
                setTimeout(function () {
                    toastr.warning("After expand event fired!")
                }, 2e3)
            }), e.on("beforeRemove", function (e) {
                return toastr.info("Before remove event fired!"), confirm("Are you sure to remove this portlet ?")
            }), e.on("afterRemove", function (e) {
                setTimeout(function () {
                    toastr.warning("After remove event fired!")
                }, 2e3)
            }), e.on("reload", function (e) {
                toastr.info("Leload event fired!"), KTApp.block(e.getSelf(), {
                    overlayColor: "#000000",
                    type: "spinner",
                    state: "brand",
                    opacity: .05,
                    size: "lg"
                }), setTimeout(function () {
                    KTApp.unblock(e.getSelf())
                }, 2e3)
            })
        }(), function () {
            var e = new KTPortlet("kt_portlet_tools_3");
            e.on("beforeCollapse", function (e) {
                setTimeout(function () {
                    toastr.info("Before collapse event fired!")
                }, 100)
            }), e.on("afterCollapse", function (e) {
                setTimeout(function () {
                    toastr.warning("Before collapse event fired!")
                }, 2e3)
            }), e.on("beforeExpand", function (e) {
                setTimeout(function () {
                    toastr.info("Before expand event fired!")
                }, 100)
            }), e.on("afterExpand", function (e) {
                setTimeout(function () {
                    toastr.warning("After expand event fired!")
                }, 2e3)
            }), e.on("beforeRemove", function (e) {
                return toastr.info("Before remove event fired!"), confirm("Are you sure to remove this portlet ?")
            }), e.on("afterRemove", function (e) {
                setTimeout(function () {
                    toastr.warning("After remove event fired!")
                }, 2e3)
            }), e.on("reload", function (e) {
                toastr.info("Leload event fired!"), KTApp.block(e.getSelf(), {
                    type: "loader",
                    state: "success",
                    message: "Please wait..."
                }), setTimeout(function () {
                    KTApp.unblock(e.getSelf())
                }, 2e3)
            }), e.on("afterFullscreenOn", function (e) {
                toastr.warning("After fullscreen on event fired!");
                var t = $(e.getBody()).find("> .kt-scroll");
                t && (t.data("original-height", t.css("height")), t.css("height", "100%"), KTUtil.scrollUpdate(t[0]))
            }), e.on("afterFullscreenOff", function (e) {
                var t;
                toastr.warning("After fullscreen off event fired!"), (t = $(e.getBody()).find("> .kt-scroll")) && ((t = $(e.getBody()).find("> .kt-scroll")).css("height", t.data("original-height")), KTUtil.scrollUpdate(t[0]))
            })
        }(), function () {
            var e = new KTPortlet("kt_portlet_tools_4");
            e.on("beforeCollapse", function (e) {
                setTimeout(function () {
                    toastr.info("Before collapse event fired!")
                }, 100)
            }), e.on("afterCollapse", function (e) {
                setTimeout(function () {
                    toastr.warning("Before collapse event fired!")
                }, 2e3)
            }), e.on("beforeExpand", function (e) {
                setTimeout(function () {
                    toastr.info("Before expand event fired!")
                }, 100)
            }), e.on("afterExpand", function (e) {
                setTimeout(function () {
                    toastr.warning("After expand event fired!")
                }, 2e3)
            }), e.on("beforeRemove", function (e) {
                return toastr.info("Before remove event fired!"), confirm("Are you sure to remove this portlet ?")
            }), e.on("afterRemove", function (e) {
                setTimeout(function () {
                    toastr.warning("After remove event fired!")
                }, 2e3)
            }), e.on("reload", function (e) {
                toastr.info("Leload event fired!"), KTApp.block(e.getSelf(), {
                    type: "loader",
                    state: "brand",
                    message: "Please wait..."
                }), setTimeout(function () {
                    KTApp.unblock(e.getSelf())
                }, 2e3)
            }), e.on("afterFullscreenOn", function (e) {
                toastr.warning("After fullscreen on event fired!");
                var t = $(e.getBody()).find("> .kt-scroll");
                t && (t.data("original-height", t.css("height")), t.css("height", "100%"), KTUtil.scrollUpdate(t[0]))
            }), e.on("afterFullscreenOff", function (e) {
                var t;
                toastr.warning("After fullscreen off event fired!"), (t = $(e.getBody()).find("> .kt-scroll")) && ((t = $(e.getBody()).find("> .kt-scroll")).css("height", t.data("original-height")), KTUtil.scrollUpdate(t[0]))
            })
        }(), function () {
            var e = new KTPortlet("kt_portlet_tools_5");
            e.on("beforeCollapse", function (e) {
                setTimeout(function () {
                    toastr.info("Before collapse event fired!")
                }, 100)
            }), e.on("afterCollapse", function (e) {
                setTimeout(function () {
                    toastr.warning("Before collapse event fired!")
                }, 2e3)
            }), e.on("beforeExpand", function (e) {
                setTimeout(function () {
                    toastr.info("Before expand event fired!")
                }, 100)
            }), e.on("afterExpand", function (e) {
                setTimeout(function () {
                    toastr.warning("After expand event fired!")
                }, 2e3)
            }), e.on("beforeRemove", function (e) {
                return toastr.info("Before remove event fired!"), confirm("Are you sure to remove this portlet ?")
            }), e.on("afterRemove", function (e) {
                setTimeout(function () {
                    toastr.warning("After remove event fired!")
                }, 2e3)
            }), e.on("reload", function (e) {
                toastr.info("Leload event fired!"), KTApp.block(e.getSelf(), {
                    type: "loader",
                    state: "brand",
                    message: "Please wait..."
                }), setTimeout(function () {
                    KTApp.unblock(e.getSelf())
                }, 2e3)
            }), e.on("afterFullscreenOn", function (e) {
                toastr.info("After fullscreen on event fired!")
            }), e.on("afterFullscreenOff", function (e) {
                toastr.warning("After fullscreen off event fired!")
            })
        }(), function () {
            var e = new KTPortlet("kt_portlet_tools_6");
            e.on("beforeCollapse", function (e) {
                setTimeout(function () {
                    toastr.info("Before collapse event fired!")
                }, 100)
            }), e.on("afterCollapse", function (e) {
                setTimeout(function () {
                    toastr.warning("Before collapse event fired!")
                }, 2e3)
            }), e.on("beforeExpand", function (e) {
                setTimeout(function () {
                    toastr.info("Before expand event fired!")
                }, 100)
            }), e.on("afterExpand", function (e) {
                setTimeout(function () {
                    toastr.warning("After expand event fired!")
                }, 2e3)
            }), e.on("beforeRemove", function (e) {
                return toastr.info("Before remove event fired!"), confirm("Are you sure to remove this portlet ?")
            }), e.on("afterRemove", function (e) {
                setTimeout(function () {
                    toastr.warning("After remove event fired!")
                }, 2e3)
            }), e.on("reload", function (e) {
                toastr.info("Leload event fired!"), KTApp.block(e.getSelf(), {
                    type: "loader",
                    state: "brand",
                    message: "Please wait..."
                }), setTimeout(function () {
                    KTApp.unblock(e.getSelf())
                }, 2e3)
            }), e.on("afterFullscreenOn", function (e) {
                toastr.info("After fullscreen on event fired!")
            }), e.on("afterFullscreenOff", function (e) {
                toastr.warning("After fullscreen off event fired!")
            })
        }()
    }
};
jQuery(document).ready(function () {
    KTPortletTools.init()
});