define([
    'jquery',
    'underscore',
    'moment',
    'mage/translate'
], function ($, _, moment) {
    'use strict';

    return function (validator) {
        var validators = {
            'validate-forbid-semicolon': [
                function (value) {
                    return !value.includes(';');
                },
                $.mage.__('You can not use semicolon sign here.')
            ]
        };

        validators = _.mapObject(validators, function (data) {
            return {
                handler: data[0],
                message: data[1]
            };
        });

        return $.extend(validator, validators);
    };
});
