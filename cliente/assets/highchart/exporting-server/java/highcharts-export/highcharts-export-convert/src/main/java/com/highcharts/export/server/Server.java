// Import necessary classes and libraries

public class Server {
    // Class variables
    private Process process;
    private final int port;
    private final String host;
    private final int readTimeout;
    private final int connectTimeout;
    private final int maxTimeout;
    private ServerState state;

    // Logger for logging events and errors
    protected static Logger logger = Logger.getLogger("utils");

    // Constructor initializes the PhantomJS process and sets up the required parameters
    public Server(String exec, String script, String host, int port, int connectTimeout, int readTimeout, int maxTimeout) {
        // Assign parameters to instance variables
        this.port = port;
        this.host = host;
        this.connectTimeout = connectTimeout;
        this.readTimeout = readTimeout;
        this.maxTimeout = maxTimeout;

        // Initialize the PhantomJS process and check if it's ready
        // ...

        // Add a shutdown hook to terminate the PhantomJS process gracefully
        Runtime.getRuntime().addShutdownHook(new Thread() {
            // ...
        });
    }

    // initialize() method logs a message indicating that the PhantomJS server has started
    public void initialize() {
        logger.debug("Phantom server started on port " + port);
    }

    // request() method sends a request to the PhantomJS server and returns the response
    public String request(String params) throws SocketTimeoutException, SVGConverterException, TimeoutException {
        // ...
    }

    // cleanup() method cleans up and terminates the PhantomJS process
    public void cleanup() {
        // ...
    }

    // getPort(), getHost(), getState(), and setState() methods return or set the respective instance variables

    // toString() method returns a string representation of the Server instance
    @Override
    public String toString() {
        return this.getClass().getName() + "listening to port: " + port;
    }
}
