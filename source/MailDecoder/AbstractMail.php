<?php
abstract class MailDecoder_AbstractMail
{
    /**
     * Convert encoding and return it.
     *
     * @param   string  $str    String to convert
     * @return  string
     * @access  private
     */
    protected function convert($str)
    {
        return mb_convert_encoding($str, 'UTF-8', 'ISO-2022-JP');
    }

    abstract protected function initialize();
    abstract public function getBody();
    abstract public function getSubject();
}
