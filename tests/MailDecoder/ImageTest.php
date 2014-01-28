<?php
class MailDecoder_ImageTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $input = file_get_contents(realpath(dirname(__FILE__) . '/../') . '/data/html_mail.txt');
        $mail = MailDecoder_Factory::decode($input);
        $images = $mail->getImages();
        foreach ($images as $k => $i) {
            // $this->(attachment_id)
            $this->$k = $i;
        }

        $this->save_dir = dirname(__FILE__) . '/image';

        // clean up.
        foreach (new DirectoryIterator($this->save_dir) as $file) {
            if ($file->isFile()) unlink($file->getPathname());
        }
    }

    /**
     * @test
     */
    public function initializeSetsTheProperties()
    {
        $this->assertSame('png', $this->ii_1438accdfe796b02->ext);
        $this->assertSame('png', $this->ii_1438acc4a5d01c06->ext);
    }

    /**
     * @test
     */
    public function savePutsImage()
    {
        $this->ii_1438accdfe796b02->save($this->save_dir . '/ii_1438accdfe796b02.' . $this->ii_1438accdfe796b02->ext);
        $this->assertTrue(file_exists($this->save_dir . '/ii_1438accdfe796b02.' . $this->ii_1438accdfe796b02->ext));


        $this->ii_1438acc4a5d01c06->save($this->save_dir . '/ii_1438acc4a5d01c06.' . $this->ii_1438acc4a5d01c06->ext);
        $this->assertTrue(file_exists($this->save_dir . '/ii_1438acc4a5d01c06.' . $this->ii_1438acc4a5d01c06->ext));

    }
}
