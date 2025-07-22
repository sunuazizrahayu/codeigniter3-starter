<?php
/**
 * Override `lang` function to return `key` when translation not found
 */
if ( ! function_exists('lang'))
{
	/**
	 * Lang
	 *
	 * Fetches a language variable and optionally outputs a form label
	 *
	 * @param	string	$line		The language line
	 * @param	string	$for		The "for" value (id of the form element)
	 * @param	array	$attributes	Any additional HTML attributes
	 * @return	string
	 */
	function lang($key, $for = '', $attributes = array())
	{
		$line = get_instance()->lang->line($key);
		if ($line === FALSE) {
			$line = $key;
		}

		if ($for !== '')
		{
			$line = '<label for="'.$for.'"'._stringify_attributes($attributes).'>'.$line.'</label>';
		}

		return $line;
	}
}

// ------------------------------------------------------------------------
/**
 * Auto translation with Google-Translate
 * Source: https://github.com/stichoza/google-translate-php
 * Execute: `composer require stichoza/google-translate-php:^4.1`
 */
if (!function_exists('translate')) {
	function translate($words, $to_lang=null, $from_lang=null)
	{
		$CI =& get_instance();
		$to_lang = $to_lang ?? $CI->config->item('language_abbr');

		$CI->load->driver('cache');
		$cache_key = 'translate_'.$to_lang.'_'.$words;
		$cache_data = $CI->cache->file->get($cache_key);
		if (!$cache_data) {
			try {
				//get new data of translation
				$tr = new \Stichoza\GoogleTranslate\GoogleTranslate();
				$tr->setSource($from_lang);
				$tr->setTarget($to_lang);
				$translation = $tr->translate($words);

				//save translation to cache
				$cache_data = $translation;
				$CI->cache->file->save($cache_key, $cache_data, 3600);
			} catch (Exception $e) {
				return $words;
			}
		}

		return $cache_data;
	}
}