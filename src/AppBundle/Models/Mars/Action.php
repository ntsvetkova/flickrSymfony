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
    private $actions = [];
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
     * @param $actions string
     */
    public function __construct($actions) {
        $this->actions = str_split($actions);
    }

    /**
     * @param Rover $rover
     * @param Plateau $plateau
     * @return int|string
     */
    public function change(Rover $rover, Plateau $plateau)
    {
        $plateauCoordinates = $plateau->getCoordinates();
        $result = '';
        foreach ($this->actions as $changing) {
            $result = $this->checkRoverCoordinates($rover->getX(), $rover->getY(), $plateauCoordinates);
            if ($result != '') {
                break;
            }
            if ($changing == 'L' || $changing == 'R') {
                $rover->setHeading($this->rotate($rover->getHeading(), $changing));
            } else {
                if ($rover->getHeading() == 'W' || $rover->getHeading() == 'E') {
                    $rover->setX($this->move($rover->getX(), $rover->getHeading(), $plateauCoordinates));
                } else {
                    $rover->setY($this->move($rover->getY(), $rover->getHeading(), $plateauCoordinates));
                }
            }
        }
        if ($result == '') {
            $result = $rover->getX() . ' ' . $rover->getY() . ' ' . $rover->getHeading();
        }
        return $result;
    }

    /**
     * @param $oldHeading
     * @param $rotating
     */
    public function rotate($oldHeading, $rotating)
    {
        return $this->changeHeadings[$oldHeading . $rotating];
    }

    /**
     * @param $oldCoordinate
     * @param $heading
     * @param $plateauCoordinates
     * @return mixed
     */
    public function move($oldCoordinate, $heading, $plateauCoordinates)
    {
        if ($heading == 'E' || $heading == 'N') {
            $newCoordinate = ++$oldCoordinate;
        } else {
            $newCoordinate = --$oldCoordinate;
        }
        return $newCoordinate;
    }

    /**
     * @param $x
     * @param $y
     * @param $plateauCoordinates
     * @return int
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