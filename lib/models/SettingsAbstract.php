<?php

abstract class CMA_SettingsAbstract {
	
	const TEXT_DOMAIN = '';
	
	const TYPE_BOOL = 'bool';
	const TYPE_INT = 'int';
	const TYPE_DECIMAL = 'decimal';
	const TYPE_STRING = 'string';
	const TYPE_TEXTAREA = 'textarea';
	const TYPE_RICH_TEXT = 'rich_text';
	const TYPE_RADIO = 'radio';
	const TYPE_SELECT = 'select';
	const TYPE_MULTISELECT = 'multiselect';
	const TYPE_MULTICHECKBOX = 'multicheckbox';
	const TYPE_CSV_LINE = 'csv_line';
	const TYPE_USERS_LIST = 'users_list';
	const TYPE_CUSTOM = 'custom';
	const TYPE_COLOR = 'color';
    const TYPE_RANGE = 'range';
	

	public static $categories = array();
	public static $subcategories = array();
	
	
	public static function getOptionsConfig() {
		return array();
	}
	
	
	public static function getOptionsConfigByCategory($category, $subcategory = null) {
		$options = static::getOptionsConfig();
		return array_filter($options, function($val) use ($category, $subcategory) {
			if ($val['category'] == $category) {
				return (is_null($subcategory) OR $val['subcategory'] == $subcategory);
			}
		});
	}
	
	
	public static function getOptionConfig($name) {
		$options = static::getOptionsConfig();
		if (isset($options[$name])) {
			return $options[$name];
		}
	}
	
	
	public static function setOption($name, $value) {
		$options = static::getOptionsConfig();
		if (isset($options[$name])) {
			$field = $options[$name];
			if(strpos($name,'notification') && in_array($field['type'],[static::TYPE_STRING,static::TYPE_TEXTAREA])){
                $value = esc_attr($value);
			}
			$value = static::cast($value, $field['type']);
			if (apply_filters('cma_before_update_option', true, $name, $value, $field)) {
				update_option($name, $value);
			}
			if (isset($field['afterSave']) AND is_callable($field['afterSave'])) {
				call_user_func($field['afterSave'], $field);
			}
		}
	}
	

	public static function getOption($name) {
		$options = static::getOptionsConfig();
		if (isset($options[$name])) {
			$field = $options[$name];
			$defaultValue = (isset($field['default']) ? $field['default'] : null);
			return static::cast(get_option($name, $defaultValue), $field['type'], $defaultValue);
		}

		return null;
	}
	
	
	public static function getCategories() {
		return static::$categories;
	}
	
	
	public static function getSubcategories($category = null) {
		if (is_null($category)) {
			return static::$subcategories;
		}
		else if (isset(static::$subcategories[$category])) {
			return static::$subcategories[$category];
		} else {
			return array();
		}
	}
	
	
	protected static function boolval($val) {
		return (boolean) $val;
	}
	
	
	protected static function arrayval($val) {
		if (is_array($val)) return $val;
		else if (is_object($val)) return (array)$val;
		else return array();
	}
	
	
	protected static function cast($val, $type, $defaultValue = null) {
		if ($type == static::TYPE_STRING) {
			return esc_attr(trim(strval($val)));
		}
		else if ($type == static::TYPE_BOOL) {
			return (intval($val) ? 1 : 0);
		}
		else if (in_array($type, array(static::TYPE_MULTISELECT, static::TYPE_USERS_LIST, static::TYPE_MULTICHECKBOX))) {
			if (empty($val)) return array();
			else return $val;
		}
		else if ($type == static::TYPE_RADIO) {
			if (is_null($val)) {
				$val = $defaultValue;
			}
			return $val;
		}
		else {
			$castFunction = $type . 'val';
			if (function_exists($castFunction)) {
				return call_user_func($castFunction, $val);
			}
			else if (method_exists(__CLASS__, $castFunction)) {
				return call_user_func(array(__CLASS__, $castFunction), $val);
			} else {
				return $val;
			}
		}
	}
	
	
	protected static function csv_lineval($value) {
		if (!is_array($value)) $value = explode(',', $value);
		return $value;
	}
	
	
	public static function processPostRequest() {
		do_action('cma_settings_save');
		$options = static::getOptionsConfig();
		$post = array_map('stripslashes_deep', $_POST);
		foreach ($options as $name => $optionConfig) {
		    if(isset($optionConfig['onlyin'])){
		        continue;
            }
			static::setOption($name, isset($post[$name]) ? $post[$name] : null);
		}
		update_option('cmaer_email_piping_category', isset($post['cmaer_email_piping_category']) ? $post['cmaer_email_piping_category'] : array('0' => ''));
	}
	
	
	public static function userId($userId = null) {
		if (empty($userId)) $userId = get_current_user_id();
		return $userId;
	}
	
	
	public static function isLoggedIn($userId = null) {
		$userId = static::userId($userId);
		return !empty($userId);
	}
	
	
	public static function getRolesOptions() {
		global $wp_roles;
		$result = array();
		if (!empty($wp_roles) AND is_array($wp_roles->roles)) foreach ($wp_roles->roles as $name => $role) {
			$result[$name] = $role['name'];
		}
		return $result;
	}
	
	
	public static function getPagesOptions() {
		$pages = get_pages(array('number' => 100));
		$result = array(null => '--');
		if (is_array($pages)) foreach ($pages as $page) {
			$result[$page->ID] = $page->post_title;
		}
		return $result;
	}
	

	static function writeLocalizationFile() {
		
		$added = array();
		$textDomain = static::TEXT_DOMAIN;
		$printLine = function($text) use ($textDomain, &$added) {
			if (is_numeric($text)) return;
			if (empty($added[$text])) {
				$added[$text] = true;
				printf('# @ %s'. PHP_EOL .'msgid "%s"'. PHP_EOL .'msgstr "%s"'. PHP_EOL . PHP_EOL,
					$textDomain,
					str_replace('"', '\"', $text),
					str_replace('"', '\"', $text)
				);
			}
		};
		
		$config = static::getOptionsConfig();
		foreach ($config as $optionName => $option) {
			$printLine($option['title']);
			if (!empty($option['desc'])) {
				$printLine($option['desc']);
			}
			if (!empty($option['options']) AND is_array($option['options'])) {
				foreach ($option['options'] as $optionLabel) {
					$printLine($optionLabel);
				}
			}
		}
		
		foreach (static::$categories as $key => $category) {
			$printLine($category);
			if (isset(static::$subcategories[$key])) {
				foreach (static::$subcategories[$key] as $subcategory) {
					$printLine($subcategory);
				}
			}
		}
		
	}
	
	static function __($msg) {
		return __($msg, static::TEXT_DOMAIN);
	}
	
	
}
