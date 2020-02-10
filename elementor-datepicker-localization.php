<?php
/**
 * Plugin Name: Elementor Datepicker Localization
 * Plugin URI: https://github.com/creame/elementor-datepicker-localization/
 * Description: Load current site locale for Elementor form datepicker.
 * Version: 1.1.0
 * Author: Creame
 * Author URI: https://crea.me
 */

class ElementorDatepickerLocalization {

	private $locale;
	private $format;
	private $time24;

	function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	function init() {
		$this->locale = apply_filters( 'elementor/datepicker/locale', $this->get_locale() );
		$this->format = apply_filters( 'elementor/datepicker/format', 'Y-m-d' );
		$this->time24 = apply_filters( 'elementor/datepicker/24h', false ) ? 'true' : 'false';

		if ( 'default' !== $this->locale ) {
			// Register script
			add_action( 'wp_enqueue_scripts', array( $this, 'script_register' ) );
			// Enqueue if date field is present
			add_filter( 'elementor_pro/forms/render/item/date', array( $this, 'script_enqueue' ) );
		}
		// Apply locale and format
		add_action( 'wp_footer', array( $this, 'datepicker_settings' ), 99 );
	}

	function script_register() {
		wp_register_script( 'flatpickr_localize', "https://npmcdn.com/flatpickr/dist/l10n/{$this->locale}.js", [ 'flatpickr' ] );
	}

	function script_enqueue( $item ) {
		if ( ! isset( $item['use_native_date'] ) || 'yes' !== $item['use_native_date'] ) {
			wp_enqueue_script( 'flatpickr_localize' );
			remove_filter( 'elementor_pro/forms/render/item/date', array( $this, 'script_enqueue' ) );
		}

		return $item;
	}

	function datepicker_settings() {
		if ( wp_script_is( 'flatpickr', 'enqueued' ) ) {
			$lang = wp_script_is( 'flatpickr_localize', 'enqueued' ) ? str_replace( '-', '_', $this->locale ) : '';

			echo '<script>' .
				"flatpickr.setDefaults({dateFormat:'$this->format', time_24hr:$this->time24}); " .
				( $lang ? "flatpickr.localize(flatpickr.l10ns.$lang); " : '' ) .
				( 'Y-m-d' !== $this->format ? "jQuery('.elementor-date-field').removeAttr('pattern');" : '' ) .
				'</script>';
		}
	}

	function get_locale() {

		// Relation WordPress languages with flatpickr languages
		$locales = array(
			'af'             => '',   // 'Afrikaans'
			'ar'             => 'ar', // 'Arabic'
			'ary'            => 'ar', // 'Moroccan Arabic'
			'as'             => '',   // 'Assamese'
			'azb'            => 'az', // 'South Azerbaijani'
			'az'             => 'az', // 'Azerbaijani'
			'bel'            => 'be', // 'Belarusian'
			'bg_BG'          => 'bg', // 'Bulgarian'
			'bn_BD'          => 'bn', // 'Bengali (Bangladesh)'
			'bo'             => '',   // 'Tibetan'
			'bs_BA'          => 'bs', // 'Bosnian'
			'ca'             => 'cat', // 'Catalan'
			'ceb'            => '',   // 'Cebuano'
			'cs_CZ'          => 'cs', // 'Czech'
			'cy'             => 'cy', // 'Welsh'
			'da_DK'          => 'da', // 'Danish'
			'de_CH_informal' => 'de', // 'German (Switzerland, Informal)'
			'de_CH'          => 'de', // 'German (Switzerland)'
			'de_DE'          => 'de', // 'German'
			'de_DE_formal'   => 'de', // 'German (Formal)'
			'de_AT'          => 'de', // 'German (Austria)'
			'dzo'            => '',   // 'Dzongkha'
			'el'             => 'gr', // 'Greek'
			'en_GB'          => 'en', // 'English (UK)'
			'en_AU'          => 'en', // 'English (Australia)'
			'en_CA'          => 'en', // 'English (Canada)'
			'en_ZA'          => 'en', // 'English (South Africa)'
			'en_NZ'          => 'en', // 'English (New Zealand)'
			'eo'             => 'eo', // 'Esperanto'
			'es_CL'          => 'es', // 'Spanish (Chile)'
			'es_ES'          => 'es', // 'Spanish (Spain)'
			'es_MX'          => 'es', // 'Spanish (Mexico)'
			'es_GT'          => 'es', // 'Spanish (Guatemala)'
			'es_CR'          => 'es', // 'Spanish (Costa Rica)'
			'es_CO'          => 'es', // 'Spanish (Colombia)'
			'es_PE'          => 'es', // 'Spanish (Peru)'
			'es_VE'          => 'es', // 'Spanish (Venezuela)'
			'es_AR'          => 'es', // 'Spanish (Argentina)'
			'et'             => 'et', // 'Estonian'
			'eu'             => 'es', // 'Basque'
			'fa_IR'          => 'fa', // 'Persian'
			'fi'             => 'fi', // 'Finnish'
			'fr_CA'          => 'fr', // 'French (Canada)'
			'fr_FR'          => 'fr', // 'French (France)'
			'fr_BE'          => 'fr', // 'French (Belgium)'
			'fur'            => '',   // 'Friulian'
			'gd'             => 'ga', // 'Scottish Gaelic'
			'gl_ES'          => 'es', // 'Galician'
			'gu'             => '',   // 'Gujarati'
			'haz'            => '',   // 'Hazaragi'
			'he_IL'          => 'he', // 'Hebrew'
			'hi_IN'          => 'hi', // 'Hindi'
			'hr'             => 'hr', // 'Croatian'
			'hsb'            => '',   // 'Upper Sorbian'
			'hu_HU'          => 'hu', // 'Hungarian'
			'hy'             => '',   // 'Armenian'
			'id_ID'          => 'id', // 'Indonesian'
			'is_IS'          => 'is', // 'Icelandic'
			'it_IT'          => 'it', // 'Italian'
			'ja'             => 'ja', // 'Japanese'
			'jv_ID'          => '',   // 'Javanese'
			'ka_GE'          => 'ka', // 'Georgian'
			'kab'            => '',   // 'Kabyle'
			'kk'             => 'kz', // 'Kazakh'
			'km'             => 'km', // 'Khmer'
			'kn'             => '',   // 'Kannada'
			'ko_KR'          => 'ko', // 'Korean'
			'ckb'            => '',   // 'Kurdish (Sorani)'
			'lo'             => '',   // 'Lao'
			'lt_LT'          => 'lt', // 'Lithuanian'
			'lv'             => 'lv', // 'Latvian'
			'mk_MK'          => 'mk', // 'Macedonian'
			'ml_IN'          => '',   // 'Malayalam'
			'mn'             => 'mn', // 'Mongolian'
			'mr'             => '',   // 'Marathi'
			'ms_MY'          => 'ms', // 'Malay'
			'my_MM'          => 'my', // 'Myanmar (Burmese)'
			'nb_NO'          => 'no', // 'Norwegian (Bokmål)'
			'ne_NP'          => '',   // 'Nepali'
			'nl_NL'          => 'nl', // 'Dutch'
			'nl_NL_formal'   => 'nl', // 'Dutch (Formal)'
			'nl_BE'          => 'nl', // 'Dutch (Belgium)'
			'nn_NO'          => 'no', // 'Norwegian (Nynorsk)'
			'oci'            => '',   // 'Occitan'
			'pa_IN'          => 'pa', // 'Punjabi'
			'pl_PL'          => 'pl', // 'Polish'
			'ps'             => '',   // 'Pashto'
			'pt_BR'          => 'pt', // 'Portuguese (Brazil)'
			'pt_AO'          => 'pt', // 'Portuguese (Angola)'
			'pt_PT'          => 'pt', // 'Portuguese (Portugal)'
			'pt_PT_ao90'     => 'pt', // 'Portuguese (Portugal, AO90)'
			'rhg'            => '',   // 'Rohingya'
			'ro_RO'          => 'ro', // 'Romanian'
			'ru_RU'          => 'ru', // 'Russian'
			'sah'            => '',   // 'Sakha'
			'si_LK'          => 'si', // 'Sinhala'
			'sk_SK'          => 'sk', // 'Slovak'
			'skr'            => '',   // 'Saraiki'
			'sl_SI'          => 'sl', // 'Slovenian'
			'sq'             => 'sq', // 'Albanian'
			'sr_RS'          => 'sr', // 'Serbian'
			'sv_SE'          => 'sv', // 'Swedish'
			'sw'             => '',   // 'Swahili'
			'szl'            => '',   // 'Silesian'
			'ta_IN'          => '',   // 'Tamil'
			'te'             => '',   // 'Telugu'
			'th'             => 'th', // 'Thai'
			'tl'             => '',   // 'Tagalog'
			'tr_TR'          => 'tr', // 'Turkish'
			'tt_RU'          => '',   // 'Tatar'
			'tah'            => '',   // 'Tahitian'
			'ug_CN'          => '',   // 'Uighur'
			'uk'             => 'uk', // 'Ukrainian'
			'ur'             => '',   // 'Urdu'
			'uz_UZ'          => '',   // 'Uzbek'
			'vi'             => 'vn', // 'Vietnamese'
			'zh_HK'          => 'zh', // 'Chinese (Hong Kong)'
			'zh_TW'          => 'zh-tw', // 'Chinese (Taiwan)'
			'zh_CN'          => 'zh', // 'Chinese (China)'
		);

		$wp_locale = get_locale();

		$locale = array_key_exists( $wp_locale, $locales ) ? $locales[ $wp_locale ] : 'default';

		// English or none use default (en) lang
		if ( $locale === 'en' || $locale === '' ) {
			$locale = 'default';
		}

		return $locale;
	}

}

$elementor_datepickr_localization = new ElementorDatepickerLocalization();
