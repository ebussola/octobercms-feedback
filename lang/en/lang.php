<?php


return [
    'component' => [
        'send_to' => [
            'title' => 'Send to:',
            'description' => 'The address to send the feedback. Leave it blank to use the admin\'s address',
            'placeholder' => 'Using admin\'s address'
        ],
        'onSend' => [
            'success' => 'Thank you for your message!',
            'error' => [
                'email' => [
                    'email' => 'Invalid email address, please provide a valid email'
                ]
            ]
        ]
    ],
    'mail_template' => [
        'description' => 'The feedback message to be sent to the email registered.'
    ]
];