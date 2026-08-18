<?php

declare(strict_types=1);

return [
    'statuses' => [
        'pending'   => 'En attente',
        'confirmed' => 'Confirmée',
        'cancelled' => 'Annulée',
        'completed' => 'Terminée',
        'refunded'  => 'Remboursée',
    ],
    'wizard' => [
        'tour'    => 'Circuit',
        'date'    => 'Date',
        'guests'  => 'Voyageurs',
        'details' => 'Vos coordonnées',
        'payment' => 'Paiement',
    ],
    'seats_left'    => ':count place disponible|:count places disponibles',
    'deposit_hint'  => 'Payez :amount maintenant, le solde avant le départ.',
    'confirmation'  => 'Réservation :number confirmée.',
];
