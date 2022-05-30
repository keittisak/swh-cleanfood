/*!
 * AdminLTE v3.0.0-rc.1 (https://adminlte.io)
 * Copyright 2014-2019 Colorlib <http://colorlib.com>
 * Licensed under MIT (https://github.com/almasaeed2010/AdminLTE/blob/master/LICENSE)
 */
!function(e, t) {
  "object" == typeof exports && "undefined" != typeof module ? t(exports) : "function" == typeof define && define.amd ? define(["exports"], t) : t((e = e || self).adminlte = {})
}(this, function(e) {
  "use strict";
  var t = function(e) {
      var t = "ControlSidebar"
        , n = "lte.controlsidebar"
        , i = e.fn[t]
        , s = {
          COLLAPSED: "collapsed.lte.controlsidebar",
          EXPANDED: "expanded.lte.controlsidebar"
      }
        , o = ".control-sidebar"
        , a = ".control-sidebar-content"
        , r = '[data-widget="control-sidebar"]'
        , l = ".main-header"
        , c = ".main-footer"
        , h = "control-sidebar-animate"
        , d = "control-sidebar-open"
        , u = "control-sidebar-slide-open"
        , f = "layout-fixed"
        , g = "layout-navbar-fixed"
        , _ = "layout-sm-navbar-fixed"
        , p = "layout-md-navbar-fixed"
        , m = "layout-lg-navbar-fixed"
        , v = "layout-xl-navbar-fixed"
        , C = "layout-footer-fixed"
        , y = "layout-sm-footer-fixed"
        , w = "layout-md-footer-fixed"
        , D = "layout-lg-footer-fixed"
        , A = "layout-xl-footer-fixed"
        , E = function() {
          function t(e, t) {
              this._element = e,
              this._config = t,
              this._init()
          }
          var i = t.prototype;
          return i.show = function() {
              this._config.controlsidebarSlide ? (e("html").addClass(h),
              e("body").removeClass(u).delay(300).queue(function() {
                  e(o).hide(),
                  e("html").removeClass(h),
                  e(this).dequeue()
              })) : e("body").removeClass(d);
              var t = e.Event(s.EXPANDED);
              e(this._element).trigger(t)
          }
          ,
          i.collapse = function() {
              this._config.controlsidebarSlide ? (e("html").addClass(h),
              e(o).show().delay(10).queue(function() {
                  e("body").addClass(u).delay(300).queue(function() {
                      e("html").removeClass(h),
                      e(this).dequeue()
                  }),
                  e(this).dequeue()
              })) : e("body").addClass(d);
              var t = e.Event(s.COLLAPSED);
              e(this._element).trigger(t)
          }
          ,
          i.toggle = function() {
              e("body").hasClass(d) || e("body").hasClass(u) ? this.show() : this.collapse()
          }
          ,
          i._init = function() {
              var t = this;
              this._fixHeight(),
              this._fixScrollHeight(),
              e(window).resize(function() {
                  t._fixHeight(),
                  t._fixScrollHeight()
              }),
              e(window).scroll(function() {
                  (e("body").hasClass(d) || e("body").hasClass(u)) && t._fixScrollHeight()
              })
          }
          ,
          i._fixScrollHeight = function() {
              var t = {
                  scroll: e(document).height(),
                  window: e(window).height(),
                  header: e(l).outerHeight(),
                  footer: e(c).outerHeight()
              }
                , n = Math.abs(t.window + e(window).scrollTop() - t.scroll)
                , i = e(window).scrollTop()
                , s = !1
                , r = !1;
              e("body").hasClass(f) && ((e("body").hasClass(g) || e("body").hasClass(_) || e("body").hasClass(p) || e("body").hasClass(m) || e("body").hasClass(v)) && "fixed" === e(l).css("position") && (s = !0),
              (e("body").hasClass(C) || e("body").hasClass(y) || e("body").hasClass(w) || e("body").hasClass(D) || e("body").hasClass(A)) && "fixed" === e(c).css("position") && (r = !0),
              0 === i && 0 === n ? (e(o).css("bottom", t.footer),
              e(o).css("top", t.header),
              e(o + ", " + o + " " + a).css("height", t.window - (t.header + t.footer))) : n <= t.footer ? !1 === r ? (e(o).css("bottom", t.footer - n),
              e(o + ", " + o + " " + a).css("height", t.window - (t.footer - n))) : e(o).css("bottom", t.footer) : i <= t.header ? !1 === s ? (e(o).css("top", t.header - i),
              e(o + ", " + o + " " + a).css("height", t.window - (t.header - i))) : e(o).css("top", t.header) : !1 === s ? (e(o).css("top", 0),
              e(o + ", " + o + " " + a).css("height", t.window)) : e(o).css("top", t.header))
          }
          ,
          i._fixHeight = function() {
              var t = e(window).height()
                , n = e(l).outerHeight()
                , i = e(c).outerHeight();
              if (e("body").hasClass(f)) {
                  var s = t - n;
                  (e("body").hasClass(C) || e("body").hasClass(y) || e("body").hasClass(w) || e("body").hasClass(D) || e("body").hasClass(A)) && "fixed" === e(c).css("position") && (s = t - n - i),
                  e(o + " " + a).css("height", s),
                  "undefined" != typeof e.fn.overlayScrollbars && e(o + " " + a).overlayScrollbars({
                      className: this._config.scrollbarTheme,
                      sizeAutoCapable: !0,
                      scrollbars: {
                          autoHide: this._config.scrollbarAutoHide,
                          clickScrolling: !0
                      }
                  })
              }
          }
          ,
          t._jQueryInterface = function(i) {
              return this.each(function() {
                  var s = e(this).data(n);
                  if (s || (s = new t(this,e(this).data()),
                  e(this).data(n, s)),
                  "undefined" === s[i])
                      throw new Error(i + " is not a function");
                  s[i]()
              })
          }
          ,
          t
      }();
      return e(document).on("click", r, function(t) {
          t.preventDefault(),
          E._jQueryInterface.call(e(this), "toggle")
      }),
      e.fn[t] = E._jQueryInterface,
      e.fn[t].Constructor = E,
      e.fn[t].noConflict = function() {
          return e.fn[t] = i,
          E._jQueryInterface
      }
      ,
      E
  }(jQuery)
    , n = function(e) {
      var t = "Layout"
        , n = e.fn[t]
        , i = ".main-header"
        , s = ".main-sidebar"
        , o = ".main-sidebar .sidebar"
        , a = ".content-wrapper"
        , r = ".main-footer"
        , l = "hold-transition"
        , c = "sidebar-focused"
        , h = "layout-fixed"
        , d = {
          scrollbarTheme: "os-theme-light",
          scrollbarAutoHide: "l"
      }
        , u = function() {
          function t(e, t) {
              this._config = t,
              this._element = e,
              this._init()
          }
          var n = t.prototype;
          return n.fixLayoutHeight = function() {
              var t = {
                  window: e(window).height(),
                  header: e(i).outerHeight(),
                  footer: e(r).outerHeight(),
                  sidebar: e(o).height()
              }
                , n = this._max(t);
              e("body").hasClass(h) ? (e(a).css("min-height", n - t.header - t.footer),
              "undefined" != typeof e.fn.overlayScrollbars && e(o).overlayScrollbars({
                  className: this._config.scrollbarTheme,
                  sizeAutoCapable: !0,
                  scrollbars: {
                      autoHide: this._config.scrollbarAutoHide,
                      clickScrolling: !0
                  }
              })) : t.window > t.sidebar ? e(a).css("min-height", t.window - t.header - t.footer) : e(a).css("min-height", t.sidebar - t.header)
          }
          ,
          n._init = function() {
              var t = this;
              e("body").removeClass(l),
              this.fixLayoutHeight(),
              e(o).on("collapsed.lte.treeview expanded.lte.treeview collapsed.lte.pushmenu expanded.lte.pushmenu", function() {
                  t.fixLayoutHeight()
              }),
              e(window).resize(function() {
                  t.fixLayoutHeight()
              }),
              e("body, html").css("height", "auto")
          }
          ,
          n._max = function(e) {
              var t = 0;
              return Object.keys(e).forEach(function(n) {
                  e[n] > t && (t = e[n])
              }),
              t
          }
          ,
          t._jQueryInterface = function(n) {
              return this.each(function() {
                  var i = e(this).data("lte.layout")
                    , s = e.extend({}, d, e(this).data());
                  i || (i = new t(e(this),s),
                  e(this).data("lte.layout", i)),
                  "init" === n && i[n]()
              })
          }
          ,
          t
      }();
      return e(window).on("load", function() {
          u._jQueryInterface.call(e("body"))
      }),
      e(o + " a").on("focusin", function() {
          e(s).addClass(c)
      }),
      e(o + " a").on("focusout", function() {
          e(s).removeClass(c)
      }),
      e.fn[t] = u._jQueryInterface,
      e.fn[t].Constructor = u,
      e.fn[t].noConflict = function() {
          return e.fn[t] = n,
          u._jQueryInterface
      }
      ,
      u
  }(jQuery)
    , i = function(e) {
      var t = "PushMenu"
        , n = ".lte.pushmenu"
        , i = e.fn[t]
        , s = {
          COLLAPSED: "collapsed" + n,
          SHOWN: "shown" + n
      }
        , o = {
          autoCollapseSize: !1,
          screenCollapseSize: 768,
          enableRemember: !1,
          noTransitionAfterReload: !0
      }
        , a = {
          TOGGLE_BUTTON: '[data-widget="pushmenu"]',
          SIDEBAR_MINI: ".sidebar-mini",
          SIDEBAR_COLLAPSED: ".sidebar-collapse",
          BODY: "body",
          OVERLAY: "#sidebar-overlay",
          WRAPPER: ".wrapper"
      }
        , r = "sidebar-collapse"
        , l = "sidebar-open"
        , c = function() {
          function t(t, n) {
              this._element = t,
              this._options = e.extend({}, o, n),
              this._init(),
              e(a.OVERLAY).length || this._addOverlay()
          }
          var i = t.prototype;
          return i.show = function() {
              e(a.BODY).addClass(l).removeClass(r),
              this._options.enableRemember && localStorage.setItem("remember" + n, l);
              var t = e.Event(s.SHOWN);
              e(this._element).trigger(t)
          }
          ,
          i.collapse = function() {
              e(a.BODY).removeClass(l).addClass(r),
              this._options.enableRemember && localStorage.setItem("remember" + n, r);
              var t = e.Event(s.COLLAPSED);
              e(this._element).trigger(t)
          }
          ,
          i.isShown = function() {
              return e(window).width() >= this._options.screenCollapseSize ? !e(a.BODY).hasClass(r) : e(a.BODY).hasClass(l)
          }
          ,
          i.toggle = function() {
              this.isShown() ? this.collapse() : this.show()
          }
          ,
          i.autoCollapse = function() {
              this._options.autoCollapseSize && (e(window).width() <= this._options.autoCollapseSize ? this.isShown() && this.toggle() : this.isShown() || this.toggle())
          }
          ,
          i.remember = function() {
              this._options.enableRemember && (localStorage.getItem("remember" + n) == r && (this._options.noTransitionAfterReload ? e("body").addClass("hold-transition").addClass(r).delay(10).queue(function() {
                  e(this).removeClass("hold-transition"),
                  e(this).dequeue()
              }) : e("body").addClass(r)))
          }
          ,
          i._init = function() {
              var t = this;
              this.remember(),
              this.autoCollapse(),
              e(window).resize(function() {
                  t.autoCollapse()
              })
          }
          ,
          i._addOverlay = function() {
              var t = this
                , n = e("<div />", {
                  id: "sidebar-overlay"
              });
              n.on("click", function() {
                  t.collapse()
              }),
              e(a.WRAPPER).append(n)
          }
          ,
          t._jQueryInterface = function(n) {
              return this.each(function() {
                  var i = e(this).data("lte.pushmenu")
                    , s = e.extend({}, o, e(this).data());
                  i || (i = new t(this,s),
                  e(this).data("lte.pushmenu", i)),
                  "toggle" === n && i[n]()
              })
          }
          ,
          t
      }();
      return e(document).on("click", a.TOGGLE_BUTTON, function(t) {
          t.preventDefault();
          var n = t.currentTarget;
          "pushmenu" !== e(n).data("widget") && (n = e(n).closest(a.TOGGLE_BUTTON)),
          c._jQueryInterface.call(e(n), "toggle")
      }),
      e(window).on("load", function() {
          c._jQueryInterface.call(e(a.TOGGLE_BUTTON))
      }),
      e.fn[t] = c._jQueryInterface,
      e.fn[t].Constructor = c,
      e.fn[t].noConflict = function() {
          return e.fn[t] = i,
          c._jQueryInterface
      }
      ,
      c
  }(jQuery)
    , s = function(e) {
      var t = "Treeview"
        , n = e.fn[t]
        , i = {
          SELECTED: "selected.lte.treeview",
          EXPANDED: "expanded.lte.treeview",
          COLLAPSED: "collapsed.lte.treeview",
          LOAD_DATA_API: "load.lte.treeview"
      }
        , s = ".nav-item"
        , o = ".nav-treeview"
        , a = ".menu-open"
        , r = '[data-widget="treeview"]'
        , l = "menu-open"
        , c = {
          trigger: r + " " + ".nav-link",
          animationSpeed: 300,
          accordion: !0
      }
        , h = function() {
          function t(e, t) {
              this._config = t,
              this._element = e
          }
          var n = t.prototype;
          return n.init = function() {
              this._setupListeners()
          }
          ,
          n.expand = function(t, n) {
              var s = this
                , r = e.Event(i.EXPANDED);
              if (this._config.accordion) {
                  var c = n.siblings(a).first()
                    , h = c.find(o).first();
                  this.collapse(h, c)
              }
              t.stop().slideDown(this._config.animationSpeed, function() {
                  n.addClass(l),
                  e(s._element).trigger(r)
              })
          }
          ,
          n.collapse = function(t, n) {
              var s = this
                , r = e.Event(i.COLLAPSED);
              t.stop().slideUp(this._config.animationSpeed, function() {
                  n.removeClass(l),
                  e(s._element).trigger(r),
                  t.find(a + " > " + o).slideUp(),
                  t.find(a).removeClass(l)
              })
          }
          ,
          n.toggle = function(t) {
              var n = e(t.currentTarget)
                , i = n.next();
              if (i.is(o)) {
                  t.preventDefault();
                  var a = n.parents(s).first();
                  a.hasClass(l) ? this.collapse(e(i), a) : this.expand(e(i), a)
              }
          }
          ,
          n._setupListeners = function() {
              var t = this;
              e(document).on("click", this._config.trigger, function(e) {
                  t.toggle(e)
              })
          }
          ,
          t._jQueryInterface = function(n) {
              return this.each(function() {
                  var i = e(this).data("lte.treeview")
                    , s = e.extend({}, c, e(this).data());
                  i || (i = new t(e(this),s),
                  e(this).data("lte.treeview", i)),
                  "init" === n && i[n]()
              })
          }
          ,
          t
      }();
      return e(window).on(i.LOAD_DATA_API, function() {
          e(r).each(function() {
              h._jQueryInterface.call(e(this), "init")
          })
      }),
      e.fn[t] = h._jQueryInterface,
      e.fn[t].Constructor = h,
      e.fn[t].noConflict = function() {
          return e.fn[t] = n,
          h._jQueryInterface
      }
      ,
      h
  }(jQuery)
    , o = function(e) {
      var t = "DirectChat"
        , n = e.fn[t]
        , i = "toggled{EVENT_KEY}"
        , s = '[data-widget="chat-pane-toggle"]'
        , o = ".direct-chat"
        , a = "direct-chat-contacts-open"
        , r = function() {
          function t(e, t) {
              this._element = e
          }
          return t.prototype.toggle = function() {
              e(this._element).parents(o).first().toggleClass(a);
              var t = e.Event(i);
              e(this._element).trigger(t)
          }
          ,
          t._jQueryInterface = function(n) {
              return this.each(function() {
                  var i = e(this).data("lte.directchat");
                  i || (i = new t(e(this)),
                  e(this).data("lte.directchat", i)),
                  i[n]()
              })
          }
          ,
          t
      }();
      return e(document).on("click", s, function(t) {
          t && t.preventDefault(),
          r._jQueryInterface.call(e(this), "toggle")
      }),
      e.fn[t] = r._jQueryInterface,
      e.fn[t].Constructor = r,
      e.fn[t].noConflict = function() {
          return e.fn[t] = n,
          r._jQueryInterface
      }
      ,
      r
  }(jQuery)
    , a = function(e) {
      var t = "TodoList"
        , n = e.fn[t]
        , i = '[data-widget="todo-list"]'
        , s = "done"
        , o = {
          onCheck: function(e) {
              return e
          },
          onUnCheck: function(e) {
              return e
          }
      }
        , a = function() {
          function t(e, t) {
              this._config = t,
              this._element = e,
              this._init()
          }
          var n = t.prototype;
          return n.toggle = function(t) {
              t.parents("li").toggleClass(s),
              e(t).prop("checked") ? this.check(t) : this.unCheck(e(t))
          }
          ,
          n.check = function(e) {
              this._config.onCheck.call(e)
          }
          ,
          n.unCheck = function(e) {
              this._config.onUnCheck.call(e)
          }
          ,
          n._init = function() {
              var t = this;
              e(i).find("input:checkbox:checked").parents("li").toggleClass(s),
              e(i).on("change", "input:checkbox", function(n) {
                  t.toggle(e(n.target))
              })
          }
          ,
          t._jQueryInterface = function(n) {
              return this.each(function() {
                  var i = e(this).data("lte.todolist")
                    , s = e.extend({}, o, e(this).data());
                  i || (i = new t(e(this),s),
                  e(this).data("lte.todolist", i)),
                  "init" === n && i[n]()
              })
          }
          ,
          t
      }();
      return e(window).on("load", function() {
          a._jQueryInterface.call(e(i))
      }),
      e.fn[t] = a._jQueryInterface,
      e.fn[t].Constructor = a,
      e.fn[t].noConflict = function() {
          return e.fn[t] = n,
          a._jQueryInterface
      }
      ,
      a
  }(jQuery)
    , r = function(e) {
      var t = "CardWidget"
        , n = ".lte.cardwidget"
        , i = e.fn[t]
        , s = {
          EXPANDED: "expanded" + n,
          COLLAPSED: "collapsed" + n,
          MAXIMIZED: "maximized" + n,
          MINIMIZED: "minimized" + n,
          REMOVED: "removed" + n
      }
        , o = {
          CARD: "card",
          COLLAPSED: "collapsed-card",
          WAS_COLLAPSED: "was-collapsed",
          MAXIMIZED: "maximized-card"
      }
        , a = {
          DATA_REMOVE: '[data-card-widget="remove"]',
          DATA_COLLAPSE: '[data-card-widget="collapse"]',
          DATA_MAXIMIZE: '[data-card-widget="maximize"]',
          CARD: "." + o.CARD,
          CARD_HEADER: ".card-header",
          CARD_BODY: ".card-body",
          CARD_FOOTER: ".card-footer",
          COLLAPSED: "." + o.COLLAPSED
      }
        , r = {
          animationSpeed: "normal",
          collapseTrigger: a.DATA_COLLAPSE,
          removeTrigger: a.DATA_REMOVE,
          maximizeTrigger: a.DATA_MAXIMIZE,
          collapseIcon: "fa-minus",
          expandIcon: "fa-plus",
          maximizeIcon: "fa-expand",
          minimizeIcon: "fa-compress"
      }
        , l = function() {
          function t(t, n) {
              this._element = t,
              this._parent = t.parents(a.CARD).first(),
              t.hasClass(o.CARD) && (this._parent = t),
              this._settings = e.extend({}, r, n)
          }
          var n = t.prototype;
          return n.collapse = function() {
              var t = this;
              this._parent.children(a.CARD_BODY + ", " + a.CARD_FOOTER).slideUp(this._settings.animationSpeed, function() {
                  t._parent.addClass(o.COLLAPSED)
              }),
              this._parent.find(this._settings.collapseTrigger + " ." + this._settings.collapseIcon).addClass(this._settings.expandIcon).removeClass(this._settings.collapseIcon);
              var n = e.Event(s.COLLAPSED);
              this._element.trigger(n, this._parent)
          }
          ,
          n.expand = function() {
              var t = this;
              this._parent.children(a.CARD_BODY + ", " + a.CARD_FOOTER).slideDown(this._settings.animationSpeed, function() {
                  t._parent.removeClass(o.COLLAPSED)
              }),
              this._parent.find(this._settings.collapseTrigger + " ." + this._settings.expandIcon).addClass(this._settings.collapseIcon).removeClass(this._settings.expandIcon);
              var n = e.Event(s.EXPANDED);
              this._element.trigger(n, this._parent)
          }
          ,
          n.remove = function() {
              this._parent.slideUp();
              var t = e.Event(s.REMOVED);
              this._element.trigger(t, this._parent)
          }
          ,
          n.toggle = function() {
              this._parent.hasClass(o.COLLAPSED) ? this.expand() : this.collapse()
          }
          ,
          n.maximize = function() {
              this._parent.find(this._settings.maximizeTrigger + " ." + this._settings.maximizeIcon).addClass(this._settings.minimizeIcon).removeClass(this._settings.maximizeIcon),
              this._parent.css({
                  height: this._parent.height(),
                  width: this._parent.width(),
                  transition: "all .15s"
              }).delay(150).queue(function() {
                  e(this).addClass(o.MAXIMIZED),
                  e("html").addClass(o.MAXIMIZED),
                  e(this).hasClass(o.COLLAPSED) && e(this).addClass(o.WAS_COLLAPSED),
                  e(this).dequeue()
              });
              var t = e.Event(s.MAXIMIZED);
              this._element.trigger(t, this._parent)
          }
          ,
          n.minimize = function() {
              this._parent.find(this._settings.maximizeTrigger + " ." + this._settings.minimizeIcon).addClass(this._settings.maximizeIcon).removeClass(this._settings.minimizeIcon),
              this._parent.css("cssText", "height:" + this._parent[0].style.height + " !important;width:" + this._parent[0].style.width + " !important; transition: all .15s;").delay(10).queue(function() {
                  e(this).removeClass(o.MAXIMIZED),
                  e("html").removeClass(o.MAXIMIZED),
                  e(this).css({
                      height: "inherit",
                      width: "inherit"
                  }),
                  e(this).hasClass(o.WAS_COLLAPSED) && e(this).removeClass(o.WAS_COLLAPSED),
                  e(this).dequeue()
              });
              var t = e.Event(s.MINIMIZED);
              this._element.trigger(t, this._parent)
          }
          ,
          n.toggleMaximize = function() {
              this._parent.hasClass(o.MAXIMIZED) ? this.minimize() : this.maximize()
          }
          ,
          n._init = function(t) {
              var n = this;
              this._parent = t,
              e(this).find(this._settings.collapseTrigger).click(function() {
                  n.toggle()
              }),
              e(this).find(this._settings.maximizeTrigger).click(function() {
                  n.toggleMaximize()
              }),
              e(this).find(this._settings.removeTrigger).click(function() {
                  n.remove()
              })
          }
          ,
          t._jQueryInterface = function(n) {
              var i = e(this).data("lte.cardwidget");
              i || (i = new t(e(this),i),
              e(this).data("lte.cardwidget", "string" == typeof n ? i : n)),
              "string" == typeof n && n.match(/collapse|expand|remove|toggle|maximize|minimize|toggleMaximize/) ? i[n]() : "object" == typeof n && i._init(e(this))
          }
          ,
          t
      }();
      return e(document).on("click", a.DATA_COLLAPSE, function(t) {
          t && t.preventDefault(),
          l._jQueryInterface.call(e(this), "toggle")
      }),
      e(document).on("click", a.DATA_REMOVE, function(t) {
          t && t.preventDefault(),
          l._jQueryInterface.call(e(this), "remove")
      }),
      e(document).on("click", a.DATA_MAXIMIZE, function(t) {
          t && t.preventDefault(),
          l._jQueryInterface.call(e(this), "toggleMaximize")
      }),
      e.fn[t] = l._jQueryInterface,
      e.fn[t].Constructor = l,
      e.fn[t].noConflict = function() {
          return e.fn[t] = i,
          l._jQueryInterface
      }
      ,
      l
  }(jQuery)
    , l = function(e) {
      var t = "CardRefresh"
        , n = e.fn[t]
        , i = {
          LOADED: "loaded.lte.cardrefresh",
          OVERLAY_ADDED: "overlay.added.lte.cardrefresh",
          OVERLAY_REMOVED: "overlay.removed.lte.cardrefresh"
      }
        , s = {
          CARD: "card"
      }
        , o = {
          CARD: "." + s.CARD,
          DATA_REFRESH: '[data-card-widget="card-refresh"]'
      }
        , a = {
          source: "",
          sourceSelector: "",
          params: {},
          trigger: o.DATA_REFRESH,
          content: ".card-body",
          loadInContent: !0,
          loadOnInit: !0,
          responseType: "",
          overlayTemplate: '<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>',
          onLoadStart: function() {},
          onLoadDone: function(e) {
              return e
          }
      }
        , r = function() {
          function t(t, n) {
              if (this._element = t,
              this._parent = t.parents(o.CARD).first(),
              this._settings = e.extend({}, a, n),
              this._overlay = e(this._settings.overlayTemplate),
              t.hasClass(s.CARD) && (this._parent = t),
              "" === this._settings.source)
                  throw new Error("Source url was not defined. Please specify a url in your CardRefresh source option.");
              this._init(),
              this._settings.loadOnInit && this.load()
          }
          var n = t.prototype;
          return n.load = function() {
              this._addOverlay(),
              this._settings.onLoadStart.call(e(this)),
              e.get(this._settings.source, this._settings.params, function(t) {
                  this._settings.loadInContent && ("" != this._settings.sourceSelector && (t = e(t).find(this._settings.sourceSelector).html()),
                  this._parent.find(this._settings.content).html(t)),
                  this._settings.onLoadDone.call(e(this), t),
                  this._removeOverlay()
              }
              .bind(this), "" !== this._settings.responseType && this._settings.responseType);
              var t = e.Event(i.LOADED);
              e(this._element).trigger(t)
          }
          ,
          n._addOverlay = function() {
              this._parent.append(this._overlay);
              var t = e.Event(i.OVERLAY_ADDED);
              e(this._element).trigger(t)
          }
          ,
          n._removeOverlay = function() {
              this._parent.find(this._overlay).remove();
              var t = e.Event(i.OVERLAY_REMOVED);
              e(this._element).trigger(t)
          }
          ,
          n._init = function(t) {
              var n = this;
              e(this).find(this._settings.trigger).on("click", function() {
                  n.load()
              })
          }
          ,
          t._jQueryInterface = function(n) {
              var i = e(this).data("lte.cardrefresh")
                , s = e(this).data();
              i || (i = new t(e(this),s),
              e(this).data("lte.cardrefresh", "string" == typeof n ? i : n)),
              "string" == typeof n && n.match(/load/) ? i[n]() : "object" == typeof n && i._init(e(this))
          }
          ,
          t
      }();
      return e(document).on("click", o.DATA_REFRESH, function(t) {
          t && t.preventDefault(),
          r._jQueryInterface.call(e(this), "load")
      }),
      e.fn[t] = r._jQueryInterface,
      e.fn[t].Constructor = r,
      e.fn[t].noConflict = function() {
          return e.fn[t] = n,
          r._jQueryInterface
      }
      ,
      r
  }(jQuery)
    , c = function(e) {
      var t = "Dropdown"
        , n = e.fn[t]
        , i = "ul.dropdown-menu"
        , s = '[data-toggle="dropdown"]'
        , o = {}
        , a = function() {
          function t(e, t) {
              this._config = t,
              this._element = e
          }
          return t.prototype.toggleSubmenu = function() {
              this._element.siblings().show().toggleClass("show"),
              this._element.next().hasClass("show") || this._element.parents(".dropdown-menu").first().find(".show").removeClass("show").hide(),
              this._element.parents("li.nav-item.dropdown.show").on("hidden.bs.dropdown", function(t) {
                  e(".dropdown-submenu .show").removeClass("show").hide()
              })
          }
          ,
          t._jQueryInterface = function(n) {
              return this.each(function() {
                  var i = e(this).data("lte.dropdown")
                    , s = e.extend({}, o, e(this).data());
                  i || (i = new t(e(this),s),
                  e(this).data("lte.dropdown", i)),
                  "toggleSubmenu" === n && i[n]()
              })
          }
          ,
          t
      }();
      return e(i + " " + s).on("click", function(t) {
          t.preventDefault(),
          t.stopPropagation(),
          a._jQueryInterface.call(e(this), "toggleSubmenu")
      }),
      e.fn[t] = a._jQueryInterface,
      e.fn[t].Constructor = a,
      e.fn[t].noConflict = function() {
          return e.fn[t] = n,
          a._jQueryInterface
      }
      ,
      a
  }(jQuery);
  e.CardRefresh = l,
  e.CardWidget = r,
  e.ControlSidebar = t,
  e.DirectChat = o,
  e.Dropdown = c,
  e.Layout = n,
  e.PushMenu = i,
  e.TodoList = a,
  e.Treeview = s,
  Object.defineProperty(e, "__esModule", {
      value: !0
  })
});
//# sourceMappingURL=adminlte.min.js.map
