<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace GCore\Extensions\Chronoforums\Locales\DaDk;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Lang extends \GCore\Admin\Extensions\Chronoforums\Locales\EnGb\Lang{
	const CHRONOFORUMS_DATE_FORMAT = "D M j, Y, g:i a";
	const CHRONOFORUMS_STYLE_IMAGES_PATH = "en"; // change this only if you have alternative translated images for your theme, e.g: new topic..etc
	//uncomment and translate the following 4 lines in order to translate the days/months for your language
	//static $DATE_D = array('', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim');
	//static $DATE_l = array('', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
	//static $DATE_F = array('', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
	//static $DATE_M = array('', 'Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc');
	
	
	const CHRONOFORUMS_SPOOFING_ERROR = "Du kan ikke lave opslag igen nu.";
	const CHRONOFORUMS_FORUM_ACCESS_DENIED = "Du har ikke tilladelse til dette forum/sektion.";
	const CHRONOFORUMS_FORUM_ACTION_DENIED = "Du har ikke nok tilladelse til at gøre den handling i dette forum/sektion.";
	const CHRONOFORUMS_EXTENSION_NOT_ALLOWED = "Filtypen er ikke tilladt.";
	const CHRONOFORUMS_FILE_SAVE_ERROR = "Fejl i at gemme uploadet fil.";
	const CHRONOFORUMS_POST_REPORTED_SUBJECT = "Et forum opslag er blevet rapporteret på {domain}";
	const CHRONOFORUMS_POST_REPORTED_BODY = "En bruger har indrapporteret et opslag på {url}";
	const CHRONOFORUMS_NEW_REPLY_SUBJECT = "Svar på emne - \"{Topic.title}\"";
	const CHRONOFORUMS_NEW_REPLY_SUBJECT_EXT1 = " - [TUID#{Topic.params.uid}]";
	const CHRONOFORUMS_NEW_REPLY_BODY = "Et nyt svar er blevet lavet på et af de emner, som du følger du kan se det på dette link:\n\n {Topic.title_link}\n";
	const CHRONOFORUMS_NEW_REPLY_BODY_EXT1 = "\n\n Det nye svar blev lavet af: {Post.author_name}\n\nOg beskeden var:\n{Post.text}\n\nDu kan svare på opslaget ved at svare på denne email, lav ingen ændringer i emnefeltet.";
	const CHRONOFORUMS_NEW_TOPIC_SUBJECT = "Ny tråd på {domain}";
	const CHRONOFORUMS_NEW_TOPIC_BODY = "Ny tråd på {domain}, du kan se det på linket nedenfor \n\n {Topic.title_link}\n";
	const CHRONOFORUMS_NEW_PM_SUBJECT = "En ny privat besked er blevet sendt til dig på {domain}";
	const CHRONOFORUMS_NEW_PM_BODY = "En ny privat besked er blevet sendt til dig på {domain}, du kan se den på linket nedenfor\n\n {Message.link}\n";
	const CHRONOFORUMS_FORUM_DOESNT_EXIST = "Forummet eksisterer ikke eller der er sket en fejl.";
	const CHRONOFORUMS_FORUM_IS_OFFLINE = "Dette forum er offline i øjeblikket.";
	const CHRONOFORUMS_PAGE_DOESNT_EXIST = "Siden blev ikke fundet.";
	const CHRONOFORUMS_TOPIC_DOESNT_EXIST = "Tråden eksisterer ikke eller der er sket en fejl.";
	const CHRONOFORUMS_TOPIC_IS_OFFLINE = "Tråden er offline eller er ikke godkendt af moderatoren.";
	const CHRONOFORUMS_TOPIC_LOCKED_ERROR = "Tråden er låst og der kan ikke laves flere opslag.";
	const CHRONOFORUMS_PERMISSIONS_ERROR = "Adgang nægtet, du har ikke tilladelse til at tilgå denne ressource, enten er du ikke logget ind eller har ikke tilstrækkelige rettigheder.";
	const CHRONOFORUMS_SAVE_ERROR = "Det lykkedes ikke at gemme.";
	const CHRONOFORUMS_DELETE_ERROR = "Det lykkedes ikke at slette.";
	const CHRONOFORUMS_TOPIC_POSTED_NOT_PUBLISHED = "Din tråd er blevet oprettet, men afventer godkendelse fra vores moderator.";
	const CHRONOFORUMS_TOPIC_LOCK_SUCCESS = "Tråden blev låst!";
	const CHRONOFORUMS_TOPIC_LOCK_ERROR = "En fejl er sket i forsøget på at låse tråden.";
	const CHRONOFORUMS_TOPIC_UNLOCK_SUCCESS = "Tråden er ikke længere låst!";
	const CHRONOFORUMS_TOPIC_UNLOCK_ERROR = "En fejl er sket i forsøget på at låse tråden op.";
	const CHRONOFORUMS_UPDATE_SUCCESS = "Opdatering lykkedes!";
	const CHRONOFORUMS_UPDATE_ERROR = "Opdatering slog fejl.";
	const CHRONOFORUMS_DELETE_SUCCESS = "Sletningen lykkedes!";
	const CHRONOFORUMS_SUBSCRIBE_SUCCESS = "Du følger nu opslaget.";
	const CHRONOFORUMS_UNSUBSCRIBE_SUCCESS = "Du følger ikke længere opslaget.";
	const CHRONOFORUMS_CODE = "Kode";
	const CHRONOFORUMS_SELECT_ALL = "Vælg alt";
	const CHRONOFORUMS_WROTE = "skrev";
	const CHRONOFORUMS_BOARD_INDEX = "Forum indeks";
	const CHRONOFORUMS_UNSUBSCRIBE_TOPIC = "Følg ikke længere tråd";
	const CHRONOFORUMS_SUBSCRIBE_TOPIC_DESC = "Send mig besked når der laves nye opslag i denne tråd.";
	const CHRONOFORUMS_SUBSCRIBE_TOPIC = "Følg tråd";
	const CHRONOFORUMS_SEARCH = "Søg";
	const CHRONOFORUMS_QUICK_TASKS = "Hurtige opgaver";
	const CHRONOFORUMS_DELETE_TOPIC = "Slet Tråd (inklusiv opslag)";
	const CHRONOFORUMS_DELETE_AUTHOR = "Slet Forfatter (inklusiv alle brugerens tråde og opslag)";
	const CHRONOFORUMS_LOCK_TOPIC = "Lås Tråd";
	const CHRONOFORUMS_UNLOCK_TOPIC = "Lås Tråd op";
	const CHRONOFORUMS_SET_ANNOUNCEMENT = "Sæt annoncering";
	const CHRONOFORUMS_UNSET_ANNOUNCEMENT = "Fjern annoncering";
	const CHRONOFORUMS_SET_STICKY = "Sæt Sticky";
	const CHRONOFORUMS_UNSET_STICKY = "Fjern Sticky";
	const CHRONOFORUMS_PUBLISH_TOPIC = "Publicer/Godkend Tråd";
	const CHRONOFORUMS_UNPUBLISH_TOPIC = "Afpublicer Tråd";
	const CHRONOFORUMS_SUBJECT = "Emne";
	const CHRONOFORUMS_BOLD_TEXT = "Fed tekst";
	const CHRONOFORUMS_ITALIC_TEXT = "Kursiv tekst";
	const CHRONOFORUMS_UNDERLINE_TEXT = "Understregning";
	const CHRONOFORUMS_QUOTE_TEXT = "Citat";
	const CHRONOFORUMS_CODE_DISPLAY = "Vis kode";
	const CHRONOFORUMS_LIST = "Liste";
	const CHRONOFORUMS_ORDERED_LIST = "Ordnet liste";
	const CHRONOFORUMS_INSERT_IMAGE = "Sæt billede ind";
	const CHRONOFORUMS_INSERT_URL = "Sæt URL ind";
	const CHRONOFORUMS_INLINE_ATTACHMENT = "Inline vedhæftning";
	const CHRONOFORUMS_FONT_COLOR = "Font farve";
	const CHRONOFORUMS_FONT_SIZE = "Font størrelse";
	const CHRONOFORUMS_LIST_ELEMENT = "Liste element";
	const CHRONOFORUMS_FLASH = "Flash";
	const CHRONOFORUMS_HIDE_FONT_COLOR = "Skjul font farve";
	const CHRONOFORUMS_TINY = "Meget lille";
	const CHRONOFORUMS_SMALL = "Lille";
	const CHRONOFORUMS_NORMAL = "Normal";
	const CHRONOFORUMS_LARGE = "Stor";
	const CHRONOFORUMS_HUGE = "Kæmpe";
	const CHRONOFORUMS_SMILIES = "Smilies";
	const CHRONOFORUMS_FILE_COMMENT = "Fil kommentar";
	const CHRONOFORUMS_FILE_INFO = "Fil info";
	const CHRONOFORUMS_PLACE_INLINE = "Placer inline";
	const CHRONOFORUMS_DELETE_FILE = "Slet fil";
	const CHRONOFORUMS_ATTACH_FILE = "Vedhæft fil";
	const CHRONOFORUMS_UPLOAD = "Upload";
	const CHRONOFORUMS_CANCEL = "Annuller";
	const CHRONOFORUMS_SUBMIT = "Send";
	const CHRONOFORUMS_PREVIEW = "Preview";
	const CHRONOFORUMS_SEARCH_FOUND = "Søgning fandt %s resultater for:";
	const CHRONOFORUMS_POST_NEW_TOPIC = "Lav en ny tråd";
	const CHRONOFORUMS_NEW_TOPIC = "Ny Tråd";
	const CHRONOFORUMS_PAGINATOR_INFO = "Viser %s til %s af %s forekomster.";
	const CHRONOFORUMS_PAGINATOR_PREV = "Forrige";
	const CHRONOFORUMS_PAGINATOR_FIRST = "Første";
	const CHRONOFORUMS_PAGINATOR_LAST = "Sidste";
	const CHRONOFORUMS_PAGINATOR_NEXT = "Næste";
	const CHRONOFORUMS_TOPICS = "Tråde";
	const CHRONOFORUMS_REPLIES = "Svar";
	const CHRONOFORUMS_VIEWS = "Visninger";
	const CHRONOFORUMS_LASTPOST = "Sidste opslag";
	const CHRONOFORUMS_NO_UNREAD_POSTS = "Ingen ulæste opslag";
	const CHRONOFORUMS_TOPIC_REPORTED = "Tråden er blevet rapporteret.";
	const CHRONOFORUMS_TOPIC_NOT_APPROVED = "Tråden er ikke blevet godkendt.";
	const CHRONOFORUMS_ATTACHMENTS = "Vedhæftninger";
	const CHRONOFORUMS_BY = "af";
	const CHRONOFORUMS_VIEW_PROFILE = "Se brugerens profil.";
	const CHRONOFORUMS_GUEST = "Gæst";
	const CHRONOFORUMS_NO_POSTS = "Ingen opslag";
	const CHRONOFORUMS_ITS_CURRENTLY = "Det er nu";
	const CHRONOFORUMS_POSTS = "Opslag";
	const CHRONOFORUMS_NO_TOPICS = "Ingen tråde";
	const CHRONOFORUMS_VIEW_LATEST_POST = "Se det nyeste opslag";
	const CHRONOFORUMS_DELETE_CONFIRMATION = "Er du sikker på, at du vil slette det nedenstående opslag?";
	const CHRONOFORUMS_DELETE = "Slet";
	const CHRONOFORUMS_VIEWED = "Vist";
	const CHRONOFORUMS_TIMES = "gang(e)";
	const CHRONOFORUMS_DOWNLOADED = "Downloadet";
	const CHRONOFORUMS_POST_REPLY = "Lav et svar";
	const CHRONOFORUMS_REPLY = "Svar";
	const CHRONOFORUMS_POST_TOOLS = "Svar værktøjer";
	const CHRONOFORUMS_EDIT = "Rediger";
	const CHRONOFORUMS_REPORT = "Rapporter";
	const CHRONOFORUMS_INFORMATION = "Information";
	const CHRONOFORUMS_REPLY_QUOTE = "Svar med citat";
	const CHRONOFORUMS_USER_REPORT = "Brugerrapport";
	const CHRONOFORUMS_JOINED = "Meldte sig til";
	const CHRONOFORUMS_RETURN_TO = "Tilbage til";
	const CHRONOFORUMS_NO_POSTS_WERE_FOUND = "No opslag blev fundet.";
	const CHRONOFORUMS_REPORT_CONFIRMATION = "Er du sikker på, at du vil rapportere det nedenstående opslag?";
	const CHRONOFORUMS_REPORT_REASON = "Årsag";
	const CHRONOFORUMS_SEARCH_KEYWORDS = "Søg nøgleord";
	const CHRONOFORUMS_FORUM = "Forum";
	const CHRONOFORUMS_ACCESS_ERROR = "You kan ikke få adgang til dette område.";
	const CHRONOFORUMS_SEARCH_GLOBAL = "Søg alle forums";
	const CHRONOFORUMS_SEARCH_FORUM = "Søg dette forum";
	const CHRONOFORUMS_SEARCH_TOPIC = "Søg denne tråd";
	const CHRONOFORUMS_GO = "Gå";
	const CHRONOFORUMS_UPDATE_TAGS = "Opdater Tags";
	const CHRONOFORUMS_TOPIC_TAGS = "Vælg tråd tags";
	const CHRONOFORUMS_TAGS_NO_RESULTS = "Ingen resultater.";
	const CHRONOFORUMS_DELETE_AUTHOR_CONFIRMATION = "Er du sikker på, at du vil slette brugeren under, inklusiv alle brugerens tråde og opslag?";
	const CHRONOFORUMS_LOCATION = "Sted";
	const CHRONOFORUMS_ABOUT = "Om";
	const CHRONOFORUMS_SIGNATURE = "Signatur";
	const CHRONOFORUMS_AVATAR = "Avatar";
	const CHRONOFORUMS_WEBSITE = "Hjemmeside";
	const CHRONOFORUMS_PROFILE_TITLE = "%ss profil";
	const CHRONOFORUMS_AVATAR_DIMENSIONS_ERROR = "Din avatars dimensioner er større end den maksimale bredde og højde på %s og %s";
	const CHRONOFORUMS_AVATAR_SAVE_ERROR = "Fejl i lagring af avatar fil.";
	const CHRONOFORUMS_PROFILE_UPDATE_ERROR = "Fejl i opdatering af profil.";
	const CHRONOFORUMS_AVATAR_SIZE_ERROR = "Din avatars filstørrelse er større end den maksimale tilladte størrelse på %s";
	const NA = "N/A";
	const CHRONOFORUMS_CATEGORY = "Kategori";
	const CHRONOFORUMS_ON = "Til";
	const CHRONOFORUMS_REPORTED = "Rapporteret";
	const CHRONOFORUMS_ANNOUNCEMENT = "Annoncering";
	const CHRONOFORUMS_LOCKED = "Låst";
	const CHRONOFORUMS_STICKY = "Sticky";
	const CHRONOFORUMS_UNPUBLISHED = "Afpubliceret";
	const CHRONOFORUMS_POPULAR = "Populært";
	const CHRONOFORUMS_HOT = "Hot";
	const CHRONOFORUMS_ANSWERED = "Besvaret";
	const CHRONOFORUMS_SELECT_ANSWER = "Vælg som det rigtige svar";
	const CHRONOFORUMS_ANSWER_SELECTED = "Det valgte svar er blevet markeret som bedste svar.";
	const CHRONOFORUMS_BEST_ANSWER = "Bedste svar";
	const CHRONOFORUMS_ANOTHER_ANSWER_SELECTED = "Et andet svar er blevet valgt for denne tråd.";
	const CHRONOFORUMS_TOPIC_ACCESS_DENIED = "Du har ikke nok tilladelse til at læse denne tråd.";
	const CHRONOFORUMS_QUOTE = "Citat";
	const CHRONOFORUMS_AUTHOR = "Forfatter";
	const CHRONOFORUMS_EMPTY = "Tom";
	const CHRONOFORUMS_READ_POSTS = "Læs opslag";
	const CHRONOFORUMS_HAS_ATTACHMENTS = "Denne tråd har vedhæftninger";
	const CHRONOFORUMS_CLEAR = "Ryd";
	const CHRONOFORUMS_NOREPLIES_TOPIC = "Ubesvaret";
	const CHRONOFORUMS_NOREPLIES_TOPIC_DESC = "Se en liste over emner uden svar";
	const CHRONOFORUMS_NEWPOSTS_TOPIC = "Ny";
	const CHRONOFORUMS_NEWPOSTS_TOPIC_DESC = "Liste af tråde med nye opslag siden dit sidste besøg.";
	const CHRONOFORUMS_ACTIVE_TOPIC = "Aktiv";
	const CHRONOFORUMS_ACTIVE_TOPIC_DESC = "Listen af aktive tråde i de sidste %s dage.";
	const CHRONOFORUMS_PRIVATE_MESSAGING = "Private beskeder";
	const CHRONOFORUMS_PRIVATE_MESSAGING_DESC = "Vis sendte og modtagne private beskeder.";
	const CHRONOFORUMS_SENDER = "Afsender";
	const CHRONOFORUMS_SENT = "Sendt";
	const CHRONOFORUMS_INBOX = "Indbakke";
	const CHRONOFORUMS_OUTBOX = "Udbakke";
	const CHRONOFORUMS_COMPOSE_DESC = "Send ny besked";
	const CHRONOFORUMS_COMPOSE = "Skriv";
	const CHRONOFORUMS_MESSAGES_INVALID_RECIPIENT = "Ugyldig modtager";
	const CHRONOFORUMS_MESSAGES_SEND_FAILED = "Afsendelsen slog fejl!";
	const CHRONOFORUMS_MESSAGES_SEND_SUCCESS = "Din besked er blevet sendt.";
	const CHRONOFORUMS_RECIPIENTS = "Modtagere";
	const CHRONOFORUMS_MESSAGES_LOAD_FAILED = "Kunne ikke vise den valgte besked.";
	const CHRONOFORUMS_MESSAGES_FROM = "Fra";
	const CHRONOFORUMS_MESSAGES_TO = "Til";
	const CHRONOFORUMS_MESSAGE = "Besked";
	const CHRONOFORUMS_QUICK_REPLY = "Hurtigt svar";
	const CHRONOFORUMS_BOARD_PREFERENCES = "Forum indstillinger";
	const CHRONOFORUMS_EDIT_PROFILE = "Rediger profil";
	const CHRONOFORUMS_NO_NEW_POSTS = "Ingen nye opslag";
	const CHRONOFORUMS_HAS_NEW_POSTS = "Har nye opslag";
	const CHRONOFORUMS_MY_PROFILE = "Min profil";
	const CHRONOFORUMS_MY_TOPICS_DESC = "Liste af tråde startet af dig.";
	const CHRONOFORUMS_MY_TOPICS = "Mine tråde";
	const CHRONOFORUMS_START_FROM = "Start fra";
	const CHRONOFORUMS_MONTHS_AGO = "%s måneder siden";
	const CHRONOFORUMS_YEARS_AGO = "%s år siden";
	const CHRONOFORUMS_WEEKS_AGO = "%s uger siden";
	const CHRONOFORUMS_SEARCH_SETTINGS = "Søgeindstillinger";
	const CHRONOFORUMS_SEARCH_SPOOFING_ERROR = "Du kan ikke lave mere end en søgning hver %s sekunder.";
	const CHRONOFORUMS_ADD_TO_FAVORITES = "Føj til favoritter";
	const CHRONOFORUMS_REMOVE_FROM_FAVORITES = "Fjerne fra favoritter";
	const CHRONOFORUMS_FAVORITED_SUCCESS = "Dine favoritter er blevet opdateret!";
	const CHRONOFORUMS_FAVORITES = "Favoritter";
	const CHRONOFORUMS_FAVORITES_DESC = "Liste of dine favorit tråde.";
}