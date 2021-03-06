<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary'  => env('SNAPPY_PDF_BIN', '/usr/local/bin/wkhtmltopdf'),
//        'binary'  => env('SNAPPY_PDF_BIN', base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64')),
        'timeout' => false,
        'options' => ['javascript-delay' => 5000],
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => env('SNAPPY_IMG_BIN', '/usr/local/bin/wkhtmltoimage'),
//        'binary'  => env('SNAPPY_IMG_BIN', base_path('vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64')),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
