<?php

return [

    'mail' => [

        'subject' => '🔥 Possible attaque sur :domain',
        'message' => 'une attaque possible :middleware attaque sur :domain a été détecté depuis :ip . adresse affecté : :url',

    ],

    'slack' => [

        'message' => 'une possible attaque détecté.',

    ],

];
