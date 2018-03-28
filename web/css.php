<?php
  if (!defined('WEB_PATH')) { define('WEB_PATH', '../web/'); }
  if (!isset($PAGE_TITLE))  { $PAGE_TITLE = 'Template';      }
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head;
         any other head content must come *after* these tags -->

    <!-- Icon to use in the browser tab -->
    <link rel="icon" href="<?php echo WEB_PATH; ?>images/web-icon.png">

    <!-- Provide the page title -->
    <title><?php echo $PAGE_TITLE; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo WEB_PATH; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Skeleton CSS -->
    <link rel="stylesheet" href="<?php echo WEB_PATH; ?>skeleton/css/normalize.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH; ?>skeleton/css/skeleton.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH; ?>css/skeleton-modifications.css">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?php echo WEB_PATH; ?>bootstrap/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="<?php echo WEB_PATH; ?>fonts/raleway.css" rel='stylesheet' type='text/css'>

    <!-- Ace Code Editor - https://ace.c9.io/ -->
    <script type="text/javascript"
      src="<?php echo WEB_PATH; ?>ace-builds/src-noconflict/ace.js" charset="utf-8">
    </script>

    <!-- Chart.js - http://www.chartjs.org -->
    <script type="text/javascript"
      src="<?php echo WEB_PATH; ?>chartjs/Chart.bundle.min.js" charset="utf-8">
    </script>

    <!-- Custom styles for this template -->
    <link href="<?php echo WEB_PATH; ?>css/mysite-default.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo WEB_PATH; ?>bootstrap/js/html5shiv.min.js"></script>
      <script src="<?php echo WEB_PATH; ?>bootstrap/js/respond.min.js"></script>
    <![endif]-->

    <!-- Highlight.js -->
    <link rel="stylesheet" href="<?php echo WEB_PATH; ?>highlight/styles/color-brewer.css">
    <script src='<?php echo WEB_PATH; ?>highlight/highlight.pack.js'></script>
    <script>hljs.initHighlightingOnLoad();</script>

    <!-- Font-Awesome -->
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_PATH; ?>font-awesome/css/font-awesome.min.css">

    <!-- Datatables -->
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_PATH; ?>datatables.net/datatables.min.css"/>

    <!-- Printing -->
    <link rel="stylesheet" type="text/css" media="print" href="<?php echo WEB_PATH; ?>css/mysite-print.css" />

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo WEB_PATH; ?>jquery/jquery-3.3.1.min.js"></script>
    <script src="<?php echo WEB_PATH; ?>bootstrap/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo WEB_PATH; ?>bootstrap/js/ie10-viewport-bug-workaround.js"></script>
    <!-- DataTables -->
    <script type="text/javascript" src="<?php echo WEB_PATH; ?>datatables.net/datatables.min.js"></script>

  </head>

  <body>
