<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 31.08.15
 * Time: 13:42
 */

namespace AppBundle\Models\Mars;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SetData
 * @package AppBundle\Models\Mars
 */
class SetData
{
    /**
     * @var string
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
        $this->enterData = $enterData;
    }

    /**
     * set all properties using $enterData
     */
    public function setAll() {
        $this->enterData = explode("\n", $this->enterData);

        $plateauCoordinates = explode(' ', trim($this->enterData[0]));
        $this->plateauRightCornerX = (int)$plateauCoordinates[0];
        $this->plateauRightCornerY = (int)$plateauCoordinates[1];
        unset($this->enterData[0]);

        $this->plateau = Plateau::getInstance();
        $this->plateau->setCoordinates($this->plateauRightCornerX, $this->plateauRightCornerY);

        foreach ($this->enterData as $key => $value) {
            if ($key % 2 == 0) {
                array_push($this->arrInstructions, trim($value));
            }
            else {
                array_push($this->arrPositions, trim($value));
            }
        }
        $this->arrRover = array_combine($this->arrPositions, $this->arrInstructions);
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

//    public function configureOptions(OptionsResolver $resolver) {
//        $resolver->setDefaults(array(
//
//        ));
//    }

}