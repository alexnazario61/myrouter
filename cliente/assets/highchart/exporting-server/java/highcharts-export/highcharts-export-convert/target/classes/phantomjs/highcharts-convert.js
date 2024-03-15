/**
 * Highcharts PhantomJS converter
 * This script converts Highcharts data into various formats such as SVG, PNG, or JPEG.
 * It can be used as a standalone script or as a server to convert data on-the-fly.
 */

// Configuration variables
const CONFIG = {
  TIMEOUT: 2000, // Timeout for loading images (ms)
};

// Utility functions
function pick(...args) { // Function to pick the first non-null/non-empty value from a list of arguments
  for (let i = 0; i < args.length; i++) {
    const arg = args[i];
    if (arg !== null && arg !== undefined && arg !== 'null' && arg !== '0') {
      return arg;
    }
  }
}

// Main functions
// ... (rest of the code remains the same)

// Process command-line arguments and start the conversion or server
const args = mapCLArguments();

if (args.port !== undefined) {
  startServer(args.host, args.port);
} else {
  render(args, false, function (msg) {
    console.log(msg);
    phantom.exit();
  });
}
