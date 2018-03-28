<?php

  ############################################################################
  # Determine Which Semester it is right now!
  function this_semester() {
    $today_year = intval(date('Y'));
    $today_month = intval(date('n'));
    $today_day = intval(date('j'));
    $result_year = $today_year;
    if ($today_month > 5 || ($today_month >= 5 && $today_day >= 15)) {
      $result_year = $result_year + 1;
    }
    $result_semester = 'SPRING';
    if ($today_month > 5 || ($today_month >= 5 && $today_day >= 15)) {
      $result_semester = 'SUMMER';
    }
    if ($today_month > 8 || ($today_month >= 8 && $today_day >= 21)) {
      $result_semester = 'FALL';
    }
    if ($today_month == 12 && $today_day > 29) {
      $result_semester = 'SPRING';
    }
    $results = array();
    $results[0] = $result_year;
    $results[1] = $result_semester;
    $results['year'] = $result_year;
    $results['semester'] = $result_semester;
    return $results;
  }

  ############################################################################
  # Determine Which Semester it is right now!
  function last_semester($semester_override=False) {
    if ($semester_override) {
      $results = $semester_override;
    } else {
      $results = this_semester();
    }
    if ($results['semester'] == 'FALL') {
      $results['semester'] = 'SUMMER';
    } elseif ($results['semester'] == 'SUMMER') {
      $results['semester'] = 'SPRING';
      $results['year']--;
    } elseif ($results['semester'] == 'SPRING') {
      $results['semester'] = 'FALL';
    }
    $results[0] = $results['year'];
    $results[1] = $results['semester'];
    return $results;
  }

  ############################################################################
  # Determine Which Semester it is right now!
  function next_semester($semester_override=False) {
    if ($semester_override) {
      $results = $semester_override;
    } else {
      $results = this_semester();
    }
    if ($results['semester'] == 'FALL') {
      $results['semester'] = 'SPRING';
    } elseif ($results['semester'] == 'SUMMER') {
      $results['semester'] = 'FALL';
    } elseif ($results['semester'] == 'SPRING') {
      $results['semester'] = 'SUMMER';
      $results['year']++;
    }
    $results[0] = $results['year'];
    $results[1] = $results['semester'];
    return $results;
  }

?>
