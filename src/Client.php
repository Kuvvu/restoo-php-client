<?php
namespace Restoo;

class Client
{
    public function __construct($options = null)
    {
        if (!is_array($options)) {
            return false;
        }
        if (isset($options['api'])) {
            $this->api = $options['api'];
        } else {
            return false;
        }
        if (isset($options['cache']) && $options['cache'] == true) {
            $this->cache   = true;
            $this->pool    = new \Stash\Pool(new \Stash\Driver\FileSystem());
            $this->expires = (isset($options['expires'])) ? $options['expires'] : 600;
        } else {
            $this->cache = false;
        }
        if (isset($options['header']) && is_array($options['header'])) {
            $this->header = $options['header'];
        } else {
            $this->header = ['Content-Type: application/json'];
        }
    }

    public function __call($name, $arguments)
    {
        array_unshift($arguments, $name);

        if ($this->cache) {
            $cache  = $this->pool->getItem('/'.md5(json_encode($arguments)));
            $output = $cache->get();

            if ($cache->isMiss()) {
                $cache->lock();
                $output = call_user_func_array([$this, 'curl'], array($arguments));

                $cache->setTTL($this->expires);
                $cache->set($output);

                $this->pool->save($cache);
            }

            return json_decode($output);
        } else {
            return json_decode(call_user_func_array([$this, 'curl'], array($arguments)));
        }
    }

    public function deleteFromCache($item){
      $this->pool->deleteItem($item);
    }

    public function purgeCache(){
      $this->pool->clear();
      $this->pool->purge();
    }

    private function curl(array $arguments)
    {
        $endpoint = array_shift($arguments);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api.'/'.$endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arguments));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
