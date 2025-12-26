/**
 * @author Marcel Liebgott <marcel@mliebgott.de>
 * @version 1.00
 *
 * this jQuery plugin manage defined kinds of notification
 * you could show this jQuery Growl Notification by default in a queue or in top of the viewport with full width
 */


(function () {
    "use strict";
    var $, Animation, Growl,
            __bind = function (fn, me) {
                return function () {
                    return fn.apply(me, arguments);
                };
            };

    var storageName = "de.mliebgott.notification";

    $ = jQuery;

    Animation = (function () {
        function Animation() {
        }

        Animation.transitions = {
            "webkitTransition": "webkitTransitionEnd",
            "mozTransition": "mozTransitionEnd",
            "oTransition": "oTransitionEnd",
            "transition": "transitionend"
        };

        Animation.transition = function ($el) {
            var el, result, type, _ref;
            el = $el[0];
            _ref = this.transitions;

            for (type in _ref) {
                result = _ref[type];
                if (el.style[type] != null) {
                    return result;
                }
            }
        };

        return Animation;

    })();

    Growl = (function () {
        Growl.settings = {
            namespace: 'growl',
            duration: 5000,
            close: "&#215;",
            location: "default",
            style: "default",
            size: "medium",
            type: "normal",
        };

        Growl.growl = function (settings) {
            if (settings == null) {
                settings = {};
            }

            this.initialize();

            return new Growl(settings);
        };

        Growl.initialize = function () {
            return $("body:not(:has(#growls))").append('<div id="growls" />');
        };

        function Growl(settings) {
            if (settings == null) {
                settings = {};
            }
            this.html = __bind(this.html, this);
            this.$growl = __bind(this.$growl, this);
            this.$growls = __bind(this.$growls, this);
            this.animate = __bind(this.animate, this);
            this.remove = __bind(this.remove, this);
            this.dismiss = __bind(this.dismiss, this);
            this.present = __bind(this.present, this);
            this.cycle = __bind(this.cycle, this);
            this.close = __bind(this.close, this);
            this.unbind = __bind(this.unbind, this);
            this.bind = __bind(this.bind, this);
            this.render = __bind(this.render, this);
            this.settings = $.extend({}, Growl.settings, settings);
            this.$growls().attr('class', this.settings.location);
            this.render();
        }

        Growl.prototype.render = function () {
            var $growl;
            $growl = this.$growl();

            if (this.settings["type"] == "normal") {
                this.$growls().append($growl);
            }

            if (this.settings["type"] == "top") {
                if ($('.onTopNotification').length == 0) {
                    $('body').prepend($growl);

                    var height = $('div[data-id="' + this.settings.id + '"]').height();

                    $('.onTopNotification').height(height + 20);
                }
            }

            if (this.settings["static"] != null) {
                this.present();
            } else {
                this.cycle();
            }
        };

        Growl.prototype.bind = function ($growl) {
            if ($growl == null) {
                $growl = this.$growl();
            }

            return $growl.on("contextmenu", this.close).find("." + this.settings.namespace + "-close").on("click", this.close);
        };

        Growl.prototype.unbind = function ($growl) {
            if ($growl == null) {
                $growl = this.$growl();
            }

            return $growl.off("contextmenu", this.close).find("." + (this.settings.namespace - close)).off("click", this.close);
        };

        Growl.prototype.close = function (event) {
            var $growl;
            event.preventDefault();
            event.stopPropagation();
            $growl = this.$growl();

            if (this.settings.type == "top") {
                var id = $('div.growl').data("id");
                var key = storageName + "." + id

                localStorage[key] = true;
            }

            return $growl.stop().queue(this.dismiss).queue(this.remove);
        };

        Growl.prototype.cycle = function () {
            var $growl;
            $growl = this.$growl();

            if (this.settings.type == "normal") {
                return $growl.queue(this.present).delay(this.settings.duration).queue(this.dismiss).queue(this.remove);
            } else if (this.settings.type == "top") {
                return $growl.on("contextmenu", this.close).find("." + this.settings.namespace + "-close").on("click", this.close);
            }
        };

        Growl.prototype.present = function (callback) {
            var $growl;
            $growl = this.$growl();
            this.bind($growl);

            return this.animate($growl, "" + this.settings.namespace + "-incoming", 'out', callback);
        };

        Growl.prototype.dismiss = function (callback) {
            var $growl;
            $growl = this.$growl();
            this.unbind($growl);

            return this.animate($growl, "" + this.settings.namespace + "-outgoing", 'in', callback);
        };

        Growl.prototype.remove = function (callback) {
            this.$growl().remove();
            return callback();
        };

        Growl.prototype.animate = function ($element, name, direction, callback) {
            var transition;

            if (direction == null) {
                direction = 'in';
            }

            transition = Animation.transition($element);
            $element[direction === 'in' ? 'removeClass' : 'addClass'](name);
            $element.offset().position;
            $element[direction === 'in' ? 'addClass' : 'removeClass'](name);

            if (callback == null) {
                return;
            }

            if (transition != null) {
                $element.one(transition, callback);
            } else {
                callback();
            }
        };

        Growl.prototype.$growls = function () {
            return this.$_growls != null ? this.$_growls : this.$_growls = $('#growls');
        };

        Growl.prototype.$growl = function () {
            return this.$_growl != null ? this.$_growl : this.$_growl = $(this.html());
        };

        Growl.prototype.html = function () {
            // icon supported?
            var icon = "&nbsp;";
            var html = "";

            if ((this.settings.icon).length > 0) {
                icon = "<img src='" + this.settings.icon + "'>";
            }

            if (this.settings.type == "top") {
                html += "<div class='onTopNotification'></div>";
            }

            html += "<div data-id='" + this.settings.id + "' class='" + this.settings.namespace + " " + this.settings.namespace + "-" + this.settings.style + " " + this.settings.namespace + "-" + this.settings.size + "'>\n" +
                    "<div class='" + this.settings.namespace + "-icon'>" +
                    icon +
                    "</div>\n" +
                    "<div class='" + this.settings.namespace + "-right'>" +
                    "<div class='" + this.settings.namespace + "-close'>" + this.settings.close + "</div>\n" +
                    "<div class='" + this.settings.namespace + "-title'>" + this.settings.title + "</div>\n" +
                    "<div class='" + this.settings.namespace + "-message'>" + this.settings.message + "</div>\n" +
                    "</div>" +
                    "</div>";

            return html;
        };

        return Growl;
    })();

    $.growl = function (options) {
        if (options == null) {
            options = {};
        }
        return Growl.growl(options);
    };

    $.growl.error = function (options) {
        var settings;
        if (options == null) {
            options = {};
        }

        settings = {
            title: "",
            style: "error"
        };
        if (options.id == 'show') {
           return $.growl($.extend(settings, options));
        }
        
    };

    $.growl.notice = function (options) {
        var settings;
        if (options == null) {
            options = {};
        }

        settings = {
            title: "",
            style: "notice"
        };
        if (options.id == 'show') {
            return $.growl($.extend(settings, options));
        }
        
    };

    $.growl.warning = function (options) {
        var settings;

        if (options == null) {
            options = {};
        }

        settings = {
            title: "",
            style: "warning"
        };
        if (options.id == 'show') {
            return $.growl($.extend(settings, options));
        }
    };

    $.growl.top = function (options) {
        var settings;

        if (options == null) {
            options = {};
        }

        settings = {
            title: "",
            style: "notice growl-topNotification"
        };

        // was shown this notification in history
        //alert(options.id);
        if (options.id == 'show') {
            return $.growl($.extend(settings, options));
        }

        return;
    }
}).call(this);