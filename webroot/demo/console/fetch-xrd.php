<?php

$response = array();

$xrdArray = isset($_REQUEST['xrds']) ? $_REQUEST['xrds'] : null; // allow GET and POST

if (is_array($xrdArray))
{
    $data = new stdClass();
    foreach ($xrdArray as $xrd)
    {
        $xmlString = file_get_contents($xrd);
        if ($xmlString)
        {
            $xml = new SimpleXMLElement($xmlString);
            if ($xml && $xml->Subject)
            {
                $xrdObj = new stdClass();
                $xrdObj->xrd = $xrd;
                
                foreach ($xml->Link as $link)
                {
                    $key = null; // we might not care about this
                    switch ($link['rel'])
                    {
                        case 'icon':
                            $key = 'icon';
                            break;
                        case 'icon-32':
                        case 'icon32':
                            $key = 'icon32';
                            break;
                        case 'http://www.oexchange.org/spec/0.8/rel/offer':
                            $key = 'offer';
                            break;
                    }
                    if (!is_null($key)) $xrdObj->{$key} = (string)$link['href'];
                }
                
                foreach ($xml->Property as $property)
                {
                    $key = null; // we might not care about this
                    switch ($property['type'])
                    {
                        case 'http://www.oexchange.org/spec/0.8/prop/name':
                            $key = 'name';
                            break;
                        case 'http://www.oexchange.org/spec/0.8/prop/prompt':
                            $key = 'prompt';
                            break;
                        case 'http://www.oexchange.org/spec/0.8/prop/title':
                            $key = 'title';
                            break;
                    }
                    if (!is_null($key)) $xrdObj->{$key} = (string)$property;
                }
                
                $data->{$xrd} = $xrdObj;
            }
        }
    }
    $response['data'] = $data;
}

header('Content-type: application/json');
echo json_encode($response);
