<?php


return [
    'component' => [
        'send_to' => [
            'title' => 'Enviar para:',
            'description' => 'Digite o endereço de quem irá receber o feedback.',
            'placeholder' => 'Usando o endereço do Admin'
        ],
        'onSend' => [
            'success' => 'Obrigado pela mensagem! Sua opinião é extremamente importante para nós!',
            'error' => [
                'email' => [
                    'email' => 'Endereço de email inválido.'
                ]
            ]
        ]
    ],
    'mail_template' => [
        'description' => 'A mensagem que será enviada para o endereço de email selecionado.'
    ]
];