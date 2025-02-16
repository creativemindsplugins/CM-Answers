<?php

class CMA_Labels {
	
	const FILENAME = 'labels.tsv';
	const OPTION_LABEL_PREFIX = 'cma_label_';

	protected static $labels = [];
	protected static $labelsByCategories = [];
	protected static $available_labels = [
	    'Questions',
	    'Question',
	    'Answers',
	    'Answer',
	    'index_page_title',
	    'asked_on',
	    'asked_on_by',
	    'answered_on',
	    'update_on_by',
	    'update_on',
	    'RESOLVED',
        'votes_col',
        'views_col',
	    'votes',
	    'vote',
	    'view',
	    'views',
	    'cma_thank_you_for_voting',
	    'cma_you_cannot_vote',
	    'cma_you_cannot_vote_again',
	    'second_ago',
	    'seconds_ago',
	    'minute_ago',
	    'minutes_ago',
	    'hour_ago',
	    'hours_ago',
	    'day_ago',
	    'days_ago',
	    'week_ago',
	    'weeks_ago',
	    'month_ago',
	    'months_ago',
	    'year_ago',
	    'years_ago',
	    'ask_a_question',
	    'post_your_answer',
	    'enter_question_title',
	    'enter_question_content',
	    'enter_question_content_optional',
	    'answer_input_label',
	    'notify_me_of_follow',
	    'mark_as_resolved',
	    'msg_post_question_success',
	    'msg_post_question_moderation',
	    'error_question_title_too_long',
	    'error_question_content_too_long',
	    'error_answer_content_too_long',
	    'add_answer_success',
	    'add_answer_held_for_moderation',
	    'cma_content_cannot_be_empty',
	    'cma_posted_by_label',
	    'button_post_your_answer',
	    'button_add_question',
	    'orderby_newest',
	    'orderby_hottest',
	    'orderby_votes',
	    'orderby_views',
	    'orderby_highest_rating',
	    'back_to_previous_page',
	    'please_login_to_post_questions',
	    'register_link',
    ];


	public static function bootstrap() {

		self::loadLabelFile();
		do_action('cma_labels_init');

		/* You can use the following filters to add new labels for CMA:
		add_filter('cma_labels_init_labels', function($labels) {
			$labels['label_name'] = array('default' => 'Value', 'desc' => 'Description', 'category' => 'Other');
			return $labels;
		});
		add_filter('cma_labels_init_labels_by_categories', function($labelsByCategories) {
			$labelsByCategories['Other'][] = 'label_name';
			return $labelsByCategories;
		});
		*/

		self::$labels = apply_filters('cma_labels_init_labels', self::$labels);
		self::$labelsByCategories = apply_filters('cma_labels_init_labels_by_categories', self::$labelsByCategories);

	}


	public static function getLabel($labelKey) {
		$labelKey = static::normalizeLabelKey($labelKey);
		$optionName = self::OPTION_LABEL_PREFIX . $labelKey;
		$default = self::getDefaultLabel($labelKey);
		$result = get_option($optionName);
		if ($result === false OR is_null($result)) {
// 			$result = (empty($default) ? $labelKey : $default);
			$result = $default;
		}
		return apply_filters('cma_get_label_filter', $result, $labelKey, $optionName, $default);
	}


	static function normalizeLabelKey($labelKey) {
		return preg_replace('~[^a-z0-9]~i', '_', strip_tags($labelKey));
	}

	public static function setLabel($labelKey, $value) {
		$optionName = self::OPTION_LABEL_PREFIX . $labelKey;
        $value = esc_attr($value);
		if (strlen($value) == 0) $value = self::getDefaultLabel($labelKey);
		update_option($optionName, $value);
	}

	public static function getLocalized($labelKey) {
		return __(self::getLabel($labelKey), 'cm-answers-pro');
	}


	public static function n($singularLabelKey, $pluralLabelKey, $number) {
		return _n($singularLabelKey, $pluralLabelKey, $number, CMA::TEXT_DOMAIN);
	}


	public static function getDefaultLabel($key) {
		if ($label = self::getLabelDefinition($key)) {
			return $label['default'];
		} else {
			return $key;
		}
	}


	public static function getDescription($key) {
		if ($label = self::getLabelDefinition($key)) {
			return $label['desc'];
		}
	}


	public static function getLabelDefinition($key) {
		$labels = self::getLabels();
		return (isset($labels[$key]) ? $labels[$key] : NULL);
	}

    public static function isAvailable($key){
        if( in_array($key, self::$available_labels)){
            return true;
        }
        return false;
    }


	public static function getLabels() {
		return self::$labels;
	}


	public static function getLabelsByCategories() {
		return self::$labelsByCategories;
	}
	

	public static function getDefaultLabelsPath() {
		return dirname(__FILE__) .'/'. self::FILENAME;
	}


	public static function loadLabelFile($path = null, $prefix = '') {
		$file = explode("\n", file_get_contents(empty($path) ? self::getDefaultLabelsPath() : $path));
		foreach ($file as $row) {
			$row = explode("\t", trim($row));
			if (count($row) >= 2) {
				$label = array(
					'default' => $row[1],
					'desc' => (isset($row[2]) ? $row[2] : null),
					'category' => (isset($row[3]) ? $row[3] : null),
				);
				$key = $prefix . static::normalizeLabelKey($row[0]);
				self::$labels[$key] = $label;
				self::$labelsByCategories[$label['category']][] = $key;
			}
		}
    }

}

add_action('cma_load_label_file', array('CMA_Labels', 'loadLabelFile'), 1);
