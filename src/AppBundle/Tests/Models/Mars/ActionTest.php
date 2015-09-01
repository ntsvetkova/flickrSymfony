<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 01.09.15
 * Time: 15:29
 */

namespace AppBundle\Tests\Models\Mars;
use AppBundle\Models\Mars\Rover;

/**
 * Class ActionTest
 * @package AppBundle\Tests\Models\Mars
 */
class ActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider checkCoordinatesProvider
     */
    public function testCheckCoordinates($x, $y, array $plateauCoordinates)
    {
        $this->assertGreaterThanOrEqual($plateauCoordinates['leftCornerX'],$x);
        $this->assertGreaterThanOrEqual($plateauCoordinates['leftCornerY'],$y);
        $this->assertLessThanOrEqual($plateauCoordinates['rightCornerX'],$x);
        $this->assertLessThanOrEqual($plateauCoordinates['rightCornerY'],$y);
    }

    /**
     * @return array
     */
    public function checkCoordinatesProvider()
    {
        return array(
            array(1, 2, [
                'leftCornerX' => 0,
                'leftCornerY' => 0,
                'rightCornerX' => 5,
                'rightCornerY' => 5
            ]),
            array(3, 3, [
                'leftCornerX' => 0,
                'leftCornerY' => 0,
                'rightCornerX' => 5,
                'rightCornerY' => 5
            ])
        );
    }

    /**
     * @param Rover $rover
     * @param $actions
     *
     * @dataProvider changeProvider
     * @depends testCheckCoordinates
     */
    public function changeTest(Rover $rover, $actions) {
        $actions = str_split($actions);
        foreach ($actions as $action) {

        }
    }

    /**
     * @return array
     */
    public function changeProvider() {
        return array(
            array(new Rover(1, 2, 'N'), 'LMLMLMLMM'),
            array(new Rover(3, 3, 'E'), 'MMRMMRMRRM'),
//            array(1, 2, 'N', 'LMLMLMLMM'),
//            array(3, 3, 'E', 'MMRMMRMRRM')
        );
    }
}
