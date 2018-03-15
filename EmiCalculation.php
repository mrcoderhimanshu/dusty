<?php if(!defined('BASEPATH')) exit('No direct script is allowed');

/*
* @Desription: This library is writen for the drfin project to calculate the EMI. 
*              It works for the Flat as well as reducing intrest rate.
* @Version : 1.0.0
* @Author  : Himanshu Phoolwar
*
*/

Class EmiCalculation{

    private $principal = 0;
    private $intrest = 0;
    private $tenure = 0;
    private $tenureType = 0;
    private $periodInterest = 0;
    private $loanType = 1;
    private $emiMode = 1;
    private $term =1;

    private $numberOfMonths      = 12;
    private $numberOfDays       = 365;
    private $numberOfWeeks      = 52;
    private $numberOfHalfMonth  = 24;
    private $numberOfQuaters    = 4;
    private $numberOfHalfYearly = 2;

    private $tenureScale = array('DAILY', 'WEEKLY', 'HALF_MONTH', 'HALF_MONTH', 'MONTHLY', 'QUATERLY', 'HALF_YEARLY', 'YEARLY');

/*
* @Description : Construction to import the CI environment
* @ method : __construct (magic function auto call out)
* @ params : null
* @ return : null
*/
    public function __contruct(){
        //importing CI environment
        //$CI =& get_instance();
    }

/*
* @Method : 
* @Description : CalEmi
* @Type : public
* @param:   (double)$principal (required): contains the principal amount of the loan 
*           (int)$duration (required) : duration it could be in month,year,day etc.
*           (int)$durationType (required) : decide duration type 1,2,3,4,5,6
*           (double)$rate (required) : intrest rate on which we calculate the EMI. It always yearly
*           (int)$type : default 1 (Reducing), 2 (Flat)
* @return:
*/
    public function CalEmi($principal, $duration, $durationType, $rate, $emiMode, $type = 1){
        //firstly convert the rate according to the duration
        $this->principal = $principal;
        $this->interest = $rate;
        $this->tenure  = $duration;
        $this->tenureType = $durationType;
        $this->loanType = $type;
        $this->emiMode = $emiMode;
        $this->setPeriodInterest();
        $this->EmiType();
    }
	



/*
* @Method : setPeriodInterest
* @Description : set the period inrest in the class on the bases of tenure (daily, weekly, monthly, quaterly etc)
*                formula used -- intrest/100*monthly as we calculate the intrest month so we use 12
* @Type : private
* @param: Null
* @return: Null
*/
    private function setPeriodInterest(){
        $dRate = $this->interest/100*$this->numberOfMonths;
        // rate for our tenure
        switch ($this->tenureType) {
            case 2:
                //daily calculation
                $this->periodInterest = $this->interest/(100*$this->numberOfDays);
                //$this->term = $this->setTerm();
                break;
            case 3:
                //weekly calculation
                $this->periodInterest = $this->interest/(100*$this->numberOfWeeks);
                break;
            case 4:
                //15 days calculation
                $this->periodInterest = $this->interest/(100*$this->numberOfHalfMonth);
                break;
            case 5:
                //quaterly calculation
                $this->periodInterest = $this->interest/(100*$this->numberOfQuaters);
                break;
            case 6:
                //half yearly calculation
                $this->periodInterest = $this->interest/(100*$this->numberOfHalfYearly);
                break;
            case 1:
            default:
                $this->periodInterest = $this->interest/(100*$this->numberOfMonths); 
                break;
        }
        //$this->term = $this->setEMITerm();
    }


/*
* @Method : EmiType
* @Description : Decide if its flat or reducing and calculate the same
* @Type : private
* @param:   
* @return: 
*/
    private function EmiType(){
        switch($this->loanType){
            case 1:
                //here we calculate flat intrest rate
                $this->ReducingCal();
            break;

            case 2:
                // here we calculate at reducing rate
                $this->FlatCal();
            break;
        }
    }


/*
* @Method : EmiType
* @Description : Decide if its flat or reducing and calculate the same
* @Type : private
* @param:   
* @return: 
*/
    private function ReducingCal(){
        //$emI = $amount*$rate*(pow(1+$rate, $term)/ (pow(1+$rate, $term)-1));
        //echo $this->principal.'<br/>';
        //echo $this->periodInterest.'<br/>';
        //echo 'Rate :'.(5/1200);
        //echo 60.'<br/>';
        $this->term = $this->setEMITerm();
        $emI = $this->principal*$this->periodInterest*(pow(1+$this->periodInterest, $this->term)/ (pow(1+$this->periodInterest, $this->term)-1));
        echo $emI;die();
    }


    private function setEMITerm(){

        $DAILY['DAILY'] 		= 1;    
        $DAILY['WEEKLY'] 		= 7;  
        $DAILY['HALF_MONTH'] 	= 15;  
        $DAILY['MONTHLY'] 		= 30;  
        $DAILY['QUATERLY'] 		= 90;  
        $DAILY['HALF_YEARLY'] 	= 180;  
        $DAILY['YEARLY'] 		= 365;

        $WEEKLY['WEEKLY'] 		= 1;
        $WEEKLY['HALF_MONTH'] 	= 2;
        $WEEKLY['MONTHLY'] 		= 4;
        $WEEKLY['QUATERLY'] 	= 12;
        $WEEKLY['HALF_YEARLY'] 	= 24;
        $WEEKLY['YEARLY'] 		= 48;

        $HALF_MONTH['HALF_MONTH'] 	= 1;
        $HALF_MONTH['MONTHLY'] 		= 2;
        $HALF_MONTH['QUATERLY'] 	= 6;
        $HALF_MONTH['HALF_YEARLY'] 	= 12;
        $HALF_MONTH['YEARLY'] 		= 24;

        $MONTHLY['MONTHLY'] 	= 1;
        $MONTHLY['QUATERLY'] 	= 3;
        $MONTHLY['HALF_YEARLY'] = 6;
        $MONTHLY['YEARLY'] 		= 12;

        $QUATERLY['QUATERLY'] 	 = 1;
        $QUATERLY['HALF_YEARLY'] = 2;
        $QUATERLY['YEARLY'] 	 = 4;

        $HALF_YEARLY['HALF_YEARLY'] = 1;
        $HALF_YEARLY['YEARLY'] 		= 2;

        $YEARLY['YEARLY'] = 1;

        return ${$this->tenureScale[$this->emiMode]}[$this->tenureScale[$this->tenureType]]*$this->tenure;
        
    }
}