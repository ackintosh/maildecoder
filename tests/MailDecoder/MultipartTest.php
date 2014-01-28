<?php
class MailDecoder_MultipartTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $input = file_get_contents(realpath(dirname(__FILE__) . '/../') . '/data/html_mail.txt');
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
        $expect = <<<__EOS__
<div dir="ltr">HTMLメール本文<br><font color="#ff0000">HTMLメール本文(赤)</font><div><br></div><div>画像1</div><div><img src="cid:ii_1438acc4a5d01c06" alt="埋め込み画像 1"><br></div><div><br></div><div>画像2</div><div><img src="cid:ii_1438accdfe796b02" alt="埋め込み画像 2"><br>\r\n</div></div>\r\n
__EOS__;
        $this->assertSame($expect, $this->mail->getBody());
    }

    /**
     * @test
     */
    public function getBodyWithPlainReturnsBody()
    {
        $expect = <<<__EOS__
HTMLメール本文\r\nHTMLメール本文(赤)\r\n\r\n画像1\r\n[image: 埋め込み画像 1]\r\n\r\n画像2\r\n[image: 埋め込み画像 2]\r\n\r\n
__EOS__;

        $this->assertSame($expect, $this->mail->getBody('plain'));
    }

    /**
     * @test
     */
    public function getSubject()
    {
        $this->assertSame('HTMLメール件名', $this->mail->getSubject());
    }
}
