<?php

class CMA
{
	
	const TEXT_DOMAIN = 'cm-answers';

    public static function init()
    {
    	
        CMA_AnswerThread::init();
        
        add_action('init', array('CMA_BaseController', 'bootstrap'));
        add_action( 'widgets_init', array('CMA_AnswerController', 'registerSidebars') );
        add_action('plugins_loaded', array('CMA_BuddyPress', 'bootstrap'));
        add_filter('bp_blogs_record_comment_post_types', array(get_class(), 'bp_record_my_custom_post_type_comments'));
        add_action( 'template_redirect', array( __CLASS__, 'refresh_permalinks_on_bad_404' ) );
    }

    public static function install()
    {
        update_option('cma_afterActivation', 1);
        CMA_BaseController::generateSamplePages();
        CMA_AnswerThread::restoreQuestions();
    }

    public static function deactivate()
    {
        CMA_BaseController::tryRemoveSamplePages();
        CMA_AnswerThread::deleteQuestions();
    }

    public static function uninstall()
    {
    }


    /**
     * Get localized string.
     *
     * @param string $msg
     * @return string
     */
    public static function __($msg)
    {
        return __($msg, self::TEXT_DOMAIN);
    }

   
    /**
     * BuddyPress record custom post type comments
     * @param array $post_types
     * @return string
     */
    public static function bp_record_my_custom_post_type_comments($post_types)
    {
        $post_types[] = CMA_AnswerThread::POST_TYPE;
        return $post_types;
    }
    

    public static function getReferer() {
    	global $wp_query;
    	
    	$isEditPage = function($url) { return false; };
    	$isTheSameHost = function($a, $b) {
    		return parse_url($a, PHP_URL_HOST) == parse_url($b, PHP_URL_HOST);
    	};
    	
    	$canUseReferer = (!empty($_SERVER['HTTP_REFERER'])
    			AND $isTheSameHost($_SERVER['HTTP_REFERER'], site_url())
    			AND !$isEditPage($_SERVER['HTTP_REFERER']));
    	$canUseCurrentPost = (is_single() AND !empty($wp_query->post) AND $wp_query->post->post_type == CMA_Thread::POST_TYPE
    			AND $isEditPage($_GET));
    	
    	if (!empty($_GET['backlink'])) { // GET backlink param
			$url = base64_decode(urldecode($_GET['backlink']));
			if(filter_var($url, FILTER_VALIDATE_URL)) {
    			return $url;
			}
    	}
    	else if (!empty($_POST['backlink'])) { // POST backlink param
    		return $_POST['backlink'];
    	}
    	else if ($canUseReferer) { // HTTP referer
    		return $_SERVER['HTTP_REFERER'];
    	}
    	else if ($canUseCurrentPost) { // Question permalink
    		return get_permalink($wp_query->post->ID);
    	} else { // CMA index page
    		return get_post_type_archive_link(CMA_Thread::POST_TYPE);
    	}
    }

    /**
     * Auto flush permalinks wth a soft flush when a 404 error is detected on an
     * Answers main page.
     *
     * @return string
     * @since 2.4.3
     *
     */
    public static function refresh_permalinks_on_bad_404() {
        global $wp;

        if ( ! is_404() ) {
            return;
        }

        if ( isset( $_GET['cm-flush'] ) ) { // WPCS: CSRF ok.
            return;
        }

        if ( false === get_transient( 'cm_refresh_404_permalinks' ) ) {
            $slug  = CMA_AnswerThread::REWRITE_SLUG;
            $parts = explode( '/', $wp->request );

            if ( $slug !== $parts[0] ) {
                return;
            }

            flush_rewrite_rules( false );

            set_transient( 'cm_refresh_404_permalinks', 1, HOUR_IN_SECONDS * 12 );

            $redirect_url = home_url( add_query_arg( array( 'cm-flush' => 1 ), $wp->request ) );
            wp_safe_redirect( esc_url_raw( $redirect_url ), 302 );
            exit();
        }
    }
    
    
}