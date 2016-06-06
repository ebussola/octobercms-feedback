<?php

return [
    'plugin' => [
        'name' => 'Feedback',
        'description' => 'Um componente de feedback fácil de usar.'
    ],

    'component' => [
        'feedback' => [
            'name' => 'Feedback',
            'description' => 'Adiciona um formulário de feedback em sua página',

            'channelCode' => [
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
                ]
            ]
        ]
    ],

    'navigation' => [
        'menu' => [
            'side' => [
                'feedbacks' => 'Inbox',
                'archived' => 'Arquivo'
            ],
            'settings' => [
                'channels' => [
                    'description' => 'Gerenciar canais'
                ]
            ]
        ],
        'channels' => [
            'list_title' => 'Lista de canais',
            'return_to_list' => 'Voltar a lista de canais'
        ],
        'feedbacks' => [
            'list_title' => 'Lista de Feedbacks',
            'archived_title' => 'Feedbacks arquivados',
            'return_to_list' => 'Voltar a lista de Feedbacks'
        ]
    ],

    'backend' => [
        'feedback' => [
            'archive' => [
                'bulkSuccess' => 'Seus Feedbacks foram arquivados',
                'success' => 'Seu Feedback foi arquivado'
            ]
        ],
    ],

    'channel' => [
        'one' => 'Canal',
        'many' => 'Canais',

        'action' => [
            'create' => 'Criar canal',
            'update' => 'Editar canal',
            'preview' => 'Pré-visualizar canal',
            'creating' => 'Criando canal...',
            'saving' => 'Salvando canal...',
            'delete_confirm' => 'Deseja realmente deletar este canal?',
            'deleting' => 'Deletando canal...'
        ],

        'name' => 'Nome',
        'code' => 'Código',
        'method' => 'Método',
        'prevent_save_database' => 'Não salvar os Feedbacks no banco de dados',
        'no_action_warning' => 'Cuidado! Esta configuração não possui nenhuma ação.'
    ],

    'method' => [
        'email' => [
            'destination' => 'Email de destino',
            'destination_comment' => 'Um endereço para enviar o Feedback. Use vírgula (,) para adicionar mais de 1 endereço. Deixe em branco para utilizar o endereço do Administrador.',
            'subject' => 'Assunto',
            'template' => 'Template',
            'template_comment' => 'As variáveis disponíveis aqui são as mesmas do formulário'
        ],
        'group' => [
            'channels_comment' => 'Selecione um ou mais canais'
        ]
    ],

    'feedback' => [
        'one' => 'Feedback',
        'many' => 'Feedbacks',

        'action' => [
            'archive' => 'Arquivar',
            'preview' => 'Prever Feedback'
        ],

        'name' => 'Nome',
        'email' => 'Email',
        'message' => 'Mensagem',
        'created_at' => 'Criado em'
    ],

    'mail_template' => [
        'description' => 'O template é usado para enviar as mensagens de um formulário de Feedback'
    ],

    'permissions' => [
        'feedback' => [
            'manage' => 'Gerenciar Feedbacks'
        ],
        'settings' => [
            'channel' => 'Gerenciar canais de Feedback'
        ]
    ]
];