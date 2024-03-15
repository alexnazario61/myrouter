// This is the main entry point for the JavaScript code in Bootstrap's docs.
// It initializes various components and plugins used in the documentation.
// The code is wrapped in an immediately-invoked function expression (IIFE)
// to avoid polluting the global namespace.

/* global ZeroClipboard */ // This line is used to declare ZeroClipboard as a global variable.

!function ($) {
  'use strict';

  // The code inside this function will be executed after the DOM is fully loaded.
  $(function () {

    // Initialize Scrollspy
    var $window = $(window);
    var $body   = $(document.body);

    $body.scrollspy({
      target: '.bs-docs-sidebar'
    });

    $window.on('load', function () {
      $body.scrollspy('refresh');
    });

    // Prevent links with href="#" from causing a full page reload
    $('.bs-docs-container [href=#]').click(function (e) {
      e.preventDefault();
    });

    // Initialize Sidenav affixing
    setTimeout(function () {
      var $sideBar = $('.bs-docs-sidebar');

      $sideBar.affix({
        offset: {
          top: function () {
            var offsetTop      = $sideBar.offset().top;
            var sideBarMargin  = parseInt($sideBar.children(0).css('margin-top'), 10);
            var navOuterHeight = $('.bs-docs-nav').height();

            // Calculate the top offset based on the sidebar's position and the height of the navigation bar.
            return (this.top = offsetTop - navOuterHeight - sideBarMargin);
          },
          bottom: function () {
            // Set the bottom offset to the height of the footer.
            return (this.bottom = $('.bs-docs-footer').outerHeight(true));
          }
        }
      });
    }, 100);

    setTimeout(function () {
      $('.bs-top').affix();
    }, 100);

    // Initialize theme toggler
    ;(function () {
      var stylesheetLink = $('#bs-theme-stylesheet');
      var themeBtn = $('.bs-docs-theme-toggle');

      var activateTheme = function () {
        // Set the href attribute of the stylesheet link to the data-href attribute value.
        stylesheetLink.attr('href', stylesheetLink.attr('data-href'));
        themeBtn.text('Disable theme preview');
        localStorage.setItem('previewTheme', true);
      };

      if (localStorage.getItem('previewTheme')) {
        activateTheme();
      }

      themeBtn.click(function () {
        var href = stylesheetLink.attr('href');
        if (!href || href.indexOf('data') === 0) {
          activateTheme();
        } else {
          // Clear the href attribute of the stylesheet link.
          stylesheetLink.attr('href', '');
          themeBtn.text('Preview theme');
          localStorage.removeItem('previewTheme');
        }
      });
    })();

    // Initialize Tooltip and Popover demos
    $('.tooltip-demo').tooltip({
      selector: '[data-toggle="tooltip"]',
      container: 'body'
    });

    $('.popover-demo').popover({
      selector: '[data-toggle="popover"]',
      container: 'body'
    });

    // Initialize Popover demos within modals
    $('.tooltip-test').tooltip();
    $('.popover-test').popover();

    // Initialize Popover demos
    $('.bs-docs-popover').popover();

    // Initialize Button state demo
    $('#loading-example-btn').on('click', function () {
      var btn = $(this);
      btn.button('loading');
      setTimeout(function () {
        btn.button('reset');
      }, 3000);
    });

    // Initialize Modal relatedTarget demo
    $('#exampleModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var recipient = button.data('whatever'); // Extract info from data-* attributes

      // Update the modal's content
      var modal = $(this);
      modal.find('.modal-title').text('New message to ' + recipient);
      modal.find('.modal-body input').val(recipient);
    });

    // Initialize animated progress bar
    $('.bs-docs-activate-animated-progressbar').on('click', function () {
      $(this).siblings('.progress').find('.progress-bar-striped').toggleClass('active');
    });

    // Initialize ZeroClipboard
    // Configure ZeroClipboard with the path to the SWF file and the hover class
    ZeroClipboard.config({
      moviePath: '/assets/flash/ZeroClipboard.swf',
      hoverClass: 'btn-clipboard-hover'
    });

    // Insert copy to clipboard button before .highlight
    $('.highlight').each(function () {
      var btnHtml = '<div class="zero-clipboard"><span class="btn-clipboard">Copy</span></div>';
      $(this).before(btnHtml);
    });

    // Initialize ZeroClipboard instances
    var zeroClipboard = new ZeroClipboard($('.btn-clipboard'));

    // Initialize HTML bridge for ZeroClipboard
    var htmlBridge = $('#global-zeroclipboard-html-bridge');

    // Set up event handlers for ZeroClipboard
    zeroClipboard.on('load', function () {
      // Initialize tooltip for the HTML bridge
      htmlBridge
        .data('placement', 'top')
        .attr('title', 'Copy to clipboard')
        .tooltip();
    });

    // Handle copy to clipboard request
    zeroClipboard.on('dataRequested', function (client) {
      var highlight = $(this).parent().nextAll('.highlight').first();
      client.setText(highlight.text());
    });

    // Handle copy success and update tooltip
    zeroClip
