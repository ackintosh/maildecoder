<?php
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
        switch (strtolower($structure->ctype_primary)) {
            case 'multipart':
                return new MailDecoder_Multipart($structure);
                break;
            default:
                return new MailDecoder_Plain($structure);
                break;
        }
    }
}
