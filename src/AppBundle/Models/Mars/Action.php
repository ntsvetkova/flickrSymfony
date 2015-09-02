<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 31.08.15
 * Time: 14:10
 */

namespace AppBundle\Models\Mars;

use AppBundle\Exceptions\AppException;

/**
 * Class Action
 * @package AppBundle\Models\Mars
 */
class Action
{
    /**
     * @var array
     */
    private $changeHeadings = [
        'NL' => 'W',
        'NR' => 'E',
        'SL' => 'E',
        'SR' => 'W',
        'WL' => 'S',
        'WR' => 'N',
        'EL' => 'N',
        'ER' => 'S'
    ];
    /**
     * @var
     */
    private static $instance;

    /**
     * Constructor
     */
    private function __construct() {}

    /**
     * Cloning restriction
     */
    private function __clone() {}

    /**
     * @return mixed
     */
    public static function getInstance() {
        if (empty(self::$instance)) {
            $classname = __CLASS__;
            self::$instance = new $classname;
        }
        return self::$instance;
    }

    /**
     * @return array
     */
    public function getChangeHeadings() {
        return $this->changeHeadings;
    }

    /**
     * @param Rover $rover
     * @param Plateau $plateau
     * @param string $actions
     * @return int|string
     */
    public function change(Rover $rover, Plateau $plateau, $actions)
    {
        $plateauCoordinates = $plateau->getCoordinates();
        $actions = str_split($actions);
        $result = '';
        foreach ($actions as $changing) {
            $result = $this->checkRoverCoordinates($rover->getX(), $rover->getY(), $plateauCoordinates);
            if ($result != '') {
                break;
            }
            if ($changing == 'L' || $changing == 'R') {
                $rover->setHeading($this->rotate($rover->getHeading(), $changing));
            } else {
                if ($rover->getHeading() == 'W' || $rover->getHeading() == 'E') {
                    $rover->setX($this->move($rover->getX(), $rover->getHeading()));
                } else {
                    $rover->setY($this->move($rover->getY(), $rover->getHeading()));
                }
            }
        }
        if ($result == '') {
            $result = $rover->getX() . ' ' . $rover->getY() . ' ' . $rover->getHeading();
        }
        return $result;
    }

    /**
     * @param string $oldHeading
     * @param string $rotating
     */
    public function rotate($oldHeading, $rotating)
    {
        return $this->changeHeadings[$oldHeading . $rotating];
    }

    /**
     * @param int $oldCoordinate
     * @param string $heading
     * @return int
     */
    public function move($oldCoordinate, $heading)
    {
        if ($heading == 'E' || $heading == 'N') {
            $newCoordinate = ++$oldCoordinate;
        } else {
            $newCoordinate = --$oldCoordinate;
        }
        return $newCoordinate;
    }

    /**
     * @param int $x
     * @param int $y
     * @param array $plateauCoordinates
     * @return string
     */
    public function checkRoverCoordinates($x, $y, $plateauCoordinates) {
        $error = '';
        try {
            if ($x < $plateauCoordinates['leftCornerX'] || $x > $plateauCoordinates['rightCornerX']
                || $y < $plateauCoordinates['leftCornerY'] || $y > $plateauCoordinates['rightCornerY']) {
                throw new AppException('rover.out');
            }
        }
        catch (AppException $e) {
            $error = $e;
        }
        return $error;
    }
}