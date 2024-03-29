module.exports = {
  headerName: 'Game',
  headerContents: ['about', 'start game', 'contact'],
  noticeData: [
    { title: '「event」ページを更新しました。', date: '2020/09/24 10:00' },
    { title: '「event」ページを作成しました。', date: '2020/09/23 10:00' },
    { title: 'ポータルサイトを作成しました。', date: '2020/09/22 10:00' }
  ],
  authEndpoint: {
    AUTH_LOGIN: '/api/v1/admin/auth/login',
    AUTH_LOGOUT: '/api/v1/admin/auth/logout',
    AUTH_SELF: '/api/v1/admin/auth/self'
  },
  endpoint: {
    authinfo: {
      authInfomation: '/api/v1/admin/authinfo'
    },
    members: {
      members: '/api/v1/admin/members',
      csv: '/api/v1/admin/members/csv',
      member: '/api/v1/admin/members/member/:id',
      create: '/api/v1/admin/members/member',
      roles: '/api/v1/admin/roles/list'
    },
    roles: {
      roles: '/api/v1/admin/roles',
      csv: '/api/v1/admin/roles/csv',
      role: '/api/v1/admin/roles/role/:id',
      create: '/api/v1/admin/roles/role',
      delete: '/api/v1/admin/roles/role',
      permissions: '/api/v1/admin/permissions/list'
    },
    game: {
      characters: {
        characters: '/api/v1/admin/game/characters',
        character: '/api/v1/admin/game/characters/character/:id',
        template: '/api/v1/admin/game/characters/file/template',
        csv: '/api/v1/admin/game/characters/csv',
        create: '/api/v1/admin/game/characters/character',
        delete: '/api/v1/admin/game/characters/character'
      },
      enemies: {
        enemies: '/api/v1/admin/game/enemies',
        enemy: '/api/v1/admin/game/enemies/enemy/:id',
        template: '/api/v1/admin/game/enemies/file/template',
        csv: '/api/v1/admin/game/enemies/file/csv',
        create: '/api/v1/admin/game/enemies/enemy',
        delete: '/api/v1/admin/game/enemies/enemy'
      }
    }
  },
  headerMenuContents: [
    {
      label: 'File',
      icon: 'pi pi-fw pi-file',
      command: (event: any) =>
        console.log('click command', JSON.stringify(event, null, 2)),
      items: [
        {
          label: 'New',
          icon: 'pi pi-fw pi-plus',
          visible: true,
          command: (event: any) =>
            console.log('click child command', JSON.stringify(event, null, 2)),
          items: [
            {
              label: 'Bookmark',
              icon: 'pi pi-fw pi-bookmark'
            },
            {
              label: 'Video',
              icon: 'pi pi-fw pi-video'
            }
          ]
        },
        {
          label: 'Delete',
          icon: 'pi pi-fw pi-trash'
        },
        {
          separator: true
        },
        {
          label: 'Export',
          icon: 'pi pi-fw pi-external-link'
        }
      ]
    },
    {
      label: 'Edit',
      icon: 'pi pi-fw pi-pencil',
      items: [
        {
          label: 'Left',
          icon: 'pi pi-fw pi-align-left'
        },
        {
          label: 'Right',
          icon: 'pi pi-fw pi-align-right'
        },
        {
          label: 'Center',
          icon: 'pi pi-fw pi-align-center'
        },
        {
          label: 'Justify',
          icon: 'pi pi-fw pi-align-justify'
        }
      ]
    },
    {
      label: 'Users',
      icon: 'pi pi-fw pi-user',
      items: [
        {
          label: 'New',
          icon: 'pi pi-fw pi-user-plus'
        },
        {
          label: 'Delete',
          icon: 'pi pi-fw pi-user-minus'
        },
        {
          label: 'Search',
          icon: 'pi pi-fw pi-users',
          items: [
            {
              label: 'Filter',
              icon: 'pi pi-fw pi-filter',
              items: [
                {
                  label: 'Print',
                  icon: 'pi pi-fw pi-print'
                }
              ]
            },
            {
              icon: 'pi pi-fw pi-bars',
              label: 'List'
            }
          ]
        }
      ]
    },
    {
      label: 'Events',
      icon: 'pi pi-fw pi-calendar',
      items: [
        {
          label: 'Edit',
          icon: 'pi pi-fw pi-pencil',
          items: [
            {
              label: 'Save',
              icon: 'pi pi-fw pi-calendar-plus'
            },
            {
              label: 'Delete',
              icon: 'pi pi-fw pi-calendar-minus'
            }
          ]
        },
        {
          label: 'Archieve',
          icon: 'pi pi-fw pi-calendar-times',
          items: [
            {
              label: 'Remove',
              icon: 'pi pi-fw pi-calendar-minus'
            }
          ]
        }
      ]
    },
    {
      label: 'Quit',
      icon: 'pi pi-fw pi-power-off'
    }
  ],
  sideBarContents: [
    {
      label: 'ホーム',
      icon: 'pi pi-fw pi-home',
      items: [
        {
          label: '管理者ログ',
          icon: 'pi pi-fw pi-file',
          to: '/test'
        },
        {
          separator: true
        }
      ]
    },
    /* {
      label: 'ログインユーザー情報',
      icon: 'pi pi-fw pi-pencil',
      items: [
        {
          label: 'ユーザー情報',
          icon: 'pi pi-fw pi-user',
          to: '/authuser'
        },
        {
          separator: true
        }
      ]
    }, */
    {
      label: '管理者情報',
      icon: 'pi pi-fw pi-pencil',
      items: [
        {
          label: '管理者情報管理',
          icon: 'pi pi-fw pi-users',
          to: '/members'
        },
        {
          separator: true
        }
      ]
    },
    {
      label: '権限情報',
      icon: 'pi pi-fw pi-pencil',
      items: [
        {
          label: 'ロール管理',
          icon: 'pi pi-fw pi-table',
          to: '/roles'
        },
        {
          separator: true
        }
      ]
    },
    /* {
      label: 'アビリティ',
      icon: 'pi pi-fw pi-pencil',
      items: [
        {
          label: 'アビリティ管理',
          icon: 'pi pi-fw pi-pencil',
          to: '/test'
        },
        {
          separator: true
        }
      ]
    },
    {
      label: 'エリア',
      icon: 'pi pi-fw pi-pencil',
      items: [
        {
          label: 'エリア管理',
          icon: 'pi pi-fw pi-images',
          to: '/test'
        },
        {
          separator: true
        }
      ]
    },
    {
      label: '装備',
      icon: 'pi pi-fw pi-pencil',
      items: [
        {
          label: '装備管理',
          icon: 'pi pi-fw pi-pencil',
          to: '/test'
        },
        {
          separator: true
        }
      ]
    },
    {
      label: '称号',
      icon: 'pi pi-fw pi-pencil',
      items: [
        {
          label: '称号管理',
          icon: 'pi pi-fw pi-table',
          to: '/test'
        },
        {
          separator: true
        }
      ]
    }, */
    {
      label: 'キャラクター',
      icon: 'pi pi-fw pi-pencil',
      items: [
        /* {
          label: 'キャラクター管理',
          icon: 'pi pi-fw pi-user',
          to: '/game/characters'
        }, */
        {
          label: '敵キャラクター',
          icon: 'pi pi-fw pi-user',
          to: '/game/enemies'
        },
        {
          separator: true
        }
      ]
    } /* ,
    {
      label: 'エネミー',
      icon: 'pi pi-fw pi-pencil',
      items: [
        {
          label: 'エネミー管理',
          icon: 'pi pi-fw pi-android',
          to: '/test'
        }
      ]
    } */
  ]
}
