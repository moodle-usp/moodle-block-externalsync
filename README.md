# externalsync

Lista de pendências:

- Ler o arquivo csv e transformar em uma estrutura de array (ele é lido como string)
- Trocar $_FILES por optional_param
- Ler a data de start e end que estão em dd/mm/yyyy para timestamp e usar no $newcourse->startdate e $newcourse->enddate
- Fazer tudo que fizemos para cursos (botão upload, processar csv, e criar users no moodle) só que para usuários (data/users.csv) - falta encontrar as funções de criar usuário na api do moodle
- Criação de tabelas:
    
  externalsync_courses
  
    course_moodle_id
    course_external_id
    sync_date
    log

  externalsync_users:
   
    user_moodle_id
    user_external_id
    sync_date
    log
   
  externalsync_users_courses:

    user_id
    course_id
    sync_date
    log

- No foreach que cria os cursos, resgistrar informações de sincronização nas tabelas:
externalsync_courses, externalsync_users e externalsync_users_courses

Conversar com o Leônidas:

- Qual critério para automatizar a criação das categorias
