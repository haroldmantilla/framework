<?php

  // Get specific line from file
  function getLine($file, $line) {
    $file = new SplFileObject($file);
    $file->seek($line-1);
    return $file->current();
  }

  // Create a table version of print_r
  function AdvancedPrintR($data, $title='', $additional='', $badline='') {
    if (is_array($data)) {
      echo "<table border=1 cellspacing=0 cellpadding=3 width=100%>".PHP_EOL;
      if ($title != '') {
        echo '<tr><td colspan=2 style="background-color:#333333;"><strong><font color=white>'.$title.'</font></strong></td></tr>'.PHP_EOL;
      }
      if ($additional != '') {
        echo '<tr><td colspan=2 style="background-color:#dddddd;"><strong>'.$additional.'</strong></td></tr>'.PHP_EOL;
      }
      if ($badline != '') {
        echo '<tr><td colspan=2 style="background-color:#ffffff;"><pre><code class="php">'.trim($badline).'</code></pre></td></tr>'.PHP_EOL;
      }
      foreach ($data as $key => $value) {
        echo '<tr><td valign="top" style="width:40px;background-color:#F0F0F0;">'.PHP_EOL;
        echo '<strong>' . $key . "</strong></td><td>".PHP_EOL;
        AdvancedPrintR($value, "ARRAY (".count($value)." items)");
        echo "</td></tr>".PHP_EOL;
      }
      echo "</table>".PHP_EOL;
      return;
    }
    try {
      echo "(".gettype($data).") ";
      echo str_ireplace(PHP_EOL,'', var_export($data, True));
    } catch (Error $e) {
      echo "(FAIL) unable to expand...";
    }
  }

  // Print Error Trace in Readible Format
  function AdvancedErrorPrinter($comment, $errno, $errstr, $errfile, $errline, $errvars) {
    $debug_data = debug_backtrace();
    if (count($debug_data) > 2 && false) {
      $debug_vars = array_shift($debug_data);
      $debug_vars = array_shift($debug_data);
    } else {
      $debug_vars = array_shift($debug_data);
      $debug_data[0]['function'] = '';
      unset($debug_data[0]['args']);
    }
    echo "<div class=container>".PHP_EOL;
    echo "  <div class=jumbotron>".PHP_EOL;
    echo "    <h3>".PHP_EOL;
    echo "      <font color=red>$comment ($errno) $errstr</font>".PHP_EOL;
    echo "    </h3>".PHP_EOL;
    foreach (array_reverse($debug_data) as $tmp => $info) {
      $badline = getLine($info['file'], $info['line']);
      $args = array();
      if (isset($info['args'])) {
        foreach ($info['args'] as $arg => $value) {
          $args[] = str_ireplace(PHP_EOL,'', var_export($value, True));
        }
      }
      $additional = "<b>".basename($info['file'])."</b> <font color='red'>{$info['line']}</font> <font color='green'>{$info['function']}</font> ".dirname($info['file']) . "/ ";
      if ($info['function'] != '') {
        AdvancedPrintR($args, "Function: {$info['function']}()", $additional, $badline);
      } else {
        AdvancedPrintR($args, "Error in Main Script", $additional, $badline);
      }
      echo "<br>".PHP_EOL;
    }
    AdvancedPrintR($errvars, 'Variables and Values at location of Error');
    echo "  </div>".PHP_EOL;
    echo "</div>".PHP_EOL;
  }

  // Advanced Error Handling Library
  function AdvancedErrorHandler($errno, $errstr, $errfile, $errline, $errvars) {
    if (!(error_reporting() & $errno)) {
      return false;
    }

    switch ($errno) {
      case E_USER_ERROR:
        AdvancedErrorPrinter("Fatal Error", $errno, $errstr, $errfile, $errline, $errvars);
        exit(1);
        break;

      case E_USER_WARNING:
        AdvancedErrorPrinter("Warning", $errno, $errstr, $errfile, $errline, $errvars);
        break;

      case E_USER_NOTICE:
        AdvancedErrorPrinter("Notice", $errno, $errstr, $errfile, $errline, $errvars);
        break;

      default:
        AdvancedErrorPrinter("Unknown Error", $errno, $errstr, $errfile, $errline, $errvars);
        break;
    }

    // Avoid  PHP internal error handler
    return true;
  }

  set_error_handler("AdvancedErrorHandler");

?>
