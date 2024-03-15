package com.highcharts.export.server;

/**
 * This enum represents the different states that the server can be in.
 */
public enum ServerState {
    /**
     * The server is idle and ready to process a new request.
     */
    IDLE,

    /**
     * The server has encountered an error and is no longer running.
     */
    DEAD,

    /**
     * The server is currently processing a request.
     */
    BUSY,

    /**
     * The server has timed out while processing a request.
     */
    TIMEDOUT,

    /**
     * The server is actively processing a request.
     */
    ACTIVE;

    /**
     * Returns a string representation of this enum constant, as
     * defined in its declaration. This method may be overridden,
     * though it is not recommended. In most cases, you should use
     * {@link #name()} instead.
     *
     * @return a string representation of this enum constant
     */
    @Override
    public String toString() {
        return name();
    }
}
