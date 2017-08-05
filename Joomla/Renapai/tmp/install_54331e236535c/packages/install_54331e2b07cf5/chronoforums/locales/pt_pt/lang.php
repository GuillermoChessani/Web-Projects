<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
* Portuese translation by António Graça(mantoniograca@gmail.com)
**/
namespace GCore\Extensions\Chronoforums\Locales\PtPt;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Lang {
	const CHRONOFORUMS_DATE_FORMAT = "D M j, Y, g:i a";
	const CHRONOFORUMS_STYLE_IMAGES_PATH = "pt"; // change this only if you have alternative translated images for your theme, e.g: new topic..etc
	//uncomment and translate the following 4 lines in order to translate the days/months for your language
	//static $DATE_D = array('', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim');
	//static $DATE_l = array('', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
	//static $DATE_F = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
	//static $DATE_M = array('', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Agt', 'Set', 'Out', 'Nov', 'Dez');
	const CHRONOFORUMS_EXTENSION_NOT_ALLOWED = "File extension is not allowed.";
	const CHRONOFORUMS_FILE_SAVE_ERROR = "Error saving uploaded file.";
	const CHRONOFORUMS_POST_REPORTED_SUBJECT = "A forum post has been reported at {domain}";
	const CHRONOFORUMS_POST_REPORTED_BODY = "Some user has reported a post at {url}";
	const CHRONOFORUMS_NEW_REPLY_SUBJECT = "Foi colocada uma nova resposta para {Topic.title}";
	const CHRONOFORUMS_NEW_REPLY_BODY = "Uma nova resposta foi colocada para um dos tópicos de que é subscritor. Pode aceder à respoats no link abaixo\n\n {Topic.title_link}\n";
	const CHRONOFORUMS_NEW_TOPIC_SUBJECT = "Um novo tópico foi colocado para {domain}";
	const CHRONOFORUMS_NEW_TOPIC_BODY = "Um novo tópico foi enviada por {domain}";
	const CHRONOFORUMS_FORUM_DOESNT_EXIST = "Este fórum não existe ou algum erro pode ter ocorrido!";
	const CHRONOFORUMS_FORUM_IS_OFFLINE = "Presentemente este forúm esta offline..";
	const CHRONOFORUMS_TOPIC_DOESNT_EXIST = "Este tópico não existe ou algum erro pode ter ocorrido.";
	const CHRONOFORUMS_TOPIC_IS_OFFLINE = "Este tópico está offline ou ainda não foi aprovado por um moderador.";
	const CHRONOFORUMS_TOPIC_LOCKED_ERROR = "Este tópico está bloqueado e não pode ser colocados mais posts";
	const CHRONOFORUMS_PERMISSIONS_ERROR = "Acesso negado, você não tem permissão para acessar esse recurso. Faça o login.";
	const CHRONOFORUMS_SAVE_ERROR = "Falha ao salvar.";
	const CHRONOFORUMS_DELETE_SUCCESS = "Emininação bem sucedida!";
	const CHRONOFORUMS_DELETE_ERROR = "Eliminação falhada.";
	CONST CHRONOFORUMS_TOPIC_LOCK_SUCCESS = "O bloqueio do tópico foi bem sucedido!";
	const CHRONOFORUMS_TOPIC_LOCK_ERROR = "Um erro ocorreu quando tentava bloquear este tópico.";
	const CHRONOFORUMS_TOPIC_UNLOCK_SUCCESS = "Topic has been successfully unlocked!";
	const CHRONOFORUMS_TOPIC_UNLOCK_ERROR = "Um erro ocorreu quando tentava desbloquear este tópico.";
	const CHRONOFORUMS_UPDATE_SUCCESS = "Atualizado com sucesso!";
	const CHRONOFORUMS_UPDATE_ERROR = "Atualização falhou.";
	const CHRONOFORUMS_QUICK_TASKS = "Tarefas Rápidas";
	const CHRONOFORUMS_DELETE_TOPIC = "Eliminar Tópico (incluindo posts)";
	const CHRONOFORUMS_DELETE_AUTHOR = "Eliminar Autot (incluindo todos os seus tópicos & posts)";
	const CHRONOFORUMS_LOCK_TOPIC = "Tópico bloqueado";
	const CHRONOFORUMS_UNLOCK_TOPIC = "Desbloquear tópico";
	const CHRONOFORUMS_SET_ANNOUNCEMENT = "Definir anúncio";
	const CHRONOFORUMS_UNSET_ANNOUNCEMENT = "Anular definir anúncio";
	const CHRONOFORUMS_SET_STICKY = "Definir post-it";
	const CHRONOFORUMS_UNSET_STICKY = "Anular definir post-it";
	const CHRONOFORUMS_PUBLISH_TOPIC = "Publicar/Aprovar Tópico";
	const CHRONOFORUMS_UNPUBLISH_TOPIC = "Anular Despublicar tópico";
	const CHRONOFORUMS_ITS_CURRENTLY = "É atualmente";
	const CHRONOFORUMS_TOPICS = "Tópicos";
	const CHRONOFORUMS_POSTS = "Posts";
	const CHRONOFORUMS_LASTPOST = "Último Post";
	const CHRONOFORUMS_POST_NEW_TOPIC = "Novo tópico";
	const CHRONOFORUMS_REPLIES = "Respostas";
	const CHRONOFORUMS_VIEWS = "Visto";
	const CHRONOFORUMS_NO_POSTS = "Sem Posts";
	const CHRONOFORUMS_ATTACHMENTS = "Anexos";
	const CHRONOFORUMS_DELETE_CONFIRMATION = "Tem certeza de que deseja apagar o post abaixo?";
	const CHRONOFORUMS_REPORT_CONFIRMATION = "Tem certeza que deseja denunciar o post abaixo?";
	const CHRONOFORUMS_POST_REPLY = "Colocar uma resposta";
	const CHRONOFORUMS_NO_POSTS_WERE_FOUND = "Não foram encontrados posts.";
	const CHRONOFORUMS_INFORMATION = "Informação";
	const CHRONOFORUMS_BOARD_INDEX = "Início";
	const CHRONOFORUMS_RETURN_TO = "Regressar a";
	const CHRONOFORUMS_SUBSCRIBE_TOPIC = "Subscrever Tópico";
	const CHRONOFORUMS_SUBSCRIBE_TOPIC_DESC = "Notifique-me quando for colocado um novo post para este tópico.";
	const CHRONOFORUMS_UNSUBSCRIBE_TOPIC = "Anular subscrição do tópico.";
	const CHRONOFORUMS_SUBSCRIBE_SUCCESS = "Subscição bem sucedida!";
	const CHRONOFORUMS_UNSUBSCRIBE_SUCCESS = "Anulação da subscrição bem sucedida!";
	const CHRONOFORUMS_SEARCH_FOUND = "A pesquisa encontrou %s resultados para:";
	const CHRONOFORUMS_NO_UNREAD_POSTS = "Sem posts por ler";
	const CHRONOFORUMS_FORUM = "Fórum";
	const CHRONOFORUMS_REPORT_REASON = "Razão";
	const CHRONOFORUMS_SEARCH_KEYWORDS = "Pesquisar Palavras chave";
	const CHRONOFORUMS_CANCEL = "Cancelar";
	const CHRONOFORUMS_SEARCH = "Pesquisar";
	const CHRONOFORUMS_REPORT = "Reportar";
	const CHRONOFORUMS_DELETE = "Apagar";
	const CHRONOFORUMS_EDIT = "Editar";
	const CHRONOFORUMS_REPLY_QUOTE = "Responder com citação";
	const CHRONOFORUMS_TOPIC_POSTED_NOT_PUBLISHED = "O seu tópico foi colocado mas está à espera de aprovação pelos moderadores.";
	const CHRONOFORUMS_NO_TOPICS = "Sem tópicos";
	const CHRONOFORUMS_BY = "por";
	const CHRONOFORUMS_JOINED = "Registado";
	const CHRONOFORUMS_PAGINATOR_INFO = "Mostrando %s para %s de %s entradas.";
	const CHRONOFORUMS_PAGINATOR_PREV = "Anterior";
	const CHRONOFORUMS_PAGINATOR_FIRST = "Primeiro";
	const CHRONOFORUMS_PAGINATOR_LAST = "Último";
	const CHRONOFORUMS_PAGINATOR_NEXT = "Próximo";
	const CHRONOFORUMS_CODE = "Código";
	const CHRONOFORUMS_SELECT_ALL = "Selecionar tudo";
	const CHRONOFORUMS_WROTE = "escreveu";
	const CHRONOFORUMS_TIMES = "tempo(s)";
	const CHRONOFORUMS_DOWNLOADED = "Descarregado";
	const CHRONOFORUMS_VIEWED = "Visto";
	const CHRONOFORUMS_TOPIC_REPORTED = "Este tópico foi reportado.";
	const CHRONOFORUMS_TOPIC_NOT_APPROVED = "Este tópico foi aprovado.";
	const CHRONOFORUMS_VIEW_PROFILE = "Exibir o perfil do utilizador.";
	const CHRONOFORUMS_USER_REPORT = "Relatório de Utilizadort";
	const CHRONOFORUMS_VIEW_LATEST_POST = "Exibir os últimos posts";
	const CHRONOFORUMS_SUBJECT = "Assunto";
	const CHRONOFORUMS_BOLD_TEXT = "Texto em bold";
	const CHRONOFORUMS_ITALIC_TEXT = "Texto em itálico";
	const CHRONOFORUMS_UNDERLINE_TEXT = "Texto sublinhado";
	const CHRONOFORUMS_QUOTE_TEXT = "Citar texto";
	const CHRONOFORUMS_CODE_DISPLAY = "Mostar código";
	const CHRONOFORUMS_LIST = "Lista";
	const CHRONOFORUMS_ORDERED_LIST = "Lista ordenada";
	const CHRONOFORUMS_INSERT_IMAGE = "Inserir imagem";
	const CHRONOFORUMS_INSERT_URL = "Inserir URL";
	const CHRONOFORUMS_INLINE_ATTACHMENT = "Anexo em espera";
	const CHRONOFORUMS_FONT_COLOR = "Cor da fonte";
	const CHRONOFORUMS_FONT_SIZE = "Tamanho da fonte";
	const CHRONOFORUMS_LIST_ELEMENT = "Elemento da lista";
	const CHRONOFORUMS_FLASH = "Flash";
	const CHRONOFORUMS_HIDE_FONT_COLOR = "Esconder a cor da fonte";
	const CHRONOFORUMS_TINY = "Micro";
	const CHRONOFORUMS_SMALL = "Pequeno";
	const CHRONOFORUMS_NORMAL = "Normal";
	const CHRONOFORUMS_LARGE = "Grande";
	const CHRONOFORUMS_HUGE = "Enorme";
	const CHRONOFORUMS_SMILIES = "Sorrisos";
	const CHRONOFORUMS_FILE_COMMENT = "Comentário do ficheiro";
	const CHRONOFORUMS_FILE_INFO = "Informação do ficheiro";
	const CHRONOFORUMS_PLACE_INLINE = "Colocado em espera";
	const CHRONOFORUMS_DELETE_FILE = "Eliminar ficheiro";
	const CHRONOFORUMS_ATTACH_FILE = "Anexar ficheiro";
	const CHRONOFORUMS_UPLOAD = "Carregar";
	const CHRONOFORUMS_SUBMIT = "Enviar";
}