<?php
	class Bad {
		private $code;
		private $message;

		function __construct($json) {
			$json = is_string($json)? json_decode($json) : $json;
			if(array_key_exists("code", $json) && array_key_exists("message", $json)) {
				$this->code = $json->{"code"};
				$this->message = $json->{"message"};
			} else {
				error_log("Error creating error object from string " . $json);
			}
		}

		public function getCode() {
			return $this->code;
		}

		public function getMessage() {
			return $this->message;
		}

		public function toJson() {
			$error = array();
			if(!empty($this->code)) {
			    $error["code"] = $this->code;
			}

			if(!empty($this->message)) {
			    $error["message"] = $this->message;
			}
			return json_encode($error);
		}
	}

	final class Latch {
		private static $API_VERSION = "0.9";
		public static $API_HOST = "https://latch.elevenpaths.com";
		public static $API_CHECK_STATUS_URL = "/api/0.9/status";
		public static $API_PAIR_URL = "/api/0.9/pair";
		public static $API_PAIR_WITH_ID_URL = "/api/0.9/pairWithId";
		public static $API_UNPAIR_URL =  "/api/0.9/unpair";
		public static $API_LOCK_URL =  "/api/0.9/lock";
		public static $API_UNLOCK_URL =  "/api/0.9/unlock";
		public static $API_HISTORY_URL =  "/api/0.9/history";
		public static $API_OPERATION_URL =  "/api/0.9/operation";

	      public static $PROXY_HOST = NULL;

	      public static $CA_CERTIFICATE_PATH = NULL;

		public static $AUTHORIZATION_HEADER_NAME = "Authorization";
		public static $DATE_HEADER_NAME = "X-11Paths-Date";
		public static $AUTHORIZATION_METHOD = "11PATHS";
		public static $AUTHORIZATION_HEADER_FIELD_SEPARATOR = " ";

		public static $UTC_STRING_FORMAT = "Y-m-d H:i:s";

		private static $HMAC_ALGORITHM = "sha1";

		public static $X_11PATHS_HEADER_PREFIX = "X-11Paths-";
		private static $X_11PATHS_HEADER_SEPARATOR = ":";


		public static function setHost($host) {
	            Latch::$API_HOST = $host;
		}

	        public static function setProxy($host) {
	            self::$PROXY_HOST = $host;
		}

	        public static function setCACertificatePath($certificatePath) {
	            self::$CA_CERTIFICATE_PATH = $certificatePath;
	        }
		private static function getPartFromHeader($part, $header) {
			if (!empty($header)) {
				$parts = explode(self::$AUTHORIZATION_HEADER_FIELD_SEPARATOR, $header);
				if(count($parts) > $part) {
					return $parts[$part];
				}
			}
			return "";
		}

		public static function getAuthMethodFromHeader($authorizationHeader) {
			return getPartFromHeader(0, $authorizationHeader);
		}
		public static function getAppIdFromHeader($authorizationHeader) {
			return getPartFromHeader(1, $authorizationHeader);
		}
		public static function getSignatureFromHeader($authorizationHeader) {
			return getPartFromHeader(2, $authorizationHeader);
		}

		private $appId;
		private $secretKey;
		function __construct($appId, $secretKey) {
			$this->appId = $appId;
			$this->secretKey = $secretKey;
		}

		public function HTTP($method, $url, $headers, $params) {
			$curlHeaders = array();
			foreach ($headers as $hkey=>$hvalue) {
				array_push($curlHeaders, $hkey . ":" . $hvalue);
			}

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $curlHeaders);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	            curl_setopt($ch, CURLOPT_PROXY, self::$PROXY_HOST);

	            if ($method == "PUT" || $method == "POST"){
	            	$params_string="";
	            	foreach($params as $key=>$value) { $params_string .= $key.'='.$value.'&'; }
				rtrim($params_string, '&');
				curl_setopt($ch,CURLOPT_POST, count($params));
				curl_setopt($ch,CURLOPT_POSTFIELDS, $params_string);
	            }

	            if (self::$CA_CERTIFICATE_PATH != NULL) {
	                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	                curl_setopt($ch, CURLOPT_CAINFO, self::$CA_CERTIFICATE_PATH);
	            } else {
	                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	            }

			$response = curl_exec($ch);
			curl_close($ch);

			return $response;
		}

		private function HTTP_GET_proxy($url) {
			return new Response($this->HTTP("GET", self::$API_HOST . $url, $this->authenticationHeaders("GET", $url, null), null));
		}

		private function HTTP_POST_proxy($url, $params) {
			return new Response($this->HTTP("POST", self::$API_HOST . $url, $this->authenticationHeaders("POST", $url, null, null,$params), $params));
		}

		private function HTTP_PUT_proxy($url, $params) {
			return new Response($this->HTTP("PUT", self::$API_HOST . $url, $this->authenticationHeaders("PUT", $url, null, null, $params), $params));
		}

		private function HTTP_DELETE_proxy($url) {
			return new Response($this->HTTP("DELETE", self::$API_HOST . $url, $this->authenticationHeaders("DELETE", $url, null), null));
		}

		public function pairWithId($accountId) {
			return $this->HTTP_GET_proxy(self::$API_PAIR_WITH_ID_URL . "/" . $accountId);
		}

		public function pair($token) {
			return $this->HTTP_GET_proxy(self::$API_PAIR_URL . "/" . $token);
		}

		public function status($accountId) {
			return $this->HTTP_GET_proxy(self::$API_CHECK_STATUS_URL . "/" . $accountId);
		}

		public function operationStatus($accountId, $operationId) {
			return $this->HTTP_GET_proxy(self::$API_CHECK_STATUS_URL . "/" . $accountId . "/op/" . $operationId);
		}

		public function unpair($accountId) {
			return $this->HTTP_GET_proxy(self::$API_UNPAIR_URL . "/" . $accountId);
		}

		public function lock($accountId, $operationId=null){
			if ($operationId == null){
				return $this->HTTP_POST_proxy(self::$API_LOCK_URL . "/" . $accountId, array());
			}else{
				return $this->HTTP_POST_proxy(self::$API_LOCK_URL . "/" . $accountId . "/op/" . $operationId, array());
			}
		}

		public function unlock($accountId, $operationId=null){
			if ($operationId == null){
				return $this->HTTP_POST_proxy(self::$API_UNLOCK_URL . "/" . $accountId, array());
			}else{
				return $this->HTTP_POST_proxy(self::$API_UNLOCK_URL . "/" . $accountId . "/op/" . $operationId, array());
			}
		}

		public function history($accountId, $from=0, $to=null) {
			if ($to == null){
				$date = time();
				$to = $date*1000;
			}
			return $this->HTTP_GET_proxy(self::$API_HISTORY_URL . "/" . $accountId . "/" . $from . "/" . $to);
		}

		public function createOperation($parentId, $name, $twoFactor, $lockOnRequest){
			$data = array(
				'parentId' => urlencode($parentId),
				'name' => urlencode($name),
				'two_factor' => urlencode($twoFactor),
				'lock_on_request' => urlencode($lockOnRequest));
			return $this->HTTP_PUT_proxy(self::$API_OPERATION_URL, $data);
		}

		public function removeOperation($operationId){
			return $this->HTTP_DELETE_proxy(self::$API_OPERATION_URL . "/" . $operationId);
		}

		public function updateOperation($operationId, $name, $twoFactor, $lockOnRequest){
			$data = array(
				'name' => urlencode($name),
				'two_factor' => urlencode($twoFactor),
				'lock_on_request' => urlencode($lockOnRequest));
			return $this->HTTP_POST_proxy(self::$API_OPERATION_URL . "/" . $operationId, $data);
		}

		public function getOperations($operationId=null){
			if ($operationId == null){
				return $this->HTTP_GET_proxy(self::$API_OPERATION_URL);
			}else{
				return $this->HTTP_GET_proxy(self::$API_OPERATION_URL . "/" . $operationId);
			}
		}
		private function signData($data) {
			return base64_encode(hash_hmac(self::$HMAC_ALGORITHM, $data, $this->secretKey, true));
		}
		public function authenticationHeaders($HTTPMethod, $queryString, $xHeaders=null, $utc=null, $params=null) {
			$utc = trim(($utc!=null) ? $utc : $this->getCurrentUTC());
			$stringToSign = trim(strtoupper($HTTPMethod)) . "\n" .
							$utc . "\n" .
							$this->getSerializedHeaders($xHeaders) . "\n" .
							trim($queryString);

		      if ($params != null && sizeof($params) > 0){
		      	$serializedParams = $this->getSerializedParams($params);
		      	if ($serializedParams != null && sizeof($serializedParams) > 0){
		      		$stringToSign = trim($stringToSign . "\n" . $serializedParams);
		      	}
		      }

			$authorizationHeader = self::$AUTHORIZATION_METHOD .
								   self::$AUTHORIZATION_HEADER_FIELD_SEPARATOR .
								   $this->appId .
								   self::$AUTHORIZATION_HEADER_FIELD_SEPARATOR .
								   $this->signData($stringToSign);

			$headers = array();
			$headers[self::$AUTHORIZATION_HEADER_NAME] = $authorizationHeader;
			$headers[self::$DATE_HEADER_NAME] = $utc;

			return $headers;
		}

		private function getSerializedHeaders($xHeaders) {
			if($xHeaders != null) {
				$headers = array_change_key_case($xHeaders, CASE_LOWER);
				ksort($headers);
				$serializedHeaders = "";

				foreach($headers as $key=>$value) {
					if(strncmp(strtolower($key), strtolower($X_11PATHS_HEADER_PREFIX), strlen($X_11PATHS_HEADER_PREFIX))==0) {
						error_log("Error serializing headers. Only specific " . $X_11PATHS_HEADER_PREFIX . " headers need to be singed");
						return null;
					}
					$serializedHeaders .= $key . $X_11PATHS_HEADER_SEPARATOR . $value . " ";
				}
				return trim($serializedHeaders, "utf-8");
			} else {
				return "";
			}
		}

		private function getSerializedParams($params) {
			if($params != null) {
				ksort($params);
				$serializedParams = "";

				foreach($params as $key=>$value) {
					$serializedParams .= $key . "=" . $value . "&";
				}
				return trim($serializedParams, "&");
			} else {
				return "";
			}
		}

		private function getCurrentUTC() {
			$time = new \DateTime('now', new \DateTimeZone('UTC'));
			return $time->format(self::$UTC_STRING_FORMAT);
		}
	}

	class Response {

		public $data = null;
		public $error = null;


		public function __construct($jsonString) {
			$json = json_decode($jsonString);
			if(!is_null($json)) {
				if (array_key_exists("data", $json)) {
					$this->data = $json->{"data"};
				}
				if (array_key_exists("error", $json)) {
					$this->error = new Bad($json->{"error"});
				}
			}
		}

		public function getData() {
			return $this->data;
		}


		public function setData($data) {
			$this->data = json_decode($data);
		}


		public function getError() {
			return $this->error;
		}


		public function setError($error) {
			$this->error = new Bad($error);
		}

		public function toJSON() {
			$response = array();
			if(!empty($this->data)) {
				$response["data"] = $data;
			}

			if(!empty($error)) {
				$response["error"] = $error;
			}
			return json_encode($response);
		}
	}


	$latch = new Latch('GDAiDEbbdieCHTVpFRAs', '6krru6aw8p3Y88PX7Pn4h98GQNARqwEpsL4RTXyk');
	//$pairResponse = $latch->pair("eDcRfF");
	$statusResponse = $latch->status('rsmXjxcmQWkcHpJ3i6nU9nU7aNThGDAx8eNihnaXXmEL9XmtiCUbLZk3WLbnbeve');
	//$unpairResponse = $latch->unpair('');
	//print_r($pairResponse);
	print_r($statusResponse);
	//print_r($unpairResponse);
