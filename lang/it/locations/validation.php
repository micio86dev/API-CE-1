<?php

return [
    'name.required' => 'Il nome della location è obbligatorio.',
    'name.max' => 'Il nome della location non può superare 255 caratteri.',
    'phone_number.string' => 'Il numero di telefono deve essere una stringa.',
    'phone_number.max' => 'Il numero di telefono non può superare 15 caratteri.',
    'phone_number.min' => 'Il numero di telefono deve essere lungo almeno 8 caratteri.',
    'email.email' => 'Il campo email deve essere un indirizzo email valido.',
    'email.max' => 'Il campo email non può superare 70 caratteri.',
    'customer_id.required' => 'Il cliente della location è obbligatorio.',
    'customer_id.exists' => 'Il cliente della location non esiste.',
    'types.array' => 'I tipi della location devono essere forniti come un array.',
    'types.*.integer' => 'I tipi della location devono essere forniti come un array di interi.',
    'address.required' => 'L\'indirizzo della location è obbligatorio.',
    'address.array' => 'L\'indirizzo della location devono essere forniti come un array.',
    'email.unique' => 'L\'email della location deve essere unica.',
    'phone_number.unique' => 'Il numero di telefono della location deve essere unico.',
];