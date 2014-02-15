<?php
abstract class MailDecoder_AbstractMailMultipart extends MailDecoder_AbstractMail
{
    /**
     * stdClass returned by Mail_mimeDecode::decode.
     *
     * @var     stdClass
     * @access  protected
     */
    protected $structure;

    /**
     * The properties that accessable via __get method.
     *
     * @var     array
     * @access  protected
     */
    protected $properties;

    /**
     * An array contains MailDecoder_Image object.
     *
     * @var     array
     * @access  protected
     */
    protected $images = array();

    /**
     * Constructor.
     * Sets up the object and initialize the properties.
     *
     * @param   object  $structure
     * @return  void
     */
    public function __construct($structure)
    {
        $this->structure = $structure;
        $this->initialize();
    }

    /**
     * Returns property if exists in '$this->properties'.
     *
     * @param   string  $name   Property name
     * @return  mixed
     * @access  public
     */
    public function __get($name)
    {
        if (!empty($this->properties[$name])) return $this->properties[$name];
    }

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
                    break;
                default:
                    break;
            }
        }
    }

    protected function setBody($part)
    {
        if (isset($part->ctype_primary) && $part->ctype_primary === 'text') {
            if (!isset($this->properties['body'][$part->ctype_secondary])) {
                $this->properties['body'][$part->ctype_secondary] = '';
            }
            $this->properties['body'][$part->ctype_secondary] .= $part->body;
        }
    }

    /**
     * Returns converted subject.
     *
     * @return  string
     * @access  public
     */
    public function getSubject()
    {
        return $this->convert($this->headers['subject']);
    }

    /**
     * Returns converted body.
     *
     * @param   string  $type   Body type to get.
     * @return  string
     * @access  public
     */
    public function getBody($type = 'html')
    {
        return $this->convert($this->body[$type]);
    }

    /**
     * Returns an Array that contains Image object.
     *
     * @return  array
     * @access  public
     */
    public function getImages()
    {
        return $this->images;
    }
}
