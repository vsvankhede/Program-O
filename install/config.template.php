<?php
/***************************************
  * http://www.program-o.com
  * PROGRAM O
  * Version: 2.4.6
  * FILE: config/global_config.php
  * AUTHOR: Elizabeth Perreau and Dave Morton
  * DATE: 12-09-2014
  * DETAILS: this file is the ONLY configuration file for the bot and bot admin
  ***************************************/
    //------------------------------------------------------------------------
    // Paths - only set this manually if the below doesnt work
    //------------------------------------------------------------------------

    $thisConfigFolder = __DIR__ . DIRECTORY_SEPARATOR;
    chdir($thisConfigFolder);
    $parentFolder = str_replace(DIRECTORY_SEPARATOR . 'config', '', $thisConfigFolder);
    $baseURL = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
    $docRoot = $_SERVER['DOCUMENT_ROOT'];
    define('_BASE_DIR_', $parentFolder);
    $path_separator = DIRECTORY_SEPARATOR;
    $thisFile = str_replace(_BASE_DIR_, '', $thisFile);
    $thisFile = str_replace($path_separator, '/', $thisFile);
    $baseURL  = str_replace($thisFile, '', $baseURL);
    define('_BASE_URL_', $baseURL);

    //------------------------------------------------------------------------
    // Define paths for include files
    //------------------------------------------------------------------------

    define('_INC_PATH_',_BASE_DIR_.$path_separator);
    define('_ADMIN_PATH_',_BASE_DIR_.'admin'.$path_separator);
    define('_SESSION_PATH_',_ADMIN_PATH_.'[session_dir]'.$path_separator);
    define('_ADMIN_URL_',_BASE_URL_.'admin/');
    define('_CAPTCHA_PATH_',_ADMIN_PATH_.'captcha-images'.$path_separator);
    define('_BOTCORE_PATH_',_BASE_DIR_.'chatbot'.$path_separator.'core'.$path_separator);
    define('_LIB_PATH_',_BASE_DIR_.'library'.$path_separator);
    define('_LIB_URL_',_BASE_URL_.'library/');
    define('_ADDONS_PATH_',_BASE_DIR_.'chatbot'.$path_separator.'addons'.$path_separator);
    define('_CONF_PATH_',_BASE_DIR_.'config'.$path_separator);
    define('_UPLOAD_PATH_',_CONF_PATH_.'uploads'.$path_separator);
    define('_LOG_PATH_',_BASE_DIR_.'logs'.$path_separator);
    define('_LOG_URL_',_BASE_URL_.'logs/');
    define('_DEBUG_PATH_',_BASE_DIR_.'chatbot'.$path_separator.'debug'.$path_separator);
    define('_DEBUG_URL_',_BASE_URL_.'chatbot/debug/');
    define('_INSTALL_PATH_',_BASE_DIR_.$path_separator.'install'.$path_separator);
    define('_INSTALL_URL_',_BASE_URL_.'install/');
    define('IS_WINDOWS',(DIRECTORY_SEPARATOR == '/') ? false : true);

    //------------------------------------------------------------------------
    // Define constants for the current version of Program O, and for the OS name and version
    //------------------------------------------------------------------------

    define ('VERSION', trim(file_get_contents(_BASE_DIR_ . 'version.txt'))); # Program O version

    $os  = php_uname('s');
    $osv = php_uname('v');
    header("x-server-os: $os - $osv");

    //------------------------------------------------------------------------
    // Error reporting
    //------------------------------------------------------------------------
    if(!(ini_get('allow_call_time_pass_reference'))){
      ini_set('allow_call_time_pass_reference', 'true');
    }

    $e_all = defined('E_DEPRECATED') ? E_ALL & ~E_DEPRECATED : E_ALL;
    error_reporting($e_all);
    ini_set('log_errors', true);
    ini_set('error_log', _LOG_PATH_ . 'error.log');
    ini_set('html_errors', false);
    ini_set('display_errors', false);

    //------------------------------------------------------------------------
    // Session handling
    //------------------------------------------------------------------------
    $session_lifetime = 86400; // 24 hours, expressed in seconds
    $server_name = filter_input(INPUT_SERVER,'SERVER_NAME');
    $session_cookie_path = str_replace("http://$server_name", '', _ADMIN_URL_);
    session_set_cookie_params($session_lifetime, $session_cookie_path);
    ini_set('session.save_path', _SESSION_PATH_);

    //------------------------------------------------------------------------
    // parent bot
    // the parent bot is used to find aiml matches if no match is found for the current bot
    // in the database the bot_parent_id is the id of the bot to use
    // if no parent bot is used this is set to zero
    // the actual parent bot is set later on in program o there is no need to edit this value
    //------------------------------------------------------------------------
    $bot_parent_id = 1;

//------------------------------------------------------------------------
// Set the default bot configuration And the database settings
//------------------------------------------------------------------------

    //------------------------------------------------------------------------
    // DB and time zone settings
    //------------------------------------------------------------------------

    $time_zone_locale = '[time_zone_locale]'; // a full list can be found at http://uk.php.net/manual/en/timezones.php
    $dbh    = '[dbh]';  # dev remote server location
    $dbPort = '[dbPort]';    # dev database name/prefix
    $dbn    = '[dbn]';    # dev database name/prefix
    $dbu    = '[dbu]';       # dev database username
    $dbp    = '[dbp]';  # dev database password

    //these are the admin DB settings in case you want make the admin a different db user with more privs
    $adm_dbu = '[adm_dbu]';
    $adm_dbp = '[adm_dbp]';

    //------------------------------------------------------------------------
    // Default bot settings
    //------------------------------------------------------------------------

    //Used to populate the stack when first initialized
    $stack_value = 'om';
    //Default conversation id will be set to current session
    $convo_id = session_id();

    //default bot config - this is the default bot most of this will be overwriten by the bot configuration in the db
    $bot_id = 1;
    $format = '[format]';
    $pattern = 'RANDOM PICKUP LINE';
    $error_response = 'No AIML category found. This is a Default Response.';
    $conversation_lines = '1';
    $remember_up_to = 10;
    $debugemail = '[debugemail]';
    /*
     * $debug_level - The level of messages to show the user
     * 0=none,
     * 1=errors only
     * 1=error+general,
     * 2=error+general+sql,
     * 3=everything
     */
    $debug_level = '[debug_level]';

    /*
     * $debug_mode - How to show the debug data
     * 0 = source code view - show debugging in source code
     * 1 = file log - log debugging to a file
     * 2 = page view - display debugging on the webpage
     * 3 = email each conversation line (not recommended)
     */
     $debug_mode = '[debug_mode]';
     $save_state = '[save_state]';
     $error_response = '[error_response]';
     $unknown_user = 'Seeker';

    //------------------------------------------------------------------------
    // Default debug data
    //------------------------------------------------------------------------

    //initially set here but overwriten by bot configuration in the admin panel
  /** @noinspection PhpSillyAssignmentInspection */
  $debug_level = $debug_level;

    //for quick debug to override the bot config debug options
    //0 - Do not show anything
    //1 - will print out to screen immediately
    $quickdebug = 0;

    //for quick debug
    //1 = will write debug data to file regardless of the bot config choice
    //it will write it as soon as it becomes available but this this will be finally
    //overwriten once if and when the conversation turn is complete
    //this will hammer the server if left on so dont leave it on... use in emergencies.
    $writetotemp = 0;

    //debug folders where txt files are stored
    $debugfolder = _DEBUG_PATH_;
    $debugfile = "$debugfolder$convo_id.txt";

    //------------------------------------------------------------------------
    // Set Misc Data
    //------------------------------------------------------------------------

    $botmaster_name = '[botmaster_name]';
    $charset = 'ISO-8859-1';
    $charset = 'UTF-8';

    //------------------------------------------------------------------------
    // Set Program O Website URLs
    //------------------------------------------------------------------------

    define('DOCS_URL', 'http://www.program-o.com/ns/faq/');
    define('NEWS_URL', 'http://blog.program-o.com/'); #This needs to be altered to reflect the correct URL
    define('RSS_URL', 'http://blog.program-o.com/feed/');
    define('SUP_URL', 'http://forum.program-o.com/syndication.php');
    define('FORUM_URL', 'http://forum.program-o.com/');
    define('BUGS_EMAIL', 'bugs@program-o.com');

//------------------------------------------------------------------------
//
// THERE SHOULD BE NO NEED TO EDIT ANYTHING BELOW THIS LINE
//
//------------------------------------------------------------------------

    //------------------------------------------------------------------------
    // Set timezone
    //------------------------------------------------------------------------

    if(function_exists('date_default_timezone_set') && function_exists('date_default_timezone_get'))
    {
      @date_default_timezone_set(@date_default_timezone_get());
    }
    elseif(function_exists('date_default_timezone_set'))
    {
      @date_default_timezone_set($time_zone_locale);
    }


    //------------------------------------------------------------------------
    // Load words list and large arrays into session variables
    //------------------------------------------------------------------------

    if (empty($_SESSION['commonWords']))
    {
      $_SESSION['commonWords'] = file(_CONF_PATH_.'commonWords.dat', FILE_IGNORE_NEW_LINES);
    }

    $common_words_array = $_SESSION['commonWords'];

    //------------------------------------------------------------------------
    // Set Program O globals
    // Do not edit
    //------------------------------------------------------------------------
    $srai_iterations = 1;
    $rememLimit = 20;
    $debugArr = array();

    //------------------------------------------------------------------------
    // Addon Configuration - Set as desired
    //------------------------------------------------------------------------

    define('USE_SPELL_CHECKER', true);
    define('PARSE_BBCODE', true);
    define('USE_WORD_CENSOR', true);
    define('USE_CUSTOM_TAGS', true);

    //------------------------------------------------------------------------
    // Configure mbstring parameters
    //------------------------------------------------------------------------

    define('IS_MB_ENABLED', (function_exists('mb_internal_encoding')) ? true : false);
    if(IS_MB_ENABLED)
    {
      mb_internal_encoding($charset);
      mb_http_input($charset);
      mb_http_output($charset);
      mb_detect_order($charset);
      mb_regex_encoding($charset);
    }

    //------------------------------------------------------------------------
    // Set memory trigger for large data imports
    //------------------------------------------------------------------------

    $sys_mem_limit = ini_get('memory_limit');
    $quantifier = preg_match('~\D~', $sys_mem_limit,$matches);
    $quantifier = strtolower($matches[0]);
    $mem_limit = str_replace($quantifier, '', $sys_mem_limit);
    switch ($quantifier)
    {
      case 'g':
      $mem_limit *= 1024;
      case 'm':
      $mem_limit *= 1024;
      case 'k':
      $mem_limit *= 1024;
      default:
      $mem_limit *= 0.5; // half of the memory limit set by PHP
    }
    define('MEM_TRIGGER', $mem_limit);


    //------------------------------------------------------------------------
    // Set Script Installation as completed
    //------------------------------------------------------------------------

    define('SCRIPT_INSTALLED', true);
?>