# MailDecoder

Library for HTML mail decoding.

[![Build
Status](https://travis-ci.org/ackintosh/maildecoder.png?branch=master)](https://travis-ci.org/ackintosh/maildecoder)

## Usage

```php
$mail = Mailer_Factory::decode($maildata);

echo $mail->getSubject();
echo $mail->getBody();

// Get the images that inserted in HTMLmail body.
// array('attachment_id' => Image object)
$images = $mail->getImages();

foreach ($images as $id => $img) {
    $result = $img->save("./img_dir/{$id}.{$img->ext}");
}
```
