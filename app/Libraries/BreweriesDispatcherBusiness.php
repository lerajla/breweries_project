<?php

namespace app\Libraries;

use Exception;
use App\Dto\DispatcherDto;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Log;

/**
 * Class BreweriesDispatcherBusiness
 */
class BreweriesDispatcherBusiness
{
      /**
    * @var string
    */
    private $baseurl;

    /**
    * @var bool
    */
    private $verify;

    /**
     * BreweriesDispatcherBusiness constructor.
     */
    public function __construct()
    {
        $this->baseurl = config('app.breweriesDispatcherRest.baseUrl');
        $this->verify = config('app.breweriesDispatcherRest.verify');
    }

    /**
     * @return DispatcherDto
     */
    public function listBreweries(): DispatcherDto
    {   
        $endpoint = "$this->baseurl/breweries";

        return $this->handler('GET', $endpoint);
    }


    /**
     * @param string $verb
     * @param string $endpoint
     * @return DispatcherDto
     */
    private function handler(string $verb, string $endpoint): DispatcherDto
    {
      $resultDto = new DispatcherDto();
      $client = new Client([
            'verify'  => $this->verify,
        ]);

      try {
          /** @var ResponseInterface $response */
          $response = $client->$verb($endpoint);
          $resultDto->setSuccess(true);
          $resultDto->setData($response->getBody()->getContents());
      } catch (ConnectException $e) {
          Log::channel('app')->error('Failed operation:: ConnectExceptionMessage: ' . $e->getMessage() . ']');
          $resultDto->setMessage($e->getMessage());
      } catch (Exception $e) {
          Log::channel('app')->error('Failed operation:: ExceptionMessage: ' . $e->getMessage() . ']');
          $resultDto->setMessage($e->getMessage());
      }

      return $resultDto;
    }

}
