<?php
Mage::getSingleton('core/session')->addSuccess('Success Message');
Mage::getSingleton('core/session')->addError('Error Message');
Mage::getSingleton('core/session')->addWarning('Warning Message');
Mage::getSingleton('core/session')->addNotice('Notice Message');
?>
