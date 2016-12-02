<!DOCTYPE html>
<html lang="en">
<head>

<!-- Dylan Doblar and Louie McConnell -->

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<title>Bellarmine Track & Field</title>

<!-- Bootstrap -->
<script src="./js/bootstrap.js"></script>
<script src="./js/jquery-1.11.3.min.js"></script>
<script src="./js/jquery.validate.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">



</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class="text-center">Bellarmine All-Comer's Meet Registration</h1>
            </div>
        </div>
        <hr>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-offset-3 col-xs-12 col-lg-6">
                <div class="jumbotron">
                    <div class="row text-center">
                        <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12"> </div>
                        <div class="text-center col-lg-12">
                            <div class="help-block">
<?php
				$eventTimeToEventName = array( 
					0 => "60m",
					1 => "100m",
					2 => "150m",
					3 => "300m",
					4 => "mile",
					5 => "3200m",
					6 => "100m_hurdles",
					7 => "110m_hurdles"
				);
				
				$eventDistanceToEventName = array(
					0 => "high_jump",
					1 => "long_jump",
					2 => "triple_jump",
					3 => "pole_vault",
					4 => "softball_toss",
					5 => "shot_put",
				);
				
			    $ini_array = parse_ini_file("test.ini");		
				$host = $ini_array["host"];
				$dbname = $ini_array["dbname"];
				$user = $ini_array["user"];
				$password = $ini_array["pass"];
				
				$eventTime = [];
				for($i=0; $i < count($_POST['event_sec']); $i++) {
					$secs = 0;
					$eventTime[$i] = (0.01 * $_POST['event_hun'][$i]) + (60 * $_POST['event_min'][$i]) + $_POST['event_sec'][$i];
				}
				$eventMark = [];
				for($i=0; $i < count($_POST['event_in']); $i++) {
					$secs = 0;
					$eventMark[$i] = (12 * $_POST['event_ft'][$i]) + $_POST['event_in'][$i];
				}
				$checkedEventNames = [];
				foreach($_POST as $key => $data) {
					if(is_string($data) && strcmp($data, "on")===0) {
						array_push($checkedEventNames, $key);
					}
				}			
				$eventTimes = array_combine($eventTimeToEventName, $eventTime);
				$eventMarks = array_combine($eventDistanceToEventName, $eventMark);
				$eventTimes = $eventTimes + $eventMarks;

				try {
					$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
					// set the PDO error mode to exception

					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);						
					
					if($conn) {
						// echo "<br>SUCCESS!!<br>";
						$out = $conn->prepare("SELECT `id` FROM `TrackMeet_Competitors`");
						$out->bindParam(':firstName', $_REQUEST['first-name']);
						$out->execute();
						$result = $out->fetchAll(PDO::FETCH_ASSOC);
						
						// Add user to database
						$out = $conn->prepare("INSERT INTO `TrackMeet_Competitors`(`first_name`, `last_name`, `email`, `division`, `is_male`, `attends_bell`, `grade`) VALUES (:firstName, :lastName, :email, :division, :isMale, :attendsBell, :grade)");
						$out->bindParam(':firstName', $_REQUEST['first-name']);
						$out->bindParam(':lastName', $_REQUEST['last-name']);
						$out->bindParam(':email', $_REQUEST['email']);
						$out->bindParam(':division', $_REQUEST['division']);
						$temp = 0;
						if($_REQUEST['gender'] === 0) {
							$temp = 0;
						} else {
							$temp = 1;
						}
						$out->bindParam(':isMale', $_REQUEST['gender']);
						$attendsBell = preg_match('/@bcp.org$/', $_REQUEST['email']);
						$out->bindParam(':attendsBell', $attendsBell);
						$grade = 0;
						if(isset($_REQUEST['hs_grade'])) {
							$grade = $_REQUEST['hs_grade'];
						} else if(isset($_REQUEST['ms_grade'])) {
							$grade = $_REQUEST['ms_grade'];
						}
						$out->bindParam(':grade', $grade);
						
						$out->execute();

						
						// ADDING THE PARTICULAR EVENTS
						$out = $conn->prepare("SELECT `id` FROM `TrackMeet_Competitors` WHERE `first_name`=:firstName AND `last_name`=:lastName AND `email`=:email");
						// $out = $conn->prepare("SELECT `id` FROM `TrackMeet_Competitors` HAVING id=max(id)");
						$out->bindParam(':firstName', $_REQUEST['first-name']);
						$out->bindParam(':lastName', $_REQUEST['last-name']);
						$out->bindParam(':email', $_REQUEST['email']);
						$out->execute();
						$result = $out->fetchAll(PDO::FETCH_ASSOC);
						$athleteID = $result[0]["id"];
						
						
						// echo "<pre>";
						// print_r($result);
						// print_r($result[0]);
						// echo "<br>checkedEventNames<br>";
						// print_r($checkedEventNames[4]);
						for($i = 0; $i < count($checkedEventNames); $i++) {
							// get the ID of each event that the athlete wants to register for
							$out = $conn->prepare("SELECT `id` FROM `TrackMeet_Events` WHERE `event`=:event AND `is_male`=:isMale AND `division`=:division");
							$eventName = $checkedEventNames[$i];
							$out->bindParam(':event', $eventName);
							$out->bindParam(':isMale', $_REQUEST["gender"]);
							$out->bindParam(':division', $_REQUEST["division"]);
							$out->execute();
							// echo "*******************<br>";
							// echo "eventName: ";
							// echo $eventName;
							// echo "<br>gender: ";
							// echo $_REQUEST["gender"];
							// echo "<br>division: ";
							// echo $_REQUEST["division"];
							// echo "<br>*******************";
							$secondResult = $out->fetchAll(PDO::FETCH_ASSOC);
							// echo "<br><br><br><hr>";
							// print_r($secondResult);
							// echo "<hr><br><br><br>";
							$eventID = $secondResult[0]["id"];
							$out->setFetchMode(PDO::FETCH_ASSOC);
							$result = $out->fetch();
							
							// create an entry for each of the events specific to the athlete registering
							$out = $conn->prepare("INSERT INTO `TrackMeet_Entries`(`athlete_id`, `event_id`, `seed_mark`) VALUES (:athleteID, :eventID, :seedMark)");
							$out->bindParam(':athleteID', $athleteID);
							$out->bindParam(':eventID', $eventID);
							//eventTimes contains ALL events and corresponding marks, both track and field
							$seedMark = $eventTimes[$checkedEventNames[$i]];
							$out->bindParam(':seedMark', $seedMark);
							$out->execute();
						}
						// echo "</pre>";
						echo "Thank you, {$_POST['first-name']} for registering.";
						// echo "You have registered for:<br><pre>";
						
					} else {
						echo "<br>Connection to the database has failed. Please try again later.<br>";
					}
					$conn = null;
				} catch(PDOException $e) {
					echo "Connection failed: " . $e->getMessage();
				}
				
			?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
