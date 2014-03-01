<?php
class MailDecoder_FactoryTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $test_dir = realpath(dirname(__FILE__) . '/../');
        $this->input_htmlmail = file_get_contents($test_dir . '/data/html_mail.txt');
        $this->input_htmlIphonemail = file_get_contents($test_dir . '/data/html_iphone_mail.txt');
        $this->input_plainmail = file_get_contents($test_dir . '/data/plain_mail.txt');
    }

    /**
     * @test
     */
    public function decodeReturnsMailDecoderMultipart()
    {
        $mail = MailDecoder_Factory::decode($this->input_htmlmail);
        $this->assertSame('MailDecoder_Multipart', get_class($mail));
    }

    /**
     * @test
     */
    public function decodeReturnsMailDecoderMultipartIphone()
    {
        $mail = MailDecoder_Factory::decode($this->input_htmlIphonemail);
        $this->assertSame('MailDecoder_MultipartIphone', get_class($mail));
    }

    /**
     * @test
     */
    public function decodeReturnsMailDecoderPlain()
    {
        $mail = MailDecoder_Factory::decode($this->input_plainmail);
        $this->assertSame('MailDecoder_Plain', get_class($mail));
    }
}
