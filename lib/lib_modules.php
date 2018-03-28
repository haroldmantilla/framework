<?php

  ###############################################################
  # Process Plug-and-Play Modules as part of the template       #
  ###############################################################

  # Make sure that scanned PHP files have the following
  # variable defined within them:

  ###############################################################
  # Automatic Navbar Menu Generation (lib_module) Configuration #
  ###############################################################
  $MODULE_DEF = array('name'=>'MySQL Query Builder',
                      'version'=>1.0,
                      'display'=>'Query Builder',
                      'tab'=>'tools',
                      'position'=>20,
                      'student'=>true,
                      'instructor'=>true,
                      'guest'=>false,
                      'access'=>array('admin'=>'site'));
  ###############################################################

  $NAVBAR_MODULES = array();

  function module_process($file_data) {
    preg_match_all('/\$MODULE_DEF[^;]+;/i', $file_data, $output);
    if (isset($output[0][0])) {
      eval($output[0][0]);
    }
    if (isset($MODULE_DEF)) {
      return $MODULE_DEF;
    } else {
      return array();
    }
  }

  if (defined('MODULE_DIRS')
      && defined('MODULE_FILES')
      && defined('MODULE_IGNORE')) {

    $MODULE_FILE_CHECK = MODULE_FILES;
    foreach(MODULE_DIRS as $dir) {
      if (is_dir($dir)) {
        foreach(scandir($dir) as $file) {
          if (!in_array($file, MODULE_IGNORE)
              && !in_array("$dir/$file", $MODULE_FILE_CHECK)
              && substr($file, -4) === '.php'
              && substr($file, 0, 4) !== 'lib_'
          ) {
            $MODULE_FILE_CHECK[] = "$dir/$file";
          }
        }
      }
    }

    foreach ($MODULE_FILE_CHECK as $file) {
      if (file_exists($file)) {
        $file_data = file_get_contents($file);
        preg_match('/\$MODULE_DEF/', $file_data, $mod_check);
        if (!empty($mod_check)) {
          if (isset($MODULE_DEF)) {
            unset($MODULE_DEF);
          }
          $MODULE_DEF = module_process($file_data);
          if (isset($MODULE_DEF) && !empty($MODULE_DEF)) {
            $visible = True;
            if (STUDENT && !$MODULE_DEF['student']) { $visible = False; }
            if (INSTRUCTOR && !$MODULE_DEF['instructor']) { $visible = False; }
            if (GUEST && !$MODULE_DEF['guest']) { $visible = False; }
            foreach ($MODULE_DEF['access'] as $key => $value) {
              if (!isset(USER['privileges'][$key]) || !in_array($value, USER['privileges'][$key])) {
                $visible = False;
              }
            }
            if ($visible && $MODULE_DEF['tab'] != '') {
              $MODULE_DEF['file'] = $file;
              $NAVBAR_MODULES[$MODULE_DEF['tab']][$MODULE_DEF['position']][] = $MODULE_DEF;
              ksort($NAVBAR_MODULES[$MODULE_DEF['tab']]);
            }
          }
        }
      }
    }
    ksort($NAVBAR_MODULES);
    define('NAVBAR_MODULES', $NAVBAR_MODULES);
  }

?>
