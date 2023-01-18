# ExternalSync

Por enquanto, é possível subir arquivos CSV de cursos e de usuários.

A parte de usuários não está funcionando ainda, mas a de cursos já está. Os cursos que já estiverem na base de dados são exibidos como "erro" e os que forem criados são exibidos como "sucesso".

## Pendências:
- [X] Forms para cursos e usuários;
- [X] Transformar CSV em array;
- [ ] Criação de cursos:
  - [X] Criação dos que ainda não estão na base;
  - [X] Tratamento de erro dos que já estão;
  - [ ] Categorias;
- [ ] Criação de usuários;
- [ ] Tabelas próprias na base de dados:
  - [ ] **externalsync_courses** (course_moodle_id, course_external_id, sync_date, log);
  - [ ] **externalsync_users** (user_moodle_id, user_external_id, sync_date, log);
  - [ ] **externalsync_users_courses** (user_id, course_id, sync_date, log);
- [ ] Sincronização;
- [ ] Uso correto de strings para a questão de idiomas.