<?php 
namespace App\Utilities;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Twilio\Jwt\ClientToken;
use Twilio\Rest\Client as twilioClient;
use App\models\sms\SmsLog;


class Sendsms
{
	public function sendsms($mobile_number,$body)
	{
	 try {
		$getway =get_option('set_sms_gateway');
		 if(!$getway){
		 	throw ValidationException::withMessages(['message' => _lang('SMS gateway not defined!')]);
          }
		if ($getway=='Twillo') {
		  return $this->sendSmsViaTwilio($mobile_number, $body);
		}
		elseif($getway=='Custom')
		{
          $route =get_option('sms_route');
          if ($route=='bulck_route') {
          	return $this->sendSmsViaBulkSmsRoute($mobile_number, $body);
          }
          elseif ($route=='solutionbd') {
          	return $this->sendSmsViaItSolutionbd($mobile_number, $body);
          }
          elseif ($route=='zaman_it') {
          	return $this->sendSmsViaZamanIt($mobile_number, $body);
          }
          elseif ($route=='mim_sms') {
          	return $this->sendSmsViaMimSms($mobile_number, $body);
          }

		}
		else {
            // log sms to file
            Log::channel('smsLog')->info("Send new sms to ".$mobile_number." and message is:\"".$body."\"");
            return true;
          }
	    }
	   catch (Exception $e) {
            //write error log
            Log::channel('smsLog')->error($e->getMessage());
            throw ValidationException::withMessages(['message' => _lang('Something Went Wrong')]);
        }


        return true;

	}

	  private function sendSmsViaMimSms($number, $message) {
        try {
            $client = new Client();
            $uri = get_option('custom_api_url')."?user=".urlencode(get_option('custom_api_key'))."&password=".urlencode(get_option('custom_api_secret'))."&sender=".urlencode(get_option('custom_api_sender_id'))."&SMSText=".urlencode($message)."&GSM=".$number."&type=longSMS";
            $response = $client->get($uri);
            $status = $response->getBody()->getContents();
            if($status !="-5" && $status !="5")
            {
                $log = $this->logSmsToDB($number, $message, "SMS SEND");
            }
            else{
                Log::channel('smsLog')->warning($status.". url=".$uri);
            }

            return true;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            throw ValidationException::withMessages(['message' => _lang('Something Went Wrong')]);
        }
    }


    private function sendSmsViaZamanIt($number, $message) {
        try {

            $client = new Client();
            $uri = get_option('custom_api_url')."?user=".urlencode(get_option('custom_api_key'))."&password=".urlencode(get_option('custom_api_secret'))."&sender=".urlencode(get_option('custom_api_sender_id'))."&SMSText=".urlencode($message)."&GSM=".$number."&type=longSMS";
            $response = $client->get($uri);
            $status = $this->parseXmlResponse($response->getBody()->getContents());

            if($status !="-5" && $status !="5")
            {
                $log = $this->logSmsToDB($number, $message, "SMS SEND");
            }
            else{
                Log::channel('smsLog')->warning($status.". url=".$uri);
            }

            return true;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            throw ValidationException::withMessages(['message' => _lang('Something Went Wrong')]);
        }
    }


    private function sendSmsViaItSolutionbd($number, $message) {
        try {
            $client = new Client();
            $uri = get_option('custom_api_url')."?user=".urlencode(get_option('custom_api_key'))."&password=".urlencode(get_option('custom_api_secret'))."&sender=".urlencode(get_option('custom_api_sender_id'))."&SMSText=".urlencode($message)."&GSM=".$number."&type=longSMS";
            $response = $client->get($uri);
            $status = $response->getBody()->getContents();
            if($status !="-5" && $status !="5")
            {
              $log = $this->logSmsToDB($number, $message, "SMS SEND"); 
            }
            else{
                Log::channel('smsLog')->warning($status.". url=".$uri);
            }

            return true;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            throw ValidationException::withMessages(['message' => _lang('Something Went Wrong')]);
        }
    }

        private function sendSmsViaBulkSmsRoute($number, $message) {
        try {

            $client = new Client();
            $uri = get_option('custom_api_url')."?api_key=".get_option('custom_api_key')."&type=text&contacts=".$number."&senderid=".get_option('custom_api_sender_id')."&msg=".urlencode($message);
            $response = $client->get($uri);
            $status = json_decode($response->getBody());

            $isSuccess = false;
            switch ($status) {
                case "1002":
                    $msg = "Sender Id/Masking Not Found";
                    break;
                case "1003":
                    $msg = "API Not Found";
                    break;
                case "1004":
                    $msg = "SPAM Detected";
                    break;
                case "1005":
                    $msg = "Internal Error";
                    break;
                case "1006":
                    $msg = "Internal Error";
                    break;
                case "1007":
                    $msg = "Balance Insufficient";
                    break;
                case "1008":
                    $msg = "Message is empty";
                    break;
                case "1009":
                    $msg = "Message Type Not Set";
                    break;
                case "1010":
                    $msg = "Invalid User & Password";
                    break;
                case "1011":
                    $msg = "Invalid User Id";
                    break;
                default:
                    $msg = 'SMS SEND';
                    $isSuccess = true;
                    break;
            }

            if($isSuccess) {
            	$log = $this->logSmsToDB($number, $message, "SMS SEND");
                
            }
            else{
                Log::channel('smsLog')->warning($msg.". url=".$uri);
            }

            return true;

        } catch (RequestException $e) {
            throw new Exception($e->getMessage());
        }


    }

	private function sendSmsViaTwilio($number, $message) {

		    $accountSid = get_option("twillo_sid");
	        $authToken  = get_option("twillo_token");
	        $mobileNumber = get_option("twillo_sender_number");

	         $client = new Client($accountSid, $authToken);
	         $response=$client->messages->create(
						$number,
						array(
						 'from' => $mobileNumber,
						 'body' => $message
						  )
						);
	      $log = $this->logSmsToDB($number, $message, "SMS SEND");
	    if($response->errorCode){
            Log::channel('smsLog')->warning($response->errorMessage.". url=twilio api");
        }

        return true;
	}

	 private function parseXmlResponse($response) {
        try {
            $responseXml = simplexml_load_string($response);
            if ($responseXml instanceof \SimpleXMLElement) {
                $status = (string)$responseXml->result->status;
                return $status;
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }

    }

        private function logSmsToDB($to, $message, $status){

        return SmsLog::create([
            'sender_id' => auth()->user()->id,
            'to' => $to,
            'message' => $message,
            'status' => $status,
        ]);

    }
}

 ?>