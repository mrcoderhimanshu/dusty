<?php

Class EmiCalculation{

	
	/*
	* Principal amount we are giving
	* 
	* @access : private
	* @dataType : double
	*/
	private $principal  = 0;
	
	/*
	* tenure is the time for which we are giving the loan
	* 
	* @access : private
	* @dataType : int
	*/
	private $tenure 	= 0;
	
	/*
	* rate is the rate of intrest we are charging and it must be yearly
	* 
	* @access : private
	* @dataType : int
	*/
	private $rate 		= 0;
	
	/*
	* type of tenure, it will tell the class is it a daily monthly or yearly etc.
	* 
	* @access : private
	* @dataType : int
	*/
	private $tenureType = 0;
	
	/*
	* mode of EMI, it will tell the class what will we be the Emi Mode wethere user will going to pay monthly or weekly etc..
	* 
	* @access : private
	* @dataType : int
	*/
	private $emiMode    = 0;
	
	/*
	* type of loan reducing or flat 1 for reducing 2 for flat default is 1
	* 	
	* @access : private
	* @dataType : int
	*/
	private $loanType   = 1;

	/*
	* period intrest is the inrest as per the tenure scale
	* 	
	* @access : private
	* @dataType : double
	*/
	private $periodInterest = 1;
	
	/*
	* tenure Scale is an array which handles all the calculation for tenure
	* 	
	* @access : private
	* @dataType : array 
	*/
	private $tenureScale = array('DAILY', 'WEEKLY', 'HALF_MONTH', 'MONTHLY', 'QUATERLY', 'HALF_YEARLY', 'YEARLY');
	
	/*
	* in Year is an array which converts all the system into an standard to year.
	* 	
	* @access : private
	* @dataType : array 
	*/
	private $inYear = array('numberOfMonths' => 12, 'numberOfDays' => 365, 'numberOfWeeks' => 52, 'numberOfHalfMonth'=> 24, 'numberOfQuaters'=> 4, 'numberOfHalfYearly'=> 2);


	private $eachEMI = 0;


	public $response = array();

	public $startDate = '';



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
*           (int)$tenure (required) : tenure it could be in month,year,day etc.
*           (int)$tenureType (required) : decide tenure type, for this we are using tenureScale array
*           (double)$rate (required) : intrest rate on which we calculate the EMI. It always yearly
*           (int)$emiMode (required) : suggests the emi mode monthly weekly halfmonth etc, for this we are considering tenureScale array.
*           (int)$loanType : default 1 (Reducing), 2 (Flat)
* @return:
*/
	public function CalEmi($principal, $tenure, $tenureType, $rate, $emiMode, $startDate, $loanType = 1){
		
		$this->principal = $principal;
		$this->tenure    = $tenure;
		$this->tenureType= $tenureType;
		$this->rate 	 = $rate;
		$this->emiMode   = $emiMode;
		$this->loanType  = $loanType;
		$this->startDate = $startDate;
		$this->setPeriodInterest();
		$this->EmiType();
		return $this->response;
		
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
        // rate for our tenure
        switch ($this->emiMode) {
            case 0:
                //daily calculation
                $this->periodInterest = $this->rate/(100*$this->inYear['numberOfDays']);
                break;
            case 1:
                //weekly calculation
                $this->periodInterest = $this->rate/(100*$this->inYear['numberOfWeeks']);
                break;
            case 2:
                //15 days/ Half monthly calculation
                $this->periodInterest = $this->rate/(100*$this->inYear['numberOfHalfMonth']);
                break;
            case 4:
                //quaterly calculation
                $this->periodInterest = $this->rate/(100*$this->inYear['numberOfQuaters']);
                break;
            case 5:
                //half yearly calculation
                $this->periodInterest = $this->rate/(100*$this->inYear['numberOfHalfYearly']);
                break;
            case 3:
			default:
                $this->periodInterest = $this->rate/(100*$this->inYear['numberOfMonths']);               
                break;
        }
    }

	
/*
* @Method : EmiType
* @Description : Decide if its flat or reducing and calculate the same
* @Type : private
* @param: N/A 
* @return: N/A
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
* @Method : ReducingCal
* @Description : Calculate the emi at reducing rate of intrest for the given param
* @Type : private
* @param: N/A
* @return: N/A
*/
	private function ReducingCal(){
        //$emI = $amount*$rate*(pow(1+$rate, $term)/ (pow(1+$rate, $term)-1));
		$this->term = $this->setEMITerm();	
        $this->eachEMI = $this->principal*$this->periodInterest*(pow(1+$this->periodInterest, $this->term)/ (pow(1+$this->periodInterest, $this->term)-1));
		//now we need to create a schedule
		$this->createReducingScheduler();
	}

/*
* @Method : FlatCal
* @Description : Calculate the emi at flat rate of intrest for the given param
* @Type : private
* @param: N/A
* @return: N/A
*/
	private function FlatCal(){
		//$emi = (principal + Interest)/period in months
		$this->term = $this->setEMITerm();
		$this->periodInterest = ($this->principal/$this->rate)*$this->tenure;
		$this->eachEMI = ($this->principal+$this->periodInterest)/$this->term;
		// now we need to create a schedule
		$this->createFlatScheduler();
	}	

/*
* @Method : setEMITerm
* @Description : It will set the EMI term in the class for which we need to calculate the emi
* @Type : private
* @param:   N/A
* @return: int term
*/
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

/*
* @Method : createReducingScheduler
* @Description : It will create an array for the schedule output
* @Type : private
* @param:   N/A
* @return: N/A
*/
	private function createReducingScheduler(){
		$loanAmount = $this->principal;
		$initalLoanAmount = 0;
		$postLoanAmount = 0;
		$index =0;
		for($i=1; $i<=$this->term; $i++){
			$loanRate = $loanAmount *($this->periodInterest);
			$postLoanAmount = $this->eachEMI - $loanRate;
			$result[$index]['emi_count'] = $i;
			$result[$index]['begining_balance'] = $loanAmount;
			$result[$index]['emi'] = round($this->eachEMI, 2);
			$result[$index]['principal'] = round(($this->eachEMI - $loanRate),2);
			$result[$index]['Interest'] = round($loanRate,2);
			$result[$index]['ending_balance'] = round(($loanAmount-$postLoanAmount),2);
			if($i == 1){
				$result[$index]['emiDate'] = $this->startDate;
			}else{
				$result[$index]['emiDate'] = $this->nextEMIDate($i);
			}
			$loanAmount = round(($loanAmount-$postLoanAmount),2);
			$index++;
		}
		$this->response = $result;
	}

/*
* @Method : createFlatScheduler
* @Description : It will create an array for the schedule output for flat calculation
* @Type : private
* @param:   N/A
* @return: N/A
*/
	private function createFlatScheduler(){
		$loanAmount = $this->principal;
		$eachTermRatePart = 0;
		$termPrincipalPart = 0;
		$index =0;
		for($i=1; $i<=$this->term; $i++){
			$eachTermRatePart = $this->periodInterest/$this->term;
			$termPrincipalPart = $this->eachEMI - $eachTermRatePart;
			$result[$index]['emi_count'] = $i;
			$result[$index]['begining_balance'] = $loanAmount;
			$result[$index]['emi'] = round($this->eachEMI, 2);
			$result[$index]['principal'] = round($termPrincipalPart, 2);
			$result[$index]['interest'] =  round($eachTermRatePart,2);
			$result[$index]['ending_balance'] = round(($loanAmount-$termPrincipalPart),2);
			if($i == 1){
				$result[$index]['emiDate'] = $this->startDate;
			}else{
				$result[$index]['emiDate'] = $this->nextEMIDate($i);
			}
			$loanAmount = round(($loanAmount-$termPrincipalPart),2);
			$index++;
		}
		$this->response = $result;
	}


	private function nextEMIDate($emiNumber){
		switch ($this->tenureScale[$this->emiMode]) {
			case 'DAILY':
				$date = strtotime("+".$emiNumber." days", strtotime($this->startDate));
				$newDate = date("Y-m-d", $date);
				break;

			case 'WEEKLY':
				$date = strtotime("+".$emiNumber." week", strtotime($this->startDate));
				$newDate = date("Y-m-d", $date);
				break;
			
			default:
				# code...
				break;
		}
		return $newDate;
	}
}
?>