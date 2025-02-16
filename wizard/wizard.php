<?php

class CMA_SetupWizard{

    public static $steps;
    public static $wizard_url;
    public static $wizard_path;
    public static $options_slug = 'cma_'; //change for your plugin needs
    public static $wizard_screen = 'cm-answers_page_cma_setup_wizard'; //change for your plugin needs
    public static $setting_page_slug = CMA_BaseController::ADMIN_SETTINGS; //change for your plugin needs
    public static $plugin_basename;


    public static function init() {
        self::$wizard_url = plugin_dir_url(__FILE__);
        self::$wizard_path = plugin_dir_path(__FILE__);
        self::$plugin_basename = plugin_basename(CMA_PLUGIN_FILE); //change for your plugin needs
        self::setSteps();

        add_action('admin_menu', array(__CLASS__, 'add_submenu_page'),30);
        add_action('wp_ajax_cmf_save_wizard_options',[__CLASS__,'saveOptions']);
        add_action( 'admin_enqueue_scripts', [ __CLASS__, 'enqueueAdminScripts' ] );
        add_action('activated_plugin', [__CLASS__, 'redirectAfterInstall'], 1, 2);
        add_action('admin_notices', [__CLASS__,'disableAdminNotices'],1);
    }


    public static function setSteps()
    {
        self::$steps = [
            1 => ['title' => 'Initial Setup',
                'options' => [
                    0 => [
                        'name' => 'cma_answer_page_disabled',
                        'title' => 'Disable default forum page',
                        'type' => 'bool',
                        'value'   => 1,
                        'hint' => 'Completely disable the default index page, making it return a 404 error.
The default forum page is automatically generated but cannot be customized. Disabling it allows you to create and use an editable forum page instead.'
                    ],
                    1 => [
                        'name' => 'cma_create_ajax_page',
                        'title' => 'Create editable forum page',
                        'type' => 'bool',
                        'value'   => 1,
                        'hint' => 'This option creates a new forum page that you can customize. The page also supports dynamic updates, improving user experience.'
                    ],
                    2 => [
                        'name' => 'cma_enable_ajax_on_filters',
                        'title' => 'Enable dynamic filtering',
                        'type' => 'bool',
                        'value'   => 1,
                        'hint' => 'When enabled, filters on the forum page update instantly as users interact with them, without needing to reload the page.'
                    ],
                    3 => [
                        'name' => 'cma_enable_ajax_on_question',
                        'title' => 'Enable quick navigation for questions',
                        'type' => 'bool',
                        'value'   => 1,
                        'hint' => 'When enabled, clicking on a question or returning to the main index page will load the content instantly without refreshing the entire page.'
                    ],
                ],
            ],
            2 => ['title' =>'Questions Page Settings',
                'options' => [
                    0 => [
                        'name' => 'cma_items_per_page',
                        'title' => 'Amount of questions per page',
                        'type' => 'int',
                        'value' => 10,
                        'hint' => 'Set the maximum number of questions displayed per page on the index page.'
                    ],
                    1 => [
                        'name' => 'cma_views_allowed',
                        'title' => 'Show number of views for a question',
                        'type' => 'bool',
                        'value' => 1,
                        'hint' => 'Display the total number of views for each question on the index page.'
                    ],
                    2 => [
                        'name' => 'cma_answers_allowed',
                        'title' => 'Show number of answers for a question',
                        'type' => 'bool',
                        'value' => 1,
                        'hint' => 'Display the total number of answers for each question on the index page.'
                    ],
                    3 => [
                        'name' => 'cma_column_votes_enabled',
                        'title' => 'Show number of votes for a question',
                        'type' => 'bool',
                        'value' => 1,
                        'hint' => 'Display a rating box for each question on the index page, based on the selected voting mode.'
                    ],
                    4 => [
                        'name' => 'cma_show_index_order',
                        'title' => 'Show questions sorting',
                        'type' => 'bool',
                        'value' => 1,
                        'hint' => 'Enable or disable the question sorting options (Newest, Hottest, Most) on the index page.'
                    ],
                    5 => [
                        'name' => 'cma_index_show_content',
                        'title' => 'Show question\'s description',
                        'type' => 'radio',
                        'value' => 0,
                        'options'   => [
                            0 => [
                                'title' => 'disabled',
                                'value' => 0
                            ],
                            1 => [
                                'title' => 'only fragment',
                                'value' => 'fragment'
                            ],
                            2 => [
                                'title' => 'entire content',
                                'value' => 1
                            ]
                        ],
                        'hint' => 'Choose if to show the full question description, only a fragment of it, or not show at all (on the index page).'
                    ],
                    6 => [
                        'name' => 'cma_question_ajax_min_width',
                        'title' => 'Set the min-width of the forum page content',
                        'type' => 'string',
                        'value' => '80%',
                        'hint' => 'Define the min-width of the question list on the forum page.'
                    ],
                ],
            ],
            3 => ['title' =>'Questions and Answers Settings',
                'options' => [
                    0 => [
                        'name' => 'cma_show_gravatars',
                        'title' => 'Show gravatar photos',
                        'type' => 'bool',
                        'value' => 1,
                        'hint' => 'Show user profile photos from Gravatar next to usernames on thread pages.'
                    ],
                    1 => [
                        'name' => 'cma_js_limit_question_title',
                        'title' => 'Limit for question title',
                        'type' => 'int',
                        'value' => 100,
                        'hint' => 'Set the maximum number of characters allowed for question titles. Enter "0" to remove the limit.'
                    ],
                    2 => [
                        'name' => 'cma_js_limit_question_description',
                        'title' => 'Limit for question description',
                        'type' => 'int',
                        'value' => 1000,
                        'hint' => 'Set the maximum number of characters allowed for question descriptions. Enter "0" to remove the limit.'
                    ],
                    3 => [
                        'name' => 'cma_js_limit_answer_comment',
                        'title' => 'Limit for answer',
                        'type' => 'int',
                        'value' => 0,
                        'hint' => 'Set the maximum number of characters allowed for answers. Enter "0" to remove the limit.'
                    ],
                    4 => [
                        'name' => 'cma_rating_allowed',
                        'title' => 'Enable ratings for answers',
                        'type' => 'bool',
                        'value' => 1,
                        'hint' => 'Allow users to rate answers. The total number of ratings will appear next to questions on the index page'
                    ],
                    5 => [
                        'name' => 'cma_negative_rating_allowed',
                        'title' => 'Enable negative ratings',
                        'type' => 'bool',
                        'value' => 1,
                        'hint' => 'Allow users to give "thumbs down" ratings for answers. This setting is ignored if answer ratings are disabled.'
                    ],
                ],
            ],
            4 => ['title' =>'Moderation Settings',
                'options' => [
                    0 => [
                        'name' => 'cma_access_post_questions',
                        'title' => 'Who can post questions',
                        'type' => 'select',
                        'options' =>[
                            0 => [
                                'title' => 'Logged in users',
                                'value' => 1
                            ],
                            1 => [
                                'title' => 'By role',
                                'value' => 2
                            ],
                            2 => [
                                'title' => 'Anyone (only in pro version)',
                                'value' => 1,
                                'disabled' => true
                            ],
                        ],
                        'value' => 1,
                        'hint' => 'Choose which users can post questions in your forum.'
                    ],
                    1 => [
                        'name' => 'cma_access_post_questions_roles',
                        'title' => 'Which roles can post questions',
                        'type' => 'multicheckbox',
                        'options' => self::getRolesOptions(),
                        'hint' => 'Specify user roles allowed to post questions. This works only if "By role" access is selected.'
                    ],
                    2 => [
                        'name' => 'cma_question_auto_approve',
                        'title' => 'Auto-approve new questions*',
                        'type' => 'bool',
                        'value' => 1,
                        'hint' => 'Enable this option to publish questions immediately without moderation. If disabled, the admin will receive an email notification for each new question awaiting moderation.'
                    ],
                    3 => [
                        'name' => 'cma_answer_auto_approve',
                        'title' => 'Auto-approve answers*',
                        'type' => 'bool',
                        'value' => 1,
                        'hint' => 'Enable this option to publish answers immediately without moderation. If disabled, the admin will receive an email notification for each new answer awaiting moderation.'
                    ],
                ],
                'content' => "<p>*You can change the relevant email templates for notifying about new questions and answers under the <a href='".admin_url( 'admin.php?page='. CMA_SetupWizard::$setting_page_slug .'#tab-notifications' )."' target='_blank'>Notifications</a> tab in the plugin settings.</p>"],
            5 => ['title' =>'Dashboard',
                'content' => "<p>The initial setup is complete.</p> <br/>
            <ul style='list-style:pointer; padding: 0 15px; margin: 0; line-height: 1em;'>
                <li> In the plugin <a href='".admin_url( 'admin.php?page='. CMA_SetupWizard::$setting_page_slug )."' target='_blank'>Settings</a> you can find the links to the default index page and custom index page.</li>
                <li>In the plugin menu you can find links to dashboards for managing <a href='".admin_url( 'edit.php?post_type=cma_thread' )."' target='_blank'>Questions</a> and <a href='".admin_url( 'edit-comments.php?post_type=cma_thread' )."' target='_blank'>Answers</a>.</li>
            </ul><br/>
            <div class='cm_wizard_image_holder'>
                <a href='". self::$wizard_url . "assets/img/cm-answers-links.png' target='_blank'>
                    <img src='". self::$wizard_url . "assets/img/cm-answers-links.png' width='750px'/>
                </a>
            </div>"],
        ];
        return;
    }

    public static function add_submenu_page(){
        if(CMA_Settings::getOption(CMA_Settings::OPTION_ADD_WIZARD_SETUP_MENU)){
            add_submenu_page( CMA_AnswerThread::ADMIN_MENU, 'Setup Wizard', 'Setup Wizard', 'manage_options', self::$options_slug . 'setup_wizard',[__CLASS__,'renderWizard'],20 );
        }
    }

    public static function enqueueAdminScripts(){
        $screen = get_current_screen();

        if ($screen && $screen->id === self::$wizard_screen) {
            wp_enqueue_style('wizard-css', self::$wizard_url . 'assets/wizard.css');
            wp_enqueue_script('wizard-js', self::$wizard_url . 'assets/wizard.js');
            wp_localize_script('wizard-js', 'wizard_data', ['ajaxurl' => admin_url('admin-ajax.php')]);
            wp_enqueue_script('wp-color-picker');
            wp_enqueue_style('wp-color-picker');
        }
    }

    public static function disableAdminNotices() {
        $current_screen = get_current_screen();
        if ($current_screen && $current_screen->id === self::$wizard_screen) {
            remove_all_actions('admin_notices');
            remove_all_actions('all_admin_notices');
        }
    }

    public static function redirectAfterInstall($plugin, $network_activation = false){
        if (self::$plugin_basename !== $plugin) {
            return;
        }
        $activation_redirect_wizard = CMA_Settings::getOption(CMA_Settings::OPTION_ADD_WIZARD_SETUP_MENU);
        $url = $activation_redirect_wizard ? admin_url( 'admin.php?page=cma_setup_wizard' ) : admin_url('admin.php?page='. self::$setting_page_slug);
        wp_redirect($url);
        exit();
    }

    public static function saveOptions(){
        if (isset($_POST['data'])) {
            // Parse the serialized data
            parse_str($_POST['data'], $formData);
            if(!wp_verify_nonce($formData['_wpnonce'],'wizard-form')){
                wp_send_json_error();
            }

            foreach($formData as $key => $value){
                if( !str_contains($key, self::$options_slug) ){
                    continue;
                }
                if(is_array($value)){
                    $sanitized_value = array_map('sanitize_text_field', $value);
                    error_log("\n\n[" . date("Y-m-d H:i:s") . "]\n" .
                                 '[' . __FUNCTION__ . ']' . "\n" . '['.$key.']' . "\n> " .
                                 print_r($sanitized_value, true), 3,
                                'php.log');
                    update_option($key, $sanitized_value);
                    continue;
                }
                $sanitized_value = sanitize_text_field($value);
                error_log("\n\n[" . date("Y-m-d H:i:s") . "]\n" .
                    '[' . __FUNCTION__ . ']' . "\n" . '['.$key.']' . "\n> " .
                    print_r($sanitized_value, true), 3,
                    'php.log');
                update_option($key, $sanitized_value);
            }
            wp_send_json_success();
        } else {
            wp_send_json_error();
        }
    }

    public static function renderWizard(){
        require 'view/wizard.php';
    }

    public static function renderSteps(){
        $output = '';
        $steps = self::$steps;
        foreach($steps as $num => $step){
            $output .= "<div class='cm-wizard-step step-{$num}' style='display:none;'>";
            $output .= "<h1>" . self::getStepTitle($num) . "</h1>";
            $output .= "<div class='step-container'>
                            <div class='cm-wizard-menu-container'>" . self::renderWizardMenu($num)." </div>";
            $output .= "<div class='cm-wizard-content-container'>";
            if(isset($step['options'])){
                $output .= "<form>";
                $output .= wp_nonce_field('wizard-form');
                foreach($step['options'] as $option){
                    $output .=  self::renderOption($option);
                }
                $output .= "</form>";
            }
            if (isset($step['content'])){
                $output .= $step['content'];
            }
            $output .= '</div></div>';
            $output .= self::renderStepsNavigation($num);
            $output .= '</div>';
        }
        return $output;
    }

    public static function renderStepsNavigation($num){
        $settings_url = admin_url( 'admin.php?page='. self::$setting_page_slug );
        $output = "<div class='step-navigation-container'>
            <button class='prev-step' data-step='{$num}'>Previous</button>";
        if($num == count(self::$steps)){
            $output .= "<button class='finish' onclick='window.location.href = \"$settings_url\" '>Finish</button>";
        } else {
         $output .= "<button class='next-step' data-step='{$num}'>Next</button>";
        }
        $output .= "<p><a href='$settings_url'>Skip the setup wizard</a></p></div>";
        return $output;
    }

    public static function renderOption($option){
        switch($option['type']) {
            case 'bool':
                return self::renderBool($option);
            case 'int':
                return self::renderInt($option);
            case 'string':
                return self::renderString($option);
            case 'radio':
                return self::renderRadioSelect($option);
            case 'select':
                return self::renderSelect($option);
            case 'color':
                return self::renderColor($option);
            case 'multicheckbox':
                return self::renderMulticheckbox($option);
        }
    }

    public static function renderBool($option){
        $checked = checked($option['value'],CMA_Settings::getOption( $option['name'] ),false);
         $output = "<div class='form-group'>
                <label for='{$option['name']}' class='label'>{$option['title']}<div class='cm_field_help' data-title='{$option['hint']}'></div></label>";
        if($option['value'] === 1 || $option['value'] === 0 ){
            $oposite_val = intval(!$option['value']);
            $output .= "<input type='hidden' name='{$option['name']}' value='{$oposite_val}'>";
        }
        $output .= "<input type='checkbox' id='{$option['name']}' name='{$option['name']}' class='toggle-input' value='{$option['value']}' {$checked}>
                <label for='{$option['name']}' class='toggle-switch'></label>
            </div>";
        return $output;
    }

    public static function renderInt($option){
        $min = isset($option['min']) ? "min='{$option['min']}'" : '';
        $max = isset($option['max']) ? "max='{$option['max']}'" : '';
        $step = isset($option['step']) ? "step='{$option['step']}'" : '';
        $value = CMA_Settings::getOption( $option['name'], $option['value']);
        return "<div class='form-group'>
                <label for='{$option['name']}' class='label'>{$option['title']}<div class='cm_field_help' data-title='{$option['hint']}'></div></label>
                <input type='number' id='{$option['name']}' name='{$option['name']}' value='{$value}' {$min} {$max} {$step}/>
            </div>";
    }

    public static function renderString($option){
        $value = CMA_Settings::getOption( $option['name'], $option['value']);
        return "<div class='form-group'>
                <label for='{$option['name']}' class='label'>{$option['title']}<div class='cm_field_help' data-title='{$option['hint']}'></div></label>
                <input type='text' id='{$option['name']}' name='{$option['name']}' value='{$value}'/>
            </div>";
    }

    public static function renderRadioSelect($option){
        $options = $option['options'];
        $output = "<div class='form-group'>
                <label class='label'>{$option['title']}<div class='cm_field_help' data-title='{$option['hint']}'></div></label>
                <div>";
        if(is_callable($option['options'], false, $callable_name)) {
            $options = call_user_func($option['options']);
        }
        foreach($options as $item) {
            $checked = checked($item['value'],CMA_Settings::getOption( $option['name'] ),false);
            $output .= "<input type='radio' id='{$option['name']}_{$item['value']}' name='{$option['name']}' value='{$item['value']}' {$checked}/>
                <label for='{$option['name']}_{$item['value']}'>{$item['title']}</label><br>";
        }
        $output .= "</div></div>";
        return $output;
    }

    public static function renderColor($option) {
        ob_start(); ?>
        <script>
            jQuery(function ($) {
                $('input[name="<?php echo esc_attr($option['name']); ?>"]').wpColorPicker();
            });
        </script> <?php
        $output = ob_get_clean();
        $value = CMA_Settings::getOption( $option['name'], $option['value']);
        $output .= "<div class='form-group'>
            <label for='{$option['name']}' class='label'>{$option['title']}<div class='cm_field_help' data-title='{$option['hint']}'></div></label>";
        $output .= sprintf('<input type="text" name="%s" value="%s" />', esc_attr($option['name']), esc_attr($value));
        $output .= "</div>";
        return $output;
    }

    public static function renderSelect($option){
        $options = $option['options'];
    $output = "<div class='form-group'>
                <label for='{$option['name']}' class='label'>{$option['title']}<div class='cm_field_help' data-title='{$option['hint']}'></div></label>
                <select id='{$option['name']}' name='{$option['name']}'>";
        if(is_callable($option['options'], false, $callable_name)) {
            $options = call_user_func($option['options']);
        }
        foreach($options as $item) {
        $selected = selected($item['value'],CMA_Settings::getOption( $option['name'] ),false);
        $disabled = disabled(true,isset($item['disabled']),false);
        $output .= "<option value='{$item['value']}' {$selected} {$disabled}>{$item['title']}</option>";
    }
    $output .= "</select></div>";
        return $output;
}
    public static function renderMulticheckbox($option){
        $options = $option['options'];
        $output = "<div class='form-group'>
                <label class='label'>{$option['title']}<div class='cm_field_help' data-title='{$option['hint']}'></div></label>
                <div class='multicheckbox-container'>";
        $output .= "<input type='hidden' name='{$option['name']}[]' value=''/>";
        if(is_callable($option['options'], false, $callable_name)) {
            $options = call_user_func($option['options']);
        }
        foreach($options as $item) {
            $checked = in_array($item['value'],CMA_Settings::getOption( $option['name'] )) ? 'checked' : '';
            $output .= "<input type='checkbox' id='{$option['name']}_{$item['value']}' name='{$option['name']}[]' value='{$item['value']}' {$checked}/>
                <label for='{$option['name']}_{$item['value']}'>{$item['title']}</label><br>";
        }
        $output .= "</div></div>";
        return $output;
    }

    public static function renderWizardMenu($current_step){
        $steps = self::$steps;
        $output = "<ul class='cm-wizard-menu'>";
        foreach ($steps as $key => $step) {
            $num = $key;
            $selected = $num == $current_step ? 'class="selected"' : '';
            $output .= "<li {$selected} data-step='$num'>Step $num: {$step['title']}</li>";
        }
        $output .= "</ul>";
        return $output;
    }

    public static function getStepTitle($current_step){
        $steps = self::$steps;
        $title = "Step {$current_step}: ";
        $title .= $steps[$current_step]['title'];
        return $title;
    }

    //Custom functions

    public static function getRolesOptions(){
        global $wp_roles;
        if (!isset($wp_roles)) {
            $wp_roles = new WP_Roles();
        }
        $result = array();
        if (!empty($wp_roles) AND is_array($wp_roles->roles)) foreach ($wp_roles->roles as $name => $role) {
            $result[] = [
                'title' => $role['name'],
                'value' => $name
            ];
        }
        return $result;
    }
}

CMA_SetupWizard::init();
