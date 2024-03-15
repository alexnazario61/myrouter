<?php 
/*****************************
 *
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
 *
 ******************************/

class routeros_api
{
    /**
     * @var bool Show debug information
     */
    var $debug = false;      // Show debug information
    var $error_no;           // Variable for storing connection error number, if any
    var $error_str;          // Variable for storing connection error text, if any
    var $attempts = 5;       // Connection attempt count
    var $connected = false;  // Connection state
    var $delay = 3;          // Delay between connection attempts in seconds
    var $port = 8728;        // Port to connect to
    var $timeout = 3;        // Connection attempt timeout and data read timeout
    var $socket;             // Variable for storing socket resource

    /**
     * Check if a variable is iterable
     *
     * @param mixed $var
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
     * @return void
     */
    function debug($text)
    {
        if ($this->debug)
            echo $text . "\n";
    }

    /**
     * Encode the length of a string in RouterOS API format
     *
     * @param int $length
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
        } else if ($length >= 0x10000000)
            $length = chr(0xF0) . chr(($length >> 24) & 0xFF) . chr(($length >> 16) & 0xFF) . chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        return $length;
    }

    /**
     * Login to RouterOS
     *
     * @param string $ip Hostname (IP or domain) of the RouterOS server
     * @param string $login The RouterOS username
     * @param string $password The RouterOS password
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
                $RESPONSE = $this->read();
                if ($RESPONSE[0] == '!done') {
                    $MATCHES = array();
                    if (preg_match_all('/[^=]+/i', $RESPONSE[1], $MATCHES)) {
                        if ($MATCHES[0][0] == 'ret' && strlen($MATCHES[0][1]) == 32) {
                            $this->write('/login', false);
                            $this->write('=name=' . $login, false);
                            $this->write('=response=00' . md5(chr(0) . $password . pack('H*', $MATCHES[0][1])));
                            $RESPON
