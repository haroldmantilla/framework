<?php
  # Set Default Title / Information
  if (!isset($PAGE_TITLE)) {$PAGE_TITLE = 'Page Title'; }
  if (!isset($NAVBAR_TITLE)) {$NAVBAR_TITLE = 'NavBar Title'; }
  if (!isset($NAVBAR_TITLE_URL)) {$NAVBAR_TITLE_URL = '#'; }
?>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container"> <!-- << Remove this if you want the navbar to go all the way to the left -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- NavBar Branding if Interested
            <a class="navbar-brand" href="#"><img alt="Navbar!" src="css/images/web-icon.png" width="24"></a>
          -->
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">

            <!-- NavBar Title -->
            <li><a href="<?php echo $NAVBAR_TITLE_URL; ?>"><?php echo $NAVBAR_TITLE; ?></a></li>

            <?php

              foreach ($NAVBAR as $i => $navbar_item) {
                # Provide a clickable navbar option
                if ($navbar_item['type'] == 'url') {
                  echo "<li><a title='".$navbar_item['title']."' href='".$navbar_item['url']."'>".PHP_EOL;
                  if (isset($navbar_item['ltext'])) {
                    echo $navbar_item['ltext'];
                  }
                  if (isset($navbar_item['icon'])) {
                    echo "<span class='glyphicon ".$navbar_item['icon']."' aria-hidden='true'></span>".PHP_EOL;
                  }
                  if (isset($navbar_item['rtext'])) {
                    echo $navbar_item['rtext'];
                  }
                  if (isset($navbar_item['caret'])) {
                    echo '<span class="caret"></span>';
                  }
                  echo "</a></li>".PHP_EOL;
                # Allow direct text output
                } elseif ($navbar_item['type'] == 'search') {
                  echo "</ul>".PHP_EOL;
                  echo "<div class='col-sm-3 col-md-3'>".PHP_EOL;
                  echo "<form class='navbar-form' role='search' action='{$navbar_item['action']}' method='POST'>".PHP_EOL;
                  echo " <div class='input-group'>".PHP_EOL;
                  echo "  <input type='text' class='form-control' placeholder='{$navbar_item['title']}' name='{$navbar_item['field']}'>".PHP_EOL;
                  if (isset($navbar_item['icon']) && $navbar_item['icon'] != '') {
                    echo "  <div class='input-group-btn'>".PHP_EOL;
                    echo "   <button class='btn btn-default' type='submit'><i class='glyphicon {$navbar_item['icon']}'></i></button>".PHP_EOL;
                    echo "  </div>".PHP_EOL;
                  }
                  echo " </div>".PHP_EOL;
                  echo "</form>".PHP_EOL;
                  echo "</div>".PHP_EOL;
                } elseif ($navbar_item['type'] == 'direct') {
                  echo $navbar_item['text'];
                # Seperate left from right on the navbar
                } elseif ($navbar_item['type'] == 'seperator' || $navbar_item['type'] == 'separator') {
                  echo '</ul><ul class="nav navbar-nav navbar-right">'.PHP_EOL;
                # Allow for drop down menus within the navbar
                } elseif ($navbar_item['type'] == 'dropdown') {
                  echo '<li class="dropdown">'.PHP_EOL;
                  echo '              <a href="#" title="'.$navbar_item['title'].'" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.PHP_EOL;
                  echo '              ';
                  if (isset($navbar_item['ltext'])) {
                    echo $navbar_item['ltext'];
                  }
                  if (isset($navbar_item['icon'])) {
                    echo "<span class='glyphicon ".$navbar_item['icon']."' aria-hidden='true'></span>";
                  }
                  if (isset($navbar_item['rtext'])) {
                    echo $navbar_item['rtext'];
                  }
                  if (isset($navbar_item['caret'])) {
                    echo '<span class="caret"></span>';
                  }
                  echo '</a>'.PHP_EOL;
                  echo '              <ul class="dropdown-menu  scrollable-menu">'.PHP_EOL;
                  foreach ($navbar_item['options'] as $ii => $row) {
                    if ($row['type'] == 'seperator' || $row['type'] == 'separator') {
                      echo '                <li role="separator" class="divider"></li>'.PHP_EOL;
                    } elseif ($row['type'] == 'header') {
                      echo '                <li class="dropdown-header">'.$row['text'].'</li>'.PHP_EOL;
                    } elseif ($row['type'] == 'url') {
                      echo "                <li><a title='".$row['title']."' href='".$row['url']."'>".$row['text']."</a></li>".PHP_EOL;
                    } elseif ($row['type'] == 'direct') {
                      echo $row['text'];
                    }
                  }
                  echo '              </ul>'.PHP_EOL;
                }
                echo '            </li>'.PHP_EOL;
              }
            ?>
          </ul>
        </div>
      </div>
    </nav>

    <!-- End NavBar - Begin Page Operations -->
