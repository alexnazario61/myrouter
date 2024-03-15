(function ($, window, document, undefined) {
    'use strict';

    var hasTouch = 'ontouchstart' in window;

    var hasPointerEvents = (function () {
        var el = document.createElement('div'),
            docEl = document.documentElement;
        if (!('pointerEvents' in el.style)) {
            return false;
        }
        el.style.pointerEvents = 'auto';
        el.style.pointerEvents = 'x';
        docEl.appendChild(el);
        var supports = window.getComputedStyle && window.getComputedStyle(el, '').pointerEvents === 'auto';
        docEl.removeChild(el);
        return !!supports;
    })();

    var eStart = hasTouch ? 'touchstart' : 'mousedown',
        eMove = hasTouch ? 'touchmove' : 'mousemove',
        eEnd = hasTouch ? 'touchend' : 'mouseup',
        eCancel = hasTouch ? 'touchcancel' : 'mouseup';

    var defaults = {
        listNodeName: 'ol',
        itemNodeName: 'li',
        rootClass: 'dd',
        listClass: 'dd-list',
        itemClass: 'dd-item',
        dragClass: 'dd-dragel',
        handleClass: 'dd-handle',
        collapsedClass: 'dd-collapsed',
        placeClass: 'dd-placeholder',
        noDragClass: 'dd-nodrag',
        emptyClass: 'dd-empty',
        expandBtnHTML: '<button data-action="expand" type="button">Expand</button>',
        collapseBtnHTML: '<button data-action="collapse" type="button">Collapse</button>',
        group: 0,
        maxDepth: 5,
        threshold: 20
    };

    function Plugin(element, options) {
        this.w = $(window);
        this.el = $(element);
        this.options = $.extend({}, defaults, options);
        this.init();
    }

    Plugin.prototype = {

        init: function () {
            var that = this;

            this.reset();

            this.el.data('nestable-group', this.options.group);

            this.placeEl = $('<div class="' + this.options.placeClass + '"/>');

            $.each(this.el.find(this.options.itemNodeName), function (k, el) {
                that.setParent($(el));
            });

            this.el.on('click', 'button', {list: this}, function (event) {
                if (that.dragEl || (!hasTouch && event.button !== 0)) {
                    return;
                }
                var target = $(event.currentTarget),
                    action = target.data('action'),
                    item = target.parent(that.options.itemNodeName);
                if (action === 'collapse') {
                    that.collapseItem(item);
                }
                if (action === 'expand') {
                    that.expandItem(item);
                }
            });

            var onStartEvent = function (e) {
                var mouse = that.mouse,
                    target = $(e.target),
                    dragItem = target.closest(that.options.itemNodeName);

                that.placeEl.css('height', dragItem.height());


