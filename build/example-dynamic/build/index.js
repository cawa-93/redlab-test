/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./src/example-dynamic/build/index.js ***!
  \********************************************/
!function () {
  "use strict";

  var e,
    n = {
      144: function () {
        var e = window.wp.blocks,
          n = window.wp.element,
          r = window.wp.i18n,
          o = window.wp.blockEditor,
          t = JSON.parse('{"u2":"create-block/example-dynamic"}');
        (0, e.registerBlockType)(t.u2, {
          edit: function () {
            return (0, n.createElement)("p", {
              ...(0, o.useBlockProps)()
            }, (0, r.__)("Example Dynamic – hello from the editor!", "example-dynamic"));
          }
        });
      }
    },
    r = {};
  function o(e) {
    var t = r[e];
    if (void 0 !== t) return t.exports;
    var i = r[e] = {
      exports: {}
    };
    return n[e](i, i.exports, o), i.exports;
  }
  o.m = n, e = [], o.O = function (n, r, t, i) {
    if (!r) {
      var c = 1 / 0;
      for (f = 0; f < e.length; f++) {
        r = e[f][0], t = e[f][1], i = e[f][2];
        for (var u = !0, a = 0; a < r.length; a++) (!1 & i || c >= i) && Object.keys(o.O).every(function (e) {
          return o.O[e](r[a]);
        }) ? r.splice(a--, 1) : (u = !1, i < c && (c = i));
        if (u) {
          e.splice(f--, 1);
          var l = t();
          void 0 !== l && (n = l);
        }
      }
      return n;
    }
    i = i || 0;
    for (var f = e.length; f > 0 && e[f - 1][2] > i; f--) e[f] = e[f - 1];
    e[f] = [r, t, i];
  }, o.o = function (e, n) {
    return Object.prototype.hasOwnProperty.call(e, n);
  }, function () {
    var e = {
      826: 0,
      431: 0
    };
    o.O.j = function (n) {
      return 0 === e[n];
    };
    var n = function (n, r) {
        var t,
          i,
          c = r[0],
          u = r[1],
          a = r[2],
          l = 0;
        if (c.some(function (n) {
          return 0 !== e[n];
        })) {
          for (t in u) o.o(u, t) && (o.m[t] = u[t]);
          if (a) var f = a(o);
        }
        for (n && n(r); l < c.length; l++) i = c[l], o.o(e, i) && e[i] && e[i][0](), e[i] = 0;
        return o.O(f);
      },
      r = self.webpackChunkexample_dynamic = self.webpackChunkexample_dynamic || [];
    r.forEach(n.bind(null, 0)), r.push = n.bind(null, r.push.bind(r));
  }();
  var t = o.O(void 0, [431], function () {
    return o(144);
  });
  t = o.O(t);
}();
/******/ })()
;
//# sourceMappingURL=index.js.map