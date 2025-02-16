<?php
include_once CMA_PATH . '/lib/models/PostType.php';

class CMA_AnswerThread extends CMA_PostType
{
    /**
     * Post type name
     */
    const POST_TYPE = 'cma_thread';
    /**
     * Rewrite slug
     */
    const REWRITE_SLUG = 'answers';
    const ADMIN_MENU = 'CMA_answers_menu';
    const VOTES_MODE_COUNT = 1;

    /**
     * @var CMA_AnswerThread[] singletones cache
     */
    protected static $instances = array();
    /**
     * @var array meta keys mapping
     */
    protected static $_meta = array(
        'lastPoster'         => '_last_poster',
        'views'              => '_views',
        'listeners'          => '_listeners',
        'resolved'           => '_resolved',
        'highestRatedAnswer' => '_highest_rated_answer',
        'votes'              => '_votes'
    );
    protected static $_commentMeta = array(
        'rating'     => '_rating',
        'usersRated' => '_users_rated'
    );

    /**
     * Initialize model
     */
    public static function init()
    {
        $post_type_args = array(
            'has_archive'  => TRUE,
//            'menu_position' => 4,
            'show_in_menu' => self::ADMIN_MENU,
            'rewrite'      => array(
                'slug'       => self::REWRITE_SLUG,
                'with_front' => FALSE,
            ),
            'supports'     => array('title', 'editor'),
            'hierarchical' => false
        );
        $plural = CMA_Labels::getLocalized('Questions');
        self::registerPostType(self::POST_TYPE, CMA_Labels::getLocalized('Question'), $plural, 'CM Answers', $post_type_args);

        //add_filter('CMA_admin_parent_menu', create_function('$q', 'return "' . self::ADMIN_MENU . '";'));
		$selfAdminMenu = self::ADMIN_MENU;
		add_filter('CMA_admin_parent_menu', function($q) use ($selfAdminMenu) {
			return $selfAdminMenu;
		});

        add_action('admin_menu', array(__CLASS__, 'registerAdminMenu'));
        require_once CMA_PATH . '/lib/helpers/Shortcodes.php';
        CMA_Shortcodes::init();

        /**
         * TODO: initiate widgets
         */
    }

    /**
     * @static
     * @param int $id
     * @return CMA_AnswerThread
     */
    public static function getInstance($id = 0)
    {
        if( !$id )
        {
            return NULL;
        }
        if( !isset(self::$instances[$id]) || !self::$instances[$id] instanceof self )
        {
            self::$instances[$id] = new self($id);
        }
        if( empty(self::$instances[$id]->post) OR self::$instances[$id]->post->post_type != self::POST_TYPE )
        {
            return NULL;
        }
        return self::$instances[$id];
    }

    public static function getQuestionsTitle()
    {
        if (!empty($questionsTitle = get_option('cma_questions_title'))) {
            CMA_Labels::setLabel('index_page_title', $questionsTitle);
            delete_option('cma_questions_title');
        }
        return CMA_Labels::getLocalized('index_page_title');
    }
    
    
    static function getMarkupBoxShow() {
        return CMA_Settings::getOption(CMA_Settings::OPTION_MARKUP_BOX_SHOW);
    }
    
    
    static function showLoginForm() {
        return CMA_Settings::getOption(CMA_Settings::OPTION_SHOW_LOGIN_FORM);
    }

    public static function registerAdminMenu()
    {
        $current_user = wp_get_current_user();

        if( user_can($current_user, 'manage_options') )
        {

            $page = add_menu_page(__('Questions', 'cm-answers'), 'CM Answers', 'edit_posts', self::ADMIN_MENU, function($q){ return; });
            add_submenu_page(self::ADMIN_MENU, __('Answers', 'cm-answers'), __('Answers', 'cm-answers'), 'edit_posts', 'edit-comments.php?post_type=' . self::POST_TYPE);
         }
    }

    /**
     * Checks if current user can post questions
     * @return boolean
     */
    public static function canPostQuestions()
    {
        $postQuestionsSetting = CMA_Settings::getOption(CMA_Settings::OPTION_POST_QUESTIONS_ACCESS);

        switch($postQuestionsSetting)
        {
            case CMA_Settings::ACCESS_USERS:
            {
                return is_user_logged_in();
            }
            case CMA_Settings::ACCESS_ROLE:
            {
                $user = get_userdata(get_current_user_id());
                if( !$user )
                {
                    return FALSE;
                }
                $userRoles = $user->roles;
                $accessRoles = (array)CMA_Settings::getOption(CMA_Settings::OPTION_POST_QUESTIONS_ACCESS_ROLES);

                $hasRightRole = array_intersect($accessRoles, $userRoles);
                return user_can($user, 'manage_options') || !empty($hasRightRole);
            }
            default:
                return is_user_logged_in();
                break;
        }
    }

    /**
     * Get content of answer
     * @return string
     */
    public function getContent()
    {
        return $this->post->post_content;
    }
    
    
	public function getLightContent() {
    	return self::lightContent($this->getContent());
    }
    
    
    public static function lightContent($content) {
    	return preg_replace('/[\s\n\r\t]+/', ' ', strip_tags($content));
    }

    /**
     * Set content of question
     * @param string $_description
     * @param bool $save Save immediately?
     * @return CMA_AnswerThread
     */
    public function seContent($_content, $save = false)
    {
        $this->post->post_content = nl2br($_description);
        if( $save ) $this->savePost();
        return $this;
    }

    /**
     * Set status
     * @param string $_status
     * @param bool $save Save immediately?
     * @return CMA_AnswerThread
     */
    public function setStatus($_status, $save = false)
    {
        $this->post->post_status = $_status;
        if( $save ) $this->savePost();
        return $this;
    }

    public function getStatus()
    {
        $status = $this->post->post_status;
        if( $status == 'draft' ) return __('pending', 'cm-answers');
        elseif( $status == 'publish' ) return __('approved', 'cm-answers');
    }

    /**
     * Get author ID
     * @return int Author ID
     */
    public function getAuthorId()
    {
        return $this->post->post_author;
    }

    /**
     * Get author
     * @return WP_User
     */
    public function getAuthor()
    {
        return get_userdata($this->getAuthorId());
    }

    /**
     * Set author
     * @param int $_author
     * @param bool $save Save immediately?
     * @return CMA_AnswerThread
     */
    public function setAuthor($_author, $save = false)
    {
        $this->post->post_author = $_author;
        if( $save ) $this->savePost();
        return $this;
    }

    public function getLastPoster()
    {
        $lastPoster = $this->getPostMeta(self::$_meta['lastPoster']);
        if( empty($lastPoster) ) $lastPoster = $this->getAuthorId();
        return $lastPoster;
    }

    public function getLastPosterName()
    {
        $userdata = get_userdata($this->getLastPoster());
        return $userdata->display_name;
    }

    public static function getAvatarHtml($user_id) {
        $html = '';
        $enabled = CMA_Settings::getOption(CMA_Settings::OPTION_SHOW_GRAVATARS);
        if ($enabled) {
            $html = get_avatar($user_id, 32);
        }

        return apply_filters('cma_user_avatar', $html, $enabled);

    }

    public function setLastPoster($lastPoster)
    {
        $this->savePostMeta(array(self::$_meta['lastPoster'] => $lastPoster));
        return $this;
    }

    public function getViews()
    {
        return (int) $this->getPostMeta(self::$_meta['views']);
    }

    public function addView()
    {
        $views = $this->getViews();
        $this->savePostMeta(array(self::$_meta['views'] => $views + 1));
        return $this;
    }

    public function getTitle()
    {
        $title = parent::getTitle();
        if( $this->isResolved() ) $title = '[' . CMA_Labels::getLocalized('RESOLVED') . '] ' . $title;
        return $title;
    }

    public function getVotes()
    {
        if( self::getVotesMode() == self::VOTES_MODE_COUNT ) return (int) $this->getPostMeta(self::$_meta['votes']);
        else return $this->getHighestRatedAnswer();
    }

    public function addVote()
    {
        $votes = $this->getVotes();
        $this->savePostMeta(array(self::$_meta['votes'] => $votes + 1));
        $this->refreshHighestRatedAnswer();
        return $this;
    }

    public function getHighestRatedAnswer()
    {
        return (int) $this->getPostMeta(self::$_meta['highestRatedAnswer']);
    }

    public function refreshHighestRatedAnswer()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT MAX(m.meta_value*1) FROM {$wpdb->commentmeta} m JOIN {$wpdb->comments} c ON c.comment_ID=m.comment_id AND m.meta_key='%s' AND c.comment_post_ID='%d'", self::$_commentMeta['rating'], $this->getId());
        $highest = (int) $wpdb->get_var($sql);
        $this->savePostMeta(array(self::$_meta['highestRatedAnswer'] => $highest));
        return $this;
    }

    public function isResolved()
    {
        return $this->getPostMeta(self::$_meta['resolved']) == 1;
    }

    public function setResolved($value = true)
    {
        $this->savePostMeta(array(self::$_meta['resolved'] => (int) $value));
        return $this;
    }

    public function getListeners()
    {
        return (array) $this->getPostMeta(self::$_meta['listeners']);
    }

    public function addListener($userId)
    {
        $listeners = $this->getListeners();
        $listeners[] = $userId;
        $listeners = array_unique($listeners);
        $this->savePostMeta(array(self::$_meta['listeners'] => $listeners));
        return $this;
    }

    public function getUnixUpdated($gmt = false)
    {
        return get_post_modified_time('G', $gmt, $this->getPost());
    }

    /**
     * Get when item was updated
     * @param string $format
     * @return string
     */
    public function getUpdated($format = '')
    {
        if( empty($format) ) $format = get_option('date_format');
        return date_i18n($format, strtotime($this->post->post_modified));
    }

    public function getCreationDate($format = '')
    {
        if( empty($format) ) $format = get_option('date_format') . ' ' . get_option('time_format');
        return date_i18n($format, strtotime($this->post->post_date));
    }

    public function setUpdated($date = null)
    {
        if( empty($date) ) $date = current_time('mysql');
        $this->post->post_modified = $date;
        $this->savePost();
        return $this;
    }

    public function getNumberOfAnswers()
    {
        $answers = get_comment_count($this->getId());
        if( $answers && is_array($answers) )
        {
            return $answers['approved'];
        }
        return 0;
    }

    public function getAnswers($sort = 'newest')
    {
        $order = CMA_Settings::getOption(CMA_Settings::OPTION_ANSWER_SORTING_DESC) ? 'DESC' : 'ASC';
        if( $sort == 'newest' )
        {
            $args = array(
                'post_id' => $this->getId(),
                'status'  => 'approve',
                'order'   => $order,
                'fields'  => 'ids'
            );
            $rawComments = get_comments($args);
        }
        elseif( $sort == 'votes' )
        {
            global $wpdb;
            $sql = $wpdb->prepare("SELECT c.comment_ID
            	FROM {$wpdb->comments} c
            	LEFT JOIN {$wpdb->commentmeta} cm ON c.comment_ID=cm.comment_id AND cm.meta_key=%s
            	WHERE c.comment_post_ID=%d AND c.comment_approved
            	ORDER BY cm.meta_value*1 {$order}",
            	self::$_commentMeta['rating'],
            	$this->getId()
            );
            $rawComments = $wpdb->get_col($sql);
        }
        
        $comments = array();
        if( !empty($rawComments) )
        {
            foreach($rawComments as $commentId)
            {
                $comments[] = $this->getCommentData(intval($commentId));
            }
        }
        return $comments;
    }

    public function isEditAllowed($userId)
    {
        return (user_can($userId, 'manage_options') || $this->getAuthorId() == $userId);
    }

    public static function newThread($data = array())
    {
        if( self::isQuestionAutoApproved() ) $status = 'publish';
        else $status = 'draft';
        $title = trim(wp_kses($data['title'], array()));
        $content = trim(wp_kses($data['content'], array(
            'a'      => array(
                'href'  => array(),
                'title' => array()
            ),
            'em'     => array(),
            'strong' => array(),
            'b'      => array(),
            'pre'    => array()
        )));
        if( empty($title) ) $errors[] = __('Title cannot be empty', 'cm-answers');
        if( !CMA_Settings::getOption(CMA_Settings::OPTION_QUESTION_DESCRIPTION_OPTIONAL) && empty($content) ) $errors[] = CMA_Labels::getLocalized('cma_content_cannot_be_empty');
        // Length limit
        if ($limit = CMA_Settings::getOption(CMA_Settings::OPTION_JS_LIMIT_QUESTION_TITLE)) {
            if (strlen($title) > $limit) {
                $errors[] = sprintf(CMA_Labels::getLocalized('error_question_title_too_long'), $limit);
            }
        }
        // Content length limit
        if ($limit = CMA_Settings::getOption(CMA_Settings::OPTION_JS_LIMIT_QUESTION_DESCRIPTION)) {
            if (strlen($content) > $limit) {
                $errors[] = sprintf(CMA_Labels::getLocalized('error_question_content_too_long'), $limit);
            }
        }

        if( !empty($errors) )
        {
            throw new Exception(serialize($errors));
        }
        $id = wp_insert_post(array(
            'post_status'  => $status,
            'post_type'    => self::POST_TYPE,
            'post_title'   => $title,
            'post_content' => $content,
            'post_name'    => urldecode(sanitize_title_with_dashes($title)),
            'post_author'  => get_current_user_id(),
        ));
        if( $id instanceof WP_Error )
        {
            return $id->get_error_message();
        }
        else
        {
            $instance = self::getInstance($id);
            $instance->setUpdated()
                    ->setResolved(false)
                    ->setLastPoster(get_current_user_id());
            if( $data['notify'] == 1 ) $instance->addListener(get_current_user_id());
            $instance->savePostMeta(array(self::$_meta['votes'] => 0));
            $instance->savePostMeta(array(self::$_meta['highestRatedAnswer'] => 0));
            $instance->savePostMeta(array(self::$_meta['views'] => 0));
            $instance->savePost();
            if( !self::isQuestionAutoApproved() ) {
                $instance->notifyModerator();
            } else {
                $instance->notifyAboutNewQuestion();
            }
            do_action('cma_question_post_after', $instance);
            return $instance;
        }
    }

    public function notifyModerator()
    {
        $link = get_permalink($this->getId());
        $author = $this->getAuthor()->display_name;
        $email = $this->getAuthor()->user_email;
        $title = $this->getTitle();
        $content = $this->getContent();

        $approveLink = admin_url('edit.php?post_status=draft&post_type=' . self::POST_TYPE . '&cma-action=approve&cma-id=' . $this->getId());
        $trashLink = admin_url('edit.php?post_status=draft&post_type=' . self::POST_TYPE . '&cma-action=trash&cma-id=' . $this->getId());
        $pendingLink = admin_url('edit.php?post_status=draft&post_type=' . self::POST_TYPE);

        $emailTitle = '[' . get_bloginfo('name') . '] ' . __('Please moderate', 'cm-answers') . ' : "' . $title . '"';

        $emailContent = self::getNewQuestionAdminNotificationContent();
        $emailContent = str_replace('[question_link]', $link, $emailContent);
        $emailContent = str_replace('[author]', $author, $emailContent);
        $emailContent = str_replace('[email]', $email, $emailContent);
        $emailContent = str_replace('[question_title]', $title, $emailContent);
        $emailContent = str_replace('[question_content]', $content, $emailContent);
        $emailContent = str_replace('[approve_link]', $approveLink, $emailContent);
        $emailContent = str_replace('[trash_link]', $trashLink, $emailContent);
        $emailContent = str_replace('[pending_link]', $pendingLink, $emailContent);

        wp_mail(get_option('admin_email'), str_replace('#','№',$emailTitle), $emailContent);
    }

    public function notifyModeratorAnswer($comment_id){
        $comment = get_comment( $comment_id );
        $author = $comment->comment_author;
        $email = $comment->comment_author_email;
        $commentContent = $comment->comment_content;
        $answerLink = get_permalink( $comment->comment_post_ID );
        $question = get_post( $comment->comment_post_ID );
        $questionTitle = $question->post_title;
        $approveLink = admin_url( "comment.php?action=approve&c={$comment_id}#wpbody-content" );
        $trashLink = admin_url( "comment.php?action=trash&c={$comment_id}#wpbody-content" );
        $spamLink = admin_url( "comment.php?action=spam&c={$comment_id}#wpbody-content" );
        $pendingLink = admin_url( 'edit-comments.php?comment_status=moderated#wpbody-content' );

        $emailTitle = '[' . get_bloginfo('name') . '] ' . __('Please moderate', 'cm-answers') . ' : "' . $questionTitle . '"';
        $emailContent = self::getNewAnswerAdminNotificationContent();

        $emailContent = str_replace('[answer_link]', $answerLink, $emailContent);
        $emailContent = str_replace('[author]', $author, $emailContent);
        $emailContent = str_replace('[email]', $email, $emailContent);
        $emailContent = str_replace('[question_title]', $questionTitle, $emailContent);
        $emailContent = str_replace('[answer_content]', $commentContent, $emailContent);
        $emailContent = str_replace('[approve_link]', $approveLink, $emailContent);
        $emailContent = str_replace('[trash_link]', $trashLink, $emailContent);
        $emailContent = str_replace('[spam_link]', $spamLink, $emailContent);
        $emailContent = str_replace('[pending_link]', $pendingLink, $emailContent);

        wp_mail(get_option('admin_email'), str_replace('#','№',$emailTitle), $emailContent);
    }

    public function notifyAboutNewQuestion()
    {
        $receivers = self::getNewQuestionNotification(false);
        if( !empty($receivers) )
        {
            $author = $this->getAuthor()->display_name;
            $questionTitle = $this->getTitle();
            $questionLink = get_permalink($this->getId());
            $questionStatus = $this->getStatus();
            $blogname = get_bloginfo('name');
            $title = self::getNewQuestionNotificationTitle();
            $content = self::getNewQuestionNotificationContent();
            $title = str_replace('[blogname]', $blogname, $title);
            $title = str_replace('[author]', $author, $title);
            $title = str_replace('[question_title]', $questionTitle, $title);
            $title = str_replace('[question_status]', $questionStatus, $title);
            $title = str_replace('[question_link]', $questionLink, $title);
            $content = str_replace('[blogname]', $blogname, $content);
            $content = str_replace('[author]', $author, $content);
            $content = str_replace('[question_title]', $questionTitle, $content);
            $content = str_replace('[question_status]', $questionStatus, $content);
            $content = str_replace('[question_link]', $questionLink, $content);

            foreach($receivers as $receiver)
            {
                $receiver = trim($receiver);
                if( is_email($receiver) )
                {
                    @wp_mail($receiver, $title, $content);
                }
            }
        }
    }

    public function delete()
    {
        return wp_delete_post($this->getId(), true) !== false;
    }

    public function approve()
    {
        $this->setStatus('publish', true);
    }

    public function trash()
    {
        $this->setStatus('trash', true);
    }

    public static function getCommentData($comment_id)
    {
        $comment = get_comment($comment_id);
        $retVal = array(
            'id'         => $comment_id,
            'content'    => $comment->comment_content,
            'author'     => get_comment_author($comment_id),
            'date'       => get_comment_date(get_option('date_format') . ' ' . get_option('time_format'), $comment_id),
            'daysAgo'    => self::renderDaysAgo(get_comment_date('G', $comment_id)),
            'rating'     => (int) get_comment_meta($comment_id, self::$_commentMeta['rating'], true),
            'status'     => $comment->comment_approved == 1 ? 'approved' : 'pending',
            'questionId' => $comment->comment_post_ID
        );
        return $retVal;
    }

    public function addCommentToThread($content, $author_id, $notify = false, $resolved = false)
    {
        $user = get_userdata($author_id);
        $content = trim(wp_kses($content, array(
            'a'      => array(
                'href'  => array(),
                'title' => array()
            ),
            'em'     => array(),
            'strong' => array(),
            'b'      => array(),
            'pre'    => array()
        )));
        if( empty($content) ) $errors[] =  CMA_Labels::getLocalized('cma_content_cannot_be_empty');
        if ($limit = CMA_Settings::getOption(CMA_Settings::OPTION_JS_LIMIT_ANSWER_COMMENT)) {
            if (strlen($content) > $limit) {
                $errors[] =  sprintf(CMA_Labels::getLocalized('error_answer_content_too_long'), $limit);
            }
        }
        if( !empty($errors) )
        {
            throw new Exception(serialize($errors));
        }
        if( self::isAnswerAutoApproved() ) $approved = 1;
        else $approved = 0;

        $data = array(
            'comment_post_ID'      => $this->getId(),
            'comment_author'       => $user->display_name,
            'comment_author_email' => $user->user_email,
            'comment_author_IP'    => $_SERVER['REMOTE_ADDR'],
            'user_id'              => $author_id,
            'comment_parent'       => 0,
            'comment_content'      => apply_filters('comment_text', $content, null),
            'comment_approved'     => $approved,
            'comment_date'         => current_time('mysql')
        );
        $comment_id = wp_insert_comment($data);
        $this->updateThreadMetadata($comment_id, $author_id, $notify, $resolved);
        update_comment_meta($comment_id, self::$_commentMeta['rating'], 0);
        if( $approved !== 1 )
        {
            self::notifyModeratorAnswer($comment_id);
        }
        return $comment_id;
    }

    protected function _notifyOnFollow($lastCommentId)
    {
        $listeners = $this->getListeners();
        if( !empty($listeners) && wp_get_comment_status($lastCommentId) == 'approved')
        {
            $message = CMA_Settings::getOption(CMA_Settings::OPTION_THREAD_NOTIFICATION);
            $title = CMA_Settings::getOption(CMA_Settings::OPTION_THREAD_NOTIFICATION_TITLE);

            $postTitle = $this->getTitle();
            $commentLink = get_permalink($this->getId()) . '/#comment-' . $lastCommentId;
            $blogname = get_bloginfo('name');
            $title = str_replace('[blogname]', $blogname, $title);
            $title = str_replace('[question_title]', $postTitle, $title);
            $title = str_replace('[comment_link]', $commentLink, $title);
            $message = str_replace('[blogname]', $blogname, $message);
            $message = str_replace('[question_title]', $postTitle, $message);
            $message = str_replace('[comment_link]', $commentLink, $message);
            foreach($listeners as $user_id)
            {
                $user = get_userdata($user_id);
                if( !empty($user->user_email) )
                {
                    wp_mail($user->user_email, $title, $message);
                }
            }
        }
    }

    public function updateThreadMetadata($comment_id, $author_id, $notify, $resolved)
    {
        if( $notify )
        {
            $this->addListener($author_id);
        }
        $this->setResolved($resolved)
                ->setLastPoster($author_id)
                ->setUpdated()
                ->savePost();
        $this->_notifyOnFollow($comment_id);
    }

    public function getVoters($comment_id)
    {
        return (array) get_comment_meta($comment_id, self::$_commentMeta['usersRated'], true);
    }

    public function addVoter($comment_id, $user_id)
    {
        $voters = $this->getVoters($comment_id);
        $voters[] = $user_id;
        $voters = array_unique($voters);
        update_comment_meta($comment_id, self::$_commentMeta['usersRated'], $voters);
        return $this;
    }

    public function isVotingAllowed($comment_id, $user_id)
    {
        return !in_array($user_id, $this->getVoters($comment_id));
    }

    public function voteUp($comment_id)
    {
        $currentRating = (int) get_comment_meta($comment_id, self::$_commentMeta['rating'], true);
        update_comment_meta($comment_id, self::$_commentMeta['rating'], $currentRating + 1);
        $this->addVoter($comment_id, get_current_user_id())->addVote();
        return $currentRating + 1;
    }

    public function voteDown($comment_id)
    {
        $currentRating = (int) get_comment_meta($comment_id, self::$_commentMeta['rating'], true);
        update_comment_meta($comment_id, self::$_commentMeta['rating'], $currentRating - 1);

        $this->addVoter($comment_id, get_current_user_id())->addVote();
        return $currentRating - 1;
    }

    public function getUnixDate($gmt = false)
    {
        return get_post_time('G', $gmt, $this->getPost());
    }

    public static function renderDaysAgo($date, $gmt = false)
    {
        if( !is_numeric($date) ) $date = strtotime($date);
        $current = current_time('timestamp', $gmt);
        $seconds_ago = floor($current - $date);
        if( $seconds_ago < 0 ) return __('some time ago', 'cm-answers');
        else
        {
            if( $seconds_ago < 60 )
            {
                return sprintf(_n(CMA_Labels::getLocalized('second_ago'),  CMA_Labels::getLocalized('seconds_ago'), $seconds_ago, 'cm-answers'), $seconds_ago);
            }
            else
            {
                $minutes_ago = floor($seconds_ago / 60);
                if( $minutes_ago < 60 )
                {
                    return sprintf(_n(CMA_Labels::getLocalized('minute_ago'), CMA_Labels::getLocalized('minutes_ago'), $minutes_ago, 'cm-answers'), $minutes_ago);
                }
                else
                {
                    $hours_ago = floor($minutes_ago / 60);
                    if( $hours_ago < 24 )
                    {
                        return sprintf(_n(CMA_Labels::getLocalized('hour_ago'), CMA_Labels::getLocalized('hours_ago'), $hours_ago, 'cm-answers'), $hours_ago);
                    }
                    else
                    {
                        $days_ago = floor($hours_ago / 24);
                        if( $days_ago < 7 )
                        {
                            return sprintf(_n(CMA_Labels::getLocalized('day_ago'), CMA_Labels::getLocalized('days_ago'), $days_ago, 'cm-answers'), $days_ago);
                        }
                        else
                        {
                            $weeks_ago = floor($days_ago / 7);
                            if( $weeks_ago < 4 )
                            {
                                return sprintf(_n(CMA_Labels::getLocalized('week_ago'), CMA_Labels::getLocalized('weeks_ago'), $weeks_ago, 'cm-answers'), $weeks_ago);
                            }
                            else
                            {
                                $months_ago = floor($weeks_ago / 4);
                                if( $months_ago < 12 )
                                {
                                    return sprintf(_n(CMA_Labels::getLocalized('month_ago'), CMA_Labels::getLocalized('months_ago'), $months_ago, 'cm-answers'), $months_ago);
                                }
                                else
                                {
                                    $years_ago = floor($months_ago / 12);
                                    return sprintf(_n(CMA_Labels::getLocalized('year_ago'), CMA_Labels::getLocalized('years_ago'), $years_ago, 'cm-answers'), $years_ago);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public static function isQuestionAutoApproved()
    {
        return CMA_Settings::getOption(CMA_Settings::OPTION_QUESTION_AUTO_APPROVE);
    }

    public static function isAnswerAutoApproved()
    {
        return CMA_Settings::getOption(CMA_Settings::OPTION_ANSWER_AUTO_APPROVE);
    }

    public static function isRatingAllowed()
    {
        return CMA_Settings::getOption(CMA_Settings::OPTION_ANSWERS_RATING_ALLOWED);
    }

    public static function isNegativeRatingAllowed()
    {
        return CMA_Settings::getOption(CMA_Settings::OPTION_NEGATIVE_RATING_ALLOWED);
    }

    public static function getVotesMode()
    {
        return CMA_Settings::getOption(CMA_Settings::OPTION_VOTES_MODE);
    }

	public static function isSidebarEnabled()
	{
        return CMA_Settings::getOption(CMA_Settings::OPTION_SIDEBAR_ENABLED);
	}

    public static function getSidebarMaxWidth()
    {
        return (int) CMA_Settings::getOption(CMA_Settings::OPTION_SIDEBAR_MAX_WIDTH);
    }

    public static function getNotificationTitle()
    {
        return CMA_Settings::getOption(CMA_Settings::OPTION_THREAD_NOTIFICATION_TITLE);
    }

    public static function getNewQuestionNotification($asString = true)
    {
        $receivers = CMA_Settings::getOption(CMA_Settings::OPTION_POST_ADMIN_NOTIFICATION_EMAIL);
        if($asString && is_array($receivers)){
            return implode(', ', $receivers);
        }
        if(!$asString && !is_array($receivers)){
            return explode(',', $receivers);
        }
        return $receivers;
    }

    public static function getNotificationContent()
    {
        return CMA_Settings::getOption(CMA_Settings::OPTION_THREAD_NOTIFICATION);
    }

    public static function getNewQuestionNotificationContent()
    {
        return CMA_Settings::getOption(CMA_Settings::OPTION_NEW_QUESTION_NOTIFICATION_CONTENT);
    }

    public static function getNewQuestionAdminNotificationContent()
    {
        return CMA_Settings::getOption(CMA_Settings::OPTION_NEW_QUESTION_ADMIN_NOTIFICATION_CONTENT);
    }

    public static function getNewAnswerAdminNotificationContent()
    {
        return CMA_Settings::getOption(CMA_Settings::OPTION_NEW_ANSWER_ADMIN_NOTIFICATION_CONTENT);
    }

    public static function getNewQuestionNotificationTitle()
    {
        return CMA_Settings::getOption(CMA_Settings::OPTION_NEW_QUESTION_NOTIFICATION_TITLE);
    }

    public static function customOrder(WP_Query $query, $orderby)
    {
        switch($orderby)
        {
            case 'hottest':
                $query->set('orderby', 'modified');
                $query->set('order', 'DESC');
                break;
            case 'votes':
                if( self::getVotesMode() == self::VOTES_MODE_COUNT ) $query->set('meta_key', self::$_meta['votes']);
                else $query->set('meta_key', self::$_meta['highestRatedAnswer']);
                $query->set('orderby', 'meta_value_num');
                $query->set('order', 'DESC');
                break;
            case 'views':
                $query->set('meta_key', self::$_meta['views']);
                $query->set('orderby', 'meta_value_num');
                $query->set('order', 'DESC');
                break;
            case 'newest':
            default:
                $query->set('orderby', 'date');
                $query->set('order', 'DESC');
                break;
        }
        return $query;
    }

    public static function getQuestions(){
        $args = array(
            'post_type' => self::POST_TYPE,
            'post_status' => array('any', 'trash'),
            'numberposts' => -1,
            'fields' => 'ids'
        );
        return get_posts( $args );
    }

    public static function getQuestionsByUser($user_id, $limit = -1)
    {
        $args = array(
            'author'      => $user_id,
            'post_type'   => self::POST_TYPE,
            'post_status' => array('publish', 'draft'),
            'fields'      => 'ids',
            'orderby'     => 'date',
            'order'       => 'DESC'
        );
        $args['posts_per_page'] = $limit;
        $q = new WP_Query($args);
        $questions = array();
        foreach($q->get_posts() as $id)
        {
            $questions[] = self::getInstance($id);
        }
        return $questions;
    }

    public static function isQuestionExists($question)
    {   
        $question = trim($question);
        $question = preg_replace("/\?+$/", "", $question);
        $args = array(
            'post_type'   => self::POST_TYPE,
            'post_status' => array('publish'),
            'title'  => $question,
            'fields'      => 'ids',
        );
        $q = new WP_Query($args);
        return boolval($q->found_posts);
    }

    public static function deleteQuestions(){
        $_posts = self::getQuestions();
        foreach ($_posts as $post_id) {
            $res = wp_trash_post( $post_id );
        }
    }

    public static function restoreQuestions(){
        $_posts = self::getQuestions();
        foreach ($_posts as $post_id) {
            $res = wp_untrash_post( $post_id );
        }
    }

    public function isVisible() {
    	return true;
    }
    
    public function getPermalink(array $query = array(), $backlink = false, $append = '') {
    	$result = get_permalink($this->getId()) . $append;
    	return add_query_arg(urlencode_deep($query), $result);
    }
    
    public function isPublished() {
        return ($this->post->post_status == 'publish');
    }

    public function getPermalinkWithBacklink(array $query = array(), $append = '') {
        return $this->getPermalink($query, true, $append);
    }
}

class CMA_Thread extends CMA_AnswerThread {}
