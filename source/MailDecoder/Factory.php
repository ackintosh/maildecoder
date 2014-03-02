<?php
require dirname(__FILE__) . '/Exception/InvalidMailData.php';

class MailDecoder_Factory
{
    private function __construct() {
    }

    /**
     * Decoding and create an object.
     *
     * @param   string  $input  The input to decode
     * @return  object
     * @access  public
     */
    public static function decode($input)
    {
        $params['include_bodies'] = true;
        $params['decode_bodies']  = true;
        $params['decode_headers'] = true;
        $params['crlf'] = "\r\n";
        $params['input'] = $input;
        $mimeDecode = new Mail_mimeDecode($params['input']);
        $structure = $mimeDecode->decode($params);

        $pear = new PEAR;
        if ($pear->isError($structure)) {
            throw new MailDecoder_Exception_InvalidData($structure->getMessage(), $structure->getCode());
        }

        switch (strtolower($structure->ctype_primary)) {
            case 'multipart':
                if (isset($structure->headers['x-mailer']) && strpos($structure->headers['x-mailer'], 'iPhone Mail') === 0) {
                    return new MailDecoder_MultipartIphone($structure);
                }
                return new MailDecoder_Multipart($structure);
                break;
            default:
                return new MailDecoder_Plain($structure);
                break;
        }
    }
}
