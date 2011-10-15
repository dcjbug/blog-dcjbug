<?php
/*
Copyright: © 2009 WebSharks, Inc. ( coded in the USA )
<mailto:support@websharks-inc.com> <http://www.websharks-inc.com/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__qcache_utils_urls"))
	{
		class c_ws_plugin__qcache_utils_urls
			{
				/*
				Responsible for remote communications processed by this plugin.
					`wp_remote_request()` through the `WP_Http` class.
				*/
				public static function remote ($url = FALSE, $post_vars = FALSE, $args = array (), $raw = FALSE)
					{
						static $http_response_filtered = false; /* Apply GZ filters only once. */
						/**/
						$args = (!is_array ($args)) ? array (): $args; /* Disable SSL verifications. */
						$args["sslverify"] = (!isset ($args["sslverify"])) ? false : $args["sslverify"];
						/**/
						if (!$http_response_filtered && ($http_response_filtered = true))
							add_filter ("http_response", "c_ws_plugin__qcache_utils_urls::_remote_gz_variations");
						/**/
						if ($url) /* Obviously, we must have a valid URL before we do anything at all here. */
							{
								if (preg_match ("/^https/i", $url) && strtolower (substr (PHP_OS, 0, 3)) === "win")
									add_filter ("use_curl_transport", "__return_false", ($curl_disabled = 1352));
								/**/
								if ((is_array ($post_vars) || is_string ($post_vars)) && !empty ($post_vars))
									$args = array_merge ($args, array ("method" => "POST", "body" => $post_vars));
								/**/
								$response = wp_remote_request ($url, $args); /* Get response array. */
								/**/
								if ($raw && !($r = "")) /* Return a raw response w/ all headers too? */
									{
										foreach (wp_remote_retrieve_headers ($response) as $header => $header_v)
											$r .= $header . ": " . $header_v . "\r\n";
										$r = trim ($r) . "\r\n\r\n"; /* Separate headers. */
										$r .= wp_remote_retrieve_response_message ($response);
									}
								else /* Else we just retrieve the body. */
									$r = wp_remote_retrieve_body ($response);
								/**/
								if ($curl_was_disabled_by_this_routine_with_1352_priority = $curl_disabled)
									remove_filter ("use_curl_transport", "__return_false", 1352);
								/**/
								return $r; /* The return value. */
							}
						/**/
						return false; /* Else return false. */
					}
				/*
				Filters the WP_Http response for additional gzinflate variations.
					Attach to: add_filter("http_response");
				*/
				public static function _remote_gz_variations ($response = array ())
					{
						if (!isset ($response["ws__gz_variations"]) && ($response["ws__gz_variations"] = 1))
							{
								if ($response["headers"]["content-encoding"])
									if (substr ($response["body"], 0, 2) === "\x78\x9c")
										if (($gz = @gzinflate (substr ($response["body"], 2))))
											$response["body"] = $gz;
							}
						/**/
						return $response;
					}
				/*
				Parses out a full valid URI, from either a full URL, or a partial.
				*/
				public static function parse_uri ($url_or_uri = FALSE)
					{
						if (($parse = @parse_url ($url_or_uri))) /* See: http://php.net/manual/en/function.parse-url.php. */
							{
								$parse["path"] = (!empty ($parse["path"])) ? ((strpos ($parse["path"], "/") === 0) ? $parse["path"] : "/" . $parse["path"]) : "/";
								$parse["path"] = preg_replace ("/\/+/", "/", $parse["path"]); /* Removes multi slashes. */
								/**/
								return (!empty ($parse["query"])) ? $parse["path"] . "?" . $parse["query"] : $parse["path"];
							}
						/**/
						return false;
					}
			}
	}
?>