<?php
if (!defined('_REM_INTERNAL')) DEFINE('_REM_INTERNAL','Erro interno');
if (!defined('_DOWNLOADS_TITLE')) DEFINE("_DOWNLOADS_TITLE","Centro de Downloads");
if (!defined('_UP_FILE')) DEFINE('_UP_FILE','Enviar ficheiro');
if (!defined('_ADD_FILE_BUTTON')) DEFINE('_ADD_FILE_BUTTON','Adicionar ficheiro');
if (!defined('_SUBMIT_FILE_BUTTON')) DEFINE('_SUBMIT_FILE_BUTTON','Enviar ficheiro');
if (!defined('_SUBMIT_FILE_NOLOG')) DEFINE('_SUBMIT_FILE_NOLOG', 'Envio de ficheiros - tem de fazer login');
if (!defined('_SUBMIT_FILE_NOUSER')) DEFINE('_SUBMIT_FILE_NOUSER', 'Envio de ficheiros - só administradores');
if (!defined('_SUBMIT_FILE_NOLIMIT')) DEFINE('_SUBMIT_FILE_NOLIMIT', 'Envio de ficheiros - limite atingido');
if (!defined('_SUBMIT_FILE_NOSPACE')) DEFINE('_SUBMIT_FILE_NOSPACE', 'Envio de ficheiros - sem espaço disponível');
if (!defined('_SUBMIT_NO_DDIR')) DEFINE('_SUBMIT_NO_DDIR', 'Envio de ficheiros - sem directório de uploads');
if (!defined('_SUBMIT_NO_UDDIR')) DEFINE('_SUBMIT_NO_UDDIR', 'Envio de ficheiros - sem directório de up/downloads');
if (!defined('_SUBMIT_HEADING')) DEFINE('_SUBMIT_HEADING', 'Enviar ficheiro para Centro de Downloads');
if (!defined('_SUBMIT_INSTRUCT1')) DEFINE('_SUBMIT_INSTRUCT1', 'Para enviar um ficheiro, seleccione-o na caixa abaixo...');
if (!defined('_SUBMIT_INSTRUCT2')) DEFINE('_SUBMIT_INSTRUCT2', '...se o ficheiro estiver alojado noutro servidor indique a sua URL e o resto dos detalhes.');
if (!defined('_SUBMIT_INSTRUCT3')) DEFINE('_SUBMIT_INSTRUCT3', 'Escolha o ficheiro para ser enviado e indique o resto dos detalhes relevantes.');
if (!defined('_DOWN_FILE_SUBMIT_NOCHOICES')) DEFINE('_DOWN_FILE_SUBMIT_NOCHOICES','You have no permitted upload categories');
if (!defined('_SUBMIT_NEW_FILE')) DEFINE('_SUBMIT_NEW_FILE', 'Novo ficheiro');
if (!defined('_SUBMIT_UPLOAD_BUTTON')) DEFINE('_SUBMIT_UPLOAD_BUTTON', 'Enviar ficheiro');
if (!defined('_MAIN_DOWNLOADS')) DEFINE('_MAIN_DOWNLOADS','Centro de Downloads');
if (!defined('_BACK_CAT')) DEFINE('_BACK_CAT','Voltar à categoria superior');
if (!defined('_BACK_FOLDER')) DEFINE('_BACK_FOLDER','Voltar à pasta superior');
if (!defined('_DOWN_START')) DEFINE('_DOWN_START','O download irá começar dentro de 2 segundos');
if (!defined('_DOWN_CLICK')) DEFINE('_DOWN_CLICK','Clique aqui se o download não começar sozinho');
if (!defined('_INVALID_ID')) DEFINE('_INVALID_ID','ID inválida');
if (!defined('_DOWN_CATEGORY')) DEFINE('_DOWN_CATEGORY','Categoria');
if (!defined('_DOWN_NO_PARENT')) DEFINE('_DOWN_NO_PARENT','Início **');
if (!defined('_DOWN_FOLDER')) DEFINE('_DOWN_FOLDER','Pasta');
if (!defined('_DOWN_FOLDERS')) DEFINE('_DOWN_FOLDERS','Pastas');
if (!defined('_DOWN_FILES')) DEFINE('_DOWN_FILES','Ficheiros');
if (!defined('_DOWN_FOLDERS_FILES')) DEFINE('_DOWN_FOLDERS_FILES','Pastas/Ficheiros');
if (!defined('_DOWN_NO_CATS')) DEFINE("_DOWN_NO_CATS","O Centro de Downloads ainda não foi configurado para o <i>$mosConfig_sitename</i>.<br/>&nbsp;<br/>Não foram definidas categorias.");
if (!defined('_DOWN_NO_VISITOR_CATS')) DEFINE('_DOWN_NO_VISITOR_CATS','Desculpe, o Centro de Downloads não está disponível para visitantes casuais - faça o seu login');
if (!defined('_DOWN_ADMIN_FUNC')) DEFINE('_DOWN_ADMIN_FUNC','Funções Administrativas:');
if (!defined('_DOWN_ADD_CAT')) DEFINE('_DOWN_ADD_CAT','Adicionar categoria');
if (!defined('_DOWN_DEL_CAT')) DEFINE('_DOWN_DEL_CAT','Apagar categoria');
if (!defined('_DOWN_EDIT_CAT')) DEFINE('_DOWN_EDIT_CAT','Editar categoria');
if (!defined('_DOWN_UP_NEITHER')) DEFINE('_DOWN_UP_NEITHER','Nenhum');
if (!defined('_DOWN_UP_DOWNLOAD_ONLY')) DEFINE('_DOWN_UP_DOWNLOAD_ONLY','Só descarregar ficheiros');
if (!defined('_DOWN_UP_UPLOAD_ONLY')) DEFINE('_DOWN_UP_UPLOAD_ONLY','Só carregar ficheiros');
if (!defined('_DOWN_UP_BOTH')) DEFINE('_DOWN_UP_BOTH','Ambos');
if (!defined('_DOWN_USERS_PERMITTED')) DEFINE('_DOWN_USERS_PERMITTED','Os membros podem:');
if (!defined('_DOWN_VISITORS_PERMITTED')) DEFINE('_DOWN_VISITORS_PERMITTED','Os visitantes podem:');
if (!defined('_DOWN_UP_ABSOLUTE_PATH')) DEFINE('_DOWN_UP_ABSOLUTE_PATH','Caminho absoluto (opcional):');
if (!defined('_DOWN_ADD_FOLDER')) DEFINE('_DOWN_ADD_FOLDER','Adicionar pasta');
if (!defined('_DOWN_DEL_FOLDER')) DEFINE('_DOWN_DEL_FOLDER','Apagar pasta');
if (!defined('_DOWN_EDIT_FOLDER')) DEFINE('_DOWN_EDIT_FOLDER','Editar pasta');
if (!defined('_DOWN_ADD_FILE')) DEFINE('_DOWN_ADD_FILE','Adicionar ficheiro');
if (!defined('_DOWN_DEL_FILE')) DEFINE('_DOWN_DEL_FILE','Apagar ficheiro');
if (!defined('_DOWN_EDIT_FILE')) DEFINE('_DOWN_EDIT_FILE','Editar ficheiro');
if (!defined('_DOWN_PUB')) DEFINE('_DOWN_PUB','Publicado:');
if (!defined('_DOWN_SUBMIT_ANOTHER')) DEFINE('_DOWN_SUBMIT_ANOTHER','Enviar outro ficheiro?');
if (!defined('_DOWN_SUBMIT_INSPECT')) DEFINE('_DOWN_SUBMIT_INSPECT','Ver o ficheiro acabado de enviar?');
if (!defined('_YES')) DEFINE('_YES','Sim');
if (!defined('_NO')) DEFINE('_NO','Não');
if (!defined('_GLOBAL')) DEFINE('_GLOBAL','Global');
if (!defined('_DOWN_KEYWORDS')) DEFINE('_DOWN_KEYWORDS', 'Keywords:');
if (!defined('_DOWN_WINDOW_TITLE')) DEFINE('_DOWN_WINDOW_TITLE','Window Title:');
if (!defined('_DOWN_EDITOR_GROUP')) DEFINE('_DOWN_EDITOR_GROUP','Editor Group:');
if (!defined('_DOWN_AUTO_FOR_ADMIN')) DEFINE('_DOWN_AUTO_FOR_ADMIN','Auto-approve for Admin:');
if (!defined('_DOWN_AUTO_FOR_USERS')) DEFINE('_DOWN_AUTO_FOR_USERS','Auto-approve for Users:');
if (!defined('_DOWN_AUTO_USER_GROUP')) DEFINE('_DOWN_AUTO_USER_GROUP','Auto-approve user group:');
if (!defined('_DOWN_CONTAINER_CASCADE')) DEFINE('_DOWN_CONTAINER_CASCADE','Apply to all child folders:');
if (!defined('_DOWN_THANK_YOU')) DEFINE('_DOWN_THANK_YOU','Thank you for downloading ');
if (!defined('_DOWN_WAIT_OR_CLICK')) DEFINE('_DOWN_WAIT_OR_CLICK','If your download does not start automatically after a few seconds, please click on the Download link below');
if (!defined('_DOWN_UPDATE_THUMBNAILS')) DEFINE('_DOWN_UPDATE_THUMBNAILS','Update thumbnails');
if (!defined('_DOWN_DELETE_THUMBNAIL')) DEFINE('_DOWN_DELETE_THUMBNAIL','Delete thumbnail');
if (!defined('_DOWN_SUBMIT_NEW_THUMBNAIL')) DEFINE('_DOWN_SUBMIT_NEW_THUMBNAIL','Submit new thumbnail');
if (!defined('_DOWN_NOT_LOGGED_UPLOAD')) DEFINE('_DOWN_NOT_LOGGED_UPLOAD','Sorry, you are not permitted to upload.  Please sign in or register.');
if (!defined('_DOWN_NOT_LOGGED_COMMENT')) DEFINE('_DOWN_NOT_LOGGED_COMMENT','Sorry, you are not permitted to comment.  Please sign in or register.');
if (!defined('_DOWN_NOT_LOGGED_VOTE')) DEFINE('_DOWN_NOT_LOGGED_VOTE','Sorry, you are not permitted to vote.  Please sign in or register.');
if (!defined('_DOWN_COMMENT_NL')) DEFINE('_DOWN_COMMENT_NL','Please login or register to make your own comment');
if (!defined('_DOWN_DESC')) DEFINE('_DOWN_DESC','Descrição:');
if (!defined('_DOWN_DOWNLOADS')) DEFINE('_DOWN_DOWNLOADS','Downloads:');
if (!defined('_DOWN_RATING')) DEFINE('_DOWN_RATING','Avaliação:');
if (!defined('_DOWN_VOTES')) DEFINE('_DOWN_VOTES','Total de votos:');
if (!defined('_DOWN_YOUR_VOTE')) DEFINE('_DOWN_YOUR_VOTE','O seu voto:');
if (!defined('_DOWN_RATE_BUTTON')) DEFINE('_DOWN_RATE_BUTTON','Avaliar');
if (!defined('_DOWN_ALREADY_VOTE')) DEFINE('_DOWN_ALREADY_VOTE','Já votou neste download. Obrigado.');
if (!defined('_DOWN_FILE_TITLE')) DEFINE('_DOWN_FILE_TITLE','Nome:');
if (!defined('_DOWN_FILE_TITLE_SORT')) DEFINE('_DOWN_FILE_TITLE_SORT','Nome de ficheiro');
if (!defined('_DOWN_REAL_NAME')) DEFINE('_DOWN_REAL_NAME','Nome físico do ficheiro:');
if (!defined('_DOWNLOAD')) DEFINE('_DOWNLOAD','Download');
if (!defined('_DOWN_DOWNLOADS_SORT')) DEFINE('_DOWN_DOWNLOADS_SORT','Downloads');
if (!defined('_DOWN_SUB_BY')) DEFINE('_DOWN_SUB_BY','Colocado por:');
if (!defined('_DOWN_FILE_DATE')) DEFINE('_DOWN_FILE_DATE','Colocado em:');
if (!defined('_DOWN_FILE_AUTHOR')) DEFINE('_DOWN_FILE_AUTHOR','Autor:');
if (!defined('_DOWN_FILE_VER')) DEFINE('_DOWN_FILE_VER','Versão:');
if (!defined('_DOWN_FILE_SIZE')) DEFINE('_DOWN_FILE_SIZE','Tamanho:');
if (!defined('_DOWN_FILE_TYPE')) DEFINE('_DOWN_FILE_TYPE','Tipo:');
if (!defined('_DOWN_FILE_COMPANY')) DEFINE('_DOWN_FILE_COMPANY','Companhia:');
if (!defined('_DOWN_FILE_COMPANY_URL')) DEFINE('_DOWN_FILE_COMPANY_URL','Website da Empresa:');
if (!defined('_DOWN_FILE_AUTHOR_URL')) DEFINE('_DOWN_FILE_AUTHOR_URL','Website do Autor:');
if (!defined('_DOWN_FILE_RELEASE_DATE')) DEFINE('_DOWN_FILE_RELEASE_DATE','Data de lançamento (YYYY-MM-DD):');
if (!defined('_DOWN_FILE_STATUS')) DEFINE('_DOWN_FILE_STATUS','Estado:');
if (!defined('_DOWN_FILE_LANGUAGES')) DEFINE('_DOWN_FILE_LANGUAGES','Línguas:');
if (!defined('_DOWN_FILE_REQUIREMENTS')) DEFINE('_DOWN_FILE_REQUIREMENTS','Requisitos:');
if (!defined('_DOWN_FILE_OPERATING_SYSTEM')) DEFINE('_DOWN_FILE_OPERATING_SYSTEM','Sistema Operativo:');
if (!defined('_DOWN_SCREEN')) DEFINE('_DOWN_SCREEN','Screenshot:');
if (!defined('_DOWN_SCREEN_CLICK')) DEFINE('_DOWN_SCREEN_CLICK','Clique para ver');
if (!defined('_DOWN_NA')) DEFINE('_DOWN_NA','N/D');
if (!defined('_DOWN_CAT_NAME')) DEFINE('_DOWN_CAT_NAME','Nome da categoria:');
if (!defined('_DOWN_SUB_BUTTON')) DEFINE('_DOWN_SUB_BUTTON','Ir');
if (!defined('_DOWN_ALL_DONE')) DEFINE('_DOWN_ALL_DONE','Pronto!');
if (!defined('_DOWN_NOT_AUTH')) DEFINE('_DOWN_NOT_AUTH','Não tem autorização!');
if (!defined('_DOWN_FOLDER_NAME')) DEFINE('_DOWN_FOLDER_NAME','Nome da pasta:');
if (!defined('_DOWN_FOLDER_ADD_BUT')) DEFINE('_DOWN_FOLDER_ADD_BUT','Adicionar pasta');
if (!defined('_DOWN_UP_WAIT')) DEFINE('_DOWN_UP_WAIT','Aviso: Todos os ficheiros serão revistos antes de serem publicados.');
if (!defined('_DOWN_AUTOAPP')) DEFINE('_DOWN_AUTOAPP','O seu ficheiro foi automaticamente aprovado e publicado.');
if (!defined('_DOWN_SUGGEST_LOC')) DEFINE('_DOWN_SUGGEST_LOC','Sugerir localização:');
if (!defined('_DOWNLOAD_URL')) DEFINE('_DOWNLOAD_URL','URL do ficheiro:');
if (!defined('_DOWN_ICON')) DEFINE('_DOWN_ICON','&Iacute;cone:');
if (!defined('_DOWN_MOVE_FILE')) DEFINE('_DOWN_MOVE_FILE','Mover ficheiro:');
if (!defined('_DOWN_FILE_NEW_LOC')) DEFINE('_DOWN_FILE_NEW_LOC','Nova localização para o ficheiro:');
if (!defined('_DOWN_AWAIT_APPROVE')) DEFINE('_DOWN_AWAIT_APPROVE','Ficheiros enviados à espera de aprovação:');
if (!defined('_DOWN_ADMIN_APPROVE')) DEFINE('_DOWN_ADMIN_APPROVE','Aprovar ficheiros');
if (!defined('_DOWN_ID')) DEFINE('_DOWN_ID','ID');
if (!defined('_DOWN_SUBMIT_DATE')) DEFINE('_DOWN_SUBMIT_DATE','Data de envio:');
if (!defined('_DOWN_APP_SUB_BUTTON')) DEFINE('_DOWN_APP_SUB_BUTTON','Aprovar ficheiro');
if (!defined('_DOWN_DEL_SUB_BUTTON')) DEFINE('_DOWN_DEL_SUB_BUTTON','Apagar download');
if (!defined('_DOWN_SUB_APPROVE')) DEFINE('_DOWN_SUB_APPROVE','O ficheiro enviado foi aprovado.');
if (!defined('_DOWN_SUB_DEL')) DEFINE('_DOWN_SUB_DEL','O ficheiro enviado foi apagado.');
if (!defined('_DOWN_NO_SUB')) DEFINE('_DOWN_NO_SUB','Não existem mais ficheiros na lista de espera.');
if (!defined('_DOWN_REV_SUB')) DEFINE('_DOWN_REV_SUB','Analisar mais ficheiros enviados');
if (!defined('_DOWN_SEARCH')) DEFINE('_DOWN_SEARCH','Pesquisar nos downloads');
if (!defined('_DOWN_SEARCH_TEXT')) DEFINE('_DOWN_SEARCH_TEXT','Pesquisar por:');
if (!defined('_DOWN_SEARCH_FILETITLE')) DEFINE('_DOWN_SEARCH_FILETITLE','Pesquisar nos t&iacute;tulos dos ficheiros:');
if (!defined('_DOWN_SEARCH_FILEDESC')) DEFINE('_DOWN_SEARCH_FILEDESC','Pesquisar na descri&ccedil;&atilde;o dos ficheiros:');
if (!defined('_DOWN_SEARCH_ERR')) DEFINE('_DOWN_SEARCH_ERR','Deve indicar se quer pesquisar no nome ou na descrição do ficheiro.');
if (!defined('_DOWN_SEARCH_NORES')) DEFINE('_DOWN_SEARCH_NORES','Não foram encontrados ficheiros.');
if (!defined('_DOWN_FILE_HOMEPAGE')) DEFINE('_DOWN_FILE_HOMEPAGE','Homepage:');
if (!defined('_DOWN_UPDATE_SUB')) DEFINE('_DOWN_UPDATE_SUB','Actualizar download');
if (!defined('_DOWN_UP_EDIT_ID')) DEFINE('_DOWN_UP_EDIT_ID','ID do ficheiro:');
if (!defined('_DOWN_FILE_DEL_NOTE')) DEFINE('_DOWN_FILE_DEL_NOTE','Nota: O ficheiro foi removido da base de dados, mas fisicamente <b>pode</b> ainda existir.');
if (!defined('_DOWN_SUB_DATE')) DEFINE('_DOWN_SUB_DATE','Actualizado em:');
if (!defined('_DOWN_SUB_DATE_SORT')) DEFINE('_DOWN_SUB_DATE_SORT','Data de envio');
if (!defined('_DOWN_COMMENTS')) DEFINE('_DOWN_COMMENTS','Coment&aacute;rios:');
if (!defined('_DOWN_YOUR_COMM')) DEFINE('_DOWN_YOUR_COMM','O seu cont&aacute;rio:');
if (!defined('_DOWN_LEAVE_COMM')) DEFINE('_DOWN_LEAVE_COMM','Comentar');
if (!defined('_DOWN_FIRST_COMMENT')) DEFINE('_DOWN_FIRST_COMMENT','Seja o primeiro a comentar este ficheiro!');
if (!defined('_DOWN_FIRST_COMMENT_NL')) DEFINE('_DOWN_FIRST_COMMENT_NL','Seja o primeiro a comentar!  Faça o login ou registe-se.');
if (!defined('_DOWN_ALREADY_COMM')) DEFINE('_DOWN_ALREADY_COMM','Já comentou este ficheiro.');
if (!defined('_DOWN_MAX_COMM')) DEFINE("_DOWN_MAX_COMM","Máx: $Small_Text_Len letras");
if (!defined('_DOWN_DESC_MAX')) DEFINE("_DOWN_DESC_MAX","Máx: $Large_Text_Len letras");
if (!defined('_DOWN_MAIL_SUB')) DEFINE('_DOWN_MAIL_SUB','Novo download adicionado em $mosConfig_sitename ');
if (!defined('_DOWN_MAIL_MSG')) DEFINE('_DOWN_MAIL_MSG','Olá, um novo ficheiro foi enviado por $user_full'
                   .' para $mosConfig_sitename .\n'
                   .'Por favor vá até $mosConfig_live_site/administrator/index.php como administrador para ver e aprovar este download.\n\n'
                   .'Por favor não responda a esta mensagem já que foi automaticamente gerada e serve apenas para fins informativos\n');
if (!defined('_DOWN_MAIL_MSG_APP')) DEFINE('_DOWN_MAIL_MSG_APP','Olá foi submetido um novo ficheiro na secção de downloads por $user_full'
                   .' para o site $mosConfig_sitename.\n'
                   .'De acordo com as opções de configuração o ficheiro foi automaticamente aprovado.\n\n'
                   .'Por favor não responda a esta mensagem já que é automaticamente gerada e serve apenas para fins informativos\n');
if (!defined('_DOWN_ORDER_BY')) DEFINE('_DOWN_ORDER_BY','Ordenar por :');
if (!defined('_DOWN_RESET')) DEFINE('_DOWN_RESET','Recalcular a contagem dos ficheiros');
if (!defined('_DOWN_RESET_GO')) DEFINE('_DOWN_RESET_GO','Recalculando a contagem de ficheiros...');
if (!defined('_DOWN_RESET_DONE')) DEFINE('_DOWN_RESET_DONE','Cálculo da contagem de ficheiros terminada');
if (!defined('_DOWN_FIND_ORPHANS')) DEFINE('_DOWN_FIND_ORPHANS','Procurar ficheiros orfãos');
if (!defined('_DOWN_DEL_ORPHANS')) DEFINE('_DOWN_DEL_ORPHANS','Apagar ficheiros orfãos');
if (!defined('_DOWN_ORPHAN_SELECT')) DEFINE('_DOWN_ORPHAN_SELECT','Seleccionar');
if (!defined('_DOWN_ORPHAN_FILE_DEL')) DEFINE('_DOWN_ORPHAN_FILE_DEL','Ficheiro para apagar');
if (!defined('_DOWN_ORPHAN_NODEL')) DEFINE('_DOWN_ORPHAN_NODEL','Sem ficheiros para apagar');
if (!defined('_DOWN_ORPHAN_DONE')) DEFINE('_DOWN_ORPHAN_DONE','Ficheiros orfãos apagados');
if (!defined('_DOWN_BAD_POST')) DEFINE('_DOWN_BAD_POST','The settings have not been propely sent from the form.');
if (!defined('_DOWN_SUB_WAIT')) DEFINE('_DOWN_SUB_WAIT','Uma submissão mais recente está já à espera de aprovação para este ficheiro.');
if (!defined('_DOWN_REG_ONLY')) DEFINE('_DOWN_REG_ONLY','Só membros registados:');
if (!defined('_DOWN_MEMBER_ONLY_WARN')) DEFINE('_DOWN_MEMBER_ONLY_WARN',"Esta localização é só para Grupos de Membros.<BR />"
                             ."Please refer to admin concerning group ");
if (!defined('_DOWN_REG_ONLY_WARN')) DEFINE("_DOWN_REG_ONLY_WARN","Este local é só para membros registados.<BR />"
                             ."Por favor faça o login ou <a href='index.php?option=com_registration&task=register'>Registe-se</a>.");
if (!defined('_DOWN_NO_FILEN')) DEFINE('_DOWN_NO_FILEN','Por favor indique um nome para o ficheiro');
if (!defined('_DOWN_MINI_SCREEN_PROMPT')) DEFINE('_DOWN_MINI_SCREEN_PROMPT','Mostrar miniatura na lista de ficheiros:');
if (!defined('_DOWN_SEL_LOC_PROMPT')) DEFINE('_DOWN_SEL_LOC_PROMPT','Seleccionar localização');
if (!defined('_DOWN_ALL_LOC_PROMPT')) DEFINE('_DOWN_ALL_LOC_PROMPT','Todas as localizações');
if (!defined('_DOWN_SEL_CAT_DEL')) DEFINE('_DOWN_SEL_CAT_DEL','Selecicone uma categoria para apagar');
if (!defined('_DOWN_NO_CAT_DEF')) DEFINE('_DOWN_NO_CAT_DEF','Sem categorias definidas');
if (!defined('_DOWN_PUB_PROMPT')) DEFINE('_DOWN_PUB_PROMPT','Seleccione uma categoria para ');
if (!defined('_DOWN_SEL_FILE_DEL')) DEFINE('_DOWN_SEL_FILE_DEL','Seleccione um ficheiro para apagar');
if (!defined('_DOWN_CONFIG_COMP')) DEFINE('_DOWN_CONFIG_COMP','Configuração actualizada!');
if (!defined('_DOWN_CONFIG_ERR')) DEFINE("_DOWN_CONFIG_ERR","Ocorreu um erro!\nNão foi possível abrir o ficheiro de configuração para escrever!");
if (!defined('_DOWN_CATS')) DEFINE('_DOWN_CATS','Categorias');
if (!defined('_DOWN_PARENT_CAT')) DEFINE('_DOWN_PARENT_CAT','Categoria superior');
if (!defined('_DOWN_PARENT_FOLDER')) DEFINE('_DOWN_PARENT_FOLDER','Pasta superior');
if (!defined('_DOWN_PUB1')) DEFINE('_DOWN_PUB1','Publicado');
if (!defined('_DOWN_RECORDS')) DEFINE('_DOWN_RECORDS','Registos');
if (!defined('_DOWN_ACCESS')) DEFINE('_DOWN_ACCESS','Acesso');
if (!defined('_DOWN_GROUP')) DEFINE('_DOWN_GROUP','Grupo');
if (!defined('_DOWN_REG_USERS')) DEFINE('_DOWN_REG_USERS','Membros');
if (!defined('_DOWN_VISITORS')) DEFINE('_DOWN_VISITORS','Visitantes');
if (!defined('_DOWN_ALL_REGISTERED')) DEFINE('_DOWN_ALL_REGISTERED','Todos os Membros Registados');
if (!defined('_DOWN_REG_ONLY_TITLE')) DEFINE('_DOWN_REG_ONLY_TITLE','Só membros registados');
if (!defined('_DOWN_PUBLIC_TITLE')) DEFINE('_DOWN_PUBLIC_TITLE','Público');
if (!defined('_DOWN_APPROVE_TITLE')) DEFINE('_DOWN_APPROVE_TITLE','Ficheiros para aprovação');
if (!defined('_DOWN_DATE')) DEFINE('_DOWN_DATE','Data');
if (!defined('_DOWN_NAME_TITLE')) DEFINE('_DOWN_NAME_TITLE','Nome');
if (!defined('_DOWN_CONFIG_TITLE')) DEFINE('_DOWN_CONFIG_TITLE','Configuração');
if (!defined('_DOWN_CONFIG_TITLE1')) DEFINE('_DOWN_CONFIG_TITLE1','Caminhos e vários');
if (!defined('_DOWN_CONFIG_TITLE2')) DEFINE('_DOWN_CONFIG_TITLE2','Permissões');
if (!defined('_DOWN_CONFIG_TITLE3')) DEFINE('_DOWN_CONFIG_TITLE3','Download text');
if (!defined('_DOWN_CONFIG_TITLE4')) DEFINE('_DOWN_CONFIG_TITLE4','Configure pages');
if (!defined('_DOWN_CONFIG1')) DEFINE("_DOWN_CONFIG1","TabClass:<br/><i>(MOS CSS alternating row colors (Two Comma Separated Values))</i>");
if (!defined('_DOWN_CONFIG2')) DEFINE("_DOWN_CONFIG2","TabHeader:<br/><i>(MOS CSS Page header and Admin panel background)</i>");
if (!defined('_DOWN_CONFIG3')) DEFINE("_DOWN_CONFIG3","Web_Down_Path:<br/><i>(Caminho para o directório de uploads - Web - Sem barra no final)</i>");
if (!defined('_DOWN_CONFIG4')) DEFINE("_DOWN_CONFIG4","Down_Path:<br/><i>(Caminho para o directório de uploads - Ficheiro - Sem barra no final)</i>");
if (!defined('_DOWN_CONFIG5')) DEFINE("_DOWN_CONFIG5","Up_Path:<br/><i>(Caminho para o directório de uploads - Sem barra no final)</i>");
if (!defined('_DOWN_CONFIG6')) DEFINE("_DOWN_CONFIG6","MaxSize:<br/><i>(Tamanho máximo de ficheiros enviados em Kb)</i>");
if (!defined('_DOWN_CONFIG7')) DEFINE("_DOWN_CONFIG7","Max_Up_Per_Day:<br/><i>(Número máximo de uploads permitidos por utilizador por dia (Administrador é ilimitado))</i>");
if (!defined('_DOWN_CONFIG8')) DEFINE("_DOWN_CONFIG8","Max_Up_Dir_Space:<br/><i>(Espaço máximo disponível para directório de uploads em Kb)</i>");
if (!defined('_DOWN_CONFIG9')) DEFINE("_DOWN_CONFIG9","ExtsOk:<br/><i>(Extensões permitidas para upload (Lista separada por vírgulas))</i>");
if (!defined('_DOWN_CONFIG10')) DEFINE("_DOWN_CONFIG10","Allowed_Desc_Tags:<br/><i>(Permitir HTML na descrição de ficheiros (Lista separada por vírgula))</i>");
if (!defined('_DOWN_CONFIG11')) DEFINE("_DOWN_CONFIG11","Allow_Up_Overwrite:<br/><i>(Permitir novos uploads substituir ficheiros existentes)</i>");
if (!defined('_DOWN_CONFIG12')) DEFINE("_DOWN_CONFIG12","Allow_User_Sub:<br/><i>(Permitir os utilizadores enviar ficheiros - Os ficheiros terão de ser aprovados pelo Administrador)</i>");
if (!defined('_DOWN_CONFIG13')) DEFINE("_DOWN_CONFIG13","Allow_User_Edit:<br/><i>(Permitir os utilizadores editar os ficheiros enviados - Os ficheiros terão de ser re-aprovados pelo administrador)</i>");
if (!defined('_DOWN_CONFIG14')) DEFINE("_DOWN_CONFIG14","Allow_User_Up:<br/><i>(Permitir os utilizadores enviar ficheiros - Os ficheiros terão de ser aprovados pelo Administrador)</i>");
if (!defined('_DOWN_CONFIG15')) DEFINE("_DOWN_CONFIG15","Allow_Comments:<br/><i>(Permitir os utilizadores comentarem ficheiros)</i>");
if (!defined('_DOWN_CONFIG16')) DEFINE("_DOWN_CONFIG16","Send_Sub_Mail:<br/><i>(Enviar Email para administrador (ou outro) quando um utilizador enviar um ficheiro)</i>");
if (!defined('_DOWN_CONFIG17')) DEFINE("_DOWN_CONFIG17","Sub_Mail_Alt_Addr:<br/><i>(Endereço de email alternativo para enviar notícias de uploads, de outra forma será utilizado o email de administrador)</i>");
if (!defined('_DOWN_CONFIG18')) DEFINE("_DOWN_CONFIG18","Sub_Mail_Alt_Name:<br/><i>(Alternate Recipient name for submit notices)</i>");
if (!defined('_DOWN_CONFIG19')) DEFINE("_DOWN_CONFIG19","HeaderPic:<br/><i>(Logo do Centro de Downloads)</i>");
if (!defined('_DOWN_CONFIG20')) DEFINE("_DOWN_CONFIG20","Anti-Leach:<br/><i>(Esconder ficheiros para proteger de links directos)</i>");
if (!defined('_DOWN_CONFIG21')) DEFINE("_DOWN_CONFIG21","Large_Text_Len:<br/><i>(Tamanho máximo de campos grandes (Descrição/Licença))</i>");
if (!defined('_DOWN_CONFIG22')) DEFINE("_DOWN_CONFIG22","Small_Text_Len:<br/><i>(Tamanho máximo de pequenos campos Input/Texto)</i>");
if (!defined('_DOWN_CONFIG23')) DEFINE("_DOWN_CONFIG23","Small_Image_Width:<br/><i>(Largura da miniatura)</i>");
if (!defined('_DOWN_CONFIG24')) DEFINE("_DOWN_CONFIG24","Small_Image_Height:<br/><i>(Altura da miniatura)</i>");
if (!defined('_DOWN_CONFIG25')) DEFINE("_DOWN_CONFIG25","Allow_Votes:<br/><i>(Permitir utilizadores votarem nos downloads)</i>");
if (!defined('_DOWN_CONFIG26')) DEFINE("_DOWN_CONFIG26","Enable_Admin_Autoapp:<br/><i>(Uploads de ADMIN automaticamente aprovados e publicaods)</i>");
if (!defined('_DOWN_CONFIG27')) DEFINE("_DOWN_CONFIG27","Enable_User_Autoapp:<br/><i>(Uploads de membros registados automaticamente aprovados e publicados)</i>");
if (!defined('_DOWN_CONFIG28')) DEFINE("_DOWN_CONFIG28","Enable_List_Downloads:<br/><i>(Permitir fazer download a partir da lista de ficheiro de uma categoria/pasta)</i>");
if (!defined('_DOWN_CONFIG29')) DEFINE("_DOWN_CONFIG29","Permitir membros coocarem ficheiros remotos:<br/><i>(Ficheiros que estão alojados noutro servidor)</i>");
if (!defined('_DOWN_CONFIG30')) DEFINE("_DOWN_CONFIG30","Favourites_Max:<br/><i>(Allow Users to record this many favourite files)</i>");
if (!defined('_DOWN_CONFIG31')) DEFINE("_DOWN_CONFIG31","Date_Format:<br/><i>(Formato das datas para o Centro de Downloads - Função de data PHP parâmetro 1)</i>");
if (!defined('_DOWN_CONFIG32')) DEFINE("_DOWN_CONFIG32","Default_Version:<br/><i>(Valor pré-definido para dar como versão a um novo ficheiro enviado)</i>");
if (!defined('_DOWN_CONFIG33')) DEFINE('_DOWN_CONFIG33','See_Containers_no_download:<br/><i>(Permite os utilizadores ver categorias/pastas em que não podem fazer downloads)</i>');
if (!defined('_DOWN_CONFIG34')) DEFINE('_DOWN_CONFIG34','See_Files_no_download:<br/><i>(Permite os utilizadores ver os ficheiros que não podem descarregar)</i>');
if (!defined('_DOWN_CONFIG35')) DEFINE('_DOWN_CONFIG35','Max_Thumbnails:<br/><i>(Maximum thumbnail images to be stored; 0 for URL only)</i>');
if (!defined('_DOWN_CONFIG36')) DEFINE("_DOWN_CONFIG36","Large_Image_Width:<br/><i>(Large Screenshot Width)</i>");
if (!defined('_DOWN_CONFIG37')) DEFINE("_DOWN_CONFIG37","Large_Image_Height:<br/><i>(Large Screenshot Height)</i>");
if (!defined('_DOWN_CONFIG38')) DEFINE("_DOWN_CONFIG38","Allow Large Image Display:<br/><i>(Large Screenshot popup window)</i>");
if (!defined('_DOWN_CONFIG39')) DEFINE("_DOWN_CONFIG39","Store files in database, by default");
if (!defined('_DOWN_STATS_TITLE')) DEFINE('_DOWN_STATS_TITLE','Estatísticas');
if (!defined('_DOWN_TOP_TITLE')) DEFINE('_DOWN_TOP_TITLE','Top');
if (!defined('_DOWN_RATED_TITLE')) DEFINE('_DOWN_RATED_TITLE','Avaliação');
if (!defined('_DOWN_VOTED_ON')) DEFINE('_DOWN_VOTED_ON','Nº de votos');
if (!defined('_DOWN_VOTES_TITLE')) DEFINE('_DOWN_VOTES_TITLE','Votos');
if (!defined('_DOWN_RATING_TITLE')) DEFINE('_DOWN_RATING_TITLE','Avaliação');
if (!defined('_DOWN_ABOUT')) DEFINE('_DOWN_ABOUT','Sobre');
if (!defined('_DOWN_TITLE_ABOUT')) DEFINE('_DOWN_TITLE_ABOUT','Título');
if (!defined('_DOWN_VERSION_ABOUT')) DEFINE('_DOWN_VERSION_ABOUT','Versão');
if (!defined('_DOWN_AUTHOR_ABOUT')) DEFINE('_DOWN_AUTHOR_ABOUT','Autor');
if (!defined('_DOWN_WEBSITE_ABOUT')) DEFINE('_DOWN_WEBSITE_ABOUT','WebSite');
if (!defined('_DOWN_EMAIL_ABOUT')) DEFINE('_DOWN_EMAIL_ABOUT','Email');
if (!defined('_DOWN_SEL_FILE_APPROVE')) DEFINE('_DOWN_SEL_FILE_APPROVE','Seleccione um ficheiro para aprovar');
if (!defined('_DOWN_DESC_SMALL')) DEFINE('_DOWN_DESC_SMALL','Descrição curta:');
if (!defined('_DOWN_DESC_SMALL_MAX')) DEFINE('_DOWN_DESC_SMALL_MAX','Máx: 150 letras');
if (!defined('_DOWN_AUTO_SHORT')) DEFINE('_DOWN_AUTO_SHORT','Auto-gerar descrição curta:');
if (!defined('_DOWN_LICENSE')) DEFINE('_DOWN_LICENSE','Licença:');
if (!defined('_DOWN_LICENSE_AGREE')) DEFINE('_DOWN_LICENSE_AGREE','Deve concordar com a licença:');
if (!defined('_DOWN_LEECH_WARN')) DEFINE('_DOWN_LEECH_WARN','A sua sessão não foi validada e as medidas anti-leach estão a fazer efeito.');
if (!defined('_DOWN_LICENSE_WARN')) DEFINE('_DOWN_LICENSE_WARN','Por favor leia/aceite a licença para fazer o download.');
if (!defined('_DOWN_LICENSE_CHECKBOX')) DEFINE('_DOWN_LICENSE_CHECKBOX','Concordo com os termos acima citados.');
if (!defined('_DOWN_DATE_FORMAT')) DEFINE("_DOWN_DATE_FORMAT","%d %B %Y"); //Uses PHP's strftime Command Format
if (!defined('_DOWN_FILE_NOTFOUND')) DEFINE('_DOWN_FILE_NOTFOUND','Ficheiro não encontrado');
if (!defined('_DOWN_ACCESS_GROUP')) DEFINE('_DOWN_ACCESS_GROUP','Grupo autorizado:');
if (!defined('_DOWN_THUMB_WRONG_TYPE')) DEFINE('_DOWN_THUMB_WRONG_TYPE','<h3>Thumbnail images must be png, jpg or jpeg</h3>');
if (!defined('_DOWN_EXTENSION_IN_TITLE')) DEFINE('_DOWN_EXTENSION_IN_TITLE','Extension in title');
if (!defined('_DOWN_DOWNLOAD_TEXT_BOX')) DEFINE('_DOWN_DOWNLOAD_TEXT_BOX','Download Text Box');
if (!defined('_DOWN_PRUNE_LOG')) DEFINE('_DOWN_PRUNE_LOG','Prune the log file');
if (!defined('_DOWN_LOGFILE_CUTOFF_DATE')) DEFINE('_DOWN_LOGFILE_CUTOFF_DATE','Please enter the date before which all log file entries are to be deleted:');
if (!defined('_DOWN_PRESS_SAVE_ACTIVATE')) DEFINE('_DOWN_PRESS_SAVE_ACTIVATE','then press "Save" to activate.');
if (!defined('_DOWN_METHOD_NOT_PRESENT')) DEFINE('_DOWN_METHOD_NOT_PRESENT','Component %s error: attempt to use non-existent method %s in %s');
if (!defined('_DOWN_CLASS_NOT_PRESENT')) DEFINE('_DOWN_CLASS_NOT_PRESENT','Component %s error: attempt to use non-existent class %s');
if (!defined('_DOWN_NO_UPLOAD_TO_FILES')) DEFINE('_DOWN_NO_UPLOAD_TO_FILES','Cannot bulk upload to a container with a filepath');
if (!defined('_DOWN_COUNTS_RECALCULATED')) DEFINE('_DOWN_COUNTS_RECALCULATED','File and folder counts recalculated');
if (!defined('_DOWN_COUNTS_RESET')) DEFINE('_DOWN_COUNTS_RESET','File download counts reset');
if (!defined('_DOWN_OLD_LOG_REMOVED')) DEFINE('_DOWN_OLD_LOG_REMOVED','Log file entries earlier than %s removed.');
if (!defined('_DOWN_NONE_MISSING')) DEFINE('_DOWN_NONE_MISSING','No missing files');
if (!defined('_DOWN_NO_RELEVANT_THUMB')) DEFINE('_DOWN_NO_RELEVANT_THUMB',' - no relevant files - removal attempted.<br/>');
if (!defined('_DOWN_THUMB_NOT_BELONG')) DEFINE('_DOWN_THUMB_NOT_BELONG','%s in directory %s file does not belong - removal attempted.<br/>');
if (!defined('_DOWN_THUMB_NOT_IN_DB')) DEFINE('_DOWN_THUMB_NOT_IN_DB',' - no match in database - removal attempted.<br/>');
if (!defined('_DOWN_THUMB_OK')) DEFINE('_DOWN_THUMB_OK','No problems found with thumbnail files');
if (!defined('_DOWN_STRUCTURE_ADDED')) DEFINE('_DOWN_STRUCTURE_ADDED','Structure added to repository');
if (!defined('_DOWN_DB_CONVERT_OK')) DEFINE('_DOWN_DB_CONVERT_OK','Database conversion completed.  Any files listed above were invalid.');
if (!defined('_DOWN_ADD_NUMBER_FILES')) DEFINE('_DOWN_ADD_NUMBER_FILES','Add a number of files');
if (!defined('_DOWN_DISPLAY_NUMBER')) DEFINE('_DOWN_DISPLAY_NUMBER','Display #');
if (!defined('_DOWN_SEARCH_COLON')) DEFINE('_DOWN_SEARCH_COLON','Search:');
if (!defined('_DOWN_SHOW_DESCENDANTS')) DEFINE('_DOWN_SHOW_DESCENDANTS','Show descendants: ');
if (!defined('_DOWN_CLICK_TO_VISIT')) DEFINE('_DOWN_CLICK_TO_VISIT','Click to visit site');
if (!defined('_DOWN_CONTAINERS')) DEFINE('_DOWN_CONTAINERS','Containers');
if (!defined('_DOWN_UP_PLAIN_TEXT')) DEFINE('_DOWN_UP_PLAIN_TEXT','Store file as plain text?');
if (!defined('_GLOBAL')) DEFINE('_GLOBAL','Global');
if (!defined('_DOWN_BLOB_NOCHUNKS')) DEFINE('_DOWN_BLOB_NOCHUNKS',' - BLOB TABLE HAS 0 CHUNKS');
if (!defined('_DOWN_CHUNKS_DISCREPANCY')) DEFINE('_DOWN_CHUNKS_DISCREPANCY',' - BLOB TABLE HAS %s CHUNKS, FILE SAYS %s');
if (!defined('_DOWN_PLAINTEXT_DISCREPANCY')) DEFINE('_DOWN_PLAINTEXT_DISCREPANCY',' - PLAIN TEXT TABLE HAS %s ENTRIES, SHOULD BE EXACTLY 1');
if (!defined('_DOWN_NOT_FOUND_HERE')) DEFINE('_DOWN_NOT_FOUND_HERE',' - NOT FOUND AT THIS LOCATION<br/>');
if (!defined('_DOWN_LOCAL_NO_URL')) DEFINE('_DOWN_LOCAL_NO_URL','FILE NOT LOCAL, BUT NO URL SPECIFIED');
if (!defined('_DOWN_NOT_VALID_BR')) DEFINE('_DOWN_NOT_VALID_BR',' - NOT VALIDATED<br/>');
if (!defined('_DOWN_NONE_MISSING')) DEFINE('_DOWN_NONE_MISSING','No missing files');
if (!defined('_DOWN_INHERIT')) DEFINE('_DOWN_INHERIT','inherit');
if (!defined('_DOWN_FORCE_INHERIT')) DEFINE('_DOWN_FORCE_INHERIT','Force children to inherit starred');
if (!defined('_DOWN_EXT_IN_TITLE')) DEFINE('_DOWN_EXT_IN_TITLE','Extension in title');
if (!defined('_DOWN_BULK_ADD_FILES')) DEFINE('_DOWN_BULK_ADD_FILES','bulk add files from download directory');
if (!defined('_DOWN_NO_AVAILABLE_FILES')) DEFINE('_DOWN_NO_AVAILABLE_FILES','No available files');
if (!defined('_DOWN_ABS_PATH_TO_FILES')) DEFINE('_DOWN_ABS_PATH_TO_FILES','Absolute path to files:');
if (!defined('_DOWN_ACCEPTABLE_EXTENSIONS')) DEFINE('_DOWN_ACCEPTABLE_EXTENSIONS','Acceptable extensions (comma separated):');
if (!defined('_DOWN_EXTENSION_IN_TITLE')) DEFINE('_DOWN_EXTENSION_IN_TITLE','Extension in title');

// /components/com_remository/com_remository_upload.php
if (!defined('_DOWNLOAD_UPLOAD_TITLE')) DEFINE('_DOWNLOAD_UPLOAD_TITLE','Carregar um ficheiro');
if (!defined('_HEAD')) DEFINE('_HEAD','Carregar um ficheiro');
if (!defined('_FILE')) DEFINE('_FILE','Carregar ficheiro:');
if (!defined('_CLOSE')) DEFINE('_CLOSE','Fechar');
if (!defined('_SENDFILE')) DEFINE('_SENDFILE','Enviar ficheiro');
if (!defined('_ERR1')) DEFINE('_ERR1','Não foi especificado um ficheiro.');
if (!defined('_ERR2')) DEFINE('_ERR2','Ataque de upload de ficheiros');
if (!defined('_ERR3')) DEFINE('_ERR3','O ficheiro que tentou carregar é nulo!');
if (!defined('_ERR4')) DEFINE('_ERR4','Tentou carregar um ficheiro com uma extensão que não é permitida!');
if (!defined('_ERR5')) DEFINE('_ERR5','O ficheiro que tentou carregar excede o tamanho limite máximo de ');
if (!defined('_ERR6')) DEFINE('_ERR6','O ficheiro que tentou carregar já existe. Por favor escolha um novo nome para o ficheiro.');
if (!defined('_ERR7')) DEFINE('_ERR7','O directório de uploads está actualmente cheio.');
if (!defined('_ERR8')) DEFINE('_ERR8','Tem de ser Administrador ou um Utilizador registado para fazer uploads.');
if (!defined('_ERR9')) DEFINE('_ERR9','Atingiu o seu limite diário de uploads.');
if (!defined('_ERR10')) DEFINE('_ERR10','Uploads de utilizadores não são permitidos.');
if (!defined('_ERR11')) DEFINE('_ERR11','Carregamento do ficheiro com erro. Código ');
if (!defined('_UP_SUCCESS')) DEFINE('_UP_SUCCESS','Ficheiro carregado com sucesso!');
if (!defined('_UPLOAD_URL_LOCK')) DEFINE('_UPLOAD_URL_LOCK','-Ficheiro enviado-');
if (!defined('_WARNING1')) DEFINE('_WARNING1','Path for files changed - WARNING files not moved');
if (!defined('_WARNING2')) DEFINE('_WARNING2','Specified file path does not exist - Create new');
if (!defined('_APPROVE')) DEFINE('_APPROVE','Approve');
if (!defined('_CANCEL')) DEFINE('_CANCEL','Cancel');
if (!defined('_DOWN_MISSING_TITLE')) DEFINE('_DOWN_MISSING_TITLE','Missing Files');
if (!defined('_DOWN_ADDSTRUCTURE_TITLE')) DEFINE('_DOWN_ADDSTRUCTURE_TITLE','add whole structure');

// Recent additions 3.56
if (!defined('_DOWN_EDIT_CLASSIFICATION')) DEFINE ('_DOWN_EDIT_CLASSIFICATION', 'Edit Classification');
if (!defined('_DOWN_CLASSIFICATION')) DEFINE ('_DOWN_CLASSIFICATION', 'Classification');
if (!defined('_DOWN_CONTAINER_PUBLISHED')) DEFINE ('_DOWN_CONTAINER_PUBLISHED', 'Container successfully published');
if (!defined('_DOWN_CONTAINERS_PUBLISHED')) DEFINE ('_DOWN_CONTAINERS_PUBLISHED', 'Containers successfully published');
if (!defined('_DOWN_CONTAINER_UNPUBLISHED')) DEFINE ('_DOWN_CONTAINER_UNPUBLISHED', 'Container successfully unpublished');
if (!defined('_DOWN_CONTAINERS_UNPUBLISHED')) DEFINE ('_DOWN_CONTAINERS_UNPUBLISHED', 'Containers successfully unpublished');
if (!defined('_DOWN_CONTAINER_SAVED')) DEFINE ('_DOWN_CONTAINER_SAVED', 'Container saved successfully');
if (!defined('_DOWN_CONTAINER_DELETED')) DEFINE ('_DOWN_CONTAINER_DELETED', 'Container deleted successfully');
if (!defined('_DOWN_CONTAINERS_DELETED')) DEFINE ('_DOWN_CONTAINERS_DELETED', 'Containers deleted successfully');
if (!defined('_DOWN_FILE_PUBLISHED')) DEFINE ('_DOWN_FILE_PUBLISHED', 'File successfully published');
if (!defined('_DOWN_FILES_PUBLISHED')) DEFINE ('_DOWN_FILES_PUBLISHED', 'Files successfully published');
if (!defined('_DOWN_FILE_UNPUBLISHED')) DEFINE ('_DOWN_FILE_UNPUBLISHED', 'File successfully unpublished');
if (!defined('_DOWN_FILES_UNPUBLISHED')) DEFINE ('_DOWN_FILES_UNPUBLISHED', 'Files successfully unpublished');
if (!defined('_DOWN_FILE_SAVED')) DEFINE ('_DOWN_FILE_SAVED', 'File saved successfully');
if (!defined('_DOWN_FILE_DELETED')) DEFINE ('_DOWN_FILE_DELETED', 'File deleted successfully');
if (!defined('_DOWN_FILES_DELETED')) DEFINE ('_DOWN_FILES_DELETED', 'Files deleted successfully');
if (!defined('_DOWN_FILE_LOCALISED')) DEFINE ('_DOWN_FILE_LOCALISED', 'File localised successfully');
if (!defined('_DOWN_GROUP_MEMBER_SAVED')) DEFINE ('_DOWN_GROUP_MEMBER_SAVED', 'Group member added successfully');
if (!defined('_DOWN_GROUP_MEMBERS_SAVED')) DEFINE ('_DOWN_GROUP_MEMBERS_SAVED', 'Group members added successfully');
if (!defined('_DOWN_GROUP_MEMBER_DELETED')) DEFINE ('_DOWN_GROUP_MEMBER_DELETED', 'Member removed successfully');
if (!defined('_DOWN_GROUP_MEMBERS_DELETED')) DEFINE ('_DOWN_GROUP_MEMBERS_DELETED', 'Members removed successfully');
if (!defined('_DOWN_GROUP_DELETED')) DEFINE ('_DOWN_GROUP_DELETED', 'Group deleted successfully');
if (!defined('_DOWN_GROUPS_DELETED')) DEFINE ('_DOWN_GROUPS_DELETED', 'Groups deleted successfully');
if (!defined('_DOWN_ORPHAN_SINGLE_DONE')) DEFINE('_DOWN_ORPHAN_SINGLE_DONE','File Orphan Deleted');
if (!defined('_DOWN_CLASSIFICATION_PUBLISHED')) DEFINE ('_DOWN_CLASSIFICATION_PUBLISHED', 'Classification successfully published');
if (!defined('_DOWN_CLASSIFICATIONS_PUBLISHED')) DEFINE ('_DOWN_CLASSIFICATIONS_PUBLISHED', 'Classifications successfully published');
if (!defined('_DOWN_CLASSIFICATION_UNPUBLISHED')) DEFINE ('_DOWN_CLASSIFICATION_UNPUBLISHED', 'Classification successfully unpublished');
if (!defined('_DOWN_CLASSIFICATIONS_UNPUBLISHED')) DEFINE ('_DOWN_CLASSIFICATIONS_UNPUBLISHED', 'Classifications successfully unpublished');
if (!defined('_DOWN_CLASSIFICATION_SAVED')) DEFINE ('_DOWN_CLASSIFICATION_SAVED', 'Classification saved successfully');
if (!defined('_DOWN_CLASSIFICATION_DELETED')) DEFINE ('_DOWN_CLASSIFICATION_DELETED', 'Classification deleted successfully');
if (!defined('_DOWN_CLASSIFICATIONS_DELETED')) DEFINE ('_DOWN_CLASSIFICATIONS_DELETED', 'Classifications deleted successfully');
if (!defined('_DOWN_MISSING_DELETED')) DEFINE ('_DOWN_MISSING_DELETED', 'Missing file deleted successfully');
if (!defined('_DOWN_MISSINGS_DELETED')) DEFINE ('_DOWN_MISSINGS_DELETED', 'Missing files deleted successfully');
if (!defined('_SUBMIT_FILE_BUTTON_ADV')) DEFINE('_SUBMIT_FILE_BUTTON_ADV','AddFile');