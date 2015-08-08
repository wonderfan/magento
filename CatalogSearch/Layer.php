		if (strlen(Mage::helper('catalogSearch')->getQueryText())) {
			$searchOrder = Mage::app()->getRequest()->getParam('order');			
			if(empty($searchOrder)){
				$collection->setOrder('relevance', 'DESC');
			}else{
				if($searchOrder == 'relevance'){
					$searchDir = Mage::app()->getRequest()->getParam('dir');
					if($searchDir == 'desc'){
						$collection->setOrder('relevance', 'DESC');
					}
				}
			}
		}
