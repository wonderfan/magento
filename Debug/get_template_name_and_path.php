<?php
echo $this->getChild($name)->getTemplate();

echo $this->getLayout()->getBlock($name)->getTemplate();

echo $this->getChild($name)->getTemplateFile();

echo $this->getLayout()->getBlock($name)->getTemplateFile();
