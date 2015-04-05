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

            'actionAfterSend' => [
                'title' => 'Action after send',
                'description' => 'The action after the user send the feedback.',
                'options' => [
                    'redirect' => 'Redirect',
                    'javascript_alert' => 'Javascript Alert',
                    'custom_javascript' => 'Custom Javascript'
                ],
                'groupName' => 'After send actions'
            ],
            'actionAfterSendRedirect' => [
                'title' => 'Redirect To',
                'description' => 'The URL to redirect. Don\'t work with named routing'
            ],
            'actionAfterSendAlert' => [
                'title' => 'Alert message',
                'description' => 'The message to be displayed to the user, it is the simplest (and ugliest) way to display the message to user'
            ],
            'actionAfterSendCustomJs' => [
                'title' => 'Custom Javascript',
                'description' => 'Use this option to execute a function made with javascript.'
            ],

            'actionOnError' => [
                'title' => 'Action on Error',
                'description' => 'The action after an error occurs.',
                'options' => [
                    'javascript_alert' => 'Javascript Alert',
                    'custom_javascript' => 'Custom Javascript'
                ],
                'groupName' => 'After on Error'
            ],
            'actionOnErrorCustomJs' => [
                'title' => 'Custom Javascript',
                'description' => 'Use this option to execute a function made with javascript. The variable "messages" - array of message - is available.'
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
                'emailDestinationComment' => 'The address to send the feedback. Leave it blank to use the admin\'s address',
                'preventSaveDatabase' => 'DO NOT save feedback on database',
                'warning' => 'Warning! This configuration will have no action!'
            ]
        ]
    ],

    'channel' => [
        'name' => 'Name',
        'code' => 'Code',
        'method' => 'Method',
        'emailDestination' => 'Email destination',
        'firebasePath' => 'Firebase Path',
    ],
    'feedback' => [
        'name' => 'Name',
        'email' => 'Email',
        'message' => 'Message'
    ],

    'mail_template' => [
        'description' => 'The feedback message to be sent to the email registered.'
    ]
];