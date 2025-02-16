<?php
abstract class CMA_BaseController
{
    const TITLE_SEPARATOR   = '&gt;';
    const MESSAGE_SUCCESS   = 'success';
    const MESSAGE_ERROR     = 'error';
    const MESSAGES_TRANSIENT = 'CMA_messages';
    const ADMIN_SETTINGS    = 'CMA_admin_settings';
    const ADMIN_PRO         = 'CMA_admin_pro';
    const OPTION_TITLES     = 'CMA_panel_titles';
    const ADMIN_BP_NOTIFY = 'CMA_BP_notify';
    const PAGE_ABOUT_URL = 'https://www.cminds.com/wordpress-plugins/?showfilter=No&cat=Plugin&nitems=3';
    const PAGE_ADDONS_URL = 'https://www.cminds.com/wordpress-plugins/?showfilter=No&amp;tags=Answer&amp;nitems=3';
    const PAGE_USER_GUIDE_URL = 'https://creativeminds.helpscoutdocs.com/category/987-answers-cma';
    const PAGE_YEARLY_OFFER = 'https://www.cminds.com/wordpress-plugins-library/cm-wordpress-plugins-yearly-membership/';
    /**
     * Reference to the original main query.
     *
     * @var WP_Query
     */
    public static $query;
    
    protected static $_titles          = array();
    protected static $_fired           = false;
    protected static $_pages           = array();
    protected static $_params          = array();
    protected static $_errors          = array();
    protected static $_messages        = array(self::MESSAGE_SUCCESS => array(), self::MESSAGE_ERROR => array());
    protected static $_customPostTypes = array();

    public static function init()
    {
        add_action('init', array(__CLASS__, 'registerPages'), 2);
    }

    public static function setQueryVars($query)
    {
        if( $query->is_home )
        {
            foreach(self::$_pages as $page)
            {
                if( isset($query->query_vars[$page['query_var']]) && $query->query_vars[$page['query_var']] == 1 )
                {
                    $query->is_home = false;
                }
            }
        }
        if(!is_admin() && ((isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == CMA_AnswerThread::POST_TYPE)
                || ( isset($query->query_vars['widget']) && $query->query_vars['widget'] !== true ))
            && !$query->is_single && !$query->is_404 && !$query->is_author)
        {
            $query->set('posts_per_page', CMA_Settings::getOption(CMA_Settings::OPTION_ITEMS_PER_PAGE));
        }
    }
    
    protected static function _addAdminPages()
    {
        add_action('CMA_custom_post_type_nav', array(__CLASS__, 'addCustomPostTypeNav'), 1, 1);
        add_action('CMA_custom_taxonomy_nav', array(__CLASS__, 'addCustomTaxonomyNav'), 1, 1);
        if (current_user_can('manage_options')) {
        	add_action('admin_menu', array(__CLASS__, 'registerAdminPages'));
        }
        
    	if (isset($_GET['page'])) {
    		if ($_GET['page'] == self::ADMIN_BP_NOTIFY) {
    			CMA_BuddyPress::notifyAllUsers();
    		}
    	}
        
    }

    public static function initSessions()
    {
        if($messages = CMA_Storage::get(self::MESSAGES_TRANSIENT))
        {
            self::$_messages = $messages;
        }
        add_action('wp_logout', array(__CLASS__, 'endSessions'));
        add_action('wp_login', array(__CLASS__, 'endSessions'));
        add_action('CMA_show_messages', array(__CLASS__, 'showMessages'));
    }

    public static function showMessages()
    {
        echo self::_loadView('messages', array('messages' => self::_getMessages()));
    }

    public static function endSessions()
    {

        if(CMA_Storage::get(self::MESSAGES_TRANSIENT))
        {
	        CMA_Storage::delete(self::MESSAGES_TRANSIENT);
        }
    }

    public static function initialize()
    {
    }

    public static function registerPages()
    {
       // flush_rewrite_rules();
        add_action('generate_rewrite_rules', array(__CLASS__, 'registerRewriteRules'));

       // flush_rewrite_rules();
        add_filter('query_vars', array(__CLASS__, 'registerQueryVars'));
        add_action('pre_get_posts', array(__CLASS__, 'setQueryVars'), 99, 1);
        add_filter('wp_title', array(__CLASS__, '_showPageTitle'), 1, 3);
        add_filter('the_posts', array(__CLASS__, 'editQuery'), 10, 2);
        add_filter('the_content', array(__CLASS__, 'showPageContent'), 10, 1);
        if(!is_admin()) wp_enqueue_style('CMA-css', CMA_URL . '/views/resources/app.css', [], '3.3.1');
    }

    public static function registerRewriteRules($rules)
    {
        $newRules   = array();
        $additional = array();
        foreach(self::$_pages as $page)
        {
            if(is_array($page['slug']))
            {
                foreach($page['slug'] as $slug)
                {
                    if(strpos($slug, '/') === false) $additional['^' . $slug . '(?=\/|$)'] = 'index.php?' . $page['query_var'] . '=1';
                    else $newRules['^' . $slug . '(?=\/|$)']   = 'index.php?' . $page['query_var'] . '=1';
                }
            }
            else $newRules['^' . $page['slug'] . '(?=\/|$)'] = 'index.php?' . $page['query_var'] . '=1';
        }
        $rules->rules = $newRules + $rules->rules + $additional;
        return $rules->rules;
    }

    public static function flush_rules()
    {
        $rules = get_option('rewrite_rules');
        foreach(self::$_pages as $page)
        {
            if(!isset($rules['^' . $page['slug'] . '(?=\/|$)']))
            {
                global $wp_rewrite;
                $wp_rewrite->flush_rules();
                return;
            }
        }
    }

    public static function registerQueryVars($query_vars)
    {
        self::flush_rules();
        foreach(self::$_pages as $page)
        {
            $query_vars[] = $page['query_var'];
        }
        return $query_vars;
    }

    protected static function _registerAction($query_var, $args = array())
    {
        $slug            = $args['slug'];
        $contentCallback = isset($args['contentCallback']) ? $args['contentCallback'] : null;
        $headerCallback  = isset($args['headerCallback']) ? $args['headerCallback'] : null;
        $title           = !empty($args['title']) ? $args['title'] : ucfirst($slug);
        $titleCallback   = isset($args['titleCallback']) ? $args['titleCallback'] : null;
        self::$_pages[$query_var] = array(
            'query_var' => $query_var,
            'slug' => $slug,
            'title' => $title,
            'titleCallback' => $titleCallback,
            'contentCallback' => $contentCallback,
            'headerCallback' => $headerCallback,
            'viewPath' => $args['viewPath'],
            'controller' => $args['controller'],
            'action' => $args['action']
        );
    }

    /**
     * Locate the template file, either in the current theme or the public views directory
     *
     * @static
     * @param array $possibilities
     * @param string $default
     * @return string
     */
    protected static function locateTemplate($possibilities, $default = '')
    {

// check if the theme has an override for the template
        $theme_overrides = array();
        foreach($possibilities as $p)
        {
            $theme_overrides[] = 'CMA/' . $p . '.phtml';
        }
        if($found = locate_template($theme_overrides, FALSE))
        {
            return $found;
        }

// check for it in the public directory
        foreach($possibilities as $p)
        {
            if(file_exists(CMA_PATH . '/views/frontend/' . $p . '.phtml'))
            {
                return CMA_PATH . '/views/frontend/' . $p . '.phtml';
            }
        }

// we don't have it
        return $default;
    }

    public static function _showPageTitle($title, $sep = '', $seplocation = 'right')
    {
        foreach(self::$_pages as $page)
        {
            if(get_query_var($page['query_var']) == 1)
            {
                if(!empty($page['titleCallback'])) $title = call_user_func($page['titleCallback']);
                else $title = self::$_titles[$page['controller'] . '-' . $page['action']] ? self::$_titles[$page['controller'] . '-' . $page['action']] : $page['title'];
                if(!empty($sep))
                {
                    $title = str_replace(self::TITLE_SEPARATOR, $sep, $title);
                    if($seplocation == 'right') $title.=' ' . $sep . ' ';
                    else $title = ' ' . $sep . ' ' . $title;
                }
                break;
            }
        }
        return $title;
    }

    public static function editQuery($posts, WP_Query $wp_query)
    {
        if(!self::$_fired)
        {
            foreach(self::$_pages as $page)
            {
                if($wp_query->get($page['query_var']) == 1)
                {
                    if(!empty($page['headerCallback']))
                    {
                        self::$_fired = true;
                        call_user_func($page['headerCallback']);
                    }
//create a fake post
                    $post                 = new stdClass;
                    $post->post_author    = 1;
                    $post->post_name      = $page_slug;
                    $post->guid           = get_bloginfo('wpurl' . '/' . $page['slug']);
                    $post->post_title     = self::_showPageTitle($page['title']);
//put your custom content here
                    $post->post_content   = 'Content Placeholder';
//just needs to be a number - negatives are fine
                    $post->ID             = -42;
                    $post->post_status    = 'static';
                    $post->comment_status = 'closed';
                    $post->ping_status    = 'closed';
                    $post->comment_count  = 0;
//dates may need to be overwritten if you have a "recent posts" widget or similar - set to whatever you want
                    $post->post_date      = current_time('mysql');
                    $post->post_date_gmt  = current_time('mysql', 1);

                    $posts   = NULL;
                    $posts[] = $post;

                    $wp_query->is_page             = true;
                    $wp_query->is_singular         = true;
                    $wp_query->is_home             = false;
                    $wp_query->is_archive          = false;
                    $wp_query->is_category         = false;
                    unset($wp_query->query["error"]);
                    $wp_query->query_vars["error"] = "";
                    $wp_query->is_404              = false;
                    add_filter('template_include', array(__CLASS__, 'overrideBaseTemplate'));
                    break;
                }
            }
        }
        return $posts;
    }

    public static function overrideBaseTemplate($template)
    {
        $template = self::locateTemplate(array(
                    'page'
                        ), $template);
        return $template;
    }

    public static function showPageContent($content)
    {
        foreach(self::$_pages as $page)
        {
            if(get_query_var($page['query_var']) == 1)
            {
                remove_filter('the_content', 'wpautop');
                if(!empty(self::$_errors))
                {
                    $viewParams = call_user_func(array('CMA_ErrorController', 'errorAction'));
                    ob_start();
                    echo self::_loadView('error', $viewParams);
                    $content    = ob_get_contents();
                    ob_end_clean();
                }
                else
                {
                    $viewParams = array();
                    if(!empty($page['contentCallback'])) $viewParams = call_user_func($page['contentCallback']);
                    ob_start();
                    echo self::_loadView('messages', array('messages' => self::_getMessages()));
                    echo self::_loadView($page['viewPath'], $viewParams);
                    $content    = ob_get_contents();
                    ob_end_clean();
                }
                break;
            }
        }
        return $content;
    }

    public static function _loadView($_name, $_params = array())
    {
        $path     = CMA_PATH . '/views/frontend/' . $_name . '.phtml';
        $template = self::locateTemplate(array($_name), $path);
//        if (!file_exists($path))
//            throw new Exception('You do not have a view file for ' . $_name);
        if(!empty($_params)) extract($_params);
        ob_start();
        require($template);
        $content  = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    protected static function _getSlug($controller, $action, $single = false)
    {
        if($action == 'index') if($single) return $controller;
            else return array(
                    $controller . '/' . $action,
                    $controller
                );
        else return $controller . '/' . $action;
    }

    protected static function _getTitle($controller, $action, $hasBody = false)
    {
        $title  = apply_filters('CMA_title_controller', ucfirst($controller)) . ' ' . self::TITLE_SEPARATOR . ' ' . apply_filters('CMA_title_action', ucfirst($action));
        $titles = self::$_titles;
        if(!isset(self::$_titles[$controller . '-' . $action]) && $hasBody) self::$_titles[$controller . '-' . $action] = $title;

        return $title;
    }

    protected static function _getQueryArg($controller, $action)
    {
        return "CMA-{$controller}-{$action}";
    }

    protected static function _getViewPath($controller, $action)
    {
        return $controller . '/' . $action;
    }

    public static function bootstrap()
    {
        self::_addAdminPages();
        self::$_titles = get_option(self::OPTION_TITLES, array());
        $controllersDir = dirname(__FILE__);
        foreach(scandir($controllersDir) as $name)
        {
            if($name != '.' && $name != '..' && $name != basename(__FILE__) && strpos($name, 'Controller.php') !== false)
            {
                $controllerName      = substr($name, 0, strpos($name, 'Controller.php'));
                $controllerClassName = CMA_PREFIX . $controllerName . 'Controller';
                $controller          = strtolower($controllerName);
                include_once $controllersDir . DIRECTORY_SEPARATOR . $name;
                $controllerClassName::initialize();
//                if (!is_admin()) {
                $args                = array();
                foreach(get_class_methods($controllerClassName) as $methodName)
                {
                    if(strpos($methodName, 'Action') !== false && substr($methodName, 0, 1) != '_')
                    {
                        $action           = substr($methodName, 0, strpos($methodName, 'Action'));
                        $query_arg        = self::_getQueryArg($controller, $action);
                        $newArgs          = array(
                            'query_arg' => self::_getQueryArg($controller, $action),
                            'slug' => self::_getSlug($controller, $action),
                            'title' => self::_getTitle($controller, $action, true),
                            'viewPath' => self::_getViewPath($controller, $action),
                            'contentCallback' => array($controllerClassName, $methodName),
                            'controller' => $controller,
                            'action' => $action
                        );
                        if(!isset($args[$query_arg])) $args[$query_arg] = array();
                        $args[$query_arg] = array_merge($args[$query_arg], $newArgs);
                    } elseif(strpos($methodName, 'Header') !== false && substr($methodName, 0, 1) != '_')
                    {
                        $action           = substr($methodName, 0, strpos($methodName, 'Header'));
                        $query_arg        = self::_getQueryArg($controller, $action);
                        $newArgs          = array(
                            'query_arg' => self::_getQueryArg($controller, $action),
                            'slug' => self::_getSlug($controller, $action),
                            'title' => self::_getTitle($controller, $action),
                            'viewPath' => self::_getViewPath($controller, $action),
                            'headerCallback' => array($controllerClassName, $methodName),
                            'controller' => $controller,
                            'action' => $action
                        );
                        if(!isset($args[$query_arg])) $args[$query_arg] = array();
                        $args[$query_arg] = array_merge($args[$query_arg], $newArgs);
                    }
                    elseif(strpos($methodName, 'Title') !== false && substr($methodName, 0, 1) != '_')
                    {
                        $action           = substr($methodName, 0, strpos($methodName, 'Title'));
                        $query_arg        = self::_getQueryArg($controller, $action);
                        $newArgs          = array(
                            'query_arg' => self::_getQueryArg($controller, $action),
                            'slug' => self::_getSlug($controller, $action),
                            'title' => self::_getTitle($controller, $action),
                            'viewPath' => self::_getViewPath($controller, $action),
                            'titleCallback' => array($controllerClassName, $methodName),
                            'controller' => $controller,
                            'action' => $action
                        );
                        if(!isset($args[$query_arg])) $args[$query_arg] = array();
                        $args[$query_arg] = array_merge($args[$query_arg], $newArgs);
                    }
                }
                foreach($args as $query_arg => $data)
                {
                    self::_registerAction($query_arg, $data);
                }
//                }
            }
        }

        global $wp_query;
        // Create local reference to the main query:
        if (empty(self::$query)) {
            self::$query = $wp_query;
        }

        self::registerPages();
        self::initSessions();
        CMA_Shortcodes::initCustomQuestionsIndexPage();
    }

    protected static function _getHelper($name, $params = array())
    {
        $name      = ucfirst($name);
        include_once CMA_PATH . '/lib/helpers/' . $name . '.php';
        $className = CMA_PREFIX . $name;
        return new $className($params);
    }

    protected static function _isPost()
    {
        return strtolower($_SERVER['REQUEST_METHOD']) == 'post';
    }

    public static function loadScripts() {
            add_action('wp_head', array(__CLASS__, 'high_priority_style'), PHP_INT_MAX);
            add_action('wp_footer', array(__CLASS__, 'high_priority_style'), PHP_INT_MAX);
            wp_enqueue_style('dashicons');

            $cmaVariables = array(
                'CMA_URL' => get_post_type_archive_link(CMA_Thread::POST_TYPE),
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'loaderBarUrl' => CMA_URL . '/views/resources/imgs/ajax-loader-bar.gif',
                'loaderUrl' => CMA_URL . '/views/resources/imgs/ajax-loader.gif',
                'navBarAutoSubmit' => CMA_Settings::getOption(CMA_Settings::OPTION_NAVBAR_AUTO_SUBMIT),
                'bestAnswerRemoveOther' => CMA_Settings::getOption(CMA_Settings::OPTION_BEST_ANSWER_REMOVE_OTHER),
                'bestAnswerRemoveOtherLabel' => CMA_Labels::getLocalized('best_answer_remove_other_confirm'),
                'confirmThreadDelete' => __(CMA_Labels::getLocalized('cma_do_you_really_want_delete_question'), 'cm-answers-pro'),
                'enableAjaxOnFilters' => CMA_Settings::getOption(CMA_Settings::OPTION_ENABLE_AJAX_ON_FILTERS),
                'enableAjaxOnQuestion' => CMA_Settings::getOption(CMA_Settings::OPTION_ENABLE_AJAX_ON_QUESTION),
            );

            wp_enqueue_script('cma-script', CMA_RESOURCE_URL . 'script.js', array('jquery', 'cma-toast', 'jquery-ui-dialog', 'suggest', 'utils'), false, true);
            wp_localize_script('cma-script', 'CMA_Variables', $cmaVariables);

            $cma_Variables = array(
                'CMA_URL' => get_post_type_archive_link(CMA_Thread::POST_TYPE),
                'ajaxUrl' => admin_url("admin-ajax.php"),
                'enableAjaxOnFilters' => CMA_Settings::getOption(CMA_Settings::OPTION_ENABLE_AJAX_ON_FILTERS),
                'enableAjaxOnQuestion' => CMA_Settings::getOption(CMA_Settings::OPTION_ENABLE_AJAX_ON_QUESTION),
            );
            wp_enqueue_script('cma-test-ajax', CMA_RESOURCE_URL . 'js/test-ajax.js', array(), false, true);
            wp_localize_script('cma-test-ajax', 'CMAVariables', $cma_Variables);

            wp_enqueue_script('cma-toast', CMA_RESOURCE_URL . 'toast/js/jquery.toastmessage.js', array('jquery'), false, true);
            wp_enqueue_style('cma-toast-css', CMA_RESOURCE_URL . 'toast/resources/css/jquery.toastmessage.css', array(), false);
            wp_enqueue_script('jquery-ui-dialog');
            wp_enqueue_style("wp-jquery-ui-dialog");

            wp_enqueue_script('suggest');

            do_action('cma_load_scripts');
    }

    public static function high_priority_style() {
        if (!defined('CMA_CSS_PRINTED')) {
            wp_print_styles('CMA-css');
            define('CMA_CSS_PRINTED', 1);
        }
    }

    public static function getUrl($controller, $action, $params = array())
    {
        $paramsString = '';
        if(!empty($params))
        {
            foreach($params as $key => $value)
            {
                $paramsString.='/' . urlencode($key) . '/' . urlencode($value);
            }
        }
        return home_url(self::_getSlug($controller, $action, true)) . $paramsString;
    }

    /**
     * Get action param (from $_GET or uri - /name/value)
     * @param string $key
     * @return string
     */
    public static function _getParam($name)
    {
        if(empty(self::$_params))
        {
            $req_uri   = $_SERVER['REQUEST_URI'];
            $home_path = parse_url(home_url());
            if(isset($home_path['path'])) $home_path = $home_path['path'];
            else $home_path = '';
            $home_path = trim($home_path, '/');
            $req_uri   = trim($req_uri, '/');
            $req_uri   = preg_replace("|^$home_path|", '', $req_uri);
            $req_uri   = trim($req_uri, '/');
            $parts     = explode('/', $req_uri);
            if(!empty($parts))
            {
                $params = array();
                for($i = count($parts) - 1; $i > 1; $i-=2)
                {
                    $params[$parts[$i - 1]] = $parts[$i];
                }
                self::$_params = $params + $_REQUEST;
            }
        }
        return isset(self::$_params[$name]) ? self::$_params[$name] : '';
    }

    protected static function _addError($msg)
    {
        self::$_errors[] = $msg;
    }

    protected static function _getErrors()
    {
        $errors = self::$_errors;
        self::$_errors = array();
        return $errors;
    }

    protected static function _saveMessages()
    {
        CMA_Storage::set(static::MESSAGES_TRANSIENT, self::$_messages);
    }

    protected static function _getMessages($type = null)
    {
        $list = array();
        if($type !== null && isset(self::$_messages[$type]))
        {
            $list = self::$_messages[$type];
            self::$_messages[$type] = array();
        }
        else
        {
            $list = self::$_messages;
            self::$_messages = array(self::MESSAGE_SUCCESS => array(), self::MESSAGE_ERROR => array());
        }
        self::_saveMessages();
        return $list;
    }

    protected static function _addMessage($type, $msg)
    {
        if(isset(self::$_messages[$type]))
        {
            self::$_messages[$type][] = $msg;
            self::_saveMessages();
        }
    }

    public static function _userRequired()
    {
        if(!is_user_logged_in())
        {
            self::_addError('You have to be logged in to see this page. <a href="' . esc_attr(wp_login_url($_SERVER['REQUEST_URI'])) . '">Log in</a>');
            return false;
        }
        return true;
    }

    public static function registerAdminPages()
    {
    	global $submenu;

        add_submenu_page(CMA_AnswerThread::ADMIN_MENU, __('Categories', 'cm-answers'), __('Categories', 'cm-answers'), 'manage_categories', 'cma-categories',[__CLASS__,'renderProAdminPage']);
        add_submenu_page(CMA_AnswerThread::ADMIN_MENU, __('Difficulty Levels', 'cm-answers'), __('Difficulty Levels', 'cm-answers'), 'edit_posts', 'cma-difficulty-levels',[__CLASS__,'renderProAdminPage']);
        add_submenu_page(CMA_AnswerThread::ADMIN_MENU, __('Reassign Content', 'cm-answers'), __('Reassign Content', 'cm-answers'), 'edit_posts', 'cma-reassign-content',[__CLASS__,'renderProAdminPage']);
        add_submenu_page(CMA_AnswerThread::ADMIN_MENU, __('CM Answers Logs', 'cm-answers'), __('Logs', 'cm-answers'), 'manage_options', 'cma-logs',[__CLASS__,'renderProAdminPage'],6);


        wp_enqueue_script('jquery');
        add_submenu_page(apply_filters('CMA_admin_parent_menu', 'options-general.php'), __('CM Answers Settings', 'cm-answers'), __('Settings', 'cm-answers'), 'manage_options', self::ADMIN_SETTINGS, array(__CLASS__, 'displaySettingsPage'));

        if (current_user_can('manage_options')) {
        	add_action('admin_head', array(__CLASS__, 'admin_head'));
        }
        add_submenu_page(CMA_AnswerThread::ADMIN_MENU, __('Shortcodes', 'cm-answers'), __('Shortcodes', 'cm-answers'), 'manage_options', 'cma-shortcodes',[__CLASS__,'renderProAdminPage'],13);
    }

    public static function renderProAdminPage(){
        $pageId = filter_input(INPUT_GET, 'page');
        switch ($pageId) {
            case 'cma-categories': {
                include_once CMA_PATH . '/views/backend/admin_categories.phtml';
                break;
            }
            case 'cma-logs': {
                include_once CMA_PATH . '/views/backend/admin_logs.phtml';
                break;
            }
            case 'cma-difficulty-levels': {
                include_once CMA_PATH . '/views/backend/admin_difficulty_levels.phtml';
                break;
            }
            case 'cma-reassign-content': {
                include_once CMA_PATH . '/views/backend/admin_reassign_content.phtml';
                break;
            }
            case 'cma-shortcodes': {
                include_once CMA_PATH . '/views/backend/shortcodes.phtml';
                break;
            }
        }
    }
    
    
    static function admin_head() {
    	echo '<style type="text/css">
        		#toplevel_page_CMA_answers_menu a[href*="cm-wordpress-plugins-yearly-membership"] {color: white;}
    			a[href*="cm-wordpress-plugins-yearly-membership"]:before {font-size: 16px; vertical-align: middle; padding-right: 5px; color: #d54e21;
    				content: "\f487";
				    display: inline-block;
					-webkit-font-smoothing: antialiased;
					font: normal 16px/1 \'dashicons\';
    			}
    			#toplevel_page_CMA_answers_menu a[href*="cm-wordpress-plugins-yearly-membership"]:before {vertical-align: bottom;}
    	
        	</style>';
    }
    
    
    public static function canSaveSettings() {
    	return (!empty($_POST) AND !empty($_POST['nonce']) AND wp_verify_nonce($_POST['nonce'], self::ADMIN_SETTINGS));
    }
    

    public static function displaySettingsPage()
    {
        wp_enqueue_style('jquery-ui-tabs-css', CMA_URL . '/views/resources/jquery-ui-tabs.css');
        wp_enqueue_script('jquery-ui-tabs', false, array(), false, true);
        wp_enqueue_script('cma-suggest-user', CMA_URL . '/views/resources/js/suggest-user.js', array('suggest', 'jquery'));
        wp_enqueue_script('cma-multiselect-user', CMA_URL . '/views/resources/js/jquery.multiselect.js', array('suggest', 'jquery'));
        wp_enqueue_script('cma-multiselect-custom-user', CMA_URL . '/views/resources/js/multiselect-custom.js', array('suggest', 'jquery'));
        wp_register_script('cma-settings-search', CMA_URL . '/views/resources/js/settings-search.js', array('jquery'));
        wp_enqueue_script('cma-settings-search');
        wp_register_script('cma-settings-mp-badges', CMA_URL . '/views/resources/js/settings-mp-badges.js', array('jquery', 'media-upload', 'thickbox'));
        wp_enqueue_script('cma-settings-mp-badges');
        wp_enqueue_style('cma-settings', CMA_URL . '/views/resources/css/settings.css');
        wp_enqueue_script('cma-select2');
        wp_enqueue_style('cma-select2-style');
        wp_enqueue_style('thickbox');
        
        $messages = array();
        if(!empty($_POST['titles']) AND self::canSaveSettings())
        {
            self::$_titles = array_map('sanitize_text_field', $_POST['titles']);
            update_option(self::OPTION_TITLES, self::$_titles);
            $messages[] = __('Settings succesfully updated', 'cm-answers');
        }
        
        $params  = array();
        $params  = apply_filters('CMA_admin_settings', $params);
        extract($params);
        ob_start();
        require(CMA_PATH . '/views/backend/settings.phtml');
        $content = ob_get_contents();
        ob_end_clean();
        self::displayAdminPage($content);
        
    }

    public static function getAdminNav()
    {
        global $submenu, $plugin_page, $pagenow;
        ob_start();
        $submenus = array();
        if(isset($submenu[apply_filters('CMA_admin_parent_menu', 'options-general.php')]))
        {
            $thisMenu = $submenu[apply_filters('CMA_admin_parent_menu', 'options-general.php')];
            foreach($thisMenu as $item)
            {
                $slug       = $item[2];
                $slugParts  = explode('?', $slug);
                $name       = '';
                if(count($slugParts) > 1) $name       = $slugParts[0];
                $isCurrent  = ($slug == $plugin_page || (!empty($name) && $name === $pagenow));
                $url        = (strpos($item[2], '.php') !== false || preg_match('#^https?://#', $slug)) ? $slug : get_admin_url('', 'admin.php?page=' . $slug);
                $submenus[] = array(
                    'link' => $url,
                    'title' => $item[0],
                    'current' => $isCurrent
                );
            }
            require(CMA_PATH . '/views/backend/nav.phtml');
        }
        $nav = ob_get_contents();
        ob_end_clean();
        return $nav;
    }

    public static function displayAdminPage($content)
    {
        $nav = self::getAdminNav();
        require(CMA_PATH . '/views/backend/template.phtml');
    }

    public static function displayProPage()
    {
        ob_start();
        require(CMA_PATH . '/views/backend/pro.phtml');
        $content = ob_get_contents();
        ob_end_clean();
        self::displayAdminPage($content);
    }

    public static function addCustomTaxonomyNav($taxonomy)
    {
        add_action('after-' . $taxonomy . '-table', array(__CLASS__, 'filterAdminNavEcho'), 10, 1);
    }

    public static function filterAdminNavEcho()
    {
        echo self::getAdminNav();
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                $('#col-container').prepend($('#CMA_admin_nav'));
            });
        </script>
        <?php
    }

    public static function addCustomPostTypeNav($postType)
    {
        self::$_customPostTypes[] = $postType;
        add_filter('views_edit-' . $postType, array(__CLASS__, 'filterAdminNav'), 10, 1);
        add_action('restrict_manage_posts', array(__CLASS__, 'addAdminStatusFilter'));
    }

    public static function addAdminStatusFilter($postType)
    {
        global $typenow;
        if(in_array($typenow, self::$_customPostTypes))
        {
            $status = get_query_var('post_status');
            ?><select name="post_status">
                <option value="0"><?php _e('Filter by status', 'cm-answers'); ?></option>
                <option value="publish"<?php if($status == 'publish') echo ' selected="selected"';
            ?>><?php _e('Approved', 'cm-answers'); ?></option>
                <option value="draft"<?php if($status == 'draft') echo ' selected="selected"';
            ?>><?php _e('Pending', 'cm-answers'); ?></option>
                <option value="trash"<?php if($status == 'trash') echo ' selected="selected"';
            ?>><?php _e('Trash', 'cm-answers'); ?></option>
            </select><?php
        }
    }

    public static function filterAdminNav($views = null)
    {
        global $submenu, $plugin_page, $pagenow;
        $scheme     = is_ssl() ? 'https://' : 'http://';
        $adminUrl   = str_replace($scheme . $_SERVER['HTTP_HOST'], '', admin_url());
        $homeUrl    = home_url();
        $currentUri = str_replace($adminUrl, '', $_SERVER['REQUEST_URI']);
        $submenus   = array();
        if(isset($submenu[apply_filters('CMA_admin_parent_menu', 'options-general.php')]))
        {
            $thisMenu = $submenu[apply_filters('CMA_admin_parent_menu', 'options-general.php')];
            foreach($thisMenu as $item)
            {
                $slug               = $item[2];
                $isCurrent          = ($slug == $plugin_page || strpos($item[2], '.php') === strpos($currentUri, '.php'));
                $url                = (strpos($item[2], '.php') !== false || strpos($slug, 'http://') !== false ) ? $slug : get_admin_url('', 'admin.php?page=' . $slug);
                $submenus[$item[0]] =
                        '<a href="' . esc_attr($url) . '" class="' . ($isCurrent ? 'current' : '') . '">' . $item[0] . '</a>';
            }
        }
        return $submenus;
    }
   
}
