<?php

/**
 *   ___       _
 *  / _ \  ___| |_ ___  _ __  _   _
 * | | | |/ __| __/ _ \| '_ \| | | |
 * | |_| | (__| || (_) | |_) | |_| |
 *  \___/ \___|\__\___/| .__/ \__, |
 *                     |_|    |___/
 * @author  : Supian M <supianidz@gmail.com>
 * @version : v1.0
 * @license : MIT
 */

namespace Octopy\HTTP;

class Response
{
    /**
     * @var string
     */
    private $response;

    /**
     * @var array
     */
    private $status = [
        100 => "Continue",
        101 => "Switching Protocols",
        102 => "Processing",
        200 => "OK",
        201 => "Created",
        202 => "Accepted",
        203 => "Non-Authoritative Information",
        204 => "No Content",
        205 => "Reset Content",
        206 => "Partial Content",
        207 => "Multi-Status",
        300 => "Multiple Choices",
        301 => "Moved Permanently",
        302 => "Found",
        303 => "See Other",
        304 => "Not Modified",
        305 => "Use Proxy",
        306 => "(Unused)",
        307 => "Temporary Redirect",
        308 => "Permanent Redirect",
        400 => "Bad Request",
        401 => "Unauthorized",
        402 => "Payment Required",
        403 => "Forbidden",
        404 => "Not Found",
        405 => "Method Not Allowed",
        406 => "Not Acceptable",
        407 => "Proxy Authentication Required",
        408 => "Request Timeout",
        409 => "Conflict",
        410 => "Gone",
        411 => "Length Required",
        412 => "Precondition Failed",
        413 => "Request Entity Too Large",
        414 => "Request-URI Too Long",
        415 => "Unsupported Media Type",
        416 => "Requested Range Not Satisfiable",
        417 => "Expectation Failed",
        418 => "I'm a teapot",
        419 => "Authentication Timeout",
        420 => "Enhance Your Calm",
        422 => "Unprocessable Entity",
        423 => "Locked",
        424 => "Failed Dependency",
        424 => "Method Failure",
        425 => "Unordered Collection",
        426 => "Upgrade Required",
        428 => "Precondition Required",
        429 => "Too Many Requests",
        431 => "Request Header Fields Too Large",
        444 => "No Response",
        449 => "Retry With",
        450 => "Blocked by Windows Parental Controls",
        451 => "Unavailable For Legal Reasons",
        494 => "Request Header Too Large",
        495 => "Cert Error",
        496 => "No Cert",
        497 => "HTTP to HTTPS",
        499 => "Client Closed Request",
        500 => "Internal Server Error",
        501 => "Not Implemented",
        502 => "Bad Gateway",
        503 => "Service Unavailable",
        504 => "Gateway Timeout",
        505 => "HTTP Version Not Supported",
        506 => "Variant Also Negotiates",
        507 => "Insufficient Storage",
        508 => "Loop Detected",
        509 => "Bandwidth Limit Exceeded",
        510 => "Not Extended",
        511 => "Network Authentication Required",
        598 => "Network read timeout error",
        599 => "Network connect timeout error"
    ];

    /**
     * @param string $response
     */
    public function __construct($response = null)
    {
        $this->response = $response ?? '';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (is_string($this->response) || is_int($this->response) || is_bool($this->response)) {
            return (string)$this->response;
        }
    }

    /**
     * @param  string $content
     * @return string
     */
    public function content(string $content = '')
    {
        $this->response = $content;
        return $this;
    }

    /**
     * @param  string $content
     * @return Response
     */
    public function text(string $content = '', int $code = 200)
    {
        return $this->content($content)->header('Content-Type', 'text/plain', true, $code);
    }

    /**
     * @param  array  $array
     * @return Response
     */
    public function html(string $content = '', int $code = 200)
    {
        return $this->content($content)->header('Content-Type', 'text/html', true, $code);
    }

    /**
     * @param  array  $array
     * @return Response
     */
    public function json($array, int $code = 200) : Response
    {
        return $this->content(json_encode($array))->header('Content-Type', 'application/json', true, $code);
    }

    /**
     * @param  string $location
     * @param  string $name
     * @return Response
     */
    public function download(string $location, string $name)
    {
        $this->header('Content-Disposition', 'attachment; filename=' . $name . ';');
        readfile($location);
        return $this;
    }

    /**
     * @param  string       $key
     * @param  mixed        $value
     * @param  bool|boolean $replace
     * @param  int|integer  $code
     * @return Response
     */
    public function header($key, $value = null, bool $replace = true, int $code = 200) : Response
    {
        if (is_array($key)) {
            foreach ($key as $key => $value) {
                $this->header($key, $value);
            }
            
            return $this;
        }

        header(sprintf('%s: %s', $key, $value), $replace, $code);

        return $this;
    }

    /**
     * @param  int|integer $code
     * @return Response
     */
    public function code(int $code = 200) : Response
    {
        http_response_code($code);
        return $this;
    }

    /**
     * @return int
     */
    public function status() : int
    {
        return http_response_code();
    }

    /**
     * @param  int|integer $code
     * @return string
     */
    public function reason(int $code = null) : ?string
    {
        if ($code === null) {
            $code = $this->status();
        }
        
        return $this->status[$code] ?? 'Unknown';
    }

    /**
     * @return array
     */
    public function headers() : array
    {
        return apache_response_headers();
    }

    /**
     * @return Response
     */
    public function instance() : Response
    {
        return $this;
    }
}
