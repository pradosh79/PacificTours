<?php

declare(strict_types=1);

/*
| French validation overrides. Only the rules this application actually uses are
| translated; anything missing falls back to Laravel's English defaults.
*/

return [
    'accepted'  => 'Le champ :attribute doit être accepté.',
    'after'     => 'Le champ :attribute doit être une date postérieure à :date.',
    'boolean'   => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed' => 'La confirmation du champ :attribute ne correspond pas.',
    'date'      => "Le champ :attribute n'est pas une date valide.",
    'email'     => 'Le champ :attribute doit être une adresse courriel valide.',
    'exists'    => 'La valeur sélectionnée pour :attribute est invalide.',
    'image'     => 'Le champ :attribute doit être une image.',
    'integer'   => 'Le champ :attribute doit être un entier.',
    'max'       => [
        'numeric' => 'Le champ :attribute ne peut pas dépasser :max.',
        'file'    => 'Le fichier :attribute ne peut pas dépasser :max kilo-octets.',
        'string'  => 'Le champ :attribute ne peut pas dépasser :max caractères.',
    ],
    'min' => [
        'numeric' => 'Le champ :attribute doit être au moins :min.',
        'string'  => 'Le champ :attribute doit contenir au moins :min caractères.',
    ],
    'numeric'  => 'Le champ :attribute doit être un nombre.',
    'required' => 'Le champ :attribute est obligatoire.',
    'unique'   => 'Cette valeur de :attribute est déjà utilisée.',

    'attributes' => [
        'customer_first_name' => 'prénom',
        'customer_last_name'  => 'nom',
        'customer_email'      => 'courriel',
        'customer_phone'      => 'téléphone',
        'travel_date'         => 'date de voyage',
        'adults'              => 'adultes',
        'children'            => 'enfants',
        'infants'             => 'bébés',
        'coupon_code'         => 'code promo',
        'terms'               => 'conditions générales',
    ],
];
