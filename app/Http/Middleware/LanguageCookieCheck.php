<?php

namespace Qualifier\Http\Middleware;

use Closure;

/**
 * Class LanguageCookieCheck
 * Requires domain value from config/app.php
 *
 * @package DatabaseBrowser\Http\Middleware
 */
class LanguageCookieCheck {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $custom_lang = false;
        $lang = $request->cookie('lang');
        if (!$lang) {
            $lang = $this->getPreferredLanguage($request->header('Accept-Language'));
            if (!$lang) $lang = config('fallback_locale');
            $custom_lang = true;
        }

        app()->setLocale($lang);

        $response = $next($request);
        if (app()->getLocale() != $lang || $custom_lang) $response->withCookie(cookie()->forever('lang', app()->getLocale(), null, '.' . config('app.domain')));
//        if(app()->getLocale() != $lang || $custom_lang) \Cookie::queue('lang', app()->getLocale(), 5000, null, '.database.local');

        return $response->header('Access-Control-Allow-Credentials', 'true');
    }

    /**
     * Parses Accept-Language header for best language solution.
     * @param $header string Accept-Language string
     * @return string|null
     */
    private function getPreferredLanguage($header) {
        $langList = array();

        // break up string into pieces (languages and q factors)
        preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $header, $lang_parse);

        if (count($lang_parse[1])) {
            // create a list like "en" => 0.8
            $langList = array_combine($lang_parse[1], $lang_parse[4]);

            // set default to 1 for any without q factor
            foreach ($langList as $lang => $val) {
                if ($val === '') $langList[$lang] = 1;
            }

            // sort list based on value
            arsort($langList, SORT_NUMERIC);
        }

        $acceptedLangList = config('app.locales');
        $result = null;
        $q = 0;

        foreach ($langList as $lang => $priority) {
            if (in_array($lang, $acceptedLangList) && $priority > $q) {
                $q = $priority;
                $result = $lang;
            }
        }

        return $result;
    }
}
