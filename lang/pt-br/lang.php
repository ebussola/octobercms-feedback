<?php


return [
    'component' => [
        'feedback' => [
            'name' => 'Feedback',
            'description' => 'Escute o que seus usuários têm a dizer, receba mensagens e melhore seu site.',

            'channelCode' => [
                'title' => 'Canal',
                'description' => 'Selecione o canal que você deseja usar.'
            ],
            'successMessage' => [
                'title' => 'Mensagem de sucesso customizada',
                'description' => 'Escreva uma mensagem de sucesso, ou deixe em branco para usar o padrão'
            ],
            'redirectTo' => [
                'title' => 'Redirecionar para:',
                'description' => 'Escolha uma página para redirecionar.'
            ]
        ],

        'onSend' => [
            'success' => 'Obrigado pela mensagem!',
            'error' => [
                'email' => [
                    'email' => 'Email inválido, por favor, insira um email válido.'
                ],
                'message' => [
                    'required' => 'Você precisa escrever algo para que nos ajude a entender seu problema.'
                ]
            ]
        ]
    ],

    'backend' => [
        'feedback' => [
            'archive' => [
                'bulkSuccess' => 'Seus feedbacks foram arquivados',
                'success' => 'Seu feedback foi arquivado'
            ]
        ],
        'settings' => [
            'channel' => [
                'emailDestinationComment' => 'O endereço de email que receberá a mensagem. Use vírgula para cadastrar mais de um endereço de email. Deixe em branco caso queira usar o email do administrador.',
                'preventSaveDatabase' => 'NÃO usar o banco de dados para armazenar as mensagens',
                'warning' => 'Atenção! Essa configuração não tera nenhuma ação!'
            ]
        ]
    ],

    'channel' => [
        'name' => 'Nome',
        'code' => 'Código',
        'method' => 'Método',
        'emailDestination' => 'Email de destino'
    ],
    'feedback' => [
        'name' => 'Nome',
        'email' => 'Email',
        'message' => 'Mensagem'
    ],

    'mail_template' => [
        'description' => 'A mensagem que será enviada para o endereço de email selecionado.'
    ],

    'permissions' => [
        'feedback' => [
            'manage' => 'Gerenciar feedbacks'
        ],
        'settings' => [
            'channel' => 'Gerenciar canais do Feedback'
        ]
    ]
];