<?php

namespace ACL\MainBundle\Resizer;

use Imagine\Image\ImagineInterface;
use Imagine\Image\Box;
use Gaufrette\File;
use Imagine\Image\Point;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Resizer\ResizerInterface;
use Imagine\Image\ImageInterface;
use Imagine\Exception\InvalidArgumentException;
use Sonata\MediaBundle\Metadata\MetadataBuilderInterface;

class CustomResizer implements ResizerInterface
{
    protected $adapter;
    protected $mode;
    protected $metadata;

    /**
     * @var Point
     */
    protected $cropPoint;

    /**
     * @param ImagineInterface $adapter
     * @param string $mode
     */
    public function __construct(ImagineInterface $adapter, $mode, MetadataBuilderInterface $metadata)
    {
        $this->adapter = $adapter;
        $this->mode = $mode;
        $this->metadata = $metadata;
    }

    /**
     * {@inheritdoc}
     */
    public function resize(MediaInterface $media, File $in, File $out, $format, array $settings)
    {
        if (!(isset($settings['width']) && $settings['width']))
            throw new \RuntimeException(sprintf('Width parameter is missing in context "%s" for provider "%s"', $media->getContext(), $media->getProviderName()));

        $image = $this->adapter->load($in->getContent());

        $content = $image
            ->thumbnail($this->getBox($media, $settings), $this->mode)
            ->resize($this->getBox($media, $settings))
            ->get($format, array('quality' => $settings['quality']));

        $out->setContent($content, $this->metadata->get($media, $out->getName()));
    }

    /**
     * {@inheritdoc}
     */
    public function getBox(MediaInterface $media, array $settings)
    {
        $size = $media->getBox();
        $hasWidth = isset($settings['width']) && $settings['width'];
        $hasHeight = isset($settings['height']) && $settings['height'];

        if (!$hasWidth && !$hasHeight)
            throw new \RuntimeException(sprintf('Width/Height parameter is missing in context "%s" for provider "%s". Please add at least one parameter.', $media->getContext(), $media->getProviderName()));

        if ($hasWidth && $hasHeight)
            return new Box($settings['width'], $settings['height']);

        if (!$hasHeight)
            $settings['height'] = intval($settings['width'] * $size->getHeight() / $size->getWidth());

        if (!$hasWidth)
            $settings['width'] = intval($settings['height'] * $size->getWidth() / $size->getHeight());

        return $this->computeBox($media, $settings);
    }

    /**
     * @throws InvalidArgumentException
     *
     * @param MediaInterface $media
     * @param array $settings
     *
     * @return Box
     */
    private function computeBox(MediaInterface $media, array $settings)
    {
        if ($this->mode !== ImageInterface::THUMBNAIL_INSET && $this->mode !== ImageInterface::THUMBNAIL_OUTBOUND)
            throw new InvalidArgumentException('Invalid mode specified');

        $size = new Box($settings['width'], $settings['height']);

        $ratios = array(
            $settings['width'] / $size->getWidth(),
            $settings['height'] / $size->getHeight()
        );

        if ($this->mode === ImageInterface::THUMBNAIL_INSET)
            $ratio = min($ratios);
        else
            $ratio = max($ratios);

        $size->scale($ratio);


        //original size
        $srcBox = $media;
        //we scale on the smaller dimension
        if ($srcBox->getWidth() > $srcBox->getHeight()) {
            $width = $srcBox->getWidth() * ($size->getHeight() / $srcBox->getHeight());
            $height = $size->getHeight();
            //we center the crop in relation to the width
            $this->cropPoint = new Point((max($width - $size->getWidth(), 0)) / 2, 0);
        } else {
            $width = $size->getWidth();
            $height = $srcBox->getHeight() * ($size->getWidth() / $srcBox->getWidth());
            //we center the crop in relation to the height
            $this->cropPoint = new Point(0, (max($height - $size->getHeight(), 0)) / 2);
        }

        return new Box($width, $height);

    }
}