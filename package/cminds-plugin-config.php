<?php
ob_start();
include plugin_dir_path(__FILE__) . 'views/plugin_compare_table.php';
$plugin_compare_table = ob_get_contents();
ob_end_clean();
$cminds_plugin_config = array(
    'plugin-is-pro'                 => false,
    'plugin-has-addons'             => TRUE,
    'plugin-version'                => '3.3.1',
    'plugin-affiliate'              => '',
    'plugin-redirect-after-install' => admin_url( 'admin.php?page=CMA_admin_settings' ),
    'plugin-settings'               => admin_url( 'admin.php?page=CMA_admin_settings' ),
    'plugin-campign'                => '?utm_source=cmafree&utm_campaign=freeupgrade',
    'plugin-show-guide'             => TRUE,
    'plugin-guide-text'             => '    <div style="display:block">
        <ol>
         <li>Go to <strong>"Setting"</strong> and click on <strong>"Link to questions frontend list"</strong></li>
            <li>Scroll down to the bottom and <strong>Add</strong> your first question</li>
            <li>Click on the question which was created and scroll down to <strong>Add</strong>  your first answer.</li>
            <li>In the plugin setting you can change moderation options and notification settings</li>
            <li><strong>Troubleshooting:</strong> Make sure that you are using Post name permalink structure in the WP Admin Settings -> Permalinks.</li>
            <li><strong>Troubleshooting:</strong> If post type archive does not show up or displays 404 then install Rewrite Rules Inspector plugin and use the Flush rules button.</li>
            <li><strong>Troubleshooting:</strong> if the settings cannot be saved eg. 403 Forbidden error shows up after pressed the Save button, then contact your hosting provider and ask for the restrictions for POST requests to the /wp-admin/admin.php.</li>        </ol>
    </div>',
    'plugin-guide-video-height'     => 240,
    'plugin-guide-videos'           => array(
        array( 'title' => 'Installation tutorial', 'video_id' => '159673807' ),
    ),
    'plugin-upgrade-text'           => 'Good Reasons to Upgrade to Pro',
    'plugin-upgrade-text-list'      => array(
        array( 'title' => 'Why you should upgrade to Pro', 'video_time' => '0:00' ),
        array( 'title' => 'Improved questions list view with search and filters ', 'video_time' => '0:03' ),
        array( 'title' => 'Improved thred view with more options', 'video_time' => '0:50' ),
        array( 'title' => 'Categories support', 'video_time' => '1:24' ),
        array( 'title' => 'Multiple attachment support', 'video_time' => '1:55' ),
        array( 'title' => 'Replace comments with question module', 'video_time' => '2:34' ),
        array( 'title' => 'Enhanced voting support', 'video_time' => '3:18' ),
        array( 'title' => 'Tags support', 'video_time' => '3:49' ),
        array( 'title' => 'User dashboard and profile', 'video_time' => '4:23' ),
        array( 'title' => 'Multiple forums support', 'video_time' => '4:56' ),
        array( 'title' => 'Logs and statistics', 'video_time' => '5:18' ),
        array( 'title' => 'Private posts', 'video_time' => '5:52' ),
        array( 'title' => 'Advanced notifications', 'video_time' => '6:28' ),
        array( 'title' => 'Disclaimer support ', 'video_time' => '6:55' ),
        array( 'title' => 'Shortcode support ', 'video_time' => '7:52' ),
   ),
    'plugin-upgrade-video-height'   => 240,
    'plugin-upgrade-videos'         => array(
        array( 'title' => 'Answers Premium Plugin Overview', 'video_id' => '271271526' ),
    ),
    'plugin-abbrev'                 => 'cma',
    'plugin-file'                   => CMA_PLUGIN_FILE,
    'plugin-dir-path'               => plugin_dir_path( CMA_PLUGIN_FILE ),
    'plugin-dir-url'                => plugin_dir_url( CMA_PLUGIN_FILE ),
    'plugin-basename'               => plugin_basename( CMA_PLUGIN_FILE ),
    'plugin-icon'                   => '',
    'plugin-name'                   => 'CM Answers',
    'plugin-license-name'           => 'CM Answers',
    'plugin-slug'                   => '',
    'plugin-short-slug'             => 'cm-answers',
    'plugin-menu-item'              => 'CMA_answers_menu',
    'plugin-textdomain'             => 'cm-answers',
    'plugin-userguide-key'          => '987-answers-cma',
    'plugin-store-url'              => 'https://www.cminds.com/cm-answer-store-page-content/?utm_source=cmafree&utm_campaign=freeupgrade&upgrade=1',
    'plugin-support-url'            => 'https://www.cminds.com/contact/',
    'plugin-review-url'             => 'https://wordpress.org/support/view/plugin-reviews/cm-answers',
    'plugin-changelog-url'          => 'https://www.cminds.com/wordpress-plugins-library/cm-answers-changelog/',
    'plugin-licensing-aliases'      => array( 'CM Answers' ),
    'plugin-compare-table'          => $plugin_compare_table,
);