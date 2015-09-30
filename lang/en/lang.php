<?php


return [
    'component' => [
        'feedback' => [
            'name' => 'Feedback',
            'description' => 'Listen to your users, receive messages and improve your site.',

            'channelCode' => [
                'title' => 'Channel',
                'description' => 'Select the channel you want to use.'
            ],
            'successMessage' => [
                'title' => 'Custom Success Message',
                'description' => 'Set a custom message if you want.'
            ],
            'redirectTo' => [
                'title' => 'Redirect to:',
                'description' => 'Choose a page to redirect to, or none.'
            ]
        ],

        'onSend' => [
            'success' => 'Thank you for your message!',
            'error' => [
                'email' => [
                    'email' => 'Invalid email address, please provide a valid email'
                ],
                'message' => [
                    'required' => 'You need to write something to help us understand your needs.'
                ]
            ]
        ]
    ],

    'backend' => [
        'feedback' => [
            'archive' => [
                'bulkSuccess' => 'Your feedbacks were archived',
                'success' => 'Your feedback was archived'
            ]
        ],
        'settings' => [
            'channel' => [
                'emailDestinationComment' => 'The address to send the feedback. Use comma (,) to add more than 1 address. Leave it blank to use the admin\'s address',
                'preventSaveDatabase' => 'DO NOT save feedback on database',
                'warning' => 'Warning! This configuration will have no action!'
            ]
        ]
    ],

    'channel' => [
        'name' => 'Name',
        'code' => 'Code',
        'method' => 'Method',
        'emailDestination' => 'Email destination'
    ],
    'feedback' => [
        'name' => 'Name',
        'email' => 'Email',
        'message' => 'Message'
    ],

    'mail_template' => [
        'description' => 'The feedback message to be sent to the email registered.'
    ],

    'permissions' => [
        'feedback' => [
            'manage' => 'Manage feedbacks'
        ],
        'settings' => [
            'channel' => 'Manage feedback channels'
        ]
    ]
];