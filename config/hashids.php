<?php

/*
 * This file is part of Laravel Hashids.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Hashids Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'main' => [
            'salt' => 'your-salt-string',
            'length' => 'your-length-integer',
        ],

        'show' => [
            'salt' => 'dNWAtEDQeGuownCEx6aiuXUt7hBnjeFN',
            'length' => 10,
        ],
        'ticket' => [
            'salt' => 'dqciY7qewr2BWQs56jwe78TesdgfhyweJfdsgkMsrrMs',
            'length' => 10,
            'alphabet' => 'abcdefg123456789',
        ],
        'ticket_code' => [
            'salt' => 'dqciY7qBWQsjGTkZoeerDw4mhHcBMtiUcJfpzMpLrMs',
            'length' => 10,
        ],
        'order' => [
            'salt' => 'RhqEHxxwFrxYeTR3QBWcEsExBHhopvVAjEhvP3KmyCn',
            'length' => 10,
        ],
        'payment' => [
            'salt' => 'yoxXxHVtAnutxXhqJhaooGdXZN7hAtUaKocnM4UxJim',
            'length' => 10,
        ],
        'showtime' => [
            'salt' => 'NsDiCWTz2bKPXPMZkUXvMfw8fVcdXw7jf',
            'length' => 10,
        ],
        'device' => [
            'salt' => 'GwFmG3G8nVJzeHADeDXJaFGXAdkMLFYeqJcCiXaqRxK',
            'length' => 10,
        ],

    ],

];
