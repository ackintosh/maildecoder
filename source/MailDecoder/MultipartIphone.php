<?php
class MailDecoder_MultipartIphone extends MailDecoder_AbstractMailMultipart
{
    protected function initialize()
    {
        $this->properties['headers'] = $this->structure->headers;

        foreach ($this->structure->parts as $part) {
            switch ($part->ctype_primary) {
                case 'multipart':
                    foreach ($part->parts as $p) {
                        $this->setBody($p);
                    }
                    break;
                case 'text':
                    $this->setBody($part);
                    break;
                case 'image':
                    $image = new MailDecoder_Image($part);
                    $this->images[$image->attachment_id] = $image;
                    if ($image->disposition === 'inline') {
                        $this->setInlineImageToBody($image);
                    }
                    break;
                default:
                    break;
            }
        }
    }

    protected function setBody($part)
    {
        if (isset($part->ctype_primary) && $part->ctype_primary === 'text') {
            foreach (array('plain', 'html') as $type) {
                if (!isset($this->properties['body'][$type])) {
                    $this->properties['body'][$type] = '';
                }
                $this->properties['body'][$type] .= $part->body;
            }
        }
    }

    protected function setInlineImageToBody(MailDecoder_Image $image)
    {
        if (!isset($this->properties['body']['html'])) {
            $this->properties['body']['html'] = '';
        }
        $this->properties['body']['html'] .= <<<__EOS__

<img src="cid:{$image->attachment_id}">

__EOS__;
    }
}
