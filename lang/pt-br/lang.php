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

            'actionAfterSend' => [
                'title' => 'Ação após enviar',
                'description' => 'A ação logo após que o usuário envia uma mensagem.',
                'options' => [
                    'redirect' => 'Redirecionar',
                    'javascript_alert' => 'Alerta Javascript (usando a função alert)',
                    'custom_javascript' => 'Javascript customizado'
                ],
                'groupName' => 'Ações após enviar'
            ],
            'actionAfterSendRedirect' => [
                'title' => 'Redirecionar o usuário para:',
                'description' => 'A URL para onde o usuário deve ser redirecionado. Essa opção não funciona com "named routing"'
            ],
            'actionAfterSendAlert' => [
                'title' => 'Mensagem do "alert"',
                'description' => 'A mensagem que irá aparecer para o usuário. Esta é a maneira mais simples (e feia) de exibir a mensagem ao usuário.'
            ],
            'actionAfterSendCustomJs' => [
                'title' => 'Javascript customizado',
                'description' => 'Use esta opção para executar uma função feita com javascript.'
            ],

            'actionOnError' => [
                'title' => 'Ação de erro',
                'description' => 'Ação quando acontece um erro.',
                'options' => [
                    'javascript_alert' => 'Alerta Javascript (usando a função alert)',
                    'custom_javascript' => 'Javascript customizado'
                ],
                'groupName' => 'Ações após um erro'
            ],
            'actionOnErrorCustomJs' => [
                'title' => 'Javascript customizado',
                'description' => 'Use esta opção para executar uma função feita com javascript. A variável "messages" está disponível e é um array de mensagem.'
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
                'emailDestinationComment' => 'O endereço de email que receberá a mensagem. Deixe em branco caso queira usar o email do administrador.',
                'preventSaveDatabase' => 'NÃO usar o banco de dados para armazenar as mensagens',
                'warning' => 'Atenção! Essa configuração não tera nenhuma ação!'
            ]
        ]
    ],

    'channel' => [
        'name' => 'Nome',
        'code' => 'Código',
        'method' => 'Método',
        'emailDestination' => 'Email de destino',
        'firebasePath' => 'Firebase Path',
    ],
    'feedback' => [
        'name' => 'Nome',
        'email' => 'Email',
        'message' => 'Mensagem'
    ],

    'mail_template' => [
        'description' => 'A mensagem que será enviada para o endereço de email selecionado.'
    ]
];