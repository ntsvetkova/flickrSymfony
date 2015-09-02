<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 01.09.15
 * Time: 15:29
 */

namespace AppBundle\Tests\Models\Mars;
use AppBundle\Exceptions\AppException;
use AppBundle\Models\Mars\Action;
use AppBundle\Models\Mars\Plateau;
use AppBundle\Models\Mars\Rover;

require_once __DIR__ . '/../../../Models/Mars/Rover.php';
require_once __DIR__ . '/../../../Models/Mars/Plateau.php';
require_once __DIR__ . '/../../../Models/Mars/Action.php';
require_once __DIR__ . '/../../../Exceptions/AppException.php';

/**
 * Class ActionTest
 * @package AppBundle\Tests\Models\Mars
 */
class ActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Action
     */
    private $action;
    /**
     * @var array
     */
    private $headings = ['N', 'S', 'E', 'W'];
    /**
     * @var Plateau
     */
    private $plateau;

    /**
     * Values necessary for all tests
     */
    protected function setUp() {
        $this->action = Action::getInstance();
        $this->plateau = Plateau::getInstance();
        $this->plateau->setCoordinates(5,5);
    }

     /**
     * @param int $x
     * @param int $y
     * @param array $plateauCoordinates
     *
     * @dataProvider checkRoverCoordinatesProvider
     * @covers Action::checkRoverCoordinates
     */
    public function testCheckRoverCoordinates($x, $y, array $plateauCoordinates)
    {
        $check = $this->action->checkRoverCoordinates($x, $y, $plateauCoordinates);
        $this->assertInternalType('string', $check);
        if ($x < $plateauCoordinates['leftCornerX'] || $x > $plateauCoordinates['rightCornerX']
            || $y < $plateauCoordinates['leftCornerY'] || $y > $plateauCoordinates['rightCornerY']) {
            $this->assertNotEmpty($check);
        }
        else {
            $this->assertEmpty($check);
        }
    }

    /**
     * @param Rover $rover
     * @param Plateau $plateau
     * @param string $instruction
     *
     * @dataProvider changeProvider
     * @covers Action::change
     */
    public function testChange(Rover $rover, Plateau $plateau, $instruction) {
        $change = $this->action->change($rover, $plateau, $instruction);
        $this->assertInternalType('string', $change);
        $this->assertEquals('1 3 N', $change, 'Error performing instructions');
    }

    /**
     * @param string $oldHeading
     * @param string $rotating
     *
     * @dataProvider rotateProvider
     * @covers Action::rotate
     */
    public function testRotate($oldHeading, $rotating) {
        $this->assertArrayHasKey($oldHeading . $rotating, $this->action->getChangeHeadings());
        $rotation = $this->action->rotate($oldHeading, $rotating);
        $this->assertInternalType('string', $rotation);
        $this->assertEquals($this->action->getChangeHeadings()[$oldHeading . $rotating], $rotation,
            "Error rotating $rotating");
    }

    /**
     * @param int $oldCoordinate
     * @param string $heading
     *
     * @dataProvider moveProvider
     * @covers Action::move
     */
    public function testMove($oldCoordinate, $heading) {
        $this->assertContains($heading, $this->headings);
        $move = $this->action->move($oldCoordinate, $heading);
        if ($heading == 'E' || $heading == 'N') {
            $this->assertEquals(++$oldCoordinate, $move, "Error moving $heading");
        }
        else {
            $this->assertEquals(--$oldCoordinate, $move, "Error moving $heading");
        }
    }

    /**
     * @return array
     */
    public function checkRoverCoordinatesProvider()
    {
        $this->plateau = Plateau::getInstance();
        $this->plateau->setCoordinates(5,5);
        return array(
            array(1, 2, $this->plateau->getCoordinates()),
            array(3, 3, $this->plateau->getCoordinates()),
        );
    }

    /**
     * @return array
     */
    public function changeProvider() {
        $this->plateau = Plateau::getInstance();
        $this->plateau->setCoordinates(5,5);
        return array(
            array(new Rover(1, 2, 'N'), $this->plateau, 'LMLMLMLMM'),
//            array(new Rover(3, 3, 'E'), $this->plateau, 'MMRMMRMRRM'),
        );
    }

    /**
     * @return array
     */
    public function rotateProvider() {
        return [
            ['N', 'L']
        ];
    }

    /**
     * @return array
     */
    public function moveProvider() {
        return [
            [1, 'N']
        ];
    }
}
