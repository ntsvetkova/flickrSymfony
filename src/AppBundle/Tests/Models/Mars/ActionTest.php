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
     * @param string $expected
     *
     * @dataProvider checkRoverCoordinatesProvider
     * @covers Action::checkRoverCoordinates
     */
    public function testCheckRoverCoordinates($x, $y, array $plateauCoordinates, $expected) {
        $check = $this->action->checkRoverCoordinates($x, $y, $plateauCoordinates);
        $this->assertEquals($expected, $check);
    }

    /**
     * @param Rover $rover
     * @param Plateau $plateau
     * @param string $instruction
     * @param string $expected
     *
     * @dataProvider changeProvider
     * @covers Action::change
     */
    public function testChange(Rover $rover, Plateau $plateau, $instruction, $expected) {
        $change = $this->action->change($rover, $plateau, $instruction);
        $this->assertInternalType('string', $change, 'change() method must return string');
        $this->assertEquals($expected, $change, 'Error performing instructions');
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
        $this->assertInternalType('string', $rotation, 'rotate() method must return string');
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
    public function testMove($oldCoordinate, $heading, $expected) {
        $this->assertContains($heading, $this->headings);
        $move = $this->action->move($oldCoordinate, $heading);
        $this->assertInternalType('int', $move, 'move() method must return int');
        $this->assertEquals($expected, $move, "Error moving $heading");
    }

    /**
     * @return array
     */
    public function checkRoverCoordinatesProvider()
    {
        $this->plateau = Plateau::getInstance();
        $this->plateau->setCoordinates(5,5);
        return [
            [1, 9, $this->plateau->getCoordinates(), 'rover.out'],
            [3, 3, $this->plateau->getCoordinates(), ''],
        ];
    }

    /**
     * @return array
     */
    public function changeProvider() {
        $this->plateau = Plateau::getInstance();
        $this->plateau->setCoordinates(5,5);
        return [
            [new Rover(1, 2, 'N'), $this->plateau, 'LMLMLMLMM', '1 3 N'],
            [new Rover(3, 3, 'E'), $this->plateau, 'MMRMMRMRRM', '5 1 E'],
            [new Rover(3, 3, 'E'), $this->plateau, 'MMRMMRMRRM', '5 4 E'],
        ];
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
            [1, 'N', 2]
        ];
    }

    /**
     * Mock test
     */
    public function testMock() {
        $plateau = $this->getMockBuilder('Plateau')
            ->setMethods(['getCoordinates', 'setCoordinates'])
            ->getMock();
        $plateau->expects($this->atLeastOnce())
            ->method('getCoordinates')
            ->will($this->onConsecutiveCalls(
                [
                    'leftCornerX' => 1,
                    'leftCornerY' => 2,
                    'rightCornerX' => 6,
                    'rightCornerY' => 9
                ],
                [
                    'leftCornerX' => 0,
                    'leftCornerY' => 0,
                    'rightCornerX' => 5,
                    'rightCornerY' => 5
                ]
            ));
        $plateau->expects($this->atLeastOnce())
            ->method('setCoordinates')
            ->with($this->equalTo(0), $this->equalTo(0), $this->greaterThan(0), $this->greaterThan(0))
            ->will($this->returnArgument(3));
        $plateau->setCoordinates(0,0,3,8);

        $roverMock = $this->getMockBuilder('Rover')
            ->setMethods(['getX','getY'])
            ->getMock();

        $roverMock->expects($this->any())
            ->method('getX')
            ->will($this->returnValue(1));

        $roverMock->expects($this->any())
            ->method('getY')
            ->will($this->returnValue('6'));
        $this->assertEquals(6, $roverMock->getY());

        $check = $this->action->checkRoverCoordinates($roverMock->getX(), $roverMock->getY(), $plateau->getCoordinates());
        $this->assertEquals('', $check);

        $check = $this->action->checkRoverCoordinates($roverMock->getX(), $roverMock->getY(), $plateau->getCoordinates());
        $this->assertEquals('rover.out', $check);
    }

}
