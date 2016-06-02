<?php

return [
    'plugin' => [
        'name' => 'Feedback',
        'description' => 'An easy feedback component for your site'
    ],

    'component' => [
        'feedback' => [
            'name' => 'Feedback',
            'description' => 'Adds a feedback form to your page',

            'channelCode' => [
                'description' => 'Select the channel you want to use with this form'
            ],
            'successMessage' => [
                'title' => 'Custom success message',
                'description' => 'You can specify a custom message that will be shown to a user after successful form submit'
            ],
            'redirectTo' => [
                'title' => 'Redirect to',
                'description' => 'You can choose a page to redirect to after successful form submit'
            ]
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

    'navigation' => [
        'menu' => [
            'side' => [
                'feedbacks' => 'Inbox',
                'archived' => 'Archived'
            ],
            'settings' => [
                'channels' => [
                    'description' => 'Manage channels'
                ]
            ]
        ],
        'channels' => [
            'list_title' => 'Channels list',
            'return_to_list' => 'Return to channels list'
        ],
        'feedbacks' => [
            'list_title' => 'Feedbacks list',
            'archived_title' => 'Archived feedbacks',
            'return_to_list' => 'Return to feedbacks list'
        ]
    ],

    'backend' => [
        'feedback' => [
            'archive' => [
                'bulkSuccess' => 'Your feedbacks were archived',
                'success' => 'Your feedback was archived'
            ]
        ],
    ],

    'channel' => [
        'one' => 'Channel',
        'many' => 'Channels',

        'action' => [
            'create' => 'Create channel',
            'update' => 'Edit channel',
            'preview' => 'Preview channel',
            'creating' => 'Creating channel...',
            'saving' => 'Saving channel...',
            'delete_confirm' => 'Do you really want to delete this channel?',
            'deleting' => 'Deleting channel...'
        ],

        'name' => 'Name',
        'code' => 'Code',
        'method' => 'Method',
        'prevent_save_database' => 'Do not save feedbacks in a database',
        'no_action_warning' => 'Warning! This configuration have no action: you will not recive any feedback messages'
    ],

    'method' => [
        'email' => [
            'destination' => 'Email destination',
            'destination_comment' => 'An address where to send the feedback. Use comma (,) to add more than 1 address. Leave it blank to use the admin\'s address',
            'subject' => 'Subject',
            'template' => 'Template',
            'template_comment' => 'The variables available here are these on the form'
        ],
        'group' => [
            'channels_comment' => 'Select one or more channels'
        ]
    ],

    'feedback' => [
        'one' => 'Feedback',
        'many' => 'Feedbacks',

        'action' => [
            'archive' => 'Archive',
            'preview' => 'Preview feedback'
        ],

        'name' => 'Name',
        'email' => 'Email',
        'message' => 'Message',
        'created_at' => 'Created at'
    ],

    'mail_template' => [
        'description' => 'The template is used to send messages from the feedback form'
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
