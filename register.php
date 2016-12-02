<!DOCTYPE html>
<html lang="en">
<head>

<!-- Dylan Doblar and Louie McConnell -->

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<title>Bellarmine Track & Field</title>

<!-- Bootstrap -->
<script src="./js/bootstrap.js"></script>
<script src="./js/jquery-1.11.3.min.js"></script>
<script src="./js/jquery.validate.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
.error {
    font-style: normal;
    font-size: 10px;
    padding: 3px;
    margin: 3px;
    background-color: #ffc;
    border: 1px solid #c00;
}
.seed {
}
span.seed > input {
    width: 37px;
    display: inline;
    height: 34px;
}
.masters,
.hs,
.ms,
.seed {
    display: none;
}
input {
    margin: 0px !important;
}
label {
    margin: 0px !important;
}
.form-group input[type="checkbox"] {
    display: none;
}
/* sets the width of the entire button */
.form-group input[type="checkbox"] + .btn-group {
    width: 320px/* 250px */;
}
/* sets the width of the white part of the button */
.form-group input[type="checkbox"] + .btn-group .btn-default{
    width: 150px;
}
.form-group input[type="checkbox"] + .btn-group > label span {
    width: 20px;
}
.form-group input[type="checkbox"] + .btn-group > label span:first-child {
    display: none;
}
.form-group input[type="checkbox"] + .btn-group > label span:last-child {
    display: inline-block;
}
.form-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
    display: inline-block;
}
.form-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
    display: none;
}
form > .form-group {
    text-align: center !important;
}
</style>

<script>
/* global $ */
$(document).ready(function() {
    
    
    
    
    var dealWithPadding = function() {
        var addNamePaddings = function() {
            $("#first-name-outer-div").css("padding-right", "15px");
            $("#last-name-outer-div").css("padding-left", "15px");
        };
    
        var removeNamePaddings = function() {
            $("#first-name-outer-div").css("padding-right", "0px");
            $("#last-name-outer-div").css("padding-left", "0px");
        };
    
        if ($(window).width() < 768) {
            removeNamePaddings();
        } else {
            addNamePaddings();
        }
    }
    
    dealWithPadding();

    
    
    $.validator.addMethod("numField", function(value, element) {
        return this.optional(element) || /^[0-9]+$/i.test(value);
    }, "Numeric values only.");
/*
	$.validator.addMethod("username", function(value, element) {
        return this.optional(element) || /^[a-z0-9\_]+$/i.test(value);
    }, "Username must contain only letters, numbers, or underscore.");
 */
    $("#feedbackForm").validate();
    
    // Toggle showing and hiding the specific seed mark fields for each event
    $("input:checkbox").change(function() {
        var show = $(this).is(":checked") ? "block" : "none";
        $(this).parent().find(".seed").css("display", show);
    });
    
    // manages change of gender and division on events listed. 
    // TODO: make it so they clear entries on change so people can't be dumb
    $("#gender, #division").change(function() {
        

                
        
        // if both gender and division are properly selected
        if (!($("#gender option:selected").prop("disabled") || $("#division option:selected").prop("disabled"))) {

            var division = $("#division option:selected").val();
            var gender = $("#gender option:selected").val();
            console.log("Division: " + division);
            console.log("Gender: " + gender);
            // gender 0 if male, 1 if female. 
            
            division = parseInt(division);
            var genderNum = parseInt(gender);

            var oppositeGenderClass = (genderNum == 0) ? ".male" : ".female";
            var genderClass = (genderNum == 0) ? ".female" : ".male";
            
            $('#feedbackSubmit').prop("disabled", false);
            switch (division) {
                case 0:
                    console.log("Case 0 Running");
                    console.log("Division: " + division);
                    // show stuff for Middle School
                    $(".ms, .hs, .masters").css("display", "none");
                    $(".ms").css("display", "block");
                    break;
                case 1:
                    // show stuff for High School
                    $(".ms, .hs, .masters").css("display", "none");
                    //$(".hs:not(" + oppositeGenderClass + ")").css("text-align", "center");
                    $(".hs").not(oppositeGenderClass).css("display", "block");
                    break;
                case 2:
                    // show stuff for Masters
                    $(".ms, .hs, .masters").css("display", "none");
                    $(".masters").not(oppositeGenderClass).css("display", "block");
                    break;
                default:
                    // set all the values to hidden. 
                    $("#defaultHidden input").css("display", "none");
            }

        }
    });

    $(window).resize(dealWithPadding);
});
</script>

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
                        <div class="text-center col-lg-12">
                            <form role="form" id="feedbackForm" class="text-center" action="dataSubmissionTest.php" method="post">
                                <div class="text-center col-sm-6" id="first-name-outer-div" style="padding-left: 0px">
                                    <div class="form-group">
                                        <input type="text" class="required form-control" id="first-name" name="first-name" placeholder="First Name">
                                        <span class="help-block" style="display: none;">Please enter your first name.</span>
                                    </div>
                                </div>

                                <div class="text-center col-sm-6" id="last-name-outer-div" style="padding-right: 0px">
                                    <div class="form-group">
                                        <input type="text" class="required form-control" id="last-name" name="last-name" placeholder="Last Name">
                                        <span class="help-block" style="display: none;">Please enter your last name.</span>
                                    </div>
                                </div>

                                <div class="text-center col-md-12" style="padding-right:0px; padding-left:0px">
                                    <div class="form-group">
                                        <input type="text" class="required form-control" id="email" name="email" placeholder="Email Address">
                                        <span class="help-block" style="display: none;">Please enter your email address.</span>
                                    </div>
                                </div>
                                <div class="text-center col-md-12" style="padding-right:0px; padding-left:0px">
                                <p class="help-block">
                                    If you are a current Bellarmine student, please use your Bellarmine email address.
                                </p>
                                </div>
                                <div class="form-group">
                                    <!--<label for="division">Division:</label>-->
                                    <select class="required form-control" name="division" id="division">
                                        <option disabled selected>Select Division</option>
                                        <option value="0">Middle School</option>
                                        <option value="1">High School</option>
                                        <option value="2">Masters</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <!--<label for="division">Division:</label>-->
                                    <select class="required form-control" name="gender" id="gender">
                                        <option disabled selected>Select Gender</option>
                                        <option value="1">Male</option>
                                        <option value="0">Female</option>
                                    </select>
                                </div>
                                <div class="form-group ms">
                                    <!--<label for="division">Division:</label>-->
                                    <select class="form-control" name="ms_grade" id="ms_grade">
                                        <option disabled selected>Select Grade</option>
                                        <option value="6">6th grade</option>
                                        <option value="7">7th grade</option>
                                        <option value="8">8th grade</option>
                                    </select>
                                </div>
                                <div class="form-group hs">
                                    <!--<label for="division">Division:</label>-->
                                    <select class="form-control" name="hs_grade" id="hs_grade">
                                        <option disabled selected>Select Grade</option>
                                        <option value="9">9th grade</option>
                                        <option value="10">10th grade</option>
                                        <option value="11">11th grade</option>
                                        <option value="12">12th grade</option>
                                    </select>
                                </div>
                                <div class="ms hs masters">
                                    <div class="[ form-group ]">
                                        <input type="checkbox" name="60m" id="60_Meter_Run" autocomplete="off" />
                                        <div class="[ btn-group ]">
                                            <label for="60_Meter_Run" class="[ btn btn-primary ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="60_Meter_Run" class="[ btn btn-default  ]">
                                                60 Meter Run
                                            </label>
                                            <span class="seed">
                                                <input style="display:none" name="event_min[]" type="text" id="seed_60m_min" maxlength="2" placeholder="Min" class="numField">
                                                <input name="event_sec[]" type="text" id="seed_60m_sec" maxlength="2" placeholder="Sec" class="numField">
                                                <input name="event_hun[]" type="text" id="seed_60m_hun" maxlength="2" placeholder="Hun" class="numField"><br>
                                                <p class="help-block">
                                    				Please enter a <strong>100m</strong> seed time.
                                    			</p>
                                            </span>
                                            
                                        </div>
                                    </div>
                                    <div class="[ form-group ]">
                                        <input type="checkbox" name="100m" id="100_Meter_Run" autocomplete="off" />
                                        <div class="[ btn-group ]">
                                            <label for="100_Meter_Run" class="[ btn btn-primary ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="100_Meter_Run" class="[ btn btn-default  ]">
                                                100 Meter Run
                                            </label>
                                            <span class="seed">
                                                <input style="display:none" name="event_min[]" type="text" id="seed_100m_min" maxlength="2" placeholder="Min" class="numField">
                                                <input name="event_sec[]" type="text" id="seed_100m_sec" maxlength="2" placeholder="Sec" class="numField">
                                                <input name="event_hun[]" type="text" id="seed_100m_hun" maxlength="2" placeholder="Hun" class="numField"><br>
                                                <p class="help-block">
                                    				Please enter a <strong>100m</strong> seed time.
                                    			</p>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="[ form-group ]">
                                        <input type="checkbox" name="150m" id="150_Meter_Run" autocomplete="off" />
                                        <div class="[ btn-group ]">
                                            <label for="150_Meter_Run" class="[ btn btn-primary ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="150_Meter_Run" class="[ btn btn-default  ]">
                                                150 Meter Run
                                            </label>
                                            <span class="seed">
                                                <input style="display:none" name="event_min[]" type="text" id="seed_150m_min" maxlength="2" placeholder="Min" class="numField">
                                                <input name="event_sec[]" type="text" id="seed_150m_sec" maxlength="2" placeholder="Sec" class="numField">
                                                <input name="event_hun[]" type="text" id="seed_150m_hun" maxlength="2" placeholder="Hun" class="numField"><br>
                                                <p class="help-block">
                                    				Please enter a <strong>200m</strong> seed time.
                                    			</p>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="[ form-group ]">
                                        <input type="checkbox" name="300m" id="300_Meter_Run" autocomplete="off" />
                                        <div class="[ btn-group ]">
                                            <label for="300_Meter_Run" class="[ btn btn-primary ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="300_Meter_Run" class="[ btn btn-default  ]">
                                                300 Meter Run
                                            </label>
                                            <span class="seed">
                                                <input name="event_min[]" type="text" id="seed_300m_min" maxlength="2" placeholder="Min" class="numField">
                                                <input name="event_sec[]" type="text" id="seed_300m_sec" maxlength="2" placeholder="Sec" class="numField">
                                                <input name="event_hun[]" type="text" id="seed_300m_hun" maxlength="2" placeholder="Hun" class="numField"><br>
                                                <p class="help-block">
                                    				Please enter a <strong>400m</strong> seed time.
                                    			</p>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="[ form-group ]">
                                        <input type="checkbox" name="mile" id="Mile_Run" autocomplete="off" />
                                        <div class="[ btn-group ]">
                                            <label for="Mile_Run" class="[ btn btn-primary ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="Mile_Run" class="[ btn btn-default  ]">
                                                Mile Run
                                            </label>
                                            <span class="seed">
                                                <input name="event_min[]" type="text" id="seed_mile_min" maxlength="2" placeholder="Min" class="numField">
                                                <input name="event_sec[]" type="text" id="seed_mile_sec" maxlength="2" placeholder="Sec" class="numField">
                                                <input name="event_hun[]" type="text" id="seed_mile_hun" maxlength="2" placeholder="Hun" class="numField"><br>
                                                <p class="help-block">
                                    				Please enter a <strong>mile</strong> seed time.
                                    			</p>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="[ form-group ] masters hs">
                                        <input type="checkbox" name="3200m" id="3200_Meter_Run" autocomplete="off" />
                                        <div class="[ btn-group ]">
                                            <label for="3200_Meter_Run" class="[ btn btn-primary ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="3200_Meter_Run" class="[ btn btn-default  ]">
                                                3200 Meter Run
                                            </label>
                                            <span class="seed">
                                                <input name="event_min[]" type="text" id="seed_3200m_min" maxlength="2" placeholder="Min" class="numField">
                                                <input name="event_sec[]" type="text" id="seed_3200m_sec" maxlength="2" placeholder="Sec" class="numField">
                                                <input name="event_hun[]" type="text" id="seed_3200m_hun" maxlength="2" placeholder="Hun" class="numField"><br>
                                                <p class="help-block">
                                    				Please enter a <strong>3200m</strong> seed time.
                                    			</p>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="[ form-group ] masters hs female">
                                        <input type="checkbox" name="100m_hurdles" id="100_Meter_Hurdles" autocomplete="off" />
                                        <div class="[ btn-group ]">
                                            <label for="100_Meter_Hurdles" class="[ btn btn-primary ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="100_Meter_Hurdles" class="[ btn btn-default  ]">
                                                100 Meter Hurdles
                                            </label>
                                            <span class="seed">
                                                <input style="display:none" name="event_min[]" type="text" id="seed_100mh_min" maxlength="2" placeholder="Min" class="numField">
                                                <input name="event_sec[]" type="text" id="seed_100mh_sec" maxlength="2" placeholder="Sec" class="numField">
                                                <input name="event_hun[]" type="text" id="seed_100mh_hun" maxlength="2" placeholder="Hun" class="numField"><br>
                                                <p class="help-block">
                                    				Please enter a <strong>100m hurdles</strong> seed time.
                                    			</p>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="[ form-group ] masters hs male">
                                        <input type="checkbox" name="110m_hurdles" id="110_Meter_Hurdles" autocomplete="off" />
                                        <div class="[ btn-group ]">
                                            <label for="110_Meter_Hurdles" class="[ btn btn-primary ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="110_Meter_Hurdles" class="[ btn btn-default  ]">
                                                110 Meter Hurdles
                                            </label>
                                            <span class="seed">
                                                <input style="display:none" name="event_min[]" type="text" id="seed_110mh_min" maxlength="2" placeholder="Min" class="numField">
                                                <input name="event_sec[]" type="text" id="seed_110mh_sec" maxlength="2" placeholder="Sec" class="numField">
                                                <input name="event_hun[]" type="text" id="seed_110mh_hun" maxlength="2" placeholder="Hun" class="numField"><br>
                                                <p class="help-block">
                                    				Please enter a <strong>110m hurdles</strong> seed time.
                                    			</p>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="[ form-group ]">
                                        <input type="checkbox" name="high_jump" id="High_Jump" autocomplete="off" />
                                        <div class="[ btn-group ]">
                                            <label for="High_Jump" class="[ btn btn-primary ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="High_Jump" class="[ btn btn-default  ]">
                                                High Jump
                                            </label>
                                            <span class="seed">
                                                <input name="event_ft[]" type="text" id="seed_hj_ft" maxlength="2" placeholder="Ft" class="numField">
                                                <input name="event_in[]" type="text" id="seed_hj_in" maxlength="2" placeholder="In" class="numField"><br>
                                                <p class="help-block">
                                    				Please enter a <strong>high jump</strong> seed mark.
                                    			</p>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="[ form-group ]">
                                        <input type="checkbox" name="long_jump" id="Long_Jump" autocomplete="off" />
                                        <div class="[ btn-group ]">
                                            <label for="Long_Jump" class="[ btn btn-primary ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="Long_Jump" class="[ btn btn-default  ]">
                                                Long Jump
                                            </label>
                                            <span class="seed">
                                                <input name="event_ft[]" type="text" id="seed_lj_ft" maxlength="2" placeholder="Ft" class="numField">
                                                <input name="event_in[]" type="text" id="seed_lj_in" maxlength="2" placeholder="In" class="numField"><br>
                                                <p class="help-block">
                                    				Please enter a <strong>long jump</strong> seed mark.
                                    			</p>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="[ form-group ] masters hs">
                                        <input type="checkbox" name="triple_jump" id="Triple_Jump" autocomplete="off" />
                                        <div class="[ btn-group ]">
                                            <label for="Triple_Jump" class="[ btn btn-primary ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="Triple_Jump" class="[ btn btn-default  ]">
                                                Triple Jump
                                            </label>
                                            <span class="seed">
                                                <input name="event_ft[]" type="text" id="seed_tj_ft" maxlength="2" placeholder="Ft" class="numField">
                                                <input name="event_in[]" type="text" id="seed_tj_in" maxlength="2" placeholder="In" class="numField"><br>
                                                <p class="help-block">
                                    				Please enter a <strong>triple jump</strong> seed mark.
                                    			</p>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="[ form-group ] masters hs">
                                        <input type="checkbox" name="pole_vault" id="Pole_Vault" autocomplete="off" />
                                        <div class="[ btn-group ]">
                                            <label for="Pole_Vault" class="[ btn btn-primary ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="Pole_Vault" class="[ btn btn-default  ]">
                                                Pole Vault
                                            </label>
                                            <span class="seed">
                                                <input name="event_ft[]" type="text" id="seed_pv_ft" maxlength="2" placeholder="Ft" class="numField">
                                                <input name="event_in[]" type="text" id="seed_pv_in" maxlength="2" placeholder="In" class="numField"><br>
                                                <p class="help-block">
                                    				Please enter a <strong>pole vault</strong> seed mark.
                                    			</p>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="[ form-group ] ms">
                                        <input type="checkbox" name="softball_toss" id="Softball_Toss" autocomplete="off" />
                                        <div class="[ btn-group ]">
                                            <label for="Softball_Toss" class="[ btn btn-primary ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="Softball_Toss" class="[ btn btn-default  ]">
                                                Softball Toss
                                            </label>
                                            <span class="seed">
                                                <input name="event_ft[]" type="text" id="seed_st_ft" maxlength="2" placeholder="Ft" class="numField">
                                                <input name="event_in[]" type="text" id="seed_st_in" maxlength="2" placeholder="In" class="numField"><br>
                                                <p class="help-block">
                                    				Please enter a <strong>softball toss</strong> seed mark.
                                    			</p>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="[ form-group ] masters hs">
                                        <input type="checkbox" name="shot_put" id="Shot_Put" autocomplete="off" />
                                        <div class="[ btn-group ]">
                                            <label for="Shot_Put" class="[ btn btn-primary ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="Shot_Put" class="[ btn btn-default  ]">
                                                Shot Put
                                            </label>
                                            <span class="seed">
                                                <input name="event_ft[]" type="text" id="seed_sp_ft" maxlength="2" placeholder="Ft" class="numField">
                                                <input name="event_in[]" type="text" id="seed_sp_in" maxlength="2" placeholder="In" class="numField"><br>
                                                <p class="help-block">
                                    				Please enter a <strong>shot put</strong> seed mark.
                                    			</p>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="text-center col-md-12" style="padding-right:0px; padding-left:0px">
                                <p class="help-block">
                                    Please print out and sign <a href="waiverTwo.pdf" target="_blank">this waiver</a> and bring it to the meet.
                                </p>
                                </div>
                                <button disabled type="submit" id="feedbackSubmit" class="btn btn-primary btn-lg" style=" margin-top: 10px;"> Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
