<?php
require_once CMA_PATH . '/lib/models/SettingsAbstract.php';

class CMA_Settings extends CMA_SettingsAbstract {
	
	public static $categories = array(
		'installation' => 'Installation Guide',
		'general' => 'General',
		'appearance' => 'Appearance',
		'thread' => 'Thread',
		'access_control' => 'Access and moderation',
		'notifications' => 'Notifications',
		'social_login' => 'Social Login',
		'ads' => 'Advertisements',
		'labels' => 'Labels',
		'custom_css' => 'Custom CSS',
		'upgrade' => 'Upgrade',
	);
	
	public static $subcategories = array(
		'general' => array(
			'general' => 'General',
			'seo' => 'SEO',
			'disclaimer' => 'Disclaimer',
			'chat_gpt' => 'Chat GPT',
			'gemini' => 'Gemini',
			'referrals' => 'Referrals',
			'other' => 'Other',
		),
		'thread' => array(
			'question' => 'Questions',
			'answer' => 'Answers',
			'comments' => 'Comments',
			'common' => 'Common',
			'attachments' => 'Attachments',
			'spam' => 'Spam reporting',
			'private_questions' => 'Private questions',
			'bad_words' => 'Bad words',
			'question_stages' => 'Question stages',
		),
		'appearance' => array(
			'index' => 'Index page',
			'table' => 'Table of questions',
			'rating' => 'Questions rating',
			'thread' => 'Thread page',
			'attachments' => 'Attachments',
			'editor' => 'Editor',
			'navigation' => 'Navigation',
			'login' => 'Login Widget',
			'sidebar' => 'Sidebar',
			'misc' => 'Miscellaneous',
		),
		'access_control' => array(
			'access' => 'Access Control',
			'moderation' => 'Moderation',
			'other' => 'Other',
		),
		'notifications' => array(
			'notifications' => 'Notifications',
			'question' => 'New questions',
			'answer' => 'New answers',
			'comment' => 'New comments',
			'best_answer' => 'Best answer',
			'rejected' => 'Rejected content',
			'other' => 'Other',
		),
		'ads' => array(
			'index' => 'Index page',
			'thread' => 'Thread page',
		),
	);
	
	const TEXT_DOMAIN = 'cm-answers-pro-backend';
	const DEFAULT_TAG_EDIT_PAGE_TITLE = 'cma_default_tag_edit_page_title';
		
	// General
	const OPTION_ANSWERS_PERMALINK = 'cma_answers_permalink';
	const OPTION_CATEGORIES_URL_PART = 'cma_categories_url_part';
	const OPTION_ANSWERS_AS_HOMEPAGE = 'cma_answers_as_homepage';
    const OPTION_INCLUDE_CATEGORIES_URL_PART = 'cma_include_categories_url_part';
	const OPTION_ADD_ANSWERS_MENU = 'cma_add_to_nav_menu';
	const OPTION_ANSWER_PAGE_DISABLED = 'cma_answer_page_disabled';
	const OPTION_CREATE_AJAX_PAGE = 'cma_create_ajax_page';
	const OPTION_ENABLE_AJAX_ON_FILTERS = 'cma_enable_ajax_on_filters';
	const OPTION_ENABLE_AJAX_ON_QUESTION = 'cma_enable_ajax_on_question';
	const OPTION_ENABLE_CACHE_SYSTEM = 'cma_enable_cache_system';
	const OPTION_LOAD_ASSETS_CONDITIONALLY = 'cma_load_assets_conditionally';
	const OPTION_ADD_WIZARD_SETUP_MENU = 'cma_add_wizard_menu';
	const OPTION_ENABLE_AJAX_SUPPORT_ON_CONTRIBUTOR_PAGE = 'cma_enable_ajax_support_on_contributor_page';
	const OPTION_HAS_BEEN_CREATED_AJAX_PAGE = 'cma_has_been_create_ajax_page';
	const OPTION_LOGS_ENABLED = 'cma_logs_enabled';
	const OPTION_CATEGORY_SYNC_WITH_CM_DIR = 'cma_category_sync_with_cm_dir';
	const OPTION_EXPERT_SYNC_WITH_CM_DIR = 'cma_expert_sync_with_cm_dir';
	const OPTION_GEOLOCIATION_API_KEY = 'cma_geolocation_api_key';
	const OPTION_SEO_META_REWRITE_ENABLED = 'cma_seo_meta_rewrite_enabled';
	const OPTION_INDEX_META_TITLE = 'cma_index_meta_title';
	const OPTION_INDEX_META_DESC = 'cma_index_meta_desc';
	const OPTION_INDEX_META_KEYWORDS = 'cma_index_meta_keywords';
	const OPTION_NOINDEX_NON_CANONICAL = 'cma_noindex_non_canonical';
	const OPTION_NOINDEX_CONTRIBUTOR = 'cma_noindex_contributor';
	const OPTION_QUESTION_FORM_PAGE_TITLE = 'cma_question_form_page_meta_title';
	const OPTION_BACKLINK_PARAM_ENABLED = 'cma_backlink_param_enabled';
	const OPTION_PRIVATE_QUESTIONS_ENABLED = 'cma_private_questions_enabled';
	const OPTION_PRIVATE_QUESTION_EMAIL_SUBJECT = 'cma_private_question_email_subject';
	const OPTION_PRIVATE_QUESTION_EMAIL_TEMPLATE = 'cma_private_question_email_template';
	const OPTION_BAD_WORDS_FILTER_ENABLE = 'cma_bad_words_filter_enable';
	const OPTION_BAD_WORDS_LIST = 'cma_bad_words_list';
	const OPTION_BP_RELATED_CATEGORY = 'cma_bp_related_category';
	const OPTION_DATE_TIME_FORMAT = 'cma_date_time_format';
	const OPTION_DATE_TIME_OFF = 'cma_date_time_off';
    const OPTION_REL_NOFOLLOW = 'cma_rel_nofollow';
	
	// Appearance
	const OPTION_INDEX_HEADER_AFTER_TEXT = 'cma_index_header_after_text';
	const OPTION_INDEX_SORTING_OPTIONS = 'cma_index_sorting_options';
	const OPTION_INDEX_DIFFICULTY_LEVELS = 'cma_index_difficulty_levels';
	const OPTION_INDEX_SORTING_PAGINATION_RESET = 'cma_index_sorting_pagination_reset';
	const OPTION_SHOW_TITLE_FOUND_POSTS = 'cma_show_title_found_posts';
	const OPTION_SHOW_INDEX_TITLE = 'cma_show_index_title';
	const OPTION_DISABLE_TAG_ARCHIVE_TITLE = 'cma_disable_tag_archive_title';
	const OPTION_ITEMS_PER_PAGE = 'cma_items_per_page';
	const OPTION_INDEX_ORDER_BY = 'cma_index_order_by';
	const OPTION_SHOW_INDEX_ORDER = 'cma_show_index_order';
	const OPTION_COLUMN_VOTES_ENABLED = 'cma_column_votes_enabled';
	const OPTION_VIEWS_ALLOWED = 'cma_views_allowed';
	const OPTION_ANSWERS_ALLOWED = 'cma_answers_allowed';
	const OPTION_INDEX_NUMBERS_VERTICALLY = 'cma_index_numbers_vertically';
	const OPTION_INDEX_NUMBERS_RIGHT_SIDE = 'cma_index_numbers_right_side';
	const OPTION_INDEX_SHOW_DIFFICULTY_LEVEL = 'cma_index_show_difficulty_level';
	const OPTION_AUTHOR_ALLOWED = 'cma_author_allowed';
	const OPTION_AUTHOR_LINK_ENABLED = 'cma_author_link_enabled';
	const OPTION_AUTHOR_AVATAR_LINK_ENABLED = 'cma_author_avatar_link_enabled';
	const OPTION_UPDATED_ALLOWED = 'cma_updated_allowed';
	const OPTION_TABLE_QUESTION_ID_SHOW = 'cma_table_question_id_show';
	const OPTION_VOTES_MODE = 'cma_votes_mode';
	const OPTION_VOTES_NO = 'cma_votes_no';
	const OPTION_STICKY_QUESTION_COLOR = 'cma_sticky_color';
	const OPTION_SHOW_USER_STATS = 'cma_show_user_stats';
	const OPTION_SHOW_GRAVATARS = 'cma_show_gravatars';
	const OPTION_INDEX_SHOW_USERBOX = 'cma_index_show_userbox';
	const OPTION_INDEX_SHOW_RIGHT_INFO = 'cma_index_show_right_info';
	const OPTION_INDEX_CONTENT_UNDER_TITLE = 'cma_index_content_under_title';
	const OPTION_INDEX_RECENT_ANSWER_UNDER_TITLE = 'cma_index_recent_answer_under_title';
    const OPTION_INDEX_RECENT_ANSWER_LENGTH = 'cma_index_recent_answer_length';
    const OPTION_INDEX_READ_MORE_LABEL = 'cma_index_recent_answer_read_more_label';
	const OPTION_SHOW_SOCIAL = 'cma_show_social';
	const OPTION_SHOW_QUESTION_TITLE = 'cma_show_question_title';
	const OPTION_SHOW_ANSWERS_TITLE = 'cma_show_answers_title';
	const OPTION_QUESTION_TITLE_TAG = 'cma_question_title_tag';
	const OPTION_SHOW_QUESTION_AUTHOR = 'cma_show_question_author';
	const OPTION_SHOW_ANSWER_AUTHOR = 'cma_show_answer_author';
	const OPTION_SHOW_COMMENT_AUTHOR = 'cma_show_comment_author';
	const OPTION_DEFAULD_AUTHORS_BADGE = 'cma_default_authors_badge';
	const OPTION_DEFAULD_AUTHORS_BADGE_COLOR = 'cma_default_authors_badge_color';
	const OPTION_SHOW_AUTHOR_USERNAME = 'cma_show_author_username';
	const OPTION_SHOW_LABEL_NO_ANSWER = 'cma_show_show_label_no_answer';
	const OPTION_ANSWER_SORTING_BY = 'cma_answer_sorting_by';
	const OPTION_ANSWER_SORTING_DESC = 'cma_answer_sorting_desc';
	const OPTION_ANSWER_PAGINATION = 'cma_answer_pagination';
	const OPTION_ANSWER_PAGINATION_COUNT = 'cma_answer_pagination_count';
	const OPTION_THREAD_PAGE_TEMPLATE = 'cma_thread_page_template';
	const OPTION_THREAD_SHOW_TITLE = 'cma_thread_show_title';
	const OPTION_INDEX_PAGE_TEMPLATE = 'cma_index_page_template';
	const OPTION_SHORTCODES_WHITELIST = 'cma_shortcodes_whitelist';
	const OPTION_INCLUDE_CLASS_WP_EDITOR = 'cma_include_class_wp_editor';
	const OPTION_RICHTEXT_EDITOR = 'cma_richtext_editor';
	const OPTION_EXCLUDE_RICHTEXT_EDITOR_FOR_ROLES = 'cma_exclude_richtext_editor_for_roles';
    const OPTION_TABLE_TOOLBAR = 'cma_table_toolbar';
	const OPTION_TABLE_BUTTON_EDITOR = 'cma_table_button_editor';
	const OPTION_SHOW_TOOLBAR_EDITOR = 'cma_show_toolbar_editor';
	const OPTION_JUSTIFY_TEXT_EDITOR = 'cma_justify_text_editor';
	const OPTION_ALLOW_MEDIA_UPLOAD_FOR_SUBSCRIBERS = 'cma_allow_media_upload_for_subscribers';
	const OPTION_EDITOR_ROWS = 'cma_editor_rows';
	const OPTION_NOTIFY_CHECKBOX_CHECKED = 'cma_notify_checkbox_checked';
	const OPTION_ADMINONLY_CHECKBOX_CHECKED = 'cma_adminonly_checkbox_checked';
	const OPTION_HIDE_REQUIRED_CATEGORY_IF_ONE = 'cma_hide_required_category_if_one';
	const OPTION_MARKUP_BOX_SHOW = 'cma_markup_box_show';
	const OPTION_JS_LIMIT = 'cma_js_limit';
	const OPTION_JS_LIMIT_QUESTION_TITLE = 'cma_js_limit_question_title';
	const OPTION_JS_LIMIT_QUESTION_DESCRIPTION = 'cma_js_limit_question_description';
	const OPTION_JS_LIMIT_QUESTION_COMMENT = 'cma_js_limit_question_comment';
	const OPTION_JS_LIMIT_ANSWER_COMMENT = 'cma_js_limit_answer_comment';
	const OPTION_SHOW_LOGIN_WIDGET = 'cma_show_login_widget';
	const OPTION_SHOW_LOGIN_FORM = 'cma_show_login_form';
	const OPTION_SHOW_REGISTRATION_LINK = 'cma_show_registration_link';
	const OPTION_REGISTRATION_URL = 'cma_registration_url';
	const OPTION_SHOW_LOST_PASSWORD = 'cma_show_lost_password';
	const OPTION_LOST_PASSWORD_URL = 'cma_lost_password_url';
    const OPTION_REDIRECT_GUEST_WITH_QUESTION_FORM_SEPARATE_PAGE = 'cma_redirect_guest_with_question_form_separate_page';
    const OPTION_REDIRECT_URL_AFTER_LOGIN = 'cma_redirect_url_after_login';
	const OPTION_LOGIN_PAGE_LINK_TITLE = 'cma_login_page_link_title';
	const OPTION_LOGIN_PAGE_LINK_URL = 'cma_login_page_link_url';
	const OPTION_REPLACE_POST_COMMENTS_SHORTCODE_ATTR = 'cma_replace_post_comments_shortcode_attr';
	const OPTION_BP_GROUP_SHORTCODE_ATTR = 'cma_bp_group_shortcode_attr';
	const OPTION_BP_GROUP_RESTRICT_QUESTIONS = 'cma_bp_group_restrict_questions';
	const OPTION_BP_GROUP_RESTRICT_CATEGORY_TEXT = 'cma_bp_group_restrict_category_text';
	const OPTION_CONTRIBUTOR_CUSTOM_URL = 'cma_contributor_custom_url';
	const OPTION_DISABLE_AUTHOR_PAGE = 'cma_disable_author_page';
	const OPTION_BREADCRUMBS_ENABLED = 'cma_breadcrumbs_enabled';
    const OPTION_SHOW_INDEX_PAGE_NAV_BAR = 'cma_index_show_navbar';
	const OPTION_SHOW_QUESTION_PAGE_NAV_BAR = 'cma_show_question_page_nav_bar';
	const OPTION_CATEGORY_FILTER_MODE = 'cma_category_filter_mode';
	const OPTION_ALLOW_POST_ONLY_SUBCATEGORIES = 'cma_allow_post_only_subcategories';
	const OPTION_SUBMIT_BUTTON_CSS_BACKGROUND = 'cma_submit_button_css_background';
	const OPTION_ESCAPE_PRE_CONTENT = 'cma_escape_pre_content';
	const OPTION_CONTENT_ALLOWED_TAGS = 'cma_content_allowed_tags';
	const OPTION_QUESTION_FORM_ON_TOP = 'cma_question_form_on_top';
	const OPTION_QUESTION_FORM_BUTTON = 'cma_question_form_button';
	const OPTION_SUPPORT_THEME_DIR = 'cma_support_theme_dir';
	const OPTION_DISABLE_CSS = 'cma_disable_css';
	const OPTION_HIDE_CATEGORIES = 'cma_hide_categories';
	const OPTION_RELATED_QUESTIONS_POST_TYPES = 'cma_related_questions_post_types';
	const OPTION_RELATED_QUESTIONS_SHORTCODE_PARAMS = 'cma_related_questions_shortcode_params';
	const OPTION_NAVBAR_AUTO_SUBMIT = 'cma_navbar_auto_submit';
	const OPTION_SEARCH_FOR_USERS = 'cma_search_for_users';
	const OPTION_SEARCH_INCLUDE_TAGS = 'cma_search_include_tags';
	const OPTION_EMBED_ATTACHED_IMAGES = 'cma_embed_attachmed_images';
	const OPTION_EMBED_ATTACHED_IMAGES_SIZE = 'cma_embed_attachmed_images_size';
	const OPTION_INDEX_SHOW_CONTENT = 'cma_index_show_content';
	const OPTION_QUESTION_FRAGMENT_LENGTH = 'cma_question_fragment_length';
	const OPTION_QUESTION_AJAX_MIN_WIDTH = 'cma_question_ajax_min_width';
	const OPTION_LOOK_AND_FEEL_STYLE = 'cma_look_and_feel_style';
	const OPTION_QUESTION_STAGES_ENABLE = 'cma_question_stages_enable';
	const OPTION_QUESTION_STAGES_LIST = 'cma_question_stages_list';
	const OPTION_QUESTION_TITLE_STAGE_PREFIX = 'cma_question_title_stage_prefix';
	const OPTION_QUESTION_LAST_STAGE_DISABLE_ANSWERS = 'cma_question_last_stage_disable_answers';
	const OPTION_QUESTION_LAST_STAGE_DISABLE_COMMENTS = 'cma_question_last_stage_disable_comments';

	// Questions
	const OPTION_ADD_RESOLVED_QUESTION_TITLE_PREFIX = 'cma_add_resolved_question_title_prefix';
	const OPTION_QUESTION_DESCRIPTION_OPTIONAL = 'cma_question_description_optional';
	const OPTION_CATEGORY_SWITCH = 'cma_category_switch';
	const OPTION_QUESTION_REQUIRE_CATEGORY = 'cma_question_require_category';
	const OPTION_TAGS_SWITCH = 'cma_tags_switch';
	const OPTION_TAGS_SWITCH_REQUIRED = 'cma_tags_switch_required';
	const OPTION_TAGS_SWITCH_LIMIT = 'cma_tags_switch_limit';
	const OPTION_CAN_EDIT_TAGS = 'cma_can_edit_tags';
	const OPTION_ENABLE_MARK_FAVORITE_QUESTIONS = 'cma_enable_mark_favorite_questions';
	const OPTION_ENABLE_QUESTION_RATING = 'cma_enable_question_rating';
	const OPTION_ENABLE_DIFFICULTY_LEVEL = 'cma_enable_difficulty_level';
	const OPTION_ENABLE_DIFFICULTY_LEVEL_NUMBER = 'cma_enable_difficulty_level_number';

	// Spam
	const OPTION_SPAM_REPORTING_ENABLED = 'CMA_spam_reporting_enabled';
	const OPTION_SPAM_REPORTING_GUESTS = 'CMA_spam_reporting_guests';
	const OPTION_SPAM_REPORTING_EMAIL_ADDR = 'CMA_spam_reporting_email_addr';
	const OPTION_SPAM_REPORTING_EMAIL_SUBJECT = 'CMA_spam_reporting_email_subject';
	const OPTION_SPAM_REPORTING_EMAIL_TEMPLATE = 'CMA_spam_reporting_email_template';
	
	// Thread Answers
	const OPTION_ANSWER_AFTER_RESOLVED = 'cma_answer_after_resolved';
	const OPTION_ALLOW_COMMENTS_IN_RESOLVED_THREAD = 'cma_allow_comments_in_resolved_thread';
	const OPTION_ANSWERS_RATING_ALLOWED = 'cma_rating_allowed';
	const OPTION_ENABLED_MARK_BEST_ANSWER = 'cma_enabled_mark_best_answer';
	const OPTION_ALLOW_OWN_BEST_ANSWER = 'cma_allow_own_best_answer';
	const OPTION_ENABLED_UNMARK_BEST_ANSWER = 'cma_enabled_unmark_best_answer';
	const OPTION_BEST_ANSWER_REMOVE_OTHER = 'cma_best_answer_remove_other';
	const OPTION_PRIVATE_ANSWERS_ENABLED = 'cma_private_answers_enabled';
	const OPTION_PRIVATE_ANSWER_BGCOLOR = 'cma_private_answer_bgcolor';
	const OPTION_ANSWER_MIN_WORDS = 'cma_option_answer_min_words';
	const OPTION_ANSWER_MAX_HYPERLINKS = 'cma_option_answer_max_hyperlinks';

	
	// Thread comments
	const OPTION_COMMENTS_QUESTION_ENABLE = 'CMA_comments_question_enable';
    const OPTION_COMMENTS_RATING_ALLOWED = 'CMA_comments_rating_allowed';
	const OPTION_COMMENTS_QUESTION_ATTACHMENT_ENABLE = 'CMA_comments_question_attachment_enable';
	const OPTION_COMMENTS_ANSWER_ENABLE = 'CMA_comments_answer_enable';
	const OPTION_COMMENTS_ANSWER_ATTACHMENT_ENABLE = 'CMA_comments_answer_attachment_enable';
	
	// Thread Common
	const OPTION_INCREMENT_VIEWS = 'cma_increment_views';
	const OPTION_NEGATIVE_RATING_ALLOWED = 'cma_negative_rating_allowed';
	const OPTION_EDIT_MODE = 'cma_edit_mode';
	const OPTION_CAN_EDIT_RESOLVED = 'cma_allow_edit_resolved';
	const OPTION_CAN_EDIT_CATEGORY = 'cma_allow_edit_category';
	const OPTION_CAN_EDIT_DIFFICULTY = 'cma_allow_edit_difficulty';
	const OPTION_RESOLVE_THREAD_ENABLED = 'cma_resolve_thread_enabled';
	const OPTION_SHOW_ONLY_OWN_QUESTIONS = 'cma_show_only_own_questions';
	const OPTION_DUPLICATED_QUESTIONS_MODE = 'cma_duplicated_questions_mode';
	const OPTION_ALLOW_QUESTION_DELETE = 'cma_allow_question_delete';
	const OPTION_ALLOW_QUESTION_DELETE_NOANSWERS = 'cma_allow_question_delete_noanswers';
	const OPTION_QUESTION_DELETE_TRASH = 'cma_question_delete_trash';
	const OPTION_USER_RELATED_QUESTIONS_ENABLE = 'cma_user_related_questions_enable';
	const OPTION_ANONYMOUS_USER_CHECKBOX_ENABLE = 'cma_anonymous_question_checkbox_enable';
	const OPTION_ANONYMOUS_USER_ENABLE = 'cma_anonymous_question_enable';
	const OPTION_THREAD_DISPLAY_ID = 'cma_thread_display_id';
	//const OPTION_ALLOW_UNVOTE = 'cma_allow_unvote';
	const OPTION_CAN_VOTE_MYSELF = 'cma_can_vote_myself';
	const OPTION_ALLOW_GUESTS_VOTING = 'cma_allow_guests_voting';
    const OPTION_VOTING_ON_LIST = 'cma_votes_on_list';
	
	// Attachments
	const OPTION_ATTACHMENTS_QUESTIONS_ALLOW = 'CMA_attachments_questions_allow';
	const OPTION_ATTACHMENTS_ANSWERS_ALLOW = 'CMA_attachments_answers_allow';
	const OPTION_ATTACHMENTS_FILE_EXTENSIONS = 'cma_attachment_allowed';
	const OPTION_ATTACHMENTS_MAX_SIZE = 'cma_attachment_max_size';
	
	// Moderation
	const OPTION_QUESTION_AUTO_APPROVE = 'cma_question_auto_approve';
	const OPTION_SIMULATE_COMMENT = 'cma_simulate_comment';
	const OPTION_ANSWER_AUTO_APPROVE = 'cma_answer_auto_approve';
	const OPTION_COMMENTS_AUTO_APPROVE = 'CMA_comments_auto_approve';
	const OPTION_AUTO_APPROVE_AUTHORS = 'cma_answer_authors_auto_approved';
	const OPTION_LIMIT_QUESTIONS_PER_DAY = 'cma_limit_questions_per_day';
	const OPTION_LIMIT_QUESTIONS_PER_WEEK = 'cma_limit_questions_per_week';
	const OPTION_LIMIT_QUESTIONS_PER_MONTH = 'cma_limit_questions_per_month';
	const OPTION_LIMIT_ANSWERS_PER_DAY = 'cma_limit_answers_per_day';
	const OPTION_LIMIT_ANSWERS_PER_WEEK = 'cma_limit_answers_per_week';
	const OPTION_LIMIT_ANSWERS_PER_MONTH = 'cma_limit_answers_per_month';
	
	// Access
	const OPTION_VIEW_ACCESS = 'cma_access_view';
	const OPTION_VIEW_ACCESS_ROLES = 'cma_access_view_roles';

	const OPTION_ACCESS_VIEW_ANSWERS = 'cma_access_answers_view';
	const OPTION_ACCESS_VIEW_ANSWERS_ROLES = 'cma_access_answers_view_roles';
	const OPTION_POST_QUESTIONS_ACCESS = 'cma_access_post_questions';
	const OPTION_POST_QUESTIONS_ACCESS_ROLES = 'cma_access_post_questions_roles';
	const OPTION_POST_ANSWERS_ACCESS = 'cma_access_post_answers';
	const OPTION_POST_ANSWERS_ACCESS_ROLES = 'cma_access_post_answers_roles';
	const OPTION_POST_COMMENTS_ACCESS = 'cma_access_post_comments';
	const OPTION_POST_COMMENTS_ACCESS_ROLES = 'cma_access_post_comments_roles';
	const OPTION_POST_ALL_ACCESS = 'cma_access_post_all';
	const OPTION_ALLOW_FULL_HTML_ROLES = 'cma_allow_full_html_roles';
	
	// Notifications
	const OPTION_EMAIL_USE_HTML = 'cma_email_use_html';
	const OPTION_EMAIL_HTML_NL2BR = 'cma_email_html_nl2br';
	const OPTION_POST_ADMIN_NOTIFICATION_EMAIL = 'cma_new_question_notification_admin_email';
    const OPTION_NEW_QUESTION_ADMIN_NOTIFICATION_CONTENT = 'cma_new_question_admin_notification_content';
    const OPTION_NEW_ANSWER_ADMIN_NOTIFICATION_CONTENT = 'cma_new_answer_admin_notification_content';
    const OPTION_EMAIL_TO_HEADER_WHEN_BCC = 'cma_email_to_header_when_bcc';
    const OPTION_ENABLE_SENDING_NOTIFICATIONS_USING_CRON = 'cma_enable_sending_notifications_using_cron';
	const OPTION_NEW_QUESTION_EVERYBODY_FOLLOW_ENABLED = 'cma_new_question_all_users_follow_enabled';
	const OPTION_NEW_QUESTION_ADMIN_NOTIFICATION_ENABLED = 'cma_new_question_admin_notification_enabled';
	const OPTION_NEW_QUESTION_EXPERT_NOTIFICATION_ENABLED = 'cma_new_question_expert_notification_enabled';
	const OPTION_NEW_QUESTION_WHICH_EXPERTS_NOTIFIED = 'cma_new_question_which_experts_notified';
	const OPTION_NEW_QUESTION_NOTIFY_EVERYBODY_ENABLED = 'cma_new_question_all_users_notification_enabled';
	const OPTION_NEW_QUESTION_NOTIFY_AUTHOR_ENABLED = 'cma_new_question_author_notification_enabled';
	const OPTION_NEW_QUESTION_NOTIFY_AUTHOR_TITLE = 'cma_new_question_author_notification_title';
	const OPTION_NEW_QUESTION_NOTIFY_AUTHOR_CONTENT = 'cma_new_question_author_notification_content';
	const OPTION_REMINDER_NOTIFY_AUTHOR_ENABLED = 'cma_question_author_reminder_notification_enabled';
	const OPTION_REMINDER_NOTIFY_AUTHOR_TIME = 'cma_question_author_reminder_notification_time';
	const OPTION_REMINDER_NOTIFY_AUTHOR_TITLE = 'cma_question_author_reminder_notification_title';
	const OPTION_REMINDER_NOTIFY_AUTHOR_CONTENT = 'cma_question_author_reminder_notification_content';
	const OPTION_NEW_QUESTION_NOTIFY_EVERYBODY_OPTINOUT = 'cma_new_question_all_users_notification_optinout';
	const OPTION_NEW_QUESTION_NOTIFICATION = 'cma_new_question_notification';
	const OPTION_NEW_QUESTION_NOTIFICATION_TITLE = 'cma_new_question_notification_title';
	const OPTION_NEW_QUESTION_NOTIFICATION_CONTENT = 'cma_new_question_notification_content';
	const OPTION_THREAD_NOTIFICATION = 'cma_thread_notification';
	const OPTION_THREAD_NOTIFICATION_EXPERT = 'cma_thread_notification_expert';
	const OPTION_THREAD_NOTIFICATION_AUTHOR = 'cma_thread_notification_author';
	const OPTION_NEW_ANSWER_ADMIN_NOTIFICATION_ENABLED = 'cma_new_answer_admin_notification_enabled';
	const OPTION_NEW_ANSWER_NOTIFY_EVERYBODY_ENABLED = 'cma_new_answer_all_users_notification_enabled';
	const OPTION_NEW_ANSWER_EXPERT_NOTIFICATION_ENABLED = 'cma_new_answer_experts_notification_enabled';
	const OPTION_NEW_ANSWER_NOTIFY_AUTHOR_ENABLED = 'cma_new_answer_question_author_notification_enabled';
	const OPTION_THREAD_NOTIFICATION_TITLE = 'cma_thread_notification_title';
    const OPTION_THREAD_NOTIFICATION_EXPERT_TITLE = 'cma_thread_notification_expert_title';
    const OPTION_THREAD_NOTIFICATION_AUTHOR_TITLE = 'cma_thread_notification_author_title';
	const OPTION_DEBUG_EMAIL = 'cma_debug_email';
	const OPTION_ENABLE_THREAD_FOLLOWING = 'cma_enable_thread_following';
	const OPTION_ENABLE_THREAD_FOLLOWING_PERIOD = 'cma_enable_thread_following_period';
	const OPTION_ENABLE_THREAD_FOR_ADMIN_ONLY = 'cma_enable_thread_for_admin_only';
    const OPTION_ADD_ALL_WPML_LANGUAGES_CATEGORIES_TO_QUESTION = 'cma_add_all_languages_categories_to_question';
	const OPTION_REDIRECT_AFTER_POST_QUESTION = 'cma_redirect_after_post_question';
	const OPTION_ENABLE_CATEGORY_FOLLOWING = 'cma_enable_category_following';
	const OPTION_NEW_COMMENT_NOTIFICATION_ENABLED = 'cma_new_comment_nofication_enabled';
	const OPTION_NEW_COMMENT_ADMIN_NOTIFICATION_ENABLED = 'cma_new_comment_admin_nofication_enabled';
	const OPTION_NEW_COMMENT_NOTIFICATION_TITLE = 'cma_new_comment_notification_title';
	const OPTION_NEW_COMMENT_NOTIFICATION_CONTENT = 'cma_new_comment_notification_content';
	const OPTION_NOTIF_BEST_ANSWER_RECEIVERS = 'cma_notif_best_answer_receivers';
	const OPTION_NOTIF_BEST_ANSWER_TITLE = 'cma_notif_best_answer_title';
	const OPTION_NOTIF_BEST_ANSWER_CONTENT = 'cma_notif_best_answer_content';
	const OPTION_NOTIF_CONTENT_REJECTED_ENABLE = 'cma_notif_content_rejected_enable';
	const OPTION_NOTIF_CONTENT_REJECTED_SUBJECT = 'cma_notif_content_rejected_subject';
	const OPTION_NOTIF_CONTENT_REJECTED_TEMPLATE = 'cma_notif_content_rejected_template';
	
	// Ads
	const OPTION_ADV_QUESTIONS_TABLE_BEFORE = 'cma_adv_questions_table_before';
	const OPTION_ADV_QUESTIONS_TABLE_AFTER = 'cma_adv_questions_table_after';
	const OPTION_ADV_THREAD_BEFORE = 'cma_adv_thread_before';
	const OPTION_ADV_THREAD_ANSWERS_BEFORE = 'cma_adv_thread_answers_before';
	const OPTION_ADV_THREAD_ANSWERS_AFTER = 'cma_adv_thread_answers_after';
	const OPTION_ADV_THREAD_ANSWERS_FORM_AFTER = 'cma_adv_thread_answers_form_after';
	const OPTION_ADV_CSS_PREFIX = 'cma_adv_css_prefix';

	// MicroPayments
	const OPTION_MP_POST_QUESTION_ACTION = 'CMA_MP_post_question_action';
	const OPTION_MP_POST_QUESTION_POINTS = 'CMA_MP_post_question_points';
	const OPTION_MP_POST_ANSWER_ACTION = 'CMA_MP_post_answer_action';
	const OPTION_MP_POST_ANSWER_POINTS = 'CMA_MP_post_answer_points';
	const OPTION_MP_POST_VIEW_ANSWER_ACTION = 'CMA_MP_post_view_answer_action';
	const OPTION_MP_POST_VIEW_ANSWER_POINTS = 'CMA_MP_post_view_answer_points';
	const OPTION_MP_REWARD_BEST_ANSWER_ENABLE = 'CMA_MP_reward_best_answer_enable';
	const OPTION_MP_REWARD_BEST_ANSWER_BY_USER_ENABLE = 'CMA_MP_reward_best_answer_by_user_enable';
	const OPTION_MP_REWARD_BEST_ANSWER_POINTS = 'CMA_MP_reward_best_answer_points';
	const OPTION_MP_REWARD_BEST_ANSWER_MINIMUM = 'CMA_MP_reward_best_answer_minimum';
	const OPTION_MP_WHEN_CHARGE_REWARD_FROM_AUTHOR = 'CMA_MP_when_charge_reward_from_author';

	const MP_BADGES_QUESTION_POST = 'CMA_on_post';
	const MP_BADGES_QUESTION_RESOLVED = 'CMA_on_resolve';

	const MP_BADGES_MODE_DISABLED = 'disabled';
	const MP_BADGES_MODE_DEFINITIVE = 'definitive';
	const MP_BADGES_MODE_ACCUMULATIVE = 'accumulative';

	// MicroPayments Badges
	const OPTION_MP_BADGES_MODE = 'CMA_mp_badges_mode';
	const OPTION_MP_BADGES_LIST = 'CMA_mp_badges_list';

	// Disclaimer
	const OPTION_DISCLAIMER_ENABLED = 'cma_disclaimer_approve';
	const OPTION_DISCLAIMER_AFTER_SUBMIT = 'cma_disclaimer_after_submit';
	const OPTION_DISCLAIMER_CONTENT = 'cma_disclaimer_content';
	const OPTION_DISCLAIMER_CONTENT_ACCEPT = 'cma_disclaimer_content_accept';
	const OPTION_DISCLAIMER_CONTENT_REJECT = 'cma_disclaimer_content_reject';

    // Chat GPT
    const OPTION_GPT_ENABLED = 'cma_gpt_enabled';
    const OPTION_GPT_API_KEY = 'cma_gpt_api_key';
    const OPTION_GPT_FILTER_LINK = 'cma_gpt_filter_link';
    const OPTION_GPT_CATEGORY = 'cma_gpt_category';
    const OPTION_GPT_USER_DISPLAY_NAME = 'cma_gpt_display_name';
    const OPTION_GPT_PROMPT_TEMPLATE = 'cma_gpt_prompt_template';
    const OPTION_GPT_SYSTEM_ROLE = 'cma_gpt_system_role';
    const OPTION_GPT_MODEL = 'cma_gpt_model';
    const OPTION_GPT_REPLY_LENGTH = 'cma_gpt_reply_length';
    const OPTION_GPT_TEMPERATURE = 'cma_gpt_temperature';
    const OPTION_GPT_ANSWER_VIA_CRON = 'cma_gpt_answer_via_cron';

    // Gemini
    const OPTION_GEMINI_ENABLED = 'cma_gemini_enabled';
    const OPTION_GEMINI_API_KEY = 'cma_gemini_api_key';
    const OPTION_GEMINI_MODEL = 'cma_gemini_model';
    const OPTION_GEMINI_CATEGORY = 'cma_gemini_category';
    const OPTION_GEMINI_USER_DISPLAY_NAME = 'cma_gemini_display_name';
    const OPTION_GEMINI_PROMPT_TEMPLATE = 'cma_gemini_prompt_template';
    const OPTION_GEMINI_REPLY_LENGTH = 'cma_gemini_reply_length';
    const OPTION_GEMINI_TEMPERATURE = 'cma_gemini_temperature';
    const OPTION_GEMINI_SAFETY_LEVEL = 'cma_gemini_safety_level';

	// Referrals
	const OPTION_AFFILIATE_CODE = 'cma_affiliate_code';
	const OPTION_REFERRAL_ENABLED = 'cma_referral_enabled';

	// Sidebar
	const OPTION_SIDEBAR_ENABLED = 'cma_sidebar_enabled';
	const OPTION_SIDEBAR_MAX_WIDTH = 'cma_sidebar_max_width';
	const OPTION_SIDEBAR_CONTRIBUTOR_ENABLED = 'cma_sidebar_contributor_enabled';
	const OPTION_SIDEBAR_WIDGET_BEFORE = 'cma_sidebar_widget_before';
	const OPTION_SIDEBAR_WIDGET_AFTER = 'cma_sidebar_widget_after';
	const OPTION_SIDEBAR_TITLE_BEFORE = 'cma_sidebar_title_before';
	const OPTION_SIDEBAR_TITLE_AFTER = 'cma_sidebar_title_after';

	const ACCESS_EVERYONE = 0;
	const ACCESS_USERS = 1;
	const ACCESS_ROLE = 2;
	const ACCESS_AUTHOR = 3;
	const ACCESS_EXPERT = 4;
	const ACCESS_EXPERT_AUTHOR = 5;

	const EDIT_MODE_DISALLOWED = 0;
	const EDIT_MODE_WITHIN_HOUR = 1;
	const EDIT_MODE_WITHIN_DAY = 2;
	const EDIT_MODE_ANYTIME = 3;

	const VOTES_MODE_ANSWERS_COUNT = 1;
	const VOTES_MODE_HIGHEST = 2;
	const VOTES_MODE_QUESTION_COUNT = 3;
	const VOTES_MODE_QUESTION_ANSWERS_COUNT = 4;
	const VOTES_MODE_QUESTION_RATING = 5;

	const NOTIF_ANSWER_AUTHOR = 'answer_author';
	const NOTIF_QUESTION_AUTHOR = 'question_author';
	const NOTIF_FOLLOWERS = 'followers';
	const NOTIF_CONTRIBUTORS = 'contributors';

	const CATEGORY_FILTER_MODE_TREE = 1;
	const CATEGORY_FILTER_MODE_TWO_LEVEL = 2;
	const CATEGORY_FILTER_MODE_DISABLED = 0;

	const DUPLICATED_QUESTIONS_ALLOW = 0;
	const DUPLICATED_QUESTIONS_SAME_AUTHOR = 1;

	const DUPLICATED_QUESTIONS_ANY_AUTHOR = 2;

	const DELETE_MODE_DISALLOWED = 0;
	const DELETE_MODE_WITHIN_HOUR = 1;
	const DELETE_MODE_WITHIN_DAY = 2;
	const DELETE_MODE_ANYTIME = 3;

	const SHOW_CONTENT_NONE = 0;
	const SHOW_CONTENT_ENTIRE = 1;
	const SHOW_CONTENT_FRAGMENT = 'fragment';

    const SEARCH_INCLUDE_TAGS_DISABLE = 0;
    const SEARCH_INCLUDE_TAGS_SINGLE = 1;
    const SEARCH_INCLUDE_TAGS_MULTIPLE_ONE = 2;
    const SEARCH_INCLUDE_TAGS_MULTIPLE_ALL = 3;

    const OPTION_ENABLE_INTEGRATION_WITH_UM_FOLLOW = 'cma_enable_integration_with_um_follow';

    const OPTION_HIDE_LOGIN_FORM = 'cma_hide_login_form';

	public static function getOptionsConfig() {
		
		return apply_filters('cma_options_config', array(
			
			// General
			self::OPTION_ANSWERS_PERMALINK => array(
				'type' => self::TYPE_STRING,
				'default' => 'answers',
				'category' => 'general',
				'subcategory' => 'general',
				'title' => 'Answers permalink',
				'desc' => 'You can replace default "answers" slug to whatever you want.',
                'onlyin' => 'Pro'
			),
			self::OPTION_CATEGORIES_URL_PART => array(
				'type' => self::TYPE_STRING,
				'default' => 'categories',
				'category' => 'general',
				'subcategory' => 'general',
				'title' => 'Categories URL part',
				'desc' => 'Replace the "categories" URL part in the category URL: /answers/<strong>categories</strong>/some-category',
                'onlyin' => 'Pro'
			),
			self::OPTION_ANSWERS_AS_HOMEPAGE => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'general',
				'subcategory' => 'general',
				'title' => 'Set as homepage',
				'desc' => 'If enabled, questions listing will be displayed as your site\'s homepage.',
                'onlyin' => 'Pro'
			),
            self::OPTION_INCLUDE_CATEGORIES_URL_PART => array(
                'type' => self::TYPE_BOOL,
                'default' => 0,
                'category' => 'general',
                'subcategory' => 'general',
                'title' => 'Include the category to the question URL',
                'desc' => 'If enabled, the category will be added to the question URL',
                'onlyin' => 'Pro'
            ),
            self::OPTION_REL_NOFOLLOW => array(
                'type' => self::TYPE_BOOL,
                'default' => 0,
                'category' => 'general',
                'subcategory' => 'general',
                'title' => 'Add a rel="nofollow" attribute to links',
                'desc' => 'If enabled, rel="nofollow" will be added to links',
                'onlyin' => 'Pro'
            ),
			self::OPTION_ADD_ANSWERS_MENU => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'general',
				'subcategory' => 'general',
				'title' => 'Add "Answers" to WP Nav Menu',
				'desc' => 'You need to have "wp_nav_menu" trigger in your template.',
			),
			self::OPTION_ANSWER_PAGE_DISABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'general',
				'subcategory' => 'general',
				'title' => 'Disable "Answers" page',
				'desc' => 'Disable the "Answers" page completely (it will show 404 instead).',
			),
			self::OPTION_CREATE_AJAX_PAGE => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'general',
				'subcategory' => 'general',
				'title' => 'Auto-create the AJAX page',
				'desc' => 'If enabled, the CMA AJAX page with the cma-index shortcode will be created automatically if not found. '
							. 'Disable this option to avoid creating this page.',
			),
			self::OPTION_ENABLE_AJAX_ON_FILTERS => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'general',
				'subcategory' => 'general',
				'title' => 'Enable AJAX call on filters',
				'desc' => 'If enabled, then filters will work with AJAX call',
			),
			self::OPTION_ENABLE_AJAX_ON_QUESTION => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'general',
				'subcategory' => 'general',
				'title' => 'Enable AJAX call on question',
				'desc' => 'If enabled, then question will open with AJAX call',
			),
            self::OPTION_ENABLE_AJAX_SUPPORT_ON_CONTRIBUTOR_PAGE => array(
                'type' => self::TYPE_BOOL,
                'default' => 1,
                'category' => 'general',
                'subcategory' => 'general',
                'title' => 'Enable AJAX support on contributor page',
                'desc' => 'If enabled, AJAX support will be enabled on the contributor page',
                'onlyin' => 'Pro'
            ),
			self::OPTION_ENABLE_CACHE_SYSTEM => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'general',
				'subcategory' => 'general',
				'title' => 'Enable cache system',
				'desc' => 'If enabled, then plugin will use a cache system',
                'onlyin' => 'Pro'
			),
			self::OPTION_LOAD_ASSETS_CONDITIONALLY => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'general',
				'subcategory' => 'general',
				'title' => 'Load assets conditionally',
				'desc' => 'If this option is enabled, the plugins assets (CSS/JS) will only be loaded on pages with at least one shortcode or on plugin generated pages. Disable if you\'re facing problems.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ADD_WIZARD_SETUP_MENU => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'general',
				'subcategory' => 'general',
				'title' => 'Display "Setup Wizard" in plugin menu',
				'desc' => 'Uncheck this to remove Setup Wizard from plugin menu.',
			),
			
			// SEO
			self::OPTION_SEO_META_REWRITE_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'general',
				'subcategory' => 'seo',
				'title' => 'Enable the meta tags rewrite',
				'desc' => 'If enabled, CMA will add an extra meta-tags for the SEO purpose.<br>'
						. 'If disabled, then the following SEO features will be disabled also.<br>'
						. '<strong>Note:</strong> meta rewrite uses the output buffering and may cause conflicts with some themes or plugins. '
						. 'If you noticed any issues with the CMA pages displaying, try to turn this option off.',
                'onlyin' => 'Pro'
			),
			self::OPTION_INDEX_META_TITLE => array(
				'type' => self::TYPE_STRING,
				'category' => 'general',
				'subcategory' => 'seo',
				'title' => 'Title bar for index page',
				'desc' => 'Enter text which appears on the browser\'s title bar on the Answers index page for better search engines positioning. '
							. 'If blank then default title will be used.<br><strong>Notice:</strong> SEO fetaures work only with the CMA default page template.',
                'onlyin' => 'Pro'
			),
			self::OPTION_INDEX_META_DESC => array(
				'type' => self::TYPE_STRING,
				'category' => 'general',
				'subcategory' => 'seo',
				'title' => 'Meta description for index page',
				'desc' => 'Enter the meta description for the index page for better search engines positioning.',
                'onlyin' => 'Pro'
			),
			self::OPTION_INDEX_META_KEYWORDS => array(
				'type' => self::TYPE_STRING,
				'category' => 'general',
				'subcategory' => 'seo',
				'title' => 'Meta keywords',
				'desc' => 'Enter the meta keywords for better search engines positioning.',
                'onlyin' => 'Pro'
			),
			self::OPTION_NOINDEX_NON_CANONICAL => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'general',
				'subcategory' => 'seo',
				'title' => 'Add noindex meta to the non-canonical pages',
				'desc' => 'If enabled, the &lt;meta name="robots" content="noindex"&gt; tag will be added to the non-canonical page, '
							. 'for example the question list sorted by non-default parameter.',
                'onlyin' => 'Pro'
			),
			self::OPTION_NOINDEX_CONTRIBUTOR => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'general',
				'subcategory' => 'seo',
				'title' => 'Add noindex meta to the contributor page',
				'desc' => 'If enabled, the &lt;meta name="robots" content="noindex"&gt; tag will be added to the contributor page.',
                'onlyin' => 'Pro'
			),
			self::OPTION_QUESTION_FORM_PAGE_TITLE => array(
                'type' => self::TYPE_STRING,
                'default' => '',
                'category' => 'general',
                'subcategory' => 'seo',
                'title' => 'Title bar for "Ask a Question" page',
                'desc' => 'Enter text which appears on the browser\'s title bar on the page with question form. '
                    . 'If blank then default title will be used.<br><strong>Notice:</strong> The fetaure work only if the "Question form on a separate page" option is enabled.',
                'onlyin' => 'Pro'
            ),
			
			// Other
			self::OPTION_LOGS_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'general',
				'subcategory' => 'other',
				'title' => 'Enable logs',
				'desc' => 'If enabled, the information about posting and voting will be additionaly logged to database.',
                'onlyin' => 'Pro'
			),
			self::OPTION_GEOLOCIATION_API_KEY => array(
				'type' => self::TYPE_STRING,
				'default' => '',
				'category' => 'general',
				'subcategory' => 'other',
				'title' => 'Geolocation API key',
				'desc' => 'Enter an ipinfodb.com IP Location API key to track the downloads locations in logs. '
							. 'If you don\'t have an API key, <a href="http://ipinfodb.com/register.php" target="_blank">register new account</a>.',
                'onlyin' => 'Pro'
			),
			self::OPTION_CATEGORY_SYNC_WITH_CM_DIR => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'general',
				'subcategory' => 'other',
				'title' => 'Category sync with CM Expert Directory plugin',
				'desc' => 'If enabled, then admin will create category under CM Answers same category automatic created in CM Expert Directory plugin.',
                'onlyin' => 'Pro'
			),
            self::OPTION_EXPERT_SYNC_WITH_CM_DIR => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'general',
				'subcategory' => 'other',
				'title' => 'Experts sync with CM Expert Directory plugin',
				'desc' => 'If enabled, then experts in CM Answers will be replace by experts from CM Expert Directory plugin.',
                'onlyin' => 'Pro'
			),
			
			// Appearance Index
			self::OPTION_SHOW_TITLE_FOUND_POSTS => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'index',
				'title' => 'Show number of questions next to category header\'s title',
				'desc' => 'If enabled, number of questions will be added to the category title in the header, for example: Answers (19).',
                'onlyin' => 'Pro'
			),
			self::OPTION_INDEX_PAGE_TEMPLATE => array(
				'type' => self::TYPE_SELECT,
				'options' => [0 => 'CMA default'],
				'default' => 'page.php',
				'category' => 'appearance',
				'subcategory' => 'index',
				'title' => 'Page template for index',
				'desc' => 'Choose the page template of the current theme or set default.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SHOW_INDEX_TITLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'index',
				'title' => 'Show index page title',
				'desc' => 'This option works only if you are using default CMA page template for the index page.',
                'onlyin' => 'Pro'
			),
			self::OPTION_DISABLE_TAG_ARCHIVE_TITLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'index',
				'title' => 'Disable tag archive title',
				'desc' => 'Use this option to disable page title on tag archive and question edit page',
                'onlyin' => 'Pro'
			),
			self::OPTION_ITEMS_PER_PAGE => array(
				'type' => self::TYPE_INT,
				'default' => 10,
				'category' => 'appearance',
				'subcategory' => 'index',
				'title' => 'Amount of Questions per page',
				'desc' => 'Limit of the questions per page.',
			),
			self::OPTION_INDEX_ORDER_BY => array(
				'type' => self::TYPE_RADIO,
				'options' => static::getIndexSortingOptions(),
				'default' => 'newest',
				'category' => 'appearance',
				'subcategory' => 'index',
				'title' => 'Questions sorting',
				'desc' => 'Choose the default option how to sort the questions.',
			),
			/* ML */
			self::OPTION_SHOW_INDEX_ORDER => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'index',
				'title' => 'Show questions sorting',
				'desc' => 'If enabled, the question sorting of Newest/Hottest/Most won\'t be displayed on the index page.',
			),
			self::OPTION_INDEX_SORTING_OPTIONS => array(
				'type' => self::TYPE_MULTICHECKBOX,
				'options' => static::getIndexSortingOptions(),
				'default' => array_keys(static::getIndexSortingOptions()),
				'category' => 'appearance',
				'subcategory' => 'index',
				'title' => 'Show sorting options',
				'desc' => 'Choose which sorting options will be available on the questions index page.',
                'onlyin' => 'Pro'
			),
            self::OPTION_INDEX_DIFFICULTY_LEVELS => array(
                'type' => self::TYPE_BOOL,
                'default' => 0,
                'category' => 'appearance',
                'subcategory' => 'index',
                'title' => 'Show difficulty levels',
                'desc' => 'Show or hide difficulty levels dropdown',
                'onlyin' => 'Pro'
            ),
			self::OPTION_INDEX_SORTING_PAGINATION_RESET => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'index',
				'title' => 'Reset pagination with sorting',
				'desc' => 'If enabled, the pagniation will start with each sort on the index page.',
                'onlyin' => 'Pro'
			),
			self::OPTION_INDEX_HEADER_AFTER_TEXT => array(
				'type' => self::TYPE_TEXTAREA,
				'category' => 'appearance',
				'subcategory' => 'index',
				'title' => 'Text below header',
				'desc' => 'You can enter text which will appear below the header of the questions index.',
                'onlyin' => 'Pro'
			),
			self::OPTION_QUESTION_FORM_ON_TOP => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'index',
				'title' => 'Question form on top',
				'desc' => 'Display the question form above the questions table (if enabled) or below (if disabled).',
                'onlyin' => 'Pro'
			),
			self::OPTION_QUESTION_FORM_BUTTON => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'index',
				'title' => 'Question form on a separate page',
				'desc' => 'If enabled, the question form won\'t be displayed on the index page. Instead CMA will display a link to the question page. '
							. 'Question form will be displayed on the separate page.',
                'onlyin' => 'Pro'
			),
			self::OPTION_INDEX_SHOW_CONTENT => array(
				'type' => self::TYPE_RADIO,
				'options' => array(
					self::SHOW_CONTENT_NONE => 'disable',
					self::SHOW_CONTENT_FRAGMENT => 'only fragment',
					self::SHOW_CONTENT_ENTIRE => 'entire content',
				),
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'index',
				'title' => 'Show question\'s description',
				'desc' => 'Enable or disable showing the question\'s description on the index page.',
			),
			self::OPTION_QUESTION_FRAGMENT_LENGTH => array(
				'type' => self::TYPE_INT,
				'default' => 250,
				'category' => 'appearance',
				'subcategory' => 'index',
				'title' => 'Length of the question\'s fragment',
				'desc' => 'Set the fragment length which will be displayed from the question\'s description.',
			),
			self::OPTION_QUESTION_AJAX_MIN_WIDTH => array(
				'type' => self::TYPE_STRING,
				'default' => '80%',
				'category' => 'appearance',
				'subcategory' => 'index',
				'title' => 'Set the min-width of the forum page content',
				'desc' => 'Define the min-width of the question list on the forum page.',
			),
			
			// Appearance Questions Table
			self::OPTION_COLUMN_VOTES_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'table',
				'title' => 'Show number of votes for a question',
				'desc' => 'If enabled, users will see rating column, based on chosen votes mode for questions.',
			),
			self::OPTION_VIEWS_ALLOWED => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'table',
				'title' => 'Show number of views for a question',
				'desc' => 'If enabled, users will see number of views next to the question name (main Answers page only).',
			),
			self::OPTION_ANSWERS_ALLOWED => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'table',
				'title' => 'Show number of answers for a question',
				'desc' => 'If enabled, users will see number of answers next to the question name (main Answers page only).',
			),
			self::OPTION_INDEX_NUMBERS_VERTICALLY => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'table',
				'title' => 'Display numbers vertically',
				'desc' => 'If enabled, the votes, answers and views numbers will displayed vertically. If disabled - horizontally.',
                'onlyin' => 'Pro'
			),
            self::OPTION_INDEX_NUMBERS_RIGHT_SIDE => array(
                'type' => self::TYPE_BOOL,
                'default' => 0,
                'category' => 'appearance',
                'subcategory' => 'table',
                'title' => 'Display numbers on the right side',
                'desc' => 'If enabled, the votes, answers and views numbers will displayed on the right side. If disabled - on the left.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_INDEX_SHOW_DIFFICULTY_LEVEL => array(
                'type' => self::TYPE_BOOL,
                'default' => 0,
                'category' => 'appearance',
                'subcategory' => 'table',
                'title' => 'Display difficulty level',
                'desc' => 'If enabled, the Difficulty level will be added at the bottom of the question',
                'onlyin' => 'Pro'
            ),
			self::OPTION_AUTHOR_ALLOWED => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'table',
				'title' => 'Show information about the author of a question',
				'desc' => 'If enabled, users will see the information about the author of the question next to the question name (main Answers page only).',
                'onlyin' => 'Pro'
			),
			self::OPTION_AUTHOR_LINK_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'table',
				'title' => 'Author name as a link to his page',
				'desc' => 'If enabled, the username will be a link to the contributor\'s page.',
                'onlyin' => 'Pro'
			),
			self::OPTION_AUTHOR_AVATAR_LINK_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'table',
				'title' => 'Author photo as a link to his page',
				'desc' => 'If enabled, the photo(avatar) will be a link to the contributor\'s page.',
                'onlyin' => 'Pro'
			),
			self::OPTION_UPDATED_ALLOWED => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'table',
				'title' => 'Show information about the updates for a question',
				'desc' => 'If enabled, users will see the information about the last update (the author and time/date) next to the question name (main Answers page only).',
                'onlyin' => 'Pro'
			),
			self::OPTION_TABLE_QUESTION_ID_SHOW => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'table',
				'title' => 'Show question ID on questions table',
                'onlyin' => 'Pro'
			),
			self::OPTION_SHOW_LABEL_NO_ANSWER => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'table',
				'title' => 'Show label when question has no answer',
                'onlyin' => 'Pro'
			),
			self::OPTION_INDEX_SHOW_USERBOX => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'table',
				'title' => 'Show author box on index page',
				'desc' => 'If this is enabled, author profile will appear in a special box with photo.',
                'onlyin' => 'Pro'
			),
			self::OPTION_INDEX_SHOW_RIGHT_INFO => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'table',
				'title' => 'Show question info',
				'desc' => 'Showing question info in right column.',
                'onlyin' => 'Pro'
			),
			self::OPTION_INDEX_CONTENT_UNDER_TITLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'table',
				'title' => 'Show content under the title',
				'desc' => '',
                'onlyin' => 'Pro'
			),
            self::OPTION_INDEX_RECENT_ANSWER_UNDER_TITLE => array(
                'type' => self::TYPE_BOOL,
                'default' => 0,
                'category' => 'appearance',
                'subcategory' => 'table',
                'title' => 'Show recent answer under the title',
                'desc' => '',
                'onlyin' => 'Pro'
            ),
            self::OPTION_INDEX_RECENT_ANSWER_LENGTH => array(
                'type' => self::TYPE_INT,
                'default' => 55,
                'category' => 'appearance',
                'subcategory' => 'table',
                'title' => 'Recent answer text length',
                'desc' => 'Trim recent answer text to a certain number of words',
                'onlyin' => 'Pro'
            ),

			self::OPTION_STICKY_QUESTION_COLOR => array(
				'type' => self::TYPE_STRING,
				'default' => '#EEEEEE',
				'category' => 'appearance',
				'subcategory' => 'table',
				'title' => 'Sticky questions background color',
				'desc' => 'You can write color by name: white, red, lightblue. Or you can use html format #CCCCCC, #0000FF etc.',
                'onlyin' => 'Pro'
			),
			
			// Appearance Votes
			self::OPTION_VOTES_MODE => array(
				'type' => self::TYPE_RADIO,
				'options' => array(
					self::VOTES_MODE_ANSWERS_COUNT => 'Total number of votes of its answers',
					self::VOTES_MODE_HIGHEST => 'Rating of the best answer',
					self::VOTES_MODE_QUESTION_COUNT => 'Total number of votes for the question',
					self::VOTES_MODE_QUESTION_ANSWERS_COUNT => 'Sum of votes for the question and its answers',
					self::VOTES_MODE_QUESTION_RATING => 'Rating of the question',
				),
				'default' => self::VOTES_MODE_ANSWERS_COUNT,
				'category' => 'appearance',
				'subcategory' => 'rating',
				'title' => 'On questions list in "votes" box show',
				'desc' => 'If ratings are disabled, this setting will be ignored.',
			),
			self::OPTION_VOTES_NO => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'rating',
				'title' => 'Replace "0" votes/answers to "no"',
				'desc' => 'If enabled, users will see "no" instead of 0.',
                'onlyin' => 'Pro'
			),
			
			// Appearance table
			self::OPTION_THREAD_PAGE_TEMPLATE => array(
				'type' => self::TYPE_SELECT,
				'options' => [0 => 'CMA default'],
				'default' => 'page.php',
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Page template for thread',
				'desc' => 'Choose the page template of the current theme or set default.',
                'onlyin' => 'Pro'
			),
			self::OPTION_THREAD_SHOW_TITLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'misc',
				'title' => 'Show additional question title inside the content',
				'desc' => 'If your theme template doesn\'t show title, you can display an additional title inside the content.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SHOW_USER_STATS => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Show number of questions and answers next to username',
				'desc' => 'If enabled, number of questions and answers posted by user will be displayed on answers page next to username.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SHOW_GRAVATARS => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Show gravatar photos',
				'desc' => 'If this is enabled, photos from gravatar (http://www.gravatar.com/) will be shown next to user name and in his profile page.',
			),
			self::OPTION_SHOW_SOCIAL => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Show social share icons in question page',
				'desc' => 'If this is enabled, social media links (Facebook, Linkedin, Twitter) will be shown in the question page.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SHOW_QUESTION_TITLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Show question title',
				'desc' => 'If enabled, shows the title at the top of the thread page.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SHOW_ANSWERS_TITLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Show answers title',
				'desc' => 'If enabled, shows the title, with the answers count, at the top of the answers section. The title can be changed from the labels tab.',
                'onlyin' => 'Pro'
			),
			self::OPTION_QUESTION_TITLE_TAG => array(
				'type' => self::TYPE_SELECT,
				'options' => array(
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'span' => 'span',
					'p' => 'p'
				),
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Question title HTML tag',
				'desc' => 'Which HTML tag will enclose the title, affecting the layout of the page. Only applies if the title is shown.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SHOW_QUESTION_AUTHOR => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Show question author',
                'onlyin' => 'Pro'
			),
			self::OPTION_SHOW_ANSWER_AUTHOR => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Show answer author',
                'onlyin' => 'Pro'
			),
			self::OPTION_SHOW_COMMENT_AUTHOR => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Show comment author',
                'onlyin' => 'Pro'
			),
			self::OPTION_DEFAULD_AUTHORS_BADGE => array(
				'type' => self::TYPE_STRING,
				'default' => '',
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Default authors badge',
				'desc' => 'Leave empty to disable',
                'onlyin' => 'Pro'
			),
			self::OPTION_DEFAULD_AUTHORS_BADGE_COLOR => array(
				'type' => self::TYPE_COLOR,
				'default' => '#0bc100',
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Default authors badge color',
                'onlyin' => 'Pro'
			),
			self::OPTION_SHOW_AUTHOR_USERNAME => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Show author username instead of Name and Surname',
                'onlyin' => 'Pro'
			),
			self::OPTION_ANSWER_SORTING_BY => array(
				'type' => self::TYPE_RADIO,
				'options' => array(
					'newest' => 'date',
					'votes' => 'votes',
				),
				'default' => 'newest',
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Sort answers by',
				'desc' => 'Default: by date.',
			),
			self::OPTION_ANSWER_SORTING_DESC => array(
				'type' => self::TYPE_RADIO,
				'options' => array(
					0 => 'Ascending order (oldest or lowest rate first)',
					1 => 'Descending order (newest or highest rate first)',
				),
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Sort answers in',
				'desc' => 'Specify how answers to a question should be sorted (default: descending).',
			),
			self::OPTION_ANSWER_PAGINATION => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Paginate the answers',
				'desc' => 'If enabled, breaks down the forum in multiple parts and shows the pagination buttons at the bottom. The text of the Previous and Next buttons can be changed from the labels tab.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ANSWER_PAGINATION_COUNT => array(
				'type' => self::TYPE_INT,
				'min' => 1,
				'max' => 9999,
				'default' => 5,
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Answers per page',
				'desc' => 'The amount of answers per each pagination page.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SHORTCODES_WHITELIST => array(
				'type' => self::TYPE_CSV_LINE,
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Shortcodes whitelist',
				'desc' => 'Enter the shortcodes comma-separated list (only names, without brackets) which can be used by all users in their questions and answers. '
						. 'Other shortcodes won\'t be executed.',
                'onlyin' => 'Pro'
			),
			
			// Appearance attachments
			self::OPTION_EMBED_ATTACHED_IMAGES => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'attachments',
				'title' => 'Embed attached images',
				'desc' => 'If enabled, the images attached with the question/answer will be embeded below the content.',
                'onlyin' => 'Pro'
			),
			self::OPTION_EMBED_ATTACHED_IMAGES_SIZE => array(
				'type' => self::TYPE_INT,
				'default' => 200,
				'category' => 'appearance',
				'subcategory' => 'attachments',
				'title' => 'Dimensions of the attached image thumbnail [px]',
				'desc' => 'Set the thumbnail max width or height in pixels for the attached images.',
                'onlyin' => 'Pro'
			),
			
			// Appearance Editor
			self::OPTION_RICHTEXT_EDITOR => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'Show richtext editor for question/answer form',
				'desc' => 'If enabled, the question/answer textarea will be replaced with RichText editor (TinyMCE).',
                'onlyin' => 'Pro'
			),
            self::OPTION_EXCLUDE_RICHTEXT_EDITOR_FOR_ROLES => array(
				'type' => self::TYPE_MULTISELECT,
				'default' => '',
				'options' => array(__CLASS__, 'getRolesOptions'),
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'Disable rich text editor for user roles:',
				'desc' => 'Select the user roles that should not be allowed to use the RichText editor when it`s enabled.',
                'onlyin' => 'Pro'
			),
			self::OPTION_TABLE_BUTTON_EDITOR => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'Show table button in rich editor',
				'desc' => 'If enabled, you will be able to add tables in RichText editor (TinyMCE).',
                'onlyin' => 'Pro'
			),
            self::OPTION_TABLE_TOOLBAR => array(
                'type' => self::TYPE_BOOL,
                'default' => 0,
                'category' => 'appearance',
                'subcategory' => 'editor',
                'title' => 'Show table pop up properties in rich editor',
                'desc' => 'If enabled, the table pop up properties will be shown in RichText editor (TinyMCE).',
                'onlyin' => 'Pro'
            ),
			self::OPTION_SHOW_TOOLBAR_EDITOR => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'Show toolbar in richtext editor by default',
				'desc' => 'if enabled, toolbar in richtext editor shows by default',
                'onlyin' => 'Pro'
			),
			self::OPTION_ALLOW_MEDIA_UPLOAD_FOR_SUBSCRIBERS => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'Allow media upload for subscribers in rich editor',
				'desc' => 'if enabled, Add media button will be available for Subscriber role<br>' . '<b>Caution: it can make your site vulnerable, as this option gives an access to media of your site</b>',
                'onlyin' => 'Pro'
			),

			self::OPTION_JUSTIFY_TEXT_EDITOR => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'Add justify button to text align block',
				'desc' => 'if enabled, justify button in richtext editor is shown',
                'onlyin' => 'Pro'
			),

			self::OPTION_EDITOR_ROWS => array(
				'type' => self::TYPE_INT,
				'default' => 3,
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'Editor rows number',
                'onlyin' => 'Pro'
			),
			self::OPTION_MARKUP_BOX_SHOW => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'Show markup box near question/answer form',
				'desc' => 'If enabled, the box showing the markup and codewrap possibility will appear.',
			),
			self::OPTION_JS_LIMIT => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'Enable JS limit',
				'desc' => 'If enabled, below input fields will be displayed an information about entered text length and the characters left.',
                'onlyin' => 'Pro'
			),
			self::OPTION_JS_LIMIT_QUESTION_TITLE => array(
				'type' => self::TYPE_INT,
				'category' => 'appearance',
				'subcategory' => 'editor',
				'default' => 100,
				'title' => 'Limit for question title',
				'desc' => 'Enter characters limit for a question title. It works on the server-side even when the JS limiting is disabled. Enter 0 to disable.',
			),
			self::OPTION_JS_LIMIT_QUESTION_DESCRIPTION => array(
				'type' => self::TYPE_INT,
				'category' => 'appearance',
				'subcategory' => 'editor',
				'default' => 10000,
				'title' => 'Limit for question description',
				'desc' => 'Enter characters limit for a question title. Enter 0 to disable. It works on the server-side even when the JS limiting is disabled. '
						. 'On the front-end works only if rich text editor is disabled.',
			),
			self::OPTION_JS_LIMIT_ANSWER_COMMENT => array(
				'type' => self::TYPE_INT,
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'Limit for answer',
				'desc' => 'Enter characters limit for an answer. Enter 0 to disable. It works on the server-side even when the JS limiting is disabled.',
			),
			self::OPTION_JS_LIMIT_QUESTION_COMMENT => array(
				'type' => self::TYPE_INT,
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'Limit for answer comment',
				'desc' => 'Enter characters limit for a comment to answer. Enter 0 to disable. It works on the server-side even when the JS limiting is disabled.',
                'onlyin' => 'Pro'
			),
			self::OPTION_NOTIFY_CHECKBOX_CHECKED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'Notification option checked by default',
				'desc' => 'Make the "Notify me of follow" option on the question/answer form to be checked by default.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ADMINONLY_CHECKBOX_CHECKED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'For admin only option checked by default',
				'desc' => 'Make the "For admin only" option on the question form to be checked by default.',
                'onlyin' => 'Pro'
			),
// 			self::OPTION_HIDE_REQUIRED_CATEGORY_IF_ONE => array(
// 				'type' => self::TYPE_BOOL,
// 				'default' => 1,
// 				'category' => 'appearance',
// 				'subcategory' => 'editor',
// 				'title' => 'Hide required categories select-box if only one exists',
// 				'desc' => 'If enabled, the categories select-box will be hidden if category is required to post a question and only one category exists.',
// 			),
			self::OPTION_SUBMIT_BUTTON_CSS_BACKGROUND => array(
				'type' => self::TYPE_STRING,
				'default' => '',
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'Submit button background color',
				'desc' => 'Set the custom background for the submit button or leave empty to use default.<br>Example: #66cc66',
                'onlyin' => 'Pro'
			),
			self::OPTION_ESCAPE_PRE_CONTENT => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'Escape the &lt;pre&gt; tag content',
				'desc' => 'If enabled, HTML code inside the &lt;pre&gt; tag will be escaped. If disabled, HTML code inside won\'t be escaped.',
                'onlyin' => 'Pro'
			),
			self::OPTION_CONTENT_ALLOWED_TAGS => array(
				'type' => self::TYPE_TEXTAREA,
				'default' => "a href title, pre class, p, del, ins, code, blockquote, em, strong, b, br, ul, ol, li, h1, h2, h3, h4, h5, h6, hr",
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'Allowed HTML tags and attributes',
				'desc' => 'Enter list of the allowed tags and it\'s attributes. Other tags will be escaped from the question or answer content.<br>'
						. 'Separate tags with commas or new lines. '
						. 'Allowed tag\'s attributes type next to the tag, separated by spaces.<br><br>'
						. 'Example:<pre>a href title, img src, p style</pre>',
                'onlyin' => 'Pro'
			),
			self::OPTION_INCLUDE_CLASS_WP_EDITOR => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'editor',
				'title' => 'Include class-wp-editor',
				'desc' => 'Disable this option to do not include wp-includes/class-wp-editor.php file if experiencing an issue with WP Editor on the CMA pages.',
                'onlyin' => 'Pro'
			),
			
			// Appearance Navigation
            self::OPTION_SHOW_INDEX_PAGE_NAV_BAR => array(
                'type' => self::TYPE_BOOL,
                'default' => 1,
                'category' => 'appearance',
                'subcategory' => 'navigation',
                'title' => 'Show navigation bar on the index page',
                'desc' => 'If disabled, the navigation bar will be not displayed on the index page.',
                'onlyin' => 'Pro'
            ),
			self::OPTION_SHOW_QUESTION_PAGE_NAV_BAR => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'navigation',
				'title' => 'Show navigation bar on the question page',
				'desc' => 'If disabled, the navigation bar will be not displayed on the single question page.',
                'onlyin' => 'Pro'
			),
			self::OPTION_CATEGORY_FILTER_MODE => array(
				'type' => self::TYPE_RADIO,
				'options' => array(
					self::CATEGORY_FILTER_MODE_TREE => 'Single select box with categories tree',
					self::CATEGORY_FILTER_MODE_TWO_LEVEL => 'Two-level filter',
					self::CATEGORY_FILTER_MODE_DISABLED => 'Disabled',
				),
				'default' => self::CATEGORY_FILTER_MODE_TREE,
				'category' => 'appearance',
				'subcategory' => 'navigation',
				'title' => 'Category filter mode',
				'desc' => 'Category filter which displays on the thread list.',
                'onlyin' => 'Pro'
			),
			self::OPTION_BREADCRUMBS_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'navigation',
				'title' => 'Show breadcrumbs',
				'desc' => 'If enabled, the breadcrumbs will be added above the title on the index page and the thread page.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ALLOW_POST_ONLY_SUBCATEGORIES => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'navigation',
				'title' => 'Allow to post questions only in subcategories when the two-level categories filter enabled',
				'desc' => 'Works only when two-level categories filter is set.<br>' .
							'If disabled, users will be able to post questions to any category.<br>' .
							'If enabled, users will be ale to post questions only in the subcategories.',
                'onlyin' => 'Pro'
			),
			self::OPTION_BACKLINK_PARAM_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'navigation',
				'title' => 'Add a backlink parameter to URL',
				'desc' => 'If enabled, the backlink parameter will be added to the thread\'s permalink to create backlinks. '
							. 'If disbled, plugin will use HTTP referer instead.',
                'onlyin' => 'Pro'
			),
			self::OPTION_NAVBAR_AUTO_SUBMIT => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'navigation',
				'title' => 'Apply navbar filters instantly',
				'desc' => 'If enabled, changing the navigation bar select-box filters will be automatically applied.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SEARCH_FOR_USERS => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'navigation',
				'title' => 'Search for users',
				'desc' => 'If enabled, allows to search for users on questions page',
                'onlyin' => 'Pro'
			),
			self::OPTION_SEARCH_INCLUDE_TAGS => array(
				'type' => self::TYPE_RADIO,
				'options' => array(
					self::SEARCH_INCLUDE_TAGS_DISABLE => 'disabled',
					self::SEARCH_INCLUDE_TAGS_SINGLE => 'match whole search term as a single tag',
					self::SEARCH_INCLUDE_TAGS_MULTIPLE_ONE => 'separate search term by spaces and match single tag',
					self::SEARCH_INCLUDE_TAGS_MULTIPLE_ALL => 'separate search term by spaces and match all tags',
				),
				'default' => self::SEARCH_INCLUDE_TAGS_SINGLE,
				'category' => 'appearance',
				'subcategory' => 'navigation',
				'title' => 'Search questions by tags in the standard WP search',
                'onlyin' => 'Pro'
			),
			
			// Appearance Login Widget
			self::OPTION_SHOW_LOGIN_WIDGET => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'login',
				'title' => 'Show Login Widget',
				'desc' => 'If disabled, users will not see the login widget with the login form and social login links on the CM Answers pages at all.',
                'onlyin' => 'Pro'
            ),
			self::OPTION_SHOW_LOGIN_FORM => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'login',
				'title' => 'Show login form',
				'desc' => 'If disabled, users will not see WP login form on the Login Widget, but they will see Social Login buttons, if defined.',
			),
            self::OPTION_REDIRECT_URL_AFTER_LOGIN => array(
                'type' => self::TYPE_STRING,
                'default' => get_site_url(),
                'category' => 'appearance',
                'subcategory' => 'login',
                'title' => 'Link to redirect after social login',
                'desc' => 'Enter the URL of the page you want to redirect to after social login',
                'onlyin' => 'Pro'
            ),
			self::OPTION_LOGIN_PAGE_LINK_TITLE => array(
				'type' => self::TYPE_STRING,
				'default' => 'Go to WP login page',
				'category' => 'appearance',
				'subcategory' => 'login',
				'title' => 'Login page link title',
				'desc' => 'The title of the link which leads to the WP login page if the user is not logged in. Leave blank to disable.',
                'onlyin' => 'Pro'
			),
			self::OPTION_LOGIN_PAGE_LINK_URL => array(
				'type' => self::TYPE_STRING,
				'category' => 'appearance',
				'subcategory' => 'login',
				'title' => 'Login page link URL',
				'desc' => 'Enter the custom login page URL if using non-default. Leave blank to use default WP login page.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SHOW_REGISTRATION_LINK => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'login',
				'title' => 'Show registration link',
				'desc' => 'If enabled, the registration link will be added to the login form. Link will be visible only if WP allows guests registration.',
                'onlyin' => 'Pro'
			),
			self::OPTION_REGISTRATION_URL => array(
				'type' => self::TYPE_STRING,
				'category' => 'appearance',
				'subcategory' => 'login',
				'title' => 'Registration link URL',
				'desc' => 'Enter the custom registration page URL if using non-default. Leave blank to use default WP registration page.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SHOW_LOST_PASSWORD => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'login',
				'title' => 'Show lost password link',
				'desc' => 'If enabled, the "Lost password" link will be added to the login form.',
                'onlyin' => 'Pro'
			),
			self::OPTION_LOST_PASSWORD_URL => array(
				'type' => self::TYPE_STRING,
				'category' => 'appearance',
				'subcategory' => 'login',
				'title' => 'Reset password link URL',
				'desc' => 'Enter the custom reset password page URL if using non-default. Leave blank to use default WP registration page.',
                'onlyin' => 'Pro'
			),
            self::OPTION_REDIRECT_GUEST_WITH_QUESTION_FORM_SEPARATE_PAGE => array(
                'type' => self::TYPE_BOOL,
                'default' => 0,
                'category' => 'appearance',
                'subcategory' => 'login',
                'title' => 'Redirect not logined users with Question form on a separate page',
                'desc' => 'Activated, if enabled "Question form on a separate page',
                'onlyin' => 'Pro'
            ),
            self::OPTION_REDIRECT_AFTER_POST_QUESTION => array(
                'type' => self::TYPE_BOOL,
                'default' => 1,
                'category' => 'appearance',
                'subcategory' => 'login',
                'title' => 'Redirect after post new question',
                'desc' => 'If enabled, user will be redirected to the new question page. Disable to stay at the page with question form.',
                'onlyin' => 'Pro'
            ),
			
			// Appearance Misc
			self::OPTION_LOOK_AND_FEEL_STYLE => array(
				'type' => self::TYPE_SELECT,
				'options' => array(
					'' => '-- default --',
					'2017-04' => 'April 2017',
				),
				'category' => 'appearance',
				'subcategory' => 'misc',
				'title' => 'Look and file style',
				'desc' => 'You can choose one from the additional styles we\'ve prepared for the front-end look and feel.',
                'onlyin' => 'Pro'
			),
			self::OPTION_DATE_TIME_FORMAT => array(
				'type' => self::TYPE_STRING,
				'default' => '',
				'category' => 'appearance',
				'subcategory' => 'misc',
				'title' => 'Date/time format',
				'desc' => 'Enter the date/time format that will be displayed as the created date next to the questions and answers. '
						. 'Leave empty to use Wordpress defaults.',
                'onlyin' => 'Pro'
			),
			self::OPTION_DATE_TIME_OFF => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'misc',
				'title' => 'Hide time',
				'desc' => 'If enable then time will hide and it will work if above option is empty',
                'onlyin' => 'Pro'
			),
			self::OPTION_REPLACE_POST_COMMENTS_SHORTCODE_ATTR => array(
				'type' => self::TYPE_STRING,
				'default' => 'limit=100 pagination=0 search=0',
				'category' => 'appearance',
				'subcategory' => 'misc',
				'title' => 'Attributes for shortcode replacing default comments',
				'desc' => 'If you replaced the default comments on a post or page, instead of default comments, '
						. 'the questions from chosen category will be displayed using this shortcode attributes. '
						. 'You can use the same attributes like in the cma-questions shortcode.',
                'onlyin' => 'Pro'
			),
			self::OPTION_BP_GROUP_SHORTCODE_ATTR => array(
				'type' => self::TYPE_STRING,
				'default' => 'formontop=0 limit=10 sort=hottest form=1 navbar=0 skipanonymously=1',
				'category' => 'appearance',
				'subcategory' => 'misc',
				'title' => 'Shortcode attributes for BuddyPress Group',
				'desc' => 'If you assigned some BP Group with a CMA category you can adjust the shortcode which is used to display the CMA question\'s list.',
                'onlyin' => 'Pro'
			),
			self::OPTION_BP_GROUP_RESTRICT_QUESTIONS => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'misc',
				'title' => 'Restrict group questions for the users which are not in BuddyPress Group',
				'desc' => 'If you assigned some BP Group with a CMA category unmembered users will not see group questions',
                'onlyin' => 'Pro'
			),
			self::OPTION_BP_GROUP_RESTRICT_CATEGORY_TEXT => array(
				'type' => self::TYPE_RICH_TEXT,
				'default' => "This content is restricted. \nTry to address the issue to your administrator",
				'category' => 'appearance',
				'subcategory' => 'misc',
				'title' => 'The message for resticted question content',
				'desc' => 'Works only if BuddyPress restriction is enabled',
                'onlyin' => 'Pro'
			),
			self::OPTION_CONTRIBUTOR_CUSTOM_URL => array(
				'type' => self::TYPE_STRING,
				'category' => 'appearance',
				'subcategory' => 'misc',
				'title' => 'User\'s profile custom URL',
				'desc' => 'Enter the custom URL of the user\'s profile page, for example if you are using BuddyPress.<br>'
							. 'Leave blank to use default CMA contributor\'s page.<br><br>'
							. '%s - user\'s nicename<br>%d - user\'s ID<br>Example: /user/profile/%s (will give /user/profile/admin).',
                'onlyin' => 'Pro'
			),
            self::OPTION_DISABLE_AUTHOR_PAGE => array(
                'type' => self::TYPE_BOOL,
                'default' => 1,
                'category' => 'appearance',
                'subcategory' => 'misc',
                'title' => 'Disable answers authors\' pages',
                'desc' => 'If enabled, pages with URL /answer/answers/author/ will be disabled (it will show 404 instead).',
                'onlyin' => 'Pro'
            ),
			self::OPTION_SUPPORT_THEME_DIR => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'misc',
				'title' => 'Support template overriding',
				'desc' => 'If enabled, the templates will be overriden by using files in the "CMA" directory created in your theme folder.',
                'onlyin' => 'Pro'
			),
			self::OPTION_DISABLE_CSS => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'misc',
				'title' => 'Disable app.css',
				'desc' => 'You can disable attaching the app.css file. The custom CSS will be still attached.',
                'onlyin' => 'Pro'
			),
			self::OPTION_HIDE_CATEGORIES => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'misc',
				'title' => 'Hide categories',
				'desc' => 'If enabled, the categories won\'t be displayed in the questions table.',
                'onlyin' => 'Pro'
			),
			self::OPTION_RELATED_QUESTIONS_POST_TYPES => array(
				'type' => self::TYPE_MULTICHECKBOX,
				'options' => array(__CLASS__, 'getPostTypesOptions'),
				'category' => 'appearance',
				'subcategory' => 'misc',
				'default' => array(),
				'title' => 'Show related questions below chosen post types',
				'desc' => 'If enabled, the related questions widget will be automatically added below each post for the chosen post types. '
							.'You can override this settings on the specific post edit page.',
                'onlyin' => 'Pro'
			),
			self::OPTION_RELATED_QUESTIONS_SHORTCODE_PARAMS => array(
				'type' => self::TYPE_STRING,
				'default' => 'limit=5',
				'category' => 'appearance',
				'subcategory' => 'misc',
				'title' => 'Post\'s related questions shortcode params',
				'desc' => 'Define the params of related question\'s shortcode to show below the post.',
                'onlyin' => 'Pro'
			),
			
			
			// Thread question
			self::OPTION_QUESTION_DESCRIPTION_OPTIONAL => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Allow questions with no description',
				'desc' => 'If enabled, users will be able to post questions without description.',
			),
			self::OPTION_CATEGORY_SWITCH => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Let users choose the category when posting questions',
				'desc' => 'Shows the category picker on the question submission form. If this option is disabled, users won\'t choose a category and new questions will have no category.',
                'onlyin' => 'Pro'
			),
			self::OPTION_CAN_EDIT_CATEGORY => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Let users change the category of their questions',
				'desc' => 'Shows the category picker on the question edit form.',
                'onlyin' => 'Pro'
			),
			self::OPTION_QUESTION_REQUIRE_CATEGORY => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Require category',
				'desc' => 'If enabled, users won\'t be able to post question without choosing a category but it will work if enabled above option.',
                'onlyin' => 'Pro'
			),
			self::OPTION_TAGS_SWITCH => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Enable tags in questions',
				'desc' => 'If enabled, tags field will appear when submitting a question.',
                'onlyin' => 'Pro'
			),
			self::OPTION_TAGS_SWITCH_REQUIRED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Is tags required',
				'desc' => 'If enabled, tags field is requied when submitting a question but it will work if enabled above option.',
                'onlyin' => 'Pro'
			),
			self::OPTION_TAGS_SWITCH_LIMIT => array(
				'type' => self::TYPE_INT,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Tags limit',
				'desc' => 'Tags limit such as 1, 3, 5 etc.<br><strong>Note:</strong> 0 means user able to upload unlimited tags',
                'onlyin' => 'Pro'
			),
			self::OPTION_CAN_EDIT_TAGS => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Let users change tags of their questions',
				'desc' => 'Shows the tag selector on the question edit form.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ENABLE_MARK_FAVORITE_QUESTIONS => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Allow to mark question as favorite',
                'onlyin' => 'Pro'
			),
			self::OPTION_ENABLE_QUESTION_RATING => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Enable ratings for questions',
				'desc' => 'If enabled, users will be able to rate questions.',
                'onlyin' => 'Pro'
			),
            self::OPTION_ENABLE_DIFFICULTY_LEVEL => array(
                'type' => self::TYPE_BOOL,
                'default' => 0,
                'category' => 'thread',
                'subcategory' => 'question',
                'title' => 'Enable difficulty level for questions',
                'desc' => 'If enabled, users will be able to specify difficulty level of the question.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_ENABLE_DIFFICULTY_LEVEL_NUMBER => array(
                'type' => self::TYPE_BOOL,
                'default' => 0,
                'category' => 'thread',
                'subcategory' => 'question',
                'title' => 'Enable difficulty level number for questions',
                'desc' => 'If enabled, the difficulty level number will be displayed.',
                'onlyin' => 'Pro'
            ),
			self::OPTION_CAN_EDIT_DIFFICULTY => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Let users change the difficulty of their questions',
				'desc' => 'Shows the difficulty selector on the question edit form.',
                'onlyin' => 'Pro'
			),
			self::OPTION_RESOLVE_THREAD_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Allow author to resolve thread',
				'desc' => 'If this is enabled, author can mark thread as resolved. You can disable posting answers in the resolved thread.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SHOW_ONLY_OWN_QUESTIONS => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Show only users own questions',
				'desc' => 'If enabled, user will be able to display only questions that he posted.',
                'onlyin' => 'Pro'
			),
			self::OPTION_DUPLICATED_QUESTIONS_MODE => array(
				'type' => self::TYPE_RADIO,
				'options' => array(
					self::DUPLICATED_QUESTIONS_ALLOW => 'Allow',
					self::DUPLICATED_QUESTIONS_SAME_AUTHOR => 'Disallow when the author asked a question with the same title before',
					self::DUPLICATED_QUESTIONS_ANY_AUTHOR => 'Disallow when any author asked a question with the same title before',
				),
				'default' => self::DUPLICATED_QUESTIONS_ALLOW,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Duplicated questions',
				'desc' => 'Decide how to support the duplicated questions.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ALLOW_QUESTION_DELETE => array(
				'type' => self::TYPE_RADIO,
				'options' => array(
					self::DELETE_MODE_DISALLOWED => 'Disallowed',
					self::DELETE_MODE_WITHIN_HOUR => 'Within one hour',
					self::DELETE_MODE_WITHIN_DAY => 'Within one day',
					self::DELETE_MODE_ANYTIME => 'Anytime',
				),
				'default' => self::DELETE_MODE_DISALLOWED,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Allow author to delete his question',
				'desc' => 'Decide whether the question author can delete his question.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ALLOW_QUESTION_DELETE_NOANSWERS => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Delete question allowed only if no answers posted',
				'desc' => 'If author is allowed to delete his questions, you can limit this for only those questions which have no answers.',
                'onlyin' => 'Pro'
			),
			self::OPTION_QUESTION_DELETE_TRASH => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Put questions to trash instead deleting',
				'desc' => 'If enabled, admin will be allowed to browse the Trash to figure out which questions has been deleted and restore them or empty the Trash.',
                'onlyin' => 'Pro'
			),
			self::OPTION_USER_RELATED_QUESTIONS_ENABLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Allow to set related questions by user',
				'desc' => 'If enabled, user will be able to select related questions which will be displayed on the thread page.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ANONYMOUS_USER_CHECKBOX_ENABLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Let users post questions and answers anonymously',
				'desc' => 'Shows the option to registered users when posting. The user name will be hidden and the profile won\'t be linked. Disabling this setting will reveal all names. The checkbox text can be changed from the labels settings.',
				'class' => 'cm-ask-users-anonymously',
                'onlyin' => 'Pro'
			),
			self::OPTION_ANONYMOUS_USER_ENABLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Let users post questions or answers with a nickname',
				'desc' => 'Shows the option to registered users when posting. The user profile will not be linked.  Disabling this setting will reveal all names. The checkbox text can be changed from the labels settings.',
				'class' => 'cm-anonymous-user-enable',
				'display' => 0,
                'onlyin' => 'Pro'
			),
			self::OPTION_ENABLE_THREAD_FOR_ADMIN_ONLY => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Enable thread for admin only',
				'desc' => 'If enabled, the "For admin only" option will be available.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ADD_ALL_WPML_LANGUAGES_CATEGORIES_TO_QUESTION => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question',
				'title' => 'Enable multilingual category for the question',
				'desc' => '<strong>WPML Integration</strong><br>If enabled, all wpml translations of selected categories will be added to question.',
                'onlyin' => 'Pro'
			),
			self::OPTION_THREAD_DISPLAY_ID => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Display question ID',
				'desc' => 'If enabled, thread page will display question ID in order to refer in another question (see related question option).',
                'onlyin' => 'Pro'
			),
			self::OPTION_ADD_RESOLVED_QUESTION_TITLE_PREFIX => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'thread',
				'title' => 'Add [RESOLVED] prefix to resolved question\'s title',
                'onlyin' => 'Pro'
			),
			
			// Thread Answers
			self::OPTION_ANSWER_AFTER_RESOLVED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'answer',
				'title' => 'Allow answers after the question has been resolved',
				'desc' => 'If enabled, users will be able to post answers even after the question was resolved.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ALLOW_COMMENTS_IN_RESOLVED_THREAD => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'thread',
				'subcategory' => 'answer',
				'title' => 'Allow comments after the question has been resolved',
				'desc' => 'If enabled, users will be able to post comments even after the question was resolved.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ANSWERS_RATING_ALLOWED => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'thread',
				'subcategory' => 'answer',
				'title' => 'Enable ratings for answers',
				'desc' => 'If enabled, users will be able to rate answers and will see the number of answers next to the question name (main Answers page only).',
			),
			self::OPTION_ENABLED_MARK_BEST_ANSWER => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'answer',
				'title' => 'Enable marking as the best answer',
				'desc' => 'If enabled, author will be able to mark the best answer for his question which will be highlighted.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ALLOW_OWN_BEST_ANSWER => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'answer',
				'title' => 'Allow marking own answer as best answer',
				'desc' => 'If enabled, question author will be able to mark own answer as the best answer.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ENABLED_UNMARK_BEST_ANSWER => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'answer',
				'title' => 'Enable unmarking the best answer',
				'desc' => 'If enabled, author will be able to unmark the best answer.',
                'onlyin' => 'Pro'
			),
			self::OPTION_BEST_ANSWER_REMOVE_OTHER => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'answer',
				'title' => 'Allow to remove non-best answers',
				'desc' => 'If enabled, when marking the best answer, user will be aksed wheter to remove other non-best answers from the thread or not.',
                'onlyin' => 'Pro'
			),
			self::OPTION_PRIVATE_ANSWERS_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'answer',
				'title' => 'Allow private answers',
				'desc' => 'If enabled, user will be allowed to post answers which can be viewed only by the author of the question.',
                'onlyin' => 'Pro'
			),
			self::OPTION_PRIVATE_ANSWER_BGCOLOR => array(
				'type' => self::TYPE_STRING,
				'default' => '#f3fff3',
				'category' => 'thread',
				'subcategory' => 'answer',
				'title' => 'Private answer background color',
				'desc' => 'CSS color for the .cma-answer-private selector.',
                'onlyin' => 'Pro'
			),

            self::OPTION_ANSWER_MIN_WORDS => array(
                'type' => self::TYPE_STRING,
                'default' => '0',
                'category' => 'thread',
                'subcategory' => 'answer',
                'title' => 'Min words amount',
                'desc' => 'Set here required minimum amount of words in the answer. Set to "0" to disable this options.',
                'onlyin' => 'Pro'
            ),

            self::OPTION_ANSWER_MAX_HYPERLINKS => array(
                'type' => self::TYPE_STRING,
                'default' => '0',
                'category' => 'thread',
                'subcategory' => 'answer',
                'title' => 'Max hyperlinks',
                'desc' => 'Set here maximum allowed amount of hyperlinks in the answer. Set to "0" to disable this option.',
                'onlyin' => 'Pro'
            ),

            // Thread Spam
			self::OPTION_SPAM_REPORTING_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'spam',
				'title' => 'Enable spam reporting for questions/answers',
                'onlyin' => 'Pro'
			),
			self::OPTION_SPAM_REPORTING_GUESTS => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'spam',
				'title' => 'Allow guests to report a spam',
				'desc' => 'If set to Yes then non-logged users also will can send a spam report.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SPAM_REPORTING_EMAIL_ADDR => array(
				'type' => self::TYPE_STRING,
				'default' => '',
				'category' => 'thread',
				'subcategory' => 'spam',
				'title' => 'Send spam report to an email address',
				'desc' => 'Multiple addresses separate by comma.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SPAM_REPORTING_EMAIL_SUBJECT => array(
				'type' => self::TYPE_STRING,
				'default' => "[[blogname]] Spam report in thread: [title]",
				'category' => 'thread',
				'subcategory' => 'spam',
				'title' => 'Spam report email subject',
				'desc' => 'You can use the following tokens: [blogname], [url], [title], [author], [content], [user], [datetime], [trash], [spam].',
                'onlyin' => 'Pro'
			),
			self::OPTION_SPAM_REPORTING_EMAIL_TEMPLATE => array(
				'type' => self::TYPE_TEXTAREA,
				'default' => "Hi, user [user] has reported a spam.\n\nThread: [title]\nURL: [url]\nAuthor: [author]\nContent:\n[content]\n\n"
							."Trash it: [trash]\nSpam: [spam]",
				'category' => 'thread',
				'subcategory' => 'spam',
				'title' => 'Spam report email template',
				'desc' => 'You can use the following tokens: [blogname], [url], [title], [author], [content], [user], [datetime], [trash], [spam].',
                'onlyin' => 'Pro'
			),
				
			self::OPTION_COMMENTS_QUESTION_ENABLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'thread',
				'subcategory' => 'comments',
				'title' => 'Enable the question comments',
				'desc' => 'If enabled, users except normal answers will be able to post comments to the question.',
                'onlyin' => 'Pro'
			),
            self::OPTION_COMMENTS_RATING_ALLOWED => array(
                'type' => self::TYPE_BOOL,
                'default' => 1,
                'category' => 'thread',
                'subcategory' => 'comments',
                'title' => 'Enable ratings for comments',
                'desc' => 'If enabled, users will be able to rate comments.',
                'onlyin' => 'Pro'
            ),
			self::OPTION_COMMENTS_QUESTION_ATTACHMENT_ENABLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'comments',
				'title' => 'Enable the attachment for question comments',
				'desc' => 'If enabled, users will be able to add attachment with comments to the question.',
                'onlyin' => 'Pro'
			),
			self::OPTION_COMMENTS_ANSWER_ENABLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'thread',
				'subcategory' => 'comments',
				'title' => 'Enable the answer comments',
				'desc' => 'If enabled, users will be able to post comments to the answers.',
                'onlyin' => 'Pro'
			),
			self::OPTION_COMMENTS_ANSWER_ATTACHMENT_ENABLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'comments',
				'title' => 'Enable the attachment for answer comments',
				'desc' => 'If enabled, users will be able to add attachment with comments to the answers.',
                'onlyin' => 'Pro'
			),
			
			// Thread Common
			self::OPTION_INCREMENT_VIEWS => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'thread',
				'subcategory' => 'common',
				'title' => 'Increment number of views every time the page is refreshed',
				'desc' => 'If enabled, views counter will be increased every time the page is refreshed. If disabled, cookie will be set to block user '
						. 'from increasing the counter on current machine.',
                'onlyin' => 'Pro'
			),
			self::OPTION_NEGATIVE_RATING_ALLOWED => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'thread',
				'subcategory' => 'common',
				'title' => 'Enable negative ratings',
				'desc' => 'If enabled, users will be able to give "thumbs down" for an answer. If previous settings is disabled, this will be ignored.',
			),
			self::OPTION_EDIT_MODE => array(
				'type' => self::TYPE_RADIO,
				'options' => array(
					self::EDIT_MODE_DISALLOWED => 'Disallowed',
					self::EDIT_MODE_WITHIN_HOUR => 'Within one hour',
					self::EDIT_MODE_WITHIN_DAY => 'Within one day',
					self::EDIT_MODE_ANYTIME => 'Anytime',
				),
				'default' => self::EDIT_MODE_DISALLOWED,
				'category' => 'thread',
				'subcategory' => 'common',
				'title' => 'Editing question or answer by its author',
				'desc' => 'Choose the mode of editing questions and answers.',
                'onlyin' => 'Pro'
			),
			self::OPTION_CAN_EDIT_RESOLVED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'common',
				'title' => 'Allow editing resolved questions or its answers',
				'desc' => 'If this is enabled, user can edit resolved questions and answers of a resolved question.',
                'onlyin' => 'Pro'
			),
// 			self::OPTION_ALLOW_UNVOTE => array(
// 				'type' => self::TYPE_BOOL,
// 				'default' => 0,
// 				'category' => 'thread',
// 				'subcategory' => 'common',
// 				'title' => 'Allow to unvote',
// 				'desc' => 'If enabled, user can undone his rating.',
// 			),
			self::OPTION_CAN_VOTE_MYSELF => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'common',
				'title' => 'Allow user to vote for content posted by himself',
				'desc' => 'If enabled, user can vote for a question or answer posted by himself.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ALLOW_GUESTS_VOTING => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'common',
				'title' => 'Allow guests voting',
				'desc' => 'If enabled, not logged-in users will be able to vote for questions and answers. The voting will be limited for single IP address.',
                'onlyin' => 'Pro'
			),
            self::OPTION_VOTING_ON_LIST => array(
                'type' => self::TYPE_BOOL,
                'default' => 0,
                'category' => 'thread',
                'subcategory' => 'common',
                'title' => 'Allow voting up on questions list',
                'desc' => 'If enabled, users will be able to vote for questions on questions lists.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_ENABLE_INTEGRATION_WITH_UM_FOLLOW => array(
                'type' => self::TYPE_BOOL,
                'default' => FALSE,
                'category' => 'thread',
                'subcategory' => 'common',
                'title' => 'Enable integration with UM Followers extension',
                'desc' => 'If the option is enabled the Ultimate Member "Follow" button appear near answer author information.'
                    . ' Ultimate Member plugin and Ultimate Member Followers Extension have to be activated.',
                'onlyin' => 'Pro'
            ),
			
			// Attachments
			self::OPTION_ATTACHMENTS_QUESTIONS_ALLOW => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'attachments',
				'title' => 'Allow attachments in questions',
				'desc' => 'If enabled, user will be able to upload files which will be attached to the posted question.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ATTACHMENTS_ANSWERS_ALLOW => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'attachments',
				'title' => 'Allow attachments in answer',
				'desc' => 'If enabled, user will be able to upload files which will be attached to the posted answer.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ATTACHMENTS_FILE_EXTENSIONS => array(
				'type' => self::TYPE_CSV_LINE,
				'category' => 'thread',
				'subcategory' => 'attachments',
				'title' => 'Allowed attachment file types',
				'desc' => 'Comma-separated list of allowed attachment file types. Leave empty to disable. (example: zip,doc,docx).',
                'onlyin' => 'Pro'
			),
			self::OPTION_ATTACHMENTS_MAX_SIZE => array(
				'type' => self::TYPE_INT,
				'default' => 1024*1024,
				'category' => 'thread',
				'subcategory' => 'attachments',
				'title' => 'Allowed attachment max size (in bytes)',
				'desc' => 'Max size in bytes of attachment. Cannot exceed server max, which is: '. ini_get('upload_max_filesize')
							. ' where 1M equals to 1,048,576 bytes.',
                'onlyin' => 'Pro'
			),
			
			// Thread Private Questions
			self::OPTION_PRIVATE_QUESTIONS_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'private_questions',
				'title' => 'Enable private questions',
				'desc' => 'If enabled, each user will be able to send private question to the other user. Question will be send by email, '
						. 'using recipient\'s email address from Wordpress and put sender\'s email in the Reply-To header, '
						. 'so recipient will be able to reply directly to the sender\'s email address, bypassing the Wordpress.',
                'onlyin' => 'Pro'
			),
			self::OPTION_PRIVATE_QUESTION_EMAIL_SUBJECT => array(
				'type' => self::TYPE_STRING,
				'default' => '[[blogname]] Private question: [title]',
				'category' => 'thread',
				'subcategory' => 'private_questions',
				'title' => 'Email subject',
				'desc' => 'Private question will be send by email with this subject.',
                'onlyin' => 'Pro'
			),
			self::OPTION_PRIVATE_QUESTION_EMAIL_TEMPLATE => array(
				'type' => self::TYPE_TEXTAREA,
				'default' => "User [username] has asked a private question to you by website [blogname].\n-----------------------------------\n[question]"
							. "\n-----------------------------------\nIf you want to reply, simply reply to this email.",
				'category' => 'thread',
				'subcategory' => 'private_questions',
				'title' => 'Email template',
				'desc' => 'Private question will be send by email using this template.<br>You can use following tokens: [blogname], [username], [title], [question].',
                'onlyin' => 'Pro'
			),
			
			// Bad words
			self::OPTION_BAD_WORDS_FILTER_ENABLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'bad_words',
				'title' => 'Enable bad words filter',
				'desc' => 'If enabled, the question, answer, comment or tag which includes a bad word won\'t be accepted.',
                'onlyin' => 'Pro'
			),
			self::OPTION_BAD_WORDS_LIST => array(
				'type' => self::TYPE_TEXTAREA,
				'default' => '',
				'category' => 'thread',
				'subcategory' => 'bad_words',
				'title' => 'Bad words list',
				'desc' => 'Separate each bad word by new line. You can use regular expressons (compatible with '
						. '<a href="http://php.net/manual/en/reference.pcre.pattern.syntax.php" target="_blank" title="PHP: PCRE syntax">preg_match()</a> in PHP) '
						. 'by wrapping the expression by slashes,<br>for example: <kbd>/(bad)?words?/</kbd>',
                'onlyin' => 'Pro'
			),
			
			// Moderation
			self::OPTION_QUESTION_AUTO_APPROVE => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'access_control',
				'subcategory' => 'moderation',
				'title' => 'Auto-approve new questions',
				'desc' => 'This option overrides following options. Turning this option ON - turnes OFF the question moderation.',
			),
			self::OPTION_SIMULATE_COMMENT => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'access_control',
				'subcategory' => 'moderation',
				'title' => 'Simulate comment add when question is added',
				'desc' => 'Try to add questions as if they were comments. Tip: Triggers external spam filtering functions for comments (e.g. Akismet).',
                'onlyin' => 'Pro'
			),
			self::OPTION_ANSWER_AUTO_APPROVE => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'access_control',
				'subcategory' => 'moderation',
				'title' => 'Auto-approve answers',
			),
			self::OPTION_COMMENTS_AUTO_APPROVE => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'access_control',
				'subcategory' => 'moderation',
				'title' => 'Auto-approve new comments',
				'desc' => 'If enabled, comments will appear in the thread without moderation. In disabled, admin must approve every comment before it will be visible.',
                'onlyin' => 'Pro'
			),
			self::OPTION_AUTO_APPROVE_AUTHORS => array(
				'type' => self::TYPE_USERS_LIST,
				'default' => array(1),
				'category' => 'access_control',
				'subcategory' => 'moderation',
				'title' => 'Auto-approve content from following users',
                'onlyin' => 'Pro'
			),
			self::OPTION_LIMIT_QUESTIONS_PER_DAY => array(
				'type' => self::TYPE_INT,
				'default' => 0,
				'category' => 'access_control',
				'subcategory' => 'moderation',
				'title' => 'Limit questions per day',
				'desc' => 'How many questions can be posted per day. Enter 0 to disable',
                'onlyin' => 'Pro'
			),
			self::OPTION_LIMIT_QUESTIONS_PER_WEEK => array(
				'type' => self::TYPE_INT,
				'default' => 0,
				'category' => 'access_control',
				'subcategory' => 'moderation',
				'title' => 'Limit questions per week',
				'desc' => 'How many questions can be posted per week (7 days). Enter 0 to disable',
                'onlyin' => 'Pro'
			),
			self::OPTION_LIMIT_QUESTIONS_PER_MONTH => array(
				'type' => self::TYPE_INT,
				'default' => 0,
				'category' => 'access_control',
				'subcategory' => 'moderation',
				'title' => 'Limit questions per month',
				'desc' => 'How many questions can be posted per month (30 days). Enter 0 to disable',
                'onlyin' => 'Pro'
			),
			self::OPTION_LIMIT_ANSWERS_PER_DAY => array(
				'type' => self::TYPE_INT,
				'default' => 0,
				'category' => 'access_control',
				'subcategory' => 'moderation',
				'title' => 'Limit answers per day',
				'desc' => 'How many answers can be posted per day. Enter 0 to disable',
                'onlyin' => 'Pro'
			),
			self::OPTION_LIMIT_ANSWERS_PER_WEEK => array(
				'type' => self::TYPE_INT,
				'default' => 0,
				'category' => 'access_control',
				'subcategory' => 'moderation',
				'title' => 'Limit answers per week',
				'desc' => 'How many answers can be posted per week (7 days). Enter 0 to disable',
                'onlyin' => 'Pro'
			),
			self::OPTION_LIMIT_ANSWERS_PER_MONTH => array(
				'type' => self::TYPE_INT,
				'default' => 0,
				'category' => 'access_control',
				'subcategory' => 'moderation',
				'title' => 'Limit answers per month',
				'desc' => 'How many answers can be posted per month (30 days). Enter 0 to disable',
                'onlyin' => 'Pro'
			),
			
			// Access
			self::OPTION_VIEW_ACCESS => array(
				'type' => self::TYPE_SELECT,
				'options' => array(
					self::ACCESS_EVERYONE => 'Everyone',
					self::ACCESS_USERS => 'Logged in users',
					self::ACCESS_ROLE => 'By role',
				),
				'default' => self::ACCESS_EVERYONE,
				'category' => 'access_control',
				'subcategory' => 'access',
				'title' => 'Who can view questions',
				'desc' => 'Choose who can view questions. Users which have no access won\'t be able to see the question index at all.',
                'onlyin' => 'Pro'
			),
			self::OPTION_VIEW_ACCESS_ROLES => array(
				'type' => self::TYPE_MULTISELECT,
				'options' => array(__CLASS__, 'getRolesOptions'),
				'category' => 'access_control',
				'subcategory' => 'access',
				'title' => 'Which roles can view questions',
				'desc' => 'Works only if chosen "By role" access.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ACCESS_VIEW_ANSWERS => array(
				'type' => self::TYPE_SELECT,
				'options' => array(
					self::ACCESS_EVERYONE => 'Everyone',
					self::ACCESS_USERS => 'Logged in users',
					self::ACCESS_ROLE => 'By role',
					self::ACCESS_AUTHOR => 'Asker + displaying own answers',
				),
				'default' => self::ACCESS_EVERYONE,
				'category' => 'access_control',
				'subcategory' => 'access',
				'title' => 'Who can see answers',
				'desc' => 'Choose who can see the answers on the question thread page.<br>Question author will see all answers always.<br>'
							. 'Answer author will see own answers always.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ACCESS_VIEW_ANSWERS_ROLES => array(
				'type' => self::TYPE_MULTISELECT,
				'options' => array(__CLASS__, 'getRolesOptions'),
				'category' => 'access_control',
				'subcategory' => 'access',
				'title' => 'Which roles can see answers',
				'desc' => 'Works only if chosen "By role" answers view access.',
                'onlyin' => 'Pro'
			),
			self::OPTION_POST_QUESTIONS_ACCESS => array(
				'type' => self::TYPE_SELECT,
				'options' => array(
					self::ACCESS_USERS => 'Logged in users',
					self::ACCESS_ROLE => 'By role',
				),
				'default' => self::ACCESS_USERS,
				'category' => 'access_control',
				'subcategory' => 'access',
				'title' => 'Who can post questions',
			),
			self::OPTION_POST_QUESTIONS_ACCESS_ROLES => array(
				'type' => self::TYPE_MULTISELECT,
				'options' => array(__CLASS__, 'getRolesOptions'),
				'category' => 'access_control',
				'subcategory' => 'access',
				'title' => 'Which roles can post questions',
				'desc' => 'Works only if chosen "By role" access.',
			),
			self::OPTION_POST_ANSWERS_ACCESS => array(
				'type' => self::TYPE_SELECT,
				'options' => array(
					self::ACCESS_USERS => 'Logged in users',
					self::ACCESS_EXPERT => 'Experts',
					self::ACCESS_EXPERT_AUTHOR => 'Experts and question author',
					self::ACCESS_ROLE => 'By role',
				),
				'default' => self::ACCESS_USERS,
				'category' => 'access_control',
				'subcategory' => 'access',
				'title' => 'Who can post answers',
				'desc' => 'If you choose "Experts" and the specified thread has no experts related to his category, '
							. 'then it will work as the "Logged in users" option.',
                'onlyin' => 'Pro'
			),
			self::OPTION_POST_ANSWERS_ACCESS_ROLES => array(
				'type' => self::TYPE_MULTISELECT,
				'options' => array(__CLASS__, 'getRolesOptions'),
				'category' => 'access_control',
				'subcategory' => 'access',
				'title' => 'Which roles can post answers',
				'desc' => 'Works only if chosen "By role" access.',
                'onlyin' => 'Pro'
			),
			self::OPTION_POST_COMMENTS_ACCESS => array(
				'type' => self::TYPE_SELECT,
				'options' => array(
					self::ACCESS_USERS => 'Logged in users',
					self::ACCESS_ROLE => 'By role',
				),
				'default' => self::ACCESS_USERS,
				'category' => 'access_control',
				'subcategory' => 'access',
				'title' => 'Who can post comments',
                'onlyin' => 'Pro'
			),
			self::OPTION_POST_COMMENTS_ACCESS_ROLES => array(
				'type' => self::TYPE_MULTISELECT,
				'options' => array(__CLASS__, 'getRolesOptions'),
				'category' => 'access_control',
				'subcategory' => 'access',
				'title' => 'Which roles can post comments',
				'desc' => 'Works only if chosen "By role" access.',
                'onlyin' => 'Pro'
			),
            self::OPTION_POST_ALL_ACCESS => array(
                'type' => self::TYPE_BOOL,
                'default' => 0,
                'category' => 'access_control',
                'subcategory' => 'access',
                'title' => 'Allow guests make subscription',
                'desc' => 'After make subscription a new user will be created. Credentials will be sent to the new user.',
                'onlyin' => 'Pro'
            ),
			self::OPTION_ALLOW_FULL_HTML_ROLES => array(
				'type' => self::TYPE_MULTISELECT,
				'options' => array(__CLASS__, 'getRolesOptions'),
				'category' => 'access_control',
				'subcategory' => 'other',
				'title' => 'Which roles can post content with full HTML support',
				'desc' => 'Other role\'s posts will be filtered from HTML tags containing URLs, scripts and unsupported tags.',
                'onlyin' => 'Pro'
			),
			
			// Notifications
			self::OPTION_POST_ADMIN_NOTIFICATION_EMAIL => array(
				'type' => self::TYPE_CSV_LINE,
				'default' => '',
				'category' => 'notifications',
				'subcategory' => 'notifications',
				'title' => 'Email address for the admin notifications',
				'desc' => 'Separate e-mail addresses by commas or leave empty to disable.',
                'onlyin' => 'Pro'
			),
            self::OPTION_NEW_QUESTION_ADMIN_NOTIFICATION_CONTENT => array(
                'type' => self::TYPE_TEXTAREA,
                'default' => "A new question has been asked and is waiting for your approval [question_link]\n
Author: [author]\n
E-mail: [email]\n
Title: [question_title]\n
Content:\n
[question_content]\n\n
Approve it: [approve_link]\n
Trash it: [trash_link]\n
Please visit the questions moderation panel:\n
[pending_link]",
                'category' => 'notifications',
                'subcategory' => 'notifications',
                'title' => 'New question admin moderation notification content',
                'desc' => "Admin will receive a notification email with this content.<br><br>"
                    . "[author] - Author of the question<br>"
                    . "[email] - Author email<br>"
                    . "[question_title] - Title of the question<br>"
                    . "[question_content] - Content of the question<br>"
                    . "[question_link] - Link to the new question<br>"
                    . "[approve_link] - Link to approve new question<br>"
                    . "[trash_link] - Link to trash new question<br>"
                    . "[pending_link] - Link to the questions moderation panel<br>",
            ),
            self::OPTION_NEW_ANSWER_ADMIN_NOTIFICATION_CONTENT => array(
                'type' => self::TYPE_TEXTAREA,
                'default' => "A new comment on the post [question_title] is waiting for your approval [answer_link]\n\n"
                    . "Author: [author]\nEmail: [email]\nComment: \n[answer_content]\n\n\nApprove it: [approve_link]\n"
                    . "Trash it: [trash_link]\nSpam it: [spam_link]\nPlease visit the moderation panel:\n[pending_link]",
                'category' => 'notifications',
                'subcategory' => 'notifications',
                'title' => 'New answer admin moderation notification content',
                'desc' => "Admin will receive a notification email with this content.<br><br>"
                    . "[author] - Author of the question<br>"
                    . "[email] - Author email<br>"
                    . "[question_title] - Title of the question<br>"
                    . "[answer_link] - Link to the new answer<br>"
                    . "[answer_content] - Content of the answer<br>"
                    . "[approve_link] - Link to approve new question<br>"
                    . "[trash_link] - Link to trash new question<br>"
                    . "[spam_link] - Link to mark new answer as spam<br>"
                    . "[pending_link] - Link to the answers moderation panel<br>",
            ),
			self::OPTION_EMAIL_USE_HTML => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'notifications',
				'subcategory' => 'notifications',
				'title' => 'Use HTML content type',
				'desc' => 'If enabled, the email will be send wil the Content-type: text/html',
                'onlyin' => 'Pro'
			),
			self::OPTION_EMAIL_HTML_NL2BR => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'notifications',
				'subcategory' => 'notifications',
				'title' => 'Replace new lines with the &lt;br&gt; tags',
				'desc' => 'If using HTML emails, new lines in the email template will be replaced with the &lt;br&gt; tag as in the Wordpress posts.',
                'onlyin' => 'Pro'
			),
			self::OPTION_NEW_QUESTION_EVERYBODY_FOLLOW_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'notifications',
				'subcategory' => 'notifications',
				'title' => 'Add all users as new thread followers',
				'desc' => 'When posting new question, mark all users as thread followers. '
						. 'Until user won\'t unfollow the thread he will receive notifications about new answers.',
                'onlyin' => 'Pro'
			),
			self::OPTION_NEW_QUESTION_ADMIN_NOTIFICATION_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'notifications',
				'subcategory' => 'question',
				'title' => 'Enable notification for admin',
				'desc' => 'If enabled, the notification about new question will be send to the email addresses defined above.',
                'onlyin' => 'Pro'
			),
			self::OPTION_NEW_QUESTION_EXPERT_NOTIFICATION_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'notifications',
				'subcategory' => 'question',
				'title' => 'Enable notification for experts',
				'desc' => 'If enabled, experts will be notified about new questions in their categories. You can define experts per each category.',
                'onlyin' => 'Pro'
			),
			self::OPTION_NEW_QUESTION_WHICH_EXPERTS_NOTIFIED => array(
                'type' => self::TYPE_SELECT,
                'options' => array(
                    0 => 'Notify all experts in category',
                    1 => 'Notify only assigned expert',
                ),
                'default' => 0,
                'category' => 'notifications',
                'subcategory' => 'question',
                'title' => 'Which experts should be notified',
                'desc' => 'If you choose "Notify all experts in category" then all experts will be notified about new questions in their categories.'
                    .' If "Notify only assigned expert" is chosen only the selected expert will be notified. If the expert was not selected then all experts in the category will get a notification ',
                'onlyin' => 'Pro'
            ),
			self::OPTION_NEW_QUESTION_NOTIFY_EVERYBODY_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'notifications',
				'subcategory' => 'question',
				'title' => 'Notify all users',
				'desc' => 'Send notification email to all users after a new question will be posted.<br>'
						. '<strong>Warning: all Wordpress users will receive an email.</strong>',
                'onlyin' => 'Pro'
			),
			self::OPTION_NEW_QUESTION_NOTIFY_AUTHOR_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'notifications',
				'subcategory' => 'question',
				'title' => 'Notify question author',
				'desc' => 'Send a notification email to the author of the question about processing the question.',
                'onlyin' => 'Pro'
			),
            self::OPTION_NEW_QUESTION_NOTIFY_AUTHOR_TITLE => array(
                'type' => self::TYPE_STRING,
                'default' => "[[blogname]] Your question have been received",
                'category' => 'notifications',
                'subcategory' => 'question',
                'title' => 'Subject of the notification email for author',
                'desc' => 'Author of  the question will receive a notification email with this subject.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_NEW_QUESTION_NOTIFY_AUTHOR_CONTENT => array(
                'type' => self::TYPE_TEXTAREA,
                'default' => "Hi [author],\nWe have received your question:\nTitle: [question_title]\nContent: [question_body]\n\n"
                    . "We will reply as soon as possible.",
                'category' => 'notifications',
                'subcategory' => 'question',
                'title' => 'Content of the notification email for author',
                'desc' => "Author of the question will receive a notification email with this content.<br><br>"
                    . "[blogname] - Name of the site<br>"
                    . "[author] - Author of the question<br>"
                    . "[question_title] - Title of the question<br>"
                    . "[question_body] - Body of the question<br>"
                    . "[question_status] - Approval status of the question (pending, approved)<br>"
                    . "[question_link] - URL address of the new question",
                'onlyin' => 'Pro'
            ),
            self::OPTION_REMINDER_NOTIFY_AUTHOR_ENABLED => array(
                'type' => self::TYPE_BOOL,
                'default' => 0,
                'category' => 'notifications',
                'subcategory' => 'question',
                'title' => 'Enable reminder by email',
                'desc' => 'If enabled, a reminder notification email will be send to the author of the question.<br>'
                    . '<strong>Warning: this option works only if the WP_CRON is enabled.</strong>',
                'onlyin' => 'Pro'
            ),
            self::OPTION_REMINDER_NOTIFY_AUTHOR_TIME => array(
                'type' => self::TYPE_INT,
                'default' => 7,
                'category' => 'notifications',
                'subcategory' => 'question',
                'title' => 'Reminder email time',
                'desc' => 'Select the number of days after which you want to send a reminder.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_REMINDER_NOTIFY_AUTHOR_TITLE => array(
                'type' => self::TYPE_STRING,
                'default' => "[[blogname]] Please confirm is your question answered",
                'category' => 'notifications',
                'subcategory' => 'question',
                'title' => 'Reminder email subject',
                'desc' => 'Author of the question will receive a reminder notification email with this subject.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_REMINDER_NOTIFY_AUTHOR_CONTENT => array(
                'type' => self::TYPE_TEXTAREA,
                'default' => "Hi [author],\nPlease confirm if your question is answered.",
                'category' => 'notifications',
                'subcategory' => 'question',
                'title' => 'Reminder email content',
                'desc' => "Author of the question will receive a reminder notification email with this content.<br><br>"
                    . "[blogname] - Name of the site<br>"
                    . "[author] - Author of the question<br>"
                    . "[question_title] - Title of the question<br>"
                    . "[question_body] - Body of the question<br>"
                    . "[question_link] - URL address of the new question",
                'onlyin' => 'Pro'
            ),
			self::OPTION_NEW_QUESTION_NOTIFY_EVERYBODY_OPTINOUT => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'notifications',
				'subcategory' => 'question',
				'title' => 'Allow users to opt-in and opt-out to follow all new questions',
				'desc' => 'User will be able to opt-in the new questions newsletter by clicking the button visible on the CMA pages. '
						. 'The opt-out link will be added to the footer of the email message.',
                'onlyin' => 'Pro'
			),
            self::OPTION_NEW_QUESTION_NOTIFICATION => array(
                'type' => self::TYPE_CSV_LINE,
                'default' => '',
                'category' => 'notifications',
                'subcategory' => 'question',
                'title' => 'Notify about new questions',
                'desc' => 'Separate e-mail addresses by commas or leave empty to disable.',
            ),
			self::OPTION_NEW_QUESTION_NOTIFICATION_TITLE => array(
				'type' => self::TYPE_STRING,
				'default' => "[[blogname]] A new question has been asked by [author]",
				'category' => 'notifications',
				'subcategory' => 'question',
				'title' => 'Subject of the notification email',
				'desc' => 'Category subscribers and admin will receive a notification email with this subject.',
			),
			self::OPTION_NEW_QUESTION_NOTIFICATION_CONTENT => array(
				'type' => self::TYPE_TEXTAREA,
				'default' => "Hi, a new question has been asked by [author]:\nTitle: [question_title]\n\n"
					. "Click to see: [question_link]",
				'category' => 'notifications',
				'subcategory' => 'question',
				'title' => 'Content of the notification email',
				'desc' => "Category subscribers and admin will receive a notification email with this content.<br><br>"
							. "[blogname] - Name of the site<br>"
							. "[author] - Author of the question<br>"
							. "[question_title] - Title of the question<br>"
							. "[question_status] - Approval status of the question (pending, approved)<br>"
							. "[question_link] - URL address of the new question<br>",
			),
			self::OPTION_NEW_ANSWER_ADMIN_NOTIFICATION_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'notifications',
				'subcategory' => 'answer',
				'title' => 'Enable notification for admin',
                'onlyin' => 'Pro'
			),
			self::OPTION_NEW_ANSWER_NOTIFY_EVERYBODY_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'notifications',
				'subcategory' => 'answer',
				'title' => 'Notify all users',
				'desc' => 'Send notification email to all users after a new answer will be posted.<br>'
						. '<strong>Warning: all Wordpress users will receive an email.</strong>',
                'onlyin' => 'Pro'
			),
			self::OPTION_NEW_ANSWER_EXPERT_NOTIFICATION_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'notifications',
				'subcategory' => 'answer',
				'title' => 'Notify experts',
				'desc' => 'Send notification email to experts after a new answer will be posted.<br>',
                'onlyin' => 'Pro'
			),
			self::OPTION_NEW_ANSWER_NOTIFY_AUTHOR_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'notifications',
				'subcategory' => 'answer',
				'title' => 'Notify question author',
				'desc' => 'Send notification email to question author after a new answer will be posted.<br>',
                'onlyin' => 'Pro'
			),
			self::OPTION_THREAD_NOTIFICATION_TITLE => array(
				'type' => self::TYPE_STRING,
				'default' => "[[blogname]] Someone has posted a new answer on the topic you subscribed to",
				'category' => 'notifications',
				'subcategory' => 'answer',
				'title' => 'Subject of the notification email',
				'desc' => 'Subscribers and admin will receive a notification email with this subject.<br>'
							. '(Subscribers are users who have checked the "Notify me of follow" option or following the question thread or whole category.)',
			),
			self::OPTION_THREAD_NOTIFICATION => array(
				'type' => self::TYPE_TEXTAREA,
				'default' => "Someone has posted a new answer on the topic you subscribed to\n\nTopic: [question_title]\nClick to see: [comment_link]",
				'category' => 'notifications',
				'subcategory' => 'answer',
				'title' => 'Content of the notification email',
				'desc' => "Subscribers and admin will receive a notification email with this content.<br><br>"
							. "You can use the following shortcodes:<br>"
							. "[blogname] - Name of the site<br>"
							. "[question_title] - Title of the question<br>"
							. "[comment_link] - Link to the new answer<br>"
			),
            self::OPTION_THREAD_NOTIFICATION_EXPERT_TITLE => array(
                'type' => self::TYPE_STRING,
                'default' => "[[blogname]] Someone has posted a new answer on the topic you are expert in",
                'category' => 'notifications',
                'subcategory' => 'answer',
                'title' => 'Subject of the notification email for experts',
                'desc' => 'Experts will receive a notification email with this subject.<br>',
                'onlyin' => 'Pro'
            ),
            self::OPTION_THREAD_NOTIFICATION_EXPERT => array(
                'type' => self::TYPE_TEXTAREA,
                'default' => "Someone has posted a new answer on the topic you are expert in\n\nTopic: [question_title]\nClick to see: [comment_link]",
                'category' => 'notifications',
                'subcategory' => 'answer',
                'title' => 'Content of the notification email for experts',
                'desc' => "Experts will receive a notification email with this content.<br><br>"
                    . "You can use the following shortcodes:<br>"
                    . "[blogname] - Name of the site<br>"
                    . "[question_title] - Title of the question<br>"
                    . "[question_body] - Body of the question<br>"
                    . "[comment_link] - Link to the new answer<br>"
                    . "[question_author] - Name of the question author<br>"
                    . "[author] - Name of the answer author<br>"
                    . "[ip] - Author IP address<br>"
                    . "[answer] - Answer body<br>"
                    . "[opt_out_url] - URL address of the opt-out page",
                'onlyin' => 'Pro'
            ),

            self::OPTION_THREAD_NOTIFICATION_AUTHOR_TITLE => array(
                'type' => self::TYPE_STRING,
                'default' => "[[blogname]] Someone has posted a new answer on the topic you created",
                'category' => 'notifications',
                'subcategory' => 'answer',
                'title' => 'Subject of the notification email for author',
                'desc' => 'Author will receive a notification email with this subject.<br>',
                'onlyin' => 'Pro'
            ),
            self::OPTION_THREAD_NOTIFICATION_AUTHOR => array(
                'type' => self::TYPE_TEXTAREA,
                'default' => "Someone has posted a new answer on the topic you created\n\nTopic: [question_title]\nClick to see: [comment_link]",
                'category' => 'notifications',
                'subcategory' => 'answer',
                'title' => 'Content of the notification email for author',
                'desc' => "Author will receive a notification email with this content.<br><br>"
                    . "You can use the following shortcodes:<br>"
                    . "[blogname] - Name of the site<br>"
                    . "[question_title] - Title of the question<br>"
                    . "[question_body] - Body of the question<br>"
                    . "[comment_link] - Link to the new answer<br>"
                    . "[question_author] - Name of the question author<br>"
                    . "[author] - Name of the answer author<br>"
                    . "[ip] - Author IP address<br>"
                    . "[answer] - Answer body<br>"
                    . "[opt_out_url] - URL address of the opt-out page",
                'onlyin' => 'Pro'
            ),
			self::OPTION_NEW_COMMENT_NOTIFICATION_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'notifications',
				'subcategory' => 'comment',
				'title' => 'Enable notification for subscribers',
				'desc' => 'Subscribers are users who have checked the "Notify me of follow" option or following the question thread/whole category.',
                'onlyin' => 'Pro'
			),
			self::OPTION_NEW_COMMENT_ADMIN_NOTIFICATION_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'notifications',
				'subcategory' => 'comment',
				'title' => 'Enable notification for admin',
                'onlyin' => 'Pro'
			),
			self::OPTION_NEW_COMMENT_NOTIFICATION_TITLE => array(
				'type' => self::TYPE_STRING,
				'default' => "[[blogname]] Someone has posted a new comment on the topic you subscribed to",
				'category' => 'notifications',
				'subcategory' => 'comment',
				'title' => 'Subject of the notification email',
				'desc' => 'Subscribers and admin will receive a notification email with this subject.',
                'onlyin' => 'Pro'
			),
			self::OPTION_NEW_COMMENT_NOTIFICATION_CONTENT => array(
				'type' => self::TYPE_TEXTAREA,
				'default' => "Someone has posted a new comment on the topic you subscribed to\n\nTopic: [question_title]\nClick to see: [comment_link]",
				'category' => 'notifications',
				'subcategory' => 'comment',
				'title' => 'Content of the notification email',
				'desc' => "Subscribers and admin will receive a notification email with this content.<br><br>"
							. "You can use the following shortcodes:<br>"
							. "[blogname] - Name of the site<br>"
							. "[question_title] - Title of the question<br>"
							. "[question_body] - Body of the question<br>"
							. "[comment_link] - Link to the new comment<br>"
							. "[author] - Author name<br>"
							. "[comment] - Comment body<br>"
							. "[opt_out_url] - URL address of the opt-out page",
                'onlyin' => 'Pro'
			),
			self::OPTION_NOTIF_BEST_ANSWER_RECEIVERS => array(
				'type' => self::TYPE_MULTICHECKBOX,
				'options' => array(
					self::NOTIF_ANSWER_AUTHOR => 'Answer\'s author',
					self::NOTIF_QUESTION_AUTHOR => 'Question\'s author',
					self::NOTIF_FOLLOWERS => 'Thread followers',
					self::NOTIF_CONTRIBUTORS => 'All thread contributors',
				),
				'category' => 'notifications',
				'subcategory' => 'best_answer',
				'title' => 'Best answer notification receivers',
                'onlyin' => 'Pro'
			),
			self::OPTION_NOTIF_BEST_ANSWER_TITLE => array(
				'type' => self::TYPE_STRING,
				'default' => "[[blogname]] Best answer in: [question_title]",
				'category' => 'notifications',
				'subcategory' => 'best_answer',
				'title' => 'Subject of the notification email',
				'desc' => 'Users will receive a notification email with this subject.',
                'onlyin' => 'Pro'
			),
			self::OPTION_NOTIF_BEST_ANSWER_CONTENT => array(
				'type' => self::TYPE_TEXTAREA,
				'default' => "The best answer has been chosen.\n\nTopic: [question_title]\nLink: [answer_link]\n\nAnswer by [answer_author]:\n[answer]",
				'category' => 'notifications',
				'subcategory' => 'best_answer',
				'title' => 'Content of the notification email',
				'desc' => "Subscribers and admin will receive a notification email with this content.<br><br>"
				. "You can use the following shortcodes:<br>"
				. "[blogname] - Name of the site<br>"
				. "[question_title] - Title of the question<br>"
				. "[question_body] - Body of the question<br>"
				. "[question_author] - Answer author name<br>"
				. "[answer_link] - Link to the new comment<br>"
				. "[answer_author] - Answer author name<br>"
				. "[answer] - Answer content<br>",
                'onlyin' => 'Pro'
			),
			self::OPTION_NOTIF_CONTENT_REJECTED_ENABLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'notifications',
				'subcategory' => 'rejected',
				'title' => 'Enable email notifications for the rejected content',
				'desc' => 'If enabled the users will receive a notification email after moderator reject a question, answer or comment.',
                'onlyin' => 'Pro'
			),
			self::OPTION_NOTIF_CONTENT_REJECTED_SUBJECT => array(
				'type' => self::TYPE_STRING,
				'default' => "[[blogname]] Your [type] has been rejected by moderator",
				'category' => 'notifications',
				'subcategory' => 'rejected',
				'title' => 'Email subject for the rejected content notification',
				'desc' => 'Users will receive a notification email with this subject after moderator reject a question, answer or comment.',
                'onlyin' => 'Pro'
			),
			self::OPTION_NOTIF_CONTENT_REJECTED_TEMPLATE => array(
				'type' => self::TYPE_TEXTAREA,
				'default' => "Moderator rejected your [type].\n\nTopic: [question_title]\nPosted: [date]\n\nYour content: [fragment]",
				'category' => 'notifications',
				'subcategory' => 'rejected',
				'title' => 'Email template for the rejected content notification',
				'desc' => "Users will receive a notification email with this template after moderator reject a question, answer or comment."
					. "<br><br>You can use the following shortcodes:<br>"
					. "[blogname] - Name of the site<br>"
					. "[type] - type of the rejected content: question, answer or comment<br>"
					. "[question_title] - title of the question or the question of the answer or comment it has been posted to<br>"
					. "[content] - rejected content<br>"
					. "[fragment] - first 100 characters of the rejected content<br>"
					. "[date] - date posted<br>",
                'onlyin' => 'Pro'
			),
			
			self::OPTION_DEBUG_EMAIL => array(
				'type' => self::TYPE_CUSTOM,
				'category' => 'notifications',
				'subcategory' => 'other',
				'title' => 'Test sending emails',
				'desc' => 'Use this feature if you don\'t receive the email from the plugin to test if your Wordpress is sending emails properly.',
				'content' => function() {
					$nonce = wp_create_nonce('cma_debug_email');
					return '<div class="cma-debug-email" data-nonce="'. $nonce.'">
						<input type="email" disabled value="'. esc_attr(get_bloginfo('admin_email')) .'" placeholder="Enter email address"> <input type="button" disabled value="Test" style="cursor:default;" />
					</div>';
				},
                'onlyin' => 'Pro'
			),
			self::OPTION_ENABLE_THREAD_FOLLOWING => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'notifications',
				'subcategory' => 'other',
				'title' => 'Enable thread following',
				'desc' => 'If disabled, the "Notify me of follow" and the "Follow" options will be not available '
							. 'and the notifications about new answers and comments won\'t be send.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ENABLE_THREAD_FOLLOWING_PERIOD => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'notifications',
				'subcategory' => 'other',
				'title' => 'Enable thread following period',
				'desc' => 'If enabled, then user able to select notification period such as Immediately, Within 4 hours, Monthly etc.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ENABLE_CATEGORY_FOLLOWING => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'notifications',
				'subcategory' => 'other',
				'title' => 'Enable category following',
				'desc' => 'Category following allow users to receive notifications about all new threads added to the category and its subcategories.',
                'onlyin' => 'Pro'
			),
			self::OPTION_EMAIL_TO_HEADER_WHEN_BCC => array(
				'type' => self::TYPE_STRING,
				'default' => '',
				'category' => 'notifications',
				'subcategory' => 'other',
				'title' => 'Default email recipient when using BCC',
				'desc' => 'Some email servers do not accept the empty "To" header when sending the email to undisclosed recipients by BCC. '
				. 'You can define here the email address that will be the main receiver of that kind of emails, but your user\'s addressess '
				. 'will be still undisclosed.',
                'onlyin' => 'Pro'
			),
            self::OPTION_ENABLE_SENDING_NOTIFICATIONS_USING_CRON => array(
                'type' => self::TYPE_BOOL,
                'default' => 1,
                'category' => 'notifications',
                'subcategory' => 'other',
                'title' => 'Enable sending email notifications using CRON',
                'desc' => 'If disabled, notifications will be send while posting new content, instead of sending by using cron.',
                'onlyin' => 'Pro'
            ),
			
			// MicroPayments
			self::OPTION_MP_POST_QUESTION_ACTION => array(
				'type' => self::TYPE_RADIO,
				'options' => [''],
				'default' => '',
				'category' => 'micropayments',
				'subcategory' => 'general',
				'title' => 'Action on question post',
				'desc' => 'Choose what action to do when user posted a question.',
                'onlyin' => 'Pro'
			),
			self::OPTION_MP_POST_QUESTION_POINTS => array(
				'type' => self::TYPE_INT,
				'category' => 'micropayments',
				'subcategory' => 'general',
				'title' => 'Number of points to grant/charge on question post',
                'onlyin' => 'Pro'
			),
			self::OPTION_MP_POST_ANSWER_ACTION => array(
				'type' => self::TYPE_RADIO,
				'options' => [''],
				'default' => '',
				'category' => 'micropayments',
				'subcategory' => 'general',
				'title' => 'Action on answer post',
				'desc' => 'Choose what action to do when user posted an answer.',
                'onlyin' => 'Pro'
			),
			self::OPTION_MP_POST_ANSWER_POINTS => array(
				'type' => self::TYPE_INT,
				'category' => 'micropayments',
				'subcategory' => 'general',
				'title' => 'Number of points to grant/charge on answer post',
                'onlyin' => 'Pro'
			),
			self::OPTION_MP_POST_VIEW_ANSWER_ACTION => array(
				'type' => self::TYPE_RADIO,
				'options' => [''],
				'default' => '',
				'category' => 'micropayments',
				'subcategory' => 'general',
				'title' => 'Action on view answer post',
				'desc' => 'Choose what action to do when user view an answer.',
                'onlyin' => 'Pro'
			),
			self::OPTION_MP_POST_VIEW_ANSWER_POINTS => array(
				'type' => self::TYPE_DECIMAL,
				'category' => 'micropayments',
				'subcategory' => 'general',
				'title' => 'Number of points to charge on view answer post',
                'onlyin' => 'Pro'
			),
			self::OPTION_MP_REWARD_BEST_ANSWER_ENABLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'micropayments',
				'subcategory' => 'general',
				'title' => 'Let question author grant points to poster of the best answer',
				'desc' => 'When creating a question, the author will be able to set an amount of MicroPayments points to be given to the poster of the best answer.',
                'onlyin' => 'Pro'
			),
			self::OPTION_MP_WHEN_CHARGE_REWARD_FROM_AUTHOR => array(
				'type' => self::TYPE_RADIO,
				'options' => array(
					self::MP_BADGES_QUESTION_POST => 'posted',
					self::MP_BADGES_QUESTION_RESOLVED => 'resolved',
				),
				'default' => self::MP_BADGES_QUESTION_POST,
				'category' => 'micropayments',
				'subcategory' => 'general',
				'title' => 'Charge author when question is',
				'desc' => 'The question author will effectively spend points when they mark an answer as the best one.',
                'onlyin' => 'Pro'
			),
			self::OPTION_MP_REWARD_BEST_ANSWER_BY_USER_ENABLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'micropayments',
				'subcategory' => 'general',
				'title' => 'Enable user to set points manually for the best answer',
				'desc' => 'Grant points to the best answer when the author mark question as resolved.',
                'onlyin' => 'Pro'
			),
			self::OPTION_MP_REWARD_BEST_ANSWER_MINIMUM => array(
				'type' => self::TYPE_INT,
				'default' => 0,
				'category' => 'micropayments',
				'subcategory' => 'general',
				'class' => 'cm-minimal-amount-of-points',
				'title' => 'Minimal amount of points to set manually',
				'desc' => 'Minimal amount of points for the best answer that the user can set manually in front-end.',
                'onlyin' => 'Pro'
			),
			self::OPTION_MP_REWARD_BEST_ANSWER_POINTS => array(
				'type' => self::TYPE_INT,
				'default' => 3,
				'category' => 'micropayments',
				'subcategory' => 'general',
				'title' => 'Best answer reward amount of points',
				'desc' => 'If "set points manually for the best answer" option is disabled, then grant this amount of points to the best answer author.',
                'onlyin' => 'Pro'
			),
			
			// Micropayments Badges
			self::OPTION_MP_BADGES_MODE => array(
				'type' => self::TYPE_RADIO,
				'options' => array(
					self::MP_BADGES_MODE_DISABLED => 'disabled',
					self::MP_BADGES_MODE_DEFINITIVE => 'definitive',
					self::MP_BADGES_MODE_ACCUMULATIVE => 'accumulative',
				),
				'default' => self::MP_BADGES_MODE_DISABLED,
				'category' => 'micropayments',
				'subcategory' => 'badges',
				'title' => 'Badges mode',
				'desc' => 'Set the badges mode.<br>Definitive mode will display only badge from the user\'s current points interval.<br>'
						. 'Accumulative mode will display all previous badges as well.',
                'onlyin' => 'Pro'
			),
			self::OPTION_MP_BADGES_LIST => array(
				'type' => self::TYPE_CUSTOM,
				'content' => array('CMA_MicroPaymentsBadges', 'settingsList'),
				'category' => 'micropayments',
				'subcategory' => 'badges',
				'title' => 'Badges list',
				'desc' => '',
                'onlyin' => 'Pro'
			),
			
			// Ads Index
			self::OPTION_ADV_QUESTIONS_TABLE_BEFORE => array(
				'type' => self::TYPE_TEXTAREA,
				'category' => 'ads',
				'subcategory' => 'index',
				'title' => 'Before questions table',
				'desc' => 'Enter the AdSense JavaScript code, a Wordpress shortcode or any HTML source.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ADV_QUESTIONS_TABLE_AFTER => array(
				'type' => self::TYPE_TEXTAREA,
				'category' => 'ads',
				'subcategory' => 'index',
				'title' => 'After questions table',
				'desc' => 'Enter the AdSense JavaScript code, a Wordpress shortcode or any HTML source.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ADV_THREAD_BEFORE => array(
				'type' => self::TYPE_TEXTAREA,
				'category' => 'ads',
				'subcategory' => 'thread',
				'title' => 'Before question',
				'desc' => 'Enter the AdSense JavaScript code, a Wordpress shortcode or any HTML source.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ADV_THREAD_ANSWERS_BEFORE => array(
				'type' => self::TYPE_TEXTAREA,
				'category' => 'ads',
				'subcategory' => 'thread',
				'title' => 'Between question and answers',
				'desc' => 'Enter the AdSense JavaScript code, a Wordpress shortcode or any HTML source.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ADV_THREAD_ANSWERS_AFTER => array(
				'type' => self::TYPE_TEXTAREA,
				'category' => 'ads',
				'subcategory' => 'thread',
				'title' => 'Between answers and the answer form',
				'desc' => 'Enter the AdSense JavaScript code, a Wordpress shortcode or any HTML source.',
                'onlyin' => 'Pro'
			),
			self::OPTION_ADV_THREAD_ANSWERS_FORM_AFTER => array(
				'type' => self::TYPE_TEXTAREA,
				'category' => 'ads',
				'subcategory' => 'thread',
				'title' => 'After the answer form',
				'desc' => 'Enter the AdSense JavaScript code, a Wordpress shortcode or any HTML source.',
                'onlyin' => 'Pro'
			),
			self::OPTION_HIDE_LOGIN_FORM => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'anonymous',
				'subcategory' => 'general',
				'title' => 'Hide login form',
				'desc' => 'Removes the "Login to post a question" from the forum front-end. Useful if the forum is intended for unregistered users only.',
                'onlyin' => 'Pro'
			),
			
			self::OPTION_DISCLAIMER_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'general',
				'subcategory' => 'disclaimer',
				'title' => 'Show disclaimer for first time users',
				'desc' => 'In case you want disclaimer to appear for new user you need to select yes.',
                'onlyin' => 'Pro'
			),
            self::OPTION_DISCLAIMER_AFTER_SUBMIT => array(
                'type' => self::TYPE_BOOL,
                'default' => 0,
                'category' => 'general',
                'subcategory' => 'disclaimer',
                'title' => 'Show disclaimer when user submits a question',
                'desc' => 'The disclaimer will appear after user click "Add Question" button',
                'onlyin' => 'Pro'
            ),
			self::OPTION_DISCLAIMER_CONTENT => array(
				'type' => self::TYPE_TEXTAREA,
				'default' => 'Enter here your disclaimer text',
				'category' => 'general',
				'subcategory' => 'disclaimer',
				'title' => 'Disclaimer text',
				'desc' => 'Please describe in details the message which will appear in the disclaimer.',
                'onlyin' => 'Pro'
			),

            //Chat GPT API
            self::OPTION_GPT_ENABLED => array(
                'type' => self::TYPE_BOOL,
                'default' => false,
                'category' => 'general',
                'subcategory' => 'chat_gpt',
                'title' => 'Enable Chat_GPT',
                'desc' => 'Enabling Chat_GPT API.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GPT_API_KEY => array(
                'type' => self::TYPE_STRING,
                'default' => '',
                'category' => 'general',
                'subcategory' => 'chat_gpt',
                'title' => 'Chat GPT API Key',
                'desc' => 'API key from here <a href="https://platform.openai.com/account/api-keys" target="_blank">https://platform.openai.com/account/api-keys</a>',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GPT_CATEGORY => array(
                'type' => self::TYPE_MULTISELECT,
                'default' => '',
                'category' => 'general',
                'subcategory' => 'chat_gpt',
                'options' => [''],
                'title' => 'Category answered by Chat GPT',
                'desc' => 'Choose a category for which questions  will be answered by Chat GPT.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GPT_USER_DISPLAY_NAME => array(
                'type' => self::TYPE_STRING,
                'default' => 'Chat GPT',
                'category' => 'general',
                'subcategory' => 'chat_gpt',
                'title' => 'Chat GPT user display name',
                'desc' => 'Add display name for Chat GPT.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GPT_PROMPT_TEMPLATE => array(
                'type' => self::TYPE_STRING,
                'default' => '{question_title} {question_body}',
                'category' => 'general',
                'subcategory' => 'chat_gpt',
                'title' => 'Chat GPT Prompt Template',
                'desc' => 'Template for the prompt that\'s sent to Chat GPT server.
						<strong>It must contain: {question_title} or {question_body}</strong> which is a placeholder for the dynamic part.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GPT_MODEL => array(
                'type' => self::TYPE_SELECT,
                'default' => 'gpt-3.5-turbo',
                'category' => 'general',
                'subcategory' => 'chat_gpt',
                'options'   => ['gpt-3.5-turbo' => 'gpt-3.5-turbo'],
                'title' => 'Chat GPT Model',
                'desc' => 'Select the model for the API calls. <strong>Warning: GPT-4 may not be avaialable for you. 
                        Currently it is in limited beta stage and requires joining the waitlist on the OpenAI page.</strong>',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GPT_SYSTEM_ROLE => array(
                'type' => self::TYPE_TEXTAREA,
                'default' => 'You are a helpful assistant.',
                'category' => 'general',
                'subcategory' => 'chat_gpt',
                'title' => 'Chat GPT AI Role',
                'desc' => 'Define the role that the ChatGPT AI should assume. This can have a huge impact on the responses.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GPT_FILTER_LINK => array(
                'type' => self::TYPE_STRING,
                'default' => '',
                'category' => 'general',
                'subcategory' => 'chat_gpt',
                'title' => 'Custom link for Chat GPT',
                'desc' => 'Changing custom link for chat GPT. Leave it empty, for default value',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GPT_REPLY_LENGTH => array(
                'type' => self::TYPE_DECIMAL,
                'default' => 1500,
                'decimalConfig' => [
                    'min'  => 0,
                    'max' => 4000,
                    'step' => 1 ],
                'category' => 'general',
                'subcategory' => 'chat_gpt',
                'title' => 'Chat GPT Reply Length',
                'desc' => 'Set the maximum length of the reply from the chat. Maximum is 4000. <strong>Warning: longer replies use more
							tokens, so you can reach limit faster.</strong>',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GPT_TEMPERATURE => array(
                'type' => self::TYPE_DECIMAL,
                'default' => 0.5,
                'decimalConfig' => [
                    'min'  => 0,
                    'max' => 2,
                    'step' => 0.1 ],
                'category' => 'general',
                'subcategory' => 'chat_gpt',
                'title' => 'Chat GPT Temperature',
                'desc' => 'Ranges from 0 to 2. Higher values like 0.8 will make the output more random, while lower values
+						like 0.2 will make it more focused and deterministic.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GPT_ANSWER_VIA_CRON => array(
                'type' => self::TYPE_BOOL,
                'default' => true,
                'category' => 'general',
                'subcategory' => 'chat_gpt',
                'title' => 'Request Chat_GPT answer via CRON',
                'desc' => 'If enabled, a response from ChatGPT will be requested via CRON instead of when the question is posted.',
                'onlyin' => 'Pro'
            ),

            //Gemini API
            self::OPTION_GEMINI_ENABLED => array(
                'type' => self::TYPE_BOOL,
                'default' => false,
                'category' => 'general',
                'subcategory' => 'gemini',
                'title' => 'Enable Gemini',
                'desc' => 'Enabling Gemini API.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GEMINI_API_KEY => array(
                'type' => self::TYPE_STRING,
                'default' => '',
                'category' => 'general',
                'subcategory' => 'gemini',
                'title' => 'Gemini API Key',
                'desc' => 'API key from here <a href="https://aistudio.google.com/app/apikey" target="_blank">https://aistudio.google.com/app/apikey</a>',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GEMINI_MODEL => array(
                'type' => self::TYPE_SELECT,
                'default' => 'gemini-pro',
                'category' => 'general',
                'subcategory' => 'gemini',
                'options'   => ['gemini-pro' => 'Gemini Pro','gemini-1.5-pro-latest' => 'Gemini 1.5 Pro'],
                'title' => 'Gemini Model',
                'desc' => 'Select the Gemini Model to use for generating the completion.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GEMINI_CATEGORY => array(
                'type' => self::TYPE_MULTISELECT,
                'default' => '',
                'category' => 'general',
                'subcategory' => 'gemini',
                'options' => [''],
                'title' => 'Category answered by Gemini',
                'desc' => 'Choose a category for which questions  will be answered by Gemini.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GEMINI_USER_DISPLAY_NAME => array(
                'type' => self::TYPE_STRING,
                'default' => 'Gemini',
                'category' => 'general',
                'subcategory' => 'gemini',
                'title' => 'Gemini user display name',
                'desc' => 'Add display name for Gemini.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GEMINI_PROMPT_TEMPLATE => array(
                'type' => self::TYPE_STRING,
                'default' => '{question_title} {question_body}',
                'category' => 'general',
                'subcategory' => 'gemini',
                'title' => 'Gemini Prompt Template',
                'desc' => 'Template for the prompt that\'s sent to Gemini server.
						<strong>It must contain: {question_title} or {question_body}</strong> which is a placeholder for the dynamic part.',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GEMINI_REPLY_LENGTH => array(
                'type' => self::TYPE_DECIMAL,
                'default' => 500,
                'decimalConfig' => [
                    'min'  => 0,
                    'max' => 2048,
                    'step' => 1 ],
                'category' => 'general',
                'subcategory' => 'gemini',
                'title' => 'Gemini Reply Length',
                'desc' => 'Set the maximum length of the reply from the chat. Maximum is 2048. <strong>Warning: longer replies use more
							tokens, so you can reach limit faster.</strong>',
                'onlyin' => 'Pro'
            ),
            self::OPTION_GEMINI_TEMPERATURE => array(
                'type' => self::TYPE_DECIMAL,
                'default' => 0.9,
                'decimalConfig' => [
                    'min'  => 0,
                    'max' => 2,
                    'step' => 0.1 ],
                'category' => 'general',
                'subcategory' => 'gemini',
                'title' => 'Gemini Temperature',
                'desc' => 'Ranges from 0 to 2. Higher values like 0.8 will make the output more random, while lower values
+						like 0.2 will make it more focused and deterministic.',
                'onlyin' => 'Pro'
            ),
			self::OPTION_GEMINI_SAFETY_LEVEL => array(
                'type'        => self::TYPE_SELECT,
                'default'     => 'BLOCK_MEDIUM_AND_ABOVE',
                'category'    => 'general',
                'subcategory' => 'gemini',
                'options'     => ['BLOCK_NONE' => 'Always show regardless of probability of being harmful', 'BLOCK_LOW_AND_ABOVE' => 'Block low, medium and high probability of being harmful','BLOCK_MEDIUM_AND_ABOVE' => 'Block medium or high probability of being harmful','BLOCK_ONLY_HIGH' => 'Block high probability of being harmful' ],
                'title'       => 'Gemini Safety Level',
                'description' => 'The Gemini API blocks content based on the probability of content being unsafe.
            By default, safety settings block content (including prompts) with medium or higher probability of being 
            unsafe across any dimension. You can chage safety level to the one is appropriate for your use case',
                'onlyin' => 'Pro'
            ),
			
			// Referrals
			self::OPTION_REFERRAL_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'general',
				'subcategory' => 'referrals',
				'title' => 'Enable referrals',
				'desc' => 'Enable referrals link at the bottom of the question and the answer page.<br>'
						. 'Refer new users to any of the CM Plugins and you\'ll receive <strong>a minimum of 16%</strong> '
						. 'of their purchase! For more information please visit CM Plugins '
						. '<a href="http://www.cminds.com/referral-program/" target="_blank">Affiliate page</a>',
                'onlyin' => 'Pro'
			),
			self::OPTION_AFFILIATE_CODE => array(
				'type' => self::TYPE_STRING,
				'category' => 'general',
				'subcategory' => 'referrals',
				'title' => 'Affiliate code',
				'desc' => 'Please add your affiliate code in here.',
                'onlyin' => 'Pro'
			),
			
			// Sidebar
			self::OPTION_SIDEBAR_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'appearance',
				'subcategory' => 'sidebar',
				'title' => 'Enable sidebar',
				'desc' => '<strong>Warning!</strong> This option is deprecated and used only with the CMA default page template. '
						. 'It\'s not working with build-in theme\'s templates. '
						. 'If you don\'t see the sidebar on your CMA pages try to change the page template in the appearance settings.',
			),
			self::OPTION_SIDEBAR_CONTRIBUTOR_ENABLED => array(
				'type' => self::TYPE_BOOL,
				'default' => 1,
				'category' => 'appearance',
				'subcategory' => 'sidebar',
				'title' => 'Enable sidebar on the Contributor Profile page.',
				'desc' => 'Deprecated, see above.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SIDEBAR_MAX_WIDTH => array(
				'type' => self::TYPE_INT,
				'default' => 300,
				'category' => 'appearance',
				'subcategory' => 'sidebar',
				'title' => 'Set sidebar max width [px]',
				'desc' => 'Deprecated, see above.',
			),
			self::OPTION_SIDEBAR_WIDGET_BEFORE => array(
				'type' => self::TYPE_STRING,
				'category' => 'appearance',
				'subcategory' => 'sidebar',
				'title' => 'HTML before widget block',
				'desc' => 'Leave blank to set the theme\'s default.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SIDEBAR_WIDGET_AFTER => array(
				'type' => self::TYPE_STRING,
				'category' => 'appearance',
				'subcategory' => 'sidebar',
				'title' => 'HTML after widget block',
				'desc' => 'Leave blank to set the theme\'s default.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SIDEBAR_TITLE_BEFORE => array(
				'type' => self::TYPE_STRING,
				'category' => 'appearance',
				'subcategory' => 'sidebar',
				'title' => 'HTML before widget title',
				'desc' => 'Leave blank to set the theme\'s default.',
                'onlyin' => 'Pro'
			),
			self::OPTION_SIDEBAR_TITLE_AFTER => array(
				'type' => self::TYPE_STRING,
				'category' => 'appearance',
				'subcategory' => 'sidebar',
				'title' => 'HTML after widget title',
				'desc' => 'Leave blank to set the theme\'s default.',
                'onlyin' => 'Pro'
			),
			
			// Question stages
			self::OPTION_QUESTION_STAGES_ENABLE => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question_stages',
				'title' => 'Enable question stages',
				'desc' => 'Enable question stages which is a status of the question given by the administrator.',
                'onlyin' => 'Pro'
			),
			self::OPTION_QUESTION_STAGES_LIST => array(
				'type' => self::TYPE_TEXTAREA,
				'default' => "New\nIn development\nRejected\nCompleted",
				'category' => 'thread',
				'subcategory' => 'question_stages',
				'title' => 'Stages for a question',
				'desc' => 'Stages names separated by new line. The first stage will be a default after a user posted a question. '
				. 'Then administrator will be able to change the stage on the question page.',
                'onlyin' => 'Pro'
			),
			self::OPTION_QUESTION_TITLE_STAGE_PREFIX => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question_stages',
				'title' => 'Add the stage name to the question title',
				'desc' => 'If enabled the question title will be prefixed with the stage name in [brackets].',
                'onlyin' => 'Pro'
			),
			self::OPTION_QUESTION_LAST_STAGE_DISABLE_ANSWERS => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question_stages',
				'title' => 'Disable answers on last stage',
				'desc' => 'If admin set the last stage from the list for a question then users won\'t be able to post answers.',
                'onlyin' => 'Pro'
			),
			self::OPTION_QUESTION_LAST_STAGE_DISABLE_COMMENTS => array(
				'type' => self::TYPE_BOOL,
				'default' => 0,
				'category' => 'thread',
				'subcategory' => 'question_stages',
				'title' => 'Disable comments on last stage',
				'desc' => 'If admin set the last stage from the list for a question then users won\'t be able to post comments.',
                'onlyin' => 'Pro'
			),

		));
	}
	
	
	public static function canReportSpam($userId = null) {
		return (self::getOption(self::OPTION_SPAM_REPORTING_ENABLED)
				AND (self::getOption(self::OPTION_SPAM_REPORTING_GUESTS) OR self::isLoggedIn($userId)));
	}
	
	
	public static function areAttachmentsAllowed() {
		$ext = self::getOption(self::OPTION_ATTACHMENTS_FILE_EXTENSIONS);
		return (!empty($ext) AND (self::getOption(self::OPTION_ATTACHMENTS_ANSWERS_ALLOW) OR self::getOption(self::OPTION_ATTACHMENTS_QUESTIONS_ALLOW)));
	}
	
	
	public static function getLoginPageURL($returnURL = null) {
		if (empty($returnURL)) {
			$returnURL = get_permalink();
		}
		if(CMA_Settings::getOption(CMA_Settings::OPTION_QUESTION_FORM_BUTTON)){
            $returnURL = CMA_QuestionController::getUrl('question', 'add');
        }
		if ($customURL = CMA_Settings::getOption(CMA_Settings::OPTION_LOGIN_PAGE_LINK_URL)) {
			return add_query_arg(array('redirect_to' => urlencode($returnURL)), $customURL);
		} else {
			return wp_login_url($returnURL);
		}
	}

	
	public static function getCustomPageTemplate($template) {
		$available = CMA_Settings::getPageTemplatesOptions();
		if (isset($available[$template])) {
			return $template;
		}
	}
	
	public static function getIndexPageTemplate() {
		return static::getCustomPageTemplate(CMA_Settings::getOption(CMA_Settings::OPTION_INDEX_PAGE_TEMPLATE));
	}
	
	public static function getThreadPageTemplate() {
		return static::getCustomPageTemplate(CMA_Settings::getOption(CMA_Settings::OPTION_THREAD_PAGE_TEMPLATE));
	}
	
	
	static function getPostTypesOptions() {
		$types = get_post_types(array(), 'objects');
		foreach ($types as $name => &$type) {
			if (isset($type->labels->name)) {
				$type = $type->labels->name;
			} else {
				$type = $name;
			}
		}
		return $types;
	}
	

	
	static function getIndexSortingOptions() {
		return array(
			'newest' => 'Newest',
            'hottest' => 'Hottest',
			'votes' => 'Votes',
			'views' => 'Views',
		);
	}

	
}
