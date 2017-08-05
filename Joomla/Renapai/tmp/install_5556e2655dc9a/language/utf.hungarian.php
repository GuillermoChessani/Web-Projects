<?php
if (!defined('_REM_INTERNAL')) DEFINE('_REM_INTERNAL','Raktár Belső Hiba');
if (!defined('_DOWNLOADS_TITLE')) DEFINE("_DOWNLOADS_TITLE","$mosConfig_sitename :: File Raktár");
if (!defined('_UP_FILE')) DEFINE('_UP_FILE','File feltöltés');
if (!defined('_ADD_FILE_BUTTON')) DEFINE('_ADD_FILE_BUTTON','File hozzáadás');
if (!defined('_SUBMIT_FILE_BUTTON')) DEFINE('_SUBMIT_FILE_BUTTON','File elfogadása');
if (!defined('_SUBMIT_FILE_NOLOG')) DEFINE('_SUBMIT_FILE_NOLOG', 'Elfogadás megtagadva - nincs bejelentkezve');
if (!defined('_SUBMIT_FILE_NOUSER')) DEFINE('_SUBMIT_FILE_NOUSER', 'Elfogadás megtagadva - csak adminisztrátor');
if (!defined('_SUBMIT_FILE_NOLIMIT')) DEFINE('_SUBMIT_FILE_NOLIMIT', 'Elfogadás megtagadva - határtúllépés');
if (!defined('_SUBMIT_FILE_NOSPACE')) DEFINE('_SUBMIT_FILE_NOSPACE', 'Elfogadás megtagadva - nincs több hely');
if (!defined('_SUBMIT_NO_DDIR')) DEFINE('_SUBMIT_NO_DDIR', 'Elfogadás megtagadva - nincs letöltés könyvtár');
if (!defined('_SUBMIT_NO_UDDIR')) DEFINE('_SUBMIT_NO_UDDIR', 'Elfogadás megtagadva - nincs le-fel könyvtár');
if (!defined('_SUBMIT_HEADING')) DEFINE('_SUBMIT_HEADING', 'File feltöltése a raktárba');
if (!defined('_SUBMIT_INSTRUCT1')) DEFINE('_SUBMIT_INSTRUCT1', 'BÁRMELYIK a számítógépének böngészése és a feltölteni kívánt file kiválasztása megosztára.');
if (!defined('_SUBMIT_INSTRUCT2')) DEFINE('_SUBMIT_INSTRUCT2', 'VAGY amennyiben a file létezik már valahol a hálózaton, adja meg az URL-t és a file leírását.');
if (!defined('_SUBMIT_INSTRUCT3')) DEFINE('_SUBMIT_INSTRUCT3', 'Kérem válassza ki a file-t és töltse ki annak részleteit.');
if (!defined('_DOWN_FILE_SUBMIT_NOCHOICES')) DEFINE('_DOWN_FILE_SUBMIT_NOCHOICES','You have no permitted upload categories - please refer to the webmaster');
if (!defined('_SUBMIT_NEW_FILE')) DEFINE('_SUBMIT_NEW_FILE', 'Új file');
if (!defined('_SUBMIT_UPLOAD_BUTTON')) DEFINE('_SUBMIT_UPLOAD_BUTTON', 'File feltöltés és tárolás');
if (!defined('_MAIN_DOWNLOADS')) DEFINE('_MAIN_DOWNLOADS','Főraktár Oldala');
if (!defined('_BACK_CAT')) DEFINE('_BACK_CAT','Vissza az előző kategóriába');
if (!defined('_BACK_FOLDER')) DEFINE('_BACK_FOLDER','Vissza az előző könyvtárba');
if (!defined('_DOWN_START')) DEFINE('_DOWN_START','A letöltés 2 másodpercen belül elkezdődik.');
if (!defined('_DOWN_CLICK')) DEFINE('_DOWN_CLICK','Kattintson ide ha mégsem kezdódne el.');
if (!defined('_INVALID_ID')) DEFINE('_INVALID_ID','Ismeretlen azonosító');
if (!defined('_DOWN_CATEGORY')) DEFINE('_DOWN_CATEGORY','Kategória');
if (!defined('_DOWN_NO_PARENT')) DEFINE('_DOWN_NO_PARENT','No parent - top level **');
if (!defined('_DOWN_FOLDER')) DEFINE('_DOWN_FOLDER','Könyvtár');
if (!defined('_DOWN_FOLDERS')) DEFINE('_DOWN_FOLDERS','Könyvtárak');
if (!defined('_DOWN_FILES')) DEFINE('_DOWN_FILES','File-ok');
if (!defined('_DOWN_FOLDERS_FILES')) DEFINE('_DOWN_FOLDERS_FILES','Folders/Files');
if (!defined('_DOWN_NO_CATS')) DEFINE("_DOWN_NO_CATS","A Raktár még nem készült el a következőn: <i>$mosConfig_sitename</i>.<br/>&nbsp;<br/>Nincs definiálva kategória.");
if (!defined('_DOWN_NO_VISITOR_CATS')) DEFINE('_DOWN_NO_VISITOR_CATS','Sorry, the Repository is not available to casual visitors - please login');
if (!defined('_DOWN_ADMIN_FUNC')) DEFINE('_DOWN_ADMIN_FUNC','Admin funkciók:');
if (!defined('_DOWN_ADD_CAT')) DEFINE('_DOWN_ADD_CAT','Kategória hozzáadása');
if (!defined('_DOWN_DEL_CAT')) DEFINE('_DOWN_DEL_CAT','Kategória törlése');
if (!defined('_DOWN_EDIT_CAT')) DEFINE('_DOWN_EDIT_CAT','Kategória szerkesztése');
if (!defined('_DOWN_UP_NEITHER')) DEFINE('_DOWN_UP_NEITHER','Neither');
if (!defined('_DOWN_UP_DOWNLOAD_ONLY')) DEFINE('_DOWN_UP_DOWNLOAD_ONLY','Download Only');
if (!defined('_DOWN_UP_UPLOAD_ONLY')) DEFINE('_DOWN_UP_UPLOAD_ONLY','Upload Only');
if (!defined('_DOWN_UP_BOTH')) DEFINE('_DOWN_UP_BOTH','Both');
if (!defined('_DOWN_USERS_PERMITTED')) DEFINE('_DOWN_USERS_PERMITTED','Users permitted to:');
if (!defined('_DOWN_VISITORS_PERMITTED')) DEFINE('_DOWN_VISITORS_PERMITTED','Visitors permitted to:');
if (!defined('_DOWN_UP_ABSOLUTE_PATH')) DEFINE('_DOWN_UP_ABSOLUTE_PATH','Absolute path (optional):');
if (!defined('_DOWN_ADD_FOLDER')) DEFINE('_DOWN_ADD_FOLDER','Könyvtár hozzáadása');
if (!defined('_DOWN_DEL_FOLDER')) DEFINE('_DOWN_DEL_FOLDER','Könyvtár törlése');
if (!defined('_DOWN_EDIT_FOLDER')) DEFINE('_DOWN_EDIT_FOLDER','Könyvtár szerkesztése');
if (!defined('_DOWN_ADD_FILE')) DEFINE('_DOWN_ADD_FILE','File hozzáadása');
if (!defined('_DOWN_DEL_FILE')) DEFINE('_DOWN_DEL_FILE','File törlése');
if (!defined('_DOWN_EDIT_FILE')) DEFINE('_DOWN_EDIT_FILE','File szerkesztése');
if (!defined('_DOWN_PUB')) DEFINE('_DOWN_PUB','Publikálva:');
if (!defined('_DOWN_SUBMIT_ANOTHER')) DEFINE('_DOWN_SUBMIT_ANOTHER','Submit another file now?');
if (!defined('_DOWN_SUBMIT_INSPECT')) DEFINE('_DOWN_SUBMIT_INSPECT','View the file just submitted?');
if (!defined('_YES')) DEFINE('_YES','Igen');
if (!defined('_NO')) DEFINE('_NO','Nem');
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
if (!defined('_DOWN_DESC')) DEFINE('_DOWN_DESC','Leírás:');
if (!defined('_DOWN_DOWNLOADS')) DEFINE('_DOWN_DOWNLOADS','Letöltések:');
if (!defined('_DOWN_RATING')) DEFINE('_DOWN_RATING','Értékelés:');
if (!defined('_DOWN_VOTES')) DEFINE('_DOWN_VOTES','Összes szavazat:');
if (!defined('_DOWN_YOUR_VOTE')) DEFINE('_DOWN_YOUR_VOTE','Szavazata:');
if (!defined('_DOWN_RATE_BUTTON')) DEFINE('_DOWN_RATE_BUTTON','Értékelés');
if (!defined('_DOWN_ALREADY_VOTE')) DEFINE('_DOWN_ALREADY_VOTE','Ön már értékelte ezt a letöltést. Köszönjük!');
if (!defined('_DOWN_FILE_TITLE')) DEFINE('_DOWN_FILE_TITLE','File Címe:');
if (!defined('_DOWN_FILE_TITLE_SORT')) DEFINE('_DOWN_FILE_TITLE_SORT','File Címe');
if (!defined('_DOWN_REAL_NAME')) DEFINE('_DOWN_REAL_NAME','File physical name:');
if (!defined('_DOWNLOAD')) DEFINE('_DOWNLOAD','Letöltés');
if (!defined('_DOWN_DOWNLOADS_SORT')) DEFINE('_DOWN_DOWNLOADS_SORT','Letöltések');
if (!defined('_DOWN_SUB_BY')) DEFINE('_DOWN_SUB_BY','Hozzáadta:');
if (!defined('_DOWN_FILE_DATE')) DEFINE('_DOWN_FILE_DATE','File Dátuma:');
if (!defined('_DOWN_FILE_AUTHOR')) DEFINE('_DOWN_FILE_AUTHOR','File Szerzője:');
if (!defined('_DOWN_FILE_VER')) DEFINE('_DOWN_FILE_VER','File Verziója:');
if (!defined('_DOWN_FILE_SIZE')) DEFINE('_DOWN_FILE_SIZE','File Mérete:');
if (!defined('_DOWN_FILE_TYPE')) DEFINE('_DOWN_FILE_TYPE','File Típusa:');
if (!defined('_DOWN_FILE_COMPANY')) DEFINE('_DOWN_FILE_COMPANY','Company:');
if (!defined('_DOWN_FILE_COMPANY_URL')) DEFINE('_DOWN_FILE_COMPANY_URL','Company web site:');
if (!defined('_DOWN_FILE_AUTHOR_URL')) DEFINE('_DOWN_FILE_AUTHOR_URL','Author web site:');
if (!defined('_DOWN_FILE_RELEASE_DATE')) DEFINE('_DOWN_FILE_RELEASE_DATE','Release date (YYYY-MM-DD):');
if (!defined('_DOWN_FILE_STATUS')) DEFINE('_DOWN_FILE_STATUS','Status:');
if (!defined('_DOWN_FILE_LANGUAGES')) DEFINE('_DOWN_FILE_LANGUAGES','Languages:');
if (!defined('_DOWN_FILE_REQUIREMENTS')) DEFINE('_DOWN_FILE_REQUIREMENTS','Requirements:');
if (!defined('_DOWN_FILE_OPERATING_SYSTEM')) DEFINE('_DOWN_FILE_OPERATING_SYSTEM','Operating system:');
if (!defined('_DOWN_SCREEN')) DEFINE('_DOWN_SCREEN','Képernyőkép:');
if (!defined('_DOWN_SCREEN_CLICK')) DEFINE('_DOWN_SCREEN_CLICK','Megtekintéshez kattintson');
if (!defined('_DOWN_NA')) DEFINE('_DOWN_NA','N/A');
if (!defined('_DOWN_CAT_NAME')) DEFINE('_DOWN_CAT_NAME','Kategória neve:');
if (!defined('_DOWN_SUB_BUTTON')) DEFINE('_DOWN_SUB_BUTTON','Irány');
if (!defined('_DOWN_ALL_DONE')) DEFINE('_DOWN_ALL_DONE','Minden rendben!');
if (!defined('_DOWN_NOT_AUTH')) DEFINE('_DOWN_NOT_AUTH','Nem jogosult!');
if (!defined('_DOWN_FOLDER_NAME')) DEFINE('_DOWN_FOLDER_NAME','Könyvtár név:');
if (!defined('_DOWN_FOLDER_ADD_BUT')) DEFINE('_DOWN_FOLDER_ADD_BUT','Könyvtár hozzáadása');
if (!defined('_DOWN_UP_WAIT')) DEFINE('_DOWN_UP_WAIT','Megjegyzés: Minden feltöltés felülvizsgálatra kerül a publikálás előtt.');
if (!defined('_DOWN_AUTOAPP')) DEFINE('_DOWN_AUTOAPP','A file autómatikusan jóváhagyásra és publikálásra került.');
if (!defined('_DOWN_SUGGEST_LOC')) DEFINE('_DOWN_SUGGEST_LOC','Javasolt elhelyezés:');
if (!defined('_DOWNLOAD_URL')) DEFINE('_DOWNLOAD_URL','Letöltési URL:');
if (!defined('_DOWN_ICON')) DEFINE('_DOWN_ICON','Ikon:');
if (!defined('_DOWN_MOVE_FILE')) DEFINE('_DOWN_MOVE_FILE','File mozgatása:');
if (!defined('_DOWN_FILE_NEW_LOC')) DEFINE('_DOWN_FILE_NEW_LOC','A file új helye:');
if (!defined('_DOWN_AWAIT_APPROVE')) DEFINE('_DOWN_AWAIT_APPROVE','File engedélyezés jóváhagyásra vár:');
if (!defined('_DOWN_ADMIN_APPROVE')) DEFINE('_DOWN_ADMIN_APPROVE','Jóváhagyás');
if (!defined('_DOWN_ID')) DEFINE('_DOWN_ID','Azonosító');
if (!defined('_DOWN_SUBMIT_DATE')) DEFINE('_DOWN_SUBMIT_DATE','Jóváhagyás dátuma:');
if (!defined('_DOWN_APP_SUB_BUTTON')) DEFINE('_DOWN_APP_SUB_BUTTON','Jóváhagyás');
if (!defined('_DOWN_DEL_SUB_BUTTON')) DEFINE('_DOWN_DEL_SUB_BUTTON','Elutasítás');
if (!defined('_DOWN_SUB_APPROVE')) DEFINE('_DOWN_SUB_APPROVE','A kérelem jóváhagyva.');
if (!defined('_DOWN_SUB_DEL')) DEFINE('_DOWN_SUB_DEL','A kérelem törölve.');
if (!defined('_DOWN_NO_SUB')) DEFINE('_DOWN_NO_SUB','Nincs több kérelem.');
if (!defined('_DOWN_REV_SUB')) DEFINE('_DOWN_REV_SUB','További kérelmek áttekintése');
if (!defined('_DOWN_SEARCH')) DEFINE('_DOWN_SEARCH','Keresés a Raktárban');
if (!defined('_DOWN_SEARCH_TEXT')) DEFINE('_DOWN_SEARCH_TEXT','Keresés:');
if (!defined('_DOWN_SEARCH_FILETITLE')) DEFINE('_DOWN_SEARCH_FILETITLE','Keresés a File Címben:');
if (!defined('_DOWN_SEARCH_FILEDESC')) DEFINE('_DOWN_SEARCH_FILEDESC','Keresés a File Leírásba:');
if (!defined('_DOWN_SEARCH_ERR')) DEFINE('_DOWN_SEARCH_ERR','Adja meg a a File címet vagy File leírást amelyre keresni akar.');
if (!defined('_DOWN_SEARCH_NORES')) DEFINE('_DOWN_SEARCH_NORES','Nincs találat.');
if (!defined('_DOWN_FILE_HOMEPAGE')) DEFINE('_DOWN_FILE_HOMEPAGE','File Honlap:');
if (!defined('_DOWN_UPDATE_SUB')) DEFINE('_DOWN_UPDATE_SUB','Engedély frissítés');
if (!defined('_DOWN_UP_EDIT_ID')) DEFINE('_DOWN_UP_EDIT_ID','File Azonosító:');
if (!defined('_DOWN_FILE_DEL_NOTE')) DEFINE('_DOWN_FILE_DEL_NOTE','Megjegyzés: A régi filelista törölve lett az adatbázisból, de a fizikai file még létezik.');
if (!defined('_DOWN_SUB_DATE')) DEFINE('_DOWN_SUB_DATE','Feltöltve:');
if (!defined('_DOWN_SUB_DATE_SORT')) DEFINE('_DOWN_SUB_DATE_SORT','Feltöltés dátuma');
if (!defined('_DOWN_COMMENTS')) DEFINE('_DOWN_COMMENTS','Hozzászólások:');
if (!defined('_DOWN_YOUR_COMM')) DEFINE('_DOWN_YOUR_COMM','Az Ön hozzászólása:');
if (!defined('_DOWN_LEAVE_COMM')) DEFINE('_DOWN_LEAVE_COMM','Hozzászólás elhagyása');
if (!defined('_DOWN_FIRST_COMMENT')) DEFINE('_DOWN_FIRST_COMMENT','Legyen az első aki hozzászól!');
if (!defined('_DOWN_FIRST_COMMENT_NL')) DEFINE('_DOWN_FIRST_COMMENT_NL','Legyen az első aki hozzászól! Kérem jelentkezzen be vagy regisztráljon!');
if (!defined('_DOWN_ALREADY_COMM')) DEFINE('_DOWN_ALREADY_COMM','Ön már hozzászólt.');
if (!defined('_DOWN_MAX_COMM')) DEFINE("_DOWN_MAX_COMM","Max: $Small_Text_Len karakter");
if (!defined('_DOWN_DESC_MAX')) DEFINE("_DOWN_DESC_MAX","Max: $Large_Text_Len karakter");
if (!defined('_DOWN_MAIL_SUB')) DEFINE('_DOWN_MAIL_SUB','New Mambo Downloads Submission');
if (!defined('_DOWN_MAIL_MSG')) DEFINE('_DOWN_MAIL_MSG','Üdvözlöm. Egy új Letöltés engedélyezés érkezett $user_full-től'
                   .' a $mosConfig_sitename website-ra.\n'
                   .'Kérem látogassa meg a $mosConfig_live_site/administrator/index.php Admin-ként a jóváhagyáshoz.\n\n'
                   .'Kérem ne válaszoljon erre az üzenetre, mert autómatikusan generálódott és csak informálásra szolgál!\n');
if (!defined('_DOWN_MAIL_MSG_APP')) DEFINE('_DOWN_MAIL_MSG_APP','Hello a new user Downloads submission has been submitted by $user_full'
                   .' for the $mosConfig_sitename website.\n'
                   .'In accordance with the configuration options, it has been auto-appproved.\n\n'
                   .'Please do not respond to this message as it is automatically generated and is for information purposes only\n');
if (!defined('_DOWN_ORDER_BY')) DEFINE('_DOWN_ORDER_BY','Rendezés :');
if (!defined('_DOWN_RESET')) DEFINE('_DOWN_RESET','File-ok újraszámolása');
if (!defined('_DOWN_RESET_GO')) DEFINE('_DOWN_RESET_GO','File-ok újraszámolása...');
if (!defined('_DOWN_RESET_DONE')) DEFINE('_DOWN_RESET_DONE','File-ok újraszámolása megtörtént');
if (!defined('_DOWN_FIND_ORPHANS')) DEFINE('_DOWN_FIND_ORPHANS','Elárvult file-ok keresése');
if (!defined('_DOWN_DEL_ORPHANS')) DEFINE('_DOWN_DEL_ORPHANS','Elárvult file-ok törlése');
if (!defined('_DOWN_ORPHAN_SELECT')) DEFINE('_DOWN_ORPHAN_SELECT','Kiválaszt');
if (!defined('_DOWN_ORPHAN_FILE_DEL')) DEFINE('_DOWN_ORPHAN_FILE_DEL','Törlendő file');
if (!defined('_DOWN_ORPHAN_NODEL')) DEFINE('_DOWN_ORPHAN_NODEL','Nincs törlendő file');
if (!defined('_DOWN_ORPHAN_DONE')) DEFINE('_DOWN_ORPHAN_DONE','Elárvult file-ok törölve');
if (!defined('_DOWN_BAD_POST')) DEFINE('_DOWN_BAD_POST','A beállítások nem lettek megfelelően elküldve az űrlapról.');
if (!defined('_DOWN_SUB_WAIT')) DEFINE('_DOWN_SUB_WAIT','Egy frissített engedélyezés még jóváhagyásra vár ezen a file-on.');
if (!defined('_DOWN_REG_ONLY')) DEFINE('_DOWN_REG_ONLY','Csak regisztrált felhasználók:');
if (!defined('_DOWN_MEMBER_ONLY_WARN')) DEFINE('_DOWN_MEMBER_ONLY_WARN',"This location is for Group Members Only.<BR />"
                             ."Please refer to admin concerning group ");
if (!defined('_DOWN_REG_ONLY_WARN')) DEFINE("_DOWN_REG_ONLY_WARN","Ezt a helyet csak a Regisztrált felhasználók láthatják.<BR />"
                             ."Kérem jelentkezzen be vagy <a href='index.php?option=com_registration&task=register'>Regisztráljon</a>.");
if (!defined('_DOWN_NO_FILEN')) DEFINE('_DOWN_NO_FILEN','Adja meg a file nevét');
if (!defined('_DOWN_MINI_SCREEN_PROMPT')) DEFINE('_DOWN_MINI_SCREEN_PROMPT','Mini képernyőkép mutatása a file listában:');
if (!defined('_DOWN_SEL_LOC_PROMPT')) DEFINE('_DOWN_SEL_LOC_PROMPT','Terület kiválasztása');
if (!defined('_DOWN_ALL_LOC_PROMPT')) DEFINE('_DOWN_ALL_LOC_PROMPT','Összes terület');
if (!defined('_DOWN_SEL_CAT_DEL')) DEFINE('_DOWN_SEL_CAT_DEL','Válassza ki a törlendő kategóriát');
if (!defined('_DOWN_NO_CAT_DEF')) DEFINE('_DOWN_NO_CAT_DEF','Nincs definiált kategória');
if (!defined('_DOWN_PUB_PROMPT')) DEFINE('_DOWN_PUB_PROMPT','Válassza ki a kategóriát melyet ');
if (!defined('_DOWN_SEL_FILE_DEL')) DEFINE('_DOWN_SEL_FILE_DEL','Válassza ki a törlendő file-t');
if (!defined('_DOWN_CONFIG_COMP')) DEFINE('_DOWN_CONFIG_COMP','A konfigurációs beállítások frissítve lettek!');
if (!defined('_DOWN_CONFIG_ERR')) DEFINE("_DOWN_CONFIG_ERR","Hiba történt!\nA konfigurációs file nem nyitható meg írásra!");
if (!defined('_DOWN_CATS')) DEFINE('_DOWN_CATS','Kategóriák');
if (!defined('_DOWN_PARENT_CAT')) DEFINE('_DOWN_PARENT_CAT','Szülő kategória');
if (!defined('_DOWN_PARENT_FOLDER')) DEFINE('_DOWN_PARENT_FOLDER','Szülő könyvtár');
if (!defined('_DOWN_PUB1')) DEFINE('_DOWN_PUB1','Publikálva');
if (!defined('_DOWN_RECORDS')) DEFINE('_DOWN_RECORDS','Rekordok');
if (!defined('_DOWN_ACCESS')) DEFINE('_DOWN_ACCESS','Hozzáférés');
if (!defined('_DOWN_GROUP')) DEFINE('_DOWN_GROUP','Group');
if (!defined('_DOWN_REG_USERS')) DEFINE('_DOWN_REG_USERS','Users');
if (!defined('_DOWN_VISITORS')) DEFINE('_DOWN_VISITORS','Visitors');
if (!defined('_DOWN_ALL_REGISTERED')) DEFINE('_DOWN_ALL_REGISTERED','All Registered Users');
if (!defined('_DOWN_REG_ONLY_TITLE')) DEFINE('_DOWN_REG_ONLY_TITLE','Csak regisztrált');
if (!defined('_DOWN_PUBLIC_TITLE')) DEFINE('_DOWN_PUBLIC_TITLE','Publikus');
if (!defined('_DOWN_APPROVE_TITLE')) DEFINE('_DOWN_APPROVE_TITLE','File-ok jóváhagyásra');
if (!defined('_DOWN_DATE')) DEFINE('_DOWN_DATE','Dátum');
if (!defined('_DOWN_NAME_TITLE')) DEFINE('_DOWN_NAME_TITLE','Név');
if (!defined('_DOWN_CONFIG_TITLE')) DEFINE('_DOWN_CONFIG_TITLE','Konfiguráció');
if (!defined('_DOWN_CONFIG_TITLE1')) DEFINE('_DOWN_CONFIG_TITLE1','Elérési utak és egyebek');
if (!defined('_DOWN_CONFIG_TITLE2')) DEFINE('_DOWN_CONFIG_TITLE2','Jogosultságok');
if (!defined('_DOWN_CONFIG_TITLE3')) DEFINE('_DOWN_CONFIG_TITLE3','Download text');
if (!defined('_DOWN_CONFIG_TITLE4')) DEFINE('_DOWN_CONFIG_TITLE4','Configure pages');
if (!defined('_DOWN_CONFIG1')) DEFINE("_DOWN_CONFIG1","TabClass:<br/><i>(MOS CSS sorok színe váltakozó (Két vesszővel elválasztott értékek))</i>");
if (!defined('_DOWN_CONFIG2')) DEFINE("_DOWN_CONFIG2","TabHeader:<br/><i>(MOS CSS Oldal fejléc és Admin panel háttér)</i>");
if (!defined('_DOWN_CONFIG3')) DEFINE("_DOWN_CONFIG3","Web_Down_Path:<br/><i>(Letöltési tároló elérése - Web - NINCS záró slash)</i>");
if (!defined('_DOWN_CONFIG4')) DEFINE("_DOWN_CONFIG4","Down_Path:<br/><i>(Letöltési tároló elérése - File - NINCS záró slash)</i>");
if (!defined('_DOWN_CONFIG5')) DEFINE("_DOWN_CONFIG5","Up_Path:<br/><i>(File Feltöltési tároló elérése - NINCS záró slash)</i>");
if (!defined('_DOWN_CONFIG6')) DEFINE("_DOWN_CONFIG6","MaxSize:<br/><i>(Maximum feltölthető fileméret Kb-ban)</i>");
if (!defined('_DOWN_CONFIG7')) DEFINE("_DOWN_CONFIG7","Max_Up_Per_Day:<br/><i>(Maximum feltölthető file-ok száma naponta (Az Adminé korlátlan))</i>");
if (!defined('_DOWN_CONFIG8')) DEFINE("_DOWN_CONFIG8","Max_Up_Dir_Space:<br/><i>(Maximum feltöltés könyvtár méret Kb-ban)</i>");
if (!defined('_DOWN_CONFIG9')) DEFINE("_DOWN_CONFIG9","ExtsOk:<br/><i>(Engedélyezett kiterjesztések feltöltésre (Vesszővel elválasztott lista))</i>");
if (!defined('_DOWN_CONFIG10')) DEFINE("_DOWN_CONFIG10","Allowed_Desc_Tags:<br/><i>(HTML Tag-ek engedélyezése a leírásban (Vesszővel elválasztott lista))</i>");
if (!defined('_DOWN_CONFIG11')) DEFINE("_DOWN_CONFIG11","Allow_Up_Overwrite:<br/><i>(Új feltöltések felülírhatják a létező file-okat)</i>");
if (!defined('_DOWN_CONFIG12')) DEFINE("_DOWN_CONFIG12","Allow_User_Sub:<br/><i>(Felhasználók tölthetnek fel file-t - A file-okat az Admin hagyja jóvá)</i>");
if (!defined('_DOWN_CONFIG13')) DEFINE("_DOWN_CONFIG13","Allow_User_Edit:<br/><i>(Felhasználók szerkeszthetik feltöltött file-jaikat - A file-okat az Admin hagyja jóvá újra)</i>");
if (!defined('_DOWN_CONFIG14')) DEFINE("_DOWN_CONFIG14","Allow_User_Up:<br/><i>(Felhasználók tölthetnek fel file-t - A file-okat az Admin hagyja jóvá)</i>");
if (!defined('_DOWN_CONFIG15')) DEFINE("_DOWN_CONFIG15","Allow_Comments:<br/><i>(Felhasználók hozzászólhatnak)</i>");
if (!defined('_DOWN_CONFIG16')) DEFINE("_DOWN_CONFIG16","Send_Sub_Mail:<br/><i>(Levél küldése az Admin-nak (vagy azzal egyenértékűnek) ha a felhasználó feltölt egy file-t)</i>");
if (!defined('_DOWN_CONFIG17')) DEFINE("_DOWN_CONFIG17","Sub_Mail_Alt_Addr:<br/><i>(Eltérő Email cím melyre a jóváhagyási igények érkeznek, máskülönban az Admin kapja)</i>");
if (!defined('_DOWN_CONFIG18')) DEFINE("_DOWN_CONFIG18","Sub_Mail_Alt_Name:<br/><i>(Eltérő címzett név, jóváhagyási figyelmeztetéshez)</i>");
if (!defined('_DOWN_CONFIG19')) DEFINE("_DOWN_CONFIG19","HeaderPic:<br/><i>(Fejléc grafika)</i>");
if (!defined('_DOWN_CONFIG20')) DEFINE("_DOWN_CONFIG20","Anti-Leach:<br/><i>(File-ok elrejtése a közvetlen linkelés megelőzésére)</i>");
if (!defined('_DOWN_CONFIG21')) DEFINE("_DOWN_CONFIG21","Large_Text_Len:<br/><i>(Maximum tárolási méret a hosszú mezőknél (Leírás/Licensz))</i>");
if (!defined('_DOWN_CONFIG22')) DEFINE("_DOWN_CONFIG22","Small_Text_Len:<br/><i>(Maximum tárolási méret a rövid mezőknél)</i>");
if (!defined('_DOWN_CONFIG23')) DEFINE("_DOWN_CONFIG23","Small_Image_Width:<br/><i>(Kis képernyőkép szélesség)</i>");
if (!defined('_DOWN_CONFIG24')) DEFINE("_DOWN_CONFIG24","Small_Image_Height:<br/><i>(Kis képernyőkép magasság)</i>");
if (!defined('_DOWN_CONFIG25')) DEFINE("_DOWN_CONFIG25","Allow_Votes:<br/><i>(Felhasználók értékelhetik a file-okat)</i>");
if (!defined('_DOWN_CONFIG26')) DEFINE("_DOWN_CONFIG26","Enable_Admin_Autoapp:<br/><i>(Az Admin által feltöltött file-ok automatikusan jóváhagyásra kerülnek és publikálódnak)</i>");
if (!defined('_DOWN_CONFIG27')) DEFINE("_DOWN_CONFIG27","Enable_User_Autoapp:<br/><i>(A Regisztrált felhasználók által feltöltött file-ok automatikusan jóváhagyásra kerülnek és publikálódnak)</i>");
if (!defined('_DOWN_CONFIG28')) DEFINE("_DOWN_CONFIG28","Enable_List_Downloads:<br/><i>(Letöltés engedélyezése kategóriából/könyvtárból)</i>");
if (!defined('_DOWN_CONFIG29')) DEFINE("_DOWN_CONFIG29","Felhasználók beküldhetnek távoli file-okat:<br/><i>(File-ok melyek máshol vannak tárolva)</i>");
if (!defined('_DOWN_CONFIG30')) DEFINE("_DOWN_CONFIG30","Favourites_Max:<br/><i>(Felhasználól eltárolhatják kedvenceiket)</i>");
if (!defined('_DOWN_CONFIG31')) DEFINE("_DOWN_CONFIG31","Date_Format:<br/><i>(A Raktár dátum formátuma - PHP dátum formátum 1)</i>");
if (!defined('_DOWN_CONFIG32')) DEFINE("_DOWN_CONFIG32","Default_Version:<br/><i>(Alapértelmezett file verzió új feltöltéseknél)</i>");
if (!defined('_DOWN_CONFIG33')) DEFINE('_DOWN_CONFIG33','See_Containers_no_download:<br/><i>(Allow users to see categories/folders where they cannot download)</i>');
if (!defined('_DOWN_CONFIG34')) DEFINE('_DOWN_CONFIG34','See_Files_no_download:<br/><i>(Allow users to see files they cannot download)</i>');
if (!defined('_DOWN_CONFIG35')) DEFINE('_DOWN_CONFIG35','Max_Thumbnails:<br/><i>(Maximum thumbnail images to be stored; 0 for URL only)</i>');
if (!defined('_DOWN_CONFIG36')) DEFINE("_DOWN_CONFIG36","Large_Image_Width:<br/><i>(Large Screenshot Width)</i>");
if (!defined('_DOWN_CONFIG37')) DEFINE("_DOWN_CONFIG37","Large_Image_Height:<br/><i>(Large Screenshot Height)</i>");
if (!defined('_DOWN_CONFIG38')) DEFINE("_DOWN_CONFIG38","Allow Large Image Display:<br/><i>(Large Screenshot popup window)</i>");
if (!defined('_DOWN_CONFIG39')) DEFINE("_DOWN_CONFIG39","Store files in database, by default");
if (!defined('_DOWN_STATS_TITLE')) DEFINE('_DOWN_STATS_TITLE','Statisztika');
if (!defined('_DOWN_TOP_TITLE')) DEFINE('_DOWN_TOP_TITLE','Csúcs');
if (!defined('_DOWN_RATED_TITLE')) DEFINE('_DOWN_RATED_TITLE','Értékelés');
if (!defined('_DOWN_VOTED_ON')) DEFINE('_DOWN_VOTED_ON','Szavazat');
if (!defined('_DOWN_VOTES_TITLE')) DEFINE('_DOWN_VOTES_TITLE','Szavazatok');
if (!defined('_DOWN_RATING_TITLE')) DEFINE('_DOWN_RATING_TITLE','Értékelés');
if (!defined('_DOWN_ABOUT')) DEFINE('_DOWN_ABOUT','Névjegy');
if (!defined('_DOWN_TITLE_ABOUT')) DEFINE('_DOWN_TITLE_ABOUT','Cím');
if (!defined('_DOWN_VERSION_ABOUT')) DEFINE('_DOWN_VERSION_ABOUT','Verzió');
if (!defined('_DOWN_AUTHOR_ABOUT')) DEFINE('_DOWN_AUTHOR_ABOUT','Szerző');
if (!defined('_DOWN_WEBSITE_ABOUT')) DEFINE('_DOWN_WEBSITE_ABOUT','WebSite');
if (!defined('_DOWN_EMAIL_ABOUT')) DEFINE('_DOWN_EMAIL_ABOUT','E-Mail');
if (!defined('_DOWN_SEL_FILE_APPROVE')) DEFINE('_DOWN_SEL_FILE_APPROVE','Válassza ki a jóváhagyandó file-t');
if (!defined('_DOWN_DESC_SMALL')) DEFINE('_DOWN_DESC_SMALL','Rövid leírás:');
if (!defined('_DOWN_DESC_SMALL_MAX')) DEFINE('_DOWN_DESC_SMALL_MAX','Max: 150 karakter');
if (!defined('_DOWN_AUTO_SHORT')) DEFINE('_DOWN_AUTO_SHORT','Autómatikus rövid leírás:');
if (!defined('_DOWN_LICENSE')) DEFINE('_DOWN_LICENSE','Licensz:');
if (!defined('_DOWN_LICENSE_AGREE')) DEFINE('_DOWN_LICENSE_AGREE','Licenszt jóvá kell hagyni:');
if (!defined('_DOWN_LEECH_WARN')) DEFINE('_DOWN_LEECH_WARN','A session-je nincs jóváhagyva és a Anti-leach rendszer aktiválva van.');
if (!defined('_DOWN_LICENSE_WARN')) DEFINE('_DOWN_LICENSE_WARN','Kérem olvassa/fogadja el a licenszben foglaltakat.');
if (!defined('_DOWN_LICENSE_CHECKBOX')) DEFINE('_DOWN_LICENSE_CHECKBOX','Elfogadom a feltételeket.');
if (!defined('_DOWN_DATE_FORMAT')) DEFINE("_DOWN_DATE_FORMAT","%Y %B %d"); //Uses PHP's strftime Command Format
if (!defined('_DOWN_FILE_NOTFOUND')) DEFINE('_DOWN_FILE_NOTFOUND','File nem található');
if (!defined('_DOWN_ACCESS_GROUP')) DEFINE('_DOWN_ACCESS_GROUP','Permitted group:');
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
if (!defined('_DOWNLOAD_UPLOAD_TITLE')) DEFINE('_DOWNLOAD_UPLOAD_TITLE','File feltöltése');
if (!defined('_HEAD')) DEFINE('_HEAD','File feltöltése');
if (!defined('_FILE')) DEFINE('_FILE','Feltöltendő file:');
if (!defined('_CLOSE')) DEFINE('_CLOSE','Bezárás');
if (!defined('_SENDFILE')) DEFINE('_SENDFILE','File küldése');
if (!defined('_ERR1')) DEFINE('_ERR1','Ez a file meghatározatlan.');
if (!defined('_ERR2')) DEFINE('_ERR2','File feltöltési támadás');
if (!defined('_ERR3')) DEFINE('_ERR3','A feltöltendő file nulla hosszúságú!');
if (!defined('_ERR4')) DEFINE('_ERR4','A feltöltendő file kiterjesztése nem megengedett!');
if (!defined('_ERR5')) DEFINE('_ERR5','A feltöltendő file mérete túllépi a megengedettet: ');
if (!defined('_ERR6')) DEFINE('_ERR6','A feltöltendő file már létezik. Adjon meg egy új file nevet.');
if (!defined('_ERR7')) DEFINE('_ERR7','A feltöltési könyvtár tele van.');
if (!defined('_ERR8')) DEFINE('_ERR8','Csak az Admin és a Regisztrált felhasználók tölthetnek fel');
if (!defined('_ERR9')) DEFINE('_ERR9','Elérte a napi feltöltési határt.');
if (!defined('_ERR10')) DEFINE('_ERR10','Felhasználói feltöltés nem engedélyezett.');
if (!defined('_ERR11')) DEFINE('_ERR11','File feltöltés sikertelen a köv. kóddal ');
if (!defined('_UP_SUCCESS')) DEFINE('_UP_SUCCESS','Sikeres file feltöltés!');
if (!defined('_UPLOAD_URL_LOCK')) DEFINE('_UPLOAD_URL_LOCK','-File feltöltve-');
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