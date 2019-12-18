<?php
namespace App\Services;

use Symfony\Component\HttpFoundation\RequestStack;

class LanguagesService
{
    private $request;
    private $headers;
    private $languages;

    public function __construct(RequestStack $request)
    {
        $this->request = $request->getCurrentRequest();
        $this->headers = $this->request->headers;

        $this->setLanguages();
    }

    private function setLanguages()
    {
        $languagesString = $this->headers->get('accept-language');
        $languages = [];

        if (null != $languagesString)
        {
            $languagesArray = explode(",", $languagesString);

            foreach ($languagesArray as $key => $value) 
            {
                $data = explode(";", $value);

                $score = 0;
                $locale = null;
                $region = null;

                // Language score
                // --

                if (isset($data[1]))
                {
                    $score = preg_replace("/q=/", null, $data[1]);
                }

                if ($key == 0 && $score == 0) 
                {
                    $score = 1;
                }

                // Language
                // --

                if (isset($data[0]))
                {
                    $language = $data[0];
                }

                // Region & Locale
                // --

                $data = explode("-", $language);

                if (isset($data[1]))
                {
                    $region = $data[1];
                }
                if (isset($data[0]))
                {
                    $locale = $data[0];
                }

                array_push($languages, [
                    'score' => $score,
                    'language' => $language,
                    'locale' => $locale,
                    'region' => $region,
                ]);
            }
        }

        $this->languages = $languages;

        return $this;
    }

    public function getAcceptedLanguages()
    {
        return $this->languages;
    }

    public function getMainLanguage()
    {
        return $this->languages[0] ?? null;
    }
    public function getMainLocale()
    {
        return $this->languages[0]['locale'] ?? null;
    }
    public function getMainRegion()
    {
        return $this->languages[0]['region'] ?? null;
    }
}