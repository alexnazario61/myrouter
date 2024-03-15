<?php

/**
 * RouterOS PHP API class v1.6
 * Author: Denis Basta
 * Contributors:
 *    Nick Barnes
 *    Ben Menking (ben [at] infotechsc [dot] com)
 *    Jeremy Jefferson (http://jeremyj.com)
 *    Cristian Deluxe (djcristiandeluxe [at] gmail [dot] com)
 *
 * http://www.mikrotik.com
 * http://wiki.mikrotik.com/wiki/API_PHP_class
 */

class routeros_api
{
    /**
     * @var bool Show debug information
     */
    var $debug = false;

    /**
     * @var int Variable for storing connection error number, if any
     */
    var $error_no;

    /**
     * @var string Variable for storing connection error text, if any
     */
    var $error_str;

    /**
     * @var int Connection attempt count
     */
    var $attempts = 5;

    /**
     * @var bool Connection state
     */
    var $connected = false;

    /**
     * @var int Delay between connection attempts in seconds
     */
    var $delay = 3;

    /**
     * @var int Port to connect to
     */
    var $port = 8728;

    /**
     * @var int Connection attempt timeout and data read timeout
     */
    var $timeout = 3;

    /**
     * @var resource Variable for storing socket resource
     */
    var $socket;

    /**
     * Check if a variable is iterable
     *
     * @param mixed $var
     *
     * @return bool
     */
    function is_iterable($var)
    {
        return $var !== null
            && (is_array($var)
                || $var instanceof Traversable
                || $var instanceof Iterator
                || $var instanceof IteratorAggregate
            );
    }

    /**
     * Print text for debug purposes
     *
     * @param string $text Text to print
     *
     * @return void
     */
    function debug($text)
    {
        if ($this->debug) {
            echo $text . "\n";
        }
    }

    /**
     * Encode length of data to be sent to RouterOS
     *
     * @param int $length
     *
     * @return string
     */
    function encode_length($length)
    {
        if ($length < 0x80) {
            $length = chr($length);
        } else if ($length < 0x4000) {
            $length |= 0x8000;
            $length = chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        } else if ($length < 0x200000) {
            $length |= 0xC00000;
            $length = chr(($length >> 16) & 0xFF) . chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        } else if ($length < 0x10000000) {
            $length |= 0xE0000000;
            $length = chr(($length >> 24) & 0xFF) . chr(($length >> 16) & 0xFF) . chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        } else if ($length >= 0x10000000) {
            $length = chr(0xF0) . chr(($length >> 24) & 0xFF) . chr(($length >> 16) & 0xFF) . chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        }

        return $length;
    }

    /**
     * Login to RouterOS
     *
     * @param string $ip Hostname (IP or domain) of the RouterOS server
     * @param string $login The RouterOS username
     * @param string $password The RouterOS password
     *
     * @return bool
     */
    function connect($ip, $login, $password)
    {
        for ($ATTEMPT = 1; $ATTEMPT <= $this->attempts; $ATTEMPT++) {
            $this->connected = false;
            $this->debug('Connection attempt #' . $ATTEMPT . ' to ' . $ip . ':' . $this->port . '...');
            $this->socket = @fsockopen($ip, $this->port, $this->error_no, $this->error_str, $this->timeout);
            if ($this->socket) {
                socket_set_timeout($this->socket, $this->timeout);
                $this->write('/login');
                $RESPONSE = $this->read(false);
                if ($RESPONSE[0] == '!done') {
                    $MATCHES = array();
                    if (preg
