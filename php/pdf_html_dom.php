<?php

class IndexController extends Zend_Controller_Action
{
    const INDUSTRY_TYPE="The primary activities of this industry are";
	const MAJOR_PRODUCTS="The major products and services in this industry are";	
	const INDUSTRY_STRUCTURE="Industry Structure";
	const KEY_BUYING = "KEY BUYING INDUSTRIES";
	const KEY_SELLING = "KEY SELLING INDUSTRIES";
	
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $file = dirname(__FILE__).DIRECTORY_SEPARATOR.'beer.pdf';   
		$jar = dirname(__FILE__).DIRECTORY_SEPARATOR.'pdfbox.jar';
		$html = dirname(__FILE__).DIRECTORY_SEPARATOR.'report.html';
        shell_exec("java -jar $jar ExtractText -html $file $html ");	
        $industryType = "";		
		$majorProducts = array();
		$industryStructure = array();
		$keyBuyIndustries = array();
		$keySellIndustries = array();
		if(file_exists($html)){
		  $xmlDoc = new DOMDocument();
		  $xmlDoc->loadHTMLFile($html);
		  $xmlDoc->normalizeDocument();
		  $domNodes = $xmlDoc->getElementsByTagName("p");
		  $length = $domNodes->length;		  
		  for($i=0;$i<$length;$i++) {
		    $node = trim($domNodes->item($i)->nodeValue);
			$node = preg_replace('/\s+/', ' ', $node);
			if(empty($node))continue;
			if(self::INDUSTRY_TYPE==$node){
			   $industryType = $domNodes->item($i+1)->nodeValue;
			};
			
			if(self::MAJOR_PRODUCTS == $node){
			  $majorProducts = array($domNodes->item($i+1)->nodeValue,
			  $domNodes->item($i+2)->nodeValue,
			  $domNodes->item($i+3)->nodeValue,
			  $domNodes->item($i+4)->nodeValue,
			  $domNodes->item($i+5)->nodeValue,
			  $domNodes->item($i+6)->nodeValue
			  );			
			}
			
			if(substr($node,0,strlen(self::INDUSTRY_STRUCTURE)) == self::INDUSTRY_STRUCTURE){	
			  $nodeValue = substr($node,strlen(self::INDUSTRY_STRUCTURE));
			  $key = substr($nodeValue,0,strrpos($nodeValue," "));
			  $value = substr($nodeValue,strrpos($nodeValue," ")+1);
			  $industryStructure[$key]= $value;
			  for($k=1;$k<=9;$k++){
			  $nodeValue =  trim($domNodes->item($i+$k)->nodeValue);
			  $key = substr($nodeValue,0,strrpos($nodeValue," "));
			  $value = substr($nodeValue,strrpos($nodeValue," ")+1);
			  $industryStructure[$key]= $value;	
			  }
			};
			
			if(self::KEY_BUYING==$node){
			  for($k=1;$k<=5;$k++){
			  $nodeValue = trim($domNodes->item($i+$k)->nodeValue);
			  $key = substr($nodeValue,0,strpos($nodeValue," "));
			  $value = substr($nodeValue,strpos($nodeValue," ")+1);
			  $keyBuyIndustries[$key]= $value;	
			  }
			};	
            if(self::KEY_SELLING==$node){
			  for($k=1;$k<=5;$k++){
			  $nodeValue =  trim($domNodes->item($i+$k)->nodeValue);
			  $key = substr($nodeValue,0,strpos($nodeValue," "));
			  $value = substr($nodeValue,strpos($nodeValue," ")+1);
			  $keySellIndustries[$key]= $value;	
			  }
			};			 
		} 		  
		@unlink($html);
		}	
        		
             
        $this->view->industryType = $industryType;
        $this->view->majorProducts = $majorProducts;
		$this->view->industryStructure = $industryStructure;
		$this->view->keyBuy = $keyBuyIndustries;
		$this->view->keySell = $keySellIndustries;
    }

   
	
    public function pdf2txt($data)
    {
        /**
         * Split apart the PDF document into sections. We will address each
         * section separately.
         */
        $a_obj = $this->getDataArray($data, "obj", "endobj");
        $j     = 0;
 
        /**
         * Attempt to extract each part of the PDF document into a "filter"
         * element and a "data" element. This can then be used to decode the
         * data.
         */
        foreach ($a_obj as $obj) {
            $a_filter = $this->getDataArray($obj, "<<", ">>");
            if (is_array($a_filter) && isset($a_filter[0])) {
                $a_chunks[$j]["filter"] = $a_filter[0];
                $a_data = $this->getDataArray($obj, "stream", "endstream");
                if (is_array($a_data) && isset($a_data[0])) {
                    $a_chunks[$j]["data"] = trim(substr($a_data[0], strlen("stream"), strlen($a_data[0]) - strlen("stream") - strlen("endstream")));
                }
                $j++;
            }
        }
 
        $result_data = NULL;
 
        // decode the chunks
        foreach ($a_chunks as $chunk) {
            // Look at each chunk decide if we can decode it by looking at the contents of the filter
            if (isset($chunk["data"])) {
                // look at the filter to find out which encoding has been used
                if (strpos($chunk["filter"], "FlateDecode") !== false) {
                    // Use gzuncompress but supress error messages.
                    $data =@ gzuncompress($chunk["data"]);
                    if (trim($data) != "") {
                        // If we got data then attempt to extract it.
                        $result_data .= ' ' . $this->ps2txt($data);
                    }
                }
            }
        }
        /**
         * Make sure we don't have large blocks of white space before and after
         * our string. Also extract alphanumerical information to reduce
         * redundant data.
         */
        $result_data = trim(preg_replace('/([^a-z0-9 ])/i', ' ', $result_data));
 
        // Return the data extracted from the document.
        if ($result_data == "") {
            return NULL;
        } else {
            return $result_data;
        }
    }
 
    /**
     * Strip out the text from a small chunk of data.
     *
     * @param  string $ps_data The chunk of data to convert.
     * @return string          The string extracted from the data.
     */
    public function ps2txt($ps_data)
    {
        // Stop this function returning bogus information from non-data string.
        if (ord($ps_data[0]) < 10) {
            return $ps_data;
        }
        if (substr($ps_data, 0, 8 ) == '/CIDInit') {
            return '';
        }
 
        $result = "";
 
        $a_data = $this->getDataArray($ps_data, "[", "]");
 
        // Extract the data.
        if (is_array($a_data)) {
            foreach ($a_data as $ps_text) {
                $a_text = $this->getDataArray($ps_text, "(", ")");
                if (is_array($a_text)) {
                    foreach ($a_text as $text) {
                        $result .= substr($text, 1, strlen($text) - 2);
                    }
                }
            }
        }
 
        // Didn't catch anything, try a different way of extracting the data
        if (trim($result) == "") {
            // the data may just be in raw format (outside of [] tags)
            $a_text = $this->getDataArray($ps_data, "(", ")");
            if (is_array($a_text)) {
                foreach ($a_text as $text) {
                    $result .= substr($text, 1, strlen($text) - 2);
                }
            }
        }
 
        // Remove any stray characters left over.
        $result = preg_replace('/\b([^a|i])\b/i', ' ', $result);
        return trim($result);
    }
 
    /**
     * Convert a section of data into an array, separated by the start and end words.
     *
     * @param  string $data       The data.
     * @param  string $start_word The start of each section of data.
     * @param  string $end_word   The end of each section of data.
     * @return array              The array of data.
     */
    public function getDataArray($data, $start_word, $end_word)
    {
        $start    = 0;
        $end      = 0;
        $a_result = array();
 
        while ($start !== false && $end !== false) {
            $start = strpos($data, $start_word, $end);
            $end   = strpos($data, $end_word, $start);
            if ($end !== false && $start !== false) {
                // data is between start and end
                $a_result[] = substr($data, $start, $end - $start + strlen($end_word));
            }
        }
 
        return $a_result;
    }

}
