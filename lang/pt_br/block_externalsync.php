<?php

defined('MOODLE_INTERNAL') || die();

// principal
$string['pluginname']               = 'Sincronização Externa';
$string['main_msg']                 = 'Aqui você pode subir seus cursos e usuários através de arquivos CSV.';

// tipos
$string['type_courses']             = 'cursos';
$string['type_users']               = 'usuários';

// formulários
$string['form_uploadTitle']         = 'Enviar arquivos';
$string['form_description']         = 'Descrição';
$string['form_type']                = 'Tipo';
$string['form_replace']             = 'Substituir os dados se já existirem.';
$string['form_csvFile']             = 'Arquivo CSV';

// erros
$string['error_emptyData']          = 'Dados vazios. Por favor, tente novamente.';
$string['error_invalidFile']        = 'Arquivo enviado inválido. Por favor, verifique se você escolheu o tipo correto.';
$string['error_onUploading']        = 'Erro no envio dos dados!<br>Por favor, tente novamente.';
$string['error_courseDoesntExist']  = "O curso {$a} não existe na base.";

// confirmação de dados
$string['dataConfirmation_msg']     = 'Confirme os dados que você quer enviar.';

// dados criados
$string['createdData_errorTitle']   = 'Erros';
$string['createdData_errorMsg']     = 'Esses {$a} já estão na base.';
$string['createdData_updatedTitle'] = 'Atualizados';
$string['createdData_updatedMsg']   = 'Esses {$a} foram atualizados com sucesso.';
$string['createdData_createdTitle'] = 'Criados';
$string['createdData_createdMsg']   = 'Esses {$a} foram criados com sucesso.';

// botoes
$string['button_upload']            = 'Enviar';
$string['button_confirm']           = 'Confirmar';
$string['button_return']            = 'Voltar';

// tabelas
$string['table_title']              = 'Tabela {$a->tableName}';