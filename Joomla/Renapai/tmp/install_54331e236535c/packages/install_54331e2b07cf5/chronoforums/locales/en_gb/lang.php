<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace GCore\Extensions\Chronoforums\Locales\EnGb;
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
	
	
	const CHRONOFORUMS_SPOOFING_ERROR = "You can't post that soon.";
	const CHRONOFORUMS_FORUM_ACCESS_DENIED = "You don't have enough permissions to access this forum/section.";
	const CHRONOFORUMS_FORUM_ACTION_DENIED = "You don't have enough permissions to take this action on this forum/section.";
	const CHRONOFORUMS_EXTENSION_NOT_ALLOWED = "File extension is not allowed.";
	const CHRONOFORUMS_FILE_SAVE_ERROR = "Error saving uploaded file.";
	const CHRONOFORUMS_POST_REPORTED_SUBJECT = "A forum post has been reported at {domain}";
	const CHRONOFORUMS_POST_REPORTED_BODY = "Some user has reported a post at {url}";
	const CHRONOFORUMS_NEW_REPLY_SUBJECT = "Topic reply notification - \"{Topic.title}\"";
	const CHRONOFORUMS_NEW_REPLY_SUBJECT_EXT1 = " - [TUID#{Topic.params.uid}]";
	const CHRONOFORUMS_NEW_REPLY_BODY = "A new reply has been made to one of the topics you are subscribed to, you may check it at this link:\n\n {Topic.title_link}\n";
	const CHRONOFORUMS_NEW_REPLY_BODY_EXT1 = "\n\n The new reply was made by: {Post.author_name}\n\nAnd the message was:\n{Post.text}\n\nYou can post a reply by replying to this Email, just leave the subject line intact.";
	const CHRONOFORUMS_NEW_TOPIC_SUBJECT = "A new topic has been posted on {domain}";
	const CHRONOFORUMS_NEW_TOPIC_BODY = "A new topic has been posted on {domain}, you may check it at the link below\n\n {Topic.title_link}\n";
	const CHRONOFORUMS_NEW_POST_SUBJECT = "A new post has been made on {domain}";
	const CHRONOFORUMS_NEW_POST_BODY = "A new post has been made at {domain}, you may check it at the link below\n\n {Topic.title_link}\n";
	const CHRONOFORUMS_POST_EDIT_SUBJECT = "Forum post edited on {domain}";
	const CHRONOFORUMS_POST_EDIT_BODY = "Forum post edited on {domain}, you may check it at the link below\n\n {Topic.title_link}\n";
	const CHRONOFORUMS_NEW_PM_SUBJECT = "A new private message has been sent to you on {domain}";
	const CHRONOFORUMS_NEW_PM_BODY = "A new private message has been sent to you by '{Message.sender}' at {domain}, you may check it at the link below\n\n {Message.link}\n";
	const CHRONOFORUMS_FORUM_DOESNT_EXIST = "This forum doesn't exist or some error has occurred.";
	const CHRONOFORUMS_FORUM_IS_OFFLINE = "This forum is currently offline.";
	const CHRONOFORUMS_PAGE_DOESNT_EXIST = "Page not found";
	const CHRONOFORUMS_TOPIC_DOESNT_EXIST = "This topic doesn't exist or some error might have occurred.";
	const CHRONOFORUMS_TOPIC_IS_OFFLINE = "This topic is offline or has not been approved yet by a moderator.";
	const CHRONOFORUMS_TOPIC_LOCKED_ERROR = "This topic is locked and no more posts can be made.";
	const CHRONOFORUMS_TOPIC_AUTOLOCKED_ERROR = "This topic has been auto locked for inactivity.";
	const CHRONOFORUMS_PERMISSIONS_ERROR = "Access denied, you are not permitted to access this resource, you may not be logged in or your account may not have enough permissions.";
	const CHRONOFORUMS_SAVE_ERROR = "Save failed.";
	const CHRONOFORUMS_DELETE_ERROR = "Delete failed.";
	const CHRONOFORUMS_TOPIC_POSTED_NOT_PUBLISHED = "Your topic has been posted but is waiting approval by one of our moderators.";
	const CHRONOFORUMS_POST_POSTED_NOT_PUBLISHED = "Your reply has been posted but is waiting approval by one of our moderators.";
	const CHRONOFORUMS_NON_APPROVED_LIMIT_REACHED = "You have reached the maximum number of posts pending approval, please wait until some of your posts get approved by moderators.";
	const CHRONOFORUMS_TOPIC_LOCK_SUCCESS = "Topic has been successfully locked!";
	const CHRONOFORUMS_TOPIC_LOCK_ERROR = "An error has occurred when trying to lock the topic.";
	const CHRONOFORUMS_TOPIC_UNLOCK_SUCCESS = "Topic has been successfully unlocked!";
	const CHRONOFORUMS_TOPIC_UNLOCK_ERROR = "An error has occurred when trying to unlock the topic.";
	const CHRONOFORUMS_UPDATE_SUCCESS = "Updated successfully!";
	const CHRONOFORUMS_UPDATE_ERROR = "Update failed.";
	const CHRONOFORUMS_DELETE_SUCCESS = "Deleted successfully!";
	const CHRONOFORUMS_SUBSCRIBE_SUCCESS = "Subscribed successfully.";
	const CHRONOFORUMS_UNSUBSCRIBE_SUCCESS = "Unsubscribed successfully.";
	const CHRONOFORUMS_CODE = "Code";
	const CHRONOFORUMS_REPORT_DELETED = "Report deleted";
	const CHRONOFORUMS_SELECT_ALL = "Select all";
	const CHRONOFORUMS_MOVE_TOPIC = "Move topic";
	const CHRONOFORUMS_WROTE = "wrote";
	const CHRONOFORUMS_BOARD_INDEX = "Board Index";
	const CHRONOFORUMS_UNSUBSCRIBE_TOPIC = "Unsubscribe topic";
	const CHRONOFORUMS_SUBSCRIBE_TOPIC_DESC = "Notify me when new posts are made to this topic.";
	const CHRONOFORUMS_SUBSCRIBE_TOPIC = "Subscribe topic";
	const CHRONOFORUMS_SEARCH = "Search";
	const CHRONOFORUMS_QUICK_TASKS = "Quick Tasks";
	const CHRONOFORUMS_DELETE_TOPIC = "Delete Topic (including posts)";
	const CHRONOFORUMS_DELETE_AUTHOR = "Delete Author (including all their topics & posts)";
	const CHRONOFORUMS_LOCK_TOPIC = "Lock Topic";
	const CHRONOFORUMS_UNLOCK_TOPIC = "Unlock Topic";
	const CHRONOFORUMS_SET_ANNOUNCEMENT = "Set Announcement";
	const CHRONOFORUMS_UNSET_ANNOUNCEMENT = "Unset Announcement";
	const CHRONOFORUMS_SET_STICKY = "Set Sticky";
	const CHRONOFORUMS_UNSET_STICKY = "Unset Sticky";
	const CHRONOFORUMS_PUBLISH_TOPIC = "Publish/Approve Topic";
	const CHRONOFORUMS_UNPUBLISH_TOPIC = "Unpublish Topic";
	const CHRONOFORUMS_SUBJECT = "Subject";
	const CHRONOFORUMS_BOLD_TEXT = "Bold text";
	const CHRONOFORUMS_ITALIC_TEXT = "Italic text";
	const CHRONOFORUMS_UNDERLINE_TEXT = "Underline text";
	const CHRONOFORUMS_QUOTE_TEXT = "Quote text";
	const CHRONOFORUMS_CODE_DISPLAY = "Code display";
	const CHRONOFORUMS_LIST = "List";
	const CHRONOFORUMS_ORDERED_LIST = "Ordered list";
	const CHRONOFORUMS_INSERT_IMAGE = "Insert image";
	const CHRONOFORUMS_INSERT_URL = "Insert URL";
	const CHRONOFORUMS_INLINE_ATTACHMENT = "Inline attachment";
	const CHRONOFORUMS_FONT_COLOR = "Font colour";
	const CHRONOFORUMS_FONT_SIZE = "Font size";
	const CHRONOFORUMS_LIST_ELEMENT = "List element";
	const CHRONOFORUMS_FLASH = "Flash";
	const CHRONOFORUMS_HIDE_FONT_COLOR = "Hide font colour";
	const CHRONOFORUMS_TINY = "Tiny";
	const CHRONOFORUMS_SMALL = "Small";
	const CHRONOFORUMS_NORMAL = "Normal";
	const CHRONOFORUMS_LARGE = "Large";
	const CHRONOFORUMS_HUGE = "Huge";
	const CHRONOFORUMS_SMILIES = "Smilies";
	const CHRONOFORUMS_FILE_COMMENT = "File comment";
	const CHRONOFORUMS_FILE_INFO = "File info";
	const CHRONOFORUMS_PLACE_INLINE = "Place inline";
	const CHRONOFORUMS_DELETE_FILE = "Delete file";
	const CHRONOFORUMS_ATTACH_FILE = "Attach file";
	const CHRONOFORUMS_UPLOAD = "Upload";
	const CHRONOFORUMS_CANCEL = "Cancel";
	const CHRONOFORUMS_SUBMIT = "Submit";
	const CHRONOFORUMS_PREVIEW = "Preview";
	const CHRONOFORUMS_SEARCH_FOUND = "Search found %s results for:";
	const CHRONOFORUMS_POST_NEW_TOPIC = "Post a new topic";
	const CHRONOFORUMS_NEW_TOPIC = "New Topic";
	const CHRONOFORUMS_PAGINATOR_INFO = "Showing %s to %s of %s entries.";
	const CHRONOFORUMS_PAGINATOR_PREV = "Previous";
	const CHRONOFORUMS_PAGINATOR_FIRST = "First";
	const CHRONOFORUMS_PAGINATOR_LAST = "Last";
	const CHRONOFORUMS_PAGINATOR_NEXT = "Next";
	const CHRONOFORUMS_TOPICS = "Topics";
	const CHRONOFORUMS_REPLIES = "Replies";
	const CHRONOFORUMS_VIEWS = "Views";
	const CHRONOFORUMS_LASTPOST = "Last Post";
	const CHRONOFORUMS_NO_UNREAD_POSTS = "No unread posts";
	const CHRONOFORUMS_TOPIC_REPORTED = "This topic has been reported.";
	const CHRONOFORUMS_TOPIC_NOT_APPROVED = "This topic has not been approved.";
	const CHRONOFORUMS_ATTACHMENTS = "Attachments";
	const CHRONOFORUMS_BY = "by";
	const CHRONOFORUMS_VIEW_PROFILE = "View user's profile.";
	const CHRONOFORUMS_GUEST = "Guest";
	const CHRONOFORUMS_NO_POSTS = "No Posts";
	const CHRONOFORUMS_ITS_CURRENTLY = "It's currently";
	const CHRONOFORUMS_POSTS = "Posts";
	const CHRONOFORUMS_NO_TOPICS = "No topics";
	const CHRONOFORUMS_VIEW_LATEST_POST = "View the latest post";
	const CHRONOFORUMS_DELETE_CONFIRMATION = "Are you sure that you want to delete the post below ?";
	const CHRONOFORUMS_DELETE = "Delete";
	const CHRONOFORUMS_VIEWED = "Viewed";
	const CHRONOFORUMS_TIMES = "time(s)";
	const CHRONOFORUMS_DOWNLOADED = "Downloaded";
	const CHRONOFORUMS_POST_REPLY = "Post a reply";
	const CHRONOFORUMS_REPLY = "Reply";
	const CHRONOFORUMS_POST_TOOLS = "Post Tools";
	const CHRONOFORUMS_EDIT = "Edit";
	const CHRONOFORUMS_REPORT = "Report";
	const CHRONOFORUMS_INFORMATION = "Information";
	const CHRONOFORUMS_REPLY_QUOTE = "Reply with quote";
	const CHRONOFORUMS_USER_REPORT = "User report";
	const CHRONOFORUMS_JOINED = "Joined";
	const CHRONOFORUMS_PUBLISH = "Publish";
	const CHRONOFORUMS_UNPUBLISH = "Unpublish";
	const CHRONOFORUMS_POST_PUBLISHED = "Post has been published";
	const CHRONOFORUMS_POST_UNPUBLISHED = "Post has been unpublished";
	const CHRONOFORUMS_RETURN_TO = "Return to";
	const CHRONOFORUMS_NO_POSTS_WERE_FOUND = "No posts were found.";
	const CHRONOFORUMS_REPORT_CONFIRMATION = "Are you sure that you want to report the post below ?";
	const CHRONOFORUMS_REPORT_REASON = "Reason";
	const CHRONOFORUMS_SEARCH_KEYWORDS = "Search keywords";
	const CHRONOFORUMS_FORUM = "Forum";
	const CHRONOFORUMS_ERROR_OCCURRED = "Error occurred.";
	const CHRONOFORUMS_CONFIRM = "Confirm";
	const CHRONOFORUMS_MOVE_TOPIC_CONFIRMATION = "Do you really want to move the selected topic(s) to the forum below ?";
	const CHRONOFORUMS_ACCESS_ERROR = "You can't access this area.";
	const CHRONOFORUMS_SEARCH_GLOBAL = "Search all forums";
	const CHRONOFORUMS_SEARCH_FORUM = "Search this forum";
	const CHRONOFORUMS_SEARCH_TOPIC = "Search this topic";
	const CHRONOFORUMS_GO = "Go";
	const CHRONOFORUMS_UPDATE_TAGS = "Update Tags";
	const CHRONOFORUMS_TOPIC_TAGS = "Select topic tags";
	const CHRONOFORUMS_TAGS_NO_RESULTS = "No results found.";
	const CHRONOFORUMS_DELETE_AUTHOR_CONFIRMATION = "Are you sure that you want to delete the user(s) below including all their topics and posts ?";
	const CHRONOFORUMS_LOCATION = "Location";
	const CHRONOFORUMS_ABOUT = "About";
	const CHRONOFORUMS_SIGNATURE = "Signature";
	const CHRONOFORUMS_AVATAR = "Avatar";
	const CHRONOFORUMS_WEBSITE = "Website";
	const CHRONOFORUMS_PROFILE_TITLE = "%s's profile";
	const CHRONOFORUMS_AVATAR_DIMENSIONS_ERROR = "Your avatar dimensions exceed the maximum width and height of %s and %s";
	const CHRONOFORUMS_AVATAR_SAVE_ERROR = "Error saving avatar file.";
	const CHRONOFORUMS_PROFILE_UPDATE_ERROR = "Error updating profile data.";
	const CHRONOFORUMS_AVATAR_SIZE_ERROR = "Your avatar file size exceeds the maximum allowed size of %s";
	const NA = "N/A";
	const CHRONOFORUMS_CATEGORY = "Category";
	const CHRONOFORUMS_ON = "On";
	const CHRONOFORUMS_REPORTED = "Reported";
	const CHRONOFORUMS_ANNOUNCEMENT = "Announcement";
	const CHRONOFORUMS_LOCKED = "Locked";
	const CHRONOFORUMS_STICKY = "Sticky";
	const CHRONOFORUMS_UNPUBLISHED = "Unpublished";
	const CHRONOFORUMS_POPULAR = "Popular";
	const CHRONOFORUMS_HOT = "Hot";
	const CHRONOFORUMS_ANSWERED = "Solved";
	const CHRONOFORUMS_SELECT_ANSWER = "Mark as the correct answer";
	const CHRONOFORUMS_ANSWER_SELECTED = "The selected post has been marked as best answer.";
	const CHRONOFORUMS_BEST_ANSWER = "Best Answer";
	const CHRONOFORUMS_ANOTHER_ANSWER_SELECTED = "Another answer has been selected for this topic.";
	const CHRONOFORUMS_TOPIC_ACCESS_DENIED = "You don't have enough permissions to read this topic.";
	const CHRONOFORUMS_QUOTE = "Quote";
	const CHRONOFORUMS_AUTHOR = "Author";
	const CHRONOFORUMS_EMPTY = "Empty";
	const CHRONOFORUMS_READ_POSTS = "Read posts";
	const CHRONOFORUMS_HAS_ATTACHMENTS = "This topic has attachments";
	const CHRONOFORUMS_CLEAR = "Clear";
	const CHRONOFORUMS_NOREPLIES_TOPIC = "Unanswered";
	const CHRONOFORUMS_NOREPLIES_TOPIC_DESC = "View a list of topics with no replies";
	const CHRONOFORUMS_NEWPOSTS_TOPIC = "New";
	const CHRONOFORUMS_NEWPOSTS_TOPIC_DESC = "List of topics with new posts since your last visit.";
	const CHRONOFORUMS_ACTIVE_TOPIC = "Active";
	const CHRONOFORUMS_ACTIVE_TOPIC_DESC = "List of active topics in the last %s days.";
	const CHRONOFORUMS_PRIVATE_MESSAGING = "Private messaging";
	const CHRONOFORUMS_PRIVATE_MESSAGING_DESC = "Display sent and received private messages.";
	const CHRONOFORUMS_SENDER = "Sender";
	const CHRONOFORUMS_SENT = "Sent";
	const CHRONOFORUMS_INBOX = "Inbox";
	const CHRONOFORUMS_OUTBOX = "Outbox";
	const CHRONOFORUMS_COMPOSE_DESC = "Send new message";
	const CHRONOFORUMS_COMPOSE = "Compose";
	const CHRONOFORUMS_MESSAGES_INVALID_RECIPIENT = "Invalid recipient";
	const CHRONOFORUMS_MESSAGES_SEND_FAILED = "Sending failed!";
	const CHRONOFORUMS_MESSAGES_SEND_SUCCESS = "Your message has been sent.";
	const CHRONOFORUMS_RECIPIENTS = "Recipients";
	const CHRONOFORUMS_MESSAGES_LOAD_FAILED = "Could not load the requested message.";
	const CHRONOFORUMS_MESSAGES_FROM = "From";
	const CHRONOFORUMS_MESSAGES_TO = "To";
	const CHRONOFORUMS_MESSAGE = "Message";
	const CHRONOFORUMS_QUICK_REPLY = "Quick reply";
	const CHRONOFORUMS_BOARD_PREFERENCES = "Board preferences";
	const CHRONOFORUMS_EDIT_PROFILE = "Edit profile";
	const CHRONOFORUMS_NO_NEW_POSTS = "No new posts";
	const CHRONOFORUMS_HAS_NEW_POSTS = "Has new posts";
	const CHRONOFORUMS_MY_PROFILE = "My profile";
	const CHRONOFORUMS_MY_TOPICS_DESC = "List of topics you have posted or you are subscribed to.";
	const CHRONOFORUMS_MY_TOPICS = "My topics";
	const CHRONOFORUMS_START_FROM = "Starting from";
	const CHRONOFORUMS_MONTHS_AGO = "%s months ago";
	const CHRONOFORUMS_YEARS_AGO = "%s years ago";
	const CHRONOFORUMS_WEEKS_AGO = "%s weeks ago";
	const CHRONOFORUMS_SEARCH_SETTINGS = "Search settings";
	const CHRONOFORUMS_SEARCH_SPOOFING_ERROR = "You can't do more than 1 search in less than %s seconds.";
	const CHRONOFORUMS_ADD_TO_FAVORITES = "Add to favorites";
	const CHRONOFORUMS_REMOVE_FROM_FAVORITES = "Remove from favorites";
	const CHRONOFORUMS_FAVORITED_SUCCESS = "Your favorites have been updated successfully.";
	const CHRONOFORUMS_FAVORITES = "Favorites";
	const CHRONOFORUMS_FAVORITES_DESC = "List of your favorite topics.";
	const CHRONOFORUMS_AUTHOR_DELETE_ERROR = "Delete failed or has been blocked by a security rule.";
	const CHRONOFORUMS_ADD_TO_FEATURED = "Add to featured list";
	const CHRONOFORUMS_REMOVE_FROM_FEATURED = "Remove from featured list";
	const CHRONOFORUMS_FEATURED_SUCCESS = "Topic has been successfully featured.";
	const CHRONOFORUMS_UNFEATURED_SUCCESS = "Topic has been successfully unfeatured.";
	const CHRONOFORUMS_FEATURED_DESC = "List of featured topics.";
	const CHRONOFORUMS_FEATURED = "Featured";
	const CHRONOFORUMS_VOTE_UP = "Like";
	const CHRONOFORUMS_VOTE_DOWN = "Dislike";
	const CHRONOFORUMS_POST_VOTED_BEFORE = "You have already voted for this post before.";
	const CHRONOFORUMS_POST_VOTED = "Your vote has been made.";
	const CHRONOFORUMS_VOTE_ERROR = "Vote error.";
	const CHRONOFORUMS_SEND_PRIVATE_MESSAGING = "Send a private message to this user";
	const CHRONOFORUMS_ONLINE = "Online";
	const CHRONOFORUMS_PM = "PM";
	const CHRONOFORUMS_REPUTATION = "Reputation";
	const CHRONOFORUMS_UNPUBLISHED_DESC = "List of topics which are unpublished or need approval.";
	const CHRONOFORUMS_EXPAND = "Expand";
	const CHRONOFORUMS_COLLAPSE = "Collapse";
	const CHRONOFORUMS_NO_MORE_POSTS = "No more posts to display...";
	const CHRONOFORUMS_LOAD_MORE_POSTS = "Load more posts!";
}