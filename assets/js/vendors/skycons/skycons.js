(function() {
  "use strict";

  // Set up a RequestAnimationFrame shim so we can animate efficiently FOR
  // GREAT JUSTICE.
  var requestInterval, cancelInterval;

  (function() {
    var raf = window.requestAnimationFrame ||
              window.webkitRequestAnimationFrame ||
              window.mozRequestAnimationFrame ||
              window.oRequestAnimationFrame ||
              window.msRequestAnimationFrame ||
              window.requestAnimationFrame ||
              function(fn) {
                window.setTimeout(fn, 1000 / 60);
              },
        caf = window.cancelAnimationFrame ||
              window.webkitCancelAnimationFrame ||
              window.mozCancelAnimationFrame ||
              window.oCancelAnimationFrame ||
              window.msCancelAnimationFrame ||
              window.cancelAnimationFrame ||
              function(handle) {
                window.clearTimeout(handle);
              };

    if (raf && caf) {
      requestInterval = function(fn, delay) {
        var handle = {
          value: null
        };

        function loop() {
          handle.value = raf(loop);
          fn();
        }

        loop();
        return handle;
      };

      cancelInterval = function(handle) {
        caf(handle.value);
      };
    } else {
      requestInterval = function(fn, delay) {
        return window.setInterval(fn, delay);
      };

      cancelInterval = function(handle) {
        window.clearInterval(handle);
      };
    }
  }());

  // Catmull-rom spline stuffs.
  /* Uncomment if needed
  function upsample(n, spline) {
    // ...
  }

  function downsample(n, polyline) {
    // ...
  }
  */

  // Define skycon things.
  var KEYFRAME = 500,
      STROKE = 0.08,
      TAU = 2.0 * Math.PI,
      TWO_OVER_SQRT_2 = 2.0 / Math.sqrt(2);

  // Helper functions for drawing shapes
  function circle(ctx, x, y, r) {
    ctx.beginPath();
    ctx.arc(x, y, r, 0, TAU, false);
    ctx.fill();
  }

  function line(ctx, ax, ay, bx, by) {
    ctx.beginPath();
    ctx.moveTo(ax, ay);
    ctx.lineTo(bx, by);
    ctx.stroke();
  }

  // Icon functions
  function puff(ctx, t, cx, cy, rx, ry, rmin, rmax) {
    // ...
  }

  function puffs(ctx, t, cx, cy, rx, ry, rmin, rmax) {
    // ...
  }

  function cloud(ctx, t, cx, cy, cw, s, color) {
    // ...
  }

  function sun(ctx, t, cx, cy, cw, s, color) {
    // ...
  }

  function moon(ctx, t, cx, cy, cw, s, color) {
    // ...
  }

  function rain(ctx, t, cx, cy, cw, s, color) {
    // ...
  }

  function sleet(ctx, t, cx, cy, cw, s, color) {
    // ...
  }

  function snow(ctx, t, cx, cy, cw, s, color) {
    // ...
  }

  function fogbank(ctx, t, cx, cy, cw, s, color) {
    // ...
  }

  // Wind paths and offsets
  var WIND_PATHS = [
        // ...
      ],
      WIND_OFFSETS = [
        // ...
      ];

  function leaf(ctx, t, x, y, cw, s, color) {
    // ...
  }

  function swoosh(ctx, t, cx, cy, cw, s, index, total, color) {
    // ...
  }

  // Skycons constructor
  var Skycons = function(opts) {
    // ...
  };

  // Icon functions as properties of the Skycons object
  Skycons.CLEAR_DAY = function(ctx, t, color) {
    // ...
  };

  Skycons.CLEAR_NIGHT = function(ctx, t, color) {
    // ...
  };

  Skycons.PARTLY_CLOUDY_DAY = function(ctx, t, color) {
    // ...
  };

  Skycons.PARTLY_CLOUDY_NIGHT = function(ctx, t, color) {
    // ...
  };

  Skycons.CLOUDY = function(ctx, t, color) {
    // ...
  };

  Skycons.RAIN = function(ctx, t, color) {
    // ...
  };

  Skycons.SLEET = function(ctx, t, color) {
    // ...
  };

  Skycons.SNOW = function(ctx, t, color) {
    // ...
  };

  Skycons.WIND = function(ctx, t, color) {
    // ...
  };

  Skycons.FOG = function(
