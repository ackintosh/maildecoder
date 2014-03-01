<?php
class MailDecoder_MultipartIphoneTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $input = file_get_contents(realpath(dirname(__FILE__) . '/../') . '/data/html_iphone_mail.txt');
        $this->mail = MailDecoder_Factory::decode($input);
    }

    /**
     * @test
     */
    public function initializeSetsTheProperties()
    {
        $this->assertTrue(!is_null($this->mail->body['html']));
        $this->assertTrue(!is_null($this->mail->body['plain']));
        $images = $this->mail->getImages();
        $this->assertTrue(!empty($images));
    }

    /**
     * @test
     */
    public function getBodyReturnsBodyWithHTMLTag()
    {
        $expect = 'テストテスト\r\n\r\n\n<img src=\"cid:.*\">\n\r\nテストテスト\r\n\r\n\r\n';
        $this->assertTrue(preg_match("#^{$expect}$#", $this->mail->getBody()) === 1);
    }

    /**
     * @test
     */
    public function getBodyWithPlainReturnsBody()
    {
        $expect = <<<__EOS__
テストテスト\r\n\r\n\r\nテストテスト\r\n\r\n\r\n
__EOS__;
        $this->assertSame($expect, $this->mail->getBody('plain'));
    }
}
