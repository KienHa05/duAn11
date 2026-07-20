<?php

return [

    'name' => env('APP_NAME', 'Laravel'),

    'logo_text' => env('BRAND_LOGO_TEXT', strtoupper(substr((string) env('APP_NAME', 'L'), 0, 1))),

    'url' => env('APP_URL', 'http://localhost'),

    'support_email' => env('SUPPORT_EMAIL', env('MAIL_FROM_ADDRESS', 'hello@example.com')),

];
