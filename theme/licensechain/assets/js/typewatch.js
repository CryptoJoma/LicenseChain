!(function (e, t) {
  "function" == typeof define && define.amd
    ? define(["jquery"], t)
    : t("object" == typeof exports ? require("jquery") : e.jQuery);
})(this, function (e) {
  "use strict";
  e.fn.typeWatch = function (t) {
    function n(e, t) {
      var n = "DIV" === e.type ? jQuery(e.el).html() : jQuery(e.el).val();
      ((n.length >= r.captureLength && n != e.text) ||
        (t && (n.length >= r.captureLength || r.allowSubmit)) ||
        (0 == n.length && e.text)) &&
        ((e.text = n), e.cb.call(e.el, n));
    }
    function i(e) {
      var t = (e.type || e.nodeName).toUpperCase();
      if (jQuery.inArray(t, r.inputTypes) >= 0) {
        var i = {
          timer: null,
          text: "DIV" === t ? jQuery(e).html() : jQuery(e).val(),
          cb: r.callback,
          el: e,
          type: t,
          wait: r.wait,
        };
        r.highlight &&
          "DIV" !== t &&
          jQuery(e).focus(function () {
            this.select();
          });
        var u = function (e) {
          var u = i.wait,
            r = !1,
            a = t;
          "undefined" != typeof e.keyCode &&
            13 == e.keyCode &&
            "TEXTAREA" !== a &&
            "DIV" !== t &&
            (console.log("OVERRIDE"), (u = 1), (r = !0));
          var c = function () {
            n(i, r);
          };
          clearTimeout(i.timer), (i.timer = setTimeout(c, u));
        };
        jQuery(e).on("keydown paste cut input", u);
      }
    }
    var u = [
        "TEXT",
        "TEXTAREA",
        "PASSWORD",
        "TEL",
        "SEARCH",
        "URL",
        "EMAIL",
        "DATETIME",
        "DATE",
        "MONTH",
        "WEEK",
        "TIME",
        "DATETIME-LOCAL",
        "NUMBER",
        "RANGE",
        "DIV",
      ],
      r = e.extend(
        {
          wait: 750,
          callback: function () {},
          highlight: !0,
          captureLength: 2,
          allowSubmit: !1,
          inputTypes: u,
        },
        t
      );
    return this.each(function () {
      i(this);
    });
  };
});
