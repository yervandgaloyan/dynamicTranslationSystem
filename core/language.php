<?php

include_once "settings.php";

class Language extends Settings{

    // Return selected language
    public function getSelectedLanguage() : string
    {
        if(!isset($_COOKIE['language']))
            return parent::getConfigByName('defaultLanguage');
        return $_COOKIE['language'];
    }

    // Set language
    public function setLanguage(string $lang = null) : int
    {
        if(is_null($lang)) return -1;
        if(!$this->isLanguageAvailable($lang)) return 0;
        setcookie("language", $lang, 2147483647, "/");
        return 1;
    }

    // Set default language
    public function setDefaultLanguage(string $langCode = null) : int
    {
        if(is_null($langCode)) return -1;
        if(!$this->isLanguageAvailable($langCode)) return -2;
        return parent::setConfig('defaultLanguage', $langCode) ? 1 : 0;
    }    
    
    // Set default language
    public function getDefaultLanguage() : string
    {
        return parent::getConfigByName('defaultLanguage');
    }
    // return all available languages
    public function getAvailableLanguages() : array
    {
        return parent::getConfigByName('availableLanguages');
    }
    
    // Add language
    public function addLanguage(string $langCode = null, string $langName = null) : int
    {
        if(is_null($langCode) || is_null($langName)) return -1;
        if($this->isLanguageAvailable($langCode)) return -2;
        $availableLanguages = $this->getAvailableLanguages();
        $availableLanguages += array($langCode => $langName);
        // parent::setTranslationsToDB();
        // print_r($availableLanguages);
       
        return parent::setConfig('availableLanguages', $availableLanguages) ? 1 : 0;
    }
    // Remove language from available languages
    public function removeLanguage(string $langCode = null) : int
    {
        if(is_null($langCode)) return -1;
        if(!$this->isLanguageAvailable($langCode)) return -2;
        $availableLanguages = $this->getAvailableLanguages();
        unset($availableLanguages[$langCode]);
        return parent::setConfig('availableLanguages', $availableLanguages) ? 1 : 0;
    }
    // Return 1 if available, 0 if not.
    function isLanguageAvailable(String $lang = null) : int
    {
        if(is_null($lang)) return -1;
        if(array_key_exists($lang, $this->getAvailableLanguages())) return 1;
        return 0;
    }
}
// $lang = new Language;
// $lang->addLanguage('efnddd', 'English');

// print_r(json_decode('{"hy":"Հայերեն","ru":"RUSSIAN","en":"English"}', true));
// $lang->removeLanguage('en');
// print_r($lang->getAvailableLanguages());
// echo $lang->setLanguage("hy");
// $availableLanguages = $lang->getAvailableLanguages();
// echo $lang->isLanguageAvailable('edn');

// echo $lang->setDefaultLanguage('hy');
// echo $lang->getDefaultLanguage();
?>