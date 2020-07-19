<?php

use D2\Instance;
use Performance\User;
use Performance\UserAddress;
use Performance\UserPreferences;

$autoload = __DIR__.'/../vendor/autoload.php';

if (! file_exists($autoload)) {
    throw new RuntimeException('Install composer dependencies to run test suite');
}

require_once $autoload;

$started = hrtime(true);

$build = function() {

    $dbRow = [
        'id'                             => 1,
        'name'                           => 'Ivan',
        'email'                          => 'ivan@ivan.ru',
        'created_at'                     => '1970-01-01 00:00:00',
        'address_country'                => 'Russia',
        'address_city'                   => 'Moscow',
        'address_street'                 => 'Krasnaya',
        'address_house'                  => '1',
        'address_flat'                   => null,
        'address_zip_code'               => 100000,
        'preferences_locale'             => 'ru_RU',
        'preferences_language'           => 'ru',
        'preferences_timezone'           => 'utc',
        'preferences_theme'              => 'light',
        'preferences_subscribe_news'     => false,
        'preferences_subscribe_messages' => true,
        'field0'                         => 'text',
        'field1'                         => 'text',
        'field2'                         => 'text',
        'field3'                         => 'text',
        'field4'                         => 'text',
        'field5'                         => 'text',
    ];

    $dbRow['address']     = Instance::byConstructor(UserAddress::class, $dbRow, 'address_');
    $dbRow['preferences'] = Instance::byConstructor(UserPreferences::class, $dbRow, 'preferences_');

    return Instance::byConstructor(User::class, $dbRow);
};

for ($i = 1; $i <= 1000; $i++) {
    $build();
    if ($i == 2) {
        $finished2 = hrtime(true);
    }
    if ($i == 5) {
        $finished5 = hrtime(true);
    }
    if ($i == 10) {
        $finished10 = hrtime(true);
    }
    if ($i == 25) {
        $finished25 = hrtime(true);
    }
    if ($i == 100) {
        $finished100 = hrtime(true);
    }
}

$finished1000 = hrtime(true);

dd([
    '2    ' => (($finished2    - $started) / 1e9) . ' sec',
    '5    ' => (($finished5    - $started) / 1e9) . ' sec',
    '10   ' => (($finished10   - $started) / 1e9) . ' sec',
    '25   ' => (($finished25   - $started) / 1e9) . ' sec',
    '100  ' => (($finished100  - $started) / 1e9) . ' sec',
    '1000 ' => (($finished1000 - $started) / 1e9) . ' sec',
]);