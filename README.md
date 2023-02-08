# ExternalSync

A criação de usuários e de cursos já está funcionando. Os usuários podem ser inscritos diretamente em cursos, mas a definição dos papéis ainda não funciona corretamente.

Os cursos que já estiverem na base de dados são exibidos como "erro" e os que forem criados são exibidos como "sucesso".

Os usuários que já estiverem no sistema terão seus dados atualizados. Essa é a melhor saída? Penso em adicionar uma etapa a mais, questionando se é desejado fazer isso. Por agora, está sendo feito diretamente.

## Pendências:
- [X] Forms para cursos e usuários;
- [X] Transformar CSV em array;
- [ ] Criação de cursos:
  - [X] Criação dos que ainda não estão na base;
  - [X] Tratamento de erro dos que já estão;
  - [ ] Categorias;
- [X] Criação de usuários;
- [X] Tabelas próprias na base de dados:
  - [X] **externalsync_courses** (course_moodle_id, course_external_id, sync_date, log);
  - [X] **externalsync_users** (user_moodle_id, user_external_id, sync_date, log);
  - [X] **externalsync_users_courses** (user_id, course_id, sync_date, log);
- [?] Sincronização;
- [ ] Uso correto de strings para a questão de idiomas.