<?php

	##############################################################################
	# Calendar 3.1-4.0 Database Library
	# J. Kenney 2016-2018

	##############################################################################
	# Note: This library expects, at a minimum the following constants
	#       to be defined prior to loading the library
	#
	# define('DATABASE_HOST', 'XXXX.academy.usna.edu');
  # define('DATABASE_USER', 'database username');
  # define('DATABASE_PW',   'users password');
  # define('DATABASE_NAME', 'database name');
	#
	# or you can set a single variable to allow for multiple databases
	# although only the 'default' one will be automatically loaded by
	# this library
	#
	# define('DATABASE_MYSQL',
	#         array('default'=>array('host'=>'XXXX.academy.usna.edu',
	#                                'user'=>'database username',
	#                                'password'=>'users password',
	#                                'name'=>'database name')));

	##############################################################################
	# Used to establish a link to a database
	function connect_db($hostname, $username, $password, $schema) {

	  # Connect to MySQL
	  $db = new mysqli($hostname, $username, $password, $schema);

	  # Provide Failure data if unsuccessful
	  if (mysqli_connect_errno()) {
	    echo "<hr><h1><font color=red>Database Connection Failure:</font></h1>";
	    echo "<pre>ERROR: " . mysqli_connect_errno() . "</pre><pre>" . mysqli_connect_error() . "</pre><hr>";
	  }

	  ##############################################################################
	  # Let there be UTF-8
	  $db->query("set character_set_client='utf8'");
	  $db->query("set character_set_results='utf8'");
	  $db->query("set collation_connection='utf8_general_ci'");

	  return $db;
	}

	##############################################################################
	# Connect to default database (if defined)
	if (defined('DATABASE_MYSQL') && isset(DATABASE_MYSQL['default'])) {
		$db = connect_db(DATABASE_MYSQL['default']['host'], DATABASE_MYSQL['default']['user'], DATABASE_MYSQL['default']['password'], DATABASE_MYSQL['default']['name']);
	} elseif (defined('DATABASE_HOST')) {
		$db = connect_db(DATABASE_HOST, DATABASE_USER, DATABASE_PW, DATABASE_NAME);
	} else {
		echo "<hr><h1><font color=red>Database Information NOT Configured</font></h1>";
		die;
	}

	##############################################################################
	# Dynamically Build a MySQL Prepared Query...
	# Returns an executed $stmt, that can then be stepped though or processed
	#
	# Example Usage:
	#  $query = "SELECT * FROM auth_user WHERE user=? AND last=?";
	#  $bind_fields = array("jpjones", "Jones");
	#  $stmt = build_query($db, $query, $bind_fields);
	# Example Usage:
	#  $stmt = build_query($db, "SELECT * FROM auth_user");
	function build_query($db, $query, $bind_fields=array(), $bind_types=array(), $reveal_prepare=true, $hide_errors=false) {

		# Mark if errors found.
		$errors_detected = false;

		# Determine the bind types of variables, and build the string
		$bind_string = '';
		foreach ($bind_fields as $bf) {
			if (isset($bind_types[$bf])) {
				$bind_string .= $bind_types[$bf];
			} else {
				$bind_string .= 's';
			}
		}

		# Build the parameter array
		$mysql_bind_string = array();
		$mysql_bind_string[] = & $bind_string;
		for ($i = 0; $i < count($bind_fields); $i++) {
			$mysql_bind_string[] = & $bind_fields[$i];
		}

		# Initialize a new DB query
		$stmt = $db->stmt_init();

		# Initial Error Checking
		if($stmt === false && !$hide_errors) {
			if (!$errors_detected) {
				$errors_detected = true;
				echo "<div class=container><div class=jumbotron><h1><font color=red>Database Error (Step 1 - init):</font></h1>";
				echo "<p>The following query was provided to the <b>build_query()</b> function:</p>";
				echo "<pre><code class=sql>$query</code></pre>";
				if ($reveal_prepare) {
					echo "<p>This query would have been interpreted, via <b>PREPARE</b> procedures, as:</p>";
					$expand_query = $query;
					foreach ($bind_fields as $bf) {
						$expand_query = implode("<font color=red>{</font><font color=blue>".$bf."</font><font color=red>}</font>", explode("?", $expand_query, 2));
					}
					echo "<pre><code class=sql>$expand_query</code></pre>";
					echo "<h4>Location of DB Function Call:</h4><p>";
					array_walk( debug_backtrace(), create_function( '$a,$b', 'print "<b>". basename( $a[\'file\'] ). "</b> &nbsp; <font color=\"red\">{$a[\'line\']}</font> &nbsp; <font color=\"green\">{$a[\'function\']} ()</font> &nbsp; -- ". dirname( $a[\'file\'] ). "/";' ) );
				}
				echo "</p>";
				echo "<h4>Additional Error Data:</h4>";
				echo "<p>The following debugging data is provided by the SQL library functions:	</p>";
			}
			echo "<pre>Connect Error: " . $db->errno . " - " . $db->error . "</pre>";
		}

		# Build MySQL PREPARED statement
		$stmt->prepare($query);

		# Prepare Error Checking
		if ($db->errno && !$hide_errors) {
			if (!$errors_detected) {
				$errors_detected = true;
				echo "<div class=container><div class=jumbotron><h1><font color=red>Database Error (Step 2 - prepare):</font></h1>";
				echo "<p>The following query was provided to the <b>build_query()</b> function:</p>";
				echo "<pre><code class=sql>$query</code></pre>";
				if ($reveal_prepare) {
					echo "<p>This query would have been interpreted, via <b>PREPARE</b> procedures, as:</p>";
					$expand_query = $query;
					foreach ($bind_fields as $bf) {
						$expand_query = implode("<font color=red>{</font><font color=blue>".$bf."</font><font color=red>}</font>", explode("?", $expand_query, 2));
					}
					echo "<pre><code class=sql>$expand_query</code></pre>";
					echo "<h4>Location of DB Function Call:</h4><p>";
					array_walk( debug_backtrace(), create_function( '$a,$b', 'print "<b>". basename( $a[\'file\'] ). "</b> &nbsp; <font color=\"red\">{$a[\'line\']}</font> &nbsp; <font color=\"green\">{$a[\'function\']} ()</font> &nbsp; -- ". dirname( $a[\'file\'] ). "/";' ) );
				}
				echo "</p>";
				echo "<h4>Additional Error Data:</h4>";
				echo "<p>The following debugging data is provided by the SQL library functions:	</p>";
			}
			echo "<pre>Error: " . $db->errno . " - " . $db->error . "</pre>";
		}

		# Bind the fields to the query
		if ($bind_string != '') {
			$result = call_user_func_array(array($stmt, 'bind_param'), $mysql_bind_string);

			# Count the number of ? in the prepared query statement
			if (count($bind_fields) != substr_count($query, '?') && !$hide_errors) {
				if (!$errors_detected) {
					$errors_detected = true;
					echo "<div class=container><div class=jumbotron><h1><font color=red>Database Error (Step 3 - bind):</font></h1>";
					echo "<p>The following query was provided to the <b>build_query()</b> function:</p>";
					echo "<pre><code class=sql>$query</code></pre>";
					if ($reveal_prepare) {
						echo "<p>This query would have been interpreted, via <b>PREPARE</b> procedures, as:</p>";
						$expand_query = $query;
						foreach ($bind_fields as $bf) {
							$expand_query = implode("<font color=red>{</font><font color=blue>".$bf."</font><font color=red>}</font>", explode("?", $expand_query, 2));
						}
						echo "<pre><code class=sql>$expand_query</code></pre>";
						echo "<h4>Location of DB Function Call:</h4><p>";
						array_walk( debug_backtrace(), create_function( '$a,$b', 'print "<b>". basename( $a[\'file\'] ). "</b> &nbsp; <font color=\"red\">{$a[\'line\']}</font> &nbsp; <font color=\"green\">{$a[\'function\']} ()</font> &nbsp; -- ". dirname( $a[\'file\'] ). "/";' ) );
					}
					echo "</p>";
					echo "<h4>Additional Error Data:</h4>";
					echo "<p>The following debugging data is provided by the SQL library functions:	</p>";
				}
				echo "<pre>Expected Bind Error: Number of ? marks (".substr_count($query, '?').") != provided elements (".count($bind_fields).") </pre>";
			}

			# Check for binding errors
			if (!$result && !$hide_errors) {
				$last_error = error_get_last();
				if ($last_error) {
					if (!$errors_detected) {
						$errors_detected = true;
						echo "<div class=container><div class=jumbotron><h1><font color=red>Database Error (Step 4 - bind detail):</font></h1>";
						echo "<p>The following query was provided to the <b>build_query()</b> function:</p>";
						echo "<pre><code class=sql>$query</code></pre>";
						if ($reveal_prepare) {
							echo "<p>This query would have been interpreted, via <b>PREPARE</b> procedures, as:</p>";
							$expand_query = $query;
							foreach ($bind_fields as $bf) {
								$expand_query = implode("<font color=red>{</font><font color=blue>".$bf."</font><font color=red>}</font>", explode("?", $expand_query, 2));
							}
							echo "<pre><code class=sql>$expand_query</code></pre>";
							echo "<h4>Location of DB Function Call:</h4><p>";
							array_walk( debug_backtrace(), create_function( '$a,$b', 'print "<b>". basename( $a[\'file\'] ). "</b> &nbsp; <font color=\"red\">{$a[\'line\']}</font> &nbsp; <font color=\"green\">{$a[\'function\']} ()</font> &nbsp; -- ". dirname( $a[\'file\'] ). "/";' ) );
						}
						echo "</p>";
						echo "<h4>Additional Error Data:</h4>";
						echo "<p>The following debugging data is provided by the SQL library functions:	</p>";
					}
					echo "<pre>PHP Warning: ".PHP_EOL;
					echo "Line: " . $last_error['line'] . PHP_EOL;
					echo "Message: " . $last_error['message'] . PHP_EOL;
					echo "</pre>";
				}
			}
		}

		# Execute MySQL PREPARED statement
		$result = $stmt->execute();

		# Execution Error
		if (!$result && !$hide_errors) {
			if (!$errors_detected) {
				$errors_detected = true;
				echo "<div class=container><div class=jumbotron><h1><font color=red>Database Error (Step 5 - execute):</font></h1>";
				echo "<p>The following query was provided to the <b>build_query()</b> function:</p>";
				echo "<pre><code class=sql>$query</code></pre>";
				if ($reveal_prepare) {
					echo "<p>This query would have been interpreted, via <b>PREPARE</b> procedures, as:</p>";
					$expand_query = $query;
					foreach ($bind_fields as $bf) {
						$expand_query = implode("<font color=red>{</font><font color=blue>".$bf."</font><font color=red>}</font>", explode("?", $expand_query, 2));
					}
					echo "<pre><code class=sql>$expand_query</code></pre>";
					echo "<h4>Location of DB Function Call:</h4><p>";
					array_walk( debug_backtrace(), create_function( '$a,$b', 'print "<b>". basename( $a[\'file\'] ). "</b> &nbsp; <font color=\"red\">{$a[\'line\']}</font> &nbsp; <font color=\"green\">{$a[\'function\']} ()</font> &nbsp; -- ". dirname( $a[\'file\'] ). "/";' ) );
				}
				echo "</p>";
				echo "<h4>Additional Error Data:</h4>";
				echo "<p>The following debugging data is provided by the SQL library functions:	</p>";
			}
			echo "<pre>". $db->error . "</pre>";
		}

		# Close out error reporting
		if ($errors_detected && !$hide_errors) {
			echo "<h4><font color=red>Please contact the database or web administrator to report this error.</font></h4>";
			echo "</div></div>";
		}

		# Return the SQL $stmt object.
		return $stmt;
	}

	# Shortcut function to hide prepared values in debugging
	function build_query_hide($db, $query, $bind_fields=array(), $bind_types=array(), $reveal_prepare=false) {
		return build_query($db, $query, $bind_fields, $bind_types, $reveal_prepare);
	}

	# Shortcut function to hide any errors during the query
	function build_query_quiet($db, $query, $bind_fields=array(), $bind_types=array(), $reveal_prepare=false, $hide_errors=true) {
		return build_query($db, $query, $bind_fields, $bind_types, $reveal_prepare, $hide_errors);
	}

	##############################################################################
	// Return an associative array of the MySQLi results, given a returned $stmt object
	//
	//  Results will be returned in the following format
	// 	Array
	// (
	//     [0] => Array
	//         (
	//             [user] => jpjones
	//             [displayname] => Professor John Paul Jones
	//             [first] => John Paul
	//             [last] => Jones
	//             [department] => Computer Science
	//             [session] => user|s:6:"jpjones";
	//             [id] => fknibxx97m2gq6ehk4a1rpaki7
	//             [valid] => 1472867262
	//             [login] => 1472861282
	//         )
	//
	// )
	function stmt_to_assoc_array($stmt) {
		# Retrieve associated metadata
	  $meta = $stmt->result_metadata();

		# Determine column Names
	  while ($field = $meta->fetch_field()) {
	    $params[] = &$row[$field->name];
	  }

		# Build variables into which data will be placed
	  call_user_func_array(array($stmt, 'bind_result'), $params);

		# Retrieve a row of data
	  while ($stmt->fetch()) {
			# Retrieve a single column->value pair
	    foreach($row as $key => $val) {
	      $c[$key] = $val;
	    }
	    $results[] = $c;
	  }

		# If there were no results, then just return an empty array
	  if (!isset($results)) {
	    return array();
	  }

		# Return results
	  return $results;
	}

	##############################################################################
	# return a single row (from results assuming that there was only one row)
	function array_2d_to_1d($results) {
	  if (isset($results[0])) {
	    return $results[0];
	  } else {
	    return array();
	  }
	}

	##############################################################################
	# Take in a string like: "org, address1, address2, city, state, zip, formal,
	#                         signed_by, signed_data, held_by, agree_type, comments"
	# And convert it to a populated array of values (from $ARRAY) which have these as keys
	# And return a correct size string of ?'s for a PREPARED statement Insert or Update
	function build_array($ARRAY, $fields, $labeled=true) {
	  $bind_fields = array();
	  $bind_quests = '';
	  $empty = '';
	  $insert_quests = '';
		$counter = 0;
	  foreach (explode(",", $fields) as $field) {
	    $field = trim($field);
	    if ($bind_quests != '') {
	      $bind_quests .= ', ';
	      $insert_quests .= ', ';
	    }
	    $bind_quests .= '?';
	    $insert_quests .= "$field=?";
			if (!$labeled) {
				$bind_fields[] = $ARRAY[$counter];
	    } elseif (isset($ARRAY[$field])) {
	      $bind_fields[] = trim($ARRAY[$field]);
	    } else {
	      $bind_fields[] = $empty;
	    }
			$counter++;
	  }
	  return array($bind_fields, $bind_quests, $insert_quests);
	}

?>
