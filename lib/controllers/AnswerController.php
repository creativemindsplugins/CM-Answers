<?php
include_once CMA_PATH . '/lib/models/AnswerThread.php';
class CMA_AnswerController extends CMA_BaseController
{
    const OPTION_ADD_ANSWERS_MENU = 'cma_add_to_nav_menu';
    const OPTION_MARKUP_BOX_SHOW = 'cma_markup_box_show';

    public static function initialize()
    {
        add_filter('template_include', array(get_class(), 'overrideTemplate'));
        add_filter('manage_edit-' . CMA_AnswerThread::POST_TYPE . '_columns', array(get_class(), 'registerAdminColumns'));
        add_filter('manage_' . CMA_AnswerThread::POST_TYPE . '_posts_custom_column', array(get_class(), 'adminColumnDisplay'), 10, 2);
        do_action('CMA_custom_post_type_nav', CMA_AnswerThread::POST_TYPE);
        add_filter('CMA_admin_settings', array(get_class(), 'addAdminSettings'));
        add_action('admin_init', array(get_class(), 'processStatusChange'));
        add_filter('wp_nav_menu_items', array(get_class(), 'addMenuItem'), 1, 1);
        add_action('pre_get_posts', array(get_class(), 'registerCustomOrder'), 1, 1);
        add_action('CMA_login_form', array(get_class(), 'showLoginForm'));
        add_filter('notify_post_author', array(__CLASS__, 'notify_post_author'), PHP_INT_MAX-5, 2);
        add_action('wp_set_comment_status', [get_class(), 'processAnwserStatusChange'], 999, 2);
        add_action('wp_insert_comment',[__CLASS__, 'sanitizeCommentContent'],1,2);
        add_shortcode('cminds_answers', array(get_class(), 'showAnswers'));

    }
    
    
    public static function registerSidebars() {
    	register_sidebar(array(
            'id' => 'cm-answers-sidebar',
            'name' => __('CM Answers Sidebar', 'cm-answers'),
            'description' => __('This sidebar is shown on CM Answers pages', 'cm-answers')
        ));
    }

    public static function addMenuItem($items)
    {
        $link = self::_loadView('answer/meta/menu-item', array('listUrl' => self::addAnswersMenu() ? get_post_type_archive_link(CMA_AnswerThread::POST_TYPE) : null));
        return $items . $link;
    }

    public static function showLoginForm()
    {
    	if (CMA_AnswerThread::showLoginForm()) {
        	echo self::_loadView('answer/widget/login');
    	}
    }

    public static function processStatusChange()
    {
        if(is_admin() && isset($_REQUEST['cma-action']))
        {
            switch($_REQUEST['cma-action'])
            {
                case 'approve':
                    $id = sanitize_text_field($_REQUEST['cma-id']);
                    if(is_numeric($id))
                    {
                        $thread = CMA_AnswerThread::getInstance($id);
                        $thread->approve();
                        $thread->notifyAboutNewQuestion();
						/*
						add_action('admin_notices', create_function('$q', 'echo "<div class=\"updated\"><p>'
                        	. addslashes(__('Question', 'cm-answers') . ': ' . sprintf(__('"%s" has been succesfully approved'), $thread->getTitle()))
                        	. '</p></div>";'));
						*/
						add_action('admin_notices', function($q) use ($thread) {
							echo '<div class="updated"><p>'.addslashes(__('Question', 'cm-answers') . ': ' . sprintf(__('"%s" has been succesfully approved'), $thread->getTitle())).'</p></div>';
							});

                    }
                    break;
                case 'trash':
                    $id = sanitize_text_field($_REQUEST['cma-id']);
                    if(is_numeric($id))
                    {
                        $thread = CMA_AnswerThread::getInstance($id);
                        $thread->trash();
                        /*
					    add_action('admin_notices', create_function('$q', 'echo "<div class=\"updated\"><p>' . addslashes(__('Question', 'cm-answers') . ': '
                        	. sprintf(__('"%s" has been succesfully moved to trash'), $thread->getTitle())) . '</p></div>";'));
						*/
						add_action('admin_notices', function($q) use ($thread) {
							echo '<div class="updated"><p>'.addslashes(__('Question', 'cm-answers') . ': ' . sprintf(__('"%s" has been succesfully moved to trash'), $thread->getTitle())) . '</p></div>';
							});
                    }
                    break;
            }
        }
    }

    public static function registerCustomOrder($query)
    {
        if(((isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == CMA_AnswerThread::POST_TYPE)
        		|| ( isset($query->query_vars['widget']) && $query->query_vars['widget'] !== true ))
        	&& !$query->is_single && !$query->is_404 && !$query->is_author && isset($_GET['sort']))
        {
            $query         = CMA_AnswerThread::customOrder($query, $_GET['sort']);
            $query->is_top = true;
//             $query->set('posts_per_page', 5);
        }
    }

    public static function overrideTemplate($template)
    {
    	global $wp_query;
//     	echo '<pre>';
//     	var_dump($wp_query);exit;
        if(get_query_var('post_type') == CMA_AnswerThread::POST_TYPE)
        {
            if(self::_isPost()) self::processQueryVars();
            if(is_single() || is_404())
            {
                wp_enqueue_script('jquery');
                wp_enqueue_script('jquery-toast', CMA_URL . '/views/resources/toast/js/jquery.toastmessage.js', array('jquery'));
                wp_enqueue_style('jquery-toast-css', CMA_URL . '/views/resources/toast/resources/css/jquery.toastmessage.css');
                $template = self::locateTemplate(array(
                            'answer/single'
                                ), $template);
                if(!self::_isPost())
                {
                    self::_processViews();
                }
            }
            else
            {
                $template = self::locateTemplate(array(
                            'answer/index'
                                ), $template);
            }
            add_filter('body_class', array(get_class(), 'adjustBodyClass'), 20, 2);
        }
        return $template;
    }

    protected static function _processViews()
    {
        global $wp_query;
        $post   = $wp_query->post;
        $thread = CMA_AnswerThread::getInstance($post->ID);
        if($thread)
        {
        $thread->addView();
    }
        else
        {
            global $wp_query;
            $wp_query->is_404    = true;
            $wp_query->is_single = false;
            $wp_query->is_page   = false;

            $template = get_query_template('404');
            if(!empty($template)) include( $template );
            die();
        }
    }

    protected static function _processAddCommentToThread()
    {
        global $wp_query;
        $post      = $wp_query->post;
        $thread    = CMA_AnswerThread::getInstance($post->ID);
        $content   = sanitize_text_field($_POST['content']);
        $notify    = !empty($_POST['thread_notify']);
        $resolved  = !empty($_POST['thread_resolved']);
        $author_id = get_current_user_id();
        $error     = false;
        $messages  = array();
        try
        {
        	if (empty($_POST['nonce']) OR !wp_verify_nonce($_POST['nonce'], 'cma_answer')) {
        		throw new Exception(serialize(array('Invalid nonce.')));
        	}
            $comment_id = $thread->addCommentToThread($content, $author_id, $notify, $resolved);
        }
        catch(Exception $e)
        {
            $messages = unserialize($e->getMessage());
            $error    = true;
        }
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
        {

            header('Content-type: application/json');
            echo json_encode(array('success' => (int) (!$error), 'comment_id' => $comment_id, 'commentData' => CMA_AnswerThread::getCommentData($comment_id), 'message' => $messages));
            exit;
        }
        else
        {
            if($error)
            {
                foreach((array) $messages as $message)
                {
                    self::_addMessage(self::MESSAGE_ERROR, $message);
                }
            }
            else
            {
            	
            	do_action('cma_answer_post_after', $thread, CMA_Answer::getById($comment_id));
            	
                $autoApprove = CMA_AnswerThread::isAnswerAutoApproved();
                if($autoApprove)
                {
                    $msg = __('Your answer has been succesfully added.', 'cm-answers');
                    self::_addMessage(self::MESSAGE_SUCCESS, $msg);
                    wp_redirect(get_permalink($post->ID) . '/#comment-' . $comment_id, 303);
                }
                else
                {
                    $msg = __('Thank you for your answer, it has been held for moderation.', 'cm-answers');
                    self::_addMessage(self::MESSAGE_SUCCESS, $msg);
                    wp_redirect(get_permalink($post->ID), 303);
                }
                exit;
            }
        }
    }


    protected static function _processAddThread($formLocation = false)
    {
        global $wp_query;
        $post      = $wp_query->post;
        $title     = sanitize_text_field($_POST['thread_title']);
        $content   = sanitize_text_field($_POST['thread_comment']);
        $notify    = !empty($_POST['thread_notify']);
        $author_id = get_current_user_id();
        $error     = false;
        $messages  = array();
        $data      = array(
            'title' => $title,
            'content' => $content,
            'notify' => $notify,
            'author_id' => $author_id
        );

        if(CMA_AnswerThread::isQuestionExists($title)){
            $messages = array("Question (" . $title . ") exists");
            $error    = true;
        }else{
            try
            {
            	if (empty($_POST['nonce']) OR !wp_verify_nonce($_POST['nonce'], 'cma_question')) {
            		throw new Exception(serialize(array('Invalid nonce.')));
            	}
                $thread    = CMA_AnswerThread::newThread($data);
                $thread_id = $thread->getId();
            }
            catch(Exception $e)
            {
                $messages = unserialize($e->getMessage());
                $error    = true;
            }
        }

        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
        {
            header('Content-type: application/json');
            echo json_encode(array('success' => (int) (!$error), 'thread_id' => $thread_id, 'message' => $messages));
            exit;
        }
        else
        {
            if($error)
            {
                foreach((array) $messages as $message)
                {
                    self::_addMessage(self::MESSAGE_ERROR, $message);
                }
                if($formLocation != "cminds_answers_shortcode"){
                    wp_redirect(get_post_type_archive_link(CMA_AnswerThread::POST_TYPE), 303);
                }
            }
            else
            {
                $autoApprove = CMA_AnswerThread::isQuestionAutoApproved();
                if($autoApprove)
                {
                    $msg = __('New question has been succesfully added.', 'cm-answers');
                    self::_addMessage(self::MESSAGE_SUCCESS, $msg);
                }
                else
                {
                    $msg = __('Thank you for your question, it has been held for moderation.', 'cm-answers');
                    self::_addMessage(self::MESSAGE_SUCCESS, $msg);
                }
                if($formLocation != "cminds_answers_shortcode"){
                    wp_redirect(get_post_type_archive_link(CMA_AnswerThread::POST_TYPE), 303);
                }
            }
            if($formLocation != "cminds_answers_shortcode"){
                exit;
            }
        }
    }

    protected static function _processVote()
    {
        if(is_single())
        {
            global $wp_query;
            $post = $wp_query->post;
            if(!empty($post))
            {
                $thread  = CMA_AnswerThread::getInstance($post->ID);
                $comment = self::_getParam('cma-comment');
                $nonce = self::_getParam('nonce');
                if(!empty($comment) AND !empty($nonce) AND wp_verify_nonce($nonce, 'cma_vote'))
                {
                    $response = array('success' => 0, 'message' => __('There was an error while processing your vote', 'cm-answers'));
                    $votes    = 0;
                    if(!is_user_logged_in())
                    {
                        $response['success'] = 0;
                        $response['message'] = __('You have to be logged-in to vote', 'cm-answers');
                    }
                    else
                    if($thread->isVotingAllowed($comment, get_current_user_id()))
                    {
                        $response['success'] = 1;
                        if(self::_getParam('cma-value') == 'up')
                        {
                            $response['message'] = $thread->voteUp($comment);
                        }
                        else $response['message'] = $thread->voteDown($comment);
                    } else
                    {
                        $response['message'] = __('You have already voted for this comment', 'cm-answers');
                    }
                    header('Content-type: application/json');
                    echo json_encode($response);
                    exit;
                }
            }
        }
    }

    public static function processQueryVars()
    {
        $action = self::_getParam('cma-action');
        $formLocation = self::_getParam('cma-form-location') ? self::_getParam('cma-form-location') : false;
        if(!empty($action))
        {
            switch($action)
            {
                case 'add':
                    if(is_single()) self::_processAddCommentToThread();
                    else self::_processAddThread($formLocation);
                    break;
                case 'vote':
                    self::_processVote();
                    break;
            }
        }
    }

    public static function adjustBodyClass($wp_classes, $extra_classes = [])
    {
        foreach($wp_classes as $key => $value)
        {
            if($value == 'singular') unset($wp_classes[$key]);
        }
	    if(!CMA_AnswerThread::isSidebarEnabled() || !is_active_sidebar('cm-answers-sidebar')) $extra_classes[] = 'full-width';
        return array_merge($wp_classes, (array) $extra_classes);
    }

    public static function registerAdminColumns($columns)
    {
        $columns['author']   = __('Author', 'cm-answers');
        $columns['views']    = __('Views', 'cm-answers');
        $columns['status']   = __('Status', 'cm-answers');
        $columns['comments'] = __('Answers', 'cm-answers');
        return $columns;
    }

    public static function adminColumnDisplay($columnName, $id)
    {
        $thread = CMA_AnswerThread::getInstance($id);
        if(!$thread) return;
        switch($columnName)
        {
            case 'author':
                echo $thread->getAuthor()->display_name;
                break;
            case 'views':
                echo $thread->getViews();
                break;
            case 'status':
                echo $thread->getStatus();
                if(strtolower($thread->getStatus()) == strtolower(__('pending', 'cm-answers')))
                {
                    ?>
                    <a href="<?php echo esc_attr(add_query_arg(urlencode_deep(array('cma-action' => 'approve', 'cma-id' => $id)))); ?>">(<?php _e('Approve', 'cm-answers'); ?>)</a>
                    <?php
                }
                break;
        }
    }

    public static function addAdminSettings($params = array())
    {
        if(self::_isPost() AND self::canSaveSettings())
        {
            CMA_AnswerThread::setQuestionAutoApproved(isset($_POST['questions_auto_approve']) && $_POST['questions_auto_approve'] == 1);
            CMA_AnswerThread::setAnswerAutoApproved(isset($_POST['answers_auto_approve']) && $_POST['answers_auto_approve'] == 1);
            CMA_AnswerThread::setRatingAllowed(isset($_POST['ratings']) && $_POST['ratings'] == 1);
            CMA_AnswerThread::setNegativeRatingAllowed(isset($_POST['negative_ratings']) && $_POST['negative_ratings'] == 1);
            CMA_AnswerThread::setNewQuestionNotification(stripslashes($_POST['notification_new_questions']));
            CMA_AnswerThread::setNewQuestionNotificationTitle(stripslashes($_POST['new_question_notification_title']));
            CMA_AnswerThread::setNewQuestionNotificationContent(esc_attr($_POST['new_question_notification_content']));
            CMA_AnswerThread::setNewQuestionAdminNotificationContent(esc_attr($_POST['new_question_admin_notification_content']));
            CMA_AnswerThread::setNewAnswerAdminNotificationContent(esc_attr($_POST['new_answer_admin_notification_content']));
            CMA_AnswerThread::setNotificationTitle(stripslashes($_POST['notification_title']));
            CMA_AnswerThread::setNotificationContent(stripslashes(esc_attr($_POST['notification_content'])));
            if (isset($_POST['votes_mode'])) CMA_AnswerThread::setVotesMode((int) $_POST['votes_mode']);
	        CMA_AnswerThread::setSidebarEnabled(isset($_POST['sidebar_enable']) && $_POST['sidebar_enable'] == 1);
	        CMA_AnswerThread::setSidebarMaxWidth((int) $_POST['sidebar_max_width']);
	        CMA_AnswerThread::setShowLoginForm($_POST[CMA_AnswerThread::OPTION_SHOW_LOGIN_FORM]);
            if(!empty($_POST['questions_title']))
            {
                update_option(CMA_AnswerThread::OPTION_QUESTIONS_TITLE, esc_attr($_POST['questions_title']));
            }
            self::setAnswersMenu(isset($_POST['add_menu']) && $_POST['add_menu'] == 1);
            update_option(self::OPTION_MARKUP_BOX_SHOW, !empty($_POST[self::OPTION_MARKUP_BOX_SHOW]));
        }
        $params['ratings']                             = CMA_AnswerThread::isRatingAllowed();
        $params['negativeRatings']                     = CMA_AnswerThread::isNegativeRatingAllowed();
        $params['questionAutoApproved']                = CMA_AnswerThread::isQuestionAutoApproved();
        $params['answerAutoApproved']                  = CMA_AnswerThread::isAnswerAutoApproved();
        $params['notificationNewQuestions']            = CMA_AnswerThread::getNewQuestionNotification();
        $params['newQuestionNotificationTitle']        = CMA_AnswerThread::getNewQuestionNotificationTitle();
        $params['newQuestionNotificationContent']      = CMA_AnswerThread::getNewQuestionNotificationContent();
        $params['newQuestionAdminNotificationContent'] = CMA_AnswerThread::getNewQuestionAdminNotificationContent();
        $params['newAnswerAdminNotificationContent']   = CMA_AnswerThread::getNewAnswerAdminNotificationContent();
        $params['newAnswerAuthorNotificationContent']   = CMA_AnswerThread::getNewAnswerAuthorNotificationContent();
        $params['notificationTitle']                   = CMA_AnswerThread::getNotificationTitle();
        $params['notificationContent']                 = CMA_AnswerThread::getNotificationContent();
        $params['votesMode']                           = CMA_AnswerThread::getVotesMode();
	    $params['sidebarEnable']                       = CMA_AnswerThread::isSidebarEnabled();
	    $params['sidebarMaxWidth']                     = CMA_AnswerThread::getSidebarMaxWidth();
        $params['addMenu']                             = self::addAnswersMenu();
        $params['questions_title']                     = CMA_AnswerThread::getQuestionsTitle();
        $params['showMarkupBox'] = CMA_AnswerThread::getMarkupBoxShow();
        $params['showLoginForm'] = CMA_AnswerThread::showLoginForm();
        return $params;
    }

    public static function setAnswersMenu($value = false)
    {
        update_option(self::OPTION_ADD_ANSWERS_MENU, $value);
    }

    public static function addAnswersMenu()
    {
        return (bool) get_option(self::OPTION_ADD_ANSWERS_MENU);
    }

    /**
     * Shortode example: [cminds_answers ids="1,2,3" can-add-question="y|n"]
     * @param  array  $atts array
     * @return shortcode html
     */
    public static function showAnswers($atts = array()) {

        if(self::_isPost()) self::processQueryVars();

        $atts = shortcode_atts(array('ids' => null, 'can-add-question' => 'n'), $atts);

        $args = array(
            'post_type' => CMA_AnswerThread::POST_TYPE,
        );

        if($atts["ids"]){
            $args["post__in"] = explode(",", $atts["ids"]);
        }

        $atts["query"] = new WP_Query( $args );

        ob_start();
        set_query_var('atts', $atts); // send data to template

        include CMA_PATH . '/views/frontend/answer/shortcodes/answers.phtml';
        return ob_get_clean();
    }

    static function notify_post_author($maybe_notify, $comment_ID) {
        $comment = get_comment($comment_ID);
        if ($maybe_notify AND get_post_type($comment->comment_post_ID) == 'cma_thread') {
            $maybe_notify = false;
        }
        return $maybe_notify;
    }

    public static function processAnwserStatusChange($answerId, $status) {
        /*
         * Get the comment, author, thread
         */
        $answer = get_comment($answerId);
        /*
         * Comment not found
         */
        if (!$answer) {
            return;
        }

        // Comment is not a CMA answer
        if (get_post_type($answer->comment_post_ID) != 'cma_thread') {
            return;
        }
        $thread = CMA_AnswerThread::getInstance($answer->comment_post_ID);
        $author_id = $answer->user_id;
        $notify = false;
        $resolved = false;
        $thread->updateThreadMetadata($answerId, $author_id, $notify, $resolved);// Send notifications

    }

    public static function sanitizeCommentContent($id, $comment){
       $data['comment_content'] =  sanitize_text_field($comment->comment_content);
       $data['comment_ID'] = $id;
       wp_update_comment($data);
    }

}
?>
