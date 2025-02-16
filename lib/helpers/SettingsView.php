<?php

require_once CMA_PATH . '/lib/helpers/SettingsViewAbstract.php';

class CMA_SettingsView extends CMA_SettingsViewAbstract {


    public function renderOptionDescription($option) {
        $result = (isset($option['desc']) ? $option['desc'] : '');
        if(isset($option['onlyin'])){
            $result = self::renderOnlyin($option['onlyin']);
        }
        return sprintf('<div class="cm-settings-option-desc">%s</div>', $result);
    }

    public static function getProOnlyOptions($option){
        switch ($option){
            case 'cma_votes_mode' :
                return [ 3,4,5 ];
                break;
        }
        return [];
    }

    protected function renderRadio($name, $options, $currentValue = null,$disabled) {
        if (is_null($currentValue)) {
            $currentValue = CMA_Settings::getOption($name);
        }
        $result = '';
        $fieldName = esc_attr($name);
        $proOnly = self::getProOnlyOptions($name);
        foreach ($options as $value => $text) {
            $fieldId = esc_attr($name .'_'. $value);
            $disabled_option = !empty($proOnly) && in_array($value,$proOnly) ? 'disabled' : $disabled;
            $result .= sprintf('<label><input type="radio" name="%s" id="%s" value="%s"%s %s/> %s</label>',
                $fieldName, $fieldId, esc_attr($value),
                ( (string)$currentValue === (string)$value ? ' checked="checked"' : ''),
                $disabled_option,
                esc_html(CMA_Settings::__($text))
            );
        }
        return $result;
    }

    public static function renderOnlyin( $onlyin = 'Pro' ) {
        static $renderOnce = 0;
        ob_start();
        if ( ! $renderOnce ):
            ?>
            <style>
                .onlyinpro a {
                    color: #aaa !important;
                }

                .onlyinpro {
                    color: #aaa !important;
                }

                .cm-settings-row.hide, .onlyinpro.hide, label.hide {
                    display: none !important;
                }
                .cm-settings-row:has(.onlyinpro) > *:not(.cm-settings-option-desc){
                    opacity: 0.7;
                }
            </style>
            <?php
            $renderOnce = 1;
        endif;
        ?>
        <div class="onlyinpro">Available in <?php echo esc_attr( $onlyin ); ?> version and above. <a
                href="https://www.cminds.com/cm-answer-store-page-content/#pricing_table" target="">UPGRADE NOW&nbsp;➤</a>
        </div>
        <?php
        $content = ob_get_clean();

        return $content;
    }
	
	
	protected function getSubcategoryTitle($category, $subcategory) {
		$subcategories = $this->getSubcategories();
		if (isset($subcategories[$category]) AND isset($subcategories[$category][$subcategory])) {
			return CMA_Settings::__($subcategories[$category][$subcategory]);
		} else {
			return CMA_Settings::__($subcategory);
		}
	}
	
	
	protected function getCategories() {
		return CMA_Settings::getCategories();
	}
	
	
	protected function getSubcategories() {
		return CMA_Settings::getSubcategories();
	}
	
	
}