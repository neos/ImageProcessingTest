<?php
namespace Neos\ImageProcessingTest\Tests\Functional;

use TYPO3\Flow\Resource\ResourceManager;
use TYPO3\Media\Domain\Model\Image;
use TYPO3\Media\Domain\Model\ImageInterface;
use TYPO3\TypoScript\Tests\Functional\TypoScriptObjects\AbstractTypoScriptObjectTest;

/**
 * Testcase for the image "Rendering"
 */
class RenderingTest extends AbstractTypoScriptObjectTest
{

    /**
     * @var boolean
     */
    static protected $testablePersistenceEnabled = true;

    /**
     * @var ResourceManager
     */
    protected $resourceManager;

    /**
     * @var ImageInterface
     */
    protected $originalImage;

    public function setUp()
    {
        parent::setUp();

        if (!$this->persistenceManager instanceof \TYPO3\Flow\Persistence\Doctrine\PersistenceManager) {
            $this->markTestSkipped('Doctrine persistence is not enabled');
        }

        $this->resourceManager = $this->objectManager->get('TYPO3\Flow\Resource\ResourceManager');
        $resource = $this->resourceManager->importResource(__DIR__ . '/Fixtures/ReferenceImage.jpg');
        $this->originalImage = new Image($resource);
    }

    /**
     * {@inheritdoc}
     *
     * @return \TYPO3\TypoScript\View\TypoScriptView
     */
    protected function buildView()
    {
        $view = parent::buildView();
        $view->setPackageKey('Neos.ImageProcessingTest');
        $view->setTypoScriptPathPattern(__DIR__ . '/Fixtures/TypoScript/');
        $view->assign('fixtureDirectory', __DIR__ . '/Fixtures/');
        $view->assign('image', $this->originalImage);

        return $view;
    }

    /**
     * Scenario can be found on Discuss
     *
     * Please keep in sync this test with the thread
     *
     * @return array
     * @see https://discuss.neos.io/t/crop-resize-behavior/464
     */
    public static function processingOption()
    {
        return [
            # Original Image
            [
                'maximumWidth' => null,
                'width' => null,
                'maximumHeight' => null,
                'height' => null,
                'allowUpScaling' => false,
                'allowCropping' => false,
                'expected' => [
                    'isOriginal' => true,
                    'width' => 800,
                    'height' => 600
                ]
            ],
            # Scenario #1
            [
                'maximumWidth' => null,
                'width' => 200,
                'maximumHeight' => null,
                'height' => null,
                'allowUpScaling' => false,
                'allowCropping' => true,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 200,
                    'height' => 150
                ]
            ],
            [
                'maximumWidth' => null,
                'width' => 200,
                'maximumHeight' => null,
                'height' => null,
                'allowUpScaling' => false,
                'allowCropping' => false,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 200,
                    'height' => 150
                ]
            ],
            [
                'maximumWidth' => null,
                'width' => 1200,
                'maximumHeight' => null,
                'height' => null,
                'allowUpScaling' => false,
                'allowCropping' => true,
                'expected' => [
                    'isOriginal' => true,
                    'width' => 800,
                    'height' => 600
                ]
            ],
            [
                'maximumWidth' => null,
                'width' => 1200,
                'maximumHeight' => null,
                'height' => null,
                'allowUpScaling' => false,
                'allowCropping' => false,
                'expected' => [
                    'isOriginal' => true,
                    'width' => 800,
                    'height' => 600
                ]
            ],
            # Scenario #2
            [
                'maximumWidth' => null,
                'width' => 200,
                'maximumHeight' => null,
                'height' => null,
                'allowUpScaling' => true,
                'allowCropping' => true,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 200,
                    'height' => 150
                ]
            ],
            [
                'maximumWidth' => null,
                'width' => 200,
                'maximumHeight' => null,
                'height' => null,
                'allowUpScaling' => true,
                'allowCropping' => false,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 200,
                    'height' => 150
                ]
            ],
            [
                'maximumWidth' => null,
                'width' => 1200,
                'maximumHeight' => null,
                'height' => null,
                'allowUpScaling' => true,
                'allowCropping' => true,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 1200,
                    'height' => 900
                ]
            ],
            [
                'maximumWidth' => null,
                'width' => 1200,
                'maximumHeight' => null,
                'height' => null,
                'allowUpScaling' => true,
                'allowCropping' => false,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 1200,
                    'height' => 900
                ]
            ],
            # Scenario #3
            [
                'maximumWidth' => 200,
                'width' => null,
                'maximumHeight' => null,
                'height' => null,
                'allowUpScaling' => false,
                'allowCropping' => true,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 200,
                    'height' => 150
                ]
            ],
            [
                'maximumWidth' => 200,
                'width' => null,
                'maximumHeight' => null,
                'height' => null,
                'allowUpScaling' => false,
                'allowCropping' => false,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 200,
                    'height' => 150
                ]
            ],
            [
                'maximumWidth' => 1200,
                'width' => null,
                'maximumHeight' => null,
                'height' => null,
                'allowUpScaling' => false,
                'allowCropping' => true,
                'expected' => [
                    'isOriginal' => true,
                    'width' => 800,
                    'height' => 600
                ]
            ],
            [
                'maximumWidth' => 1200,
                'width' => null,
                'maximumHeight' => null,
                'height' => null,
                'allowUpScaling' => false,
                'allowCropping' => false,
                'expected' => [
                    'isOriginal' => true,
                    'width' => 800,
                    'height' => 600
                ]
            ],
            # Scenario #4
            [
                'maximumWidth' => null,
                'width' => 200,
                'maximumHeight' => null,
                'height' => 300,
                'allowUpScaling' => false,
                'allowCropping' => false,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 200,
                    'height' => 150
                ]
            ],
            [
                'maximumWidth' => null,
                'width' => 800,
                'maximumHeight' => null,
                'height' => 1200,
                'allowUpScaling' => false,
                'allowCropping' => false,
                'expected' => [
                    'isOriginal' => true,
                    'width' => 800,
                    'height' => 600
                ]
            ],
            # Scenario #5
            [
                'maximumWidth' => 120,
                'width' => 200,
                'maximumHeight' => 120,
                'height' => 300,
                'allowUpScaling' => false,
                'allowCropping' => false,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 120,
                    'height' => 90
                ]
            ],
            [
                'maximumWidth' => 400,
                'width' => 800,
                'maximumHeight' => 400,
                'height' => 1200,
                'allowUpScaling' => false,
                'allowCropping' => false,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 400,
                    'height' => 300
                ]
            ],
            # Scenario #6
            [
                'maximumWidth' => null,
                'width' => 200,
                'maximumHeight' => null,
                'height' => 300,
                'allowUpScaling' => false,
                'allowCropping' => true,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 200,
                    'height' => 300
                ]
            ],
            [
                'maximumWidth' => null,
                'width' => 800,
                'maximumHeight' => null,
                'height' => 1200,
                'allowUpScaling' => false,
                'allowCropping' => true,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 400,
                    'height' => 600
                ]
            ],
            # Scenario #7
            [
                'maximumWidth' => null,
                'width' => 200,
                'maximumHeight' => null,
                'height' => 100,
                'allowUpScaling' => true,
                'allowCropping' => true,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 200,
                    'height' => 100
                ]
            ],
            [
                'maximumWidth' => null,
                'width' => 1200,
                'maximumHeight' => null,
                'height' => 600,
                'allowUpScaling' => true,
                'allowCropping' => true,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 1200,
                    'height' => 600
                ]
            ],
            [
                'maximumWidth' => null,
                'width' => 200,
                'maximumHeight' => null,
                'height' => 200,
                'allowUpScaling' => true,
                'allowCropping' => true,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 200,
                    'height' => 200
                ]
            ],
            [
                'maximumWidth' => null,
                'width' => 1200,
                'maximumHeight' => null,
                'height' => 1200,
                'allowUpScaling' => true,
                'allowCropping' => true,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 1200,
                    'height' => 1200
                ]
            ],
            [
                'maximumWidth' => 200,
                'width' => null,
                'maximumHeight' => 200,
                'height' => null,
                'allowUpScaling' => true,
                'allowCropping' => true,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 200,
                    'height' => 200
                ]
            ],
            [
                'maximumWidth' => 1200,
                'width' => null,
                'maximumHeight' => 1200,
                'height' => null,
                'allowUpScaling' => true,
                'allowCropping' => true,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 1200,
                    'height' => 1200
                ]
            ],
            # Scenario #8
            [
                'maximumWidth' => 200,
                'width' => null,
                'maximumHeight' => 300,
                'height' => null,
                'allowUpScaling' => false,
                'allowCropping' => true,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 200,
                    'height' => 300
                ]
            ],
            [
                'maximumWidth' => 1200,
                'width' => null,
                'maximumHeight' => 1600,
                'height' => null,
                'allowUpScaling' => false,
                'allowCropping' => true,
                'expected' => [
                    'isOriginal' => false,
                    'width' => 450,
                    'height' => 600
                ]
            ],
        ];
    }

    /**
     * @test
     *
     * @dataProvider processingOption
     */
    public function withProcessingTheImageRespectTheContraints(
        $maximumWidth,
        $width,
        $maximumHeight,
        $height,
        $allowUpScaling,
        $allowCropping,
        array $expected
    ) {
        $view = $this->buildView();
        $view->assignMultiple([
            'maximumWidth' => $maximumWidth,
            'width' => $width,
            'maximumHeight' => $maximumHeight,
            'height' => $height,
            'allowUpScaling' => $allowUpScaling,
            'allowCropping' => $allowCropping
        ]);
        $view->setTypoScriptPath('imageUriProcessing');
        $uri = trim($view->render());
        $image = $this->readImageFromUri($uri);
        $this->assertEquals($expected['width'], $image['width']);
        $this->assertEquals($expected['height'], $image['height']);
        if ($expected['isOriginal'] === true) {
            $this->assertImageIsOriginal($image);
        } else {
            $this->assertImageIsNotOriginal($image);
        }
    }

    /**
     * @param string $uri
     * @return array
     */
    protected function readImageFromUri($uri)
    {
        $uri = parse_url($uri);
        $filename = FLOW_PATH_WEB . trim($uri['path'], '/');
        $size = getimagesize($filename);
        $image = [
            'filename' => $filename,
            'width' => $size[0],
            'height' => $size[1],
        ];

        return $image;
    }

    protected function assertImageIsOriginal($image)
    {

    }

    protected function assertImageIsNotOriginal($image)
    {

    }

    protected function assertImageDimensions($image, $width, $height)
    {

    }

}