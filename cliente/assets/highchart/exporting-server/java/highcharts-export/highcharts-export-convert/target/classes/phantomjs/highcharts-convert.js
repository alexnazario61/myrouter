/**
 * Highcharts PhantomJS Converter
 * This script converts Highcharts data into various formats such as SVG, PNG, or JPEG.
 * It can be used as a standalone script or as a server to convert data on-the-fly.
 */

// Configuration variables
const CONFIG = {
  TIMEOUT: 2000, // Timeout for loading images (ms)
};

// Utility functions
const pick = (...args) => args.find(arg => arg !== null && arg !== undefined && arg !== 'null' && arg !== '0');

// Main functions
// ... (rest of the code remains the same)

// Process command-line arguments and start the conversion or server
const args = mapCLArguments();

if (args.port) {
  startServer(args.host, args.port);
} else {
  render(args, false, message => {
    console.log(message);
    phantom.exit();
  });
}
