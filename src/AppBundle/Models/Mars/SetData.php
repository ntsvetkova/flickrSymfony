<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 31.08.15
 * Time: 13:42
 */

namespace AppBundle\Models\Mars;

use AppBundle\Exceptions\AppException;

/**
 * Class SetData
 * @package AppBundle\Models\Mars
 */
class SetData
{
    /**
     * @var
     */
    protected $enterData;
    /**
     * @var int
     */
    private $plateauRightCornerX;
    /**
     * @var int
     */
    private $plateauRightCornerY;
    /**
     * @var array
     */
    private $arrInstructions = [];
    /**
     * @var array
     */
    private $arrPositions = [];
    /**
     * @var array
     */
    private $arrRover = [];
    /**
     * @var Plateau
     */
    private $plateau;

    /**
     * @param $enterData
     */
    public function setEnterData($enterData)
    {
        $enterData = explode("\n", $enterData);
        foreach ($enterData as $key => $value) {
            if (empty($value)) {
                unset($enterData[$key]);
            }
        }
        try {
            if (preg_match("/\d\s\d$/", trim($enterData[0]))) {
                $plateauCoordinates = explode(' ', trim($enterData[0]));
                $this->plateauRightCornerX = (int)$plateauCoordinates[0];
                $this->plateauRightCornerY = (int)$plateauCoordinates[1];
                unset($enterData[0]);
            }
            else {
                throw new AppException('right corner');
            }
            $this->plateau = Plateau::getInstance();
            $this->plateau->setCoordinates($this->plateauRightCornerX, $this->plateauRightCornerY);
            foreach ($enterData as $key => $value) {
                if ($key % 2 == 0) {
                    if (preg_match("/[LRM]$/", trim($value))) {
                        array_push($this->arrInstructions, trim($value));
                    }
                    else {
                        throw new AppException('instructions');
                    }
                } else if (preg_match("/(\d\s){2}[NSWE]{1}$/", trim($value))) {
                    array_push($this->arrPositions, trim($value));
                }
                else {
                    throw new AppException('position');
                }
            }
            for ($i = 0; $i < count($this->arrInstructions); $i++) {
                $this->arrRover[$this->arrPositions[$i]] = $this->arrInstructions[$i];
            }
        }
        catch (AppException $e) {
            echo $e;
        }
    }

    /**
     * @return mixed
     */
    public function getEnterData() {
        return $this->enterData;
    }

    /**
     *  Execute instructions for each rover
     */
    public function execute() {
        foreach ($this->arrRover as $position => $instruction) {
            $positionDetails = explode(' ', $position);
            $rover = new Rover((int)$positionDetails[0], (int)$positionDetails[1], $positionDetails[2]);
            $action = new Action($instruction);
            $action->change($rover, $this->plateau);
        }
    }

}