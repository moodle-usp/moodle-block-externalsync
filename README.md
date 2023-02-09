# ExternalSync

A criação de usuários e de cursos já está funcionando. Os usuários podem ser inscritos diretamente em cursos, mas a definição dos papéis ainda não funciona corretamente.

Agora, os cursos e usuários que já estiverem na base de dados podem ou não ter suas informações substituídas, a depender de um checbox adicionado na página de envio. Se estiver marcado então os cursos ou usuários repetidos serão substituídos, e se não apenas entrarão como erro.

## Pendências:
- [X] Forms para cursos e usuários;
- [X] Transformar CSV em array;
- [ ] Criação de cursos:
  - [X] Criação dos que ainda não estão na base;
  - [X] Atualização ou não dos que já estão;
  - [ ] Categorias;
- [X] Criação de usuários:
  - [X] Criação dos que ainda não estão na base;
  - [X] Atualização ou não dos que já estão;
- [X] Tabelas próprias na base de dados:
  - [X] **externalsync_courses** (course_moodle_id, course_external_id, sync_date, log);
  - [X] **externalsync_users** (user_moodle_id, user_external_id, sync_date, log);
  - [X] **externalsync_users_courses** (user_id, course_id, sync_date, log);
- [?] Sincronização;
- [ ] Uso correto de strings para a questão de idiomas.