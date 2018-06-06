<?php
namespace Restoo;

class Client
{
    public function __construct($options = null)
    {
      if (!is_array($options)) return false;
  		if (!isset($options['api'])) return false;
      if (isset($options['api'])) {
        $this->api = $options['api'];
      } else {
        return false;
      }
      if(isset($options['header']) && is_array($options['header'])){
        $this->header = $options['header'];
      } else {
        $this->header = ['Content-Type: application/json'];
      }
    }

    private function curl(Array $arguments)
    {
      $endpoint = array_shift($arguments);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $this->api.'/'.$endpoint);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arguments));
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_ENCODING , "gzip");
      $output = curl_exec($ch);
      curl_close($ch);
      return json_decode($output);
    }

    public function __call($name, $arguments)
  	{
      array_unshift($arguments, $name);
      return call_user_func_array([$this, 'curl'], array($arguments));
  	}

}
