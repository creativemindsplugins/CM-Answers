<?php

class CMA_Shortcodes {

    const CUSTOM_QUESTIONS_INDEX_PAGE_META_KEY = '_cma_custom_index_page';
    const CUSTOM_QUESTIONS_INDEX_PAGE_META_VALUE = '1';

    public static function init() {
        add_action('init', array(__CLASS__, 'add_rewrite_endpoint'));
        add_shortcode('cma-index', array(__CLASS__, 'shortcode_index'));
    }

    public static function add_rewrite_endpoint() {
        add_rewrite_endpoint(CMA_Settings::getOption(CMA_Settings::OPTION_ANSWERS_PERMALINK), EP_PERMALINK | EP_PAGES);
    }

    public static function shortcode_index($atts, $widget = true) {
        if(!empty($_POST)) CMA_AnswerController::processQueryVars();
        $atts = array(
                    'limit'               => CMA_Settings::getOption(CMA_Settings::OPTION_ITEMS_PER_PAGE),
                    'tiny'                => false,
                    'sort'                => CMA_Settings::getOption(CMA_Settings::OPTION_INDEX_ORDER_BY),
                    'order'               => 'desc',
                    'form'                => 1,
                    'resolvedprefix'      => 1,
                    'pagination'          => 1,
                    'votes'               => CMA_Settings::getOption(CMA_Settings::OPTION_COLUMN_VOTES_ENABLED),
                    'views'               => CMA_Settings::getOption(CMA_Settings::OPTION_VIEWS_ALLOWED),
                    'answers'             => CMA_Settings::getOption(CMA_Settings::OPTION_ANSWERS_ALLOWED),
                    'metaposition'        => 0,
                    'sortbar'             => CMA_Settings::getOption(CMA_Settings::OPTION_SHOW_INDEX_ORDER),
                    'ajax'                => CMA_Settings::getOption(CMA_Settings::OPTION_ENABLE_AJAX_ON_FILTERS) || CMA_Settings::getOption(CMA_Settings::OPTION_ENABLE_AJAX_ON_QUESTION),
                    'dateposted'          => false,
                    'showcontent'         => CMA_Settings::getOption(CMA_Settings::OPTION_INDEX_SHOW_CONTENT),
                    'scrollaftersearch'   => true,

        );


        $paged = esc_attr(CMA_AnswerController::$query->get('paged'));

        $questionsArgs = array(
            'post_type'      => CMA_Thread::POST_TYPE,
            'post_status'    => 'publish',
            'posts_per_page' => $atts['limit'],
            'paged'          => $paged,
            'fields'         => 'ids',
            'widget'         => true,
            'tag'            => isset($_GET["cmatag"]) ? $_GET["cmatag"] : '',
        );
        
        $questionsArgs = apply_filters('cma_questions_shortcode_query_args', $questionsArgs, $atts);
        $q = CMA_Thread::customOrder(new WP_Query(), $atts['sort']);

        foreach ($questionsArgs as $key => $val) {
            $q->set($key, $val);
        }
        $questions = array_map(array('CMA_Thread', 'getInstance'),$q->get_posts());

        $maxNumPages = $atts['maxNumPages'] = $q->max_num_pages;
        $paged = $q->query_vars['paged'];
        $displayOptions = array(
            'pagination'          => !$atts['tiny'] && $atts['pagination'],
            'form'                => $atts['form'],
            'votes'               => $atts['votes'],
            'views'               => $atts['views'],
            'answers'             => $atts['answers'],
            'metaposition'        => $atts['metaposition'],
            'sortbar'             => $atts['sortbar'],
            'ajax'                => $atts['ajax'],
            'resolvedPrefix'      => $atts['resolvedprefix'],
            'dateposted'          => $atts['dateposted'],
            'showcontent'         => $atts['showcontent'],
        );
        $checkPermissions = true;
        $widget = true;

        $options = array_merge($atts, compact('displayOptions', 'maxNumPages', 'paged', 'widget', 'checkPermissions'));
        $options['checkPermissions'] = false;
        $options = apply_filters('cma_questions_shortcode_widget_options', $options);
        $widgetCacheId = $options['widgetCacheId'] = CMA_AnswerController::saveWidgetOptions($options);
        $options['questions'] = $questions;
        CMA_BaseController::loadScripts();
        $result = CMA_BaseController::_loadView('answer/widget/questions', $options);

        if ($atts['ajax'])
            $result = '<div class="cma-widget-ajax" data-widget-cache-id="' . $widgetCacheId
                    . '" data-scrollaftersearch="' . intval($atts['scrollaftersearch']) . '" style="min-width: ' . CMA_Settings::getOption(CMA_Settings::OPTION_QUESTION_AJAX_MIN_WIDTH) . '">' . $result . '</div>';
        //wp_reset_postdata();
        return $result;
    }

    /**
     * Get custom Questions Index page.
     */
    public static function getCustomQuestionsIndexPage($publish = true) {
        $posts = get_pages(array(
            'meta_key'    => self::CUSTOM_QUESTIONS_INDEX_PAGE_META_KEY,
            'meta_value'  => self::CUSTOM_QUESTIONS_INDEX_PAGE_META_VALUE,
            'post_status' => $publish ? 'publish' : 'publish,private,draft,trash',
        ));
        return reset($posts);
    }

    static function doShortcodeInParam($param) {
        if (preg_match('~^\|.+\|$~', $param)) {
            $param = do_shortcode('[' . substr($param, 1, strlen($param) - 2) . ']');
        }
        return $param;
    }

    /**
     * Initialize custom Questions Index AJAX page.
     */
    public static function initCustomQuestionsIndexPage() {
        if (!self::getCustomQuestionsIndexPage(true) AND CMA_Settings::getOption(CMA_Settings::OPTION_CREATE_AJAX_PAGE)) {
            $permalink = CMA_Settings::getOption(CMA_Settings::OPTION_ANSWERS_PERMALINK) . '-ajax-example-page';
            $post = array(
                'post_title'     => CMA_Labels::getLocalized('index_page_title'),
                'post_name'      => $permalink,
                'post_content'   => '[cma-index]',
                'post_author'    => get_current_user_id(),
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'comment_status' => 'closed',
                'ping_status'    => 'closed',
            );
            $result = wp_insert_post($post);
            if ($result) {
                CMA_Settings::setOption(CMA_Settings::OPTION_HAS_BEEN_CREATED_AJAX_PAGE, true);
                if (!add_post_meta($result, self::CUSTOM_QUESTIONS_INDEX_PAGE_META_KEY, self::CUSTOM_QUESTIONS_INDEX_PAGE_META_VALUE, true)) {
                    update_post_meta($result, self::CUSTOM_QUESTIONS_INDEX_PAGE_META_KEY, self::CUSTOM_QUESTIONS_INDEX_PAGE_META_VALUE);
                }
            }
        }
        if($ajax_page = self::getCustomQuestionsIndexPage(true) AND !CMA_Settings::getOption(CMA_Settings::OPTION_CREATE_AJAX_PAGE)){
            wp_delete_post($ajax_page->ID, true);
        }
    }

}
