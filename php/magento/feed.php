 public function getFeedData()
    {
        $xml = '';
        try {
            $client = new Zend_Http_Client($this->getFeedUrl());
            $client->setConfig(array('maxredirects' => 0, 'timeout' => 5));
            $data = $client->request(Zend_Http_Client::GET);
            if ($data = $data->getBody()) {
                $xml  = new SimpleXMLElement($data);
            }
        }
        catch (Exception $e) {
            return false;
        }

        return $xml;
    }
