<?
$doc = new DOMDocument('1.0');
$root = $doc->createElement('ajax');
$doc->appendChild($root); 
$child = $doc->createElement('js');
$root->appendChild($child);
$value = $doc->createTextNode("coordination");
$child->appendChild($value );
$strXml = $doc->saveXML();
echo $strXml;
?>
