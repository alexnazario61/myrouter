/**
 * cbpHorizontalSlideOutMenu.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Codrops
 * http://www.codrops.com
 * updated by DazeinCreative
 */

/**
 * Creates a new cbpHorizontalSlideOutMenu instance.
 * @constructor
 * @param {Element} el - The root element of the menu.
 * @param {Object} [options] - The options object.
 */
function cbpHorizontalSlideOutMenu(el, options) {
  this.el = el;
  this.options = Object.assign({}, this.defaults, options);
  this._init();
}

cbpHorizontalSlideOutMenu.prototype = {
  defaults: {},

  _init: function() {
    this.current = -1;
    this.touch = 'ontouchstart' in window;
    this.menu = this.el.querySelector('.cbp-hsmenu');
    this.menuItems = this.el.querySelectorAll('.cbp-hsmenu > li');
    this.tickb = this.el.querySelectorAll('*');
    this.menuBg = document.createElement('div');
    this.menuBg.className = 'cbp-hsmenubg';
    this.el.appendChild(this.menuBg);
    this._initEvents();
    this.mark = 'marker-id';
  },

  _openMenu: function(el, ev) {
    const self = this;
    const item = el.parentNode;
    const submenu = item.querySelector('.cbp-hssubmenu');
    const closeCurrent = (current) => {
      const currentItem = current || this.menuItems[this.current];
      currentItem.className = '';
      currentItem.setAttribute('data-open', '');
    };
    const marker = (element, index, array) => {
      element.setAttribute(this.mark, '');
    };
    const closePanel = () => {
      this.current = -1;
      this.menuBg.style.height = '0px';
    };

    this.tickb.forEach(marker);

    if (submenu) {
      ev.preventDefault();

      if (item.getAttribute('data-open') === 'open') {
        closeCurrent(item);
        closePanel();
      } else {
        item.setAttribute('data-open', 'open');

        if (this.current !== -1) {
          closeCurrent();
        }

        this.current = Array.from(this.menuItems).indexOf(item);
        item.className = 'cbp-hsitem-open';

        if (this.touch) {
          this._measureSubmenu(submenu);
        } else {
          this.menuBg.style.height = submenu.offsetHeight + 'px';
        }
      }

      const closeMenu = (ev) => {
        if (!ev.target.matches('.cbp-hsmenu a') && this.menuBg.style.height !== '0px' && item.getAttribute('data-open') === 'open') {
          closeCurrent(item);
          closePanel();
          window.removeEventListener('click', closeMenu);
          window.removeEventListener('touchstart', closeMenu);
        }
      };

      window.addEventListener('click', closeMenu);
      window.addEventListener('touchstart', closeMenu);
    } else {
      if (this.current !== -1) {
        closeCurrent();
        closePanel();
      }
    }
  },

  _initEvents: function() {
    const self = this;

    for (const el of this.menuItems) {
      const trigger = el.querySelector('a');

      if (self.touch) {
        trigger.addEventListener('touchstart', (ev) => { self._openMenu(ev.currentTarget, ev); });
      } else {
        trigger.addEventListener('click', (ev) => { self._openMenu(ev.currentTarget, ev); });
      }
    }

    window.addEventListener('resize', () => { this._resizeHandler(); });
  },

  _resizeHandler: function() {
    const self = this;

    function delayed() {
      self._resize();
      self._resizeObserver.disconnect();
      self._resizeObserver = null;
    }

    if (this._resizeObserver) {
      this._resizeObserver.disconnect();
    }

    this._resizeObserver = new ResizeObserver(delayed);
    this._resizeObserver.observe(this.el);
  },

  _resize: function() {
    if (this.current !== -1) {
      this.menuBg.style.height = this.menuItems[this.current].querySelector('.cbp-hssubmenu').offsetHeight + 'px';
    }
  },

  _measureSubmenu: function(submenu) {
    const self = this;

    function delayed() {
      self.menuBg.style.height = submenu.offsetHeight + 'px';
    }

    if (this._measureObserver) {
      this._measureObserver
