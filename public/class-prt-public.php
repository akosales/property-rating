<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.makler-anfragen.immo
 * @since      1.0.0
 *
 * @package    Prt
 * @subpackage Prt/public
 */

/**
 * This interface represents the Steps for 'Wohnung', 'Haus' and 'Grundstuck'.
 */
interface Steps {
    public function getResponse();
	public function validateData();
	public function collectData();
}

class PRT_Exception extends Exception {

	protected $message = 'Unknown exception';
	protected $extraMessage;
	
	public function __construct($message = null, $extraMessage = null) {
		$this->message = $message;
		$this->extraMessage = $extraMessage;
	}

	public function getExtraMessage() {
		return $this->extraMessage;
	}
}

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Prt
 * @subpackage Prt/public
 * @author     Emre Isik
 */
class Prt_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $prt    The ID of this plugin.
	 */
	private $prt;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $settings;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $prt       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $prt, $version, $settings ) {

		$this->prt = $prt;
		$this->version = $version;
		$this->settings = $settings;
		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style($this->prt);
		wp_enqueue_style('slick');
		wp_enqueue_style('slick-theme');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Prt_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Prt_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->prt, plugin_dir_url( __FILE__ ) . 'js/prt-public.js', array( 'jquery' ), $this->version, false);
		wp_enqueue_script('jquery-steps', plugin_dir_url( __FILE__ ) . 'js/jquery.steps.min.js', array( 'jquery' ), $this->version, false);
	}

	/**
	 * 
	 */
	public function replace_jquery() {
		if (!is_admin()) {
			// comment out the next two lines to load the local copy of jQuery
			wp_deregister_script('jquery');
			wp_register_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js', false, '1.11.3');
			wp_enqueue_script('jquery');
		}
	}

	public function register_styles() {
		wp_register_style('slick', '//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css', array(), $this->version, 'all' );
		wp_register_style('slick-theme', '//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css', array(), $this->version, 'all' );
		wp_register_style($this->prt, plugin_dir_url( __FILE__ ) . 'css/prt-public.css', array('slick', 'slick-theme'), $this->version, 'all' );
	}

	public function register_scripts() {
		wp_register_script('jquery-steps', plugin_dir_url( __FILE__ ) . 'js/jquery.steps.min.js', array( 'jquery' ));
		wp_register_script('slick', '//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js', array( 'jquery' ));
		wp_register_script($this->prt, plugin_dir_url( __FILE__ ) . 'js/prt-public.js', array( 'jquery', 'slick' ));
	}

	/**
	 * Returns a Step class.
	 * @param string $type
	 * @return Step step
	 */
	private function loadStepClass($type) {
		switch($_POST['type']) {
			case 'wohnung': {
				require plugin_dir_path(__FILE__) . 'partials/steps/wohnung/class.WohnungSteps.php';
				return new WohnungSteps();
			}
			case 'haus': {
				require plugin_dir_path(__FILE__) . 'partials/steps/haus/class.HausSteps.php';
				return new HausSteps();
			}
			case 'grundstuck': {
				require plugin_dir_path(__FILE__) . 'partials/steps/grundstuck/class.GrundstuckSteps.php';
				return new GrundstuckSteps();
			}
			default: throw new Exception("Step type not valid");
		}
	}

	private function insertRequest($data) {
		global $wpdb;
		$wpdb->insert($wpdb->prefix.'prt_requests', array(
			'type' => $data['type'],
			'firstname' => $data['firstname'],
			'lastname' => $data['lastname'],
			'phone' => $data['phone'],
			'email' => $data['email'],
			'address' => $data['address'],
			'wohnflache' => $data['wohnflache'],
			'zimmer' => $data['zimmer'],
			'baujahr' => $data['baujahr'],
			'grundflache' => $data['grundflache'],
			'etage' => $data['etage'],
			'erschlossen' => $data['erschlossen'],
			'bebauung' => $data['bebauung'],
			'zuschnitt' => $data['zuschnitt'],
		));
	}

	private function get_headers_from_curl_response($response) {
		$headers = array();
		$header_text = substr($response, 0, strpos($response, "\r\n\r\n"));
	
		foreach (explode("\r\n", $header_text) as $i => $line)
			if ($i === 0)
				$headers['http_code'] = $line;
			else {
				list ($key, $value) = explode(': ', $line);
				$headers[$key] = $value;
			}
	
		return $headers;
	}

	private function curlToApi($url, $method = 'GET', $data = null, $justHeader = false) {
		require_once PRT_DIR_HOME.'includes/OAuth.php';

		$signatureMethod = new TOAuthSignatureMethod_HMAC_SHA1();
		$consumerKey = $this->settings->get_option('is24-key', 'prt_settings_general');
		$consumerSecret = $this->settings->get_option('is24-secret', 'prt_settings_general');
		$httpMethod = $method;
		$requestFields = array();
		
		$oauthConsumer = new TOAuthConsumer($consumerKey, $consumerSecret, NULL);
		$oauthRequest = TOAuthRequest::from_consumer_and_token($oauthConsumer, NULL, $httpMethod, $url, $requestFields);
		$oauthRequest->sign_request($signatureMethod, $oauthConsumer, NULL);
		
		$curl = curl_init();
		if($method === 'POST') {
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HEADER => $justHeader,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => json_encode($data),
				CURLOPT_HTTPHEADER => array(
					$oauthRequest->to_header(),
					"Cache-Control: no-cache",
					"Content-Type: application/json"
				),
				)
			);
		} else {
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HEADER => $justHeader,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					$oauthRequest->to_header(),
					"Cache-Control: no-cache"
				),
				)
			);
		}
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		$info = curl_getinfo($curl);
		curl_close($curl);
		
		if($justHeader) $response = $this->get_headers_from_curl_response($response);

		if($info['http_code'] != "200" && $info['http_code'] != "201" ) {
			$debug_info = [$response, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HEADER => $justHeader,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => json_encode($data),
				CURLOPT_HTTPHEADER => array(
					$oauthRequest->to_header(),
					"Cache-Control: no-cache",
					"Content-Type: application/json"
				)
			)];

			if($info['http_code'] == "401") throw new PRT_Exception("Not authorized", $debug_info);
			if($info['http_code'] == "400") throw new PRT_Exception("Bad Request", $debug_info);

			throw new PRT_Exception("Unknown Error", $debug_info);
		}
		
		if ($err) {
			return "Error cURL: ".htmlentities($err);
		} else {
			return [$response, $info];
		}
	}

	private function parseRoomCountToId($roomCount) {
		switch($roomCount) {
			case '1': return 1;
			case '1.5': return 2;
			case '2': return 3;
			case '2.5': return 4;
			case '3': return 5;
			case '3.5': return 6;
			case '4': return 7;
			case '4.5': return 7;
			case '5': return 8;
			case '5.5': return 8;
			case '6': return 9;
		}
		return 3;
	}

	private function parseData(&$data) {

		// -- YEAR PARSING --
		if(!isset($data['year']) || $data['year'] == null) $data['year'] = 1980;
		else {
			$year = $data['year'];
			$num_length = strlen((string) $year);
			if($num_length != 4) {
				$year = explode('-', $year);
				$year = round(($year[0] + $year[1]) / 2);
			}
			$data['year'] = $year;
		}

		// PARSING finish
	}

	private function requestGeolocation($adress) {
		$googleKey = $this->settings->get_option('google-api-key', 'prt_settings_general'); //TODO: check null
		$urlcodedAdress = urlencode($adress);
		$response = file_get_contents("https://maps.googleapis.com/maps/api/geocode/xml?address=".$urlcodedAdress."l&language=de&key=$googleKey");
		$xml = simplexml_load_string($response);

		$status = $xml->xpath("/GeocodeResponse/status/text()")[0];
		if($status == "OK") {
			$street = $xml->xpath("/GeocodeResponse/result/address_component[type = 'route']/short_name/text()")[0];
			$street_number = $xml->xpath("/GeocodeResponse/result/address_component[type = 'street_number']/long_name/text()")[0];
			$city = $xml->xpath("/GeocodeResponse/result/address_component[type = 'locality']/long_name/text()")[0];
			$plz = $xml->xpath("/GeocodeResponse/result/address_component[type = 'postal_code']/long_name/text()")[0];
		}

		if(empty($street)) return 'Bitte geben Sie eine korrekte Straße an.';
		if(empty($street_number)) return 'Bitte geben Sie eine korrekte Straßenummer an.';
		if(empty($city)) return 'Bitte geben Sie eine korrekte Stadt an.';
		if(empty($plz)) return 'Bitte geben Sie eine korrekte Postleitzahl an.';

		$lat = floatval($xml->xpath("/GeocodeResponse/result/geometry/location/lat/text()")[0]);
		$lng = floatval($xml->xpath("/GeocodeResponse/result/geometry/location/lng/text()")[0]);
		
		return ['lat' => $lat, 'lng' => $lng, 'street' => $street, 'street_number' => $street_number, 'city' => $city, 'plz' => $plz];
	}

	private function requestRating(&$data) {
		// Check IS 24 Active
		$is24_active = false;

		if($this->settings->get_option('is24-key', 'prt_settings_general') != "" && $this->settings->get_option('is24-secret', 'prt_settings_general') != "") {
			$is24_key = $this->settings->get_option('is24-key', 'prt_settings_general');
			$is24_secret = $this->settings->get_option('is24-secret', 'prt_settings_general');
			$is24_active = true;
		}

		if($is24_active) {
			$geo = $this->requestGeolocation($data['address']);
			//$coord = ['lat' => 9.735813600000029, 'lng' => 53.2664453]; //Default
			if(!is_array($geo)) throw new Exception("Error while geocoding: " . $geo);
			$coord = $geo;

			if(isset($coord['street'])) {
				$data['full_address'] = $coord['street'].' '.$coord['street_number'].', '.$coord['plz'].', '.$coord['city'];
			}

			//Parse Room Count to ID
			$rc = $this->parseRoomCountToId($data['rooms']);

			$apiArgs = array(
				'username' => 'me',
				'longitude' => $coord['lng'],
				'latitude' => $coord['lat'], 
				'address' => $data['full_address'],
				'realEstateTypeId' => $data['realEstateTypeId'],
				'constructionYear' => $data['year'],
				'roomCountId' => $rc,
				'livingArea' => $data['living_space'] === null ? 140 : $data['living_space'],
				'siteArea' => $data['footprint'] === null ? 900 : $data['footprint']
			);

			$first = $this->curlToApi('https://rest.immobilienscout24.de/restapi/api/ibw/v2.0.1/valuation/nouser/basic', 'POST', $apiArgs, true);
			if(!is_array($first)) throw new Exception("First request failed: ".$first);
			$otherUrl = str_replace('rest.v.rz.is', 'rest.immobilienscout24.de', $first[0]['Location']);
			$second = $this->curlToApi($otherUrl);
			if(!is_array($second)) throw new Exception("Second request failed: ".$second);

			$response = json_decode($second[0], true);
			$response['status'] = 'success';

			$data['resultAbsolute'] = number_format($response['resultAbsolute'], 2, ',', '.');
			$data['resultPerSqm'] = number_format($response['resultPerSqm'], 2, ',', '.');
			$data['lowAbsolute'] = number_format($response['lowAbsolute'], 2, ',', '.');
			$data['highAbsolute'] = number_format($response['highAbsolute'], 2, ',', '.');
			$data['lowPerSqm'] = number_format($response['lowPerSqm'], 2, ',', '.');
			$data['highPerSqm'] = number_format($response['highPerSqm'], 2, ',', '.');

			return $response;
		} else {
			return array('status' => 'no_rate');
		}
	}

	private function saveToDatabase($data) {
		global $wpdb;

		$sql = $wpdb->prepare("INSERT INTO 
			{$wpdb->prefix}prt_requests 
			(`type`, `salutation`, `firstname`, `lastname`, `phone`, `email`, `address`, `wohnflache`, `zimmer`, `baujahr`, `grundflache`, `etage`, `erschlossen`, `bebauung`, `zuschnitt`, `resultAbsolute`, `lowAbsolute`, `highAbsolute`, `resultPerSqm`, `lowPerSqm`, `highPerSqm`)
			VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%d', '%d', '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d');",
			[
				$data['type'],
				$data['salutation'],
				$data['firstname'],
				$data['lastname'],
				$data['phone'],
				$data['email'],
				$data['address'],
				$data['living_space'],
				$data['rooms'],
				$data['construction_year'],
				$data['footprint'],
				$data['floor'],
				$data['opened_up'],
				$data['building'],
				$data['cut'],
				$data['response']['resultAbsolute'],
				$data['response']['lowAbsolute'],
				$data['response']['highAbsolute'],
				$data['response']['resultPerSqm'],
				$data['response']['lowPerSqm'],
				$data['response']['highPerSqm']

		]);
		$wpdb->query($sql);
	}

	private function emailTo($data, $toType = 'customer') {
		$email_content = $this->settings->get_option('email-content-'.$toType, 'prt_settings_email');
		$email_subject = $this->settings->get_option('email-subject-'.$toType, 'prt_settings_email');
		$email_header = array('Content-Type: text/html; charset=UTF-8');
		$toBeReplaced = [
			"{{IMMOBILIEN_TYP}}" => $data['type'],
			"{{ANREDE}}" => $data['salutation'],
			"{{VORNAME}}" => $data['firstname'],
			"{{NACHNAME}}" => $data['lastname'],
			"{{TELEFON}}" => $data['phone'],
			"{{EMAIL}}" => $data['email'],
			"{{ADRESSE}}" => $data['address'],
			"{{WOHNFLACHE}}" => $data['living_space'],
			"{{ZIMMER}}" =>	$data['rooms'],
			"{{BAUJAHR}}" => $data['construction_year'],
			"{{GRUNDFLACHE}}" => $data['footprint'],
			"{{ETAGE}}" => $data['floor'],
			"{{ERSCHLOSSEN}}" => $data['opened_up'],
			"{{BEBAUUNG}}" => $data['building'],
			"{{ZUSCHNITT}}" => $data['cut'],
			"{{GESAMT_ERGEBNIS}}" => $data['response']['resultAbsolute'].' €',
			"{{MIN_GESAMT_ERGEBNIS}}" => $data['response']['lowAbsolute'].' €',
			"{{MAX_GESAMT_ERGEBNIS}}" => $data['response']['highAbsolute'].' €',
			"{{ERGEBNIS_PRO_QM}}" => $data['response']['resultPerSqm'].' €',
			"{{MIN_ERGEBNIS_PRO_QM}}" => $data['response']['lowPerSqm'].' €',
			"{{MAX_ERGEBNIS_PRO_QM}}" => $data['response']['highPerSqm'].' €'
		];
		$email_content = strtr($email_content, $toBeReplaced);
		$email_subject = strtr($email_subject, $toBeReplaced);

		if($toType == 'customer') {
			wp_mail($data['email'], $email_subject, $email_content, $email_header);
		} else {
			$dir = PRT_DIR_HOME. 'admin/openimmo_exports/';
			$this->generateOpenImmoXML($data, $dir);
			$attachment = array($data['openimmo_file']);
			wp_mail($this->settings->get_option('admin-email', 'prt_settings_email'), 
					$email_subject, $email_content, $email_header, $attachment);
		}
	}

	private function generateOpenImmoXML(&$data, $dir) {
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><openimmo_feedback/>');
		$xml->addChild('version', '1.2.5');
		$x_objekt = $xml->addChild('objekt');
		$x_objekt->addChild('oobj_id', $this->settings->get_option('objectnumber', 'prt_settings_general'));
		$x_interessent = $x_objekt->addChild('interessent');
		$x_interessent->addChild('anrede', $data['salutation']);
		$x_interessent->addChild('vorname', $data['firstname']);
		$x_interessent->addChild('nachname', $data['lastname']);
		$x_interessent->addChild('plz', $data['address']);
		$x_interessent->addChild('ort', $data['salutation']);
		$x_interessent->addChild('tel', $data['phone']);
		$x_interessent->addChild('email', $data['email']);
		$x_interessent->addChild('bevorzugt', 'TEL');
		$x_interessent->addChild('wunsch', 'ANRUF');
		$x_interessent->addChild('anfrage', $this->dataToOIAnfrage($data));
		$file_path = $dir.'openimmo_'.time().'.xml';
		file_put_contents($file_path, "\xEF\xBB\xBF".$xml->asXML());
		$data['openimmo_file'] = $file_path;
	}

	private function dataToOIAnfrage($data) {
		$response = "";
		foreach ($data as $key => $value) {
			if(!is_array($value)) $response .= __($key, 'prt') . ': ' . $value . PHP_EOL;
		}
		return $response;
	}

	private function jsonErrorResponse($msg, $extraMessage = null) {
		$res = ['success' => false, 'msg' => $msg];
		if($extraMessage != null) {
			$res['extra_message'] = $extraMessage;
		}
		echo json_encode($res);
	}

	public function ajax_prt_getsteps() {
		if($_POST['type']) {
			$r = $this->loadStepClass($_POST['type']);
			echo json_encode($r->getResponse());
			wp_die();
		}
		echo 'AJAX Called without POST Data.';
		wp_die();
	}

	public function ajax_prt_geo() {
		$response = ['status' => 'fail'];
		if($_POST['address'] && !empty($_POST['address'])) {
			$geo = $this->requestGeolocation($_POST['address']);
			if(is_array($geo)) {
				$response = ['status' => 'success'];
			} else {
				$response['error'] = $geo;
			}
		}
		echo json_encode($response);
		wp_die();
	}

	public function ajax_prt_submit() {
		if(!empty($_POST['type'])) {
			$r = $this->loadStepClass($_POST['type']);

			try {
				// Validate data and create structure
				$r->validateData();
				$data = $r->collectData();

				// Parsing some required data
				$this->parseData($data);

				// Request data and collect response (as Array)
				$response = $this->requestRating($data);
				$data['response'] = $response;
				$data = array_merge($response, $data);

				//Save to Database
				$this->saveToDatabase($data);

				//Send email to admin
				$this->emailTo($data, 'admin');

				//Send email to customer
				$this->emailTo($data, 'customer');

				// Return response to Client
				echo json_encode($response);
			} catch(PRT_Exception $prt_e) {
				$this->jsonErrorResponse($prt_e->getMessage(), $prt_e->getExtraMessage());
			} catch(Exception $e) {
				$this->jsonErrorResponse($e->getMessage());
			}
			
		}

		wp_die();
	}

	/**
	 * Will be called if PRT_INCLUDE shotcode will be triggerd.
	 *
	 * @since    1.0.0
	 */
	public function shortcode_prt_include() {

		wp_enqueue_script($this->prt);
		wp_enqueue_script('slick');

		wp_localize_script( $this->prt, 'prt_ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

		ob_start();
		require plugin_dir_path( __FILE__ ) . 'partials/prt-public-shortcode-prt_include.php';
		$shortcode_response = ob_get_clean();

		return $shortcode_response;
	}

}
