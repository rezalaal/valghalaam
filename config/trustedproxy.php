<?php

use Illuminate\Http\Request;


return [

    /*
     * Set trusted proxy IP addresses.
     *
     * Both IPv4 and IPv6 addresses are supported, along with CIDR notation.
     * The "*" character is syntactic sugar within TrustedProxy to trust any
     * proxy that connects directly to your server, a requirement when you cannot
     * know the address of your proxy (e.g. if using Elastic Load Balancing).
     */
    'proxies' => env('TRUSTED_PROXIES', '*'), // Accepts the '*' wildcard for all proxies.

    /*
     * To trust one or more specific proxies that connect directly to your server,
     * use an array instead of "*":
     *
     * 'proxies' => [
     *     '192.168.1.1',
     *     '192.168.1.2',
     * ]
     */

    /*
     * Or, to trust all proxies that connect directly to your server, use a "*"
     *
     * Note: '*' does not mean 'all proxies'. It means 'all proxies that connect
     * directly to your server' (e.g. all load balancers, all CDN servers).
     */

    /*
     * Default Header Names
     *
     * Change these if the proxy does not use the default header names.
     */
    'headers' => [
        Request::HEADER_FORWARDED    => 'FORWARDED',
        Request::HEADER_X_FORWARDED_FOR => 'X_FORWARDED_FOR',
        Request::HEADER_X_FORWARDED_HOST => 'X_FORWARDED_HOST',
        Request::HEADER_X_FORWARDED_PORT => 'X_FORWARDED_PORT',
        Request::HEADER_X_FORWARDED_PROTO => 'X_FORWARDED_PROTO',
        Request::HEADER_X_FORWARDED_AWS_ELB  => 'X_FORWARDED_AWS_ELB',
    ],

];
