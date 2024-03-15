<?php

class RouterOS_API {

    /**
     * @var bool Show debug information
     */
    private bool $debug = false;

    /**
     * @var int Variable for storing connection error number, if any
     */
    private int $error_no;

    /**
     * @var string Variable for storing connection error text, if any
     */
    private string $error_str;

    /**
     * @var int Connection attempt count
     */
    private int $attempts = 5;

    /**
     * @var bool Connection state
     */
    private bool $connected = false;

    /**
     * @var int Delay between connection attempts in seconds
     */
    private int $delay = 3;

    /**
     * @var int Port to connect to
     */
    private int $port = 8728;

    /**
     * @var int Connection attempt timeout and data read timeout
     */
    private int $timeout = 3;

    /**
     * @var resource Variable for storing socket resource
     */
    private $socket;

    /**
     * Debug function to print debug information
     *
     * @param string $text
     */
    private function debug(string $text): void {
        if ($this->debug) {
            echo $text . "\n";
        }
    }

    /**
     * Encodes the length of a message to be sent over the socket
     *
     * @param int $length
     * @return string
     */
    private function encode_length(int $length): string {
        if ($length < 0x80) {
            return chr($length);
        }
        else if ($length < 0x4000) {
            $length |= 0x8000;
            return chr( ($length >> 8) & 0xFF) . chr($length & 0xFF);
        }
        else if ($length < 0x200000) {
            $length |= 0xC00000;
            return chr( ($length >> 16) & 0xFF) . chr( ($length >> 8) & 0xFF) . chr($length & 0xFF);
        }
        else if ($length < 0x10000000) {
            $length |= 0xE0000000;
            return chr( ($length >> 24) & 0xFF) . chr( ($length >> 16) & 0xFF) . chr( ($length >> 8) & 0xFF) . chr($length & 0xFF);
        }
        else if ($length >= 0x10000000) {
            $length |= 0xF0000000;
            return chr(0xF0) . chr( ($length >> 24) & 0xFF) . chr( ($length >> 16) & 0xFF) . chr( ($length >> 8) & 0xFF) . chr($length & 0xFF);
        }
    }

    /**
     * Connects to the RouterOS API
     *
     * @param string $ip
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function connect(string $ip, string $login, string $password): bool {
        for ($attempt = 1; $attempt <= $this->attempts; $attempt++) {
            $this->connected = false;
            $this->debug('Connection attempt #' . $attempt . ' to ' . $ip . ':' . $this->port . '...');
            if (is_resource($this->socket = @fsockopen($ip, $this->port, $this->error_no, $this->error_str, $this->timeout)) ) {
                socket_set_timeout($this->socket, $this->timeout);
                $this->write('/login');
                $response = $this->read();
                if ($response[0] == '!done') {
                    if (preg_match_all('/[^=]+/i', $response[1], $matches) ) {
                        if ($matches[0][0] == 'ret' && strlen($matches[0][1]) == 32) {
                            $this->write('/login', false);
                            $this->write('=name=' . $login, false);
                            $this->write('=response=00' . md5(chr(0) . $password . pack('H*', $matches[0][1]) ) );
                            $response = $this->read();
                            if ($response[0] == '!done') {
                                $this->connected = true;
                                break;
                            }
                        }
                    }
                }
                fclose($this->socket);
            }
            sleep($this->delay);
        }
        if ($this->connected) {
            $this->debug('Connected...');
        }
        else {
            $this->debug('Error...');
        }
        return $this->connected;
    }

    /**
     * Disconnects from the RouterOS API
     */
    public function disconnect(): void {
        if (is_resource($this->socket)) {
            fclose($this->socket);
        }
        $this->connected = false;
        $this->debug('Disconnected...');
    }

    /**
     * Parses the response from the RouterOS API
     *
     * @param array $response
     *
