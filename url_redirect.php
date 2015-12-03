<?php

	   $url = $this->getRequest()->getRequestUri();
	   if(strpos($url,'admin') == false){
		   if(strpos($url,'index.php') !== false){
			   $url = str_replace('/index.php', '', $url);
			   $this->getRequest()->setRequestUri($url);
			   $this->getResponse()->setRedirect($url,301);
		   }
		   if(substr($url, -1)=='/'){
			   $url = substr($url, 0, -1);
			   $this->getRequest()->setRequestUri($url);
			   $this->getResponse()->setRedirect($url,301);
		   }
	   }
