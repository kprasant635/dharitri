/**
 * @author Marcel Liebgott <marcel@mliebgott.de>
 * @version 1.00
 *
 * this notification service is based on jQuery growl
 * following types of notifications was supported
 * - error
 * - warning
 * - info
 */
(function ($) {
    $.NotificationService = {
        /**
         * @author Marcel Liebgott <marcel@mliebgott.de>
         * @since 1.00
         *
         * shwow error notification
         *
         * @param {Object} options
         * @return {Instance} growl
         */
        showErrorNotification: function (options) {
            if (options == null) {
                options = {};
            }

            if (typeof options.icon == "undefined") {
                var iconOption = {
                    icon: ""
                };

                options = $.extend({}, options, iconOption);
            }

            return $.growl.error(options);
        },
        /**
         * @author Marcel Liebgott <marcel@mliebgott.de>
         * @since 1.00
         *
         * shwow warning notification
         *
         * @param {Object} options
         * @return {Instance} growl
         */
        showWarningNotification: function (options) {
            if (options == null) {
                options = {};
            }

            if (typeof options.icon == "undefined") {
                var iconOption = {
                    icon: ""
                };

                options = $.extend({}, options, iconOption);
            }

            return $.growl.warning(options);
        },
        /**
         * @author Marcel Liebgott <marcel@mliebgott.de>
         * @since 1.00
         *
         * show info notification
         *
         * @param {Object} options
         * @return {Instance} growl
         */
        showInfoNotification: function (options) {
            if (options == null) {
                options = {};
            }

            if (typeof options.icon == "undefined") {
                var iconOption = {
                    icon: ""
                };

                options = $.extend({}, options, iconOption);
            }

            return $.growl.notice(options);
        },
        /**
         * @author Marcel Liebgott <marcel@mliebgott.de>
         * @since 1.00
         *
         * show top notification
         *
         * @param {Object} options
         * @return {Instance} growl
         */
        showTopNotification: function (options) {
            if (options == null) {
                options = {};
            }

            if (typeof options.icon == "undefined") {
                var iconOption = {
                    icon: ""
                };

                options = $.extend({}, options, iconOption);
            }

            return $.growl.top(options);
        }
    };
})(jQuery);