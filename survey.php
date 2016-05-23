<?php session_start(); ?>
<!DOCTYPE html>  <!-- ADD OCCUPATION TO THE Survey -->
<html>
	<head>
		<meta charset="utf-8">
		<title>Survey</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="iat.js"></script>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" id="css1">
		<link rel="stylesheet" type="text/css" href="form.css" id="css2">
		<script>
		function inputOther(v) {
			if (v == "other") {
				document.getElementById('otherGender').style.display="inline";
			} else {
				document.getElementById('otherGender').style.display="none";
			}
			
		}

		$( "#button_submit" ).click(function() {
			alert( "Handler for .submit() called." );
		});
		</script>
	</head>
	<body>
		<div id="page">
		<div class="container">
		<h2>Survey</h2>
		<form role="form" id="survey" action="" method="post">
			<fieldset>
				<div class="form-group">
					Gender: 
					<select name="gender" class="form-control" onchange="inputOther(this.value)">
						<option selected disabled></option>
						<option value="male">Male</option>
						<option value="female">Female</option>
						<option value="unknown">Prefer not to disclose</option>
						<option value="other">Other </option>
					</select> 
					<input type="text" placeholder="Describe" name="otherGender" id="otherGender" style="display:none;" maxlength="25">
				</div>
				
				
				<div class="form-group">
				Age
					<select name="age" class="form-control">
						<option selected disabled></option>
						<option value="5">0-5</option>
						<option value="10">6-10</option>
						<option value="15">11-15</option>
						<option value="20">16-20</option>
						<option value="25">21-25</option>
						<option value="30">26-30</option>
						<option value="35">31-35</option>
						<option value="40">36-40</option>
						<option value="45">41-45</option>
						<option value="50">46-50</option>
						<option value="55">51-55</option>
						<option value="60">56-60</option>
						<option value="65">61-65</option>
						<option value="70">66-70</option>
						<option value="75">71-75</option>
						<option value="80">76-80</option>
						<option value="85">81-85</option>
						<option value="90">86-90</option>
						<option value="95">91-95</option>
						<option value="100">96-100</option>
						<option value="101">100+</option>
					</select>
				</div>
				<div class="form-group">
					Ethnicity
					<select name="ethnicity" class="form-control">
						<option selected disabled></option>
						<option value="AI or AN"> American Indian or Alaska Native</option>
						<option value="asian"> Asian </option>
						<option value="black"> Black or African American</option>
						<option value="other states"> Native Hawaiian or Other Pacific Islander</option>
						<option value="white"> White</option>
						<option value="hispanic or latino"> Hispanic or Latino</option>
						<option value="no answer">No Answer</option>
					</select>
				</div>
				<div class="form-group">
					How many IATs have you previously performed?
					<select name="numberIATs" class="form-control">
						<option selected disabled></option>
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3-5">3-5</option>
						<option value="6+">6+</option>
					</select>
				</div>
				<div class="form-group">
					What country have you spent most of your life in?
					<select name="countries" class="form-control">
						<option selected disabled></option>
						<option value="USA">United States</option>
						<option value="AFG">Afghanistan</option>
						<option value="ALA">Åland Islands</option>
						<option value="ALB">Albania</option>
						<option value="DZA">Algeria</option>
						<option value="ASM">American Samoa</option>
						<option value="AND">Andorra</option>
						<option value="AGO">Angola</option>
						<option value="AIA">Anguilla</option>
						<option value="ATA">Antarctica</option>
						<option value="ATG">Antigua and Barbuda</option>
						<option value="ARG">Argentina</option>
						<option value="ARM">Armenia</option>
						<option value="ABW">Aruba</option>
						<option value="AUS">Australia</option>
						<option value="AUT">Austria</option>
						<option value="AZE">Azerbaijan</option>
						<option value="BHS">Bahamas</option>
						<option value="BHR">Bahrain</option>
						<option value="BGD">Bangladesh</option>
						<option value="BRB">Barbados</option>
						<option value="BLR">Belarus</option>
						<option value="BEL">Belgium</option>
						<option value="BLZ">Belize</option>
						<option value="BEN">Benin</option>
						<option value="BMU">Bermuda</option>
						<option value="BTN">Bhutan</option>
						<option value="BOL">Bolivia, Plurinational State of</option>
						<option value="BES">Bonaire, Sint Eustatius and Saba</option>
						<option value="BIH">Bosnia and Herzegovina</option>
						<option value="BWA">Botswana</option>
						<option value="BVT">Bouvet Island</option>
						<option value="BRA">Brazil</option>
						<option value="IOT">British Indian Ocean Territory</option>
						<option value="BRN">Brunei Darussalam</option>
						<option value="BGR">Bulgaria</option>
						<option value="BFA">Burkina Faso</option>
						<option value="BDI">Burundi</option>
						<option value="KHM">Cambodia</option>
						<option value="CMR">Cameroon</option>
						<option value="CAN">Canada</option>
						<option value="CPV">Cape Verde</option>
						<option value="CYM">Cayman Islands</option>
						<option value="CAF">Central African Republic</option>
						<option value="TCD">Chad</option>
						<option value="CHL">Chile</option>
						<option value="CHN">China</option>
						<option value="CXR">Christmas Island</option>
						<option value="CCK">Cocos (Keeling) Islands</option>
						<option value="COL">Colombia</option>
						<option value="COM">Comoros</option>
						<option value="COG">Congo</option>
						<option value="COD">Congo, the Democratic Republic of the</option>
						<option value="COK">Cook Islands</option>
						<option value="CRI">Costa Rica</option>
						<option value="CIV">Côte d'Ivoire</option>
						<option value="HRV">Croatia</option>
						<option value="CUB">Cuba</option>
						<option value="CUW">Curaçao</option>
						<option value="CYP">Cyprus</option>
						<option value="CZE">Czech Republic</option>
						<option value="DNK">Denmark</option>
						<option value="DJI">Djibouti</option>
						<option value="DMA">Dominica</option>
						<option value="DOM">Dominican Republic</option>
						<option value="ECU">Ecuador</option>
						<option value="EGY">Egypt</option>
						<option value="SLV">El Salvador</option>
						<option value="GNQ">Equatorial Guinea</option>
						<option value="ERI">Eritrea</option>
						<option value="EST">Estonia</option>
						<option value="ETH">Ethiopia</option>
						<option value="FLK">Falkland Islands (Malvinas)</option>
						<option value="FRO">Faroe Islands</option>
						<option value="FJI">Fiji</option>
						<option value="FIN">Finland</option>
						<option value="FRA">France</option>
						<option value="GUF">French Guiana</option>
						<option value="PYF">French Polynesia</option>
						<option value="ATF">French Southern Territories</option>
						<option value="GAB">Gabon</option>
						<option value="GMB">Gambia</option>
						<option value="GEO">Georgia</option>
						<option value="DEU">Germany</option>
						<option value="GHA">Ghana</option>
						<option value="GIB">Gibraltar</option>
						<option value="GRC">Greece</option>
						<option value="GRL">Greenland</option>
						<option value="GRD">Grenada</option>
						<option value="GLP">Guadeloupe</option>
						<option value="GUM">Guam</option>
						<option value="GTM">Guatemala</option>
						<option value="GGY">Guernsey</option>
						<option value="GIN">Guinea</option>
						<option value="GNB">Guinea-Bissau</option>
						<option value="GUY">Guyana</option>
						<option value="HTI">Haiti</option>
						<option value="HMD">Heard Island and McDonald Islands</option>
						<option value="VAT">Holy See (Vatican City State)</option>
						<option value="HND">Honduras</option>
						<option value="HKG">Hong Kong</option>
						<option value="HUN">Hungary</option>
						<option value="ISL">Iceland</option>
						<option value="IND">India</option>
						<option value="IDN">Indonesia</option>
						<option value="IRN">Iran, Islamic Republic of</option>
						<option value="IRQ">Iraq</option>
						<option value="IRL">Ireland</option>
						<option value="IMN">Isle of Man</option>
						<option value="ISR">Israel</option>
						<option value="ITA">Italy</option>
						<option value="JAM">Jamaica</option>
						<option value="JPN">Japan</option>
						<option value="JEY">Jersey</option>
						<option value="JOR">Jordan</option>
						<option value="KAZ">Kazakhstan</option>
						<option value="KEN">Kenya</option>
						<option value="KIR">Kiribati</option>
						<option value="PRK">Korea, Democratic People's Republic of</option>
						<option value="KOR">Korea, Republic of</option>
						<option value="KWT">Kuwait</option>
						<option value="KGZ">Kyrgyzstan</option>
						<option value="LAO">Lao People's Democratic Republic</option>
						<option value="LVA">Latvia</option>
						<option value="LBN">Lebanon</option>
						<option value="LSO">Lesotho</option>
						<option value="LBR">Liberia</option>
						<option value="LBY">Libya</option>
						<option value="LIE">Liechtenstein</option>
						<option value="LTU">Lithuania</option>
						<option value="LUX">Luxembourg</option>
						<option value="MAC">Macao</option>
						<option value="MKD">Macedonia, the former Yugoslav Republic of</option>
						<option value="MDG">Madagascar</option>
						<option value="MWI">Malawi</option>
						<option value="MYS">Malaysia</option>
						<option value="MDV">Maldives</option>
						<option value="MLI">Mali</option>
						<option value="MLT">Malta</option>
						<option value="MHL">Marshall Islands</option>
						<option value="MTQ">Martinique</option>
						<option value="MRT">Mauritania</option>
						<option value="MUS">Mauritius</option>
						<option value="MYT">Mayotte</option>
						<option value="MEX">Mexico</option>
						<option value="FSM">Micronesia, Federated States of</option>
						<option value="MDA">Moldova, Republic of</option>
						<option value="MCO">Monaco</option>
						<option value="MNG">Mongolia</option>
						<option value="MNE">Montenegro</option>
						<option value="MSR">Montserrat</option>
						<option value="MAR">Morocco</option>
						<option value="MOZ">Mozambique</option>
						<option value="MMR">Myanmar</option>
						<option value="NAM">Namibia</option>
						<option value="NRU">Nauru</option>
						<option value="NPL">Nepal</option>
						<option value="NLD">Netherlands</option>
						<option value="NCL">New Caledonia</option>
						<option value="NZL">New Zealand</option>
						<option value="NIC">Nicaragua</option>
						<option value="NER">Niger</option>
						<option value="NGA">Nigeria</option>
						<option value="NIU">Niue</option>
						<option value="NFK">Norfolk Island</option>
						<option value="MNP">Northern Mariana Islands</option>
						<option value="NOR">Norway</option>
						<option value="OMN">Oman</option>
						<option value="PAK">Pakistan</option>
						<option value="PLW">Palau</option>
						<option value="PSE">Palestinian Territory, Occupied</option>
						<option value="PAN">Panama</option>
						<option value="PNG">Papua New Guinea</option>
						<option value="PRY">Paraguay</option>
						<option value="PER">Peru</option>
						<option value="PHL">Philippines</option>
						<option value="PCN">Pitcairn</option>
						<option value="POL">Poland</option>
						<option value="PRT">Portugal</option>
						<option value="PRI">Puerto Rico</option>
						<option value="QAT">Qatar</option>
						<option value="REU">Réunion</option>
						<option value="ROU">Romania</option>
						<option value="RUS">Russian Federation</option>
						<option value="RWA">Rwanda</option>
						<option value="BLM">Saint Barthélemy</option>
						<option value="SHN">Saint Helena, Ascension and Tristan da Cunha</option>
						<option value="KNA">Saint Kitts and Nevis</option>
						<option value="LCA">Saint Lucia</option>
						<option value="MAF">Saint Martin (French part)</option>
						<option value="SPM">Saint Pierre and Miquelon</option>
						<option value="VCT">Saint Vincent and the Grenadines</option>
						<option value="WSM">Samoa</option>
						<option value="SMR">San Marino</option>
						<option value="STP">Sao Tome and Principe</option>
						<option value="SAU">Saudi Arabia</option>
						<option value="SEN">Senegal</option>
						<option value="SRB">Serbia</option>
						<option value="SYC">Seychelles</option>
						<option value="SLE">Sierra Leone</option>
						<option value="SGP">Singapore</option>
						<option value="SXM">Sint Maarten (Dutch part)</option>
						<option value="SVK">Slovakia</option>
						<option value="SVN">Slovenia</option>
						<option value="SLB">Solomon Islands</option>
						<option value="SOM">Somalia</option>
						<option value="ZAF">South Africa</option>
						<option value="SGS">South Georgia and the South Sandwich Islands</option>
						<option value="SSD">South Sudan</option>
						<option value="ESP">Spain</option>
						<option value="LKA">Sri Lanka</option>
						<option value="SDN">Sudan</option>
						<option value="SUR">Suriname</option>
						<option value="SJM">Svalbard and Jan Mayen</option>
						<option value="SWZ">Swaziland</option>
						<option value="SWE">Sweden</option>
						<option value="CHE">Switzerland</option>
						<option value="SYR">Syrian Arab Republic</option>
						<option value="TWN">Taiwan, Province of China</option>
						<option value="TJK">Tajikistan</option>
						<option value="TZA">Tanzania, United Republic of</option>
						<option value="THA">Thailand</option>
						<option value="TLS">Timor-Leste</option>
						<option value="TGO">Togo</option>
						<option value="TKL">Tokelau</option>
						<option value="TON">Tonga</option>
						<option value="TTO">Trinidad and Tobago</option>
						<option value="TUN">Tunisia</option>
						<option value="TUR">Turkey</option>
						<option value="TKM">Turkmenistan</option>
						<option value="TCA">Turks and Caicos Islands</option>
						<option value="TUV">Tuvalu</option>
						<option value="UGA">Uganda</option>
						<option value="UKR">Ukraine</option>
						<option value="ARE">United Arab Emirates</option>
						<option value="GBR">United Kingdom</option>
						<option value="USA">United States</option>
						<option value="UMI">United States Minor Outlying Islands</option>
						<option value="URY">Uruguay</option>
						<option value="UZB">Uzbekistan</option>
						<option value="VUT">Vanuatu</option>
						<option value="VEN">Venezuela, Bolivarian Republic of</option>
						<option value="VNM">Viet Nam</option>
						<option value="VGB">Virgin Islands, British</option>
						<option value="VIR">Virgin Islands, U.S.</option>
						<option value="WLF">Wallis and Futuna</option>
						<option value="ESH">Western Sahara</option>
						<option value="YEM">Yemen</option>
						<option value="ZMB">Zambia</option>
						<option value="ZWE">Zimbabwe</option>
					</select>
				</div>
				
				<div class="form-group">
					Education:
					<select name="education" class="form-control">
						<option selected disabled></option>
						<option value="0">Elementary School</option>
						<option value="1">Junior High</option>
						<option value="2">Some High School</option>
						<option value="3">High School Graduate</option>
						<option value="4">Some College</option>
						<option value="5">Associate's Degreee</option>
						<option value="6">Bachelor's Degree</option>
						<option value="7">Some Graduate School</option>
						<option value="8">Master's Degree</option>
						<option value="9">M.B.A.</option>
						<option value="10">J.D.</option>
						<option value="11">M.D.</option>
						<option value="12">Ph.D.</option>
						<option value="13">MFA</option>
						<option value="14">Other Advanced degree</option>
					</select>
				</div>
				<div class="form-group">
					Major field of study or that of your highest degree:
					<select name="field" class="form-control">
						<option selected disabled></option>
						<option value="0">Biological sciences/life sciences</option>
						<option value="1">Business</option>
						<option value="2">Communications</option>
						<option value="3">Computer and Information Sciences</option>
						<option value="4">Education</option>
						<option value="5">Engineering, Mathematics, or Physical Sciences/Science Technologies</option>
						<option value="6">Health Professions or Related Sciences</option>
						<option value="7">Humanities/Liberal Arts</option>
						<option value="8">Law or Legal Studies</option>
						<option value="9">Psychology</option>
						<option value="10">Social Science or history</option>
						<option value="11">Visual Performing Arts</option>
						<option value="12">Other</option>
					</select>
				</div>
				<div class="form-group">
					Background level of Computer Science (1-Very Low... 5-Basic Knowledge... 10-Very High)<br>
					<label for="1">1<br>
						<input type="radio" class="radio-inline" id="1" name="background" value="1">
					</label>
					<label for="2">2<br>
						<input type="radio" class="radio-inline" id="2" name="background" value="2">
					</label>
					<label for="3">3<br>
						<input type="radio" class="radio-inline" id="3" name="background" value="3">
					</label>
					<label for="4">4<br>
						<input type="radio" class="radio-inline" id="4" name="background" value="4">
					</label>
					<label for="5">5<br>
						<input type="radio" class="radio-inline" id="5" name="background" value="5">
					</label>
					<label for="6">6<br>
						<input type="radio" class="radio-inline" id="6" name="background" value="6">
					</label>
					<label for="7">7<br>
						<input type="radio" class="radio-inline" id="7" name="background" value="7">
					</label>
					<label for="8">8<br>
						<input type="radio" class="radio-inline" id="8" name="background" value="8">
					</label>
					<label for="9">9<br>
						<input type="radio" class="radio-inline" id="9" name="background" value="9">
					</label>
					<label for="10">10<br>
						<input type="radio" class="radio-inline" id="10" name="background" value="10">
					</label>
				</div>
				
			</fieldset>
			<br>
			<br>
			<button type="submit" class="btn btn-block" id="button_submit">Submit</button>
		</form>
		
		</div>
		
	</div>
	<script>
		// this is the id of the form
		$("#survey").submit(function() {

		    var url = "ajax/survey.php"; // the script where you handle the form input.

		    $.ajax({
		           type: "POST",
		           url: url,
		           data: $("#survey").serialize(), // serializes the form's elements.
		           success: function(data) {
					    if (data.status == 'success') {
					        alert("Do not forget to copy your ID: " + data.msg);

					        window.location.href = "instructions.php";
					    }else if(data.status == 'error'){
					        //alert("Error on query!");
					        alert(data.msg);
					    }
					},
		         });

		    return false; // avoid to execute the actual submit of the form.
		});
	</script>
	</body>
</html>
