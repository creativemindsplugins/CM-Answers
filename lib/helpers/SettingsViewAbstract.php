<?php

abstract class CMA_SettingsViewAbstract {
	
	protected $categories = array();
	protected $subcategories = array();
	
	
	
	public function render() {
		$result = '';
		$categories = $this->getCategories();
		foreach ($categories as $category => $title) {
			$result .= $this->renderCategory($category);
		}
		return $result;
	}
	
	
	
	public function renderCategory($category) {
		$result = '';
		$subcategories = $this->getSubcategories();
		if (!empty($subcategories[$category])) {
			foreach ($subcategories[$category] as $subcategory => $title) {
				$result .= $this->renderSubcategory($category, $subcategory);
			}
		}
		return '<div class="settings_'. $category .'"><div class="cm-settings-collapse-toggle">Toggle all</div>'. $result .'</div>';
	}
	
	
	abstract protected function getCategories();
	
	
	abstract protected function getSubcategories();
	
	
	
	public function renderSubcategory($category, $subcategory, $onlyContent = false) {
		$result = '';
		$subcategories = $this->getSubcategories();
		if (isset($subcategories[$category]) AND isset($subcategories[$category][$subcategory])) {
			$options = CMA_Settings::getOptionsConfigByCategory($category, $subcategory);
			foreach ($options as $name => $option) {
				$result .= $this->renderOption($name, $option);
			}
		}
		
		$result = apply_filters('cma_settings_render_subcategory_content', $result, $category, $subcategory);
		
		if ($onlyContent) return $result;
		else return apply_filters('cma_settings_render_subcategory', sprintf(
			'<div class="cma-settings-section %s">
				<h3 class="cm-settings-collapse-btn">
					<span class="dashicons dashicons-arrow-right"></span>
					<strong>%s</strong>
				</h3>
				<div class="cm-settings-collapse-container cm-settings-collapse-close">
					%s
				</div>
			</div>',
			'settings_'. $category .'_'. $subcategory,
			esc_html($this->getSubcategoryTitle($category, $subcategory)),
			$result
		), $category, $subcategory);
	}
	
	
	public function renderOption($name, array $option = array()) {
		if (empty($option)) $option = CMA_Settings::getOptionConfig($name);
	    $class = isset($option['class']) ? $option['class'] : '';
	    $display = isset($option['display']) ? ' style="display: none" ' : '';
		$result = $this->renderOptionTitle($option)
				. $this->renderOptionControls($name, $option)
				. $this->renderOptionDescription($option);
		return sprintf('<div class="cm-settings-row %s" %s>%s</div>', $class, $display, $result);
	}
	
	
	public function renderOptionTitle($option) {
		return sprintf('<div class="cm-settings-option-name">%s:</div>', CMA_Settings::__($option['title']));
	}
	
	public function renderOptionControls($name, array $option = array()) {
		if (empty($option)) $option = CMA_Settings::getOptionConfig($name);
		$result = '';
        $disabled = isset($option['onlyin']) && $option['onlyin']== 'Pro' ? 'disabled' : '';
		switch ($option['type']) {
			case CMA_Settings::TYPE_BOOL:
				$result = $this->renderBool($name,$disabled);
				break;
			case CMA_Settings::TYPE_INT:
				$result = $this->renderInputNumber($name,$disabled);
				break;
			case CMA_Settings::TYPE_DECIMAL:
				$result = $this->renderInputDecimal($name,$disabled);
				break;
			case CMA_Settings::TYPE_TEXTAREA:
				$result = $this->renderTextarea($name,$disabled);
				break;
			case CMA_Settings::TYPE_RICH_TEXT:
				$result = $this->renderRichText($name,$disabled);
				break;
			case CMA_Settings::TYPE_RADIO:
				$result = '<div class="multiline">' . $this->renderRadio($name, $option['options'],null,$disabled) . '</div>';
				break;
			case CMA_Settings::TYPE_SELECT:
				$result = $this->renderSelect($name, $option['options'],null,$disabled);
				break;
			case CMA_Settings::TYPE_MULTISELECT:
				$result = $this->renderMultiSelect($name, $option['options'],null,$disabled);
				break;
			case CMA_Settings::TYPE_MULTICHECKBOX:
				$result = $this->renderMultiCheckbox($name, $option['options'],null,$disabled);
				break;
			case CMA_Settings::TYPE_CSV_LINE:
				$result = $this->renderCSVLine($name,$disabled);
				break;
			case CMA_Settings::TYPE_COLOR:
				$result = $this->renderInputColor($name,$disabled);
				break;
			case CMA_Settings::TYPE_USERS_LIST:
				$result = $this->renderUsersList($name,$disabled);
				break;
            case CMA_Settings::TYPE_RANGE:
                $result = $this->renderRangeInput($name, $option);
                break;
			case CMA_Settings::TYPE_CUSTOM:
				$result = $this->renderCustomField($name);
				break;
			default:
				$result = $this->renderInputText($name,null,$disabled);
		}
		return sprintf('<div class="cm-settings-option-control">%s</div>', $result);
	}
	
	public function renderOptionDescription($option) {
		$result = (isset($option['desc']) ? $option['desc'] : '');
		return sprintf('<div class="cm-settings-option-desc">%s</div>', $result);
	}
	
	
	protected function renderInputText($name, $value = null,$disabled) {
		if (is_null($value)) {
			$value = CMA_Settings::getOption($name);
		}
		return sprintf('<input type="text" name="%s" value="%s" %s/>', esc_attr($name), esc_attr($value),$disabled);
	}
	
	protected function renderInputNumber($name,$disabled) {
		return sprintf('<input type="number" name="%s" value="%s" %s/>', esc_attr($name), esc_attr(CMA_Settings::getOption($name)),$disabled);
	}

    protected function renderRangeInput($name, $option,$disabled) {
	    $min = isset($option['min']) ? $option['min'] : 0;
        $max = isset($option['max']) ? $option['max'] : 1;
        $step = isset($option['step']) ? $option['step'] : 0.01;
        return sprintf(
            '<input type="range" name="%s" value="%s" min="%d" max="%d" step="%f" %s/>',
            esc_attr($name),
            esc_attr(CMA_Settings::getOption($name)),
            $min, $max, $step,$disabled
        );
    }
	
	protected function renderInputDecimal($name,$disabled) {
		$config = CMA_Settings::getOptionConfig($name);
		if (empty($config['decimalConfig'])) $config['decimalConfig'] = array();
		$decimal = shortcode_atts(array(
			'min' => '',
			'max' => '',
			'step' => 0.01,
		), $config['decimalConfig']);
		$extra = '';
		foreach ($decimal as $key => $val) {
			$extra .= ' ' . $key .'='. esc_attr($val);
		}
		return sprintf('<input type="number" name="%s" value="%s"%s %s/>', esc_attr($name), esc_attr(CMA_Settings::getOption($name)), $extra,$disabled);
	}
	
	protected function renderCSVLine($name,$disabled) {
		$value = CMA_Settings::getOption($name);
		if (is_array($value)) $value = implode(',', $value);
		return $this->renderInputText($name, $value,$disabled);
	}
	
	
	protected function renderUsersList($name,$disabled) {
		return sprintf('<div class="suggest-user" data-field-name="%s">
			<ul>%s</ul>
			<div><span>%s:</span><input type="text" %s/> <input type="button" value="%s" %s/></div>
		</div>', $name, $this->renderUsersListItems($name,$disabled), CMA_Settings::__('Find user'),$disabled, esc_attr(CMA_Settings::__('Add')),$disabled);
	}
	
	
	protected function renderUsersListItems($name,$disabled) {
		$value = CMA_Settings::getOption($name);
		if (!empty($value)) $users = get_users(array('include' => $value));
		$result = '';
		if (!empty($users)) foreach ($users as $user) {
			$result .= self::renderUsersListItem($name, $user->ID, $user->user_login,$disabled);
		}
		return $result;
	}
	
	
	static public function renderUsersListItem($name, $userId, $login,$disabled) {
        $disable = empty($disabled) ? '' : 'style="pointer-events: none"';
		$template = '<li data-user-id="%d" data-user-login="%s">
			<a href="%s" %s>%s</a> <a href="" class="btn-list-remove" %s>&times;</a>
			<input type="hidden" name="%s[]" value="%d" /></li>';
		return sprintf($template,
			intval($userId),
			$login,
			esc_attr(get_edit_user_link($userId)),
            $disable,
			esc_html($login),
            $disable,
			$name,
			intval($userId)
		);
	}
	
	
	protected function renderTextarea($name,$disabled) {
		return sprintf('<textarea name="%s" cols="60" rows="5" %s>%s</textarea>', esc_attr($name),$disabled, esc_html(CMA_Settings::getOption($name)));
	}
	
	
	protected function renderBool($name,$disabled) {
		return $this->renderRadio($name, array(1 => 'Yes', 0 => 'No'), intval(CMA_Settings::getOption($name)),$disabled);
	}
	
	
	protected function renderRadio($name, $options, $currentValue = null,$disabled) {
		if (is_null($currentValue)) {
			$currentValue = CMA_Settings::getOption($name);
		}
		$result = '';
		$fieldName = esc_attr($name);
		foreach ($options as $value => $text) {
			$fieldId = esc_attr($name .'_'. $value);
// 			$result .= var_export($currentValue);
// 			$result .= var_export($value);
			$result .= sprintf('<label><input type="radio" name="%s" id="%s" value="%s" %s %s/> %s</label>',
					$fieldName, $fieldId, esc_attr($value),
					( (string)$currentValue === (string)$value ? ' checked="checked"' : ''),
                $disabled, esc_html(CMA_Settings::__($text))
			);
		}
		return $result;
	}
	
	
	protected function renderSelect($name, $options, $currentValue = null,$disabled) {
		return sprintf('<div><select name="%s" %s>%s</select></div>', esc_attr($name), $disabled,$this->renderSelectOptions($name, $options, $currentValue));
	}
	
	
	protected function renderSelectOptions($name, $options, $currentValue = null) {
		if (is_null($currentValue)) {
			$currentValue = CMA_Settings::getOption($name);
		}
		$result = '';
		if (is_callable($options)) $options = call_user_func($options, $name);
		foreach ($options as $value => $text) {
			$result .= sprintf('<option value="%s"%s>%s</option>',
				esc_attr($value),
				( $this->isSelected($value, $currentValue) ? ' selected="selected"' : ''),
				esc_html(CMA_Settings::__($text))
			);
		}
		
		return $result;
	}
	
	
	protected function isSelected($option, $value) {
		if (is_array($value)) {
			return in_array($option, $value);
		} else {
			return ((string)$option == (string)$value);
		}
	}
	
	
	
	protected function renderMultiSelect($name, $options, $currentValue = null,$disabled) {
		return sprintf('<div><select name="%s[]" multiple="multiple" %s>%s</select></div>',
			esc_attr($name),$disabled, $this->renderSelectOptions($name, $options, $currentValue));
	}
	
	protected function renderMultiCheckbox($name, $options, $currentValue = null,$disabled) {
		$result = '';
		if (is_callable($options)) {
			$options = call_user_func($options);
		}
		foreach ($options as $value => $label) {
			$result .= $this->renderMultiCheckboxItem($name, $value, $label, $currentValue,$disabled);
		}
		return '<div>' . $result . '</div>';
	}
	
	
	protected function renderMultiCheckboxItem($name, $value, $label, $currentValue = null,$disabled) {
		if (is_null($currentValue)) $currentValue = CMA_Settings::getOption($name);
		if (!is_array($currentValue)) $currentValue = array();
		return sprintf('<div><label><input type="checkbox" name="%s[]" value="%s"%s %s/> %s</label></div>',
			esc_attr($name),
			esc_attr($value),
			(in_array($value, $currentValue) ? ' checked="checked"' : ''),
            $disabled,
			esc_html(CMA_Settings::__($label))
		);
	}
	
	protected function renderInputColor($name,$disabled) {
		return sprintf('<input type="color" name="%s" value="%s" %s/>', esc_attr($name), esc_attr(CMA_Settings::getOption($name)),$disabled);
	}
	
	
	protected function renderCustomField($name) {
		if ($config = CMA_Settings::getOptionConfig($name) AND isset($config['content'])) {
			if (is_callable($config['content'])) {
				return call_user_func($config['content'], $name, $config);
			} else {
				return $config['content'];
			}
		}
	}
		
	protected function renderRichText($name,$disabled) {
		ob_start();
		wp_editor(CMA_Settings::getOption($name), $name, array(
			'textarea_name' => $name,
			'textarea_rows' => 10,
            'editor_class' => !empty($disabled) ? 'disabled_textarea' : ''
		));
		return ob_get_clean();
	}
	
}
