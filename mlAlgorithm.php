<?php
//"DecidsionTreeAlgorithm" class use the php-ml master libary (php machine learning)
declare(strict_types = 1);
require_once __DIR__ . '/vendor/autoload.php';
use Phpml\Classification\DecisionTree;
use Phpml\Dataset\CsvDataset;
//"DecidsionTreeAlgorithm" class extends "DecisionTree" to build decesion tree algorithm
class DecidsionTreeAlgorithm extends DecisionTree {
    //"data" array for save all data rows in "gymcsv" csv file
    private $data = [];
    //"calculateWorkout" function for build decistion tree algorithm and calculate predict result finally return "workout"result
    public function calculateWorkout($height, $weight, $fat, $isSportHabits, $isMedicalProblems, $duration):
        String {
            //make csv object from "gymcsv" csv file
            $dataset = new CsvDataset('../gymcsv.csv', 7, false);
            
            //set all data rows from "gymcsv" csv file to "data" array
            for ($i = 1;$i < count($dataset->getSamples()) - 1;$i++) {
                $this->data[$i] = $dataset->getSamples() [$i];                
            }

            //calculate the result by use "getData" function and return the result
            [$data, $targets] = $this->getData($this->data);
            $classifier = new DecisionTree(7);
            //train
            $classifier->train($data, $targets);
            $y = $classifier->getFeatureImportances();


            //add variables to array for calclate
            $testSamples = [[$height, $weight, $fat, $isSportHabits, $isMedicalProblems, $duration]];

            //predict result
            $predicted = $classifier->predict($testSamples);
            echo $predicted[0];


            return $predicted[0];
        }


        //"getData" function for calculate result
        public function getData(array $input):
            array {
                $targets = array_column($input, 6);
                array_walk($input, function (&$v):
                    void {
                        array_splice($v, 6, 1);
                    });
                    return [$input, $targets];
                }





                //"updateWeights" function (called after each feedback from any trainer) to check if accepted work plan is need to improve by count all feedbacks accepted that belongs to workplan (sended to function) and count all "yes" and "no" feedbacks and if "no" feedbacks average more than "yes" feedbacks then update the csv file (workplan weights) by minus or plus 'height,weight,fat' (dependent average)
                public function updateWeights($workplanid):
                    void {
                        //this function work after each feedback
                        //connect to db and count trainers belongs to workplan and if more than 10 feedback we
                        //will calculate all "yes" or "no" answers and if no>yes then update csv weights

                        //get all feeds yes feeds and no feeds by "getWorkplanFeedbacks" function belongs workplan id
                        $allFeed = getWorkplanFeedbacks($workplanid, '');
                        $yesFeed = getWorkplanFeedbacks($workplanid, 'yes');
                        $noFeed = getWorkplanFeedbacks($workplanid, 'no');
                        //if all total feeds >10 
                        if($allFeed>10)
                        {
                            //calculate average yes and no feeds
                            $yesAvg=($yesFeed*100)/$allFeed;
                            $noAvg=($noFeed*100)/$allFeed;
                            //if total no feeds > yes feeds continue for update csv
                            if($noAvg>$yesAvg)
                            {
                                
                                //variables for calculate average (height weight and fat)
                                $heightAvg=0;
                                $weightAvg=0;
                                $fatAvg=0;
                                //array for save trainers belong workplan
                                $planObj=null; 
                                //get all trainers
                                $trainers=getSubscriptions('active');
                                echo count((array)getSubscriptions('active'));
                                $totalTrainers=count((array)getSubscriptions('active'));

                                //get workplans by "getWorkPlans" function for get trainer belong workplan
                                $workpland=getWorkPlans();
                                $totalWorkplans=count((array)getWorkPlans());
                                //get array of objects belong workplan and save in $planObj
                                for($i=0;$i<$totalWorkplans;$i++)
                                {
                                    if($workpland[$i]->id==$workplanid)
                                        $planObj=$workpland[$i];
                                }
                                //for count num of trainers belong workplan
                                $numberOfTrainers=0;
                                //sum and save into variables
                                for($j=0;$j<$totalTrainers;$j++)
                                {
                                if($trainers[$j]->WorkPlan->id==$planObj->id)
                                {
                                    $heightAvg+=$trainers[$j]->height;
                                    $weightAvg+=$trainers[$j]->weight;
                                    $fatAvg+=$trainers[$j]->fat;
                                    $numberOfTrainers++;

                                }
                                    
                                }
                                
                                 //calc average and save into variables
                                 $heightAvg/=$numberOfTrainers;
                                 $weightAvg/=$numberOfTrainers;
                                 $fatAvg/=$numberOfTrainers;

                                 //get worplan name
                                 $wprkplanName=$planObj->name;
                                 //check the no feeds average and add to averages 
                                if($noAvg>51&&$noAvg<65)
                                {
                                 $heightAvg+=1;
                                 $weightAvg-=1;
                                 $fatAvg+=1;
                                }
                                else if($noAvg>=65&&$noAvg<75)
                                {
                                  $heightAvg+=2;
                                  $weightAvg-=2;
                                  $fatAvg+=2;
                                }
                                else if($noAvg>=75)
                                {
                                    $heightAvg+=3;
                                    $weightAvg-=3;
                                    $fatAvg+=3;
                                }

                                //open csv original file and rewrite file
                                 $input = fopen('../gymcsv.csv', 'r');  //open for reading
                                $output = fopen('../temp_gymcsv.csv', 'w'); //open for writing
                    
                                $i=0;
                                //write all rows to help file except rows want for update 
                                 while( false !== ( $data = fgetcsv($input) ) ){  //read each line as an array
                                 if($data[6]!=$wprkplanName)
                                 {
                                 //modify data here
                                
                                 //write modified data to new file
                                 fputcsv( $output, $data);
                                 }
                                else
                                {
                                   //save rows for update in array
                                   $list[$i]=$data;
                                   $i++;

                                }

                        
                            }
                    
                    //update saved array values in new averages (3 options)
                    for($i=0;$i<3;$i++)
                    {
                        if($i==1) 
                        {
                             $heightAvg+=1; $weightAvg+=1;$fatAvg+=1;
                        }
                        
                         if($i==2) 
                        {
                             $heightAvg-=2; $weightAvg-=2;$fatAvg-=2;

                        }   
                         $list[$i][0]=$heightAvg;
                         $list[$i][1]=$weightAvg;
                         $list[$i][2]=$fatAvg;
                         $list[$i][3]=$list[$i][3];
                         $list[$i][4]=$list[$i][4];
                         $list[$i][5]=$planObj->duration;
                         $list[$i][6]=$wprkplanName;

                         
                    }
                   

                     //add updated rows to help file 
                     foreach ($list as $line) {
                        fputcsv($output, $line);
                    }
                    //close both files
                    fclose( $input );
                    fclose( $output );

                    //open two files but for write updated 'help file' to original file
                    $output = fopen('../gymcsv.csv', 'w');  //open for reading
                    $input = fopen('../temp_gymcsv.csv', 'r'); //open for writing
                        
                    //write all rows from 'help' file to 'original' file
                    while( false !== ( $data = fgetcsv($input) ) ){  //read each line as an array
                    
                           
                            //write modified data to new file
                            fputcsv( $output, $data);
                    }

                    //close both files
                    fclose( $input );
                    fclose( $output );

                            }
                        }


                        
                        
                    }




                    //"addNewWorkplan" function for add new 3 rows to csv file (3 options after add new work plan)
                    public function addNewWorkplan($workplanName, $height, $weight, $fat, $isSport, $isMedicalProblems, $duration) {
                        $heightOption1 = $height;
                        $heightOption2 = $height - 2;
                        $heightOption3 = $height + 2;
                        $weightOption1 = $weight;
                        $weightOption2 = $weight - 2;
                        $weightOption3 = $weight + 2;
                        $fattOption1 = $fat;
                        $fatOption2 = $fat - 2;
                        $fatOption3 = $fat + 2;
                        
                        if($isMedicalProblems=='no') $isMedicalProblemsOption3='yes'; else  $isMedicalProblemsOption3='no';
                        if($isSport=='no') $isSportOption3='yes'; else  $isSportOption3='no';

                        if($isMedicalProblems=='no') $isMedicalProblemsOption2='yes'; else  $isMedicalProblemsOption2='no';
                        if($isSport=='no') $isSportOption2='yes'; else  $isSportOption2='no';

                        $list = array(array($heightOption1, $weightOption1, $fattOption1, $isSport, $isMedicalProblems, $duration, $workplanName), array($heightOption2, $weightOption2, $fatOption2, $isSportOption2, $isMedicalProblemsOption2, $duration, $workplanName), array($heightOption3, $weightOption3, $fatOption3, $isSportOption3, $isMedicalProblemsOption3, $duration, $workplanName));
                        $file = fopen('../gymcsv.csv', "a");
                        foreach ($list as $line) {
                            fputcsv($file, $line);
                        }
                        fclose($file);
                    }
                }
?>